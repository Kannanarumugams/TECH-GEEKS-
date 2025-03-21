<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sale";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the AJAX request
$productName = $_POST['productName'];
$productAmount = $_POST['productAmount'];
$productQuantity = $_POST['productQuantity'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO products (product_name, amount, stoks) VALUES (?, ?, ?)");
$stmt->bind_param("sdi", $productName, $productAmount, $productQuantity);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>