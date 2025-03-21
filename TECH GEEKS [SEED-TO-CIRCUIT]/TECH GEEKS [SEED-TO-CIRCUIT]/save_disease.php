<?php
$servername = "localhost";  // Change if needed (e.g., to a remote server)
$username = "root";         // Change to your MySQL username
$password = "";             // Change if you have a MySQL password
$database = "farmer_detials";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the disease name from POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disease = $_POST['disease'] ?? '';

    if (!empty($disease)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO disease (disease_name) VALUES (?)");
        $stmt->bind_param("s", $disease);

        if ($stmt->execute()) {
            echo "Disease saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Disease name is empty!";
    }
}

$conn->close();
?>
