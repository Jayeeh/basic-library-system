<?php
/**
 * User Registration Handler
 * 
 * This script handles new user registration for the library management system.
 * It performs input validation, checks for duplicate emails/usernames,
 * and securely stores user information in the database.
 */

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../Database/server.php';

// Initialize error variables
$error = false;
$fullname_error = "";
$email_error = "";
$phone_error = "";
$username_error = "";
$password_error = "";

// Process registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate full name
    if (empty($fullname)) {
        $fullname_error = "Full name is required";
        $error = true;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
        $error = true;
    }

    // Check for duplicate email
    $stmt = $connection->prepare("SELECT id FROM administrator WHERE email = ?");
    if (!$stmt) {
        $_SESSION['error_message'] = "Database error: " . $connection->error;
        $error = true;
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $email_error = "Email already exists";
            $error = true;
        }
        $stmt->close();
    }

    // Validate phone number format (optional field)
    if (!empty($phone)) {  
        if (!preg_match('/^\d{11}$/', $phone)) {
            $phone_error = "Phone number must be 11 digits";
            $error = true;
        }
    }

    // Validate username
    if (empty($username)) {
        $username_error = "Username is required";
        $error = true;
    } else {
        // Check for duplicate username
        $stmt = $connection->prepare("SELECT id FROM administrator WHERE username = ?");
        if (!$stmt) {
            $_SESSION['error_message'] = "Database error: " . $connection->error;
            $error = true;
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $username_error = "Username already taken";
                $error = true;
            }
            $stmt->close();
        }
    }

    // Validate password strength
    if (strlen($password) < 6) {
        $password_error = "Password must be at least 6 characters";
        $error = true;
    }

    // Confirm passwords match
    if ($password !== $confirm_password) {
        $password_error = "Passwords do not match";
        $error = true;
    }

    // If no errors, proceed with registration
    if (!$error) {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user into database
        $stmt = $connection->prepare("INSERT INTO administrator (fullname, email, phone, username, password) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            $_SESSION['error_message'] = "Database error: " . $connection->error;
        } else {
            $stmt->bind_param("sssss", $fullname, $email, $phone, $username, $hashed_password);
            
            if (!$stmt->execute()) {
                $_SESSION['error_message'] = "Error occurred during registration: " . $stmt->error;
            } else {
                $_SESSION['success_message'] = "Registration successful!";
                
                // Clean up
                $stmt->close();
                $connection->close();
                
                header("Location: ./index.php");
                exit();
            }
            $stmt->close();
        }
    }
    
    // Close database connection
    $connection->close();
}
?>

<div class="jumbotron" style="
    background-image: url('./Images/library-image.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    background-attachment: fixed;
">
    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div id="registrationForm" class="register-form bg-dark bg-opacity-50 p-4 rounded shadow" style="display: none;">
                    <h2 class="text-white text-center mb-4">REGISTRATION</h2>
                    
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                                echo $_SESSION['error_message'];
                                unset($_SESSION['error_message']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success">
                            <?php 
                                echo $_SESSION['success_message'];
                                unset($_SESSION['success_message']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="text-white">Full Name:</label>
                            <input type="text" name="fullname" class="form-control" required>
                            <span class="text-danger"><?php echo $fullname_error; ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="text-white">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                            <span class="text-danger"><?php echo $email_error; ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="text-white">Phone Number:</label>
                            <input type="tel" name="phone" class="form-control">
                            <span class="text-danger"><?php echo $phone_error; ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="text-white">Username:</label>
                            <input type="text" name="username" class="form-control" required>
                            <span class="text-danger"><?php echo $username_error; ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="text-white">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                            <span class="text-danger"><?php echo $password_error; ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="text-white">Confirm Password:</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                            <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>