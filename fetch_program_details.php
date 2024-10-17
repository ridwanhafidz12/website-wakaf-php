<?php
include 'db.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Query untuk mendapatkan program berdasarkan user_id
    $sql = "SELECT pr.program_name, p.jumlah FROM pemasukan p
            JOIN program pr ON p.program_id = pr.id
            WHERE p.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
            echo "<td>Rp. " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No data found</td></tr>";
    }
    $stmt->close();
}
?>
