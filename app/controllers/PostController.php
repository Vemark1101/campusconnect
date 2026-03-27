<?php
require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../models/LikeModel.php';

class PostController {
    private $postModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->postModel = new PostModel();
    }

    public function home() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])) {
            $content = htmlspecialchars($_POST['content']);
            $this->postModel->create($_SESSION['user_id'], $content);

            header("Location: index.php?action=home");
            exit();
        }

        $posts = $this->postModel->getAll();

        $commentModel = new CommentModel();
        $likeModel = new LikeModel();

        foreach ($posts as &$post) {
            $post['comments'] = $commentModel->getCommentsByPost($post['id']);
            $post['likes'] = $likeModel->countLikes($post['id']);
            $post['user_liked'] = $likeModel->alreadyLiked($post['id'], $_SESSION['user_id']);
        }

        require_once __DIR__ . '/../views/home.php';
    }
}