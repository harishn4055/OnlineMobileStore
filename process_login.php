<?php
session_start();
require_once 'includes/db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        header("Location: admin_dashboard.php");
    } else {
        $_SESSION['error'] = "Invalid password";
        header("Location: admin_login.php");
    }
} else {
    $_SESSION['error'] = "User not found";
    header("Location: admin_login.php");
}
exit();
?>