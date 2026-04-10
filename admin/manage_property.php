<?php
session_start();

// 🔐 Check Admin Login
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access Denied");
}

include("../config/db.php");

// ✅ MOVE DELETE LOGIC HERE (TOP)
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM properties WHERE id=$id");
    header("Location: manage_property.php");
    exit();
}

include("../includes/admin_header.php");
?>

<div class="container">

    <h2>Manage Properties</h2>

    <?php
    $res = mysqli_query($conn, "SELECT * FROM properties");

    while($row = mysqli_fetch_assoc($res)){
    ?>

    <div class="glass card">

        <h3><?php echo $row['title']; ?></h3>
        <p>₹<?php echo $row['price']; ?></p>

        <!-- ✏️ UPDATE BUTTON -->
        <a href="add_property.php?id=<?php echo $row['id']; ?>">
            <button type="button">Update</button>
        </a>

        <!-- ❌ DELETE BUTTON -->
        <a href="?delete=<?php echo $row['id']; ?>" 
           onclick="return confirm('Are you sure you want to delete this property?')">
            <button type="button">Delete</button>
        </a>

    </div>
    <br>

    <?php } ?>

    <br>
    <a href="dashboard.php">
        <button type="button">⬅ Back</button>
    </a>

</div>

<?php include("../includes/footer.php"); ?>