<?php
require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../models/LikeModel.php';
require_once __DIR__ . '/../models/NotificationModel.php';

class PostController {
    private $postModel;
    private $commentModel;
    private $likeModel;
    private $notificationModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
        $this->likeModel = new LikeModel();
        $this->notificationModel = new NotificationModel();
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

    private function sanitizeText($value) {
        return trim((string) $value);
    }

    private function loadNotifications() {
        return [
            $this->notificationModel->getRecentByUser($_SESSION['user_id']),
            $this->notificationModel->countUnreadByUser($_SESSION['user_id'])
        ];
    }

    private function handlePostImageUpload($fieldName) {
        if (empty($_FILES[$fieldName]['name'])) {
            return [true, null];
        }

        $file = $_FILES[$fieldName];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [false, 'Post image upload failed.'];
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return [false, 'Post image must be 2MB or smaller.'];
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            return [false, 'Only JPG, JPEG, PNG, GIF, and WEBP images are allowed.'];
        }

        $targetDir = __DIR__ . '/../../public/assets/uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetFile = $targetDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            return [false, 'Unable to save the uploaded post image.'];
        }

        return [true, $fileName];
    }

    private function enrichPosts(array $posts) {
        foreach ($posts as &$post) {
            $post['comments'] = $this->commentModel->getCommentsByPost($post['id']);
            $post['likes'] = $this->likeModel->countLikes($post['id']);
            $post['user_liked'] = $this->likeModel->alreadyLiked($post['id'], $_SESSION['user_id']);
        }

        return $posts;
    }

    public function home() {
        $this->requireAuth();

        $posts = $this->enrichPosts($this->postModel->getAll());
        $editingPostId = isset($_GET['edit_post']) ? (int) $_GET['edit_post'] : 0;
        $editingCommentId = isset($_GET['edit_comment']) ? (int) $_GET['edit_comment'] : 0;
        [$notifications, $unreadCount] = $this->loadNotifications();

        require_once __DIR__ . '/../views/home.php';
    }

    public function create() {
        $this->requireAuth();

        $content = $this->sanitizeText($_POST['content'] ?? '');
        [$ok, $imageOrError] = $this->handlePostImageUpload('post_image');

        if (!$ok) {
            $this->setFlash('error', $imageOrError);
        } elseif (mb_strlen($content) > 1000) {
            $this->setFlash('error', 'Post content must be 1000 characters or fewer.');
        } elseif ($content === '' && $imageOrError === null) {
            $this->setFlash('error', 'Post must contain text or an image.');
        } else {
            $this->postModel->create($_SESSION['user_id'], $content, $imageOrError);
            $this->setFlash('success', 'Post published successfully.');
        }

        header("Location: index.php?action=home");
        exit();
    }

    public function update() {
        $this->requireAuth();

        $postId = (int) ($_POST['post_id'] ?? 0);
        $existingPost = $this->postModel->getById($postId);

        if (!$existingPost || (int) $existingPost['user_id'] !== (int) $_SESSION['user_id']) {
            $this->setFlash('error', 'You can only edit your own posts.');
            header("Location: index.php?action=home");
            exit();
        }

        $content = $this->sanitizeText($_POST['content'] ?? '');
        $image = $existingPost['image'];

        if (!empty($_POST['remove_image'])) {
            $image = null;
        }

        if (!empty($_FILES['post_image']['name'])) {
            [$ok, $imageOrError] = $this->handlePostImageUpload('post_image');
            if (!$ok) {
                $this->setFlash('error', $imageOrError);
                header("Location: index.php?action=home&edit_post=" . $postId);
                exit();
            }
            $image = $imageOrError;
        }

        if ($content === '' && $image === null) {
            $this->setFlash('error', 'Post must contain text or an image.');
            header("Location: index.php?action=home&edit_post=" . $postId);
            exit();
        }

        if (mb_strlen($content) > 1000) {
            $this->setFlash('error', 'Post content must be 1000 characters or fewer.');
            header("Location: index.php?action=home&edit_post=" . $postId);
            exit();
        }

        $this->postModel->updatePost($postId, $_SESSION['user_id'], $content, $image);
        $this->setFlash('success', 'Post updated successfully.');
        header("Location: index.php?action=home");
        exit();
    }

    public function delete() {
        $this->requireAuth();

        $postId = (int) ($_POST['post_id'] ?? 0);
        $existingPost = $this->postModel->getById($postId);

        if (!$existingPost || (int) $existingPost['user_id'] !== (int) $_SESSION['user_id']) {
            $this->setFlash('error', 'You can only delete your own posts.');
        } else {
            $this->postModel->deletePost($postId, $_SESSION['user_id']);
            $this->setFlash('success', 'Post deleted.');
        }

        header("Location: index.php?action=home");
        exit();
    }
}
