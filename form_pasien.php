<?php
include 'koneksi.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM Pasien WHERE PasienKlinik_ID = '$id'";
    mysqli_query($conn, $delete_query);
    header("Location: form_pasien.php");
    exit();
}

// Handle Edit mode
$is_edit = false;
$edit_id = "";
$nama = "";
$tanggal_lahir = "";
$jenis_kelamin = "";
$alamat = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $is_edit = true;
    
    $query = "SELECT * FROM Pasien WHERE PasienKlinik_ID = '$edit_id'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nama = $row['Nama_PasienKlinik'];
        $tanggal_lahir = $row['Tanggal_LahirPasien'];
        $jenis_kelamin = $row['Jenis_KelaminPasien'];
        $alamat = $row['Alamat_Pasien'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_input = $_POST['nama'];
    $tanggal_lahir_input = $_POST['tanggal_lahir'];
    $jenis_kelamin_input = $_POST['jenis_kelamin'];
    $alamat_input = $_POST['alamat'];
    
    if ($is_edit) {
        $update_query = "UPDATE Pasien SET 
                        Nama_PasienKlinik = '$nama_input',
                        Tanggal_LahirPasien = '$tanggal_lahir_input',
                        Jenis_KelaminPasien = '$jenis_kelamin_input',
                        Alamat_Pasien = '$alamat_input'
                        WHERE PasienKlinik_ID = '$id'";
        mysqli_query($conn, $update_query);
    } else {
        $insert_query = "INSERT INTO Pasien (PasienKlinik_ID, Nama_PasienKlinik, Tanggal_LahirPasien, Jenis_KelaminPasien, Alamat_Pasien) 
                        VALUES ('$id', '$nama_input', '$tanggal_lahir_input', '$jenis_kelamin_input', '$alamat_input')";
        mysqli_query($conn, $insert_query);
    }
    
    header("Location: form_pasien.php");
    exit();
}

// Get all pasien data
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
    <title>Data Pasien - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>👤 Data Pasien</h1>
            <p>Kelola data pasien klinik</p>
        </div>
        
        <div class="card-header" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
            <a href="form_pasien.php?add=1" class="btn btn-primary">➕ Tambah Baru</a>
        </div>
        
        <?php if (isset($_GET['add']) || $is_edit): ?>
        <div class="form-container">
            <h2 class="form-title"><?php echo $is_edit ? '✏️ Edit Data Pasien' : '➕ Tambah Data Pasien'; ?></h2>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>📋 PasienKlinik_ID</label>
                    <input type="text" name="id" value="<?php echo $edit_id; ?>" <?php echo $is_edit ? 'readonly' : ''; ?> placeholder="Masukkan ID pasien" required>
                </div>
                <div class="form-group">
                    <label>👤 Nama Pasien</label>
                    <input type="text" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama pasien" required>
                </div>
                <div class="form-group">
                    <label>📅 Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>" required>
                </div>
                <div class="form-group">
                    <label>⚧ Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-Laki" <?php echo $jenis_kelamin == 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                        <option value="Perempuan" <?php echo $jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>📍 Alamat</label>
                    <textarea name="alamat" placeholder="Masukkan alamat pasien"><?php echo $alamat; ?></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">✅ Simpan</button>
                    <button type="reset" class="btn btn-danger">🔄 Reset</button>
                    <a href="form_pasien.php" class="btn" style="background: #6c757d; color: white;">❌ Batal</a>
                </div>
            </form>
        </div>
        <?php endif; ?>
        
        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
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
                                <td>
                                    <a href="form_pasien.php?edit=<?php echo $row['PasienKlinik_ID']; ?>" class="action-btn btn-warning">✏️ Edit</a>
                                    <a href="form_pasien.php?delete=<?php echo $row['PasienKlinik_ID']; ?>" class="action-btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">🗑️ Hapus</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7">
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
