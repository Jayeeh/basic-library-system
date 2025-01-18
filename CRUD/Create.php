<?php 

include '../indexBody/Header.php'; 

// Initialize variables
$title = $author = $isbn = $genre = $publication_year = $total_copies = $available_copies = $status = $added_date = $location_shelf_number = '';
$title_error = $author_error = $isbn_error = $genre_error = $publication_year_error = $total_copies_error = $available_copies_error = $status_error = $added_date_error = $location_shelf_number_error = '';
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $publication_year = $_POST['publication_year'] ?? '';
    $total_copies = $_POST['total_copies'] ?? '';
    $available_copies = $_POST['available_copies'] ?? '';
    $status = $_POST['status'] ?? '';
    $added_date = $_POST['added_date'] ?? '';
    $location_shelf_number = $_POST['location_shelf_number'] ?? '';

    // Validate fields
    $errors = [
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

    foreach ($errors as $key => $value) {
        if ($value) {
            ${$key . '_error'} = $value;
            $error = true;
        }
    }
    

    if (!$error) {
        include '../Database/server.php';
        $stmt = $connection->prepare("INSERT INTO books (title, author, isbn, genre, publication_year, total_copies, available_copies, status, added_date, location_shelf_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssss', $title, $author, $isbn, $genre, $publication_year, $total_copies, $available_copies, $status, $added_date, $location_shelf_number);
        
        if ($stmt->execute()) {
            $_SESSION['book_data'] = [
                'id' => $stmt->insert_id,
                'title' => $title,
                'author' => $author,
                'isbn' => $isbn,
                'genre' => $genre,
                'publication_year' => $publication_year,
                'total_copies' => $total_copies,
                'available_copies' => $available_copies,
                'status' => $status,
                'added_date' => $added_date,
                'location_shelf_number' => $location_shelf_number
            ];
            $_SESSION['success_message'] = "Book added successfully.";
            header("location: ../index.php");
            exit;
        } else {
            error_log('Error inserting record: ' . $stmt->error);
        }
    }

}


?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadow p-4">
            <h2 class="text-center mb-4">Register</h2>
            <hr />
           
            <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">TITLE*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="title" value="<?= $title ?>">
                        <span class="text-danger"><?= $title_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">AUTHOR*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="author" value="<?= $author ?>">
                        <span class="text-danger"><?= $author_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">ISBN*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="isbn" value="<?= $isbn ?>">
                        <span class="text-danger"><?= $isbn_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">GENRE*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="genre" value="<?= $genre ?>">
                        <span class="text-danger"><?= $genre_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">PUBLICATION YEAR*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="publication_year" value="<?= $publication_year ?>">
                        <span class="text-danger"><?= $publication_year_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">TOTAL COPIES*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="total_copies" value="<?= $total_copies ?>">
                        <span class="text-danger"><?= $total_copies_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">AVAILABLE COPIES*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="available_copies" value="<?= $available_copies ?>">
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
                        <input class="form-control" type="date" name="added_date" value="<?= $added_date ?>">
                        <span class="text-danger"><?= $added_date_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">SHELF NUMBER*</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="location_shelf_number" value="<?= $location_shelf_number ?>">
                        <span class="text-danger"><?= $location_shelf_number_error ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-sm-4 col-sm-4 d-grid">
                        <button type="submit" class="btn btn-primary">Add Book</button>
                    </div>
                    <div class="col-sm-4 d-grid">
                        <a href="../index.php" class="btn btn-outline-primary">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include '../indexBody/Footer.php' ?>