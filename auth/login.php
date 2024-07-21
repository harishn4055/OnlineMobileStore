<?php

include '../includes/db.php'; // Adjust the path as needed
include '../includes/header.php'; // Ensure this path is correct and it points to the file where your header and its styles are defined
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];  // Set user_id
            $_SESSION['username'] = $username;  // Set username for easy access
            $_SESSION['logged_in'] = true;      // Important: Set a logged-in flag
            header("Location: ../homepage.php");  // Redirect to home page
            exit();  // Don't forget to call exit after header redirection
        } else {
            $login_error = "Invalid password.";
        }
    } else {
        $login_error = "No user found with that username.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Ensure the path to the CSS file is correct -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-3">Login</h1>
    <?php if (!empty($login_error)) echo "<div class='alert alert-danger'>$login_error</div>"; ?>
    <form action="login.php" method="post" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <div class="invalid-feedback">Please enter your username.</div>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">Please enter your password.</div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
<br> <br><br> <br><br> <br><br> <br>





<?php include '../includes/footer.php'; ?> <!-- Ensure this path is correct -->

</body>
</html>