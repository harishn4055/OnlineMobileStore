<?php
session_start();
require_once 'includes/db.php'; // Database connection file
include 'includes/header2.php';
// Fetch all products
$stmt = $conn->prepare("SELECT id, name, description, price, stock FROM products ORDER BY name");
$stmt->execute();
$products = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta viewport="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Product Listings</h2>
    <a href="add_product.php" class="btn btn-success mb-2">Add New Product</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['stock'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'includes/footer2.php'; ?>