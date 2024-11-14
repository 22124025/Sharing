<?php

$uname1 = $_POST['uname1'];
$upswd1 = $_POST['upswd1'];
$upswd2 = $_POST['upswd2'];
$email  = $_POST['email'];

// Check if form fields are not empty
if (!empty($uname1) && !empty($upswd1) && !empty($upswd2) && !empty($email)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "d";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check if the connection is successful
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT email FROM new WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        // Checking if email already exists
        if ($rnum > 0) {
            $message = "Someone already using this email";
        } else {
            // Check if passwords match
            if ($upswd1 == $upswd2) {
                // Hash the password
                $enc_password = password_hash($upswd1, PASSWORD_DEFAULT);

                $INSERT = "INSERT INTO new (uname1, upswd1, email) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $uname1, $enc_password, $email);
                $stmt->execute();
                
                // Redirect to the login page
                header("Location: index.html");
                exit();
            } else {
                $message = "Passwords do not match";
            }
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $message = "All fields are required";
}

// Display message
echo "<script>alert('$message');window.location.href = 'Sign up.html';</script>";
?>
