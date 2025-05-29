<?php

require_once "includes/header.php";

if ($user->isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"]; 

    if ($user -> register($name, $email, $password, $role)){
        header("Location: login.php");
        exit();
    }else{
        echo '<p class="text-red-700 bg-red-50 border border-red-200 rounded p-2 my-2 text-center">Registration failed. Email already used.</p>';
    }
}
?>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white via-violet-100 to-violet-200 text-violet-900 p-4">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm border border-violet-200">
        <h2 class="text-2xl font-semibold mb-6 text-center text-violet-700">Register</h2>
        <form method="POST" class="space-y-5">
            <label class="block">
                <span class="block mb-1 text-violet-700 font-medium">Name:</span>
                <input type="text" name="name" required class="w-full px-4 py-2 bg-violet-50 text-violet-900 rounded-md border border-violet-300 focus:outline-none focus:ring-2 focus:ring-violet-400">
            </label>
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
            <button type="submit" class="w-full bg-violet-700 hover:bg-violet-800 text-white font-medium py-2 px-4 rounded-md transition">Register</button>
        </form>
        <div class="mt-6 text-center">
            <a href="login.php" class="text-violet-700 hover:text-violet-900 font-medium">Already have an account? Login</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>