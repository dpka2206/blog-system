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
        echo '<p class ="error"> Invalid Email, password, or role. </p>';
    }
}

?>

<h2>Login</h2>
<form method = "POST">
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type = "password" name = "password" required></label><br>
    <label>User Type:
        <select name="role">
            <option value="user">User</option>
            <option value = "admin">Admin</option>
        </select>
    </label><br>
    <button type="submit">Login</button>
</form>

<?php require_once 'includes/footer.php'; ?>