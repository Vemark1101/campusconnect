<?php
$pageTitle = 'Profile - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(140deg, #fff8e7 0%, #dff1ff 55%, #eef9f1 100%);
        }

        .profile-shell {
            max-width: 1100px;
        }

        .hero-card,
        .panel-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 18px 40px rgba(31, 73, 125, 0.12);
        }

        .avatar-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 28px;
            border: 5px solid #fff;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }

        .mini-post {
            border-radius: 20px;
            background: #f8fbfd;
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
            <h2 class="mb-1">My Profile</h2>
            <p class="text-muted mb-0">Manage your public identity and review your recent posts.</p>
        </div>
        <a href="index.php?action=home" class="btn btn-outline-secondary">Back to Feed</a>
    </div>

    <?php require __DIR__ . '/partials/flash.php'; ?>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="hero-card p-4 h-100">
                <div class="text-center mb-4">
                    <img src="assets/uploads/<?= htmlspecialchars(!empty($user['profile_pic']) ? $user['profile_pic'] : 'default-avatar.svg') ?>" class="avatar-img mb-3" alt="Profile image" onerror="this.src='assets/uploads/default-avatar.svg'">
                    <h3 class="mb-1"><?= htmlspecialchars($user['full_name']) ?></h3>
                    <div class="text-muted">@<?= htmlspecialchars($user['username']) ?></div>
                </div>

                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="panel-card p-3">
                            <div class="text-muted small">Joined</div>
                            <div class="fw-semibold"><?= htmlspecialchars(substr((string) $user['created_at'], 0, 10)) ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="panel-card p-3">
                            <div class="text-muted small">Posts</div>
                            <div class="fw-semibold"><?= count($posts) ?></div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Bio</h6>
                    <p class="text-muted mb-0"><?= $user['bio'] ? nl2br(htmlspecialchars($user['bio'])) : 'No bio added yet.' ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="panel-card p-4 mb-4">
                <h4 class="mb-3">Edit Profile</h4>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_pic" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bio / About</label>
                        <textarea name="bio" class="form-control" rows="4" maxlength="500"><?= htmlspecialchars($user['bio']) ?></textarea>
                    </div>
                    <button class="btn btn-success" type="submit">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </form>
            </div>

            <div class="panel-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">My Posts</h4>
                    <a href="index.php?action=home" class="btn btn-sm btn-outline-primary">Create New Post</a>
                </div>

                <?php if (empty($posts)): ?>
                    <p class="text-muted mb-0">You have not posted anything yet.</p>
                <?php endif; ?>

                <?php foreach ($posts as $post): ?>
                    <div class="mini-post p-3 mb-3">
                        <div class="small text-muted mb-2"><?= htmlspecialchars($post['created_at']) ?></div>
                        <?php if (!empty($post['content'])): ?>
                            <p class="mb-2"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
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
