<?php 
include("../config/db.php"); 
include("../includes/header.php"); 
?>

<div class="container">

<h2 class="section-title">Find Your Perfect Stay 🔍</h2>

<form method="GET" class="glass" style="margin:30px 0;padding:25px;">
<div style="display:flex; gap:15px; flex-wrap:wrap; align-items:center;">
<input type="text" name="search" placeholder="🔍 Search..." value="<?php echo $_GET['search'] ?? ''; ?>" style="flex:2;padding:15px;border-radius:15px;">
<select name="type" style="flex:1;padding:15px;">
<option value="">All</option>
<option value="boys">Boys</option>
<option value="girls">Girls</option>
</select>
<select name="sharing" style="flex:1;padding:15px;">
<option value="">Any Sharing</option>
<option value="single">Single</option>
<option value="double">Double</option>
<option value="triple">Triple</option>
</select>
<button style="padding:15px 25px;">Search</button>
</div>
</form>

<?php
$search = $_GET['search'] ?? '';
$type = $_GET['type'] ?? '';
$sharing = $_GET['sharing'] ?? '';

$query = "SELECT * FROM properties WHERE 1=1";

if($search != '') $query .= " AND (title LIKE '%$search%' OR address LIKE '%$search%')";
if($type != '') $query .= " AND type='$type'";
if($sharing != '') $query .= " AND sharing='$sharing'";

$result = mysqli_query($conn,$query);
?>

<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)){ 

// ✅ COUNT BOOKINGS
$booked = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM bookings 
WHERE property_id='{$row['id']}' AND status='approved'
"))['total'];
$capacity = isset($row['capacity']) ? $row['capacity'] : 1;
$remaining = $capacity - $booked;
?>

<div class="glass card" style="padding:0; overflow:hidden;">

<img src="../uploads/<?php echo $row['image']; ?>" 
style="width:100%; height:220px; object-fit:cover;">

<div style="padding:15px;">

<h3><?php echo $row['title']; ?></h3>
<p>📍 <?php echo $row['address']; ?></p>

<p><?php echo ucfirst($row['type']); ?> • <?php echo ucfirst($row['sharing']); ?></p>

<!-- ✅ AVAILABLE -->
<p style="color:#22c55e;">
👥 Available: <?php echo max(0,$remaining); ?>
</p>

<br>

<a href="property.php?id=<?php echo $row['id']; ?>">
<button class="view-btn">View Details</button>
</a>

</div>

</div>

<?php } ?>

</div>

</div>

<?php include("../includes/footer.php"); ?>