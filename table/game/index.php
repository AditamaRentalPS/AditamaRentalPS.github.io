<?php
session_start();

// Proteksi: hanya admin yang boleh akses
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../../login.php");
    exit;
}

// Koneksi database
include __DIR__ . '/../../db.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Game</title>

    <!-- Font & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .thumbnail-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 8px;
        }
    </style>
</head>

<body class="bg-gray-900 text-white min-h-screen p-10">

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold">Daftar Judul Game</h3>
            <a href="../../logout.php" class="text-sm text-red-400 hover:text-red-200">Logout</a>
        </div>

        <a href="tambah.php" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Game
        </a>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Judul Game</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM games");

                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr class='bg-gray-900 hover:bg-gray-700'>
                                <td class='px-6 py-4 text-sm text-gray-300'>{$row['id']}</td>
                                <td class='px-6 py-4'>
                                    <img src='../../{$row['gambar']}' class='w-16 h-16 object-cover rounded'>
                                </td>
                                <td class='px-6 py-4 text-sm text-gray-200'>{$row['nama_game']}</td>
                                <td class='px-6 py-4'>
                                    <a href='edit.php?id={$row['id']}' class='text-blue-400 hover:text-blue-200 mr-3'>Edit</a>
                                    <a href='hapus.php?id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-400 hover:text-red-200'>Hapus</a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
