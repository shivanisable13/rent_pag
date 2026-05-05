<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("pg-db","root","root","pg_rental");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>
