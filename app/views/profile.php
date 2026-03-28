<?php
$pageTitle = 'Profile - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f6f1e8 0%, #d9ebff 50%, #edf7e6 100%);
        }

        .profile-shell {
            max-width: 1120px;
        }

        .hero-card,
        .panel-card {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 45px rgba(23, 86, 118, 0.12);
        }

        .profile-hero {
            background: rgba(255, 255, 255, 0.92);
        }

        .avatar-img {
            width: 146px;
            height: 146px;
            object-fit: cover;
            border-radius: 30px;
            border: 6px solid #fff;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }

        .profile-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            background: rgba(23, 86, 118, 0.08);
            color: #175676;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .profile-name {
            color: #17324d;
        }

        .username-text {
            color: #4f6579;
            font-weight: 600;
        }

        .mini-post {
            border-radius: 24px;
            background: rgba(247, 251, 255, 0.95);
            border: 1px solid rgba(23, 50, 77, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .metric-tile {
            border-radius: 22px;
            background: rgba(23, 86, 118, 0.08);
            border: 1px solid rgba(23, 50, 77, 0.1);
            box-shadow: 0 12px 24px rgba(23, 50, 77, 0.06);
        }

        .metric-value {
            font-size: 1.15rem;
            color: #17324d;
        }

        .section-title {
            color: #17324d;
        }

        .section-subtitle {
            color: #60778a;
        }

        .bio-block {
            padding: 1rem 1.1rem;
            border-radius: 22px;
            background: rgba(247, 251, 255, 0.95);
            border: 1px solid rgba(23, 50, 77, 0.08);
        }

        .edit-panel {
            background: rgba(255, 255, 255, 0.92);
        }

        .posts-panel {
            background: rgba(255, 255, 255, 0.92);
        }

        .post-date {
            color: #60778a;
            font-weight: 600;
        }

        .post-content {
            color: #17324d;
            line-height: 1.65;
        }

        .back-btn {
            min-width: 150px;
        }
    </style>
HTML;
$extraScripts = <<<HTML
<script>
document.querySelector('form[enctype="multipart/form-data"]')?.addEventListener('submit', (event) => {
    const fullName = document.querySelector('input[name="full_name"]').value.trim();
    if (!fullName) {
        event.preventDefault();
        alert('Full name is required.');
    }
});
</script>
HTML;
require __DIR__ . '/partials/head.php';
$activePage = 'profile';
require __DIR__ . '/partials/topbar.php';
?>
<main class="container profile-shell py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="soft-pill mb-2"><i class="bi bi-stars"></i> Personal dashboard</span>
            <h2 class="mb-1 page-heading">My Profile</h2>
            <p class="text-muted mb-0">Manage your public identity and review your recent posts.</p>
        </div>
        <a href="index.php?action=home" class="btn btn-outline-secondary back-btn">Back to Feed</a>
    </div>

    <?php require __DIR__ . '/partials/flash.php'; ?>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="hero-card profile-hero p-4 h-100">
                <div class="text-center mb-4">
                    <span class="profile-tag mb-3"><i class="bi bi-person-vcard"></i> Public Profile</span>
                    <br>
                    <img src="assets/uploads/<?= htmlspecialchars(!empty($user['profile_pic']) ? $user['profile_pic'] : 'default-avatar.svg') ?>" class="avatar-img mb-3" alt="Profile image" onerror="this.src='assets/uploads/default-avatar.svg'">
                    <h3 class="mb-1 profile-name"><?= htmlspecialchars($user['full_name']) ?></h3>
                    <div class="username-text">@<?= htmlspecialchars($user['username']) ?></div>
                </div>

                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="metric-tile p-3">
                            <div class="text-muted small">Joined</div>
                            <div class="fw-semibold metric-value"><?= htmlspecialchars(substr((string) $user['created_at'], 0, 10)) ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="metric-tile p-3">
                            <div class="text-muted small">Posts</div>
                            <div class="fw-semibold metric-value"><?= count($posts) ?></div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="mb-2 section-title">Bio</h6>
                    <div class="bio-block">
                        <p class="mb-0 section-subtitle"><?= $user['bio'] ? nl2br(htmlspecialchars($user['bio'])) : 'No bio added yet.' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="panel-card edit-panel p-4 mb-4">
                <div class="mb-3">
                    <h4 class="mb-1 section-title">Edit Profile</h4>
                    <p class="mb-0 section-subtitle">Update your display details and profile image.</p>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_pic" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required maxlength="100" placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bio / About</label>
                        <textarea name="bio" class="form-control" rows="4" maxlength="500" placeholder="Tell people what you study, do, or care about."><?= htmlspecialchars($user['bio']) ?></textarea>
                    </div>
                    <button class="btn btn-success px-4" type="submit">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </form>
            </div>

            <div class="panel-card posts-panel p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-0 section-title">My Posts</h4>
                        <small class="section-subtitle">Your latest profile activity</small>
                    </div>
                    <a href="index.php?action=home" class="btn btn-sm btn-outline-primary">Create New Post</a>
                </div>

                <?php if (empty($posts)): ?>
                    <p class="text-muted mb-0">You have not posted anything yet.</p>
                <?php endif; ?>

                <?php foreach ($posts as $post): ?>
                    <div class="mini-post p-3 mb-3">
                        <div class="small post-date mb-2"><?= htmlspecialchars($post['created_at']) ?></div>
                        <?php if (!empty($post['content'])): ?>
                            <p class="mb-2 post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($post['image'])): ?>
                            <img src="assets/uploads/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded-4" alt="Post image">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
