
<?php

require_once "../includes/auth.php";
requireAdmin();

require_once "../config/database.php";

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Verify the CSRF token
if (!verifyCsrfToken($_POST["csrf_token"] ?? null)) {
    http_response_code(403);
    exit("Invalid security token. Please refresh the page and try again.");
}

// Get the student ID from the submitted form
$student_id = filter_input(INPUT_POST, "student_id", FILTER_VALIDATE_INT);

if (!$student_id || $student_id <= 0) {
    exit("Invalid student ID.");
}

// Check if the student exists
$stmt = $pdo->prepare(
    "SELECT student_id FROM students WHERE student_id = :student_id"
);

$stmt->execute([
    ":student_id" => $student_id
]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    exit("Student record not found.");
}

// Delete the student record
try {

    $stmt = $pdo->prepare(
        "DELETE FROM students WHERE student_id = :student_id"
    );

    $stmt->execute([
        ":student_id" => $student_id
    ]);

    header("Location: index.php?deleted=1");
    exit;

} catch (PDOException $e) {

    error_log("Student deletion failed: " . $e->getMessage());

    exit("Unable to delete this student record. Please try again.");
}
