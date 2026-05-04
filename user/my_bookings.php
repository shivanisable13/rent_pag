<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

// ✅ Secure user id
$user_id = intval($_SESSION['user_id']);

// ✅ Fetch only this user's bookings
$bookings = mysqli_query($conn, "
    SELECT b.*, p.title 
    FROM bookings b 
    LEFT JOIN properties p ON p.id = b.property_id 
    WHERE b.user_id = '$user_id'
    ORDER BY b.id DESC
");
?>

<div class="container">
<h2 class="section-title">My Bookings 📋</h2>

<div class="grid">

<?php while($b = mysqli_fetch_assoc($bookings)){ 

    $status = strtolower($b['status']);
?>

<div class="glass booking-card">

    <h3><?php echo $b['title'] ?? 'Property'; ?></h3>

    <p>
        Status: 
        <span class="status <?php echo $status; ?>">
            <?php echo ucfirst($status); ?>
        </span>
    </p>

    <p>📅 <?php echo date("d M Y, h:i A", strtotime($b['created_at'])); ?></p>

    <p>💬 <?php echo $b['message'] ?: 'No message'; ?></p>

    <!-- ✅ ADDED AMOUNT HERE -->
    <p>💰 Amount: ₹<?php echo $b['amount']; ?></p>

    <?php
    // ✅ Show Pay Now button ONLY after admin approval
    if($status == "approved" && isset($b['payment_status']) && $b['payment_status'] == "pending"){
    ?>
        <a href="payment.php?booking_id=<?php echo $b['id']; ?>" 
           style="display:inline-block;margin-top:10px;padding:8px 15px;background:#28a745;color:white;border-radius:5px;text-decoration:none;">
           
           Pay Now 💳
        </a>
    <?php } ?>

    <?php
    // ✅ Show payment success
    if(isset($b['payment_status']) && $b['payment_status'] == "paid"){
    ?>
        <p style="color:green;margin-top:10px;">✅ Payment Completed</p>
    <?php } ?>

</div>

<?php } ?>

</div>

</div>

<?php include("../includes/footer.php"); ?>