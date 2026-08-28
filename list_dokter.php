<?php
include 'koneksi.php';

$query = "SELECT d.*, p.Nama_Poli FROM Dokter d LEFT JOIN Poli p ON d.Poli_ID = p.Poli_ID ORDER BY d.Dokter_ID";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Dokter - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>👨‍⚕️ List Dokter</h1>
            <p>Laporan data dokter klinik</p>
        </div>
        
        <div class="content-card">
            <div class="card-header">
                <h3>Data Dokter</h3>
                <button onclick="window.print()" class="btn">🖨️ Cetak</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Dokter</th>
                        <th>Poli</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><strong><?php echo $row['Dokter_ID']; ?></strong></td>
                                <td><?php echo $row['Nama_Dokter']; ?></td>
                                <td><span class="badge"><?php echo $row['Nama_Poli']; ?></span></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-state-icon">👨‍⚕️</div>
                                    <p>Belum ada data dokter</p>
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
