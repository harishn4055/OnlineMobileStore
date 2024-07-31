<?php
session_start();
require_once 'includes/db.php';

include 'includes/header1.php'; 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];  // Assuming user_id is stored in the session

function getOrCreateCartId($userId) {
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);  // Connection error handling
    }

    $stmt = $conn->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['cart_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $conn->insert_id;
    }
}

// Calculate total cart amount
$stmt = $conn->prepare("SELECT SUM(p.price * ci.quantity) AS total FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.cart_id = ?");
$cartId = getOrCreateCartId($userId); // Fetch or create cart ID
$stmt->bind_param("i", $cartId);
$stmt->execute();
$result = $stmt->get_result();
$total = $result->num_rows > 0 ? $result->fetch_assoc()['total'] : 0;

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zip = htmlspecialchars($_POST['zip']);
    $paymentType = $_POST['payment_type']; // Payment type: card or cash

    // Process order based on payment type
    if ($paymentType === 'cash') {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, status) SELECT ?, product_id, quantity, 'completed' FROM cart_items WHERE cart_id = ?");
        $stmt->bind_param("ii", $userId, $cartId);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->bind_param("i", $cartId);
        $stmt->execute();

        echo "<script>alert('Thank you for your order, $name! Your order has been placed successfully.'); window.location.href='order_confirmation.php';</script>";
        exit();
    }
    elseif ($paymentType === 'card') {
        echo "<script>alert('Online payments are under development, please use Cash On Delivery'); window.location.href='checkout.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Checkout</h1>
    <h3>Total Amount: $<?php echo number_format($total, 2); ?></h3>
    <form method="POST" action="checkout.php">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="form-group">
            <label for="zip">Zip Code:</label>
            <input type="text" class="form-control" id="zip" name="zip" required>
        </div>
        <div class="form-group">
            <label for="payment_type">Payment Type:</label>
            <select name="payment_type" class="form-control" required>
                <option value="card">Credit Card</option>
                <option value="cash">Cash on Delivery</option>
            </select>
        </div>
        <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php include 'includes/footer.php'; ?>