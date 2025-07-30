<?php
// register_process.php
session_start();

// Aktifkan error reporting untuk debugging selama pengembangan
// HAPUS ATAU KOMENTARI BARIS INI KETIKA GO LIVE DI SERVER PRODUKSI!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // Pastikan file db.php ada dan berisi koneksi database ($conn)

// Pastikan request adalah POST. Jika bukan, arahkan kembali ke halaman registrasi.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

// Ambil data dari form POST
$name = trim($_POST['name'] ?? ''); // trim() untuk menghapus spasi di awal/akhir
$email = trim(strtolower($_POST['email'] ?? '')); // trim() dan strtolower() untuk email
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Simpan data input ke session untuk mengisi ulang form jika ada error
// Password tidak disimpan kembali ke session untuk keamanan
$_SESSION['old_reg_data'] = [
    'name' => $name,
    'email' => $email,
];

// --- Validasi Input ---

// Validasi semua field wajib diisi
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['reg_error'] = "Semua field wajib diisi.";
    header('Location: register.php');
    exit;
}

// Validasi konfirmasi password
if ($password !== $confirm_password) {
    $_SESSION['reg_error'] = "Konfirmasi password tidak cocok.";
    header('Location: register.php');
    exit;
}

// Validasi panjang password (contoh minimal 6 karakter)
if (strlen($password) < 6) {
    $_SESSION['reg_error'] = "Password minimal 6 karakter.";
    header('Location: register.php');
    exit;
}

// Validasi format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['reg_error'] = "Format email tidak valid.";
    header('Location: register.php');
    exit;
}

// --- Proses Penyimpanan ke Database ---

// Hash password sebelum disimpan
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Cek jika email sudah ada di database
$check_stmt = null; // Inisialisasi statement
try {
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$check_stmt) {
        // Jika prepare gagal, artinya ada masalah dengan query SQL itu sendiri
        throw new Exception("SQL Prepare (check email) failed: " . $conn->error);
    }
    $check_stmt->bind_param("s", $email); // 's' untuk string
    $check_stmt->execute();
    $check_stmt->store_result(); // Simpan hasil untuk mendapatkan jumlah baris

    if ($check_stmt->num_rows > 0) {
        $_SESSION['reg_error'] = "Email sudah terdaftar. Gunakan email lain.";
        header('Location: register.php');
        exit;
    }
} catch (Exception $e) {
    // Tangani error database saat cek email
    $_SESSION['reg_error'] = "Kesalahan database saat memeriksa email: " . $e->getMessage();
    header('Location: register.php');
    exit;
} finally {
    // Pastikan statement ditutup
    if ($check_stmt) {
        $check_stmt->close();
    }
}

// Simpan user baru ke database
$insert_stmt = null; // Inisialisasi statement
try {
    $insert_stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if (!$insert_stmt) {
        // Jika prepare gagal
        throw new Exception("SQL Prepare (insert user) failed: " . $conn->error);
    }
    $insert_stmt->bind_param("sss", $name, $email, $hashed_password); // 'sss' untuk tiga string

    if ($insert_stmt->execute()) {
        // Registrasi berhasil!
        $_SESSION['user_id'] = $conn->insert_id; // Dapatkan ID user yang baru saja dibuat
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['reg_success'] = "Registrasi berhasil! Silakan login."; // Pesan sukses

        // Arahkan ke halaman login
        header("Location: login.php");
        exit;
    } else {
        // Jika eksekusi gagal
        throw new Exception("SQL Execute (insert user) failed: " . $insert_stmt->error);
    }
} catch (Exception $e) {
    // Tangani error database saat menyimpan user
    $_SESSION['reg_error'] = "Terjadi kesalahan saat menyimpan data: " . $e->getMessage();
    header('Location: register.php');
    exit;
} finally {
    // Pastikan statement ditutup dan koneksi ditutup
    if ($insert_stmt) {
        $insert_stmt->close();
    }
    $conn->close(); // Tutup koneksi database
}

?>