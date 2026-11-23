
<?php

require_once "../includes/auth.php";
requireAdmin();

require_once "../config/database.php";

$csrfToken = generateCsrfToken();

$errors = [];

$userId = (int) $_SESSION["user_id"];

// Load the logged-in account; the password hash is only read when it is needed
$stmt = $pdo->prepare(
    "SELECT user_id, username FROM users WHERE user_id = :id"
);

$stmt->execute([
    ":id" => $userId
]);

$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    exit("Account not found.");
}

$username = $account["username"];

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!verifyCsrfToken($_POST["csrf_token"] ?? null)) {
        $errors[] = "Invalid security token. Please refresh the page and try again.";
    }

    $username = trim($_POST["username"] ?? "");
    $currentPassword = $_POST["current_password"] ?? "";
    $newPassword = $_POST["new_password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    // Validate username
    if ($username === "") {
        $errors[] = "Username is required.";
    } elseif (!preg_match("/^[A-Za-z0-9_]{3,50}$/", $username)) {
        $errors[] = "Username must be 3-50 characters and contain only letters, numbers, and underscores.";
    }

    // Password change is optional; any password field triggers validation
    $changePassword = $newPassword !== "" || $confirmPassword !== "";

    if ($changePassword) {

        if ($currentPassword === "") {
            $errors[] = "Enter your current password to set a new one.";
        }

        if (strlen($newPassword) < 8) {
            $errors[] = "New password must be at least 8 characters long.";
        }

        if ($newPassword !== $confirmPassword) {
            $errors[] = "New passwords do not match.";
        }
    }

    if (empty($errors)) {

        try {

            // Check whether the username is used by another account
            $checkUsername = $pdo->prepare(
                "SELECT user_id FROM users
                 WHERE username = :username AND user_id <> :id"
            );

            $checkUsername->execute([
                ":username" => $username,
                ":id" => $userId
            ]);

            if ($checkUsername->fetch()) {

                $errors[] = "Username is already taken.";

            } else {

                if ($changePassword) {

                    // Verify the current password before replacing the hash
                    $passwordStmt = $pdo->prepare(
                        "SELECT password FROM users WHERE user_id = :id"
                    );

                    $passwordStmt->execute([
                        ":id" => $userId
                    ]);

                    $storedHash = $passwordStmt->fetchColumn();

                    if (!$storedHash || !password_verify($currentPassword, $storedHash)) {
                        $errors[] = "Current password is incorrect.";
                    }
                }

                if (empty($errors)) {

                    if ($changePassword) {

                        $update = $pdo->prepare(
                            "UPDATE users
                             SET username = :username, password = :password
                             WHERE user_id = :id"
                        );

                        $update->execute([
                            ":username" => $username,
                            ":password" => password_hash($newPassword, PASSWORD_DEFAULT),
                            ":id" => $userId
                        ]);

                    } else {

                        $update = $pdo->prepare(
                            "UPDATE users SET username = :username WHERE user_id = :id"
                        );

                        $update->execute([
                            ":username" => $username,
                            ":id" => $userId
                        ]);
                    }

                    // Keep the sidebar and dashboard in sync
                    $_SESSION["username"] = $username;

                    if ($changePassword) {
                        session_regenerate_id(true);
                        unset($_SESSION["csrf_token"]);

                        // shortcut: no session store means other logged-in sessions stay valid,
                        // add server-side session tracking if that becomes required.
                    }

                    header("Location: manage_account.php?updated=1");
                    exit;
                }
            }

        } catch (PDOException $e) {

            error_log("Account update failed: " . $e->getMessage());

            if ($e->getCode() === "23000") {
                $errors[] = "That username is already taken.";
            } else {
                $errors[] = "Unable to update your account. Please try again.";
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
    <title>Manage Account - Student Management System</title>

    <link rel="icon" type="image/png" href="../assets/img/bu-polangui-logo.png">
    <script src="../assets/js/theme.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="app-shell">

    <?php
    $base = "../";
    $active = "account";
    require "../includes/sidebar.php";
    ?>

    <div class="app-content">
        <main class="form-container">

            <div class="page-topline">
                <a class="back-link" href="dashboard.php">Back to Dashboard</a>
            </div>

            <!-- Form Heading -->
            <header class="page-heading">
                <div>
                    <h1>Manage Account</h1>
                    <p>Update your username or change your password.</p>
                </div>
            </header>

            <!-- Success Message -->
            <?php if (isset($_GET["updated"])): ?>
                <div class="alert alert-success" role="status">
                    Account updated successfully!
                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    <strong>Please check the following:</strong>

                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Account Form -->
            <form method="POST" class="student-form">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($csrfToken) ?>"
                >

                <section class="form-section">
                    <h2>Account Details</h2>
                    <p>Your username is used to sign in to the system.</p>

                    <div class="form-grid">

                        <div class="form-group full-width">
                            <label for="username">Username *</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="<?= htmlspecialchars($username) ?>"
                                minlength="3"
                                maxlength="50"
                                autocomplete="username"
                                required
                            >
                        </div>

                    </div>
                </section>

                <section class="form-section">
                    <h2>Change Password</h2>
                    <p>Leave all password fields blank to keep your current password.</p>

                    <div class="form-grid">

                        <div class="form-group full-width">
                            <label for="current_password">Current Password</label>
                            <div class="password-wrapper">
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    autocomplete="current-password"
                                >
                                <button type="button" class="password-toggle" aria-label="Show password">
                                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                        <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="password-wrapper">
                                <input
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                                <button type="button" class="password-toggle" aria-label="Show password">
                                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                        <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div class="password-wrapper">
                                <input
                                    type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                                <button type="button" class="password-toggle" aria-label="Show password">
                                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                        <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </section>

                <div class="form-buttons">
                    <button type="submit" class="submit-button">
                        Save Changes
                    </button>

                    <a href="dashboard.php" class="cancel-button">
                        Cancel
                    </a>
                </div>

                <p class="required-note">* Required fields</p>

            </form>

        </main>
    </div>

    <script src="../assets/js/script.js" defer></script>
</body>
</html>
