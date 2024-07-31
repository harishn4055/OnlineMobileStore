<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['cancel_reason'])) {
    $orderId = $_POST['order_id'];
    $cancelReason = htmlspecialchars($_POST['cancel_reason']);
    
    // Update the order status to 'canceled' and store the cancel reason
    $stmt = $conn->prepare("UPDATE orders SET status = 'canceled', cancel_reason = ? WHERE id = ?");
    $stmt->bind_param("si", $cancelReason, $orderId);
    $stmt->execute();

    // Redirect to the orders page with a success message
    $_SESSION['message'] = "Your cancellation is in progress. Our team will get back to you in 24hrs.";
    header("Location: order_confirmation.php");
    exit();
} else {
    header("Location: order_confirmation.php");
    exit();
}
?>