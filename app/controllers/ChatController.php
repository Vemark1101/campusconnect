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

        if ($receiverId <= 0 || $receiverId === (int) $_SESSION['user_id']) {
            $users = $this->userModel->getAllUsersExcept($_SESSION['user_id']);
            if (!empty($users)) {
                header("Location: index.php?action=chat&receiver_id=" . (int) $users[0]['id']);
            } else {
                header("Location: index.php?action=home");
            }
            exit();
        }

        // Update online timestamp
        $this->chatModel->updateLastActive($_SESSION['user_id']);

        // Handle sending message
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = trim((string) ($_POST['content'] ?? ''));
            if ($content !== '') {
                $this->chatModel->sendMessage($_SESSION['user_id'], $receiverId, $content);
            }
        }

        // Get messages between users
        $messages = $this->chatModel->getMessages($_SESSION['user_id'], $receiverId);

        // Get all users except self
        $users = $this->userModel->getAllUsersExcept($_SESSION['user_id']);

        require_once __DIR__ . '/../views/chat.php';
    }

    // Fetch messages for AJAX
    public function fetchMessages($receiverId) {
        if (!isset($_SESSION['user_id']) || $receiverId <= 0) {
            header('Content-Type: application/json');
            exit(json_encode([]));
        }

        $this->chatModel->updateLastActive($_SESSION['user_id']);
        $messages = $this->chatModel->getMessages($_SESSION['user_id'], $receiverId);

        header('Content-Type: application/json');
        echo json_encode($messages);
        exit();
    }
}
