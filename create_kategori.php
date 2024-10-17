<?php
include 'db.php';

// Ambil data kategori untuk di-edit jika ada parameter `edit_id`
$kategori_to_update = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM kategori WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $kategori_to_update = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori_name = $_POST['kategori_name'];
    $kategori_id = isset($_POST['kategori_id']) ? $_POST['kategori_id'] : null;

    if ($kategori_id) {
        $sql = "UPDATE kategori SET kategori_name = '$kategori_name' WHERE id = $kategori_id";
    } else {
        $sql = "INSERT INTO kategori (kategori_name) VALUES ('$kategori_name')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Kategori saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM kategori WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Kategori deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
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
    <div class="alert alert-danger" role="alert">
        PERHATIAN!!!
    </div>
    <div class="alert alert-warning" role="alert">
        Belum Bisa Dipakai! Masih dalam mode pengembangan
    </div>

    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <a href="admin" class="back"><i class="bi bi-chevron-left"></i> Back</a>
                    <h1>Create Kategori</h1>
                    <form action="create_kategori.php" method="POST">
                        <input type="hidden" name="kategori_id" value="<?php echo $kategori_to_update['id'] ?? ''; ?>">
                        <label for="kategori_name">Nama Kategori:</label>
                        <input type="text" name="kategori_name" value="<?php echo $kategori_to_update['kategori_name'] ?? ''; ?>" required>
                        <button value="Save Kategori" class="btn btn-success mt-3">Simpan Kategori</button>
                    </form>

                    <div class="card shadow mb-4 mt-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kategori List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $conn->query("SELECT * FROM kategori");
                                        if ($result->num_rows > 0) {
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$i}</td>
                                                        <td>{$row['kategori_name']}</td>
                                                        <td>
                                                            <a href='create_kategori.php?edit_id={$row['id']}' class='btn btn-primary'>Edit</a>
                                                            <a href='create_kategori.php?delete_id={$row['id']}' class='btn btn-danger'>Delete</a>
                                                        </td>
                                                      </tr>";
                                                $i++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>No categories found</td></tr>";
                                        }
                                        ?>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>