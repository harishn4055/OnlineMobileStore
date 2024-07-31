<?php
include '../includes/db.php'; // Adjust the path as needed
include '../includes/header.php'; // Include the common header to maintain consistency

session_start();

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($conn->real_escape_string($_POST['username']));
    $email = trim($conn->real_escape_string($_POST['email']));
    $password = trim($conn->real_escape_string($_POST['password']));
    $firstname = trim($conn->real_escape_string($_POST['firstname']));
    $lastname = trim($conn->real_escape_string($_POST['lastname']));
    $phone = trim($conn->real_escape_string($_POST['phone']));
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($firstname) || empty($lastname) || empty($phone)) {
        $_SESSION['error'] = "All fields are required.";
    } elseif (!validateEmail($email)) {
        $_SESSION['error'] = "Invalid email format.";
    } elseif (!validatePassword($password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.";
    } elseif (!ctype_digit($phone)) {
        $_SESSION['error'] = "Phone number should contain only numeric values.";
    } else {
        // Check if the username or email already exists
        $checkUser = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $checkUser->bind_param("ss", $username, $email);
        $checkUser->execute();
        $result = $checkUser->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Username or Email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, firstname, lastname, phone) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $hashed_password, $email, $firstname, $lastname, $phone);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful!";
            } else {
                $_SESSION['error'] = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $checkUser->close();
    }
    $conn->close();
    header("Location: register.php"); // Redirect to the same page to show the message
    exit();
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
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    ?>
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
        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>