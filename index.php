<?php


require_once 'includes/header.php';

require_once 'classes/category.php';
$category = new Category($conn);

$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$perpage = 5;
$category_id = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? (int)$_GET['category_id'] : 0;

$posts = $post->getAll($page, $perpage, $category_id);
$total_posts = $post->getTotalPosts($category_id);
$total_pages = max(1, ceil($total_posts / $perpage));
$categories = $category->getAll();

if ($page > $total_pages) {
    $page = $total_pages;
    $posts = $post->getAll($page, $perpage, $category_id);
}
?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>


<div class="min-h-screen bg-gradient-to-br from-white via-violet-100 to-violet-200 px-4 py-8">
    <!-- Header Row: Latest Posts left, Filter right -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-transparent mb-8">
        <h2 class="text-2xl font-bold text-violet-700 tracking-wide order-1 md:order-none">Latest Posts</h2>
        <form method="GET" class="flex items-center gap-3 order-2 md:order-none md:ml-auto">
            <label for="category_id" class="text-violet-700 font-semibold whitespace-nowrap">Filter by category</label>
            <select name="category_id" id="category_id" class="bg-violet-50 text-violet-900 border border-violet-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-violet-400 transition">
                <option value="">All Categories</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $category_id == $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="ml-2 bg-violet-700 hover:bg-violet-800 text-white font-bold px-5 py-2 rounded-md shadow transition">Filter</button>
        </form>
    </div>

    <?php if (empty($posts)): ?>
        <div class="bg-white text-violet-700 rounded-xl shadow-md p-6 mb-6 text-center border border-violet-200">
            No posts found.
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center gap-8">
        <?php foreach($posts as $p): ?>
            <div class="post w-full max-w-md bg-white rounded-2xl shadow-lg border border-violet-200 overflow-hidden transition hover:shadow-2xl">
                <?php if (!empty($p['image'])): ?>
                    <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="Post Image" class="w-full h-80 object-cover border-b border-violet-200">
                <?php else: ?>
                    <div class="w-full h-80 bg-violet-100 flex items-center justify-center text-violet-400 text-3xl font-bold border-b border-violet-200">No Image</div>
                <?php endif; ?>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="text-xl font-semibold text-violet-700 mb-2"><?php echo htmlspecialchars($p['title']); ?></h3>
                    <p class="text-violet-900 mb-4 flex-1"><?php echo htmlspecialchars(mb_strimwidth($p['content'], 0, 160, '...')); ?></p>
                    <a href="view_post.php?id=<?php echo $p['id']; ?>" class="inline-block bg-violet-700 hover:bg-violet-800 text-white px-5 py-2 rounded-md font-medium transition mt-auto">Read More</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <div class="flex justify-center gap-2 mt-8">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&category_id=<?php echo $category_id; ?>"
                   class="px-4 py-2 rounded-md font-semibold <?php echo $i == $page ? 'bg-violet-700 text-white' : 'bg-violet-100 text-violet-700 hover:bg-violet-700 hover:text-white'; ?> transition">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>