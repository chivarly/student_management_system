<?php

$base = $base ?? "../";
$active = $active ?? "";
$isAdmin = ($_SESSION["role"] ?? "") === "admin";
$username = (string) ($_SESSION["username"] ?? "User");
$initial = strtoupper(substr($username, 0, 1));
$roleLabel = $isAdmin ? "Administrator" : "User";
$homeUrl = $isAdmin
    ? $base . "admin/dashboard.php"
    : $base . "students/index.php";

?>
<aside class="sidebar" id="app-sidebar" data-sidebar aria-label="Main navigation">
    <div class="sidebar-top">
        <a class="sidebar-brand" href="<?= htmlspecialchars($homeUrl) ?>">
            <span class="brand-logos">
                <img src="<?= $base ?>assets/img/bicol-university-logo.png" alt="Bicol University logo">
                <img src="<?= $base ?>assets/img/bu-polangui-logo.png" alt="Bicol University Polangui logo">
            </span>
            <span class="brand-copy">
                <strong>Bicol University</strong>
                <span>Polangui Campus</span>
            </span>
        </a>
        <p class="sidebar-system">Student Management System</p>
    </div>

    <nav class="sidebar-nav">
        <?php if ($isAdmin): ?>
            <a
                class="nav-link <?= $active === "dashboard" ? "is-active" : "" ?>"
                href="<?= $base ?>admin/dashboard.php"
                <?= $active === "dashboard" ? 'aria-current="page"' : "" ?>
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                <span>Dashboard</span>
            </a>
        <?php endif; ?>

        <a
            class="nav-link <?= $active === "students" ? "is-active" : "" ?>"
            href="<?= $base ?>students/index.php"
            <?= $active === "students" ? 'aria-current="page"' : "" ?>
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Students</span>
        </a>

        <?php if ($isAdmin): ?>
            <a
                class="nav-link <?= $active === "create" ? "is-active" : "" ?>"
                href="<?= $base ?>students/create.php"
                <?= $active === "create" ? 'aria-current="page"' : "" ?>
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
                <span>Add Student</span>
            </a>

            <a
                class="nav-link <?= $active === "account" ? "is-active" : "" ?>"
                href="<?= $base ?>admin/manage_account.php"
                <?= $active === "account" ? 'aria-current="page"' : "" ?>
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Manage Account</span>
            </a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <figure class="sidebar-campus">
            <img src="<?= $base ?>assets/img/bupc.jpg" alt="Bicol University Polangui Entrance">
            <figcaption>Bicol University&ndash;Polangui Campus</figcaption>
        </figure>

        <div class="sidebar-theme">
            <span>Appearance</span>
            <?php require __DIR__ . "/theme-toggle.php"; ?>
        </div>

        <div class="sidebar-user">
            <span class="user-avatar" aria-hidden="true"><?= htmlspecialchars($initial) ?></span>
            <span class="user-meta">
                <strong><?= htmlspecialchars($username) ?></strong>
                <span><?= htmlspecialchars($roleLabel) ?></span>
            </span>
            <a class="user-logout" href="<?= $base ?>logout.php" title="Log out">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                <span>Logout</span>
            </a>
        </div>
    </div>
</aside>

<div class="sidebar-backdrop" data-nav-backdrop hidden></div>

<header class="mobile-topbar">
    <button
        type="button"
        class="nav-toggle"
        data-nav-toggle
        aria-controls="app-sidebar"
        aria-expanded="false"
        aria-label="Open navigation"
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>

    <a class="mobile-brand" href="<?= htmlspecialchars($homeUrl) ?>">
        <img src="<?= $base ?>assets/img/bicol-university-logo.png" alt="">
        <span>BU Polangui SMS</span>
    </a>

    <?php require __DIR__ . "/theme-toggle.php"; ?>
</header>
