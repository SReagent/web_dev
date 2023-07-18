<?php
session_start();

function signOut() {
    $_SESSION = array();

    session_destroy();

    header("Location: ../FrontEnd/Signin.php");
    exit();
}

if (isset($_GET['signout'])) {
    signOut();
}
?>
