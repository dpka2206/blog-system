<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Database {
    private $host = 'localhost';
    private $dbname = 'blog_website';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}

// Usage
$db = new Database();
$conn = $db->connect(); 
?>

