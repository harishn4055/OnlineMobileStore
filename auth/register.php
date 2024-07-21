<?php
include '../includes/db.php'; // Adjust the path as needed
include '../includes/header.php'; // Include the common header to maintain consistency

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if user or email exists
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $result = $checkUser->get_result();
    if ($result->num_rows > 0) {
        echo "Username or Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $checkUser->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Adjust path as needed -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-3">Register</h1>
    <form action="register.php" method="post" class="needs-validation" novalidate>
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
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<br><br><br><br>
<?php include '../includes/footer.php'; ?> <!-- Ensure this path is correct -->
</body>
</html>