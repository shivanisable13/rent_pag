<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 🔐 AUTH CHECK
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

include("../config/db.php");
?>

<link rel="stylesheet" href="../assets/css/style.css?v=<?=time();?>">

<div class="container">

<h2 class="section-title">Admin Dashboard 📊</h2>

<?php
// ✅ SAFE QUERIES
$p = mysqli_query($conn,"SELECT COUNT(*) as total FROM properties");
$u = mysqli_query($conn,"SELECT COUNT(*) as total FROM users");
$b = mysqli_query($conn,"SELECT COUNT(*) as total FROM bookings");

$p = mysqli_fetch_assoc($p);
$u = mysqli_fetch_assoc($u);
$b = mysqli_fetch_assoc($b);
?>

<!-- 📊 STATS -->
<div class="grid">

    <div class="glass card">
        <h3>Total Properties</h3>
        <p><?php echo $p['total']; ?></p>
    </div>

    <div class="glass card">
        <h3>Total Users</h3>
        <p><?php echo $u['total']; ?></p>
    </div>

    <div class="glass card">
        <h3>Total Bookings</h3>
        <p><?php echo $b['total']; ?></p>
    </div>

</div>

<br><br>

<!-- 🔘 ACTION BUTTONS -->
<div class="grid">

    <a href="add_property.php" class="action-btn">
        ➕ Add Property
    </a>

    <a href="manage_property.php" class="action-btn">
        🏠 Manage Properties
    </a>

    <a href="bookings.php" class="action-btn">
        📋 View Bookings
    </a>
    

</div>

</div>