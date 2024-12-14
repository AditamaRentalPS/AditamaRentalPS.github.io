<?php
// Aktifkan mode maintenance
$maintenance_mode = true;

// Whitelist IP (misalnya untuk admin)
$allowed_ips = ['123.123.123.123']; // Ganti dengan IP Anda
$user_ip = $_SERVER['REMOTE_ADDR'];

if ($maintenance_mode && !in_array($user_ip, $allowed_ips)) {
    header('HTTP/1.1 503 Service Unavailable');
    header('Retry-After: 3600'); // Memberitahu browser kapan bisa coba lagi
    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website Dalam Perbaikan</title>
        <style>
            body { text-align: center; font-family: Arial, sans-serif; padding: 50px; }
            h1 { color: #555; }
        </style>
    </head>
    <body>
        <h1>Website Sedang Dalam Perbaikan</h1>
        <p>Kami sedang melakukan pembaruan. Silakan kembali lagi nanti.</p>
    </body>
    </html>';
    exit();
}

// Kode normal website Anda di sini
?>
