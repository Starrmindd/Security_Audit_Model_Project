<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}



$user = $_SESSION['user'];

// For demo: hardcoded email, replace with real data fetch from DB
$email = "user@example.com";

// Process form submission
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here you would update user info in your database.
    // For now, just simulate success:
    $success = true;
}
?>

<!-- Include Bootstrap CSS -->
 <?php include 'sidebar.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div style="margin-left:250px; padding:20px;">
    <h2>Profile Settings</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">Profile updated successfully!</div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password <small>(leave blank to keep current)</small></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
