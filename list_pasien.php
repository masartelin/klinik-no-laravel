<?php
include 'koneksi.php';

$query = "SELECT * FROM Pasien ORDER BY PasienKlinik_ID";
$result = mysqli_query($conn, $query);

function hitungUsia($tanggal_lahir) {
    $birth = new DateTime($tanggal_lahir);
    $today = new DateTime();
    $age = $today->diff($birth)->y;
    return $age;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pasien - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>👤 List Pasien</h1>
            <p>Laporan data pasien klinik</p>
        </div>
        
        <div class="content-card">
            <div class="card-header">
                <h3>Data Pasien</h3>
                <button onclick="window.print()" class="btn">🖨️ Cetak</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $usia = hitungUsia($row['Tanggal_LahirPasien']);
                            $jk_badge = $row['Jenis_KelaminPasien'] == 'Laki-Laki' ? 'badge-lk' : 'badge-pr';
                            ?>
                            <tr>
                                <td><strong><?php echo $row['PasienKlinik_ID']; ?></strong></td>
                                <td><?php echo $row['Nama_PasienKlinik']; ?></td>
                                <td><?php echo $row['Tanggal_LahirPasien']; ?></td>
                                <td><?php echo $usia; ?> th</td>
                                <td><span class="badge <?php echo $jk_badge; ?>"><?php echo $row['Jenis_KelaminPasien']; ?></span></td>
                                <td><?php echo $row['Alamat_Pasien']; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">👤</div>
                                    <p>Belum ada data pasien</p>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
