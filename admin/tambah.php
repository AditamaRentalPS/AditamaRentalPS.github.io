<?php
// tambah.php - Path: RENTAL_PS/table/game/tambah.php

// Aktifkan Error Reporting untuk debugging (Hapus/Nonaktifkan di produksi!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Proteksi: hanya admin yang boleh akses
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../../login.php"); // Pastikan path ke login.php benar
    exit;
}

// Sertakan file database connection
require_once __DIR__ . '/../../db.php'; // Path dari table/game/ ke db.php

// Pastikan koneksi database ($conn) sudah tersedia dan valid dari db.php
if (!isset($conn) || !$conn) {
    die("<div style='background-color: #dc2626; color: white; padding: 1rem; text-align: center; border-radius: 0.5rem;'>Error: Database connection not established. Check db.php.</div>");
}

// Handle POST request untuk menambah game
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Validasi dan sanitasi input nama game
    $nama_game = filter_input(INPUT_POST, 'nama_game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nama_game)) {
        echo "<script>alert('Nama game tidak boleh kosong.'); window.location.href='tambah.php';</script>";
        exit;
    }

    // Default path gambar jika tidak ada upload atau gagal
    $gambar_path_for_db = ''; // Bisa set ke 'uploads/default.jpg' jika ada gambar default

    // Konfigurasi direktori upload
    $upload_dir_server = __DIR__ . '/../../uploads/'; // Path dari table/game/ ke RENTAL_PS/uploads/
    $base_upload_path_web = 'uploads/'; // Ini path yang akan disimpan di DB (misal: 'uploads/namafile.jpg')

    // Pastikan folder uploads ada dan writable
    if (!is_dir($upload_dir_server)) {
        if (!mkdir($upload_dir_server, 0777, true)) {
            echo "<script>alert('Gagal membuat direktori upload: {$upload_dir_server}. Pastikan izin direktori.'); window.location.href='tambah.php';</script>";
            exit;
        }
    }

    // 2. Proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['gambar']['tmp_name'];
        $file_name_original = basename($_FILES['gambar']['name']);
        $file_extension = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        // Generate unique filename untuk mencegah penimpaan dan keamanan
        $new_file_name = uniqid('game_', true) . '.' . $file_extension;
        $target_file_server = $upload_dir_server . $new_file_name;

        // Validasi tipe file sederhana
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>alert('Format file tidak didukung. Hanya JPG, JPEG, PNG, GIF.'); window.location.href='tambah.php';</script>";
            exit;
        }

        // Pindahkan file yang diupload
        if (move_uploaded_file($file_tmp_name, $target_file_server)) {
            $gambar_path_for_db = $base_upload_path_web . $new_file_name;
        } else {
            echo "<script>alert('Gagal mengupload gambar. Error code: " . $_FILES['gambar']['error'] . "'); window.location.href='tambah.php';</script>";
            exit;
        }
    } else {
        // Jika input gambar wajib, Anda bisa un-komentari ini
        // echo "<script>alert('Harap upload gambar game.'); window.location.href='tambah.php';</script>";
        // exit;
    }

    // 3. Masukkan data ke database menggunakan Prepared Statement
    $stmt = mysqli_prepare($conn, "INSERT INTO games (nama_game, gambar) VALUES (?, ?)");

    if (!$stmt) {
        error_log("Prepared statement (INSERT) failed: " . mysqli_error($conn));
        echo "<script>alert('Gagal menyiapkan query database.'); window.location.href='tambah.php';</script>";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ss", $nama_game, $gambar_path_for_db); // "ss" for two strings

    $insert_success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    if ($insert_success) {
        header("Location: index.php?status=success_add");
        exit;
    } else {
        echo "<script>alert('Gagal menambah game: " . mysqli_error($conn) . "'); window.location.href='tambah.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Game Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif; /* Tambahkan font jika belum */
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Tambah Game Baru</h2>
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="nama_game" class="block text-sm font-medium mb-1">Nama Game:</label>
                <input type="text" name="nama_game" id="nama_game" required class="w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600">
            </div>
            <div>
                <label for="gambar" class="block text-sm font-medium mb-1">Gambar Game:</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" required class="w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG, GIF</p>
            </div>
            <div class="flex justify-between items-center">
                <a href="../../admin.php" class="text-sm text-blue-400 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white font-semibold">Tambah Game</button>
            </div>
        </form>
    </div>
</body>
</html>