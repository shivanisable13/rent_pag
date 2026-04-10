<?php
include("../config/db.php");

$id = $_GET['id'];
$status = $_GET['status'];

// 🔹 Update booking
mysqli_query($conn,"UPDATE bookings SET status='$status' WHERE id=$id");

// 🔹 Get booking info
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM bookings WHERE id=$id
"));

$user_id = $data['user_id'];

// 🔹 Create notification message
$message = "Your booking has been $status";

// 🔹 Insert notification
mysqli_query($conn,"
INSERT INTO notifications (user_id, message)
VALUES ('$user_id', '$message')
");

header("Location: manage_bookings.php");
?>