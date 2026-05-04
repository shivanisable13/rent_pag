<?php
include("../includes/auth.php");
include("../config/db.php");

// ✅ Validate booking_id
if(!isset($_GET['booking_id']) || empty($_GET['booking_id'])){
    die("Invalid Access - Booking ID missing");
}

$user_id = intval($_SESSION['user_id']);
$booking_id = intval($_GET['booking_id']);

// ✅ Get booking (ONLY this user)
$result = mysqli_query($conn,"
SELECT * FROM bookings 
WHERE id='$booking_id' 
AND user_id='$user_id'
");

$booking = mysqli_fetch_assoc($result);

if(!$booking){
    die("Invalid Booking");
}

// ❌ Prevent double payment
if($booking['payment_status'] == 'paid'){
    die("Payment already completed");
}

$amount = $booking['amount'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>

<link rel="stylesheet" href="../assets/css/style.css">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
.container {
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:90vh;
}

.card {
    max-width:400px;
    padding:30px;
    text-align:center;
}

.pay-btn {
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#22c55e;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.pay-btn:hover {
    background:#16a34a;
}
</style>
</head>

<body>

<div class="container">

<div class="glass card">

<h2>💳 Complete Payment</h2>

<p><b>Booking ID:</b> <?php echo $booking_id; ?></p>
<p><b>Amount:</b> ₹<?php echo $amount; ?></p>

<br>

<button id="payBtn" class="pay-btn">
    Pay Now
</button>

</div>

</div>

<script>
var options = {
    "key": "rzp_test_SjNPEU6SPz0j2X",
    "amount": "<?php echo $amount * 100; ?>",
    "currency": "INR",
    "name": "CampusStay",
    "description": "PG Booking Payment",

    "handler": function (response){

        fetch("verify_payment.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "payment_id=" + response.razorpay_payment_id + 
                  "&booking_id=<?php echo $booking_id; ?>"
        })
        .then(res => res.text())
        .then(data => {
            alert("✅ Payment Successful!");
            window.location.href = "my_bookings.php";
        });
    },

    "theme": {
        "color": "#8b5cf6"
    }
};

var rzp1 = new Razorpay(options);

document.getElementById('payBtn').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

</body>
</html>