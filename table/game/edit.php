<?php
// edit.php - Path: RENTAL_PS/table/game/edit.php

// 1. Sertakan file database connection
// Path dari RENTAL_PS/table/game/edit.php ke RENTAL_PS/db.php adalah dua level ke atas.
// require_once __DIR__ . '/../../db.php'; // Path ini sudah benar untuk struktur di atas

// Jika Anda menggunakan struktur public/includes seperti saran sebelumnya, pathnya akan berbeda:
// require_once __DIR__ . '/../../../includes/db.php'; // Jika edit.php di public/table/game/edit.php

// Mari kita asumsikan db.php ada di root proyek (RENTAL_PS/db.php)
require_once __DIR__ . '/../../db.php';

// Pastikan koneksi database ($conn) sudah tersedia dari db.php
if (!isset($conn) || !$conn) {
    die("Error: Database connection not established. Check db.php.");
}

// 2. Ambil ID dari URL dengan validasi dan keamanan
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Jika ID tidak valid, arahkan kembali
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// 3. Ambil data game saat ini menggunakan Prepared Statement (PENTING untuk keamanan)
$stmt_select = mysqli_prepare($conn, "SELECT id, nama_game, gambar FROM games WHERE id = ?");
if (!$stmt_select) {
    die("Prepared statement failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt_select, "i", $id); // "i" for integer
mysqli_stmt_execute($stmt_select);
$result_select = mysqli_stmt_get_result($stmt_select);
$data = mysqli_fetch_assoc($result_select);
mysqli_stmt_close($stmt_select);

// Jika data tidak ditemukan untuk ID tersebut, arahkan kembali
if (!$data) {
    header("Location: index.php");
    exit;
}

// 4. Handle POST update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input nama_game
    $nama_game = htmlspecialchars($_POST['nama_game']);

    // Ambil gambar lama sebagai default
    $gambar_path_for_db = $data['gambar']; // Path yang sudah ada di DB

    // Konfigurasi direktori upload
    // Path untuk menyimpan file di server (absolut atau relatif yang benar)
    $upload_dir_server = __DIR__ . '/../../uploads/'; // Dari edit.php ke RENTAL_PS/uploads/
    // Pastikan folder uploads ada dan writable
    if (!is_dir($upload_dir_server)) {
        mkdir($upload_dir_server, 0777, true); // Buat folder jika belum ada
    }

    // Path untuk disimpan di database (relatif dari root web/nama_folder_proyek)
    // Sesuaikan ini dengan bagaimana browser akan mengakses gambar
    // Jika RENTAL_PS adalah root web, maka 'uploads/' cukup.
    // Jika RENTAL_PS diakses via http://localhost/nama_folder_proyek/RENTAL_PS/, maka 'nama_folder_proyek/RENTAL_PS/uploads/'
    $base_upload_path_web = 'uploads/'; // Ini path yang akan disimpan di DB

    // 5. Proses upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['gambar']['tmp_name'];
        $file_name_original = basename($_FILES['gambar']['name']);
        $file_extension = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        // Generate unique filename to prevent overwriting and for security
        $new_file_name = uniqid('game_', true) . '.' . $file_extension;
        $target_file_server = $upload_dir_server . $new_file_name;

        // Validasi tipe file sederhana (opsional, bisa lebih ketat)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "<script>alert('Format file tidak didukung. Hanya JPG, JPEG, PNG, GIF.'); window.location.href='edit.php?id=$id';</script>";
            exit;
        }

        // Pindahkan file yang diupload
        if (move_uploaded_file($file_tmp_name, $target_file_server)) {
            // Hapus gambar lama jika ada dan bukan gambar default atau placeholder
            if (!empty($data['gambar']) && file_exists($upload_dir_server . basename($data['gambar']))) {
                // Pastikan gambar lama berada di folder uploads yang sama
                unlink($upload_dir_server . basename($data['gambar']));
            }
            $gambar_path_for_db = $base_upload_path_web . $new_file_name;
        } else {
            // Gagal upload, berikan pesan error
            echo "<script>alert('Gagal mengupload gambar.'); window.location.href='edit.php?id=$id';</script>";
            exit;
        }
    }

    // 6. Update data ke database menggunakan Prepared Statement
    $stmt_update = mysqli_prepare($conn, "UPDATE games SET gambar = ?, nama_game = ? WHERE id = ?");
    if (!$stmt_update) {
        die("Prepared statement failed: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt_update, "ssi", $gambar_path_for_db, $nama_game, $id); // "ssi" for string, string, integer
    $update_success = mysqli_stmt_execute($stmt_update);
    mysqli_stmt_close($stmt_update);

    if ($update_success) {
        header("Location: index.php?status=success_update");
        exit;
    } else {
        // Handle update failure
        echo "<script>alert('Gagal mengupdate data game: " . mysqli_error($conn) . "'); window.location.href='edit.php?id=$id';</script>";
        exit;
    }
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
                <?php
                // Pastikan path gambar untuk ditampilkan di browser adalah benar.
                // Jika $data['gambar'] disimpan sebagai 'uploads/namafile.jpg'
                // dan edit.php di RENTAL_PS/table/game/
                // Maka path relatif ke browser adalah dua level ke atas, lalu ke folder uploads
                $display_image_path = '../../' . htmlspecialchars($data['gambar']);
                ?>
                <img src="<?= $display_image_path ?>" width="150" class="rounded shadow mb-2 object-cover object-center h-32">
            </div>
            <div>
                <label for="gambar" class="block text-sm font-medium mb-1">Ganti Gambar:</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full px-3 py-2 bg-gray-700 text-white rounded border border-gray-600">
                <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
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