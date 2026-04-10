<?php

include("../config/db.php");
session_start();
session_regenerate_id(true);


$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

       $_SESSION['user_id'] = $user['id'];
       $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == 'admin'){
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: home.php");
        }
    } else {
        $error = "Invalid Email or Password";
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div style="display:flex;justify-content:center;align-items:center;height:100vh;">
    <form method="POST" class="glass" style="width:350px;">
        <h2 style="text-align:center;">Login</h2>

        <input type="email" name="email" placeholder="Email" required> 
        <div style="position:relative;">
    <input type="password" id="password" name="password" placeholder="Password" required>

    <span onclick="togglePassword()" 
          style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
        👁️
    </span>
</div>

        <button name="login" style="width:100%;">Login</button>

        <p style="color:red;"><?php echo $error; ?></p>

        <p style="text-align:center;">No account? 
            <a href="register.php" style="color:#8b5cf6;">Register</a>
        </p>
        <p style="text-align:center;">
            <a href="../admin/login.php" style="color:#8b5cf6;">Login as Admin</a>
        </p>
    </form>
    <script src="../assets/js/script.js"></script>
</div>