<?php
// echo '<pre>';
// print_r($_POST);
// die;
// WAJIB: koneksi DB (PDO)
require_once __DIR__ . '/includes/db.php';

// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php');
  exit;
}

// ===============================
// VALIDASI DATA WAJIB
// ===============================
$requiredFields = [
  'package',
  'phone',
  'rental_date',
  'duration_type',
  'duration',
  'total_price'
];

foreach ($requiredFields as $field) {
  if (!isset($_POST[$field]) || $_POST[$field] === '') {
    die('Data tidak lengkap.');
  }
}

// ===============================
// AMBIL & AMANKAN DATA
// ===============================
$name          = trim($_POST['name'] ?? '');
$package       = trim($_POST['package']);
$phone         = trim($_POST['phone']);
$rental_date   = $_POST['rental_date'];
$duration_type = $_POST['duration_type'];
$duration      = (int) $_POST['duration'];
$total_price   = (int) $_POST['total_price'];

// ===============================
// SIMPAN KE DATABASE
// ===============================
try {
  $stmt = $pdo->prepare("
    INSERT INTO orders
    (name, package, phone, rental_date, duration_type, duration, total_price, status)
    VALUES
    (:name, :package, :phone, :rental_date, :duration_type, :duration, :total_price, 'paid')
  ");

  $stmt->execute([
    ':name'          => $name,
    ':package'       => $package,
    ':phone'         => $phone,
    ':rental_date'   => $rental_date,
    ':duration_type' => $duration_type,
    ':duration'      => $duration,
    ':total_price'   => $total_price
  ]);

} catch (PDOException $e) {
  die('Gagal menyimpan order: ' . $e->getMessage());
}

// ===============================
// REDIRECT KE SUCCESS PAGE
// ===============================
header('Location: success.php');
exit;