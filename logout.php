<?php
// logout.php
session_start();

// Hapus semua variabel sesi yang spesifik untuk user atau admin
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);

unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);

// Hancurkan semua data sesi
session_destroy();

// Redirect ke halaman login atau halaman utama
header("Location: login.php"); // Mengarahkan ke login.php
exit;
?>