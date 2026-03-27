<?php
require_once __DIR__ . '/../models/UserModel.php';

class ProfileController {
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $success = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars($_POST['full_name']);
            $bio = htmlspecialchars($_POST['bio']);

            // ✅ UPDATE TEXT INFO
            $this->userModel->updateProfile($_SESSION['user_id'], $name, $bio);

            // ✅ HANDLE PROFILE PIC UPLOAD
          if (!empty($_FILES['profile_pic']['name'])) {

                $file = $_FILES['profile_pic'];

                // ✅ CHECK ERROR
                if ($file['error'] === 0) {

                    // ✅ VALIDATE FILE TYPE
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                    if (in_array($ext, $allowed)) {

                        // ✅ RENAME FILE (avoid duplicate)
                        $fileName = time() . "_" . uniqid() . "." . $ext;

                        $targetDir = __DIR__ . '/../../public/assets/uploads/';
                        $targetFile = $targetDir . $fileName;

                        // ✅ CREATE FOLDER IF NOT EXIST
                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0777, true);
                        }

                        // ✅ MOVE FILE
                        if (move_uploaded_file($file['tmp_name'], $targetFile)) {

                            // ✅ SAVE TO DATABASE
                            $this->userModel->updateProfilePic($_SESSION['user_id'], $fileName);

                            // ✅ UPDATE SESSION
                            $_SESSION['profile_pic'] = $fileName;

                        } else {
                            echo "❌ Failed to upload file";
                        }

                    } else {
                        echo "❌ Only JPG, PNG, GIF allowed";
                    }

                } else {
                    echo "❌ Upload error";
                }
            }

            $success = true;
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);

        require_once __DIR__ . '/../views/profile.php';
    }

    public function search() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $keyword = $_GET['keyword'] ?? '';
        $users = $this->userModel->search($keyword);

        require_once __DIR__ . '/../views/search.php';
    }
}