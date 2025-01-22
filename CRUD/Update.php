<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Book Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<?php 

include '../Database/server.php';

// Initialize variables
$title = $author = $isbn = $genre = $publication_year = $total_copies = $available_copies = $status = $added_date = $title_error = $author_error = $isbn_error = $genre_error = $publication_year_error = $total_copies_error = $available_copies_error = $status_error = $added_date_error = $location_shelf_number_error = '';
$successMessage = "";

// Check if the form has submitted via GET method
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the id parameter is set in the URL
    if (!isset($_GET['id'])) {
        header('location: index.php'); // Redirect to index if no ID is provided
        exit;
    }

    $id = intval($_GET['id']); // Get the ID from the URL and convert it to an integer

    // Prepare an SQL statement to fetch the client's data from the database
    $sql = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the client's data
    if ($row = $result->fetch_assoc()) {
        // Populate the form fields with the client's data
        $title = $row['title'];
        $author = $row['author'];
        $isbn = $row['isbn'];
        $genre = $row['genre'];
        $publication_year = $row['publication_year'];
        $total_copies = $row['total_copies'];
        $available_copies = $row['available_copies'];
        $status = $row['status'];
        $added_date = $row['added_date'];
        $location_shelf_number = $row['location_shelf_number'];
    } else {
        header('location: index.php'); // Redirect if no client is found
        exit;
    }

    $stmt->close();

} else {
    
    $id = intval($_GET['id']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $genre = trim($_POST['genre']);
    $publication_year = trim($_POST['publication_year']);
    $total_copies = trim($_POST['total_copies']);
    $available_copies = trim($_POST['available_copies']);
    $status = trim($_POST['status']);
    $added_date = trim($_POST['added_date']);
    $location_shelf_number = trim($_POST['location_shelf_number']);

    $error = [
        'title' => empty($title) ? "Title is required." : '',
        'author' => empty($author) ? "Author is required." : '',
        'isbn' => empty($isbn) ? "ISBN is required." : '',
        'genre' => empty($genre) ? "Genre is required." : '',
        'publication_year' => empty($publication_year) ? "Publication year is required." : '',
        'total_copies' => empty($total_copies) ? "Total copies is required." : '',
        'available_copies' => empty($available_copies) ? "Available copies is required." : '',
        'status' => empty($status) ? "Status is required." : '',
        'added_date' => empty($added_date) ? "Added date is required." : '',
        'location_shelf_number' => empty($location_shelf_number) ? "Shelf number is required." : ''
    ];

    $hasErrors  = false;
    foreach ($error as $key => $value) {
        if ($value) {
            ${$key . '_error'} = $value;
            $hasErrors = true;
        }
    }

    if (!$hasErrors) { 
        // Prepare the SQL statement to update the client's data
        $stmt = $connection->prepare("UPDATE books SET title = ?, author = ?, isbn = ?, genre = ?, publication_year = ?, total_copies = ?, available_copies = ?, status  = ?, added_date = ?, location_shelf_number = ? WHERE book_id = ?");
        $stmt->bind_param("ssssssssssi", $title, $author, $isbn, $genre, $publication_year, $total_copies, $available_copies, $status, $added_date, $location_shelf_number, $id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $successMessage = "Client updated succesfully";
            header("location: ../index.php");
            exit;
        } else {
            error_log("SQL execution failed: " . $stmt->error);
            $errorMessage[] = "Error: " . $stmt->error;;
        }
        $stmt->close();
    }

}

?>

<div class="container py-5" style="margin-bottom: 100px;">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadow p-4">
            <h2 class="text-center mb-4">Update Book Information</h2>
            <hr />
           
            <form method="post">

                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Hidden input for ID -->

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">TITLE*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="title" value="<?= htmlspecialchars($title); ?>">
                        <span class="text-danger"><?= $title_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">AUTHOR*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="author" value="<?= htmlspecialchars($author); ?>">
                        <span class="text-danger"><?= $author_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">ISBN*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="isbn" value="<?= htmlspecialchars($isbn); ?>">
                        <span class="text-danger"><?= $isbn_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">GENRE*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="genre" value="<?= htmlspecialchars($genre); ?>">
                        <span class="text-danger"><?= $genre_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">PUBLICATION YEAR*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="publication_year" value="<?= htmlspecialchars($publication_year); ?>">
                        <span class="text-danger"><?= $publication_year_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">TOTAL COPIES*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="total_copies" value="<?= htmlspecialchars($total_copies); ?>">
                        <span class="text-danger"><?= $total_copies_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">AVAILABLE COPIES*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="available_copies" value="<?= htmlspecialchars($available_copies); ?>">
                        <span class="text-danger"><?= $available_copies_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">STATUS*</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="status">
                            <option value="Available" <?= ($status == 'Available') ? 'selected' : ''; ?>>Available</option>
                            <option value="Borrowed" <?= ($status == 'Borrowed') ? 'selected' : ''; ?>>Borrowed</option>
                        </select>
                        <span class="text-danger"><?= $status_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">ADDED DATE*</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="date" name="added_date" value="<?= htmlspecialchars($added_date); ?>">
                        <span class="text-danger"><?= $added_date_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">SHELF NUMBER*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="location_shelf_number" value="<?= htmlspecialchars($location_shelf_number); ?>">
                        <span class="text-danger"><?= $location_shelf_number_error ?></span>
                    </div>
                </div>

                <?php 
                // Display success message if any
                if (!empty($successMessage)) {
                    echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                    </div>
                    ";
                }
                ?>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="../index.php" role="button">Cancel</a>
                    </div>
                </div>
                
            </form>

        </div>
    </div>
</div>

</body>
</html>