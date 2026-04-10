<?php include(__DIR__ . "/../includes/header.php"); ?>

<link rel="stylesheet" href="../assets/css/style.css">

<style>
/* HERO */
.hero {
    text-align:center;
    padding:80px 20px;
}

.hero h1 {
    font-size:42px;
    margin-bottom:10px;
}

.hero p {
    font-size:18px;
    opacity:0.8;
}

/* SECTION */
.section {
    padding:60px 20px;
    max-width:1100px;
    margin:auto;
}

/* CARDS */
.cards {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap:20px;
}

.card {
    padding:25px;
    border-radius:20px;
    text-align:center;
    transition:0.3s;
}

.card:hover {
    transform:translateY(-10px);
    box-shadow:0 0 20px rgba(255,255,255,0.2);
}

/* TEAM */
.team {
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
}

.member {
    width:200px;
    text-align:center;
}

.member img {
    width:100%;
    border-radius:50%;
    margin-bottom:10px;
}

/* BUTTON */
.btn {
    padding:12px 25px;
    border:none;
    border-radius:10px;
    background:#8b5cf6;
    color:white;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover {
    background:#6d28d9;
}
</style>

<!-- HERO -->
<div class="hero">
    <h1>🏡 About CampusStay</h1>
    <p>Your trusted platform to find the perfect PG for students</p>
</div>

<!-- ABOUT -->
<div class="section glass">
    <h2 style="text-align:center;">Who We Are</h2>
    <p style="text-align:center; margin-top:15px;">
        CampusStay is designed to help students easily discover safe, affordable,
        and comfortable PG accommodations. We simplify the booking process and ensure
        transparency between users and property owners.
    </p>
</div>

<!-- FEATURES -->
<div class="section">
    <h2 style="text-align:center;">Why Choose Us?</h2>

    <div class="cards">
        <div class="card glass">
            <h3>🔍 Easy Search</h3>
            <p>Search PGs based on near college and preferences.</p>
        </div>

        <div class="card glass">
            <h3>🔐 Secure Booking</h3>
            <p>Safe booking system with admin approval.</p>
        </div>

        <div class="card glass">
            <h3>🔔 Notifications</h3>
            <p>Get real-time updates on booking status.</p>
        </div>

        <div class="card glass">
            <h3>💬 Support</h3>
            <p>We provide support to help you anytime.</p>
        </div>
    </div>
</div>

<!-- TEAM -->
<div class="section glass">
    <h2 style="text-align:center;">Our Team</h2>

    <div class="team">

        <div class="member">
            <img src="../assets/images/logo.png" alt="user">
            <h4>Team CampusStay</h4>
            <p>Building better living experiences</p>
        </div>

        <div class="member">
            <img src="../assets/images/pg1.jpg" alt="user">
            <h4>Creative Minds</h4>
            <p>Focused on simplicity & comfort</p>
        </div>

    </div>
</div>

<!-- CTA -->
<div class="section" style="text-align:center;">
    <h2>Ready to Find Your PG?</h2>
    <a href="home.php">
        <button class="btn">Explore Now 🚀</button>
    </a>
</div>

<?php include(__DIR__ . "/../includes/footer.php"); ?>