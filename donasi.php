<?php
include 'db.php';

// Fetch data for this program
$program_id = $_GET["id"];
$sql = "
    SELECT pemasukan.*, users.nama 
    FROM pemasukan 
    JOIN users ON pemasukan.user_id = users.user_id 
    WHERE pemasukan.program_id = $program_id
";
$pemasukan = $conn->query($sql);
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

// Build full image URL
$image_url = "https://ziswaf.my.id/" . $image;

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

    <title><?php echo $program_name; ?></title>

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $program_name; ?>">
    <meta property="og:description" content="<?php echo $description; ?>">
    <meta property="og:image" content="<?php echo $image_url; ?>">
    <meta property="og:url" content="https://ziswaf.my.id/program.php?id=<?php echo $program_id; ?>">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $program_name; ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">
    <meta name="twitter:image" content="<?php echo $image_url; ?>">

    <!-- Include CSS & other meta tags -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
                width: 600px;
            }
        }

        @media (max-width: 480px) {
            .card-container {
                width: 300px;
            }
        }

        .summary {
            text-align: center;
            margin-top: 10px;
        }

        @media (max-width: 768px) {

            .chart-container {
                width: 200px;
                height: 200px;
                margin-bottom: 100px;
            }
        }

        @media (max-width: 480px) {

            .chart-container {
                width: 150px;
                height: 150px;
                margin-bottom: 100px;
            }
        }

        .chart-wrapper {
            margin-bottom: 170px;
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
            width: 100%;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar">
        <div>
            <a href="index.php"><img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
    </nav>

    <a href="index.php" class="back"><i class="bi bi-chevron-left"></i> Kembali</a>
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
                            <th>NIWA</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Program</th>
                            <th>Bulan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>NIWA</th>
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
                                <td><?php echo $data['user_id']; ?></td>
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
        <a href="index.php" class="back"><i class="bi bi-chevron-left"></i> Kembali</a>


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
        <div class="bottom-navbar">
            <a href="index.php" class="nav-link">
                <i class="bx bx-home"></i>
                <span class="nav-text">Home</span>
            </a>
            <a href="ziswaf.php" class="nav-link">
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