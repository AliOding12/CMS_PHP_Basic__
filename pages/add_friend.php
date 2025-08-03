<?php
require_once '../includes/functions.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
$user = getCurrentUser();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $friend_username = $_POST['friend_username'] ?? '';
    if (addFriend($user['id'], $friend_username)) {
        $message = 'Friend added successfully!';
    } else {
        $message = 'Failed to add friend. User not found or already added.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Friend</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Add Friend</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Friend's Username: <input type="text" name="friend_username" required></label><br>
        <button type="submit">Add Friend</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
    <?php include '../includes/footer.php'; ?>
</body>
</html>