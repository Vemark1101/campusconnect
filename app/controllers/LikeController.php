<?php
require_once __DIR__ . '/../models/LikeModel.php';

class LikeController {
    private $likeModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->likeModel = new LikeModel();
    }

    public function like() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if (isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
            $user_id = $_SESSION['user_id'];

            if ($this->likeModel->alreadyLiked($post_id, $user_id)) {
                $this->likeModel->unlike($post_id, $user_id);
            } else {
                $this->likeModel->like($post_id, $user_id);
            }
        }

        header("Location: index.php?action=home");
        exit();
    }
}