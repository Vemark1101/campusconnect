<?php
$pageTitle = 'Register - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(255, 204, 112, 0.65), transparent 28%),
                radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.2), transparent 26%),
                linear-gradient(135deg, #0f766e 0%, #1c6d86 48%, #1b3658 100%);
        }

        .auth-wrap {
            max-width: 1080px;
        }

        .auth-panel {
            border-radius: 34px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(18px);
            color: #fff;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .hero-copy {
            color: #eff9ff;
        }

        .hero-badge {
            display: inline-flex;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #fff3d8;
            font-size: 0.85rem;
        }

        .auth-panel .form-control {
            background: rgba(255, 255, 255, 0.94);
            min-height: 56px;
        }

        .check-list {
            display: grid;
            gap: 0.9rem;
            margin-top: 1.5rem;
        }

        .check-item {
            display: flex;
            gap: 0.8rem;
            align-items: flex-start;
            padding: 0.95rem 1rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
    </style>
HTML;
$bodyClass = 'd-flex align-items-center p-3 p-md-4';
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
<div class="container auth-wrap">
    <div class="row g-4 align-items-center">
        <div class="col-lg-6 hero-copy">
            <span class="hero-badge mb-3">Join the student network</span>
            <h1 class="display-4 fw-bold mb-3 page-heading">Create your space, post your ideas, meet your people.</h1>
            <p class="fs-5 text-white-50 mb-4">CampusConnect gives your class, organization, or campus community one place to post updates, react, and connect in real time.</p>
            <div class="d-flex flex-wrap gap-2">
                <span class="soft-pill"><i class="bi bi-person-badge"></i> Custom profile</span>
                <span class="soft-pill"><i class="bi bi-megaphone"></i> Newsfeed posting</span>
                <span class="soft-pill"><i class="bi bi-heart"></i> Reactions & comments</span>
            </div>
            <div class="check-list">
                <div class="check-item">
                    <i class="bi bi-check2-circle fs-5"></i>
                    <div>
                        <div class="fw-semibold">Profile setup in minutes</div>
                        <small class="text-white-50">Add your name, username, and identity before joining the feed.</small>
                    </div>
                </div>
                <div class="check-item">
                    <i class="bi bi-check2-circle fs-5"></i>
                    <div>
                        <div class="fw-semibold">Built for interaction</div>
                        <small class="text-white-50">Posts, comments, likes, and messaging are ready right after signup.</small>
                    </div>
                </div>
                <div class="check-item">
                    <i class="bi bi-check2-circle fs-5"></i>
                    <div>
                        <div class="fw-semibold">Clean final-project flow</div>
                        <small class="text-white-50">The app is structured to demo the main CRUD features smoothly.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="auth-panel p-4 p-md-5">
                <div class="mb-4">
                    <h2 class="h3 mb-2">Create your account</h2>
                    <p class="mb-0 text-white-50">Start building your profile and join the conversation.</p>
                </div>

                <?php require __DIR__ . '/partials/flash.php'; ?>

                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required maxlength="100" placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required minlength="3" maxlength="20" pattern="[A-Za-z0-9_]+" placeholder="Choose a username">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Create a password">
                    </div>
                    <button class="btn btn-light w-100 fw-semibold py-3">Register</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Already have an account?
                    <a href="index.php?action=login" class="link-light fw-semibold">Log in</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
