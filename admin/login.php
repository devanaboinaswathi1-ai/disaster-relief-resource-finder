<?php
session_start();

// Simple hardcoded credentials (in production, use hashed passwords in DB)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123'); // Change this!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USER && $password === ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Disaster Relief</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>
                Username:
                <input type="text" name="username" required autofocus>
            </label>
            <label>
                Password:
                <input type="password" name="password" required>
            </label>
            <button type="submit">Login</button>
        </form>
        <p class="hint">Default: admin / admin123</p>
    </div>
</body>
</html>