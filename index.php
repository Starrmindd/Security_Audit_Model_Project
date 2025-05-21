<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Security Audit Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main p-4">
    <h1>Security Audit Dashboard</h1>
    <form method="POST" action="scan.php" class="scan-form">
        <input type="text" name="target" class="form-control mb-3" placeholder="Enter IP or domain" required>
        <button type="submit" class="btn btn-primary">Run Security Audit</button>
    </form>
</div>

</body>
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

</html>
