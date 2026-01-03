<?php
require_once 'includes/db.php';

$package = $_POST['package'];

// kurangi stok 1
$stmt = $conn->prepare("
    UPDATE products
    SET stock = stock - 1
    WHERE code = ? AND stock > 0
");
$stmt->bind_param("s", $package);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    die("Stok habis");
}

header("Location: index.php#contact");
