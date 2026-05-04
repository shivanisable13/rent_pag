<?php
include("../config/db.php");

$payment_id = $_POST['payment_id'];
$booking_id = intval($_POST['booking_id']);

// ✅ Update booking as paid
mysqli_query($conn,"
UPDATE bookings 
SET payment_status='paid', payment_id='$payment_id' 
WHERE id='$booking_id'
");

// ✅ Get booking + property owner
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT b.*, p.owner_id 
FROM bookings b
LEFT JOIN properties p ON b.property_id = p.id
WHERE b.id='$booking_id'
"));

$user_id = $data['user_id'];      // person who booked
$owner_id = $data['owner_id'];    // owner of PG

// ================================
// 🔥 1. NOTIFY OWNER
// ================================
$message_owner = "💰 Payment received for your PG. Booking ID: $booking_id";

mysqli_query($conn,"
INSERT INTO notifications (user_id, message, booking_id)
VALUES ('$owner_id', '$message_owner', '$booking_id')
");

// ================================
// 🔥 2. NOTIFY USER (optional)
// ================================
$message_user = "✅ Payment successful! Your booking is confirmed.";

mysqli_query($conn,"
INSERT INTO notifications (user_id, message, booking_id)
VALUES ('$user_id', '$message_user', '$booking_id')
");

echo "success";
?>