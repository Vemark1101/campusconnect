<?php
$pageTitle = 'Register - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #d2f2d2 0%, #84d8c7 45%, #26667f 100%);
        }

        .auth-panel {
            width: min(460px, 100%);
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.16);
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
    const fullName = document.querySelector('input[name="full_name"]').value.trim();
    const username = document.querySelector('input[name="username"]').value.trim();
    const password = document.querySelector('input[name="password"]').value;

    if (!fullName || !username || !password) {
        event.preventDefault();
        alert('All registration fields are required.');
        return;
    }

    if (!/^[A-Za-z0-9_]{3,20}$/.test(username)) {
        event.preventDefault();
        alert('Username must be 3-20 characters using letters, numbers, or underscore.');
        return;
    }

    if (password.length < 6) {
        event.preventDefault();
        alert('Password must be at least 6 characters.');
    }
});
</script>
HTML;
require __DIR__ . '/partials/head.php';
?>
    <div class="auth-panel p-4 p-md-5">
        <div class="mb-4">
            <h1 class="h3 mb-2">Create your account</h1>
            <p class="mb-0 text-white-50">Join the campus timeline, publish posts, react, and connect with other users.</p>
        </div>

        <?php require __DIR__ . '/partials/flash.php'; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required maxlength="100">
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required minlength="3" maxlength="20" pattern="[A-Za-z0-9_]+">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button class="btn btn-light w-100 fw-semibold">Register</button>
        </form>

        <p class="text-center mt-4 mb-0">
            Already have an account?
            <a href="index.php?action=login" class="link-light fw-semibold">Log in</a>
        </p>
    </div>
<?php require __DIR__ . '/partials/footer.php'; ?>
