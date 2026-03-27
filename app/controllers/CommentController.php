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

    private function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    private function setFlash($type, $message) {
        $_SESSION['flash_' . $type] = $message;
    }

    public function add() {
        $this->requireAuth();

        $postId = (int) ($_POST['post_id'] ?? 0);
        $content = trim((string) ($_POST['content'] ?? ''));

        if ($postId <= 0 || $content === '') {
            $this->setFlash('error', 'Comment cannot be empty.');
        } else {
            $this->commentModel->addComment($postId, $_SESSION['user_id'], $content);
            $this->setFlash('success', 'Comment added.');
        }

        header("Location: index.php?action=home");
        exit();
    }

    public function update() {
        $this->requireAuth();

        $commentId = (int) ($_POST['comment_id'] ?? 0);
        $content = trim((string) ($_POST['content'] ?? ''));
        $comment = $this->commentModel->getCommentById($commentId);

        if (!$comment || (int) $comment['user_id'] !== (int) $_SESSION['user_id']) {
            $this->setFlash('error', 'You can only edit your own comments.');
        } elseif ($content === '') {
            $this->setFlash('error', 'Comment cannot be empty.');
            header("Location: index.php?action=home&edit_comment=" . $commentId);
            exit();
        } else {
            $this->commentModel->updateComment($commentId, $_SESSION['user_id'], $content);
            $this->setFlash('success', 'Comment updated.');
        }

        header("Location: index.php?action=home");
        exit();
    }

    public function delete() {
        $this->requireAuth();

        $commentId = (int) ($_POST['comment_id'] ?? 0);
        $comment = $this->commentModel->getCommentById($commentId);

        if (!$comment || (int) $comment['user_id'] !== (int) $_SESSION['user_id']) {
            $this->setFlash('error', 'You can only delete your own comments.');
        } else {
            $this->commentModel->deleteComment($commentId, $_SESSION['user_id']);
            $this->setFlash('success', 'Comment deleted.');
        }

        header("Location: index.php?action=home");
        exit();
    }
}
