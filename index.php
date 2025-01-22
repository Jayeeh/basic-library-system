<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: intro.php");
    exit();
}

include 'indexBody/Header.php';
?>

<style>
    .navbar-nav .nav-link {
        color: white; /* Change this to your preferred text color */
    }

    .navbar-nav .nav-link:hover {
        background-color: #c19a6b; /* Darker brown on hover */
        border-radius: 5px;
    }
</style>

<body>

<?php include 'indexBody/Navigation.php'; ?>

<?php include 'indexBody/Book_Viewer.php'; ?>

<?php include 'indexBody/Footer.php'; ?>
