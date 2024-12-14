<?php
header("HTTP/1.1 503 Service Temporarily Unavailable");
header("Retry-After: 3600"); // Memberitahu browser kapan harus mencoba lagi
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        body { text-align: center; padding: 50px; font-family: Arial, sans-serif; background-color: #f4f4f4; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Website Sedang Dalam Perbaikan</h1>
    <p>Kami akan segera kembali. Terima kasih atas kesabaran Anda.</p>
</body>
</html>
