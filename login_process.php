<?php
// login_process.php (Logika Autentikasi Universal)
session_start();

// Aktifkan error reporting untuk debugging selama pengembangan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // Pastikan file db.php ada dan berisi koneksi database ($conn)

// Pastikan request adalah POST. Jika bukan, arahkan kembali.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Ambil data dari form POST
$email = trim(strtolower($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

// Simpan email ke session untuk mengisi ulang form jika ada error
$_SESSION['old_login_email'] = $email;

// --- Validasi Input ---
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Email dan password wajib diisi.";
    header('Location: login.php');
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_error'] = "Format email tidak valid.";
    header('Location: login.php');
    exit;
}

// --- Proses Autentikasi ---
$stmt = null; // Inisialisasi statement
// $is_admin = false; // Flag untuk menentukan apakah yang login adalah admin (not strictly needed with separate redirects)

try {
    // 1. Coba autentikasi sebagai PENGGUNA BIASA (tabel `users`)
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    if (!$stmt) {
        throw new Exception("SQL Prepare failed (users login): " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Login pengguna biasa berhasil!
            $_SESSION['user_logged_in'] = true; // Flag untuk user biasa
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            // Hapus email lama dari session setelah login berhasil
            unset($_SESSION['old_login_email']); 
            
            header("Location: index.php"); // Redirect ke halaman utama atau dashboard user
            exit;
        }
    }
    $stmt->close(); // Tutup statement untuk tabel users

    // 2. Jika bukan pengguna biasa atau password salah, coba autentikasi sebagai ADMIN (tabel `admin`)
    $stmt = $conn->prepare("SELECT id, name, email, password FROM admin WHERE email = ?");
    if (!$stmt) {
        throw new Exception("SQL Prepare failed (admin login): " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin_user = $result->fetch_assoc();
        if (password_verify($password, $admin_user['password'])) {
            // Login admin berhasil!
            $_SESSION['admin_logged_in'] = true; // Flag khusus admin
            $_SESSION['admin_id'] = $admin_user['id'];
            $_SESSION['admin_name'] = $admin_user['name'];
            $_SESSION['admin_email'] = $admin_user['email'];

            // Hapus email lama dari session setelah login berhasil
            unset($_SESSION['old_login_email']);
            
            header("Location: admin.php"); // Redirect ke halaman admin dashboard
            exit;
        }
    }
    $stmt->close(); // Tutup statement untuk tabel admin

    // 3. Jika tidak ada yang cocok (baik user maupun admin)
    $_SESSION['login_error'] = "Email atau password salah.";
    header('Location: login.php');
    exit;

} catch (Exception $e) {
    // Tangani error database umum
    $_SESSION['login_error'] = "Terjadi kesalahan database: " . $e->getMessage();
    error_log("Login Error: " . $e->getMessage()); // Log error untuk debugging
    header('Location: login.php');
    exit;
} finally {
    // Pastikan koneksi ditutup.
    if ($conn) {
        $conn->close();
    }
}

?>