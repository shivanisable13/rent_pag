<?php
include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM properties WHERE id=$id"));

// ✅ SAFE CAPACITY FIX
$capacity = isset($data['capacity']) ? $data['capacity'] : 1;

// ✅ BOOKED COUNT
$booked = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM bookings 
WHERE property_id='$id' AND status='approved'
"))['total'];

// ✅ REMAINING
$remaining = $capacity - $booked;
?>

<div class="container">
<div class="property-layout">

<!-- 🔵 LEFT SIDE -->
<div>

<?php
$images = mysqli_query($conn,"SELECT * FROM property_images WHERE property_id=$id");
$imageList = [];
while($row = mysqli_fetch_assoc($images)){
    $imageList[] = $row;
}
?>

<div class="glass">

<img id="mainImage" src="../uploads/<?php echo $data['image']; ?>" 
style="width:100%;border-radius:15px; cursor:pointer;"
onclick="openImage(this.src)">

<div id="imagePopup" style="display:none;position:fixed;top:0; left:0;width:100%; height:100%;background:rgba(0,0,0,0.8);justify-content:center;align-items:center;z-index:999;">
<img id="popupImg" style="max-width:90%; max-height:90%; border-radius:10px;">
<span onclick="closeImage()" style="position:absolute; top:20px; right:30px; font-size:30px; color:#fff; cursor:pointer;">✖</span>
</div>

<br><br>

<div style="display:flex; gap:10px; overflow-x:auto;">
<?php foreach($imageList as $img){ ?>
<img src="../uploads/<?php echo $img['image']; ?>" class="thumbnail" onclick="changeImage(this)">
<?php } ?>
</div>

</div>

<br>

<div class="glass">
<h2><?php echo $data['title']; ?></h2>
<p><?php echo $data['address']; ?></p>
</div>

<br>

<h2 class="section-title">Amenities</h2>

<div class="grid">
<div class="glass card">📶 WiFi: <?php echo $data['wifi']; ?></div>
<div class="glass card">🧺 Laundry: <?php echo $data['laundry']; ?></div>
<div class="glass card">🍽 Meals: <?php echo $data['meals']; ?></div>
<div class="glass card">🏋 Gym: <?php echo $data['gym']; ?></div>
<div class="glass card">🧹 Cleaning: <?php echo $data['cleaning']; ?></div>
<div class="glass card">🔒 Security: <?php echo $data['security']; ?></div>
</div>

<br>

<h2 class="section-title">Description</h2>

<div class="glass">
<p><?php echo $data['description']; ?></p>
</div>

<br>

<h2 class="section-title">Location</h2>

<div class="glass">
<iframe width="100%" height="250"
src="https://maps.google.com/maps?q=<?php echo urlencode($data['address']); ?>&output=embed">
</iframe>
</div>

</div>

<!-- 🟣 RIGHT SIDE -->
<div>

<div class="glass" style="position:sticky; top:100px;">

<h2 style="color:#8b5cf6;">₹<?php echo $data['price']; ?>/ monthly</h2>
<p style="opacity:0.7;">Utility Included • No Brokerage</p>

<br>

<!-- ✅ AVAILABILITY -->
<p>
👥 Sharing: <?php echo $capacity; ?><br>

<?php if($remaining == 1){ ?>
<span style="color:red;font-weight:bold;">⚠ Only 1 seat left!</span>
<?php } else { ?>
✅ Available: <?php echo max(0,$remaining); ?>
<?php } ?>
</p>

<br>

<!-- ✅ BOOK BUTTON -->
<?php if($remaining > 0){ ?>
<a href="book.php?id=<?php echo $data['id']; ?>">
<button style="width:100%;">Book Now</button>
</a>
<?php } else { ?>
<button style="width:100%; background:#6366f1, #a855f7; color:white;" disabled>
Fully Booked 
</button>
<?php } ?>

<br><br>

<h3>Owner</h3>

<div style="display:flex;align-items:center;gap:10px;">
<div class="avatar">👤</div>
<div>
<p><?php echo $data['owner_name']; ?></p>
<small>Property Owner</small>
</div>
</div>

<br>

<a href="tel:<?php echo $data['contact']; ?>">
<button style="width:100%;">Call Owner</button>
</a>

<br><br>

<a href="https://wa.me/<?php echo $data['contact']; ?>" target="_blank">
<button style="width:100%; background:green;">WhatsApp</button>
</a>

</div>

</div>

</div>
</div>

<script>
function changeImage(el){
    document.getElementById("mainImage").src = el.src;
}

function openImage(src){
    document.getElementById("popupImg").src = src;
    document.getElementById("imagePopup").style.display = "flex";
}

function closeImage(){
    document.getElementById("imagePopup").style.display = "none";
}

let images = [];
<?php foreach($imageList as $img){ ?>
images.push("../uploads/<?php echo $img['image']; ?>");
<?php } ?>

let index = 0;

setInterval(()=>{
    if(images.length > 0){
        index = (index + 1) % images.length;
        document.getElementById("mainImage").src = images[index];
    }
}, 3000);

// 🔄 AUTO REFRESH
setInterval(()=>{
    location.reload();
}, 10000);
</script>

<?php include("../includes/footer.php"); ?>