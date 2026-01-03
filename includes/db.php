<?php
// db.php
// Pastikan kredensial database ini sesuai dengan pengaturan Anda
$host = 'localhost'; // Host database Anda, biasanya 'localhost'
$user = 'root';      // Username database Anda (contoh: 'root' untuk XAMPP/WAMP/Laragon)
$pass = '';          // Password database Anda (contoh: kosong '' untuk XAMPP/WAMP/Laragon)
$dbname = 'dc_rental';  // Nama database Anda, harus 'rental' seperti yang ada di phpMyAdmin

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=dc_rental;charset=utf8",
        "root",
        ""
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi DB gagal: " . $e->getMessage());
}


// Buat koneksi MySQLi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi skrip dan tampilkan pesan error
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Opsional: Set character set untuk koneksi (direkomendasikan)
$conn->set_charset("utf8mb4");

?>