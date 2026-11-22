
<?php

require_once "../includes/auth.php";
requireLogin();

require_once "../config/database.php";
require_once "../includes/helpers.php";

$csrfToken = generateCsrfToken();


// Get the search keyword from the URL
$search = trim($_GET["search"] ?? "");

// Retrieve student records
$sql = "SELECT
            students.student_id,
            students.student_number,
            students.first_name,
            students.last_name,
            courses.course_code,
            courses.course_name,
            departments.department_name,
            departments.department_code,
            year_levels.year_name,
            students.block
        FROM students
        INNER JOIN courses
            ON students.course_id = courses.course_id
        INNER JOIN departments
            ON courses.department_id = departments.department_id
        INNER JOIN year_levels
            ON students.year_level_id = year_levels.year_level_id";

// Add search conditions if a keyword was entered
if ($search !== "") {

    $sql .= " WHERE
                students.student_number LIKE :search
                OR students.first_name LIKE :search
                OR students.last_name LIKE :search";
}

$sql .= " ORDER BY students.student_id ASC";

$stmt = $pdo->prepare($sql);

// Execute the query
if ($search !== "") {
    $stmt->execute([
        ":search" => "%" . $search . "%"
    ]);
} else {
    $stmt->execute();
}

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records - Student Management System</title>

    <link rel="icon" type="image/png" href="../assets/img/bu-polangui-logo.png">
    <script src="../assets/js/theme.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="app-shell">

    <?php
    $base = "../";
    $active = "students";
    require "../includes/sidebar.php";
    ?>

    <div class="app-content">
        <main class="students-container">

            <!-- Page Title -->
            <section class="page-hero">
                <div class="page-hero-copy">
                    <p class="hero-kicker">Student Records</p>
                    <h1>Students</h1>
                    <p>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>. Browse and search campus student records.</p>
                </div>

                <?php if ($_SESSION["role"] === "admin"): ?>
                    <a class="primary-button" href="create.php">
                        + Add New Student
                    </a>
                <?php endif; ?>
            </section>

            <!-- Search Section -->
            <section class="panel search-panel">

                <form method="GET" class="search-form" role="search">

                    <div class="search-field">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input
                            type="text"
                            name="search"
                            placeholder="Search student number or name..."
                            value="<?= htmlspecialchars($search) ?>"
                            aria-label="Search student number or name"
                        >
                    </div>

                    <button type="submit" class="primary-button">Search</button>

                    <a class="clear-search" href="index.php">Clear Search</a>

                </form>

            </section>

            <!-- Success Messages -->
            <?php if (isset($_GET["deleted"])): ?>
                <div class="alert alert-success" role="status">
                    Student deleted successfully!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET["updated"])): ?>
                <div class="alert alert-success" role="status">
                    Student updated successfully!
                </div>
            <?php endif; ?>

            <!-- Student Table -->
            <section class="panel students-table-section">

                <div class="table-heading panel-heading">
                    <h2>All Students</h2>

                    <p>
                        <?= $search !== "" ? "Search results: " : "Total students: " ?>
                        <?= count($students) ?>
                    </p>
                </div>

                <div class="table-responsive">

                    <table class="students-table">

                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Course</th>
                                <th>Department</th>
                                <th>Year Level</th>
                                <th>Block</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($students) > 0): ?>

                                <?php foreach ($students as $student): ?>

                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($student['student_number']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($student['first_name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($student['last_name']) ?>
                                        </td>

                                        <td>
                                            <span class="course-code"><?= htmlspecialchars($student['course_code']) ?></span>
                                            <span class="course-name"><?= htmlspecialchars($student['course_name']) ?></span>
                                        </td>

                                        <td>
                                            <span class="dept-badge dept-<?= departmentClass($student['department_code']) ?>">
                                                <?= htmlspecialchars($student['department_code']) ?>
                                            </span>
                                            <span class="dept-name"><?= htmlspecialchars($student['department_name']) ?></span>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($student['year_name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($student['block']) ?>
                                        </td>

                                        <td class="action-cell">

                                            <a class="view-link"
                                                href="view.php?id=<?= (int) $student['student_id'] ?>">
                                                View
                                            </a>

                                            <?php if ($_SESSION["role"] === "admin"): ?>

                                                <a class="edit-link"
                                                    href="edit.php?id=<?= (int) $student['student_id'] ?>">
                                                    Edit
                                                </a>

                                                <form
                                                    action="delete.php"
                                                    method="POST"
                                                    class="delete-form"
                                                    data-confirm="Are you sure you want to delete this student?">

                                                    <input
                                                        type="hidden"
                                                        name="student_id"
                                                        value="<?= (int) $student['student_id'] ?>"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="csrf_token"
                                                        value="<?= htmlspecialchars($csrfToken) ?>"
                                                    >

                                                    <button type="submit" class="delete-button">
                                                        Delete
                                                    </button>

                                                </form>

                                            <?php endif; ?>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="8" class="empty-message">
                                        No student records found.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </section>

        </main>
    </div>

    <script src="../assets/js/script.js" defer></script>
</body>
</html>
