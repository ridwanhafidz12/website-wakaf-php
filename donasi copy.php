<?php
include 'db.php';

// Fetch data for this program
$program_id = $_GET["id"];
$pemasukan = $conn->query("SELECT * FROM pemasukan WHERE program_id = $program_id");
$chart_data = [];
while ($row = $pemasukan->fetch_assoc()) {
    $chart_data[] = $row;
}

// Get program details
$program = $conn->query("SELECT * FROM program WHERE id = $program_id")->fetch_assoc();
$program_name = $program['program_name'];
$target_amount = $program['target_amount'];
$description = $program['description'];
$image = $program['image'];


// Calculate total donation
$total_donation = array_sum(array_column($chart_data, 'jumlah'));
$donation_percentage = min(($total_donation / $target_amount) * 100, 100); // Limit to 100%
$donation_less = max($target_amount - $total_donation, 0); // No negative values
$donation_less_percentage = ($donation_less / $target_amount) * 100;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $program_name; ?>
    </title>
    <link rel="stylesheet" href="style.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        /* CSS styling */
        .chart-container,
        .card-container {
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

        .card-container img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
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

        .card-container .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #2596be;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .card-container .btn:hover {
            background-color: yellow;
            color: #2596be;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .card-container {
                width: 250px;
            }
        }

        @media (max-width: 480px) {
            .card-container {
                width: 200px;
            }
        }

        .summary {
            text-align: center;
            margin-top: 10px;
        }

        @media (max-width: 768px) {

            .chart-container,
            .card-container {
                width: 200px;
                height: 200px;
            }
        }

        @media (max-width: 480px) {

            .chart-container,
            .card-container {
                width: 150px;
                height: 150px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar">
        <div>
            <a href="index.php"><img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
    </nav>
    <a href="index.php"><button>Sedekah</button></a>
    <div class="card-wrapper">
        <div class="card-container">
            <img src="<?php echo $image; ?>" alt="<?php echo $program_name; ?>" width="300px">
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Data Pemasukan <?php echo $program_name; ?></h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Program</th>
                            <th>Bulan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Program</th>
                            <th>Bulan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($chart_data as $data) : ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td>Rp. <?php echo number_format($data['jumlah'], 0, ',', '.'); ?></td>
                                <td><?php
                                    $program_result = $conn->query("SELECT program_name FROM program WHERE id = " . $data['program_id']);
                                    $program = $program_result->fetch_assoc();
                                    echo $program['program_name'];
                                    ?></td>
                                <td><?php echo $data['bulan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <?php if (count($chart_data) > 0): ?>
        <h2>Donasi Chart</h2>
        <div class="chart-wrapper">
            <div class="chart-container">
                <canvas id="donasiChart"></canvas>
                <div class="summary">
                    <p>Donasi Masuk: Rp. <?php echo number_format($total_donation, 0, ',', '.'); ?> (<?php echo round($donation_percentage, 2); ?>%)</p>
                    <p>Kekurangan Donasi: Rp. <?php echo number_format($donation_less, 0, ',', '.'); ?> (<?php echo round($donation_less_percentage, 2); ?>%)</p>
                </div>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('donasiChart').getContext('2d');
            var donasiChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Donasi Masuk', 'Kekurangan Donasi'],
                    datasets: [{
                        label: 'Donasi',
                        data: [
                            <?php echo $total_donation; ?>,
                            <?php echo $donation_less; ?>
                        ],
                        backgroundColor: [
                            '#4CAF50',
                            '#FF5722'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
    <?php endif; ?>
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