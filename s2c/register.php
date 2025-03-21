<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "s2c_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $mail = $conn->real_escape_string($_POST['mail']);
    $pass = password_hash($conn->real_escape_string($_POST['pass']), PASSWORD_DEFAULT); // Hash the password
    $phone = $conn->real_escape_string($_POST['phone']);
    $location = $conn->real_escape_string($_POST['location']);
    $store_name = $conn->real_escape_string($_POST['store_name']);
    $store_type = $conn->real_escape_string($_POST['store_type']);
    $address = $conn->real_escape_string($_POST['address']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO store_detials (full_name, mail, pass, phone, location, store_name, store_type, address)
            VALUES ('$full_name', '$mail', '$pass', '$phone', '$location', '$store_name', '$store_type', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>