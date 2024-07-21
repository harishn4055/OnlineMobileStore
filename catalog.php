<?php 
include 'includes/header.php'; 
include 'includes/db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Product Catalog</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="' . htmlspecialchars($row["image_url"]) . '" class="card-img-top" alt="' . htmlspecialchars($row["name"]) . '">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
                                <p class="card-text">$' . number_format($row["price"], 2) . '</p>
                                <a href="auth/login.php" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                      </div>';
            }
        } else {
            echo '<p>No products found.</p>';
        }
        $conn->close();
        ?>
    </div>
</div>
</body>
<?php include 'includes/footer.php'; ?>
</html>