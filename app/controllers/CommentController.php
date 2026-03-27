<?php
require_once __DIR__ . '/../models/CommentModel.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->commentModel = new CommentModel();
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'], $_POST['content'])) {

            $post_id = $_POST['post_id'];
            $content = htmlspecialchars($_POST['content']);

            $this->commentModel->addComment($post_id, $_SESSION['user_id'], $content);

            header("Location: index.php?action=home");
            exit();
        }
    }
}