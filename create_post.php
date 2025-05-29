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
                echo '<p class="error text-red-600 bg-red-100 border border-red-300 rounded p-2 my-2">Failed to upload image.</p>';
            }
        } else {
            echo '<p class="error text-red-600 bg-red-100 border border-red-300 rounded p-2 my-2">Invalid file type or size. Only jpg/jpeg/png up to 2MB supported.</p>';
        }
    }

    if ($post->create($_SESSION['user_id'], $title, $content, $image, $category_id)) {
        header("Location: user_dashboard.php");
        exit;
    } else {
        echo '<p class="error text-red-600 bg-red-100 border border-red-300 rounded p-2 my-2">Failed to create post.</p>';
    }
}
?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white via-violet-100 to-violet-300 py-10 px-2">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-8 border border-violet-200">
        <h2 class="text-3xl font-bold text-violet-700 mb-8 text-center">Create Post</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label class="block text-violet-700 font-semibold mb-2">Title:</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-violet-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-400 bg-violet-50 text-violet-900">
            </div>

            <div>
                <label class="block text-violet-700 font-semibold mb-2">Category:</label>
                <select name="category_id" class="w-full px-4 py-2 border border-violet-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-400 bg-violet-50 text-violet-900">
                    <option value="">Select a category (optional)</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-violet-700 font-semibold mb-2">Content:</label>
                <textarea name="content" required rows="6" class="w-full px-4 py-2 border border-violet-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-400 bg-violet-50 text-violet-900"></textarea>
            </div>

            <div>
                <label class="block text-violet-700 font-semibold mb-2">Image (jpg/jpeg/png up to 2MB):</label>
                <input type="file" name="image" accept="image/jpeg,image/png" class="block w-full text-violet-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-violet-700 hover:bg-violet-800 text-white font-bold py-2 px-8 rounded-lg shadow transition">Create Post</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>