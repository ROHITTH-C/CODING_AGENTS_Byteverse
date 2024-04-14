<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ars";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve posts from the database
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescue Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .post {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }

        .post img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .post p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rescue Posts</h1>
        <?php
        // Check if there are posts to display
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="post">';
                echo '<img src="uploads/' . $row["image"] . '" alt="Post Image">';
                echo '<p><strong>Address:</strong> ' . $row["address"] . '</p>';
                echo '<p><strong>Description:</strong> ' . $row["description"] . '</p>';
                echo '</div>';
            }
        } else {
            echo "No posts available.";
        }
        ?>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>