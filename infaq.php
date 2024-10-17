<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wakaf Pendidikan Azzakiyyah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .slider-section {
            height: 100vh;
            background: url('mekkah.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-content {
            text-align: center;
            color: white;
            animation: fadeInDown 2s;
        }

        .slider-content h1 {
            font-size: 4em;
            text-transform: uppercase;
        }

        .ziswaf-section {
            padding: 50px 0;
            background: #f4f4f4;
            text-align: center;
        }

        .ziswaf-section h2 {
            margin-bottom: 30px;
        }

        .ziswaf-cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .ziswaf-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 22%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s;
        }

        .ziswaf-card:hover {
            transform: translateY(-10px);
        }

        .campaign-section {
            padding: 50px 0;
            background: #e9ecef;
        }

        .campaign-section h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .campaign-slider {
            width: 80%;
            margin: 0 auto;
        }

        .campaign-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 0 10px;
        }

        .campaign-card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .campaign-card h3 {
            margin-bottom: 15px;
        }

        .campaign-card p {
            font-size: 0.9em;
            color: #555;
        }

        .contact-section {
            padding: 50px 0;
            background: #343a40;
            color: white;
        }

        .contact-section h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .contact-section .contact-info, .contact-section .maps {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 30px;
        }

        .contact-info {
            max-width: 400px;
        }

        .maps iframe {
            width: 100%;
            height: 300px;
            border: none;
        }
    </style>
</head>
<body>

    <!-- Section 1: Slider -->
    <section class="slider-section">
        <div class="slider-content animate__animated animate__fadeInDown">
            <h1>Wakaf Pendidikan Azzakiyyah</h1>
            <p>Membuka jalan pendidikan untuk generasi yang lebih baik</p>
        </div>
    </section>

    <!-- Section 2: ZISWAF Categories -->
    <section class="ziswaf-section">
        <h2>Kategori ZISWAF</h2>
        <div class="ziswaf-cards">
            <div class="ziswaf-card animate__animated animate__fadeInUp">
                <h3>Zakat</h3>
                <p>Salurkan zakat Anda untuk membantu yang membutuhkan.</p>
            </div>
            <div class="ziswaf-card animate__animated animate__fadeInUp animate__delay-1s">
                <h3>Infaq</h3>
                <p>Bersedekah dengan infaq untuk kebaikan bersama.</p>
            </div>
            <div class="ziswaf-card animate__animated animate__fadeInUp animate__delay-2s">
                <h3>Sedekah</h3>
                <p>Berikan sedekah untuk meringankan beban sesama.</p>
            </div>
            <div class="ziswaf-card animate__animated animate__fadeInUp animate__delay-3s">
                <h3>Wakaf</h3>
                <p>Investasikan wakaf untuk masa depan yang lebih baik.</p>
            </div>
        </div>
    </section>

    <!-- Section 3 & 4: Campaign Slider -->
    <section class="campaign-section">
        <h2>Campaign Donasi</h2>
        <div class="campaign-slider">
            <div class="campaign-card">
                <img src="campaign1.jpg" alt="Campaign 1">
                <h3>Pembangunan Sekolah</h3>
                <p>Bantu pembangunan sekolah untuk anak-anak di daerah terpencil.</p>
                <a href="#" class="btn btn-primary">Donasi Sekarang</a>
            </div>
            <div class="campaign-card">
                <img src="campaign2.jpg" alt="Campaign 2">
                <h3>Beasiswa Pelajar</h3>
                <p>Berikan beasiswa kepada pelajar berprestasi yang kurang mampu.</p>
                <a href="#" class="btn btn-primary">Donasi Sekarang</a>
            </div>
            <div class="campaign-card">
                <img src="campaign3.jpg" alt="Campaign 3">
                <h3>Wakaf Buku</h3>
                <p>Donasikan buku untuk perpustakaan di sekolah-sekolah terpencil.</p>
                <a href="#" class="btn btn-primary">Donasi Sekarang</a>
            </div>
            <div class="campaign-card">
                <img src="campaign4.jpg" alt="Campaign 4">
                <h3>Pembangunan Masjid</h3>
                <p>Bantu pembangunan masjid di daerah yang membutuhkan.</p>
                <a href="#" class="btn btn-primary">Donasi Sekarang</a>
            </div>
        </div>
    </section>

    <!-- Section 5: Contact & Maps -->
    <section class="contact-section">
        <h2>Kontak dan Lokasi</h2>
        <div class="contact-info">
            <div>
                <h3>Alamat</h3>
                <p>Jl. Pendidikan No.123, Kota A</p>
            </div>
            <div>
                <h3>Telepon</h3>
                <p>(021) 123-4567</p>
            </div>
        </div>
        <div class="maps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.180409527074!2d-122.42061418448285!3d37.77660837975814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858064fbc2f2b7%3A0x5f74cfb3872b1d8e!2sGoogle!5e0!3m2!1sen!2sus!4v1611803102090!5m2!1sen!2sus"></iframe>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.campaign-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                dots: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>
</body>
</html>
