<?php
include 'includes/header1.php';


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /auth/login.php");
    exit();
}

require_once 'includes/db.php';

// Retrieve user input for search and sorting
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%%';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default sorting order
$validSortOrders = ['asc', 'desc'];

// Validate sort order
if (!in_array($sortOrder, $validSortOrders)) {
    $sortOrder = 'asc';
}

// Prepare SQL statement with search and sorting
$sql = "SELECT id, name, description, price, image_url FROM products WHERE name LIKE ? ORDER BY price $sortOrder";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $search);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <!-- Search and Sorting Form -->
    <form action="" method="GET" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-control">
                    <option value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : ''; ?>>Price Low to High</option>
                    <option value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : ''; ?>>Price High to Low</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </form>
        <!-- Product Display Section -->
        <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($product = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                            <a class="btn btn-primary" href="product_detail.php?id=<?php echo $product['id']; ?>">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No products found. Please adjust your search criteria.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>

