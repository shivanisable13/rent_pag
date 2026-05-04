<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
?>

<link rel="stylesheet" href="../assets/css/style.css">

<style>
.container {
    max-width:700px;
    margin:auto;
    padding:20px;
}

.title {
    text-align:center;
    margin-bottom:20px;
}

.notify-card {
    background: rgba(255,255,255,0.1);
    padding:15px;
    margin:12px 0;
    border-radius:12px;
    backdrop-filter: blur(10px);
    transition:0.3s;
    cursor:pointer;
}

.notify-card:hover {
    transform:translateY(-5px);
    box-shadow:0 0 15px rgba(255,255,255,0.2);
}
</style>

<div class="container">
<h2 class="title">🔔 My Notifications</h2>

<?php
// ===============================
// ✅ 1. BOOKING STATUS (PAYMENT)
// ===============================
$bookings = mysqli_query($conn,"
SELECT b.*, p.title 
FROM bookings b
LEFT JOIN properties p ON b.property_id = p.id
WHERE b.user_id = $user_id
ORDER BY b.id DESC
");

while($b = mysqli_fetch_assoc($bookings)){
$status = strtolower($b['status']);
?>

<div class="notify-card">

<p>
<?php 
if($status == 'approved'){
    echo "✅ Your booking for <b>".$b['title']."</b> is approved!";
} elseif($status == 'rejected'){
    echo "❌ Your booking for <b>".$b['title']."</b> is rejected!";
} else {
    echo "⏳ Your booking for <b>".$b['title']."</b> is pending...";
}
?>
</p>

<?php if($status == 'approved'){ ?>

<p>💰 Amount: ₹<?php echo $b['amount']; ?></p>

<?php if($b['payment_status'] == 'pending'){ ?>
    <a href="payment.php?booking_id=<?php echo $b['id']; ?>"
       style="display:inline-block;margin-top:10px;padding:8px 15px;background:#28a745;color:white;border-radius:5px;text-decoration:none;">
       Pay Now 💳
    </a>
<?php } ?>

<?php if($b['payment_status'] == 'paid'){ ?>
    <p style="color:lightgreen;">✅ Payment Completed</p>
<?php } ?>

<?php } ?>

</div>

<?php } ?>

<?php
// =======================================
// ✅ 2. AGREEMENT NOTIFICATIONS (SECURE)
// =======================================
$notifications = mysqli_query($conn,"
SELECT n.*, b.user_id as booking_user 
FROM notifications n
LEFT JOIN bookings b ON n.booking_id = b.id
WHERE n.user_id = $user_id
ORDER BY n.id DESC
");

while($n = mysqli_fetch_assoc($notifications)){

// 🔒 SECURITY CHECK
if($n['booking_user'] != $user_id){
    continue;
}

$booking_id = $n['booking_id'];
$link = "agreement_view.php?booking_id=".$booking_id;
?>

<a href="<?php echo $link; ?>" style="text-decoration:none;color:white;">

<div class="notify-card">

<p>
📄 Your PG agreement is ready  
<span style="color:#4ade80;font-weight:bold;">👉 Click to View Agreement</span>
</p>

<small>
<?php echo date("d M Y, h:i A", strtotime($n['created_at'])); ?>
</small>

</div>

</a>

<?php } ?>

</div>