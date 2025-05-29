<?php
 
require_once 'includes/header.php';

if (!$user->isLoggedIn() || !$user->isAdmin()){
    header('Location: header.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])){
    $comment->approve($_POST['comment_id']);
    header('Location: approve_comments.php');
    exit;
}

$pending_comments = $comment->getPendingComments();
?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gradient-to-br from-white via-violet-100 to-violet-200 px-4 py-10">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold text-violet-700 mb-8 text-center">Approve Comments</h2>
        <?php if (empty($pending_comments)): ?>
            <div class="bg-white text-violet-700 rounded-xl shadow p-6 mb-6 text-center border border-violet-200">
                No Comments to Approve.
            </div>
        <?php else: ?>
            <div class="space-y-6">
            <?php foreach($pending_comments as $c): ?>
                <div class="comment bg-white rounded-xl shadow border border-violet-200 p-6">
                    <p class="mb-2 text-violet-700"><span class="font-semibold">Post:</span> <?php echo htmlspecialchars($c['title']); ?></p>
                    <p class="mb-2 text-violet-700"><span class="font-semibold">User:</span> <?php echo htmlspecialchars($c['name']); ?></p>
                    <p class="mb-4 text-violet-900 bg-violet-50 rounded p-3"><?php echo nl2br(htmlspecialchars($c['content'])); ?></p>
                    <form method="POST" class="flex justify-end">
                        <input type="hidden" name="comment_id" value="<?php echo $c['id']; ?>">
                        <button type="submit" class="bg-violet-700 hover:bg-violet-800 text-white font-semibold px-6 py-2 rounded-md shadow transition">Approve</button>
                    </form>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>