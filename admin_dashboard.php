<?php include 'includes/header2.php';
session_start();  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <div class="list-group">
            <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="manage_orders.php" class="list-group-item list-group-item-action">Manage Orders</a>
            <a href="manage_products.php" class="list-group-item list-group-item-action">Manage Products</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'includes/footer2.php'; ?>