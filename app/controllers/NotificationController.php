<?php
require_once __DIR__ . '/../models/NotificationModel.php';

class NotificationController {
    private $notificationModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->notificationModel = new NotificationModel();
    }

    public function markAllRead() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $this->notificationModel->markAllAsRead($_SESSION['user_id']);
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=home';
        header("Location: " . $redirect);
        exit();
    }
}
