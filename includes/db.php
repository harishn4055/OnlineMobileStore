<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mobile_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>