<?php
require_once __DIR__ . '/../../config/database.php';

class PostModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($userId, $content, $image = null) {
        $query = "INSERT INTO posts (user_id, content, image)
                  VALUES (:user_id, :content, :image)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':user_id' => $userId,
            ':content' => $content,
            ':image' => $image
        ]);
    }

    public function getAll() {
        $query = "SELECT posts.*, users.username, users.full_name, users.profile_pic, users.last_active
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($postId) {
        $query = "SELECT posts.*, users.username, users.full_name, users.profile_pic
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  WHERE posts.id = :post_id
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':post_id' => $postId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($userId) {
        $query = "SELECT posts.*, users.username, users.full_name, users.profile_pic, users.last_active
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  WHERE posts.user_id = :user_id
                  ORDER BY posts.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePost($postId, $userId, $content, $image) {
        $query = "UPDATE posts
                  SET content = :content, image = :image
                  WHERE id = :post_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':content' => $content,
            ':image' => $image,
            ':post_id' => $postId,
            ':user_id' => $userId
        ]);
    }

    public function deletePost($postId, $userId) {
        $query = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':post_id' => $postId,
            ':user_id' => $userId
        ]);
    }
}
