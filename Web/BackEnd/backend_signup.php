<?php
include_once 'connect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
;

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

$query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    echo "duplicate";
    exit();
} else {

    // Insert the user data into the "users" table
    $insertQuery = "INSERT INTO users (Email, Username, Password) VALUES ('$email', '$username', '$password')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['email'] = $email;
        echo "success";
        exit();
    } else {
        echo "error";
        exit();
    }
}
?>