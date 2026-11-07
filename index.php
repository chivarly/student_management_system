
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

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <main class="auth-card">
        <h1>Student Management System</h1>
        <h2>Login</h2>
        <p class="auth-description">
            Sign in to access your account.
        </p>

        <?php if (isset($_GET["registered"]) && $_GET["registered"] === "1"): ?>

            <p style="color: green;">
                Registration successful! You can now log in to your account.
            </p>

        <?php endif; ?>

        <?php if ($error !== ""): ?>
            <p style="color: red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <label>Username:</label><br>
            <input
                type="text"
                name="username"
                value="<?= htmlspecialchars($username) ?>"
                required
            >
            <br><br>

            <label>Password:</label><br>
            <input
                type="password"
                name="password"
                required
            >
            <br><br>

            <button type="submit">Login</button>

        </form>
        
        <p class="auth-footer">
            Don't have an account?
            <a href="register.php">Sign up now</a>
        </p>
    </main>
</body>
</html>
