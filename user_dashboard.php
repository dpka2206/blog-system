<?php


require_once 'includes/header.php';

if(!$user->isLoggedIn()){
    header('Location: login.php');
    exit;
}
?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gradient-to-br from-white via-violet-100 to-violet-200 px-4 py-10">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold text-violet-700 mb-4 text-center">
            Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!
        </h2>
        <div class="flex flex-col md:flex-row md:justify-center gap-4 mb-8">
            <a href="create_post.php" class="bg-violet-700 hover:bg-violet-800 text-white font-semibold py-2 px-6 rounded-md shadow text-center transition">Create a New Post</a>
            <?php if($user->isAdmin()) :?>
                <a href="approve_comments.php" class="bg-violet-100 hover:bg-violet-200 text-violet-700 font-semibold py-2 px-6 rounded-md shadow text-center border border-violet-200 transition">Approve Comments</a>
            <?php endif; ?>
        </div>

        <h3 class="text-xl font-semibold text-violet-700 mb-4">Your Posts</h3>
        <div class="space-y-6">
        <?php
        $posts = $post->getAll() ?? [];
        $hasPosts = false;
        foreach($posts as $p):
            if ($p['user_id'] == $_SESSION['user_id'] || $user->isAdmin()):
                $hasPosts = true;
        ?>
            <div class="post bg-white rounded-xl shadow border border-violet-200 p-6">
                <h4 class="text-lg font-bold text-violet-700 mb-2">
                    <a href="view_post.php?id=<?php echo $p['id']; ?>" class="hover:underline">
                        <?php echo htmlspecialchars($p['title']); ?>
                    </a>
                </h4>
                <p class="text-violet-900 mb-2"><?php echo nl2br(htmlspecialchars(substr($p['content'],0,200))); ?></p>
            </div>
        <?php 
            endif;
        endforeach;
        if (!$hasPosts): ?>
            <div class="bg-violet-50 text-violet-700 rounded-xl shadow p-6 text-center border border-violet-100">
                You have not created any posts yet.
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>