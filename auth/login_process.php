<?php
// login_process.php (ADMIN LOGIN)
session_start();

// Debug (boleh dimatikan kalau sudah stabil)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/db.php';

// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Ambil data form
$email = trim(strtolower($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

$_SESSION['old_login_email'] = $email;

// Validasi input
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

try {
    // 🔐 LOGIN ADMIN
    $stmt = $conn->prepare(
        "SELECT id, name, email, password 
         FROM admin 
         WHERE email = ? 
         LIMIT 1"
    );

    if (!$stmt) {
        throw new Exception("SQL Prepare failed (admin login): " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            // Login sukses
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_email'] = $admin['email'];

            unset($_SESSION['old_login_email']);

            header("Location: ../admin/index.php");
            exit;
        }
    }

    // Jika gagal
    $_SESSION['login_error'] = "Email atau password salah.";
    header('Location: login.php');
    exit;

} catch (Exception $e) {
    $_SESSION['login_error'] = "Terjadi kesalahan sistem.";
    error_log("Login Error: " . $e->getMessage());
    header('Location: login.php');
    exit;
} finally {
    if (isset($stmt) && $stmt) {
        $stmt->close();
    }
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
