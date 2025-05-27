<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php'; 
require_once 'classes/User.php';
require_once 'classes/Post.php';
require_once 'classes/Comment.php';
require_once 'classes/Category.php';

$user = new User($conn);
$post = new Post($conn);
$comment = new Comment($conn);
$category = new Category($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Blog</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<header>
    <h1>My Blog System</h1>
    <nav>
        <a href="index.php">Home</a> |
        <?php if ($user->isLoggedIn()): ?>
            <a href="dashboard.php">Dashboard</a> |
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a> |
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
