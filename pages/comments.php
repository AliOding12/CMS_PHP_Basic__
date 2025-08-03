<?php
require_once '../includes/functions.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
$post_id = $_GET['post_id'] ?? 0;
$user = getCurrentUser();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    if (addComment($post_id, $user['id'], $content)) {
        $message = 'Comment added successfully!';
    } else {
        $message = 'Failed to add comment.';
    }
}
$comments = getComments($post_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Comments</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong> - <?php echo $comment['created_at']; ?></p>
            <p><?php echo htmlspecialchars($comment['content']); ?></p>
        </div>
    <?php endforeach; ?>
    <h3>Add Comment</h3>
    <form method="POST">
        <label>Comment: <textarea name="content" required></textarea></label><br>
        <button type="submit">Add Comment</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
    <?php include '../includes/footer.php'; ?>
</body>
</html>