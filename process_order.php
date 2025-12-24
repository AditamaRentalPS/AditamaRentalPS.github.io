<?php
session_start(); // Mulai session untuk menyimpan pesan

// Sertakan file koneksi database
require_once 'config.php';

// Periksa apakah request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan bersihkan (sanitize)
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $package = trim($_POST['package'] ?? '');
    $rental_date = trim($_POST['rental_date'] ?? '');
    $duration_type = trim($_POST['duration_type'] ?? '');
    $duration = (int)($_POST['duration'] ?? 0);

    // Ambil rates dari data-set (jika diperlukan untuk validasi/perhitungan ulang di server)
    // Atau bisa juga dikirimkan langsung dari form via hidden input
    // Untuk contoh ini, kita asumsikan package sudah cukup.
    // Di aplikasi nyata, Anda HARUS mengambil harga dari database inventory
    // berdasarkan $package untuk mencegah manipulasi harga dari sisi klien.

    // Validasi sederhana (Anda bisa menambahkan validasi yang lebih kompleks)
    if (empty($name) || empty($email) || empty($phone) || empty($package) || empty($rental_date) || empty($duration_type) || $duration <= 0) {
        $_SESSION['form_message'] = "Semua field wajib diisi dengan benar.";
        $_SESSION['form_message_type'] = "error";
        header("Location: index.php#contact"); // Redirect kembali ke form kontak
        exit;
    }

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['form_message'] = "Format email tidak valid.";
        $_SESSION['form_message_type'] = "error";
        header("Location: index.php#contact");
        exit;
    }

    // Generate Order ID sederhana (contoh: ORD-tanggal-random_string)
    $order_id = "ORD-" . date("Ymd") . "-" . substr(md5(uniqid(mt_rand(), true)), 0, 8);

    // Untuk 'console_model' di tabel orders, kita gunakan $package yang dipilih user
    $console_model_for_db = '';
    switch ($package) {
        case 'ps5_standard':
            $console_model_for_db = 'PS5 Standard Edition';
            break;
        case 'ps4_pro':
            $console_model_for_db = 'PS4 Pro Edition';
            break;
        case 'ps3_classic':
            $console_model_for_db = 'PS3 Classic Edition';
            break;
        default:
            $console_model_for_db = 'Paket Tidak Dikenal';
            break;
    }

    // Durasi sewa yang akan disimpan
    $duration_text = $duration . " " . $duration_type;

    // Masukkan data ke database
    // Pastikan tabel `orders` memiliki kolom: order_id, customer_name, console_model, rental_date, duration, status
   // process_order.php

// Ambil waktu sekarang sebagai waktu mulai
$start_time = date("Y-m-d H:i:s");

// Hitung waktu selesai
if ($duration_type == 'jam') {
    $end_time = date("Y-m-d H:i:s", strtotime("+$duration hours"));
} else {
    // Jika hari, asumsikan 24 jam per hari
    $end_time = date("Y-m-d H:i:s", strtotime("+$duration days"));
}

// Update Query INSERT (Tambahkan kolom start_time dan end_time)
$stmt = $conn->prepare("INSERT INTO orders (order_id, customer_name, console_model, rental_date, duration, status, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $order_id, $name, $console_model_for_db, $rental_date, $duration_text, $status, $start_time, $end_time);

    if ($stmt) {
        $status = 'Pending'; // Status awal pesanan
        // Bind parameter: s (string), s (string), s (string), s (string), s (string), s (string)
        $stmt->bind_param("ssssss", $order_id, $name, $console_model_for_db, $rental_date, $duration_text, $status);

        if ($stmt->execute()) {
            $_SESSION['form_message'] = "Terima kasih! Pesanan Anda telah diterima. Kami akan menghubungi Anda segera.";
            $_SESSION['form_message_type'] = "success";
        } else {
            $_SESSION['form_message'] = "Terjadi kesalahan saat menyimpan pesanan: " . $stmt->error;
            $_SESSION['form_message_type'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['form_message'] = "Terjadi kesalahan pada persiapan query database.";
        $_SESSION['form_message_type'] = "error";
    }

    // Tutup koneksi database
    $conn->close();

    // Redirect kembali ke halaman utama dengan hash ke bagian kontak
    header("Location: index.php#contact");
    exit;

} else {
    // Jika ada yang mencoba mengakses process_order.php secara langsung
    header("Location: index.php");
    exit;
}
?>