<?php
require_once 'includes/db.php'; // Ensure this is the correct path to your database connection script
include 'includes/header2.php';

session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image_url = $_POST['image_url']; // Capture the image URL from the form

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $name, $description, $price, $stock, $image_url); // Include the image URL in the parameters
    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully'); window.location = 'manage_products.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta viewport="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Product</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="form-group">
            <label for="image_url">Image URL:</label>
            <input type="text" class="form-control" id="image_url" name="image_url" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</div>
</body>
</html>
<?php include 'includes/footer2.php'; ?>