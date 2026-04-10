<?php
session_start();
include("../config/db.php");

// ✅ Check login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// ✅ Fetch bookings with PG title
$res = mysqli_query($conn,"
SELECT b.*, p.title 
FROM bookings b
LEFT JOIN properties p ON b.property_id = p.id
WHERE b.user_id = $user_id
ORDER BY b.id DESC
");

// ✅ Mark as read
mysqli_query($conn,"
UPDATE bookings 
SET is_read=1 
WHERE user_id='$user_id'
");
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

/* CARD */
.notify-card {
    background: rgba(255,255,255,0.1);
    padding:15px;
    margin:12px 0;
    border-radius:12px;
    backdrop-filter: blur(10px);
    transition:0.3s;
}

.notify-card:hover {
    transform:translateY(-5px);
    box-shadow:0 0 15px rgba(255,255,255,0.2);
}

/* STATUS COLORS */
.status {
    font-weight:bold;
    margin-top:5px;
}
</style>

<div class="container">

<h2 class="title">🔔 My Notifications</h2>

<?php if(mysqli_num_rows($res) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($res)){ 

        $status = strtolower($row['status']);
    ?>

    <div class="notify-card">

        <!-- MESSAGE -->
        <p>
        <?php 
        if($status == 'approved'){
            echo "✅ Your booking for <span style='color:#8b5cf6;font-weight:bold;'>".$row['title']."</span> has been approved!";
        } elseif($status == 'rejected'){
            echo "❌ Your booking for <span style='color:#8b5cf6;font-weight:bold;'>".$row['title']."</span> has been rejected!";
        } else {
            echo "⏳ Your booking for <span style='color:#8b5cf6;font-weight:bold;'>".$row['title']."</span> is pending...";
        }
        ?>
        </p>

        <!-- STATUS -->
        <p class="status" style="
        color:
        <?php 
            if($status=='approved') echo 'lightgreen';
            elseif($status=='rejected') echo 'red';
            else echo 'orange';
        ?>;
        ">
            <?php echo ucfirst($status); ?>
        </p>

        <!-- DATE -->
        <small>
            <?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?>
        </small>

    </div>

    <?php } ?>

<?php } else { ?>

    <!-- EMPTY -->
    <div style="text-align:center; margin-top:40px;">
        <h3>No notifications yet </h3>
    </div>

<?php } ?>

</div>