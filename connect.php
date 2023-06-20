<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='biblion';

$con = mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(mysqli_connect_errno())
{
    exit();
}
