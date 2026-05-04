<?php
include("../config/db.php");

$msg = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password_input = $_POST['password'];

    // ✅ NAME VALIDATION (only letters & spaces)
    if(!preg_match("/^[a-zA-Z ]+$/", $name)){
        $msg = "Name should contain only letters";
    }

    // ✅ EMAIL VALIDATION (must start with letter, can include numbers later)
    elseif(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9._%+-]*@[a-zA-Z]+\.[a-zA-Z]{2,}$/", $email)){
        $msg = "Enter valid email (must start with letters)";
    }

    // ✅ PASSWORD VALIDATION (min 6 chars, letters + numbers)
    elseif(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $password_input)){
        $msg = "Password must be at least 6 characters with letters and numbers";
    }

    else{

        $password = md5($password_input);

        // ✅ CHECK DUPLICATE EMAIL
        $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($check) > 0){
            $msg = "Email already exists";
        } else {

            mysqli_query($conn,"INSERT INTO users(name,email,password)
            VALUES('$name','$email','$password')");

            $msg = "Registered Successfully";
        }
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div style="display:flex;justify-content:center;align-items:center;height:100vh;">
    <form method="POST" class="glass" style="width:350px;">
        <h2 style="text-align:center;">Register</h2>

        <!-- NAME -->
        <input name="name" placeholder="Full Name" required>

        <!-- EMAIL -->
        <input name="email" type="email" placeholder="Email" required>

        <!-- PASSWORD -->
        <div style="position:relative;">
            <input type="password" id="password" name="password" placeholder="Password" required>

            <span onclick="togglePassword()" 
                style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
                👁️
            </span>
        </div>

        <!-- BUTTON -->
        <button name="register" style="width:100%;">Register</button>

        <!-- MESSAGE -->
        <p style="color:red;"><?php echo $msg; ?></p>

        <!-- LOGIN LINK -->
        <p style="text-align:center;">
            Already have account? 
            <a href="login.php" style="color:#8b5cf6;">Login</a>
        </p>
    </form>

    <script src="../assets/js/script.js"></script>
</div>