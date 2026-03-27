<?php
require_once __DIR__ . '/../../config/database.php';

class PostModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // CREATE POST
    public function create($user_id, $content) {
        $query = "INSERT INTO posts (user_id, content) 
                  VALUES (:user_id, :content)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':user_id' => $user_id,
            ':content' => $content
        ]);
    }

    // GET ALL POSTS (NEWSFEED)
    public function getAll() {
        $query = "SELECT posts.*, users.username 
                  FROM posts 
                  JOIN users ON posts.user_id = users.id 
                  ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}