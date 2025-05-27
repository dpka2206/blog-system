<?php 

require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header('Location: login.php');
    exit;
}

$category = new Category($conn);
$message = '';
$succes = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = trim($_POST['name']) ?? '';
    $result = $category->add($name);
    $message = $result['message'];
    $success = $result['success'];
}

?>

<main>
    <h2>Add new category</h2>
    <?php if($message): ?>
        <p class = "<?php echo $success ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message);?>
        </p>
        <?php endif; ?>

        <form method="POST" class = "category-form">
            <label>
                category Name:
                <input type="text" name="name" required>
            </label>
            <button type="submit">Add Category</button>
        </form>
        <a href="admin_dashboard.php" class="back-link">Back to dashboard</a>
</main>

<?php require_once 'includes/footer.php'; ?>