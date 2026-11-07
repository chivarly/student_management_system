<?php

$host = "localhost";
$dbname = "student_management_system";
$username = "your_username";
$password = "your_password";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());

    exit("Unable to connect to the database.");
}