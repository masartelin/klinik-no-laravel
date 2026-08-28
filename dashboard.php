<?php
include 'koneksi.php';

// Recent transactions
$recent_query = "SELECT b.No_Transaksi, b.Tanggal_Berobat, p.Nama_PasienKlinik, d.Nama_Dokter, b.Biaya_Adm
                 FROM Berobat b
                 JOIN Pasien p ON b.PasienKlinik_ID = p.PasienKlinik_ID
                 JOIN Dokter d ON b.Dokter_ID = d.Dokter_ID
                 ORDER BY b.Tanggal_Berobat DESC, b.No_Transaksi DESC
                 LIMIT 5";
$recent_result = mysqli_query($conn, $recent_query);

function formatRupiah($angka) {
    return number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>📊 Dashboard</h1>
            <p>Ringkasan aktivitas klinik</p>
        </div>
        
        <div class="content-card">
            <div class="card-header">
                <h3>💊 5 Transaksi Terakhir</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($recent_result) > 0) {
                        while ($row = mysqli_fetch_assoc($recent_result)) {
                            $tanggal = date('d/m/Y', strtotime($row['Tanggal_Berobat']));
                            $biaya = formatRupiah($row['Biaya_Adm']);
                            ?>
                            <tr>
                                <td><strong><?php echo $row['No_Transaksi']; ?></strong></td>
                                <td><?php echo $tanggal; ?></td>
                                <td><?php echo $row['Nama_PasienKlinik']; ?></td>
                                <td><?php echo $row['Nama_Dokter']; ?></td>
                                <td>Rp <?php echo $biaya; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #666;">Belum ada transaksi</td>
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
