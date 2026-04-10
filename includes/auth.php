<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: /campusstay/user/login.php");
    exit();
}
?>