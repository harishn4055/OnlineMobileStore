<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Order status updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update order status.";
    }

    header("Location: manage_orders.php");
    exit();
}
?>