<?php
$servername = "localhost";
$username = "pkbk5879_db_ziswaf";
$password = "Ridwanhafidz11";
$dbname = "pkbk5879_db_ziswaf";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
