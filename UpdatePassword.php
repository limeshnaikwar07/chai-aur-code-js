<?php
/* ============================================================
   update_password.php
   ------------------------------------------------------------
   Called via fetch() from User_dashboard.php's password modal.
   Expects JSON POST body:
     { "current_password": "...", "new_password": "..." }
   Returns JSON: { "success": bool, "message": "..." }

   ASSUMED SCHEMA — rename if your actual table differs:
     users (id, password_hash)
   ============================================================ */
/* ============================================================
   db.php
   ------------------------------------------------------------
   Shared database connection. Include this at the very top of
   every page that needs DB access:

       require_once 'db.php';

   UPDATE THESE CREDENTIALS BEFORE DEPLOYING TO YOUR HOSTING:
   most shared hosts (e.g. cPanel) give you a specific DB host,
   username, password, and database name — localhost/root/""
   only works on a local XAMPP/WAMP setup.
   ============================================================ */

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "ebankingdb";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    // In production, log this instead of exposing details to users.
    die("Database Connection Failed: " . mysqli_connect_error());
}
 require_once 'db.php';

mysqli_set_charset($conn, "utf8mb4");
require_once 'auth_check.php';
require_once 'db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$currentPassword = $input['current_password'] ?? '';
$newPassword     = $input['new_password'] ?? '';

if ($currentPassword === '' || $newPassword === '') {
    echo json_encode(['success' => false, 'message' => 'Both fields are required.']);
    exit;
}

if (strlen($newPassword) < 8) {
    echo json_encode(['success' => false, 'message' => 'New password must be at least 8 characters.']);
    exit;
}

/* Fetch the current password hash for this user */
$stmt = mysqli_prepare($conn, "SELECT password_hash FROM users WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $loggedInUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row || !password_verify($currentPassword, $row['password_hash'])) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
    exit;
}

/* Update to the new hashed password */
$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "UPDATE users SET password_hash = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "si", $newHash, $loggedInUserId);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode([
    'success' => $success,
    'message' => $success ? 'Password updated successfully!' : 'Could not update password. Please try again.'
]);