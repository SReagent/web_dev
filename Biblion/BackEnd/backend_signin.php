<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    include_once 'connect.php';

    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT Password FROM users WHERE Email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $userpassword = $row["Password"];

        if ($password == $userpassword) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['email'] = $email;
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
}
?>