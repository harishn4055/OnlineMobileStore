<?php
session_start();
require_once 'includes/db.php';

// Check user authentication and authorization
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Optional: Perform additional validation here

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User added successfully.";
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }

    header("Location: manage_users.php");
    exit();
}
?>