<?php
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

mysqli_set_charset($conn, "utf8mb4");