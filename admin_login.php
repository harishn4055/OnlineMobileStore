<?php include 'includes/header.php';
session_start();  ?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Make sure the path to your CSS file is correct -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
<?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);  // Clear the message so it doesn't persist
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);  // Clear the error message so it doesn't persist
        }
        ?>
    <h1 class="mb-3">Admin Login</h1>
    <div class="card">
        <div class="card-body">
            <form action="process_login.php" method="POST" class="needs-validation" novalidate>
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
    </div>
</div>



</body>
</html>
<?php include 'includes/footer.php'; ?>