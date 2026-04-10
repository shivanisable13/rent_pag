<?php 
include("../config/db.php"); 
include("../includes/header.php"); 
?>

<div class="container">

<h2 class="section-title">Find Your Perfect Stay 🔍</h2>

<!-- 🔥 PREMIUM SEARCH BOX -->
<form method="GET" class="glass" style="
margin:30px 0;
padding:25px;
border-radius:20px;
background:rgba(255,255,255,0.05);
">

<div style="display:flex; gap:15px; flex-wrap:wrap; align-items:center;">

    <!-- SEARCH -->
    <input type="text" name="search" placeholder="🔍 Search location or property..."
    value="<?php echo $_GET['search'] ?? ''; ?>"
    style="
    flex:2;
    padding:15px;
    border-radius:15px;
    background:rgba(0,0,0,0.6);
    border:none;
    color:white;
    ">

    <!-- TYPE -->
    <select name="type" style="flex:1; padding:15px; border-radius:15px;">
        <option value="">All</option>
        <option value="boys" <?php if(($type ?? '')=='boys') echo 'selected'; ?>>Boys</option>
        <option value="girls" <?php if(($type ?? '')=='girls') echo 'selected'; ?>>Girls</option>
    </select>

    <!-- SHARING -->
    <select name="sharing" style="flex:1; padding:15px; border-radius:15px;">
        <option value="">Any Sharing</option>
        <option value="single" <?php if(($sharing ?? '')=='single') echo 'selected'; ?>>Single</option>
        <option value="double" <?php if(($sharing ?? '')=='double') echo 'selected'; ?>>Double</option>
        <option value="triple" <?php if(($sharing ?? '')=='triple') echo 'selected'; ?>>Triple</option>
    </select>

    <!-- BUTTON -->
    <button style="padding:15px 25px;">Search</button>

</div>

</form>

<?php
$search = $_GET['search'] ?? '';
$type = $_GET['type'] ?? '';
$sharing = $_GET['sharing'] ?? '';

// 🔐 Prevent SQL injection
$search = mysqli_real_escape_string($conn, $search);
$type = mysqli_real_escape_string($conn, $type);
$sharing = mysqli_real_escape_string($conn, $sharing);

$query = "SELECT * FROM properties WHERE 1=1";

// 🔍 SEARCH (FIXED - include location)
if($search != ''){
    $query .= " AND (title LIKE '%$search%' OR address LIKE '%$search%')";
}

// 👦 TYPE FILTER
if($type != ''){
    $query .= " AND type='$type'";
}

// 🛏️ SHARING FILTER
if($sharing != ''){
    $query .= " AND sharing='$sharing'";
}

$result = mysqli_query($conn,$query);
?>

<!-- 🏠 PROPERTY CARDS -->
<div class="grid">

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="glass card" style="padding:0; overflow:hidden;">

    <!-- IMAGE -->
    <div style="position:relative;">
        <img src="../uploads/<?php echo $row['image']; ?>" 
             style="width:100%; height:220px; object-fit:cover;">

        <!-- PRICE -->
        <div style="
            position:absolute;
            bottom:10px;
            right:10px;
            background:rgba(0,0,0,0.7);
            padding:6px 12px;
            border-radius:12px;
            color:#8b5cf6;
            font-weight:bold;
        ">
            ₹<?php echo $row['price']; ?>/monthly
        </div>

        <!-- BADGE -->
        <div style="
            position:absolute;
            top:10px;
            left:10px;
            background:#8b5cf6;
            padding:5px 10px;
            border-radius:10px;
            font-size:12px;
        ">
            
        </div>
    </div>

    <!-- DETAILS -->
    <div style="padding:15px;">

        <h3><?php echo $row['title']; ?></h3>
        <p style="opacity:0.6;">
    📍 <?php echo $row['address']; ?></p>



        <p style="opacity:0.7;">
            <?php echo ucfirst($row['type']); ?> • 
            <?php echo ucfirst($row['sharing']); ?>
        </p>

        <br>

      <a href="property.php?id=<?php echo $row['id']; ?>">
    <button class="view-btn">View Details</button>
</a>

    </div>

</div>

<?php } ?>

<?php } else { ?>

<!-- ❗ NO RESULTS -->
<div class="glass" style="padding:30px; text-align:center;">
    <h3>No properties found 😢</h3>
    <p>Try changing filters</p>
</div>

<?php } ?>

</div>

</div>

<?php include("../includes/footer.php"); ?>