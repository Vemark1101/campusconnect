<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PostModel.php';

class ProfileController {
    private $userModel;
    private $postModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
        $this->postModel = new PostModel();
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

    private function uploadProfileImage($fieldName) {
        if (empty($_FILES[$fieldName]['name'])) {
            return [true, null];
        }

        $file = $_FILES[$fieldName];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [false, 'Profile image upload failed.'];
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return [false, 'Profile image must be 2MB or smaller.'];
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
            return [false, 'Unable to save the uploaded profile image.'];
        }

        return [true, $fileName];
    }

    public function profile() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim((string) ($_POST['full_name'] ?? ''));
            $bio = trim((string) ($_POST['bio'] ?? ''));

            if ($name === '') {
                $this->setFlash('error', 'Full name is required.');
                header("Location: index.php?action=profile");
                exit();
            }

            $this->userModel->updateProfile($_SESSION['user_id'], $name, $bio);
            $_SESSION['full_name'] = $name;

            if (!empty($_FILES['profile_pic']['name'])) {
                [$ok, $imageOrError] = $this->uploadProfileImage('profile_pic');
                if (!$ok) {
                    $this->setFlash('error', $imageOrError);
                    header("Location: index.php?action=profile");
                    exit();
                }

                if ($imageOrError !== null) {
                    $this->userModel->updateProfilePic($_SESSION['user_id'], $imageOrError);
                    $_SESSION['profile_pic'] = $imageOrError;
                }
            }

            $this->setFlash('success', 'Profile updated successfully.');
            header("Location: index.php?action=profile");
            exit();
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $posts = $this->postModel->getByUserId($_SESSION['user_id']);

        require_once __DIR__ . '/../views/profile.php';
    }

    public function search() {
        $this->requireAuth();

        $keyword = trim((string) ($_GET['keyword'] ?? ''));
        $users = $keyword === '' ? [] : $this->userModel->search($keyword);

        require_once __DIR__ . '/../views/search.php';
    }
}
