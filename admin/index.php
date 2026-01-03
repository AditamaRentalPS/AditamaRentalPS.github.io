<?php
session_start();
require_once '../includes/db.php';

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
<body class="bg-gray-900 text-white p-8">

<h1 class="text-2xl font-bold mb-6">Kelola Stok PlayStation</h1>

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
