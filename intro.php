<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is already logged in, redirect to index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'IntroBody/Header.php';
include 'IntroBody/Navigation.php';
include 'IntroBody/Register.php';
?>

<script src="./JScript/Register.js"></script>

<?php include 'IntroBody/Footer.php' ?>