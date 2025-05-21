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
      </tr>
    </thead>
    <tbody>
      <?php foreach ($scans as $scan): ?>
      <tr>
        <td><?= htmlspecialchars($scan['timestamp']) ?></td>
        <td><?= htmlspecialchars($scan['target']) ?></td>
        <td>
          <ul>
          <?php foreach ($scan['vulnerabilities'] as $vuln): ?>
            <li><?= htmlspecialchars($vuln['name']) ?> - <em><?= htmlspecialchars($vuln['severity']) ?></em></li>
          <?php endforeach; ?>
          </ul>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h3>Vulnerability Severity Distribution</h3>
  <canvas id="severityChart" width="400" height="200"></canvas>
</div>

<script>
function filterTable() {
  let targetFilter = document.getElementById('filterTarget').value.toLowerCase();
  let severityFilter = document.getElementById('filterSeverity').value;
  let dateFilter = document.getElementById('filterDate').value;
  let rows = document.querySelectorAll('#scansTable tbody tr');

  rows.forEach(row => {
    let target = row.cells[1].textContent.toLowerCase();
    let vulnerabilities = Array.from(row.querySelectorAll('td:nth-child(3) li')).map(li => li.textContent);
    let timestamp = row.cells[0].textContent.split(' ')[0]; // yyyy-mm-dd

    let targetMatch = target.includes(targetFilter);
    let severityMatch = !severityFilter || vulnerabilities.some(v => v.includes(severityFilter));
    let dateMatch = !dateFilter || timestamp === dateFilter;

    row.style.display = (targetMatch && severityMatch && dateMatch) ? '' : 'none';
  });
}

document.getElementById('filterTarget').addEventListener('input', filterTable);
document.getElementById('filterSeverity').addEventListener('change', filterTable);
document.getElementById('filterDate').addEventListener('change', filterTable);

document.getElementById('exportCSV').addEventListener('click', () => {
  let rows = Array.from(document.querySelectorAll('#scansTable tbody tr'))
    .filter(row => row.style.display !== 'none');

  let csvContent = "data:text/csv;charset=utf-8,";
  csvContent += "Timestamp,Target,Vulnerabilities\n";

  rows.forEach(row => {
    let timestamp = row.cells[0].textContent;
    let target = row.cells[1].textContent;
    let vulns = Array.from(row.querySelectorAll('td:nth-child(3) li'))
      .map(li => li.textContent.replace(/,/g, ';')).join('|');
    csvContent += `"${timestamp}","${target}","${vulns}"\n`;
  });

  let encodedUri = encodeURI(csvContent);
  let link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "scan_results.csv");
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
});

// Severity distribution chart
let severityCount = { High: 0, Medium: 0, Low: 0 };

let allVulns = <?php 
    $allVulns = [];
    foreach ($scans as $scan) {
        foreach ($scan['vulnerabilities'] as $vuln) {
            $allVulns[] = $vuln['severity'];
        }
    }
    echo json_encode($allVulns);
?>;

allVulns.forEach(sev => {
  if (severityCount[sev]) {
    severityCount[sev]++;
  }
});

const ctx = document.getElementById('severityChart').getContext('2d');
const chart = new Chart(ctx, {
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
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');

        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
    }
</script>

</body>
</html>
