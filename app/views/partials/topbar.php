<?php $activePage = $activePage ?? ''; ?>
<nav class="navbar navbar-expand-lg topbar navbar-dark shadow-sm">
    <div class="container shell">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="index.php?action=home">
            <span class="brand-mark">CC</span>
            <span>CampusConnect</span>
        </a>
        <div class="d-flex align-items-center gap-2 ms-auto">
            <a href="index.php?action=home" class="btn btn-sm <?= $activePage === 'home' ? 'btn-light' : 'btn-outline-light' ?>">
                Feed
            </a>
            <a href="index.php?action=profile" class="btn btn-sm <?= $activePage === 'profile' ? 'btn-light' : 'btn-outline-light' ?>">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <a href="index.php?action=logout" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
