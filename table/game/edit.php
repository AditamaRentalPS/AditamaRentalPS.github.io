<?php
include __DIR__ . '/../../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM games WHERE id = $id"));

// Handle POST update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_game = $_POST['nama_game'];
    $gambar = $data['gambar']; // Default: gambar lama

    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = '../../uploads/';
        $filename = basename($_FILES['gambar']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $gambar = 'uploads/' . $filename;
        }
    }

    mysqli_query($conn, "UPDATE games SET gambar='$gambar', nama_game='$nama_game' WHERE id = $id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Game</h2>
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Gambar Saat Ini:</label>
                <img src="../../<?= $data['gambar'] ?>" width="100" class="rounded shadow">
            </div>
            <div>
                <label for="gambar" class="block text-sm font-medium mb-1">Ganti Gambar:</label>
                <input type="file" name="gambar" id="gambar" class="w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600">
            </div>
            <div>
                <label for="nama_game" class="block text-sm font-medium mb-1">Nama Game:</label>
                <input type="text" name="nama_game" id="nama_game" value="<?= htmlspecialchars($data['nama_game']) ?>" required class="w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600">
            </div>
            <div class="flex justify-between items-center">
                <a href="index.php" class="text-sm text-blue-400 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white font-semibold">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
