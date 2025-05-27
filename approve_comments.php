<?php 
require_once 'includes/header.php';

if (!$user-> isLoggedIn() || !$user->isAdmin()){
    header('Location: header.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['comment_id'] )){
    $comment->approve($_POST['comment_id']);
    header('Location: approve_comments.php');
    exit;
}

$pending_comments = $comment->getPendingComments();
?>

<h2>Approve Comments</h2>
<?php if (empty($pending_comments)): ?>
    <p>No Comments to Approve.</p>
    <?php else: ?>
        <?php foreach( $pending_comments as $c): ?>
            <div class = "comment">
                <p>Post: <?php echo htmlspecialchars($c['title']); ?></p>
                <p>User: <?php echo htmlspecialchars($c['name']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($c['content'])); ?></p>
                <form method = "POST" >
                    <input type = "hidden" name = "comment_id" value = "<?php echo $c['id']; ?> " >
                    <button type="submit" > Approve</button>
                </form>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

<?php require_once 'includes/header.php'; ?>