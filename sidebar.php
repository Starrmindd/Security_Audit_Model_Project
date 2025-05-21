<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #0d6efd;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        transition: all 0.3s ease;
        overflow-y: auto;
        z-index: 1000;
    }

    .sidebar.closed {
        transform: translateX(-100%);
    }

    .sidebar .nav-link {
        color: white;
        padding: 12px 20px;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
        transition: margin-left 0.3s ease;
        width: 100%;
    }

    .main-content.expanded {
        margin-left: 0;
    }

    .toggle-btn {
        position: absolute;
        top: 10px;
        left: 260px;
        background: #0d6efd;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        z-index: 1001;
        transition: left 0.3s ease;
    }

    .sidebar.closed + .toggle-btn {
        left: 10px;
    }

    .user-info {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: bold;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="user-info">
        👤 <?= htmlspecialchars($user) ?>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">📊 Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">🔍 New Scan</a>
        </li>
        <li class="nav-item">
    <a class="nav-link" href="profile.php">⚙️ Profile</a>
</li>
        <li class="nav-item">
            <a class="nav-link" href="auth/logout.php">🚪 Logout</a>
        </li>
    </ul>
</div>

<!-- Toggle button -->
<button class="toggle-btn" onclick="toggleSidebar()" id="toggleBtn">☰</button>

<div class="main-content" id="mainContent">
    <!-- Your main page content starts here -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleBtn');

        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
    }
</script>
