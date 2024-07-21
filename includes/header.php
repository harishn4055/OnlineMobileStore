<?php
// Determine base path dynamically: adjust this logic based on your directory structure
$currentPage = basename($_SERVER['PHP_SELF']);
if ($currentPage == 'login.php' || $currentPage == 'register.php') {
    $basePath = "../";  // Go up one directory level for login and register pages
} else {
    $basePath = "";  // No adjustment needed for other pages
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Mobile Mart</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="navbar">
        <div class="navbar-brand">Mobile Mart</div>
        <ul>
            <li><a href="<?php echo $basePath; ?>index.php">Home</a></li>
            <li><a href="<?php echo $basePath; ?>catalog.php">Catalog</a></li>
            <li><a href="<?php echo $basePath; ?>auth/login.php">Login</a></li>
            <li><a href="<?php echo $basePath; ?>auth/register.php">Sign up</a></li>
            <li><a href="<?php echo $basePath; ?>admin_login.php">Admin Login</a></li>

            
        </ul>
    </div>
</header>
</body>