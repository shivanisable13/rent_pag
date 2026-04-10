<?php
include("../config/db.php");

$msg = "";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        $msg = "Email already exists";
    } else {
        mysqli_query($conn,"INSERT INTO users(name,email,password)
        VALUES('$name','$email','$password')");

        $msg = "Registered Successfully";
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div style="display:flex;justify-content:center;align-items:center;height:100vh;">
    <form method="POST" class="glass" style="width:350px;">
        <h2 style="text-align:center;">Register</h2>

        <input name="name" placeholder="Full Name" required>
        <input name="email" type="email" placeholder="Email" required>
        <div style="position:relative;">
    <input type="password" id="password" name="password" placeholder="Password" required style="padding-right:35px;">

    <span onclick="togglePassword()" 
          style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
        👁️
    </span>
</div>

        <button name="register" style="width:100%;">Register</button>

        <p style="color:lightgreen;"><?php echo $msg; ?></p>

        <p style="text-align:center;">Already have account? 
            <a href="login.php" style="color:#8b5cf6;">Login</a>
        </p>
    </form>
     <script src="../assets/js/script.js"></script>
</div>