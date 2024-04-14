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

// Check if the "Taken Up" button is clicked
if (isset($_POST['takeUpPost'])) {
    $postId = $_POST['postId'];

    // Update the taken_up column in the database for the selected post
    $sql = "UPDATE posts SET taken_up = 1 WHERE id = $postId";
    if ($conn->query($sql) === TRUE) {
        // Success message
        echo "Post marked as taken up successfully!";
    } else {
        // Error message
        echo "Error marking post as taken up: " . $conn->error;
    }
}

// Retrieve non-taken up posts from the database
$sqlNonTakenUp = "SELECT * FROM posts WHERE taken_up = 0";
$resultNonTakenUp = $conn->query($sqlNonTakenUp);

// Retrieve taken up posts from the database
$sqlTakenUp = "SELECT * FROM posts WHERE taken_up = 1";
$resultTakenUp = $conn->query($sqlTakenUp);
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

        .post-container {
            margin-bottom: 20px;
        }

        .post {
            display: inline-block;
            width: calc(50% - 10px); /* Adjust as needed */
            margin-right: 20px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            vertical-align: top;
        }

        .post img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .post p {
            margin: 0;
        }

        .take-up-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .take-up-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rescue Posts</h1>
        <div class="post-container">
            <h2>Non-Taken Up Posts</h2>
            <?php
            // Check if there are non-taken up posts to display
            if ($resultNonTakenUp->num_rows > 0) {
                // Output data of each non-taken up post
                while ($row = $resultNonTakenUp->fetch_assoc()) {
                    echo '<div class="post">';
                    echo '<img src="uploads/' . $row["image"] . '" alt="Post Image">';
                    echo '<p><strong>Address:</strong> ' . $row["address"] . '</p>';
                    echo '<p><strong>Description:</strong> ' . $row["description"] . '</p>';
                    echo '<button class="take-up-btn" onclick="takeUpPost(' . $row["id"] . ')">Take Up</button>'; // Pass post ID to JavaScript function
                    echo '</div>';
                }
            } else {
                echo "No non-taken up posts available.";
            }
            ?>
        </div>

        <div class="post-container">
            <h2>Taken Up Posts</h2>
            <?php
            // Check if there are taken up posts to display
            if ($resultTakenUp->num_rows > 0) {
                // Output data of each taken up post
                while ($row = $resultTakenUp->fetch_assoc()) {
                    echo '<div class="post">';
                    echo '<img src="uploads/' . $row["image"] . '" alt="Post Image">';
                    echo '<p><strong>Address:</strong> ' . $row["address"] . '</p>';
                    echo '<p><strong>Description:</strong> ' . $row["description"] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No taken up posts available.";
            }
            ?>
        </div>
    </div>

    <script>
        function takeUpPost(postId) {
            // Send AJAX request to mark the post as taken up in the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "rescue.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page to update the list of posts
                    window.location.reload();
                }
            };
            xhr.send("takeUpPost=true&postId=" + postId);
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>