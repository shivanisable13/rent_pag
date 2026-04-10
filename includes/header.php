

<!DOCTYPE html>
<html>
<head>
    <title>CampusStay</title>

    <link rel="stylesheet" href="/campusstay/assets/css/style.css">
    <script src="/campusstay/assets/js/script.js" defer></script>
</head>

<body>

<!-- 🔥 PARTICLES BACKGROUND -->


<!-- NAVBAR -->
<div class="navbar glass">
    <h2>CampusStay</h2>

    <div style="display:flex;align-items:center;gap:10px;">

        <a href="/campusstay/user/home.php"><button>Home</button></a>
                <a href="about.php">
    <button>about us </button>
</a>
        <a href="/campusstay/user/listing.php"><button>Listings</button></a>
        <a href="notifications.php">
    <button>Notifications</button>
</a>

        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){ ?>
           
        <?php } ?>

        <!-- PROFILE DROPDOWN -->
        <div class="profile-menu">
            <div class="avatar" onclick="toggleMenu()">👤</div>

            <div id="dropdown" class="dropdown">
                <p>Welcome To CampusStay</p>
                <hr>

                <?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){ ?>
                   
                <?php } ?>

                <a href="/campusstay/user/logout.php">Logout</a>
            </div>
        </div>

    </div>
</div>

<!-- MAIN CONTAINER -->
<div class="container">