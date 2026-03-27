<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }

    private function setFlash($type, $message) {
        $_SESSION['flash_' . $type] = $message;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'], $_POST['full_name'])) {
            $username = trim($_POST['username']);
            $fullName = trim($_POST['full_name']);
            $password = (string) $_POST['password'];

            if ($fullName === '' || $username === '' || $password === '') {
                $this->setFlash('error', 'All registration fields are required.');
            } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
                $this->setFlash('error', 'Username must be 3-20 characters using letters, numbers, or underscore.');
            } elseif (strlen($password) < 6) {
                $this->setFlash('error', 'Password must be at least 6 characters.');
            } elseif ($this->userModel->findByUsername($username)) {
                $this->setFlash('error', 'Username is already taken.');
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if ($this->userModel->register($username, $hashedPassword, $fullName)) {
                    $this->setFlash('success', 'Registration successful. You can now log in.');
                    header("Location: index.php?action=login");
                    exit();
                }

                $this->setFlash('error', 'Registration failed. Please try again.');
            }
        }

        require_once __DIR__ . '/../views/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
            $username = trim($_POST['username']);
            $password = (string) $_POST['password'];

            if ($username === '' || $password === '') {
                $this->setFlash('error', 'Username and password are required.');
            } else {
                $user = $this->userModel->findByUsername($username);

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['profile_pic'] = $user['profile_pic'] ?: 'default-avatar.svg';
                    $this->setFlash('success', 'Welcome back, ' . $user['full_name'] . '.');
                    header("Location: index.php?action=home");
                    exit();
                }

                $this->setFlash('error', 'Invalid credentials.');
            }
        }

        require_once __DIR__ . '/../views/login.php';
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}
