<?php
require_once __DIR__ . '/../models/ChatModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class ChatController {
    private $chatModel;
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->chatModel = new ChatModel();
        $this->userModel = new UserModel();
    }

    // Chat page
    public function chat($receiverId) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        // Update online timestamp
        $this->chatModel->updateLastActive($_SESSION['user_id']);

        // Handle sending message
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['content'])) {
            $content = htmlspecialchars($_POST['content']);
            $this->chatModel->sendMessage($_SESSION['user_id'], $receiverId, $content);
        }

        // Get messages between users
        $messages = $this->chatModel->getMessages($_SESSION['user_id'], $receiverId);

        // Get all users except self
        $users = $this->userModel->getAllUsersExcept($_SESSION['user_id']);

        require_once __DIR__ . '/../views/chat.php';
    }

    // Fetch messages for AJAX
    public function fetchMessages($receiverId) {
        if (!isset($_SESSION['user_id'])) exit(json_encode([]));

        $this->chatModel->updateLastActive($_SESSION['user_id']);
        $messages = $this->chatModel->getMessages($_SESSION['user_id'], $receiverId);

        echo json_encode($messages);
        exit();
    }
}