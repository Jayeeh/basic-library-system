<?php

// Database configuration
$servername = "localhost"; // The database server name
$username = "root";         // The database username
$password = "";             // The database password
$database = "library_books"; // The name of the database to connect to

// Create a connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    // Handle connection error
    error_log("Connection failed: " . $connection->connect_error);
    throw new Exception("Database connection failed.");
}

$connection->set_charset("utf8");
