<?php
include_once 'connect.php';

$email = $_POST["email"];
$password = $_POST["password"];

$query = "SELECT Password FROM users WHERE Email = '$email'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $userpassword = $row["Password"];

    if ($password == $userpassword) {
        echo "success";
        exit();
    } else {
        echo "invalid";
        exit();
    }
} else {
    echo "error";
    exit();
}
?>