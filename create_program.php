<?php
include 'db.php';

// Ambil data program untuk di-edit jika ada parameter `edit_id`
$program_to_update = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM program WHERE id = $edit_id");
    if ($result->num_rows > 0) {
        $program_to_update = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $program_name = $_POST['program_name'];
    $target_amount = $_POST['target_amount'];
    $description = $_POST['description'];
    $program_id = isset($_POST['program_id']) ? $_POST['program_id'] : null;

    $target_file = null;
    if ($_FILES['program_image']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["program_image"]["name"]);
        move_uploaded_file($_FILES["program_image"]["tmp_name"], $target_file);
    }

    if ($program_id) {
        $sql = "UPDATE program SET program_name = '$program_name', target_amount = $target_amount, description = '$description'";
        if ($target_file) {
            $sql .= ", image = '$target_file'";
        }
        $sql .= " WHERE id = $program_id";
    } else {
        $sql = "INSERT INTO program (program_name, target_amount, description, image) VALUES ('$program_name', $target_amount, '$description', '$target_file')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Program saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM program WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Program deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Program</title>
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
                    <h1>Create Program</h1>
                    <form action="create_program.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="program_id" value="<?php echo $program_to_update['id'] ?? ''; ?>">
                        <label for="program_name">Program Name:</label>
                        <input type="text" name="program_name" value="<?php echo $program_to_update['program_name'] ?? ''; ?>" required><br>
                        <label for="target_amount">Target Kebutuhan:</label>
                        <input type="number" name="target_amount" value="<?php echo $program_to_update['target_amount'] ?? ''; ?>" required><br>
                        <label for="description">Deskripsi:</label>
                        <textarea name="description" required><?php echo $program_to_update['description'] ?? ''; ?></textarea><br>
                        <label for="program_image">Program:</label>
                        <input type="file" name="program_image"><br>
                        <button type="submit" class="btn btn-success mt-3">Simpan Program</button>
                    </form>

                    <div class="card shadow mb-4 mt-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Program List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Program</th>
                                            <th>Target Kebutuhan</th>
                                            <th>Deskripsi</th>
                                            <th>Gambar</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $conn->query("SELECT * FROM program");
                                        if ($result->num_rows > 0) {
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>{$i}</td>
                                                        <td>{$row['program_name']}</td>
                                                        <td>Rp. " . number_format($row['target_amount'], 0, ',', '.') . "</td>
                                                        <td>{$row['description']}</td>
                                                        <td><img src='{$row['image']}' alt='{$row['program_name']}' width='100'></td>
                                                        <td>
                                                            <a href='create_program.php?edit_id={$row['id']}' class='btn btn-primary'>Edit</a>
                                                            <a href='create_program.php?delete_id={$row['id']}' class='btn btn-danger'>Delete</a>
                                                        </td>
                                                      </tr>";
                                                $i++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No programs found</td></tr>";
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
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>

</html>
