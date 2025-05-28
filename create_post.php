<?php
require_once 'includes/header.php';

if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$categories = $category->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null;
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 2 * 1024 * 1024; 
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = uniqid() . '_' . $_FILES['image']['name'];
        $upload_dir = 'uploads/';
        $file_path = $upload_dir . $file_name;

        if (in_array($file_type, $allowed_types) && $file_size <= $max_size) {
            if (move_uploaded_file($file_tmp, $file_path)) {
                $image = $file_path;
            } else {
                echo '<p class="error">Failed to upload image.</p>';
            }
        } else {
            echo '<p class="error">Invalid file type or size. Only jpg/jpeg/png up to 2MB supported.</p>';
        }
    }

    if ($post->create($_SESSION['user_id'], $title, $content, $image, $category_id)) {
        header("Location: user_dashboard.php");
        exit;
    } else {
        echo '<p class="error">Failed to create post.</p>';
    }
}
?>

<h2>Create Post</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Title:
        <input type="text" name="title" required>
    </label><br><br>

    <label>Category:
        <select name="category_id">
            <option value="">Select a category (optional)</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php echo htmlspecialchars($cat['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Content:
        <textarea name="content" required></textarea>
    </label><br><br>

    <label>Image (jpg/jpeg/png up to 2MB):
        <input type="file" name="image" accept="image/jpeg,image/png">
    </label><br><br>

    <button type="submit">Create Post</button>
</form>

<?php require_once 'includes/footer.php'; ?>
