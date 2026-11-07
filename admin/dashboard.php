
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

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <main class="dashboard-container">

        <!-- Dashboard Header -->
        <header class="dashboard-header">
            <h1>Student Management System</h1>

            <a href="../logout.php">Logout</a>
        </header>

        <!-- Welcome Section -->
        <section class="dashboard-welcome">
            <h2>
                Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!
            </h2>

            <p>You are logged in as an administrator.</p>
        </section>

        <!-- System Statistics -->
        <section>
            <h2>System Overview</h2>

            <div class="dashboard-stats">

                <div class="stat-card">
                    <p>Total Students</p>
                    <h2><?= (int) $totalStudents ?></h2>
                </div>

                <div class="stat-card">
                    <p>Total Courses</p>
                    <h2><?= (int) $totalCourses ?></h2>
                </div>

                <div class="stat-card">
                    <p>Total Year Levels</p>
                    <h2><?= (int) $totalYearLevels ?></h2>
                </div>

                <div class="stat-card">
                    <p>Total Users</p>
                    <h2><?= (int) $totalUsers ?></h2>
                </div>

            </div>
        </section>

        <!-- Management Actions -->
        <section class="dashboard-actions">
            <h2>Management</h2>

            <div class="action-links">
                <a href="../students/index.php">Manage Students</a>

                <a href="../students/create.php">Add New Student</a>
            </div>
        </section>

    </main>

</body>
</html>
