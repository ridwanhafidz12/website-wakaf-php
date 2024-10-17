<?php
include 'db.php';

// Capture the search query if it exists
$searchQuery = $_GET['search'] ?? '';

// Fetch the total number of programs
$programCountQuery = $conn->query("SELECT COUNT(*) AS total_programs FROM program WHERE program_name LIKE '%$searchQuery%'");
$totalPrograms = $programCountQuery->fetch_assoc()['total_programs'] ?? 0;

// Fetch total donations collected
$totalPemasukanQuery = $conn->query("SELECT SUM(jumlah) AS total_donasi FROM pemasukan");
$totalDonasi = $totalPemasukanQuery->fetch_assoc()['total_donasi'] ?? 0;

// Fetch total number of distinct donors
$totalDonaturQuery = $conn->query("SELECT COUNT(DISTINCT user_id) AS total_donatur FROM pemasukan");
$totalDonatur = $totalDonaturQuery->fetch_assoc()['total_donatur'] ?? 0;

// Fetch programs and their details based on the search query
$programsQuery = $conn->query("SELECT p.*, COUNT(d.id) AS jumlah_donatur FROM program p LEFT JOIN pemasukan d ON p.id = d.program_id WHERE p.program_name LIKE '%$searchQuery%' GROUP BY p.id");
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


$totalPemasukan = totalJumlah($conn->query("SELECT * FROM pemasukan"));
$totalDonasi = $totalPemasukan;

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

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
<style>
    /* Styles for all screen sizes */
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .container {
        max-width: 375px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .header .greeting {
        flex-grow: 1;
        margin-left: 10px;
    }

    .header .greeting h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 500;
    }

    .header .greeting p {
        margin: 0;
        font-size: 14px;
        color: #888;
    }

    .header .notification {
        font-size: 20px;
        color: #888;
    }

    .svg-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
        /* Tambahkan margin jika perlu */
    }

    .svg-container img {
        width: 70%;
        /* Membuat gambar responsif */
        height: auto;
        /* Memastikan tinggi menyesuaikan */
    }

    .stats {
        display: flex;
        justify-content: space-between;
        background-color: #2596be;
        color: white;
        padding: 10px;
        border-radius: 10px;
        margin: 20px;
    }

    .stats div {
        text-align: center;
        flex: 1;
        padding: 0 10px;
    }

    .stats div p {
        margin: 5px 0;
        font-size: 16px;
    }


    /* Style for small screens */
    @media (max-width: 480px) {
        .stats div p {
            margin: 5px 0;
            font-size: 12px;
        }
    }

    .quick-send,
    .transaction {
        padding: 20px;
        margin-top: -70px;
        margin-bottom: 60px;
    }

    .quick-send .header,
    .transaction .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /*  */
    .judul-program {
        text-align: center;
        color: #2596be;
        margin-top: 20px;
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

    .see-all.btn {
        color: #555;
        text-decoration: none;
    }

    .transaction .transaction-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 10px;
        margin-top: 10px;
    }

    .transaction .transaction-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .transaction .transaction-item .details {
        flex-grow: 1;
        margin-left: 10px;
    }

    .transaction .transaction-item .details h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 500;
    }

    .transaction .transaction-item .details p {
        margin: 0;
        font-size: 14px;
        color: #888;
    }

    .transaction .transaction-item .amount {
        font-size: 16px;
        font-weight: 500;
        color: #000;
    }

    /* Maps Section */
    .maps-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        margin-bottom: 100px;
    }

    .maps-container iframe {
        width: 100%;
        height: 450px;
        /* Ukuran default iframe */
        border: 0;
    }

    @media (max-width: 768px) {
        .maps-container iframe {
            height: 350px;
            /* Sesuaikan ukuran pada layar kecil */
        }
    }

    @media (max-width: 480px) {
        .maps-container iframe {
            height: 250px;
            /* Ukuran iframe pada layar yang sangat kecil */
        }
    }

    /*  */
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

    /* Media queries for larger screens */
    @media (min-width: 768px) {
        .container {
            max-width: 100%;
        }

        .balance h1 {
            font-size: 48px;
        }

        .balance .actions button {
            padding: 15px 30px;
            font-size: 18px;
        }
    }

    /* Media queries for small screens */
    @media (max-width: 375px) {
        .balance h1 {
            font-size: 28px;
        }

        .balance .actions button {
            padding: 8px 15px;
            font-size: 14px;
        }
    }
</style>
</head>


<body>
    <div class="container">
        <div class="header">
            <img alt="User profile picture" height="50"
                src="az1.png"
                width="50" />
            <div class="greeting">
                <h2>
                    Hi, Assalamu'alaikum
                </h2>
                <p>
                    Selamat datang di wakaf pendidikan santri!
                </p>
            </div>
        </div>
        <a href="https://pptqazzakiyyah.com/" class="svg-container">
            <img src="Ilustration-01.svg" alt="background azzakiyyah">
        </a>


        <h2 class="judul-program"><b>Data Wakaf</b></h2>
        <div class="stats">
            <div>
                <p><?= number_format($totalPrograms) ?> </p>
                <p>Program</p>
            </div>
            <div>
                <p>Rp. <?= number_format($totalDonasi, 0, ',', '.') ?> Wakaf</p>
            </div>
            <div>
                <p><?= number_format($totalDonatur) ?></p>
                <p>Wakif</p>
            </div>

        </div>

        <section id="section1">
            <h2 class="judul-program"><b>Program Wakaf</b></h2>
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

        <div class="transaction">
    <?php if (!empty($completedPrograms)) : ?>
        <div class="header">
            <h3>
                Riwayat Wakaf
            </h3>
            <div class="see-all">
                <a href="riwayat.php" class="see-all btn">Lihat Semua</a>
            </div>
        </div>
        <?php 
        // Batasi jumlah program yang ditampilkan menjadi 5
        $limitedPrograms = array_slice($completedPrograms, 0, 5); 
        foreach ($limitedPrograms as $program) : 
        ?>
            <div class="transaction-item">
                <img src="<?= $program['image'] ?>" alt="<?= $program['name'] ?>" width="40" height="40">
                <div class="details">
                    <h4><b><?= $program['name'] ?></b></h4>
                    <p>
                        Target Kebutuhan:<br> Rp. <?= number_format($program['target_amount'], 0, ',', '.') ?>
                    </p>
                </div>
                <div class="amount">
                    <h4>Status: <b style="color: green;">Selesai</b></h4>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


        <section id="maps-section" style="margin: 20px 0;">
            <h2 style="text-align: center; color: #2596be;">Lokasi Kami</h2> <br>
            <div class="maps-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d246.98305254476125!2d110.31905451143535!3d-7.923365710954173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aff69cc5481a5%3A0xdd726145fff4c37e!2sPESANTREN%20PUTRI%20JOGJA%20AZZAKIYYAH!5e0!3m2!1sid!2sid!4v1726245173472!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>


        <div class="bottom-navbar">
            <a href="index.php" class="nav-link">
                <i class="bx bx-home"></i>
                <span class="nav-text">Home</span>
            </a>
            <a href="ziswaf.php" class="nav-link">
                <i class="bx bx-donate-heart"></i>
                <span class="nav-text">Wakaf</span>
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
    </div>

</body>

</html>