
<?php

// Load authentication and database configuration
require_once "includes/auth.php";
require_once "config/database.php";

// Redirect users who are already logged in
if (isset($_SESSION["user_id"])) {

    if (($_SESSION["role"] ?? "") === "admin") {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: students/index.php");
    }

    exit;
}

// Generate CSRF token
$csrfToken = generateCsrfToken();

// Store validation errors
$errors = [];

// Preserve username after form submission
$username = "";

// Process registration form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verify CSRF token
    if (!verifyCsrfToken($_POST["csrf_token"] ?? null)) {
        $errors[] = "Invalid security token. Please refresh the page and try again.";
    }

    // Get submitted values
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (!preg_match("/^[A-Za-z0-9_]{3,50}$/", $username)) {
        $errors[] = "Username must be 3-50 characters and contain only letters, numbers, and underscores.";
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Confirm password
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Create account if there are no validation errors
    if (empty($errors)) {

        try {

            // Check whether username already exists
            $checkUsername = $pdo->prepare(
                "SELECT user_id FROM users WHERE username = :username"
            );

            $checkUsername->execute([
                ":username" => $username
            ]);

            if ($checkUsername->fetch()) {

                $errors[] = "Username is already taken.";

            } else {

                // Hash password before saving it
                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // Always assign the regular user role
                $sql = "
                    INSERT INTO users (username, password, role)
                    VALUES (:username, :password, 'user')
                ";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    ":username" => $username,
                    ":password" => $hashedPassword
                ]);

                // Redirect to login after successful registration
                header("Location: index.php?registered=1");
                exit;
            }

        } catch (PDOException $e) {

            error_log("Registration error: " . $e->getMessage());

            $errors[] = "Something went wrong while creating your account. Please try again.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Management System</title>

    <link rel="icon" type="image/png" href="assets/img/bu-polangui-logo.png">
    <script src="assets/js/theme.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="auth-page">
    <div class="auth-theme">
        <?php require __DIR__ . "/includes/theme-toggle.php"; ?>
    </div>

    <main class="auth-shell">
        <section class="auth-visual" aria-label="Bicol University Polangui Campus">
            <div class="auth-visual-brand">
                <div class="brand-logos">
                    <img src="assets/img/bicol-university-logo.png" alt="Bicol University logo">
                    <img src="assets/img/bu-polangui-logo.png" alt="Bicol University Polangui logo">
                </div>
                <div class="brand-copy">
                    <strong>Bicol University</strong>
                    <span>Polangui Campus</span>
                </div>
            </div>

            <div class="auth-visual-copy">
                <p class="auth-eyebrow">Student Management System</p>
                <h2>Join the campus records system.</h2>
                <p>
                    Create an account to view student information maintained by
                    Bicol University&ndash;Polangui Campus.
                </p>
            </div>

            <p class="auth-visual-foot">Polangui, Albay · Bicol University</p>
        </section>

        <section class="auth-card">
            <h1>Create an account</h1>
            <p class="auth-description">Register to access the Student Management System.</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    <strong>Please check the following:</strong>
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="form-group">
                    <label for="username">Username</label>
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

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            minlength="8"
                            autocomplete="new-password"
                            required
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
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            minlength="8"
                            autocomplete="new-password"
                            required
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

                <button type="submit" class="submit-button">Register</button>
            </form>

            <p class="auth-footer">
                Already have an account?
                <a href="index.php">Login here</a>
            </p>
        </section>
    </main>

    <script src="assets/js/script.js" defer></script>
</body>

</html>
