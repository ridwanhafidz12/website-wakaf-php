<?php
include 'db.php';

// Proses pencarian jika ada parameter pencarian
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Query untuk mendapatkan jumlah program dan total wakaf berdasarkan user_id
$sql = "SELECT p.user_id, u.nama, COUNT(pr.id) AS program_count, SUM(p.jumlah) AS total_wakaf, MAX(p.bulan) AS bulan 
        FROM pemasukan p 
        JOIN program pr ON p.program_id = pr.id
        JOIN users u ON p.user_id = u.user_id
        WHERE u.nama LIKE '%$search_query%'
        GROUP BY p.user_id, u.nama";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Donatur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        /* Style tambahan */
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

        .back:focus,
        .back:hover,
        .back:visited {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body id="page-top">
    <nav class="navbar">
        <div>
            <a href="admin"><img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
    </nav>
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                <a href="admin" class="back"><i class="bi bi-chevron-left"></i> Back</a>
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
                                            <th>Total Wakaf</th>
                                            <th>Jumlah Program</th>
                                            <th>Bulan Masuk</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Total Wakaf</th>
                                            <th>Jumlah Program</th>
                                            <th>Bulan Masuk</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['user_id']) ?></td>
                                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                                <td>Rp. <?= number_format($row['total_wakaf'], 0, ',', '.') ?></td>
                                                <td><?= htmlspecialchars($row['program_count']) ?></td>
                                                <td><?= htmlspecialchars($row['bulan']) ?></td>
                                                <td><button class="btn btn-info btn-detail" data-user-id="<?= $row['user_id'] ?>">Detail</button></td>
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
   
    <!-- Pop-up Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Program</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="programDetails">
                            <!-- Data program akan di-load menggunakan AJAX -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

            // Handle button click event
            $('.btn-detail').click(function() {
                var userId = $(this).data('user-id');
                
                // AJAX request to fetch data based on user_id
                $.ajax({
                    url: 'fetch_program_details.php', // File PHP untuk mengambil data
                    type: 'post',
                    data: { user_id: userId },
                    success: function(response) {
                        // Isi tabel di modal dengan data yang diambil
                        $('#programDetails').html(response);
                        
                        // Tampilkan modal
                        $('#detailModal').modal('show');
                    }
                });
            });
        });
    </script>
</body>

</html>
