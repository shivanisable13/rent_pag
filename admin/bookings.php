<?php


session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

include("../config/db.php");
include("../includes/admin_header.php");

// ✅ UPDATE STATUS
if(isset($_GET['approve'])){
    $id = intval($_GET['approve']);

    mysqli_query($conn,"
    UPDATE bookings 
    SET status='approved',
        notification='✅ Your booking has been approved!',
        is_read=0
    WHERE id=$id
    ");
}

if(isset($_GET['reject'])){
    $id = intval($_GET['reject']);

    mysqli_query($conn,"
    UPDATE bookings 
    SET status='rejected',
        notification='❌ Your booking has been rejected.',
        is_read=0
    WHERE id=$id
    ");
}
   


// ✅ FETCH BOOKINGS
$res = mysqli_query($conn,"
SELECT b.*, p.title 
FROM bookings b
JOIN properties p ON b.property_id = p.id
ORDER BY b.id DESC
");
?>

<div class="container">

<h2 class="section-title">Bookings Management 📋</h2>

<div class="glass">

<table style="width:100%; text-align:left;">
<tr>
    <th>User Name</th>
    <th>Property</th>
    <th>Phone</th>
    <th>Message</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($res)){ 

    $status = $row['status'] ?? 'pending';
?>

<tr>
    <!-- ✅ USER NAME FROM BOOKING FORM -->
    <td><?php echo $row['name']; ?></td>

    <td><?php echo $row['title']; ?></td>

    <!-- ✅ EXTRA DETAILS -->
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['message']; ?></td>

    <!-- ✅ STATUS -->
    <td>
        <span style="
        color:
        <?php 
            if($status=='approved') echo 'lightgreen';
            elseif($status=='rejected') echo 'red';
            else echo 'orange';
        ?>;
        font-weight:bold;
        ">
        <?php echo ucfirst($status); ?>
        </span>
    </td>

    <!-- ✅ ACTION -->
    <td>
        <a href="?approve=<?php echo $row['id']; ?>">
            <button>Approve</button>
        </a>
        

        <a href="?reject=<?php echo $row['id']; ?>">
            <button style="background:light-blue;">Reject</button>
        </a>
        
    </td>

</tr>

<?php } ?>

</table>

</div>

<div style="text-align:center; margin-top:20px;">
    <a href="dashboard.php" class="back-btn" >⬅ Back to </a>
</div>

</div>

<?php include("../includes/footer.php"); ?>