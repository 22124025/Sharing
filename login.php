<?php
// Set content type before any output
header('Content-Type: application/json');

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "d";

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
    die(json_encode(array("error" => "Connect Error (" . mysqli_connect_errno() . ") " . mysqli_connect_error())));
}

$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute database query to validate login credentials
$stmt = $conn->prepare("SELECT * FROM new WHERE uname1 = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if there is a matching user
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['upswd1'];
    
    // Verify password
    if (password_verify($password, $hashed_password)) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Wrong password"));
    }
} else {
    echo json_encode(array("error" => "User not found"));
}

$stmt->close();
$conn->close();
?>
