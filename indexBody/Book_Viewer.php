<?php
include 'Database/server.php';

// Fetch summary statistics
$stats = [
    'total_books' => 0,
    'available_books' => 0,
    'borrowed_books' => 0,
    'total_members' => 0,
    'active_borrowings' => 0,
    'overdue_books' => 0
];

// Get total and available books
$sql = "SELECT 
    COUNT(*) as total_books,
    SUM(available_copies) as available_books,
    SUM(total_copies - available_copies) as borrowed_books
FROM books";
$result = $connection->query($sql);
if ($row = $result->fetch_assoc()) {
    $stats['total_books'] = $row['total_books'];
    $stats['available_books'] = $row['available_books'];
    $stats['borrowed_books'] = $row['borrowed_books'];
}
?>

<!-- Dashboard Summary Cards -->
<div class="container-fluid mb-4 mt-5">
    <div class="row g-3">
        <!-- Total Books Card -->
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Books</h6>
                            <h2 class="mt-2 mb-0"><?php echo $stats['total_books']; ?></h2>
                        </div>
                        <i class="fas fa-book fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Books Card -->
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Available Books</h6>
                            <h2 class="mt-2 mb-0"><?php echo $stats['available_books']; ?></h2>
                        </div>
                        <i class="fas fa-book-open fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowed Books Card -->
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Borrowed Books</h6>
                            <h2 class="mt-2 mb-0"><?php echo $stats['borrowed_books']; ?></h2>
                        </div>
                        <i class="fas fa-hand-holding-book fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="./CRUD/Create.php" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Add New Book
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-success w-100">
                                <i class="fas fa-user-plus me-2"></i>New Member
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-info w-100 text-white">
                                <i class="fas fa-book-reader me-2"></i>New Borrowing
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-warning w-100">
                                <i class="fas fa-sync-alt me-2"></i>Return Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="container-fluid mb-4">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Search & Filter Books</h5>
        </div>
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by Title or Author">
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">Genre</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                        <!-- Add more genres -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option value="">Status</option>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="reset" class="btn btn-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Books Table -->
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Book Inventory</h5>
                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                    <i class="fas fa-search me-1"></i> Search Options
                </button>
            </div>
        </div>
        <div class="collapse show" id="searchCollapse">
            <div class="card-body border-bottom">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Title</label>
                        <input type="text" name="search_title" class="form-control" 
                               value="<?php echo isset($_GET['search_title']) ? htmlspecialchars($_GET['search_title']) : ''; ?>"
                               placeholder="Search by title...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Author</label>
                        <input type="text" name="search_author" class="form-control"
                               value="<?php echo isset($_GET['search_author']) ? htmlspecialchars($_GET['search_author']) : ''; ?>"
                               placeholder="Search by author...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Genre</label>
                        <input type="text" name="search_genre" class="form-control"
                               value="<?php echo isset($_GET['search_genre']) ? htmlspecialchars($_GET['search_genre']) : ''; ?>"
                               placeholder="Search by genre...">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Book ID</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Author</th>
                            <th class="text-center">ISBN</th>
                            <th class="text-center">Genre</th>
                            <th class="text-center">Publication Year</th>
                            <th class="text-center">Total Copies</th>
                            <th class="text-center">Available Copies</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Added Date</th>
                            <th class="text-center">Location/Shelf Number</th>
                            <th class="text-center">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Initialize the WHERE clause
                        $where_conditions = array();
                        $params = array();
                        $types = "";

                        // Add search conditions if provided
                        if (!empty($_GET['search_title'])) {
                            $where_conditions[] = "title LIKE ?";
                            $params[] = "%" . $_GET['search_title'] . "%";
                            $types .= "s";
                        }
                        if (!empty($_GET['search_author'])) {
                            $where_conditions[] = "author LIKE ?";
                            $params[] = "%" . $_GET['search_author'] . "%";
                            $types .= "s";
                        }
                        if (!empty($_GET['search_genre'])) {
                            $where_conditions[] = "genre LIKE ?";
                            $params[] = "%" . $_GET['search_genre'] . "%";
                            $types .= "s";
                        }

                        // Construct the SQL query
                        $sql = "SELECT * FROM books";
                        if (!empty($where_conditions)) {
                            $sql .= " WHERE " . implode(" AND ", $where_conditions);
                        }

                        // Prepare and execute the query
                        $stmt = $connection->prepare($sql);

                        if ($stmt) {
                            if (!empty($params)) {
                                $stmt->bind_param($types, ...$params);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>{$row['book_id']}</td>
                                        <td>{$row['title']}</td>
                                        <td>{$row['author']}</td>
                                        <td>{$row['isbn']}</td>
                                        <td>{$row['genre']}</td>
                                        <td>{$row['publication_year']}</td>
                                        <td>{$row['total_copies']}</td>
                                        <td>{$row['available_copies']}</td>
                                        <td>{$row['status']}</td>
                                        <td>{$row['added_date']}</td>
                                        <td>{$row['location_shelf_number']}</td>
                                        <td>
                                            <div class='btn-group' role='group'>
                                                <a class='btn btn-primary btn-sm' href='./CRUD/Update.php?id={$row['book_id']}'>
                                                    <i class='fas fa-edit'></i> Edit
                                                </a>
                                                <a class='btn btn-danger btn-sm' href='./CRUD/Delete.php?id={$row['book_id']}'>
                                                    <i class='fas fa-trash-alt'></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='12' class='text-center'>No records found.</td></tr>";
                            }
                            $stmt->close();
                        } else {
                            echo "<tr><td colspan='12' class='text-center text-danger'>Error: " . $connection->error . "</td></tr>";
                        }
                        $connection->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Custom CSS for dashboard -->
<style>
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}
.card-header {
    border-bottom: none;
    background: linear-gradient(to right, #f8f9fc, #ffffff);
}
.table th {
    font-weight: 500;
}
.btn-group {
    gap: 0.25rem;
}
#searchCollapse {
    transition: all 0.3s ease-in-out;
}
</style>