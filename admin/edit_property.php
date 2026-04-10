<?php
session_start();

// 🔐 Check admin login
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access Denied");
}

include("../config/db.php");

// ✅ CHECK ID
if(!isset($_GET['id'])){
    header("Location: manage_property.php");
    exit();
}

$id = $_GET['id'];

// ✅ FETCH PROPERTY DATA
$res = mysqli_query($conn, "SELECT * FROM properties WHERE id=$id");
$data = mysqli_fetch_assoc($res);

// ❌ IF NOT FOUND
if(!$data){
    echo "Property not found";
    exit();
}

// ✅ UPDATE LOGIC
if(isset($_POST['update'])){

    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    mysqli_query($conn, "UPDATE properties SET 
        title='$title',
        price='$price',
        description='$description'
        WHERE id=$id
    ");

    // 🔁 REDIRECT AFTER UPDATE
    header("Location: manage_property.php"); // or dashboard.php
    exit();
}

include("../includes/header.php");
?>

<div class="container">

    <h2>Edit Property</h2>

    <form method="POST">

        <!-- TITLE -->
        <input type="text" name="title"
            value="<?php echo $data['title']; ?>" required>

        <!-- PRICE -->
        <input type="number" name="price"
            value="<?php echo $data['price']; ?>" required>

        <!-- DESCRIPTION -->
        <textarea name="description"><?php echo $data['description']; ?></textarea>

        <!-- UPDATE BUTTON -->
        <button type="submit" name="update">Update Property</button>

    </form>

    <br>

    <!-- 🔙 BACK BUTTON -->
    <a href="manage_property.php">
        <button type="button">⬅ Back</button>
    </a>

</div>

<?php include("../includes/footer.php"); ?>