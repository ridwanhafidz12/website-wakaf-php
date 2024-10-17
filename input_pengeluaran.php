<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $program_id = $_POST['program_id'];
    $keterangan = $_POST['keterangan'];
    $bulan = $_POST['bulan'];

    $sql = "INSERT INTO pengeluaran (nama, jumlah, program_id, keterangan, bulan) VALUES ('$nama', '$jumlah', '$program_id', '$keterangan', '$bulan')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$pengeluaran = $conn->query("SELECT p.*, pr.program_name FROM pengeluaran p JOIN program pr ON p.program_id = pr.id");
$programs = $conn->query("SELECT * FROM program");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Input Pengeluaran</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <div>
            <a href="home_pengurus.php">
                <img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
        <div>
            <div class="dropdown">
                <a href="#" class="dropbtn">Beranda</a>
                <div class="dropdown-content">
                    <a href="index.php">Beranda Donatur</a>
                    <a href="home_pengurus.php">Beranda Pengurus</a>
                </div>
            </div>
            <a href="create_program">Buat Program</a>
        </div>
    </nav>
    <h1 class="text">Input Pengeluaran</h1>
    <form method="POST">
        <label>Nama:</label>
        <input type="text" name="nama" required>
        <label>Jumlah:</label>
        <input type="number" name="jumlah" required>
        <label for="program">Program:</label>
        <select name="program_id" required>
            <option value="">Select Program</option>
            <?php while ($program = $programs->fetch_assoc()) : ?>
                <option value="<?= $program['id'] ?>"><?= $program['program_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <label>Keterangan:</label>
        <select name="keterangan" required>
            <option value="Terealisasikan">Donasi Telah Terealisasikan</option>
            <option value="Belum Terealisasikan">Donasi Belum Terealisasikan</option>
        </select>
        <label>Bulan:</label>
        <input type="date" name="bulan" required>
        <button type="submit">Submit</button>
    </form>
    <h2>Data Pengeluaran</h2>
    <table id="pengeluaran-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Program</th>
                <th>Keterangan</th>
                <th>Bulan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $pengeluaran->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td class="rupiah"><?= $row['jumlah'] ?></td>
                    <td><?= $row['program_name'] ?></td>
                    <td class="keterangan"><?= $row['keterangan'] ?></td>
                    <td><?= $row['bulan'] ?></td>
                    <td>
                        <a href="update_pengeluaran.php?id=<?= $row['id'] ?>&type=pemasukan">Update</a>
                        <a href="delete.php?id=<?= $row['id'] ?>&type=pengeluaran">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            formatTable();

            // Tambahkan kelas warna pada keterangan
            document.querySelectorAll('.keterangan').forEach(cell => {
                if (cell.innerText.toLowerCase().includes('belum terealisasikan')) {
                    cell.classList.add('belum-terealisasikan');
                    cell.classList.remove('terealisasikan');
                } else if (cell.innerText.toLowerCase().includes('terealisasikan')) {
                    cell.classList.add('terealisasikan');
                    cell.classList.remove('belum-terealisasikan');
                }
            });
        });
    </script>

</body>

</html>