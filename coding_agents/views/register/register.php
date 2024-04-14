<?php
// Database connection details - marchali ne db battii
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ars"; // Replace 'your_database_name' with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = $_POST['fname'];
    $email = $_POST['email'];
    $password = $_POST['pin'];

    // Insert data into database
    $sql = "INSERT INTO registrationtable (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $email, $password);
    
    // Execute the prepared statement
    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
        // Redirect to login page after successful registration
        echo "<script>window.location.href = 'login.html';</script>";
    } else {
        echo "<script>alert('Error: Registration failed');</script>";
    }
}

$stmt->close();
$conn->close();
?>