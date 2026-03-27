<?php
require_once __DIR__ . '/../../config/database.php';

class LikeModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function like($post_id, $user_id) {
        $query = "INSERT IGNORE INTO likes (post_id, user_id)
                  VALUES (:post_id, :user_id)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $user_id
        ]);
    }

    public function unlike($post_id, $user_id) {
        $query = "DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $user_id
        ]);
    }

    public function alreadyLiked($post_id, $user_id) {
        $query = "SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $user_id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function countLikes($post_id) {
        $query = "SELECT COUNT(*) as total FROM likes WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':post_id' => $post_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}