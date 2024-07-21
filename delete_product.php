<?php
session_start();
require_once 'includes/db.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Invalid Product ID";
    header("Location: manage_products.php");
    exit();
}

$productId = intval($_GET['id']);

// Check for dependent orders
$stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE product_id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($count);
$stmt->fetch();

if ($count > 0) {
    $_SESSION['error'] = "Cannot delete product: it is referenced in existing orders.";
    header("Location: manage_products.php");
    exit();
}

// If no dependent orders, proceed with deletion
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
if ($stmt->execute()) {
    $_SESSION['message'] = "Product deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete product: " . $conn->error;
}
$stmt->close();
$conn->close();
header("Location: manage_products.php");
exit();
?>