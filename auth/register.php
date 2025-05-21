<?php
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = json_decode(file_get_contents('../users.json'), true);
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $error = "Username already exists!";
            break;
        }
    }

    if (!$error) {
        $users[] = ['username' => $username, 'password' => $password];
        file_put_contents('../users.json', json_encode($users, JSON_PRETTY_PRINT));
        $_SESSION['user'] = $username;
        header("Location: ../index.php");
        exit();
    }
}
?>

<link rel="stylesheet" href="../styles.css">
<div class="auth-container">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
        <p><?= $error ?></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>
