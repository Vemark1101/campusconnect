<?php
$pageTitle = 'Login - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f6f1e8 0%, #d9ebff 50%, #edf7e6 100%);
        }

        .auth-wrap {
            max-width: 1040px;
        }

        .auth-panel {
            border-radius: 34px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
            color: #17324d;
            box-shadow: 0 20px 45px rgba(23, 86, 118, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .hero-copy {
            color: #17324d;
        }

        .hero-badge {
            display: inline-flex;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(23, 86, 118, 0.08);
            color: #175676;
            font-size: 0.85rem;
        }

        .auth-panel .form-control {
            background: rgba(255, 255, 255, 0.94);
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
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(255, 255, 255, 0.42);
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
            <p class="fs-5 text-muted mb-4">Share updates, react to classmates, manage your profile, and keep conversations moving through a clean student-first network.</p>
            <div class="d-flex flex-wrap gap-2">
                <span class="soft-pill"><i class="bi bi-shield-check"></i> Secure login</span>
                <span class="soft-pill"><i class="bi bi-chat-dots"></i> Direct messaging</span>
                <span class="soft-pill"><i class="bi bi-images"></i> Media posts</span>
            </div>
            <div class="feature-grid">
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Campus-first feed</div>
                    <small class="text-muted">Post class updates, event ideas, and daily student moments in one place.</small>
                </div>
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Simple communication</div>
                    <small class="text-muted">Move from feed interaction to direct chat without leaving the platform.</small>
                </div>
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Presentation-ready UI</div>
                    <small class="text-muted">A stronger visual layer helps the project feel more complete in demos.</small>
                </div>
                <div class="feature-tile">
                    <div class="fw-semibold mb-1">Responsive layout</div>
                    <small class="text-muted">Clean experience across laptop and mobile screens for evaluation day.</small>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="auth-panel p-4 p-md-5">
                <div class="mb-4">
                    <h2 class="h3 mb-2">Welcome back</h2>
                    <p class="mb-0 text-muted">Sign in to continue to CampusConnect.</p>
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
                    <button class="btn btn-primary w-100 fw-semibold py-3">Login</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    No account yet?
                    <a href="index.php?action=register" class="fw-semibold">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
