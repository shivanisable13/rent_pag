<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_name = $_SESSION['user_name'] ?? 'User';
?>

<!DOCTYPE html>
<html>
<head>
    <title>CampusStay</title>

    <link rel="stylesheet" href="/campusstay/assets/css/style.css">
    <script src="/campusstay/assets/js/script.js" defer></script>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar glass">
    <h2>CampusStay</h2>

    <div style="display:flex;align-items:center;gap:10px;">

        <a href="/campusstay/user/home.php"><button>Home</button></a>

        <a href="about.php">
            <button>About Us</button>
        </a>

        <a href="/campusstay/user/listing.php"><button>Listings</button></a>

        <a href="notifications.php">
            <button>Notifications</button>
        </a>

        <!-- PROFILE DROPDOWN -->
        <div class="profile-menu">
            <div class="avatar" onclick="toggleMenu()">👤</div>

            <div id="dropdown" class="dropdown">
                
                <!-- ✅ USER NAME DISPLAY -->
                <p>Welcome <b><?php echo htmlspecialchars($user_name); ?></b></p>
                <hr>

                <a href="/campusstay/user/logout.php">Logout</a>
            </div>
        </div>

    </div>
</div>

<!-- MAIN CONTAINER -->
<div class="container">