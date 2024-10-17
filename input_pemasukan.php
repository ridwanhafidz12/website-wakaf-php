<?php
include 'db.php';

// Handle form submission for creating or updating a record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $jumlah = $_POST['jumlah'];
    $program_id = $_POST['program_id'];
    $bulan = $_POST['bulan'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    // Sanitize input to prevent SQL injection
    $user_id = $conn->real_escape_string($user_id);
    $jumlah = $conn->real_escape_string($jumlah);
    $program_id = $conn->real_escape_string($program_id);
    $bulan = $conn->real_escape_string($bulan);

    // Validate the inputs
    if (empty($user_id) || empty($jumlah) || empty($program_id) || empty($bulan)) {
        echo "All fields are required.";
    } else {
        if ($id) {
            // Update existing record
            $sql = "UPDATE pemasukan SET user_id='$user_id', jumlah='$jumlah', program_id='$program_id', bulan='$bulan' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO pemasukan (user_id, jumlah, program_id, bulan) VALUES ('$user_id', '$jumlah', '$program_id', '$bulan')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM pemasukan WHERE id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch data from the database
$pemasukan = $conn->query("SELECT p.*, pr.program_name, u.nama FROM pemasukan p 
                           JOIN program pr ON p.program_id = pr.id
                           JOIN users u ON p.user_id = u.user_id");
$programs = $conn->query("SELECT * FROM program");
$users = $conn->query("SELECT user_id, nama FROM users");  // Fetch users
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pemasukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" type="text/css">
    <link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .back {
            width: 100px;
            margin: 20px 0px;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            color: black;
            background-color: #e5e7eb;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .back:focus, .back:hover, .back:visited {
            text-decoration: none;
            color: black;
        }
    </style>
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
                <a href="admin" class="back"><i class="bi bi-chevron-left"></i> Back</a>
                    <h1>Input Pemasukan</h1>
                    <form method="POST" action="" class="form-group">
                        <input type="hidden" name="id" value="<?= isset($_GET['edit_id']) ? $_GET['edit_id'] : ''; ?>">
                        <label for="user_id">Nama:</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Select Nama</option>
                            <?php while ($user = $users->fetch_assoc()) : ?>
                                <option value="<?= htmlspecialchars($user['user_id']) ?>" <?= isset($_GET['edit_id']) && $_GET['edit_user_id'] == $user['user_id'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($user['nama']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required value="<?= isset($_GET['edit_jumlah']) ? $_GET['edit_jumlah'] : ''; ?>">
                        <label for="program_id">Program:</label>
                        <select name="program_id" class="form-control" required>
                            <option value="">Select Program</option>
                            <?php while ($program = $programs->fetch_assoc()) : ?>
                                <option value="<?= $program['id'] ?>" <?= isset($_GET['edit_program_id']) && $_GET['edit_program_id'] == $program['id'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($program['program_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <label for="bulan">Tanggal:</label>
                        <input type="date" name="bulan" class="form-control" required value="<?= isset($_GET['edit_bulan']) ? $_GET['edit_bulan'] : ''; ?>">
                        <button type="submit" class="btn btn-primary mt-3"><?= isset($_GET['edit_id']) ? 'Update' : 'Submit'; ?></button>
                    </form>

                    <h2>Data Pemasukan</h2>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pemasukan List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pemasukan-table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Jumlah</th>
                                            <th>Program</th>
                                            <th>Bulan</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Jumlah</th>
                                            <th>Program</th>
                                            <th>Bulan</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($row = $pemasukan->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['user_id']) ?></td>
                                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                                <td>Rp. <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                                <td><?= htmlspecialchars($row['program_name']) ?></td>
                                                <td><?= htmlspecialchars($row['bulan']) ?></td>
                                                <td>
                                                    <a href="?edit_id=<?= $row['id'] ?>&edit_user_id=<?= $row['user_id'] ?>&edit_jumlah=<?= $row['jumlah'] ?>&edit_program_id=<?= $row['program_id'] ?>&edit_bulan=<?= $row['bulan'] ?>" class="btn btn-warning">Edit</a>
                                                    <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pemasukan-table').DataTable({
                "searching": true // Enable searching on the table
            });
        });
    </script>
</body>

</html>
