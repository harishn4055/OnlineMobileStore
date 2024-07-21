<?php
session_start();
require_once 'includes/db.php';

include 'includes/header1.php'; 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch orders along with product details
$stmt = $conn->prepare("SELECT o.id, o.status, o.order_date, p.name, p.price, o.quantity, (p.price * o.quantity) AS total_price FROM orders o JOIN products p ON o.product_id = p.id WHERE o.user_id = ? ORDER BY o.order_date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Your Orders</h1>
    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td>$<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= date('F d, Y', strtotime($row['order_date'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php include 'includes/footer.php'; ?>