<?php
require_once 'config.php';

class Comment{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function create($post_id, $user_id, $content){
        $stmt = $this->conn -> prepare("INSERT INTO comments (post_id,user_id,content) VALUES (? , ? ,?)");
        return $stmt->execute(array($post_id,$user_id,$content));
    }

    public function getByPostId($post_id){
        $stmt = $this->conn->prepare("SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id AND approved = 1 WHERE post_id = ?  ORDER BY created_at DESC");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingComments(){
        $stmt = $this->conn->prepare("SELECT comments.*, posts.title, users.name FROM comments JOIN posts ON comments.post_id = posts.id JOIN users ON comments.user_id = users.id WHERE approved = 0 ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Approve($id){
        $stmt = $this->conn->prepare("UPDATE comments SET approved=1 WHERE id=?");
        $stmt->execute(array($id));
    }

    public function getPendingCommentCount(){
        $stmt = $this->conn->prepare("SELECT count(*) FROM comments WHERE approved=0");
        $stmt->execute();
        return $stmt->fetchColumn();

    }
}
?>