<?php
require_once __DIR__ . '/../config.php';
use Ramsey\Uuid\Uuid;

// User registration
function registerUser($username, $email, $password) {
    global $pdo;
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $email, $password_hash]);
}

// User login
function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user
function getCurrentUser() {
    global $pdo;
    if (!isLoggedIn()) return null;
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add friend
function addFriend($user_id, $friend_username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$friend_username]);
    $friend = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($friend && $friend['id'] != $user_id) {
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO friends (user_id, friend_id) VALUES (?, ?), (?, ?)");
        return $stmt->execute([$user_id, $friend['id'], $friend['id'], $user_id]);
    }
    return false;
}

// Create post
function createPost($user_id, $content, $image = null) {
    global $pdo;
    $image_path = null;
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $image_path = 'uploads/' . Uuid::uuid4()->toString() . '.' . $ext;
        move_uploaded_file($image['tmp_name'], __DIR__ . '/../' . $image_path);
    }
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
    return $stmt->execute([$user_id, $content, $image_path]);
}

// Add comment
function addComment($post_id, $user_id, $content) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    return $stmt->execute([$post_id, $user_id, $content]);
}

// Get posts (user and friends)
function getPosts($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT p.*, u.username 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.user_id = ? OR p.user_id IN (SELECT friend_id FROM friends WHERE user_id = ?)
        ORDER BY p.created_at DESC
    ");
    $stmt->execute([$user_id, $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get comments for a post
function getComments($post_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT c.*, u.username 
        FROM comments c 
        JOIN users u ON c.user_id = u.id 
        WHERE c.post_id = ? 
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$post_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>