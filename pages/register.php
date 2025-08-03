<?php
require_once '../includes/functions.php';
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (registerUser($username, $email, $password)) {
        header('Location: login.php');
        exit;
    } else {
        $error = 'Registration failed. Username or email already exists.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Register</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Register</button>
    </form>
    <p><a href="login.php">Login</a></p>
    <?php include '../includes/footer.php'; ?>
</body>
</html>