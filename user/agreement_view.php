<?php
// ✅ SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../config/db.php");

// ✅ LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    die("Please login first");
}

$user_id = intval($_SESSION['user_id']);
$role = $_SESSION['role'] ?? 'user';

// ✅ GET BOOKING ID
if(!isset($_GET['booking_id'])){
    die("Invalid Access");
}

$booking_id = intval($_GET['booking_id']);

// ✅ CONDITION (ADMIN CAN SEE ALL, USER ONLY OWN)
if($role == 'admin'){
    $condition = "b.id = '$booking_id'";
} else {
    $condition = "b.id = '$booking_id' AND b.user_id = '$user_id'";
}

// ✅ FETCH DATA
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT b.*, p.title, u.name as username
FROM bookings b
LEFT JOIN properties p ON b.property_id = p.id
LEFT JOIN users u ON b.user_id = u.id
WHERE $condition
"));

if(!$data){
    die("Invalid Booking");
}

// ✅ DATES
$start_date = date("d M Y", strtotime($data['created_at']));
$end_date = date("d M Y", strtotime($data['created_at']." +1 month"));
?>

<!DOCTYPE html>
<html>
<head>
<title>PG Agreement</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color:#fff;
}

/* MAIN CARD */
.container{
    max-width:750px;
    margin:40px auto;
    background:#ffffff;
    color:#000;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

/* HEADER */
.header{
    background: linear-gradient(135deg, #6366f1, #22c55e);
    color:white;
    padding:20px;
    text-align:center;
}

.header h2{
    margin:0;
}

/* CONTENT */
.content{
    padding:25px;
}

.section{
    margin-bottom:15px;
}

.label{
    font-weight:bold;
}

/* AMOUNT BOX */
.amount{
    background:#f1f5f9;
    padding:12px;
    border-radius:8px;
    font-size:18px;
    font-weight:bold;
    color:#16a34a;
}

/* TERMS */
ul{
    padding-left:20px;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
    <h2>🏡 PG Stay Agreement</h2>
    <p>CampusStay</p>
</div>

<div class="content">

<div class="section">
    <p><span class="label">User:</span> <?php echo htmlspecialchars($data['username']); ?></p>
    <p><span class="label">Property:</span> <?php echo htmlspecialchars($data['title']); ?></p>
    <p><span class="label">Amount Paid:</span> ₹ <?php echo $data['amount']; ?></p>
</div>

<hr>

<div class="section">
    <p class="label">📅 Stay Duration</p>
    <p>From: <?php echo $start_date; ?></p>
    <p>To: <?php echo $end_date; ?></p>
</div>

<hr>

<div class="section">
    <p class="label">📜 Terms & Conditions</p>
    <ul>
        <li>Stay valid for 1 month only</li>
        <li>Maintain discipline and hygiene</li>
        <li>No illegal activities allowed</li>
        <li>No refund after confirmation</li>
    </ul>
</div>

</div>

</div>

</body>
</html>