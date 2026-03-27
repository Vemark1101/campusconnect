<?php
$pageTitle = 'Search Users - CampusConnect';
$extraHead = <<<HTML
    <style>
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(255, 196, 112, 0.24), transparent 24%),
                linear-gradient(135deg, #eef8ff 0%, #fff6e8 100%);
        }

        .search-shell {
            max-width: 980px;
        }

        .search-hero {
            background: linear-gradient(135deg, rgba(23, 86, 118, 0.06), rgba(255, 159, 67, 0.08)), rgba(255, 255, 255, 0.88);
            border-radius: 32px;
            border: 1px solid rgba(23, 50, 77, 0.08);
            box-shadow: 0 16px 38px rgba(31, 73, 125, 0.1);
        }

        .result-card {
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 14px 35px rgba(31, 73, 125, 0.1);
            border: 1px solid rgba(23, 50, 77, 0.06);
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            object-fit: cover;
        }
    </style>
HTML;
require __DIR__ . '/partials/head.php';
$activePage = 'search';
require __DIR__ . '/partials/topbar.php';
?>
<main class="container search-shell py-4">
    <div class="search-hero p-4 p-md-5 mb-4">
        <div>
            <span class="soft-pill mb-2"><i class="bi bi-search-heart"></i> Discover students</span>
            <h2 class="mb-1 page-heading">User Search</h2>
            <p class="text-muted mb-0">Find classmates by name or username.</p>
        </div>
    </div>

    <form method="GET" action="index.php" class="mb-4">
        <input type="hidden" name="action" value="search">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Search by full name or username">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <?php if (empty($keyword)): ?>
        <div class="result-card p-4 text-muted">Enter a search term to discover users.</div>
    <?php elseif (empty($users)): ?>
        <div class="result-card p-4 text-muted">No users matched your search.</div>
    <?php endif; ?>

    <?php foreach ($users as $resultUser): ?>
        <?php $isOnline = !empty($resultUser['last_active']) && (strtotime($resultUser['last_active']) > time() - 60); ?>
        <div class="result-card p-4 mb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center">
                <div class="d-flex gap-3 align-items-center">
                    <img class="avatar" src="assets/uploads/<?= htmlspecialchars($resultUser['profile_pic'] ?: 'default-avatar.svg') ?>" alt="Profile image" onerror="this.src='assets/uploads/default-avatar.svg'">
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($resultUser['full_name']) ?></div>
                        <div class="text-muted">@<?= htmlspecialchars($resultUser['username']) ?></div>
                        <?php if ($isOnline): ?>
                            <div class="small text-success">Online</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <?php if ((int) $resultUser['id'] !== (int) ($_SESSION['user_id'] ?? 0)): ?>
                        <a href="index.php?action=chat&receiver_id=<?= (int) $resultUser['id'] ?>" class="btn btn-outline-success">Message</a>
                    <?php else: ?>
                        <a href="index.php?action=profile" class="btn btn-outline-primary">View Profile</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($resultUser['bio'])): ?>
                <p class="text-muted mt-3 mb-0"><?= nl2br(htmlspecialchars($resultUser['bio'])) ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
