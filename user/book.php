<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$property_id = intval($_GET['id']);

$success = "";

if(isset($_POST['book'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    if(strlen($phone) != 10){
        echo "<script>alert('Phone must be 10 digits');</script>";
    } else {

        // 🔒 LOCK SEAT (APPROVED + PENDING)
        $booked = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT COUNT(*) as total 
        FROM bookings 
        WHERE property_id='$property_id' 
        AND status IN ('approved','Pending')
        "))['total'];

        $capacity = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT capacity FROM properties WHERE id='$property_id'
        "))['capacity'];

        if($booked >= $capacity){
            echo "<script>alert('Room just got full!');window.location='property.php?id=$property_id';</script>";
            exit();
        }

        mysqli_query($conn,"INSERT INTO bookings
        (user_id,property_id,name,phone,message,status)
        VALUES
        ('$user_id','$property_id','$name','$phone','$message','Pending')");

        $success = "✅ Booking Request Sent Successfully!";
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div class="container">
<div class="glass booking-card">

<h2 class="section-title">🏡 Book Your Stay</h2>

<?php if($success != ""){ ?>
<div class="success-msg"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">
<input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" class="input-box" required>
<input type="number" name="phone" class="input-box" placeholder="📞 Phone Number" required>
<textarea name="message" class="input-box"></textarea>

<button name="book" class="btn">Confirm Booking</button>
</form>

<a href="property.php?id=<?php echo $property_id; ?>" class="back-btn">⬅ Back</a>

</div>
</div>