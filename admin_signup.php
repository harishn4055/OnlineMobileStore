<?php
require_once 'includes/db.php';  // Ensure this file correctly sets up a connection to your database
include 'includes/header2.php';
session_start();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'editor';  // Default role

    // Validate inputs
    if (empty($username) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
        $message = "Please provide valid inputs.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new admin into the database
        $stmt = $conn->prepare("INSERT INTO admins (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

        if ($stmt->execute()) {
            $message = "Admin registered successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Admin Signup Form</h2>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info">
            <?= $message ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role">
                <option value="editor">Editor</option>
                <option value="moderator">Moderator</option>
                <option value="superadmin">Superadmin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'includes/footer2.php'; ?>