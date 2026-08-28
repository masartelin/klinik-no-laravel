<?php
include 'koneksi.php';

$query = "SELECT b.No_Transaksi, b.Tanggal_Berobat, p.Nama_PasienKlinik, 
          p.Tanggal_LahirPasien, p.Jenis_KelaminPasien, b.Keluhan_Pasien, 
          pol.Nama_Poli, d.Nama_Dokter, b.Biaya_Adm
          FROM Berobat b
          JOIN Pasien p ON b.PasienKlinik_ID = p.PasienKlinik_ID
          JOIN Dokter d ON b.Dokter_ID = d.Dokter_ID
          JOIN Poli pol ON d.Poli_ID = pol.Poli_ID
          ORDER BY b.No_Transaksi";

$result = mysqli_query($conn, $query);

function hitungUsia($tanggal_lahir) {
    $birth = new DateTime($tanggal_lahir);
    $today = new DateTime();
    $age = $today->diff($birth)->y;
    return $age;
}

function formatRupiah($angka) {
    return number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Data Berobat - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>💊 List Data Berobat</h1>
            <p>Laporan lengkap data transaksi berobat</p>
        </div>
        
        <div class="content-card">
            <div class="card-header">
                <h3>Data Berobat</h3>
                <button onclick="window.print()" class="btn">🖨️ Cetak</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>Keluhan</th>
                        <th>Nama Poli</th>
                        <th>Dokter</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $usia = hitungUsia($row['Tanggal_LahirPasien']);
                            $tanggal = date('Y/m/d', strtotime($row['Tanggal_Berobat']));
                            $biaya = formatRupiah($row['Biaya_Adm']);
                            $jk_badge = $row['Jenis_KelaminPasien'] == 'Laki-Laki' ? 'badge-lk' : 'badge-pr';
                            ?>
                            <tr>
                                <td><strong><?php echo $row['No_Transaksi']; ?></strong></td>
                                <td><?php echo $tanggal; ?></td>
                                <td><?php echo $row['Nama_PasienKlinik']; ?></td>
                                <td><?php echo $usia; ?> th</td>
                                <td><span class="badge <?php echo $jk_badge; ?>"><?php echo $row['Jenis_KelaminPasien']; ?></span></td>
                                <td><?php echo $row['Keluhan_Pasien']; ?></td>
                                <td><?php echo $row['Nama_Poli']; ?></td>
                                <td><?php echo $row['Nama_Dokter']; ?></td>
                                <td>Rp <?php echo $biaya; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-state-icon">💊</div>
                                    <p>Belum ada data berobat</p>
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
