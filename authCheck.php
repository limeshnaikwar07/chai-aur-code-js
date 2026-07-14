<?php
/* ============================================================
   auth_check.php
   ------------------------------------------------------------
   Include this at the very top of every protected USER page
   (before any HTML output):

       require_once 'auth_check.php';

   It assumes your login script sets:
       $_SESSION['user_id']
       $_SESSION['user_name']
   on successful login. Adjust the session keys below if your
   login.php uses different names.
   ============================================================ */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* Convenience variables available to any page that includes this file */
$loggedInUserId   = $_SESSION['user_id'];
$loggedInUserName = $_SESSION['user_name'] ?? 'User';