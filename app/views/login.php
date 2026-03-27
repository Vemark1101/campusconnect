<?php
$pageTitle = 'Login - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top, #82cfff 0%, #2f6c8f 45%, #17324d 100%);
        }

        .auth-panel {
            width: min(420px, 100%);
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(18px);
            color: #fff;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        }
    </style>
HTML;
$bodyClass = 'd-flex justify-content-center align-items-center p-3';
$extraScripts = <<<HTML
<script>
document.querySelector('form')?.addEventListener('submit', (event) => {
    const username = document.querySelector('input[name="username"]').value.trim();
    const password = document.querySelector('input[name="password"]').value;
    if (!username || !password) {
        event.preventDefault();
        alert('Username and password are required.');
    }
});
</script>
HTML;
require __DIR__ . '/partials/head.php';
?>
    <div class="auth-panel p-4 p-md-5">
        <div class="mb-4">
            <h1 class="h3 mb-2">CampusConnect</h1>
            <p class="mb-0 text-white-50">Sign in to post updates, message classmates, and manage your profile.</p>
        </div>

        <?php require __DIR__ . '/partials/flash.php'; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required maxlength="50">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button class="btn btn-light w-100 fw-semibold">Login</button>
        </form>

        <p class="text-center mt-4 mb-0">
            No account yet?
            <a href="index.php?action=register" class="link-light fw-semibold">Register here</a>
        </p>
    </div>
<?php require __DIR__ . '/partials/footer.php'; ?>
