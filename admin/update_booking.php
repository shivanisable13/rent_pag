<?php
include("../config/db.php");

$id = intval($_GET['id']);
$status = $_GET['status'];

// 🔹 Get booking info FIRST
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM bookings WHERE id=$id
"));

if(!$data){
    die("Invalid booking");
}

$property_id = $data['property_id'];
$user_id = $data['user_id'];
$booking_id = $data['id'];
$amount = $data['amount'];

// ======================================
// ✅ CHECK CAPACITY BEFORE APPROVAL
// ======================================
if($status == "approved"){

    // 🔹 Get total approved bookings
    $booked = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT COUNT(*) as total 
    FROM bookings 
    WHERE property_id='$property_id' 
    AND status='approved'
    "))['total'];

    // 🔹 Get property capacity
    $capacity = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT capacity FROM properties WHERE id='$property_id'
    "))['capacity'];

    // 🔥 IF FULL → AUTO REJECT
    if($booked >= $capacity){

        mysqli_query($conn,"
        UPDATE bookings 
        SET status='rejected' 
        WHERE id=$id
        ");

        $message = "❌ Booking rejected. Room is already full.";

    } else {

        // ✅ APPROVE
        mysqli_query($conn,"
        UPDATE bookings 
        SET status='approved', payment_status='pending' 
        WHERE id=$id
        ");

        $message = "✅ Your booking is approved. Amount ₹$amount. Click Pay Now to continue.";
    }

} else {

    // 🔹 Manual reject
    mysqli_query($conn,"
    UPDATE bookings 
    SET status='$status' 
    WHERE id=$id
    ");

    $message = "Your booking has been $status";
}

// 🔹 Insert notification
mysqli_query($conn,"
INSERT INTO notifications (user_id, message, booking_id)
VALUES ('$user_id', '$message', '$booking_id')
");

header("Location: manage_bookings.php");
?>