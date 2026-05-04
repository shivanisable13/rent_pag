<?php
include("../config/db.php");

$booking_id = intval($_GET['booking_id']);

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT b.*, p.title, u.name as username
FROM bookings b
LEFT JOIN properties p ON b.property_id = p.id
LEFT JOIN users u ON b.user_id = u.id
WHERE b.id = '$booking_id'
"));

if(!$data){
    die("Invalid Booking");
}

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
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b);
}

/* CENTER CARD */
.wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

/* CARD */
.card{
    width:700px;
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

/* HEADER */
.header{
    background: linear-gradient(135deg, #6366f1, #22c55e);
    color:white;
    text-align:center;
    padding:25px;
}

.header h2{
    margin:0;
}

.header p{
    margin-top:5px;
    opacity:0.9;
}

/* CONTENT */
.content{
    padding:25px;
    color:#000;
}

.content p{
    margin:8px 0;
}

hr{
    margin:15px 0;
    border:0;
    border-top:1px solid #ccc;
}

/* SECTION TITLE */
.section-title{
    font-weight:bold;
    margin-bottom:5px;
}

/* LIST */
ul{
    padding-left:20px;
}

/* ICON STYLE */
.icon{
    margin-right:5px;
}
</style>
</head>

<body>

<div class="wrapper">

<div class="card">

<!-- HEADER -->
<div class="header">
    <h2>🏡 PG Stay Agreement</h2>
    <p>CampusStay</p>
</div>

<!-- CONTENT -->
<div class="content">

<p><b>User:</b> <?php echo $data['username']; ?></p>
<p><b>Property:</b> <?php echo $data['title']; ?></p>

<p><b>Amount Paid:</b> ₹ <?php echo $data['amount']; ?></p>

<hr>

<p class="section-title">📅 Stay Duration</p>
<p>From: <?php echo $start_date; ?></p>
<p>To: <?php echo $end_date; ?></p>

<hr>

<p class="section-title">📜 Terms & Conditions</p>
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