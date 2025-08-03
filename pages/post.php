<?php
require_once '../includes/functions.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
$user = getCurrentUser();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $image = $_FILES['image'] ?? null;
    if (createPost($user['id'], $content, $image)) {
        $message = 'Post created successfully!';
    } else {
        $message = 'Failed to create post.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Create Post</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Content: <textarea name="content" required></textarea></label><br>
        <label>Image: <input type="file" name="image" accept="image/*"></label><br>
        <button type="submit">Post</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
    <?php include '../includes/footer.php'; ?>
</body>
</html>