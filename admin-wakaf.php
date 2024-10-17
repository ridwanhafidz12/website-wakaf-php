<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
            color: #333;
        }

        .button-group {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .button {
            background-color: #eee;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 90%;
            height: 50px;
            text-align: center;
            line-height: 30px;
            font-size: 16px;
        }

        .button:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: inherit;
            display: block;
            width: 100%;
            height: 100%;
            line-height: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <div>
                <a href="">
                    <img src="az1.png" width="60px" alt="Logo Azzakiyyah">
                </a>
            </div>
        </nav>
        <h1>Halo, Admin Wakaf Pendidikan</h1>
        <p>Selamat datang di Azzakiyyah</p>

        <h2>Fitur</h2>
        <div class="button-group">
            <div class="button">
                <a href="create_user.php">Tambah Wakif</a>
            </div>
            <div class="button">
                <a href="create_program.php">Tambah Program</a>
            </div>
        </div>

        <h2>Analisis</h2>
        <div class="button-group">
            <div class="button">
                <a href="wakif-admin.php">Analisis Jumlah Wakif</a>
            </div>
        </div>

        <h2>Data</h2>
        <div class="button-group">
            <div class="button">
                <a href="klinik.php"></a>
            </div>
        </div>
    </div>
</body>

</html>