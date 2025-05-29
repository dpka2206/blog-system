<?php

require_once 'includes/header.php';

if(!isset($_GET['id'])){
    header('Location: index.php');
    exit;
}

$post_id =(int) $_GET['id'];
$p = $post->getById($post_id);
if(!$p){
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user->isLoggedIn()){
    $content = $_POST['content'];
    if ($comment->create($post_id,$_SESSION['user_id'], $content)){
        echo '<p>Comment submitted for approval. </p>';
    }else{
        echo '<p class="error">Failed to submit comment. </p>';
    }

}
?>

<h2><?php echo htmlspecialchars($p['title']); ?></h2>
<?php if ($p['image']): ?>
    <img src = "<?php echo htmlspecialchars($p['image']); ?>" class="post-image">
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($p['content'])); ?></p>

    <h3>Comments</h3>
<?php
$comments = $comment->getByPostId($post_id);

foreach ($comments as $c):
?>
    <div class="comment">
        <p><?php echo htmlspecialchars($c['content']) ?></p>
        <p>Posted by <?php echo htmlspecialchars($c['name']); ?></p>
    </div>
<?php endforeach; ?>

<?php if ($user->isLoggedIn()): ?>
    <h3>Add Comments</h3>
    <form method="POST">
        <label>Comment: <textarea name="content" required></textarea></label><br>
        <button type="submit">Submit</button>
    </form>
    <?php else: ?>
        <p> <a href="login.php">Login</a> to add a comment. </p>
        <?php endif; ?>

<?php require_once 'includes/footer.php'; ?>