<?php
// save_data.php

// Database connection details
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "farmer_detials"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get raw JSON data from the request body
$jsonData = file_get_contents('php://input');

// Decode the JSON data into an associative array
$data = json_decode($jsonData, true);

// Check if JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Invalid JSON data received.");
}

// Extract data from the decoded JSON
$district = $data['district'] ?? null;
$village = $data['village'] ?? null;
$disease = $data['disease'] ?? null;
$time = $data['time'] ?? null;

// Validate the data
if (!$district || !$village || !$disease || !$time) {
    die("Missing required data: district, village, disease, or time.");
}

// Convert ISO time to MySQL DATETIME format
$mysqlTime = date('Y-m-d H:i:s', strtotime($time));

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO location (district, village, disease, time) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $district, $village, $disease, $mysqlTime);

// Execute the statement
if ($stmt->execute()) {
    echo "Data saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>