<?php 
// ✅ IMPORTANTE: dapat pinaka-una ito
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🌙 DARK MODE TOGGLE
if (isset($_GET['darkmode'])) {
    $_SESSION['darkmode'] = !($_SESSION['darkmode'] ?? false);
    header("Location: index.php?action=home");
    exit();
}

if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/../app/models/UserModel.php';
    $userModel = new UserModel();
    $userModel->updateLastActive($_SESSION['user_id']);
}

// Controllers
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PostController.php';
require_once __DIR__ . '/../app/controllers/CommentController.php';
require_once __DIR__ . '/../app/controllers/LikeController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';

// Get action
$action = $_GET['action'] ?? 'login';

// Routing
switch ($action) {

    case 'register':
        (new AuthController())->register();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'home':
        (new PostController())->home();
        break;

    case 'comment':
        (new CommentController())->add();
        break;

    case 'like':
        (new LikeController())->like();
        break;

    case 'profile':
        (new ProfileController())->profile();
        break;

    case 'search':
    (new ProfileController())->search();
    break;

    default:
        (new AuthController())->login();
        break;
}