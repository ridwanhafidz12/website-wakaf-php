<?php
include 'db.php';

// Fetch all programs
$sql = "
    SELECT program.id, program.program_name, program.target_amount, SUM(pemasukan.jumlah) as total_donation
    FROM program 
    LEFT JOIN pemasukan ON program.id = pemasukan.program_id 
    GROUP BY program.id, program.program_name, program.target_amount
";
$programs = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Program</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .chart-container, .card-container {
            width: 300px;
            height: 300px;
            margin: 10px;
            position: relative;
        }

        .chart-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .card-container {
            width: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .card-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card-container h3 {
            margin: 10px 0;
            font-size: 1.2em;
            color: #333;
        }

        .card-container p {
            font-size: 14px;
            color: #555;
            padding: 0 10px;
            margin: 0;
        }

        .summary {
            text-align: center;
            margin-top: 10px;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar">
        <div>
            <a href="admin"><img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <a href="admin" class="back"><i class="bi bi-chevron-left"></i> Back</a>
            <h2 class="m-0 font-weight-bold text-primary">Analisis Semua Program</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Program</th>
                            <th>Target Donasi</th>
                            <th>Donasi Masuk</th>
                            <th>Kekurangan Donasi</th>
                            <th>% Tercapai</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Program</th>
                            <th>Target Donasi</th>
                            <th>Donasi Masuk</th>
                            <th>Kekurangan Donasi</th>
                            <th>% Tercapai</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $counter = 1;
                        while ($row = $programs->fetch_assoc()) :
                            $total_donation = $row['total_donation'] ?: 0;
                            $donation_percentage = min(($total_donation / $row['target_amount']) * 100, 100);
                            $donation_less = max($row['target_amount'] - $total_donation, 0);
                        ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $row['program_name']; ?></td>
                                <td>Rp. <?php echo number_format($row['target_amount'], 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($total_donation, 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($donation_less, 0, ',', '.'); ?></td>
                                <td><?php echo round($donation_percentage, 2); ?>%</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>
