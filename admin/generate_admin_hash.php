<?php
// generate_admin_hash.php
$admin_password_mentah = "admin123"; // GANTI DENGAN PASSWORD ADMIN YANG KUAT DAN MUDAH ANDA INGAT!
$hashed_password = password_hash($admin_password_mentah, PASSWORD_BCRYPT);
echo "Password mentah: " . $admin_password_mentah . "<br>";
echo "Hash password Anda adalah: <pre>" . $hashed_password . "</pre>";
?>