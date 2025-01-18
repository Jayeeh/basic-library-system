<?php
/**
 * Login Handler Script
 * 
 * This script handles user authentication for the library management system.
 * It validates user credentials, manages sessions, and handles login errors.
 */

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../Database/server.php';

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = false;

    // Basic input validation
    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Username and password are required";
        $error = true;
    }

    if (!$error) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $connection->prepare("SELECT id, username, password, fullname FROM administrator WHERE username = ?");
        
        if ($stmt) {
            // Bind parameters and execute query
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                // User found, verify password
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['password'])) {
                    // Set session variables on successful login
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['is_admin'] = true;
                    
                    // Clean up
                    $stmt->close();
                    $connection->close();
                    
                    // Redirect to dashboard
                    header("Location: ../index.php");
                    exit();
                } else {
                    $_SESSION['login_error'] = "Invalid password";
                }
            } else {
                $_SESSION['login_error'] = "Username not found";
            }
            // Clean up database resources
            $stmt->close();
        } else {
            $_SESSION['login_error'] = "Database error: " . $connection->error;
        }
    }
    
    // Close database connection
    $connection->close();
    
    // Redirect back with error message
    header("Location: ../intro.php");
    exit();
}
?>
