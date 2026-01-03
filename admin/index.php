<?php
session_start();
require_once '../includes/db.php';

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proteksi admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Ambil produk
$result = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kelola Stok</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<style>
body {
  font-family: Arial, sans-serif;
  background: #0f172a;
  color: #e5e7eb;
  padding: 40px;
}

.admin-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.admin-header h1 {
  font-size: 28px;
}

.logout-btn {
  background: #ef4444;
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  cursor: pointer;
}

.logout-btn:hover {
  background: #dc2626;
}

table {
  width: 100%;
  max-width: 700px;
  background: #1f2933;
  border-radius: 10px;
  overflow: hidden;
}

th, td {
  padding: 14px;
  text-align: left;
}

th {
  background: #111827;
}

tr:not(:last-child) {
  border-bottom: 1px solid #374151;
}

input[type="number"] {
  width: 80px;
  padding: 6px;
  border-radius: 6px;
  border: none;
}

.save-btn {
  background: #2563eb;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
}

.save-btn:hover {
  background: #1d4ed8;
}
</style>

<body class="bg-gray-900 text-white p-8">

<h1 class="text-2xl font-bold mb-6">Kelola Stok PlayStation</h1>
<h2 style="margin-top:40px;">📦 Daftar Order Masuk</h2>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Paket</th>
      <th>No HP</th>
      <th>Tanggal</th>
      <th>Durasi</th>
      <th>Total</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($orders as $o): ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= htmlspecialchars($o['name']) ?></td>
        <td><?= $o['package'] ?></td>
        <td><?= $o['phone'] ?></td>
        <td><?= $o['rental_date'] ?></td>
        <td><?= $o['duration'] . ' ' . $o['duration_type'] ?></td>
        <td>Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
        <td><?= $o['status'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
  <div class="admin-header">
  <h1>Kelola Stok PlayStation</h1>

  <form action="../auth/logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
  </form>
</div>


<table class="w-full border-collapse bg-gray-800">
    <thead>
        <tr class="bg-gray-700">
            <th class="p-3 text-left">Produk</th>
            <th class="p-3">Stok</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="border-t border-gray-700">
            <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
            <td class="p-3 text-center"><?= $row['stock'] ?></td>
            <td class="p-3 text-center">
                <form action="update_stock.php" method="POST" class="inline-flex gap-2">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input
                        type="number"
                        name="stock"
                        min="0"
                        value="<?= $row['stock'] ?>"
                        class="w-20 text-black px-2 py-1 rounded"
                        required
                    >
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded"
                    >
                        Simpan
                    </button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>
