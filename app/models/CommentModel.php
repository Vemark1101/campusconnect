<?php
require_once __DIR__ . '/../../config/database.php';

class CommentModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function addComment($postId, $userId, $content) {
        $query = "INSERT INTO comments (post_id, user_id, content)
                  VALUES (:post_id, :user_id, :content)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':post_id' => $postId,
            ':user_id' => $userId,
            ':content' => $content
        ]);
    }

    public function getCommentById($commentId) {
        $query = "SELECT * FROM comments WHERE id = :comment_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':comment_id' => $commentId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateComment($commentId, $userId, $content) {
        $query = "UPDATE comments
                  SET content = :content
                  WHERE id = :comment_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':content' => $content,
            ':comment_id' => $commentId,
            ':user_id' => $userId
        ]);
    }

    public function deleteComment($commentId, $userId) {
        $query = "DELETE FROM comments WHERE id = :comment_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':comment_id' => $commentId,
            ':user_id' => $userId
        ]);
    }

    public function getCommentsByPost($postId) {
        $query = "SELECT comments.*, users.username, users.full_name
                  FROM comments
                  JOIN users ON comments.user_id = users.id
                  WHERE post_id = :post_id
                  ORDER BY comments.created_at ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([':post_id' => $postId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
