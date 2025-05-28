<?php

include_once 'config.php';

class User{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

//     public function register($name,$email , $password , $role = "user"){
//         if ($role == "admin"){
//         $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE role='admin'");
//         $stmt->execute();
//         if ($stmt -> fetchColumn()> 0){
//             return false;
//         }
//     } 
//     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
//     $stmt = $this->conn->prepare("INSERT INTO users (name, email,password, role) VALUES (?,?,?,?)");
//     $stmt->execute(array($name, $email, $hashed_password, $role));
// }
public function register($name, $email, $password, $role = "user") {
    // Check for duplicate email
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        return false; // Email already exists
    }

    // Allow only one admin
    if ($role === "admin") {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return false; // Admin already exists
        }
    }

    // Hash and insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password, $role]);
}

 

public function login($email, $password,$role){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

   $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->execute(array($email, $role));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        return true;
    }
    return false;
}

public function isLoggedIn(){
    return isset($_SESSION['user_id']);
}

public function isAdmin(){
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}
public function logout(){
    session_destroy();
}

public function getTotalUsers(){
    $stmt = $this->conn->prepare('SELECT COUNT(*) FROM users');
    $stmt->execute();
    return $stmt->fetchColumn();
}
}
?>
