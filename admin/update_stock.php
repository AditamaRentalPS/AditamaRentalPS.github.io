<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Proteksi admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $ps_type = trim($_POST['ps_type']);
    $stock = (int)$_POST['stock'];
    $price_day = (int)$_POST['price_per_day'];
    $price_hour = (int)$_POST['price_per_hour'];

    if ($id) {
        // UPDATE
        $stmt = $conn->prepare(
            "UPDATE ps_stock 
             SET ps_type=?, stock=?, price_per_day=?, price_per_hour=? 
             WHERE id=?"
        );
        $stmt->bind_param("siiii", $ps_type, $stock, $price_day, $price_hour, $id);
        $stmt->execute();
    } else {
        // CREATE
        $stmt = $conn->prepare(
            "INSERT INTO ps_stock (ps_type, stock, price_per_day, price_per_hour) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("siii", $ps_type, $stock, $price_day, $price_hour);
        $stmt->execute();
    }

    header("Location: update_stock.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM ps_stock WHERE id=$id");
    header("Location: update_stock.php");
    exit;
}

// READ
$result = $conn->query("SELECT * FROM ps_stock ORDER BY id ASC");

// EDIT MODE
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $edit = $conn->query("SELECT * FROM ps_stock WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - Update Stok PS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen p-8">

  <h1 class="text-2xl font-bold mb-6">Manajemen Stok PlayStation</h1>

  <!-- FORM CREATE / UPDATE -->
  <form method="POST" class="bg-gray-800 p-6 rounded mb-8 max-w-xl">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

    <div class="mb-4">
      <label class="block mb-1">Jenis PS</label>
      <input name="ps_type" required
        class="w-full p-2 rounded text-black"
        value="<?= $edit['ps_type'] ?? '' ?>">
    </div>

    <div class="mb-4">
      <label class="block mb-1">Jumlah Stok</label>
      <input type="number" name="stock" required
        class="w-full p-2 rounded text-black"
        value="<?= $edit['stock'] ?? '' ?>">
    </div>

    <div class="mb-4">
      <label class="block mb-1">Harga / Hari</label>
      <input type="number" name="price_per_day" required
        class="w-full p-2 rounded text-black"
        value="<?= $edit['price_per_day'] ?? '' ?>">
    </div>

    <div class="mb-4">
      <label class="block mb-1">Harga / Jam</label>
      <input type="number" name="price_per_hour" required
        class="w-full p-2 rounded text-black"
        value="<?= $edit['price_per_hour'] ?? '' ?>">
    </div>

    <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
      <?= $edit ? 'Update Stok' : 'Tambah Jenis PS' ?>
    </button>
  </form>

  <!-- TABLE READ -->
  <table class="w-full bg-gray-800 rounded">
    <thead>
      <tr class="bg-gray-700">
        <th class="p-2">Jenis PS</th>
        <th class="p-2">Stok</th>
        <th class="p-2">Harga/Hari</th>
        <th class="p-2">Harga/Jam</th>
        <th class="p-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr class="border-t border-gray-700">
        <td class="p-2"><?= $row['ps_type'] ?></td>
        <td class="p-2"><?= $row['stock'] ?></td>
        <td class="p-2">Rp<?= number_format($row['price_per_day']) ?></td>
        <td class="p-2">Rp<?= number_format($row['price_per_hour']) ?></td>
        <td class="p-2 space-x-2">
          <a href="?edit=<?= $row['id'] ?>" class="text-yellow-400">Edit</a>
          <a href="?delete=<?= $row['id'] ?>"
             onclick="return confirm('Hapus data ini?')"
             class="text-red-500">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>
</html>
