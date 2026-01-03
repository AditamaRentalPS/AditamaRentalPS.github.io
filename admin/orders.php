<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../auth/login.php');
    exit;
}

$sql = "
SELECT 
  o.id,
  o.email,
  o.phone,
  o.rental_date,
  o.duration,
  o.duration_type,
  o.total_price,
  o.created_at,
  p.name AS product_name
FROM orders o
JOIN products p ON o.package = p.code
ORDER BY o.created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}


$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - Data Order</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Daftar Order Masuk</h1>

<table>
  <thead>
    <tr>
      <th>Produk</th>
      <th>Email</th>
      <th>Telepon</th>
      <th>Tanggal</th>
      <th>Durasi</th>
      <th>Total</th>
      <th>Waktu Order</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($o = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($o['product_name']) ?></td>
      <td><?= htmlspecialchars($o['email']) ?></td>
      <td><?= htmlspecialchars($o['phone']) ?></td>
      <td><?= $o['rental_date'] ?></td>
      <td><?= $o['duration'].' '.$o['duration_type'] ?></td>
      <td>Rp<?= number_format($o['total_price'],0,',','.') ?></td>
      <td><?= $o['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
