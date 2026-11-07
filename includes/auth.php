
<?php

// Add security headers to HTTP responses
header("X-Content-Type-Options: nosniff");

header("X-Frame-Options: DENY");

header("Referrer-Policy: strict-origin-when-cross-origin");

header("Permissions-Policy: camera=(), microphone=(), geolocation=()");

// Configure and start a secure session
if (session_status() === PHP_SESSION_NONE) {

    // Prevent session ID adoption from untrusted sources
    ini_set("session.use_strict_mode", "1");

    // Allow sessions to use cookies only
    ini_set("session.use_only_cookies", "1");

    // Prevent session IDs from appearing in URLs
    ini_set("session.use_trans_sid", "0");

    // Detect whether the website is using HTTPS
    $isHttps = (
        !empty($_SERVER["HTTPS"]) &&
        $_SERVER["HTTPS"] !== "off"
    );

    // Configure session cookie security
    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "secure" => $isHttps,
        "httponly" => true,
        "samesite" => "Lax"
    ]);

    // Start the session
    session_start();
}

// Check whether the user is logged in
function requireLogin(): void {

    if (!isset($_SESSION["user_id"])) {
        header("Location: ../index.php");
        exit;
    }
}

// Check whether the logged-in user is an admin
function requireAdmin(): void {

    requireLogin();

    if (($_SESSION["role"] ?? "") !== "admin") {
        http_response_code(403);
        exit("Access denied. Admin privileges are required.");
    }
}

// Generate a CSRF token
function generateCsrfToken(): string {

    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    }

    return $_SESSION["csrf_token"];
}

// Verify the submitted CSRF token
function verifyCsrfToken(?string $token): bool {

    if (
        empty($_SESSION["csrf_token"]) ||
        empty($token)
    ) {
        return false;
    }

    return hash_equals($_SESSION["csrf_token"], $token);
}
