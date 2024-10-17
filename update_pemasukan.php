<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $program_id = $_POST['program_id'];
    $bulan = $_POST['bulan'];

    // Sanitize input to prevent SQL injection
    $nama = $conn->real_escape_string($nama);
    $jumlah = $conn->real_escape_string($jumlah);
    $program_id = $conn->real_escape_string($program_id);
    $bulan = $conn->real_escape_string($bulan);

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE pemasukan SET nama=?, jumlah=?, program_id=?, bulan=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $jumlah, $program_id, $bulan, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM pemasukan WHERE id=$id");
$row = $result->fetch_assoc();

// Fetch all programs for the dropdown
$programs = $conn->query("SELECT * FROM program");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Pemasukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" type="text/css">
    <link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body id="page-top">
    <nav class="navbar">
        <div>
            <a href="index.php">
                <img src="az1.png" width="60px" alt="Logo Azzakiyyah">
            </a>
        </div>
    </nav>
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <a href="index.php"><button class="btn btn-primary">Beranda</button></a>
                    <a href="create_program.php"><button class="btn btn-success">Buat Program</button></a>
                    <h1>Update Data Pemasukan</h1>

                    <form action="update_pemasukan.php" method="POST" class="form-group">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" name="jumlah" class="form-control" value="<?= htmlspecialchars($row['jumlah']) ?>" required>
                        <label for="program_id">Program:</label>
                        <select name="program_id" class="form-control" required>
                            <?php while ($program = $programs->fetch_assoc()) : ?>
                                <option value="<?= $program['id'] ?>" <?= $program['id'] == $row['program_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($program['program_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <label for="bulan">Bulan:</label>
                        <input type="date" name="bulan" class="form-control" value="<?= htmlspecialchars($row['bulan']) ?>" required>
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pemasukan-table').DataTable();
        });
    </script>
</body>
</html>
