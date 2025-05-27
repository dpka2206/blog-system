<?php

require_once 'includes/header.php';

if(!$user-> isLoggedIn()){
    header('Location: login.php');
    exit;
}?>


<h2> Welcome . <?php echo htmlspecialchars($_SESSION['name']);?>!</h2>
<p> <a href="create_post.php">Create a New Post</a></p>
<?php if($user-> isAdmin()) :?>
    <p> <a href = "approve_comment.php"> Approve Comments </a> </p>
<?php endif; ?>


<h3>Your Posts</h3>
<?php
$posts = $post-> getAll();
foreach($posts as $p):
    if ($p['user_id'] == $_SESSION['user_id'] || $user->isAdmin()):
        ?>
        <div class="post">
            <h4><a href="view_post.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['title']); ?></a></h4>
            <p><?php echo nl2br(htmlspecialchars(substr($p['content'],0,200))); ?></p>

        </div>
        <?php 
        endif;
        endforeach;
        ?>

        <?php require_once'includes/footer.php';?>