<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple CMS</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <header>
        <h1>Simple CMS</h1>
        <?php if (isLoggedIn()): ?>
            <nav>
                <a href="../pages/dashboard.php">Dashboard</a> |
                <a href="../pages/add_friend.php">Add Friend</a> |
                <a href="../pages/post.php">Create Post</a> |
                <a href="../pages/logout.php">Logout</a>
            </nav>
        <?php else: ?>
            <nav>
                <a href="../pages/login.php">Login</a> |
                <a href="../pages/register.php">Register</a>
            </nav>
        <?php endif; ?>
    </header>