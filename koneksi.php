<?php
// File koneksi database
// Sesuaikan password sesuai environment Anda:
// - Laragon biasanya: "" atau password yang diset
// - XAMPP biasanya: ""
$host = "localhost";
$user = "root";
$pass = ""; // Ubah sesuai password MySQL Anda
$db   = "klinik";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

/**
 * Generate next ID otomatis
 * Contoh: generateNextId($conn, 'Pasien', 'PasienKlinik_ID', 'PS') → PS006
 */
function generateNextId($conn, $table, $column, $prefix, $pad = 3) {
    $query = "SELECT $column FROM $table WHERE $column LIKE '$prefix%' ORDER BY $column DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastId = $row[$column];
        // Ambil angka di belakang prefix
        $num = (int) substr($lastId, strlen($prefix));
        $num++;
    } else {
        $num = 1;
    }
    
    return $prefix . str_pad($num, $pad, '0', STR_PAD_LEFT);
}
?>
