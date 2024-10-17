<?php
include 'db.php';

// Ambil data pengguna untuk di-edit jika ada parameter `edit_id`
$user_to_edit = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM users WHERE user_id = '$edit_id'");
    if ($result->num_rows > 0) {
        $user_to_edit = $result->fetch_assoc();
    }
}

// Proses pengiriman form untuk menambahkan atau memperbarui pengguna
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']); // Escaping nama input
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

    if (empty($nama)) {
        echo "Nama harus diisi.";
    } else {
        if ($user_id) {
            // Perbarui pengguna yang ada
            $sql = "UPDATE users SET nama = '$nama' WHERE user_id = '$user_id'";
        } else {
            // Generate ID unik (misalnya, A001)
            $result = $conn->query("SELECT id FROM users ORDER BY id DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $last_id = $result->fetch_assoc()['id'];
                $new_id = "A" . str_pad($last_id + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $new_id = "A001";
            }
            // Insert pengguna baru
            $sql = "INSERT INTO users (user_id, nama) VALUES ('$new_id', '$nama')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Pengguna berhasil disimpan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


// Proses operasi hapus
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE user_id = '$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Pengguna berhasil dihapus.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data pengguna yang ada
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Wakif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="admin"><img src="az1.png" width="60px" alt="Logo Azzakiyyah"></a>
        </div>
    </nav>
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                <a href="admin" class="back"><i class="bi bi-chevron-left"></i> Back</a>
                    <h2>Tambah atau Edit Wakif</h2>
                    <form action="" method="POST" class="form-group">
                        <input type="hidden" name="user_id" value="<?php echo $user_to_edit['user_id'] ?? ''; ?>">
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="<?php echo $user_to_edit['nama'] ?? ''; ?>" required>
                        <button type="submit" class="btn btn-success mt-3">Simpan Wakif</button>
                    </form>

                    <div class="card shadow mb-4 mt-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Wakif</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th>NIWA</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($user = $users->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                                <td><?php echo htmlspecialchars($user['nama']); ?></td>
                                                <td>
                                                    <a href="create_user.php?edit_id=<?php echo $user['user_id']; ?>" class="btn btn-warning btn-circle">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="create_user.php?delete_id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-circle" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>
