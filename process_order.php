<?php
// echo '<pre>';
// print_r($_POST);
// die;
require_once 'includes/db.php'; // koneksi DB

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php');
  exit;
}

// Validasi wajib
if (
  empty($_POST['package']) ||
  empty($_POST['phone']) ||
  empty($_POST['total_price'])
) {
  die('Data tidak lengkap.');
}

// Ambil data
$name          = $_POST['name'] ?? '';
$package       = $_POST['package'];
$phone         = $_POST['phone'];
$rental_date   = $_POST['rental_date'];
$duration_type = $_POST['duration_type'];
$duration      = (int)$_POST['duration'];
$total_price   = (int)$_POST['total_price'];

// Simpan ke DB
$stmt = $pdo->prepare("
  INSERT INTO orders 
  (name, package, phone, rental_date, duration_type, duration, total_price, status)
  VALUES (?, ?, ?, ?, ?, ?, ?, 'paid')
");

$stmt->execute([
  $name,
  $package,
  $phone,
  $rental_date,
  $duration_type,
  $duration,
  $total_price
]);

// Redirect ke sukses
header('Location: success.php');
exit;
