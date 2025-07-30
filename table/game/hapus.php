<?php include __DIR__ . '/../../db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM games WHERE id=$id");
header("Location: index.php");
exit;
