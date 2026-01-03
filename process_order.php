<?php
echo '<pre>';
print_r($_POST);
die;

session_start();
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

if (
  empty($_POST['package']) ||
  empty($_POST['phone']) ||
  empty($_POST['total_price'])
) {
  die('Data tidak lengkap.');
}                           

// Ambil data POST
$package  = $_POST['package'] ?? '';
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$date     = $_POST['rental_date'] ?? '';
$duration = (int)($_POST['duration'] ?? 0);
$type     = $_POST['duration_type'] ?? '';

if (!$package || !$email || !$date || $duration <= 0) {
    die("Data tidak lengkap.");
}

$conn->begin_transaction();

try {
    // 1️⃣ Lock produk & cek stok
    $stmt = $conn->prepare(
        "SELECT stock, daily_rate, hourly_rate 
         FROM products 
         WHERE slug = ? 
         FOR UPDATE"
    );
    $stmt->bind_param("s", $package);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product || $product['stock'] <= 0) {
        throw new Exception("Stok habis.");
    }

    // 2️⃣ Hitung total harga
    $total = ($type === 'hari')
        ? $duration * $product['daily_rate']
        : $duration * $product['hourly_rate'];

    // 3️⃣ Simpan order
    $stmt = $conn->prepare(
        "INSERT INTO orders 
        (product_slug, email, phone, rental_date, duration, duration_type, total_price)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssssisi",
        $package,
        $email,
        $phone,
        $date,
        $duration,
        $type,
        $total
    );
    $stmt->execute();

    // 4️⃣ Kurangi stok
    $stmt = $conn->prepare(
        "UPDATE products SET stock = stock - 1 WHERE slug = ?"
    );
    $stmt->bind_param("s", $package);
    $stmt->execute();

    // 5️⃣ Commit
    $conn->commit();

  header('Location: success.php');
    exit;

} catch (Exception $e) {
    $conn->rollback();
    die("Order gagal: " . $e->getMessage());
}
