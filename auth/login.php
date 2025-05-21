<?php
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = json_decode(file_get_contents('../users.json'), true);
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            header("Location: ../index.php");
            exit();
        }
    }

    $error = "Invalid credentials.";
}
?>

<link rel="stylesheet" href="../styles.css">
<div class="auth-container">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <p><?= $error ?></p>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>
