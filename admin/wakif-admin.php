<?php
include 'db.php';

// Proses pencarian jika ada parameter pencarian
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Query untuk mendapatkan data donasi berdasarkan pencarian
$sql = "SELECT p.*, pr.program_name, u.nama FROM pemasukan p 
        JOIN program pr ON p.program_id = pr.id
        JOIN users u ON p.user_id = u.user_id
        WHERE u.nama LIKE '%$search_query%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Donatur</title>
    <link rel="stylesheet" href="style.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        #wrapper {
            margin-bottom: 100px;
        }
        .bottom-navbar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #2596be;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .bottom-navbar .nav-link {
            color: white;
            text-align: center;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .bottom-navbar .nav-link:hover {
            color: yellow;
        }

        .bottom-navbar .nav-link i {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .bottom-navbar .nav-text {
            display: block;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .bottom-navbar .nav-link i {
                font-size: 20px;
            }

            .bottom-navbar .nav-text {
                font-size: 10px;
            }
        }
    </style>
</head>

<body id="page-top">
    <nav class="navbar">
        <div>
            <a href="index.php"><img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
    </nav>
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <h1>Data Wakif</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Wakaf List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="donasi-table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Jumlah</th>
                                            <th>Program</th>
                                            <th>Bulan</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Jumlah</th>
                                            <th>Program</th>
                                            <th>Bulan</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['user_id']) ?></td> <!-- Menambahkan NIWA -->
                                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                                <td>Rp. <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                                <td><?= htmlspecialchars($row['program_name']) ?></td>
                                                <td><?= htmlspecialchars($row['bulan']) ?></td>
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
    <div class="bottom-navbar">
        <a href="index.php" class="nav-link">
            <i class="bx bx-home"></i>
            <span class="nav-text">Home</span>
        </a>
        <a href="#" class="nav-link">
            <i class="bx bx-donate-heart"></i>
            <span class="nav-text">Ziswaf</span>
        </a>
        <a href="riwayat.php" class="nav-link">
            <i class="bx bx-history"></i>
            <span class="nav-text">Riwayat</span>
        </a>
        <a href="wakif.php" class="nav-link">
            <i class="bx bx-user"></i>
            <span class="nav-text">Wakif</span>
        </a>
    </div>
    <!-- DataTables Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#donasi-table').DataTable({
                "searching": true // Enable searching on the table
            });
        });
    </script>
</body>

</html>