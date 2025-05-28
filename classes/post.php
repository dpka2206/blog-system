<?php
require_once 'config.php';

class Post{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function create($user_id, $title, $content, $image=null,$category_id = null){
        $stmt = $this->conn->prepare("INSERT INTO posts (user_id, title, content, image, category_id) VALUES (?,?,?,?,?)");
        return $stmt ->execute(array($user_id, $title, $content, $image, $category_id ));
    }

    public function getAll($page=1, $perpage = 5, $category_id = null){
        $offset = ($page -1) * $perpage;
        $sql = "SELECT posts.* , users.name , categories.name AS category_name FROM posts 
        JOIN users on posts.user_id = users.id
        LEFT JOIN categories ON posts.category_id = categories.id";

        if ($category_id){
            $sql .= " WHERE posts.category_id = :category_id";
        }

        $sql .= " ORDER BY posts.created_at DESC limit :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":limit", (int)$perpage , PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset , PDO::PARAM_INT);

        if ($category_id){
            $stmt->bindValue(":category_id", (int)$category_id ,PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT posts.*, users.name, categories.name AS category_name FROM posts 
                                      JOIN users ON posts.user_id = users.id LEFT JOIN categories on posts.category_id = categories.id WHERE posts.id =?");
                                      
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalPosts($category_id = null){
        $sql = "SELECT COUNT(*) FROM posts";
        if ($category_id){
            $sql .= "WHERE category_id = ?";
        }  
        $stmt = $this->conn->prepare($sql);
        if ($category_id){
            $stmt->execute(array($category_id));
        }else{
            $stmt->execute();
        }
        return $stmt->fetchColumn();

    }

    public function update($id, $title, $content, $image = null, $category_id = null){
        $sql = "UPDATE posts SET title = ?, content = ?, image = COALESCE(?, image), category_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array($title, $content, $image, $category_id, $id));

    }
}
?>