
<?php

require_once "includes/auth.php";
require_once "config/database.php";

$csrfToken = generateCsrfToken();

// If already logged in, redirect based on role
if (isset($_SESSION["user_id"])) {

    if ($_SESSION["role"] === "admin") {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: students/index.php");
    }

    exit;
}

$error = "";
$username = "";

// Process the login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!verifyCsrfToken($_POST["csrf_token"] ?? null)) {

    $error = "Invalid security token. Please refresh the page.";

    } elseif ($username === "" || $password === "") {

        $error = "Please enter your username and password.";

    } else {

        // Find the account using its username
        $stmt = $pdo->prepare(
            "SELECT user_id, username, password, role
             FROM users
             WHERE username = :username
             LIMIT 1"
        );

        $stmt->execute([
            ":username" => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the entered password against the stored hash
        if ($user && password_verify($password, $user["password"])) {

            // Generate a new session ID after successful login
            session_regenerate_id(true);
            unset($_SESSION["csrf_token"]);
            // Store account information in the session
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            // Redirect based on the user's role
            if ($user["role"] === "admin") {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: students/index.php");
            }

            exit;

        } else {

            // Use a general error message for incorrect credentials
            $error = "Invalid username or password.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>

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
                <h2>One place for student records.</h2>
                <p>
                    Manage student profiles, courses, and academic details
                    across Bicol University&ndash;Polangui Campus.
                </p>
            </div>

            <p class="auth-visual-foot">Polangui, Albay · Bicol University</p>
        </section>

        <section class="auth-card">
            <h1>Welcome!</h1>
            <p class="auth-description">Sign in to access the Student Management System.</p>

            <?php if (isset($_GET["registered"]) && $_GET["registered"] === "1"): ?>
                <div class="alert alert-success" role="status">
                    Registration successful! You can now log in to your account.
                </div>
            <?php endif; ?>

            <?php if ($error !== ""): ?>
                <div class="alert alert-error" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= htmlspecialchars($username) ?>"
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
                            autocomplete="current-password"
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

                <button type="submit" class="submit-button">Login</button>
            </form>

            <p class="auth-footer">
                Don't have an account?
                <a href="register.php">Sign up now</a>
            </p>
        </section>
    </main>

    <script src="assets/js/script.js" defer></script>
</body>
</html>
