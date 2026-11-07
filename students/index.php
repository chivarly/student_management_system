
<?php

require_once "../includes/auth.php";
requireLogin();

require_once "../config/database.php";

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
            year_levels.year_name,
            students.block
        FROM students
        INNER JOIN courses
            ON students.course_id = courses.course_id
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

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <main class="students-container">

        <!-- Page Header -->
        <header class="students-header">
            <div>
                <h1>Student Management System</h1>
                <p>Manage and view student records.</p>
            </div>

            <div class="students-header-actions">
                <?php if ($_SESSION["role"] === "admin"): ?>
                    <a href="../admin/dashboard.php">Dashboard</a>
                <?php endif; ?>

                <a href="../logout.php">Logout</a>
            </div>
        </header>

        <!-- Page Title -->
        <section class="students-page-heading">
            <div>
                <h2>Student Records</h2>
                <p>
                    Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!
                </p>
            </div>

            <?php if ($_SESSION["role"] === "admin"): ?>
                <a class="primary-button" href="create.php">
                    + Add New Student
                </a>
            <?php endif; ?>
        </section>

        <!-- Search Section -->
        <section class="students-search">

            <form method="GET" class="search-form">

                <input
                    type="text"
                    name="search"
                    placeholder="Search student number or name..."
                    value="<?= htmlspecialchars($search) ?>"
                >

                <button type="submit">Search</button>

                <a href="index.php">Clear Search</a>

            </form>

        </section>

        <!-- Success Messages -->
        <?php if (isset($_GET["deleted"])): ?>
            <p class="success-message">
                Student deleted successfully!
            </p>
        <?php endif; ?>

        <?php if (isset($_GET["updated"])): ?>
            <p class="success-message">
                Student updated successfully!
            </p>
        <?php endif; ?>

        <!-- Student Table -->
        <section class="students-table-section">

            <div class="table-heading">
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
                                        <?= htmlspecialchars($student['course_code']) ?>
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
                                <td colspan="7" class="empty-message">
                                    No student records found.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>
<script src="../assets/js/script.js" defer></script>                           
</body>
</html>
