<?php
session_start(); // Ensure session starts at the top of the script

require_once 'includes/db.php'; // Correct path to your DB connection file

// Redirect to the login page if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Function to get or create a user's cart ID
function getOrCreateCartId($userId) {
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Connection error handling
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
        return $stmt->insert_id;
    }
}

// Add an item to the cart and decrease stock
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $userId = $_SESSION['user_id'];
    $cartId = getOrCreateCartId($userId);

    // Prepare to insert item into cart and update stock
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
        $stmt->bind_param("iiii", $cartId, $productId, $quantity, $quantity);
        $stmt->execute();


        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $productId);
        $stmt->execute();

        $conn->commit();
        // Check if update was successful
        if ($stmt->affected_rows > 0) {
            $_SESSION['feedback'] = "Item added to cart successfully.";
        } else {
            $_SESSION['feedback'] = "Failed to add item to cart.";
        }
        
    } catch (Exception $e) {
        $conn->rollback();
        echo "Failed to add item to cart.";
    }
}

// Remove an item from the cart and increase stock
if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id'];
    $cartId = getOrCreateCartId($_SESSION['user_id']);

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $cartId, $productId);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE products SET stock = stock + 1 WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        $conn->commit();
        $_SESSION['feedback'] = "Item removed from cart.";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['feedback'] = "Failed to remove item from cart.";
    }
    header("Location: cart.php");
    exit();
}

// Display cart items and calculate total
function displayCartItems($cartId) {
    global $conn;
    $stmt = $conn->prepare("SELECT p.name, ci.quantity, p.price, ci.product_id FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.cart_id = ?");
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();

    $total = 0;
    echo "<table class='table'>";
    echo "<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th><th>Action</th></tr>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $lineTotal = $row['quantity'] * $row['price'];
            $total += $lineTotal;
            echo "<tr><td>" . htmlspecialchars($row['name']) . "</td><td>" . $row['quantity'] . "</td><td>$" . number_format($row['price'], 2) . "</td><td>$" . number_format($lineTotal, 2) . "</td>";
            echo "<td><form method='post'><input type='hidden' name='product_id' value='" . $row['product_id'] . "'><input type='submit' name='remove_from_cart' value='Remove' class='btn btn-danger'></form></td></tr>";
        }
        echo "<tr><td colspan='4' class='text-right'><strong>Total:</strong> $" . number_format($total, 2) . "</td>";
        echo "<td><a href='checkout.php' class='btn btn-success'>Proceed to Checkout</a></td></tr>";
    } else {
        echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
    }
    echo "</table>";
}


include 'includes/header1.php'; // Make sure this path is correct and file exists
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Your Shopping Cart</h1>
    <?php
    if (isset($_SESSION['feedback'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['feedback'] . "</div>";
        unset($_SESSION['feedback']);
    }
    $cartId = getOrCreateCartId($_SESSION['user_id']);
    displayCartItems($cartId);
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>

