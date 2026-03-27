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

    // REGISTER
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'], $_POST['full_name'])) {

            $username = htmlspecialchars($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $full_name = htmlspecialchars($_POST['full_name']);

            if ($this->userModel->register($username, $password, $full_name)) {
                header("Location: index.php?action=login");
                exit();
            } else {
                echo "Registration failed";
            }
        }

        require_once __DIR__ . '/../views/register.php';
    }

    // LOGIN
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php?action=home");
                exit();
            } else {
                echo "Invalid credentials";
            }
        }

        require_once __DIR__ . '/../views/login.php';
    }

    // LOGOUT
    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}