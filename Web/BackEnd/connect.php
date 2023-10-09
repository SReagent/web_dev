<?php
$HOSTNAME='db';
$USERNAME='user';
$PASSWORD='test';
$DATABASE='biblion';

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

?>