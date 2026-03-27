<?php
require_once __DIR__ . '/../models/LikeModel.php';
require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/NotificationModel.php';

class LikeController {
    private $likeModel;
    private $postModel;
    private $notificationModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->likeModel = new LikeModel();
        $this->postModel = new PostModel();
        $this->notificationModel = new NotificationModel();
    }

    private function setFlash($type, $message) {
        $_SESSION['flash_' . $type] = $message;
    }

    public function like() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if (isset($_GET['post_id'])) {
            $post_id = (int) $_GET['post_id'];
            $user_id = $_SESSION['user_id'];

            if ($post_id <= 0) {
                $this->setFlash('error', 'Invalid post selected.');
            } elseif ($this->likeModel->alreadyLiked($post_id, $user_id)) {
                $this->likeModel->unlike($post_id, $user_id);
            } else {
                $this->likeModel->like($post_id, $user_id);
                $post = $this->postModel->getById($post_id);
                if ($post) {
                    $this->notificationModel->createNotification(
                        (int) $post['user_id'],
                        $user_id,
                        'like',
                        ($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Someone') . ' liked your post.',
                        'index.php?action=home'
                    );
                }
            }
        }

        header("Location: index.php?action=home");
        exit();
    }
}
