<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/db.php");
session_start();

$error = "";

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password' AND role='admin'");

    if(mysqli_num_rows($res)>0){
        $user=mysqli_fetch_assoc($res);

        $_SESSION['user_id']=$user['id'];
        $_SESSION['role']='admin';

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Credentials";
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div style="display:flex;justify-content:center;align-items:center;height:100vh;">

<form method="POST" class="glass" style="width:350px;">

<h2 style="text-align:center;">Admin Login</h2>

<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="login" style="width:100%;">Login</button>

<p style="color:red;"><?php echo $error; ?></p>

</form>

</div>