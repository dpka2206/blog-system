<?php

require_once 'includes/header.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header('Location: login.php');
    exit;
}

$post = new Post($conn);
$category = new Category($conn);

$total_pages = $post->getTotalPosts();
$total_users = $conn -> query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_comments = $conn -> query("SELECT COUNT(*) FROM comments WHERE approved=0")->fetchColumn();
$recent_posts = $post->getAll(1, perpage:5);

?>

<main>
    <h2>Admin Dashboard</h2>
    <div class="stats">
        <div class = "stat-card">
            <h1>Total posts</h1>
            <p><?php echo $total_posts; ?></p>
        </div>
        <div class="stat-card"> 
            <h3>Total Users</h3>
            <p><?php echo $total_users; ?></p>
        </div>
        <div class="stat-card">
            <h3>Pending Comments</h3>
            <p><?php echo $total_comments; ?></p>
        </div>
    </div>
    <div class="dashboard-actions">
        <a href="create_post.php" class="edit-link"> Create New Post</a>
        <a href="add_category.php" class="edit-link"> Add New Category</a>
        <a href="approve_comments.php" class="edit-link"> Manage Comments</a>
    </div>
    <h3>Recent Posts</h3>
    <?php if (empty($recent_posts)) : ?>
        <p>No posts found.</p>
    <?php else: ?>
        <?php foreach ($recent_posts as $p) : ?>
            <div class="post">
                <h4><a href="view_post.php?id=<?php echo $p['id'];?>"><?php echo htmlspecialchars($p['title']);?></a></h4>
                <p><?php echo nl2br(htmlspecialchars(substr($p['content'], 0,200))); ?></p>
                <p>Posted By <?php echo htmlspecialchars($p['name']); ?> on <?php echo $p['created_at']; ?></p>
                <?php if ($p['category_name']) : ?>
                    <p>Caategory: <?php echo htmlspecialchars($p['category_name']); ?></p>
                <?php endif; ?>
                <a href="edit_post.php?id=<?php echo $p['id']; ?> " class ="edit_link">Edit</a>

            </div>
            <?php endforeach; ?>
            <?php endif; ?>


</main>
<?php require_once 'includes/footer.php'; ?>