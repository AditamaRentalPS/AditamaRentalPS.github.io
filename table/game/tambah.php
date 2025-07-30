<?php
include '../../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    echo "ID tidak ditemukan!";
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM games WHERE id = $id");

if (!$query) {
    echo "Query gagal: " . mysqli_error($conn);
    exit;
}

$game = mysqli_fetch_assoc($query);
?>
