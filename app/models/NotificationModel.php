<?php
require_once __DIR__ . '/../../config/database.php';

class NotificationModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
        $this->ensureTable();
    }

    private function ensureTable() {
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS notifications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                actor_id INT NOT NULL,
                type VARCHAR(50) NOT NULL,
                message VARCHAR(255) NOT NULL,
                link VARCHAR(255) DEFAULT 'index.php?action=home',
                is_read TINYINT(1) NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (actor_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");
    }

    public function createNotification($userId, $actorId, $type, $message, $link = 'index.php?action=home') {
        if ((int) $userId === (int) $actorId) {
            return false;
        }

        $stmt = $this->conn->prepare("
            INSERT INTO notifications (user_id, actor_id, type, message, link)
            VALUES (:user_id, :actor_id, :type, :message, :link)
        ");

        return $stmt->execute([
            ':user_id' => $userId,
            ':actor_id' => $actorId,
            ':type' => $type,
            ':message' => $message,
            ':link' => $link
        ]);
    }

    public function getRecentByUser($userId, $limit = 8) {
        $limit = max(1, (int) $limit);
        $stmt = $this->conn->prepare("
            SELECT notifications.*, users.username AS actor_username, users.full_name AS actor_name
            FROM notifications
            JOIN users ON notifications.actor_id = users.id
            WHERE notifications.user_id = :user_id
            ORDER BY notifications.created_at DESC
            LIMIT {$limit}
        ");
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUnreadByUser($userId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND is_read = 0");
        $stmt->execute([':user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    public function markAllAsRead($userId) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $userId]);
    }
}
