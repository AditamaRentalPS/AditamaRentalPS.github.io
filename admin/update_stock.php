<?php
session_start();
require_once '../includes/db.php';

// Proteksi admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $stock = (int)$_POST['stock'];

    $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
    $stmt->bind_param("ii", $stock, $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: index.php');
exit;
