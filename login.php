<?php

require_once "includes/header.php";

if ($user->isLoggedIn()) {
    header("Location: user_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($user->login($email, $password, $role)){
        header('Location: admin_dashboard.php');
        exit();
    }else{
        echo '<p class="text-violet-700 text-sm mb-4 text-center">Invalid Email, password, or role.</p>';
    }
}
?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Page Wrapper -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white via-violet-100 to-violet-200 text-violet-900 p-4">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm border border-violet-200">
        <h2 class="text-2xl font-semibold mb-6 text-center text-violet-700">Login</h2>
        <form method="POST" class="space-y-5">
            <label class="block">
                <span class="block mb-1 text-violet-700 font-medium">Email:</span>
                <input type="email" name="email" required class="w-full px-4 py-2 bg-violet-50 text-violet-900 rounded-md border border-violet-300 focus:outline-none focus:ring-2 focus:ring-violet-400">
            </label>

            <label class="block">
                <span class="block mb-1 text-violet-700 font-medium">Password:</span>
                <input type="password" name="password" required class="w-full px-4 py-2 bg-violet-50 text-violet-900 rounded-md border border-violet-300 focus:outline-none focus:ring-2 focus:ring-violet-400">
            </label>

            <label class="block">
                <span class="block mb-1 text-violet-700 font-medium">User Type:</span>
                <select name="role" class="w-full px-4 py-2 bg-violet-50 text-violet-900 rounded-md border border-violet-300 focus:outline-none focus:ring-2 focus:ring-violet-400">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </label>

            <button type="submit" class="w-full bg-violet-700 hover:bg-violet-800 text-white font-medium py-2 px-4 rounded-md transition">Login</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>