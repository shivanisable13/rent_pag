<?php
include("../config/db.php");
include("../includes/admin_header.php");

// ✅ Fetch ALL paid bookings (NO role filter)
$res = mysqli_query($conn,"
SELECT b.*, p.title, u.name as username
FROM bookings b
LEFT JOIN properties p ON b.property_id = p.id
LEFT JOIN users u ON b.user_id = u.id
WHERE LOWER(TRIM(b.payment_status)) = 'paid'
ORDER BY b.id DESC
");
?>

<div class="container">
<h2 style="text-align:center;margin:20px 0;">💳 Payment Dashboard</h2>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
<tr style="background:#333;color:white;">
    <th>Booking ID</th>
    <th>User</th>
    <th>Property</th>
    <th>Amount (₹)</th>
    <th>Payment ID</th>
    <th>Date</th>
    <th>Agreement</th>
</tr>

<?php if(mysqli_num_rows($res) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($res)){ ?>

<tr>
    <td><?php echo $row['id']; ?></td>

    <!-- ✅ Show correct username -->
    <td><?php echo htmlspecialchars($row['username'] ?? 'Unknown'); ?></td>

    <td><?php echo htmlspecialchars($row['title'] ?? 'N/A'); ?></td>

    <td>₹<?php echo $row['amount']; ?></td>

    <td><?php echo $row['payment_id']; ?></td>

    <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>

    <td>
        <a href="agreement.php?booking_id=<?php echo $row['id']; ?>"
           target="_blank"
           style="padding:6px 12px;background:#16a34a;color:white;border-radius:5px;text-decoration:none;">
           Send Agreement 📄
        </a>
    </td>
</tr>

<?php } ?>

<?php } else { ?>

<tr>
    <td colspan="7" style="text-align:center;">No payments yet</td>
</tr>

<?php } ?>

</table>
</div>