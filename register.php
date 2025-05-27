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
        echo '<p class = "error">Registration failed. Email aldready used. </p>';
    }
}
?>

<h2>Register</h2>
<form method = "POST">
    <label>Name: <input type = "text" , name="name" required></label><br>
    <label>Email: <input type = "email", name = "email" required></label><br>
    <label>Password: <input type = "password" name="password"></label><br>
    <label>User Type:
        <select name = "role"> 
            <option value = "user" >User</option>
            <option value = "admin">Admin</option>
        </select>
        
    </label><br>
    <button type = "submit">Register</button>
</form>

<?php require_once 'includes/footer.php';?>