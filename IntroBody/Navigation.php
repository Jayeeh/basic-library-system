<?php
/**
 * Navigation Bar Component
 * 
 * This component displays the top navigation bar with:
 * - Library logo/title
 * - Login form (when not logged in)
 * - Welcome message and logout button (when logged in)
 * - Error messages from login attempts
 */

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg fixed-top" style="
    background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('./library-image.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
">
    <div class="container-fluid">
        <div class="library-section me-auto">
            <h3 class="text-white" style="font-family: Montserrat; font-size: 28px; font-weight: bold;">LIBRARY</h3>
        </div>
        <div class="login-section">
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show me-2" role="alert">
                    <?php 
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Logged in state -->
                <div class="d-flex align-items-center">
                    <span class="text-white me-3">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                    <a href="./IntroBody/logout.php" class="btn btn-outline-light">Logout</a>
                </div>
            <?php else: ?>
                <!-- Login form -->
                <form action="./IntroBody/login.php" method="post" class="d-flex">
                    <input type="text" name="username" class="form-control me-2" placeholder="Username" required>
                    <input type="password" name="password" class="form-control me-2" placeholder="Password" required>
                    <button type="submit" class="btn btn-outline-light me-2">Login</button>
                    <button type="button" id="navRegisterBtn" class="btn btn-outline-light">Register</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>