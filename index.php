<?php

require_once 'includes/header.php';

require_once 'classes/category.php';
$category = new Category($conn);


$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$perpage = 5;
$category_id = isset($_GET['category_id'])&& $_GET['category_id'] !== ''? (int)$_GET['category_id'] :0;

$posts = $post->getAll($page,$perpage,$category_id);
$total_posts = $posts->getTotalPosts($category_id);
$total_pages = max( 1,ceil($total_posts/$perpage));
$categories = $category -> getAll();

if ($page > $total_pages){
    $page = $total_pages;
    $posts = $post -> getAll($page,$perpage,$category_id);
}?>

<div class="filter-heading-row">
    <form method="GET" class ="filter-form">
        <label for = "category_id">Filter by category</label>
        <select name = "category_id" id = "category_id">
            <option value = "">All Categories</option> 
        <?php foreach($categories as $cat): ?>
            <option value = "<?php echo $cat['id']; ?>" <?php echo $category_id == $cat['id']? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['name']); ?>
            </option>
        <?php endforeach; ?>
        </select>
        <button type ="submit">Filter</button>
    </form>
    <h2 class="latest-post-headings">Latest Posts</h2>
</div>

