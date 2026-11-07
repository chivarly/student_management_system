
<?php

require_once "../includes/auth.php";
requireAdmin();

require_once "../config/database.php";

$csrfToken = generateCsrfToken();
$errors = [];

// Get courses and year levels for the dropdown menus
$courses = $pdo->query(
    "SELECT course_id, course_code FROM courses ORDER BY course_code"
)->fetchAll(PDO::FETCH_ASSOC);

$yearLevels = $pdo->query(
    "SELECT year_level_id, year_name FROM year_levels ORDER BY year_level_id"
)->fetchAll(PDO::FETCH_ASSOC);

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {


if (!verifyCsrfToken($_POST["csrf_token"] ?? null)) {
    $errors[] = "Invalid security token. Please refresh the page and try again.";
}

    $student_number = trim($_POST["student_number"] ?? "");
    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $birthdate = $_POST["birthdate"] ?? "";
    $gender = $_POST["gender"] ?? "";
    $address = trim($_POST["address"] ?? "");
    $contact_number = trim($_POST["contact_number"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course_id = (int) ($_POST["course_id"] ?? 0);
    $year_level_id = (int) ($_POST["year_level_id"] ?? 0);
    $block = trim($_POST["block"] ?? "");

    // Basic validation
    if ($student_number === "") {
        $errors[] = "Student number is required.";
    }

    if ($first_name === "") {
        $errors[] = "First name is required.";
    }

    if ($last_name === "") {
        $errors[] = "Last name is required.";
    }

    if ($course_id <= 0) {
        $errors[] = "Please select a course.";
    }

    if ($year_level_id <= 0) {
        $errors[] = "Please select a year level.";
    }

    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if ($birthdate !== "") {
        $date = DateTime::createFromFormat("Y-m-d", $birthdate);

        if (!$date || $date->format("Y-m-d") !== $birthdate) {
            $errors[] = "Please enter a valid birthdate.";
        }
    }

    // Insert the student if there are no validation errors
    if (empty($errors)) {

        $sql = "INSERT INTO students (
                    student_number,
                    first_name,
                    last_name,
                    birthdate,
                    gender,
                    address,
                    contact_number,
                    email,
                    course_id,
                    year_level_id,
                    block
                ) VALUES (
                    :student_number,
                    :first_name,
                    :last_name,
                    :birthdate,
                    :gender,
                    :address,
                    :contact_number,
                    :email,
                    :course_id,
                    :year_level_id,
                    :block
                )";

        try {
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":student_number" => $student_number,
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":birthdate" => $birthdate ?: null,
                ":gender" => $gender ?: null,
                ":address" => $address ?: null,
                ":contact_number" => $contact_number ?: null,
                ":email" => $email ?: null,
                ":course_id" => $course_id,
                ":year_level_id" => $year_level_id,
                ":block" => $block ?: null
            ]);

            header("Location: create.php?success=1");
            exit;

        } catch (PDOException $e) {
            error_log("Student creation failed: " . $e->getMessage());

            if ($e->getCode() === "23000") {
                $errors[] = "That student number may already exist.";
            } else {
                $errors[] = "Unable to save the student. Please try again.";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Student Management System</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <main class="form-container">

        <!-- Page Header -->
        <header class="form-page-header">
            <div>
                <h1>Student Management System</h1>
                <p>Add a new student record to the system.</p>
            </div>

            <a href="index.php">Back to Student Records</a>
        </header>

        <!-- Form Heading -->
        <section class="form-heading">
            <h2>Add New Student</h2>
            <p>Fill in the student's information below.</p>
        </section>

        <!-- Success Message -->
        <?php if (isset($_GET["success"])): ?>
            <p class="success-message">
                Student added successfully!
            </p>
        <?php endif; ?>

        <!-- Validation Errors -->
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <strong>Please check the following:</strong>

                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Student Form -->
        <form method="POST" class="student-form">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($csrfToken) ?>"
            >

            <div class="form-grid">

                <div class="form-group">
                    <label for="student_number">Student Number *</label>
                    <input
                        type="text"
                        id="student_number"
                        name="student_number"
                        value="<?= htmlspecialchars($_POST["student_number"] ?? "") ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="<?= htmlspecialchars($_POST["first_name"] ?? "") ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="<?= htmlspecialchars($_POST["last_name"] ?? "") ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input
                        type="date"
                        id="birthdate"
                        name="birthdate"
                        value="<?= htmlspecialchars($_POST["birthdate"] ?? "") ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male"
                            <?= ($_POST["gender"] ?? "") === "Male" ? "selected" : "" ?>>
                            Male
                        </option>
                        <option value="Female"
                            <?= ($_POST["gender"] ?? "") === "Female" ? "selected" : "" ?>>
                            Female
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input
                        type="text"
                        id="contact_number"
                        name="contact_number"
                        value="<?= htmlspecialchars($_POST["contact_number"] ?? "") ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="course_id">Course *</label>
                    <select id="course_id" name="course_id" required>
                        <option value="">Select Course</option>

                        <?php foreach ($courses as $course): ?>
                            <option
                                value="<?= $course["course_id"] ?>"
                                <?= (($_POST["course_id"] ?? "") == $course["course_id"]) ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($course["course_code"]) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="year_level_id">Year Level *</label>
                    <select id="year_level_id" name="year_level_id" required>
                        <option value="">Select Year Level</option>

                        <?php foreach ($yearLevels as $year): ?>
                            <option
                                value="<?= $year["year_level_id"] ?>"
                                <?= (($_POST["year_level_id"] ?? "") == $year["year_level_id"]) ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($year["year_name"]) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="block">Block</label>
                    <input
                        type="text"
                        id="block"
                        name="block"
                        value="<?= htmlspecialchars($_POST["block"] ?? "") ?>"
                    >
                </div>

                <div class="form-group full-width">
                    <label for="address">Address</label>
                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                    ><?= htmlspecialchars($_POST["address"] ?? "") ?></textarea>
                </div>

            </div>

            <div class="form-buttons">
                <button type="submit" class="submit-button">
                    Add Student
                </button>

                <a href="index.php" class="cancel-button">
                    Cancel
                </a>
            </div>

            <p class="required-note">* Required fields</p>

        </form>

    </main>

</body>
</html>
