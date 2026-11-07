
<?php

require_once "../includes/auth.php";
requireLogin();

require_once "../config/database.php";

// Get student ID from the URL
$student_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$student_id || $student_id <= 0) {
    exit("Invalid student ID.");
}

// Retrieve complete student information
$sql = "SELECT
            students.*,
            courses.course_code,
            courses.course_name,
            year_levels.year_name
        FROM students
        INNER JOIN courses
            ON students.course_id = courses.course_id
        INNER JOIN year_levels
            ON students.year_level_id = year_levels.year_level_id
        WHERE students.student_id = :student_id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":student_id" => $student_id
]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Check whether the student exists
if (!$student) {
    exit("Student record not found.");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Student Management System</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <main class="profile-container">

        <!-- Page Header -->
        <header class="form-page-header">
            <div>
                <h1>Student Management System</h1>
                <p>View complete student information.</p>
            </div>

            <a href="index.php">Back to Student Records</a>
        </header>

        <!-- Student Profile Heading -->
        <section class="profile-heading">
            <div>
                <h2>
                    <?= htmlspecialchars($student["first_name"]) ?>
                    <?= htmlspecialchars($student["last_name"]) ?>
                </h2>

                <p>
                    Student Number:
                    <?= htmlspecialchars($student["student_number"]) ?>
                </p>
            </div>

            <?php if ($_SESSION["role"] === "admin"): ?>
                <a
                    class="primary-button"
                    href="edit.php?id=<?= (int) $student["student_id"] ?>"
                >
                    Edit Student
                </a>
            <?php endif; ?>
        </section>

        <!-- Student Information -->
        <section class="profile-section">

            <h3>Personal Information</h3>

            <div class="profile-grid">

                <div class="profile-item">
                    <span>Student Number</span>
                    <strong><?= htmlspecialchars($student["student_number"]) ?></strong>
                </div>

                <div class="profile-item">
                    <span>First Name</span>
                    <strong><?= htmlspecialchars($student["first_name"]) ?></strong>
                </div>

                <div class="profile-item">
                    <span>Last Name</span>
                    <strong><?= htmlspecialchars($student["last_name"]) ?></strong>
                </div>

                <div class="profile-item">
                    <span>Birthdate</span>
                    <strong><?= htmlspecialchars($student["birthdate"] ?? "Not provided") ?></strong>
                </div>

                <div class="profile-item">
                    <span>Gender</span>
                    <strong><?= htmlspecialchars($student["gender"] ?? "Not provided") ?></strong>
                </div>

                <div class="profile-item">
                    <span>Contact Number</span>
                    <strong><?= htmlspecialchars($student["contact_number"] ?? "Not provided") ?></strong>
                </div>

                <div class="profile-item">
                    <span>Email Address</span>
                    <strong><?= htmlspecialchars($student["email"] ?? "Not provided") ?></strong>
                </div>

                <div class="profile-item full-width">
                    <span>Address</span>
                    <strong><?= htmlspecialchars($student["address"] ?? "Not provided") ?></strong>
                </div>

            </div>

        </section>

        <!-- Academic Information -->
        <section class="profile-section">

            <h3>Academic Information</h3>

            <div class="profile-grid">

                <div class="profile-item">
                    <span>Course Code</span>
                    <strong><?= htmlspecialchars($student["course_code"]) ?></strong>
                </div>

                <div class="profile-item">
                    <span>Course Name</span>
                    <strong><?= htmlspecialchars($student["course_name"]) ?></strong>
                </div>

                <div class="profile-item">
                    <span>Year Level</span>
                    <strong><?= htmlspecialchars($student["year_name"]) ?></strong>
                </div>

                <div class="profile-item">
                    <span>Block</span>
                    <strong><?= htmlspecialchars($student["block"] ?? "Not provided") ?></strong>
                </div>

            </div>

        </section>

        <!-- Record Information -->
        <section class="profile-section">

            <h3>Record Information</h3>

            <div class="profile-grid">

                <div class="profile-item">
                    <span>Date Added</span>
                    <strong><?= htmlspecialchars($student["created_at"]) ?></strong>
                </div>

            </div>

        </section>

        <div class="profile-footer">
            <a href="index.php" class="cancel-button">
                Back to Student Records
            </a>
        </div>

    </main>

</body>
</html>
