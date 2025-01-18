<?php

// Check if the id parameter is set in the URL query string
if (isset($_GET['id'])) {

    //Retrieve the id from the query string and sanitize it.
    $book_id = intval($_GET['id']); // Convert to integer to prevent SQL injection

    // Include the database connection file to establish a connection to the database
    include '../Database/server.php';

    // Prepare the SQL DELETE query to remove the client with the specified ID from the 'clients' table
    $stmt = $connection->prepare('DELETE FROM books WHERE book_id = ?');
    $stmt->bind_param('i', $book_id); // Bind the parameter to the statement

    // Execute the DELETE query using the database connection
    if ($stmt->execute()) {
        // Optionally, you can set a success message in the session or log it
        $_SESSION['success_message'] = "Book deleted successfully.";
    } else {
        // Handle the error appropriately 
        error_log('Error deleting record: ' . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}

header('Location: ../index.php');
exit;