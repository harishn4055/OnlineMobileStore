<?php
// Start the session in the header if it's not already started.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Mobile Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
                /* Custom navbar styling */
        .navbar 
        {
            background-color: #0056b3 !important; /* Navy blue background for the navbar */
            color: white !important; /* White text for better contrast */
        }
        .custom-nav-link 
        {
            color: white !important; /* Ensures the link is white */
        }
        .custom-nav-link:hover, .custom-nav-link:focus 
        {
            color: #0056b3 !important; /* Changes color on hover */
        }

    </style>

    
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand nav-link custom-nav-link">Mobile Mart</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link custom-nav-link" href="homepage.php">Home</a>
                </li>
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-link custom-nav-link" href="./cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link custom-nav-link" href="./order_confirmation.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link custom-nav-link" href="./manage_profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="./auth/logout.php" class="btn btn-danger">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link custom-nav-link" href="/auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link custom-nav-link" href="/auth/register.php">Register</a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>
</html>

    <!-- Rest of the page content starts here -->