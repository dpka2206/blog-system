<?php
require_once 'config.php';

class Category{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    
    public function getAll(){
        $stmt = $this->conn->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($name){
        if (empty(trim($name))){
            return ["success" => false, "message" => "category canr be empty"];
        }

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM categories WHERE name = :name");
        $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt -> fetchColumn() > 0){
            return ['success'=> false,'message'=> 'Category aldready exists'];
        }

        $stmt = $this->conn->prepare('INSERT INTO categories (name) VALUES (:name)');
        $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
        if ($stmt-> execute()){
            return ['success'=> true,'message'=> 'Category added successfully'];
        }
        return ['success'=> false,'message'=> 'Failed to fetch the category'];
    }
}
?>