<?php
if($_SESSION['role'] != 'admin'){
    die("Access Denied");
}
session_start();
session_destroy();

header("Location: login.php");
?>