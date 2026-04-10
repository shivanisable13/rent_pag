<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET['id'];

$success = "";

if(isset($_POST['book'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    if(strlen($phone) != 10){
        echo "<script>alert('Phone must be 10 digits');</script>";
    } else {

        mysqli_query($conn,"INSERT INTO bookings
        (user_id,property_id,name,phone,message,status)
        VALUES
        ('$user_id','$property_id','$name','$phone','$message','Pending')");

        $success = "✅ Booking Request Sent Successfully!";
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<style>
.container {
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:90vh;
}

/* CARD */
.booking-card {
    width:100%;
    max-width:450px;
    padding:30px;
    border-radius:20px;
    text-align:center;
}

/* TITLE */
.section-title {
    margin-bottom:20px;
}

/* INPUT */
.input-box {
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    border:none;
    outline:none;
}

/* BUTTON */
.btn {
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#38bdf8;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover {
    background:#0ea5e9;
    transform:scale(1.03);
}

/* ✅ SMALL BACK BUTTON */
.back-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 6px 14px;
    border-radius: 20px;
    background: #38bdf8;
    color: white;
    text-decoration: none;
    font-size: 13px;
    transition: 0.3s;
}

.back-btn:hover {
    background: #0ea5e9;
}

/* SUCCESS */
.success-msg {
    background:#16a34a;
    color:white;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
    animation:fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(-10px);}
    to {opacity:1; transform:translateY(0);}
}
</style>

<div class="container">

<div class="glass booking-card">

<h2 class="section-title">🏡 Book Your Stay</h2>

<?php if($success != ""){ ?>
    <div class="success-msg">
        <?php echo $success; ?>
    </div>
<?php } ?>

<form method="POST">

<!-- NAME -->
<input type="text" name="name" 
value="<?php echo $_SESSION['user_name']; ?>"
class="input-box"
placeholder="👤 Your Name" required>

<!-- PHONE -->
<input type="number" name="phone" 
class="input-box"
placeholder="📞 Phone Number" required>

<!-- MESSAGE -->
<textarea name="message" 
class="input-box"
placeholder="Any special requirements..."></textarea>

<!-- BUTTON -->
<button name="book" class="btn">
    Confirm Booking 
</button>

</form>

<!-- 🔙 SMALL BACK BUTTON -->
<a href="about.php" class="back-btn">⬅ Back</a>

</div>
</div>

<script>
setTimeout(()=>{
    document.querySelector('.success-msg')?.remove();
},3000);
</script>