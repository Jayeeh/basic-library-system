<?php

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ./intro.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg" style="background-color: #d2b48c;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">My Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                
                <!-- Books Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="booksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Books Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="booksDropdown">
                        <li><a class="dropdown-item" href="./CRUD/Create.php">Add New Book</a></li>
                        <li><a class="dropdown-item" href="#">View All Books</a></li>
                        <li><a class="dropdown-item" href="#">Search Book</a></li>
                        <li><a class="dropdown-item" href="#">Manage Inventory</a></li>
                    </ul>
                </li>

                <!-- Member Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="membersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Member Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="membersDropdown">
                        <li><a class="dropdown-item" href="#">Register New Member</a></li>
                        <li><a class="dropdown-item" href="#">View Members</a></li>
                        <li><a class="dropdown-item" href="#">Update Member Info</a></li>
                    </ul>
                </li>

                <!-- Borrowing Operations Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="borrowingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Borrowing Operations
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="borrowingDropdown">
                        <li><a class="dropdown-item" href="#">New Borrowing</a></li>
                        <li><a class="dropdown-item" href="#">Return Book</a></li>
                        <li><a class="dropdown-item" href="#">View Active Borrowings</a></li>
                    </ul>
                </li>

                <!-- Reports & Statistics Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Reports & Statistics
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                        <li><a class="dropdown-item" href="#">Generate Reports</a></li>
                        <li><a class="dropdown-item" href="#">View Statistics</a></li>
                        <li><a class="dropdown-item" href="#">Export Data</a></li>
                    </ul>
                </li>
            </ul>

            <!-- User Welcome and Logout Section -->
            <div class="d-flex align-items-center">
                <span class="text-dark me-3">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                <a href="./IntroBody/logout.php" class="btn btn-outline-dark">Logout</a>
            </div>
        </div>
    </div>
</nav>