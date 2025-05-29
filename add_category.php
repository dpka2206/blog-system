<?php


require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header('Location: login.php');
    exit;
}

$category = new Category($conn);
$message = '';
$success = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = trim($_POST['name']) ?? '';
    $result = $category->add($name);
    $message = $result['message'];
    $success = $result['success'];
}

?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white via-violet-100 to-violet-200 py-10 px-2">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-violet-200">
        <h2 class="text-2xl font-bold text-violet-700 mb-8 text-center">Add New Category</h2>
        <?php if($message): ?>
            <p class="<?php echo $success ? 'text-green-700 bg-green-50 border border-green-200' : 'text-red-700 bg-red-50 border border-red-200'; ?> rounded p-3 mb-6 text-center">
                <?php echo htmlspecialchars($message);?>
            </p>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-violet-700 font-semibold mb-2">Category Name:</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-violet-300 rounded focus:outline-none focus:ring-2 focus:ring-violet-400 bg-violet-50 text-violet-900">
            </div>
            <button type="submit" class="w-full bg-violet-700 hover:bg-violet-800 text-white font-bold py-2 px-4 rounded-md shadow transition">Add Category</button>
        </form>
        <a href="admin_dashboard.php" class="inline-block mt-6 text-violet-700 hover:text-violet-900 font-medium text-center w-full">← Back to dashboard</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>