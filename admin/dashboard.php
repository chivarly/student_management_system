
<?php

require_once "../includes/auth.php";
requireAdmin();

require_once "../config/database.php";

// Get dashboard statistics
$totalStudents = $pdo->query(
    "SELECT COUNT(*) FROM students"
)->fetchColumn();

$totalCourses = $pdo->query(
    "SELECT COUNT(*) FROM courses"
)->fetchColumn();

$totalYearLevels = $pdo->query(
    "SELECT COUNT(*) FROM year_levels"
)->fetchColumn();

$totalUsers = $pdo->query(
    "SELECT COUNT(*) FROM users"
)->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Management System</title>

    <link rel="icon" type="image/png" href="../assets/img/bu-polangui-logo.png">
    <script src="../assets/js/theme.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="app-shell">

    <?php
    $base = "../";
    $active = "dashboard";
    require "../includes/sidebar.php";
    ?>

    <div class="app-content">
        <main class="dashboard-container">

            <!-- Welcome Section -->
            <section class="page-hero">
                <div class="page-hero-copy">
                    <p class="hero-kicker">Administrator Dashboard</p>
                    <h1>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></h1>
                    <p>You are logged in as an administrator for Bicol University&ndash;Polangui Campus.</p>
                </div>
            </section>

            <!-- System Statistics -->
            <section class="panel">
                <div class="panel-heading">
                    <h2>System Overview</h2>
                    <p>Current totals across the student management system.</p>
                </div>

                <div class="dashboard-stats">

                    <article class="stat-card stat-students">
                        <div class="stat-top">
                            <span class="stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </span>
                            <p class="stat-label">Total Students</p>
                        </div>
                        <p class="stat-value"><?= (int) $totalStudents ?></p>
                    </article>

                    <article class="stat-card stat-courses">
                        <div class="stat-top">
                            <span class="stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </span>
                            <p class="stat-label">Total Courses</p>
                        </div>
                        <p class="stat-value"><?= (int) $totalCourses ?></p>
                    </article>

                    <article class="stat-card stat-years">
                        <div class="stat-top">
                            <span class="stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                                    <polyline points="2 17 12 22 22 17"/>
                                    <polyline points="2 12 12 17 22 12"/>
                                </svg>
                            </span>
                            <p class="stat-label">Total Year Levels</p>
                        </div>
                        <p class="stat-value"><?= (int) $totalYearLevels ?></p>
                    </article>

                    <article class="stat-card stat-users">
                        <div class="stat-top">
                            <span class="stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <p class="stat-label">Total Users</p>
                        </div>
                        <p class="stat-value"><?= (int) $totalUsers ?></p>
                    </article>

                </div>
            </section>

            <!-- Management Actions -->
            <section class="panel">
                <div class="panel-heading">
                    <h2>Management</h2>
                </div>

                <div class="action-links">
                    <a href="../students/index.php">Manage Students</a>
                    <a href="../students/create.php">Add New Student</a>
                </div>
            </section>

        </main>
    </div>

    <script src="../assets/js/script.js" defer></script>
</body>
</html>
