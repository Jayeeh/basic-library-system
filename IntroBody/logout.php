<?php
/**
 * Logout Handler
 * 
 * This script handles user logout by destroying the session
 * and redirecting to the login page.
 */

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../intro.php");
exit();
?>
