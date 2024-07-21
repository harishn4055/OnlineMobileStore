<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $orderId = intval($_GET['id']); // Ensure the id is an integer

    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Order deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete order.";
    }

    header("Location: manage_orders.php");
    exit();
}
?>