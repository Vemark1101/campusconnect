<?php
$activePage = $activePage ?? '';
$notifications = $notifications ?? [];
$unreadCount = $unreadCount ?? 0;
?>
<nav class="navbar navbar-expand-lg topbar navbar-dark border-0 py-3">
    <div class="container shell">
        <a class="navbar-brand d-flex align-items-center gap-3 fw-semibold" href="index.php?action=home">
            <span class="brand-mark">CC</span>
            <span class="d-flex flex-column lh-sm">
                <span>CampusConnect</span>
                <small class="text-white-50 fw-normal" style="font-family: Instrument Sans, sans-serif; letter-spacing: 0;">student network</small>
            </span>
        </a>
        <div class="d-flex align-items-center gap-2 ms-auto flex-wrap justify-content-end">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-light position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i> Notifications
                    <?php if ($unreadCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                            <?= (int) $unreadCount ?>
                        </span>
                    <?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-0 overflow-hidden" style="min-width: 340px; border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
                        <strong>Notifications</strong>
                        <a href="index.php?action=mark_notifications_read" class="small text-decoration-none">Mark all as read</a>
                    </div>
                    <?php if (empty($notifications)): ?>
                        <div class="px-3 py-4 text-muted small">No notifications yet.</div>
                    <?php else: ?>
                        <?php foreach ($notifications as $notification): ?>
                            <a href="<?= htmlspecialchars($notification['link'] ?: 'index.php?action=home') ?>" class="dropdown-item px-3 py-3 border-bottom <?= empty($notification['is_read']) ? 'bg-light' : '' ?>">
                                <div class="fw-semibold small"><?= htmlspecialchars($notification['message']) ?></div>
                                <div class="text-muted small"><?= htmlspecialchars($notification['created_at']) ?></div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <a href="index.php?action=home" class="btn btn-sm <?= $activePage === 'home' ? 'btn-light' : 'btn-outline-light' ?>">
                <i class="bi bi-grid"></i> Feed
            </a>
            <a href="index.php?action=search" class="btn btn-sm <?= $activePage === 'search' ? 'btn-light' : 'btn-outline-light' ?>">
                <i class="bi bi-search"></i> Search
            </a>
            <a href="index.php?action=profile" class="btn btn-sm <?= $activePage === 'profile' ? 'btn-light' : 'btn-outline-light' ?>">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <a href="index.php?action=logout" class="btn btn-light btn-sm" onclick="return confirm('Are you sure you want to log out?');">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>
