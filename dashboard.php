<!--
high
http://example.com/login?user=admin'--&pass=123



-->

<?php
$scans = [];
if (file_exists('scans.json')) {
    $scans = json_decode(file_get_contents('scans.json'), true);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Scan History</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container mt-5">
  <h2>Scan History</h2>

  <div class="row mb-3">
    <div class="col">
      <input type="text" id="filterTarget" placeholder="Filter by target" class="form-control">
    </div>
    <div class="col">
      <select id="filterSeverity" class="form-select">
        <option value="">All Severities</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
      </select>
    </div>
    <div class="col">
      <input type="date" id="filterDate" class="form-control">
    </div>
  </div>

  <button id="exportCSV" class="btn btn-primary mb-3">Export as CSV</button>

  <table class="table table-striped" id="scansTable">
    <thead>
      <tr>
        <th>Timestamp</th>
        <th>Target</th>
        <th>Vulnerabilities</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($scans as $index => $scan): ?>
      <tr data-index="<?= $index ?>">
        <td><?= htmlspecialchars($scan['timestamp']) ?></td>
        <td><?= htmlspecialchars($scan['target']) ?></td>
        <td>
          <ul>
            <?php foreach ($scan['vulnerabilities'] as $vuln): ?>
              <li><?= htmlspecialchars($vuln['name']) ?> - <em><?= htmlspecialchars($vuln['severity']) ?></em></li>
            <?php endforeach; ?>
          </ul>
        </td>
        <td>
          <form method="POST" action="delete_scan.php" onsubmit="return confirm('Are you sure you want to delete this scan?');">
            <input type="hidden" name="index" value="<?= $index ?>">
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Pagination -->
  <nav>
    <ul class="pagination" id="pagination"></ul>
  </nav>

  <h3>Vulnerability Severity Distribution</h3>
  <canvas id="severityChart" width="400" height="200"></canvas>
</div>

<script>
// FILTER FUNCTIONALITY
function filterTable() {
  const targetFilter = document.getElementById('filterTarget').value.toLowerCase();
  const severityFilter = document.getElementById('filterSeverity').value;
  const dateFilter = document.getElementById('filterDate').value;
  const rows = document.querySelectorAll('#scansTable tbody tr');

  rows.forEach(row => {
    const target = row.cells[1].textContent.toLowerCase();
    const timestamp = row.cells[0].textContent.split(' ')[0];
    const vulns = Array.from(row.querySelectorAll('td:nth-child(3) li')).map(li => li.textContent);

    const matchTarget = target.includes(targetFilter);
    const matchSeverity = !severityFilter || vulns.some(v => v.includes(severityFilter));
    const matchDate = !dateFilter || timestamp === dateFilter;

    row.style.display = (matchTarget && matchSeverity && matchDate) ? '' : 'none';
  });

  paginateTable();
}

document.getElementById('filterTarget').addEventListener('input', filterTable);
document.getElementById('filterSeverity').addEventListener('change', filterTable);
document.getElementById('filterDate').addEventListener('change', filterTable);

// EXPORT CSV
document.getElementById('exportCSV').addEventListener('click', () => {
  const rows = Array.from(document.querySelectorAll('#scansTable tbody tr')).filter(r => r.style.display !== 'none');
  let csv = "Timestamp,Target,Vulnerabilities\n";

  rows.forEach(row => {
    const timestamp = row.cells[0].textContent;
    const target = row.cells[1].textContent;
    const vulns = Array.from(row.querySelectorAll('td:nth-child(3) li')).map(li => li.textContent.replace(/,/g, ';')).join('|');
    csv += `"${timestamp}","${target}","${vulns}"\n`;
  });

  const blob = new Blob([csv], { type: 'text/csv' });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = "scan_results.csv";
  link.click();
});

// PAGINATION
const rowsPerPage = 5;

function paginateTable() {
  const rows = Array.from(document.querySelectorAll('#scansTable tbody tr')).filter(r => r.style.display !== 'none');
  const pageCount = Math.ceil(rows.length / rowsPerPage);
  const pagination = document.getElementById('pagination');

  pagination.innerHTML = '';
  for (let i = 1; i <= pageCount; i++) {
    const li = document.createElement('li');
    li.classList.add('page-item');
    li.innerHTML = `<button class="page-link" onclick="showPage(${i})">${i}</button>`;
    pagination.appendChild(li);
  }

  showPage(1);
}

function showPage(page) {
  const rows = Array.from(document.querySelectorAll('#scansTable tbody tr')).filter(r => r.style.display !== 'none');
  rows.forEach((row, i) => {
    row.style.display = (i >= (page - 1) * rowsPerPage && i < page * rowsPerPage) ? '' : 'none';
  });
}

window.onload = paginateTable;
</script>

<script>
// CHART
const allVulns = <?php 
    $allVulns = [];
    foreach ($scans as $scan) {
        foreach ($scan['vulnerabilities'] as $vuln) {
            $allVulns[] = ucfirst(strtolower($vuln['severity']));
        }
    }
    echo json_encode($allVulns);
?>;

const severityCount = { High: 0, Medium: 0, Low: 0 };
allVulns.forEach(sev => {
  const severity = sev.charAt(0).toUpperCase() + sev.slice(1).toLowerCase();
  if (severityCount[severity] !== undefined) {
    severityCount[severity]++;
  }
});

new Chart(document.getElementById('severityChart'), {
  type: 'bar',
  data: {
    labels: Object.keys(severityCount),
    datasets: [{
      label: 'Number of Vulnerabilities',
      data: Object.values(severityCount),
      backgroundColor: ['#dc3545', '#ffc107', '#0d6efd']
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { precision: 0 }
      }
    }
  }
});
</script>

</body>
</html>
