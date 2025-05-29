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
    <link rel="stylesheet" href="css/style.css">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="bg-white/90 border-b border-violet-200 shadow-sm mb-8">
    <div class="max-w-5xl mx-auto px-4 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-violet-700 tracking-wide text-center md:text-left">My Blog System</h1>
        
        <nav class="flex flex-wrap items-center justify-center gap-3">
            <a href="index.php" class="text-violet-700 hover:text-violet-900 font-medium px-3 py-1 rounded transition">Home</a>
            
            <?php if ($user->isLoggedIn()): ?>
                <a href="create_post.php" class="text-violet-700 hover:text-violet-900 font-medium px-3 py-1 rounded transition">Create Post</a>
                
                <?php if ($_SESSION['is_admin'] ?? false): ?>
                    <a href="admin_dashboard.php" class="text-violet-700 hover:text-violet-900 font-medium px-3 py-1 rounded transition">Admin Dashboard</a>
                    <a href="approve_comment.php" class="text-violet-700 hover:text-violet-900 font-medium px-3 py-1 rounded transition">Approve Comments</a>
                <?php endif; ?>
                
                <a href="logout.php" class="bg-violet-700 hover:bg-violet-800 text-white font-semibold px-4 py-1 rounded transition">Logout</a>
            
            <?php else: ?>
                <a href="login.php" class="bg-violet-700 hover:bg-violet-800 text-white font-semibold px-4 py-1 rounded transition">Login</a>
                <a href="register.php" class="bg-violet-100 hover:bg-violet-200 text-violet-700 font-semibold px-4 py-1 rounded border border-violet-200 transition">Register</a>
            <?php endif; ?>
        </nav>

        <div class="flex justify-center md:justify-end gap-4">
            <a href="#" aria-label="Twitter" class="text-violet-700 hover:text-violet-900"><i class="fab fa-twitter text-xl"></i></a>
            <a href="#" aria-label="Facebook" class="text-violet-700 hover:text-violet-900"><i class="fab fa-facebook text-xl"></i></a>
            <a href="#" aria-label="Instagram" class="text-violet-700 hover:text-violet-900"><i class="fab fa-instagram text-xl"></i></a>
        </div>
    </div>
</header>
