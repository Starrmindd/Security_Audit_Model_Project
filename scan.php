<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scan Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'sidebar.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    echo "<div class='main'>";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['target'])) {
        $target = $_POST['target'];
        $vulnerabilities = [];

        if (strpos($target, '192.168') !== false) {
            $vulnerabilities[] = ['name' => 'Outdated SSH', 'severity' => 'High'];
        }

        if (strpos($target, 'http://') === 0) {
            $vulnerabilities[] = ['name' => 'Insecure Protocol (HTTP)', 'severity' => 'High'];
        }

        if (rand(0, 1)) {
            $vulnerabilities[] = ['name' => 'Missing CSP Header', 'severity' => 'Medium'];
        }

        require 'save_results.php';

        echo "<h2>Scan Results for <strong>$target</strong></h2>";
        if (empty($vulnerabilities)) {
            echo "<p>✅ No major vulnerabilities detected.</p>";
        } else {
            echo "<ul>";
            foreach ($vulnerabilities as $vuln) {
                echo "<li><strong>{$vuln['name']}</strong> - Severity: <span class='severity-{$vuln['severity']}'>{$vuln['severity']}</span></li>";
            }
            echo "</ul>";
        }

        echo "<a class='btn' href='dashboard.php'>📊 View Dashboard</a>";
    } else {
        echo "❌ Error: No target provided. <a href='index.php'>Go back</a>";
    }

    echo "</div>";
    ?>
</body>
</html>
