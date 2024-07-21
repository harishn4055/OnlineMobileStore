<?php
session_start();
require_once 'includes/db.php';
include 'includes/header2.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT o.id, u.username, p.name AS product_name, o.quantity, o.order_date, o.status FROM orders o JOIN users u ON o.user_id = u.id JOIN products p ON o.product_id = p.id ORDER BY o.order_date DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);  // Clear the message so it doesn't persist
            }
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);  // Clear the error message so it doesn't persist
            }
            ?>
    <h1>Manage Orders</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['order_date']) ?></td>
                <td>
                    <form action="update_order_status.php" method="post">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <select name="status" class="form-control">
                            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="shipped" <?= $row['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $row['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                        </select>
                        <button type="submit" class="btn btn-info mt-1">Update</button>
                    </form>
                </td>
                <td>
                    <a href="delete_order.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?');">Delete/Cancel</a>
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