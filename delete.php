<?php
include 'db.php';

$id = $_GET['id'];
$type = $_GET['type'];

$table = $type === 'pemasukan' ? 'pemasukan' : 'pengeluaran';
$conn->query("DELETE FROM $table WHERE id=$id");

header("Location: input_pemasukan.php");
exit();
?>
