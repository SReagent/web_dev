<?php
include_once'connect.php';

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
        echo "success";
        exit();
    } else {
        echo "error";
        exit();
    }
}
?>