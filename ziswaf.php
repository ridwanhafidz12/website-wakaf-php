<?php
include 'db.php';

// Ambil data program dan hitung pemasukan serta jumlah donatur untuk setiap program
$programsQuery = $conn->query("SELECT p.*, COUNT(d.id) AS jumlah_donatur FROM program p LEFT JOIN pemasukan d ON p.id = d.program_id GROUP BY p.id");
$programData = [];
$completedPrograms = [];

while ($program = $programsQuery->fetch_assoc()) {
    $program_id = $program['id'];
    $pemasukanProgram = $conn->query("SELECT SUM(jumlah) AS total FROM pemasukan WHERE program_id = $program_id")->fetch_assoc()['total'] ?? 0;
    $target_amount = $program['target_amount'];
    $jumlah_donatur = $program['jumlah_donatur'];

    $programDetails = [
        'id' => $program_id,
        'name' => $program['program_name'],
        'image' => $program['image'],
        'description' => $program['description'],
        'target_amount' => $target_amount,
        'pemasukan' => $pemasukanProgram,
        'jumlah_donatur' => $jumlah_donatur,
    ];

    if ($pemasukanProgram >= $target_amount) {
        $completedPrograms[] = $programDetails;
    } else {
        $programData[] = $programDetails;
    }
}

function totalJumlah($result)
{
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $total += $row['jumlah'];
    }
    return $total;
}

$totalPemasukan = totalJumlah($conn->query("SELECT * FROM pemasukan"));
$totalDonasi = $totalPemasukan;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="style.css">

    <title>Yuk Semua Bisa Wakaf</title>
    <script src="scripts.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .judul-program {
            text-align: center;
            color: #2596be;
            margin-top: 100px;
        }

        #section1 {
            background-color: #f6f6f6;
            padding: 15px;
            margin-bottom: 50px;
        }

        .chart-container {
            width: 300px;
            height: 300px;
            margin: 10px;
            position: relative;
        }

        .card-container {
            width: 300px;
            height: 500px;
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
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 550px;
            /* Sesuaikan jika perlu */
        }

        .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .text-container {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }


        .card-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card-container img {
            width: 100%;
            height: 250px;
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

        .progress {
            height: 20px;
            margin-top: 10px;
        }

        .progress-bar {
            background-color: #2596be;
            color: #fff;
            text-align: center;
            line-height: 20px;
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
                width: 350px;
            }

            .card-wrapper {
                display: flex;
                overflow-x: scroll;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
            }

            .card-container {
                scroll-snap-align: start;
                flex: 0 0 80%;
                margin-right: 10px;
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

        .wakif {
            text-align: right;
        }

        .progress-barr {
            text-align: left;
        }

        .nav__logo {
            color: #2596be;
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
<section>
    <nav class="navbar">
        <div>
            <a href="">
                <img src="az1.png" width="60px" alt="Logo Azzakiyyah">
            </a>
        </div>
    </nav>
</section>

<section id="section1">
    <h1 class="judul-program"><b>Program Wakaf</b></h1>
    <div class="card-wrapper">
        <?php foreach ($programData as $program) :
            $progress = round(($program['pemasukan'] / $program['target_amount']) * 100, 2); // Menghitung persentase progress
        ?>
            <div class="card-container">
                <a href="donasi.php?id=<?= $program['id'] ?>" style="text-decoration: none; color: #b1b01d;">
                    <img src="<?= $program['image'] ?>" alt="<?= $program['name'] ?>" width="200px">
                    <h2><b><?= $program['name'] ?></b></h2>
                    <div class="text-container">
                        <p><b>Jumlah Wakif:</b></p>
                        <p><?= $program['jumlah_donatur'] ?></p>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                            <?= $progress ?>%
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="text-container">
                            <p>Target Kebutuhan:</p>
                            <p>Rp. <?= number_format($program['target_amount'], 0, ',', '.') ?></p>
                        </div>
                        <div class="text-container">
                            <p>Donasi Masuk:</p>
                            <p>Rp. <?= number_format($program['pemasukan'], 0, ',', '.') ?></p>
                        </div>
                        <a href="donasi.php?id=<?= $program['id'] ?>" class="btn">Lihat Detail</a>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>
</section>



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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-tQpHlISxI2msZ71RPlmxd1/5CTpCJf+N8ZR9zIuW8Y4FwAxE1Uf/9N2xwVpHRkZx" crossorigin="anonymous"></script>
</body>

</html>