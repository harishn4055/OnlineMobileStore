<?php
session_start();
require_once 'includes/db.php';

// Security Check: Ensure that only authenticated admins can delete users
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);  // Get the user ID and ensure it's an integer

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete user.";
    }
}

// Redirect back to the manage users page
header("Location: manage_users.php");
exit();
?>