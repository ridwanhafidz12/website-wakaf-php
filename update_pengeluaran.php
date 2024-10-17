<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $bulan = $_POST['bulan'];

    $stmt = $conn->prepare("UPDATE pengeluaran SET nama=?, jumlah=?, keterangan=?, bulan=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $jumlah, $keterangan, $bulan, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM pengeluaran WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Data Pengeluaran</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Update Data Pengeluaran</h1>
    <form action="update_pengeluaran.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?= $row['nama'] ?>" required>
        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="<?= $row['jumlah'] ?>" required>
        <label>Keterangan:</label>
        <select name="keterangan" required>
            <option value="Terealisasikan" <?= $row['keterangan'] == 'Disalurkan' ? 'selected' : '' ?>>Donasi Telah Terealisasikan</option>
            <option value="Belum Terealisasikan" <?= $row['keterangan'] == 'Belum Terealisasikan' ? 'selected' : '' ?>>Donasi Belum Terealisasikan</option>
        </select>
        <label>Bulan:</label>
        <input type="month" name="bulan" value="<?= $row['bulan'] ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
