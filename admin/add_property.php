<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    die("Access Denied");
}

include("../config/db.php"); 
include("../includes/admin_header.php");

// ✅ CHECK EDIT MODE
$id = "";
$edit = false;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $edit = true;

    $res = mysqli_query($conn, "SELECT * FROM properties WHERE id=$id");
    $data = mysqli_fetch_assoc($res);
}

// ✅ SUBMIT (ADD + UPDATE)
if(isset($_POST['submit'])){

    $title=$_POST['title'];
    $address=$_POST['address'];
    $price=$_POST['price'];
    $type=$_POST['type'];
    $sharing=$_POST['sharing'];
    $owner=$_POST['owner'];
    $contact=$_POST['contact'];

    $wifi=$_POST['wifi'];
    $laundry=$_POST['laundry'];
    $meals=$_POST['meals'];
    $gym=$_POST['gym'];
    $cleaning=$_POST['cleaning'];
    $security=$_POST['security'];
    $description=$_POST['description'];

    $image=$_FILES['image']['name'];

    // ✏️ UPDATE
    if($edit){

        if($image){
            move_uploaded_file($_FILES['image']['tmp_name'],"../uploads/".$image);

            mysqli_query($conn,"UPDATE properties SET
                title='$title',
                address='$address',
                price='$price',
                type='$type',
                sharing='$sharing',
                image='$image',
                owner_name='$owner',
                contact='$contact',
                wifi='$wifi',
                laundry='$laundry',
                meals='$meals',
                gym='$gym',
                cleaning='$cleaning',
                security='$security',
                description='$description'
                WHERE id=$id
            ");
        } else {
            mysqli_query($conn,"UPDATE properties SET
                title='$title',
                address='$address',
                price='$price',
                type='$type',
                sharing='$sharing',
                owner_name='$owner',
                contact='$contact',
                wifi='$wifi',
                laundry='$laundry',
                meals='$meals',
                gym='$gym',
                cleaning='$cleaning',
                security='$security',
                description='$description'
                WHERE id=$id
            ");
        }

        echo "<script>alert('Property Updated Successfully'); window.location='manage_property.php';</script>";

    } else {

        // ➕ INSERT
        move_uploaded_file($_FILES['image']['tmp_name'],"../uploads/".$image);

        mysqli_query($conn,"INSERT INTO properties
        (title,address,price,type,sharing,image,owner_name,contact,wifi,laundry,meals,gym,cleaning,security,description)
        VALUES
        ('$title','$address','$price','$type','$sharing','$image','$owner','$contact','$wifi','$laundry','$meals','$gym','$cleaning','$security','$description')");

        $property_id = mysqli_insert_id($conn);

        // MULTIPLE IMAGES (MIN 5 REQUIRED)
if(!empty($_FILES['images']['name'][0])){

    $total = count($_FILES['images']['name']);

    if($total < 5){
        echo "<script>alert('Please upload at least 5 images');</script>";
    } else {

        for($i=0; $i<$total; $i++){

            $filename = time().'_'.$_FILES['images']['name'][$i];
            $tmp = $_FILES['images']['tmp_name'][$i];

            move_uploaded_file($tmp, "../uploads/".$filename);

            mysqli_query($conn,"INSERT INTO property_images(property_id,image)
            VALUES('$property_id','$filename')");
        }
    }
}
        

        echo "<script>alert('Property Added Successfully');</script>";
    }
}
?>

<div class="container">

<h2 class="section-title">
    <?php echo $edit ? "Update Property ✏️" : "Add Property 🏠"; ?>
</h2>

<form method="POST" enctype="multipart/form-data" class="glass">

<div class="grid">

    <input name="title" placeholder="Title" required
    value="<?php echo $edit ? $data['title'] : ''; ?>">

    <input name="address" placeholder="Address" required
    value="<?php echo $edit ? $data['address'] : ''; ?>">

    <input name="price" placeholder="Price" required
    value="<?php echo $edit ? $data['price'] : ''; ?>">

    <select name="type">
        <option value="boys" <?php if($edit && $data['type']=="boys") echo "selected"; ?>>Boys</option>
        <option value="girls" <?php if($edit && $data['type']=="girls") echo "selected"; ?>>Girls</option>
    </select>

    <select name="sharing">
        <option value="single" <?php if($edit && $data['sharing']=="single") echo "selected"; ?>>Single</option>
        <option value="double" <?php if($edit && $data['sharing']=="double") echo "selected"; ?>>Double</option>
        <option value="triple" <?php if($edit && $data['sharing']=="triple") echo "selected"; ?>>Triple</option>
    </select>

    <input name="owner" placeholder="Owner Name" required
    value="<?php echo $edit ? $data['owner_name'] : ''; ?>">

    <input name="contact" placeholder="Contact Number" required
    value="<?php echo $edit ? $data['contact'] : ''; ?>">
    <label>Main Image</label>
    <input type="file" name="image">

</div>

<br>

<h3>Gallery Images 📸</h3>

<div class="glass" style="padding:20px;">
    <input type="file" name="images[]" multiple>
</div>

<br>

<h3>Amenities</h3>

<div class="grid">

<select name="wifi">
<option value="Yes" <?php if($edit && $data['wifi']=="Yes") echo "selected"; ?>>WiFi</option>
<option value="No" <?php if($edit && $data['wifi']=="No") echo "selected"; ?>>No WiFi</option>
</select>

<select name="laundry">
<option value="Yes" <?php if($edit && $data['laundry']=="Yes") echo "selected"; ?>>Laundry</option>
<option value="No" <?php if($edit && $data['laundry']=="No") echo "selected"; ?>>No Laundry</option>
</select>

<select name="meals">
<option value="Yes" <?php if($edit && $data['meals']=="Yes") echo "selected"; ?>>Meals</option>
<option value="No" <?php if($edit && $data['meals']=="No") echo "selected"; ?>>No Meals</option>
</select>

<select name="gym">
<option value="Yes" <?php if($edit && $data['gym']=="Yes") echo "selected"; ?>>Gym</option>
<option value="No" <?php if($edit && $data['gym']=="No") echo "selected"; ?>>No Gym</option>
</select>

<select name="cleaning">
<option value="Yes" <?php if($edit && $data['cleaning']=="Yes") echo "selected"; ?>>Cleaning</option>
<option value="No" <?php if($edit && $data['cleaning']=="No") echo "selected"; ?>>No Cleaning</option>
</select>

<select name="security">
<option value="Yes" <?php if($edit && $data['security']=="Yes") echo "selected"; ?>>Security</option>
<option value="No" <?php if($edit && $data['security']=="No") echo "selected"; ?>>No Security</option>
</select>

</div>

<br>

<textarea name="description" placeholder="Description"
style="width:100%; height:120px;">
<?php echo $edit ? $data['description'] : ''; ?>
</textarea>

<br><br>

<button name="submit" style="width:100%;">
<?php echo $edit ? "Update Property" : "Add Property"; ?>
</button>

</form>

<div style="text-align:center; margin-top:20px;">
    <a href="dashboard.php" class="back-btn">⬅ Back to </a>
</div>


</div>

<?php include("../includes/footer.php"); ?>