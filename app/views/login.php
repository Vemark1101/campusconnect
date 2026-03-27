<?php
$pageTitle = 'Login - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(255, 190, 92, 0.7), transparent 30%),
                radial-gradient(circle at bottom right, rgba(20, 184, 166, 0.35), transparent 28%),
                linear-gradient(135deg, #16324f 0%, #1f4f73 40%, #0f766e 100%);
        }

        .auth-wrap {
            max-width: 1040px;
        }

        .auth-panel {
            border-radius: 34px;
            background: rgba(255, 255, 255, 0.16);
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
            background: rgba(255, 255, 255, 0.92);
            min-height: 56px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .feature-tile {
            padding: 1rem 1.1rem;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        @media (max-width: 767px) {
            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
HTML;
$bodyClass = 'd-flex align-items-center p-3 p-md-4';
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
<div class="container auth-wrap">
    <div class="row g-4 align-items-center">
        <div class="col-lg-6 hero-copy">
            <span class="hero-badge mb-3">Mini Social Networking Web Application</span>
            <h1 class="display-4 fw-bold mb-3 page-heading">Build your campus presence in one place.</h1>
            <p class="fs-5 text-white-50 mb-4">Share updates, react to classmates, manage your profile, and keep conversations moving through a clean student-first network.</p>
            <div class="d-flex flex-wrap gap-2">
                <span class="soft-pill"><i class="bi bi-shield-check"></i> Secure login</span>
                <span class="soft-pill"><i class="bi bi-chat-dots"></i> Direct messaging</span>
                <span class="soft-pill"><i class="bi bi-images"></i> Media posts</span>
            </div>
            <div class="feature-grid">
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Campus-first feed</div>
                    <small class="text-white-50">Post class updates, event ideas, and daily student moments in one place.</small>
                </div>
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Simple communication</div>
                    <small class="text-white-50">Move from feed interaction to direct chat without leaving the platform.</small>
                </div>
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Presentation-ready UI</div>
                    <small class="text-white-50">A stronger visual layer helps the project feel more complete in demos.</small>
                </div>
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Responsive layout</div>
                    <small class="text-white-50">Clean experience across laptop and mobile screens for evaluation day.</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="auth-panel p-4 p-md-5">
                <div class="mb-4">
                    <h2 class="h3 mb-2">Welcome back</h2>
                    <p class="mb-0 text-white-50">Sign in to continue to CampusConnect.</p>
                </div>

                <?php require __DIR__ . '/partials/flash.php'; ?>

                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required maxlength="50" placeholder="Enter your username">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Enter your password">
                    </div>
                    <button class="btn btn-light w-100 fw-semibold py-3">Login</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    No account yet?
                    <a href="index.php?action=register" class="link-light fw-semibold">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
