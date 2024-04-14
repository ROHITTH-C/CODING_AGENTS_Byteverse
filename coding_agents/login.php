<?php
// Database connection details - marchali ne db battii
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ars"; // ikkada new db name peduthu gani.. (tarvatha chepta lee)

// Create connection (aayidhi perfect ga no issue)
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection (fail aytey poyinattey)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isUserAuthenticated($email, $password, $conn) {
    $sql = "SELECT * FROM registrationtable WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}


if (isset($_POST['mobile'], $_POST['pin'])) {
    $mobile = $_POST['mobile'];
    $pin = $_POST['pin'];

    if (isUserAuthenticated($mobile, $pin, $conn)) {
        echo "
        <script>
        alert('Login successful!');
        window.location.href = 'home.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Invalid credentials!');
        window.location.href = 'login.html';
        </script>
        ";
    }
}

$stmt->close();
$conn->close();
?>