<?php
require_once '../includes/functions.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
$user = getCurrentUser();
$posts = getPosts($user['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
    <p><a href="add_friend.php">Add Friend</a> | <a href="post.php">Create Post</a></p>
    <h3>Your Feed</h3>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <p><strong><?php echo htmlspecialchars($post['username']); ?></strong> - <?php echo $post['created_at']; ?></p>
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <?php if ($post['image_path']): ?>
                <img src="../<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post image" width="200">
            <?php endif; ?>
            <p><a href="comments.php?post_id=<?php echo $post['id']; ?>">View/Add Comments</a></p>
        </div>
    <?php endforeach; ?>
    <?php include '../includes/footer.php'; ?>
</body>
</html>