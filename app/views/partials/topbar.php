<?php $activePage = $activePage ?? ''; ?>
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
