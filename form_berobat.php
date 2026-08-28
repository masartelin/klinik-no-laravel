<?php
include 'koneksi.php';

// Arrays for date components
$bulan_array = array(
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);

// Initialize variables
$no_transaksi = "";
$selected_pasien = "";
$selected_tanggal = "";
$selected_bulan = "";
$tahun = "";
$selected_dokter = "";
$keluhan = "";
$biaya_adm = "";
$is_edit = false;

// Handle Edit mode
if (isset($_GET['edit'])) {
    $no_transaksi = $_GET['edit'];
    $is_edit = true;
    
    $query = "SELECT * FROM Berobat WHERE No_Transaksi = '$no_transaksi'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $selected_pasien = $row['PasienKlinik_ID'];
        $selected_dokter = $row['Dokter_ID'];
        $keluhan = $row['Keluhan_Pasien'];
        $biaya_adm = $row['Biaya_Adm'];
        
        // Parse date
        $tanggal_obj = date_create($row['Tanggal_Berobat']);
        $selected_tanggal = date_format($tanggal_obj, 'd');
        $selected_bulan = date_format($tanggal_obj, 'n');
        $tahun = date_format($tanggal_obj, 'Y');
    }
}

// Auto generate No_Transaksi untuk mode tambah
if (!$is_edit) {
    $no_transaksi = generateNextId($conn, 'Berobat', 'No_Transaksi', 'TR');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_transaksi = $_POST['no_transaksi'];
    $pasien_id = $_POST['pasien_id'];
    $tanggal = $_POST['tanggal'];
    $bulan = $_POST['bulan'];
    $tahun_input = $_POST['tahun'];
    $dokter_id = $_POST['dokter_id'];
    $keluhan_input = $_POST['keluhan'];
    $biaya_adm_input = $_POST['biaya_adm'];
    $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] == '1';
    
    // Format date (YYYY-MM-DD)
    $tanggal_berobat = sprintf('%04d-%02d-%02d', (int)$tahun_input, (int)$bulan, (int)$tanggal);
    
    if ($is_edit) {
        // Update existing record
        $update_query = "UPDATE Berobat SET 
                        PasienKlinik_ID = '$pasien_id',
                        Tanggal_Berobat = '$tanggal_berobat',
                        Dokter_ID = '$dokter_id',
                        Keluhan_Pasien = '$keluhan_input',
                        Biaya_Adm = '$biaya_adm_input'
                        WHERE No_Transaksi = '$no_transaksi'";
        mysqli_query($conn, $update_query);
    } else {
        // Generate ulang jika kosong
        if (empty($no_transaksi)) {
            $no_transaksi = generateNextId($conn, 'Berobat', 'No_Transaksi', 'TR');
        }
        // Insert new record
        $insert_query = "INSERT INTO Berobat (No_Transaksi, PasienKlinik_ID, Tanggal_Berobat, Dokter_ID, Keluhan_Pasien, Biaya_Adm) 
                        VALUES ('$no_transaksi', '$pasien_id', '$tanggal_berobat', '$dokter_id', '$keluhan_input', '$biaya_adm_input')";
        mysqli_query($conn, $insert_query);
    }
    
    header("Location: listberobat.php");
    exit();
}

// Get data for dropdowns
$pasien_query = "SELECT * FROM Pasien ORDER BY Nama_PasienKlinik";
$pasien_result = mysqli_query($conn, $pasien_query);

$dokter_query = "SELECT * FROM Dokter ORDER BY Nama_Dokter";
$dokter_result = mysqli_query($conn, $dokter_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Berobat - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
    <style>
        .date-group {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 15px;
        }
        @media (max-width: 768px) {
            .date-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>💊 Form Berobat</h1>
            <p><?php echo $is_edit ? 'Edit data transaksi berobat' : 'Tambah data transaksi berobat baru'; ?></p>
        </div>
        
        <div class="card-header" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
            <a href="listberobat.php" class="btn btn-primary">📋 Lihat Data</a>
        </div>
        
        <div class="form-container">
            <h2 class="form-title"><?php echo $is_edit ? '✏️ Edit Data Berobat' : '➕ Tambah Data Berobat'; ?></h2>
            
            <form method="POST" action="">
                <input type="hidden" name="is_edit" value="<?php echo $is_edit ? '1' : '0'; ?>">
                <div class="form-group">
                    <label>📋 No Transaksi (Otomatis)</label>
                    <input type="text" name="no_transaksi" value="<?php echo $no_transaksi; ?>" readonly style="background:#f0f0f0;" required>
                </div>
                
                <div class="form-group">
                    <label>👤 Nama Pasien</label>
                    <select name="pasien_id" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php
                        while ($pasien = mysqli_fetch_assoc($pasien_result)) {
                            $selected = ($selected_pasien == $pasien['PasienKlinik_ID']) ? 'selected' : '';
                            echo "<option value='" . $pasien['PasienKlinik_ID'] . "' $selected>" . $pasien['Nama_PasienKlinik'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>📅 Tanggal Berobat</label>
                    <div class="date-group">
                        <select name="tanggal" required>
                            <option value="">-- Tanggal --</option>
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                $selected = ($selected_tanggal == $i) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        
                        <select name="bulan" required>
                            <option value="">-- Bulan --</option>
                            <?php
                            foreach ($bulan_array as $key => $value) {
                                $selected = ($selected_bulan == $key) ? 'selected' : '';
                                echo "<option value='$key' $selected>$value</option>";
                            }
                            ?>
                        </select>
                        
                        <input type="text" name="tahun" placeholder="Tahun" value="<?php echo $tahun; ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>👨‍⚕️ Nama Dokter</label>
                    <select name="dokter_id" required>
                        <option value="">-- Pilih Dokter --</option>
                        <?php
                        mysqli_data_seek($dokter_result, 0);
                        while ($dokter = mysqli_fetch_assoc($dokter_result)) {
                            $selected = ($selected_dokter == $dokter['Dokter_ID']) ? 'selected' : '';
                            echo "<option value='" . $dokter['Dokter_ID'] . "' $selected>" . $dokter['Nama_Dokter'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>📝 Keluhan</label>
                    <textarea name="keluhan" placeholder="Deskripsikan keluhan pasien" required><?php echo $keluhan; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>💰 Biaya Administrasi</label>
                    <input type="number" name="biaya_adm" value="<?php echo $biaya_adm; ?>" placeholder="Masukkan biaya administrasi" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">✅ Simpan</button>
                    <button type="reset" class="btn btn-danger">🔄 Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
