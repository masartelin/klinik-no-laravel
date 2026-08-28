<?php
$host = "localhost";
$user = "root";
$pass = ""; // Laragon default password
$db   = "klinik";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
