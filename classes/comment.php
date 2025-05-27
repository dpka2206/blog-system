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
        $stmt = $this->conn->prepare("SELECT comments, * , users.name FROM comments JOIN users on comments.user_id WHERE post_id = ? AND approved=1 ORDER BY created_at DESC");
        $stmt->execute(array($post_id));
        $caregories =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $caregories;
    }

    public function getPendingComments(){
        $stmt = $this->conn->prepare("SELECT comments,*, posts.title,user.name FROM comments JOIN posts ON comments.post_id = post_id WHERE approved = 0 ORDER BY created_at DESC");
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