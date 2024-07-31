<?php
session_start();
require_once 'includes/db.php'; // Ensure the database connection is included
include 'includes/header1.php'; // Ensure this path is correct and file exists

// Check for an id in the query string
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, description, price, image_url, stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-warning'>Product not found.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning'>No product specified.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .image-container {
            width: 50%; /* Adjust the width as needed */
            height: 400px; /* Fixed height for the image */
            overflow: hidden;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .price-tag {
            font-size: 1.5rem;
            color: #007BFF;
            font-weight: bold;
        }
        .stock-info {
            font-weight: bold;
            color: <?php echo $product['stock'] > 0 ? '#28a745' : '#dc3545'; ?>;
        }
        .btn-primary {
            background-color: #007BFF;
            border-color: #007BFF;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="image-container">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="image img-fluid">
            </div>
        </div>
        <div class="col-md-6 details">
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <p class="price-tag">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="stock-info"><?php echo $product['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?></p>
            <?php if ($product['stock'] > 0): ?>
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="form-control" style="width: 100px;">
                        <button type="submit" name="add_to_cart" class="btn btn-primary mt-3">Add to Cart</button>
                    </form>
                <?php else: ?>
                    <a href="auth/login.php" class="btn btn-primary mt-3">Add to Cart</a>
                <?php endif; ?>
            <?php else: ?>
                <button class="btn btn-secondary disabled">Out of Stock</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>