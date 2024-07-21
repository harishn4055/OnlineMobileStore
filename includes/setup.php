<?php
include 'db.php'; // Includes your database connection

// SQL to create table for Users
$userTable = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// SQL to create table for Products
$productTable = "CREATE TABLE IF NOT EXISTS products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    stock INT NOT NULL DEFAULT 0
)";

// SQL to create table for Orders
$orderTable = "CREATE TABLE IF NOT EXISTS orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
)";

// Executing the queries to create tables
if ($conn->query($userTable) === TRUE) {
    echo "Table users created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

if ($conn->query($productTable) === TRUE) {
    echo "Table products created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

if ($conn->query($orderTable) === TRUE) {
    echo "Table orders created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>