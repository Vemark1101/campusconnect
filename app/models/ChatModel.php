<?php
require_once __DIR__ . '/UserModel.php';

class ChatModel {
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=campusconnect", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Send message
    public function sendMessage($senderId, $receiverId, $content) {
        $stmt = $this->conn->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$senderId, $receiverId, $content]);
    }

    // Get chat between 2 users
    public function getMessages($user1, $user2) {
        $stmt = $this->conn->prepare("
            SELECT m.*, u.username AS sender_name
            FROM messages m
            JOIN users u ON m.sender_id = u.id
            WHERE (m.sender_id = ? AND m.receiver_id = ?)
               OR (m.sender_id = ? AND m.receiver_id = ?)
            ORDER BY m.created_at ASC
        ");
        $stmt->execute([$user1, $user2, $user2, $user1]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update last active
    public function updateLastActive($userId) {
        $stmt = $this->conn->prepare("UPDATE users SET last_active = NOW() WHERE id = ?");
        $stmt->execute([$userId]);
    }
}