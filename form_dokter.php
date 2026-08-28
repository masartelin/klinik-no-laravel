<?php
include 'koneksi.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM Dokter WHERE Dokter_ID = '$id'";
    mysqli_query($conn, $delete_query);
    header("Location: form_dokter.php");
    exit();
}

// Handle Edit mode
$is_edit = false;
$edit_id = "";
$nama = "";
$poli_id = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $is_edit = true;
    
    $query = "SELECT * FROM Dokter WHERE Dokter_ID = '$edit_id'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nama = $row['Nama_Dokter'];
        $poli_id = $row['Poli_ID'];
    }
}

// Auto generate ID untuk mode tambah
if (!$is_edit) {
    $edit_id = generateNextId($conn, 'Dokter', 'Dokter_ID', 'DR');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_input = $_POST['nama'];
    $poli_id_input = $_POST['poli_id'];
    $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] == '1';
    
    if ($is_edit) {
        $update_query = "UPDATE Dokter SET 
                        Nama_Dokter = '$nama_input',
                        Poli_ID = '$poli_id_input'
                        WHERE Dokter_ID = '$id'";
        mysqli_query($conn, $update_query);
    } else {
        if (empty($id)) {
            $id = generateNextId($conn, 'Dokter', 'Dokter_ID', 'DR');
        }
        $insert_query = "INSERT INTO Dokter (Dokter_ID, Nama_Dokter, Poli_ID) 
                        VALUES ('$id', '$nama_input', '$poli_id_input')";
        mysqli_query($conn, $insert_query);
    }
    
    header("Location: form_dokter.php");
    exit();
}

// Get all dokter data
$query = "SELECT d.*, p.Nama_Poli FROM Dokter d LEFT JOIN Poli p ON d.Poli_ID = p.Poli_ID ORDER BY d.Dokter_ID";
$result = mysqli_query($conn, $query);

// Get poli data for dropdown
$poli_query = "SELECT * FROM Poli ORDER BY Nama_Poli";
$poli_result = mysqli_query($conn, $poli_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>👨‍⚕️ Data Dokter</h1>
            <p>Kelola data dokter klinik</p>
        </div>
        
        <div class="card-header" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
            <a href="form_dokter.php?add=1" class="btn btn-primary">➕ Tambah Baru</a>
        </div>
        
        <?php if (isset($_GET['add']) || $is_edit): ?>
        <div class="form-container">
            <h2 class="form-title"><?php echo $is_edit ? '✏️ Edit Data Dokter' : '➕ Tambah Data Dokter'; ?></h2>
            
            <form method="POST" action="">
                <input type="hidden" name="is_edit" value="<?php echo $is_edit ? '1' : '0'; ?>">
                <div class="form-group">
                    <label>📋 Dokter_ID (Otomatis)</label>
                    <input type="text" name="id" value="<?php echo $edit_id; ?>" readonly style="background:#f0f0f0;" required>
                </div>
                <div class="form-group">
                    <label>👨‍⚕️ Nama Dokter</label>
                    <input type="text" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama dokter" required>
                </div>
                <div class="form-group">
                    <label>🏥 Poli</label>
                    <select name="poli_id" required>
                        <option value="">-- Pilih Poli --</option>
                        <?php
                        while ($poli = mysqli_fetch_assoc($poli_result)) {
                            $selected = ($poli_id == $poli['Poli_ID']) ? 'selected' : '';
                            echo "<option value='" . $poli['Poli_ID'] . "' $selected>" . $poli['Nama_Poli'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">✅ Simpan</button>
                    <button type="reset" class="btn btn-danger">🔄 Reset</button>
                    <a href="form_dokter.php" class="btn" style="background: #6c757d; color: white;">❌ Batal</a>
                </div>
            </form>
        </div>
        <?php endif; ?>
        
        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Dokter</th>
                        <th>Poli</th>
                        <th>Aksi</th>
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
                                <td><?php echo $row['Nama_Poli']; ?></td>
                                <td>
                                    <a href="form_dokter.php?edit=<?php echo $row['Dokter_ID']; ?>" class="action-btn btn-warning">✏️ Edit</a>
                                    <a href="form_dokter.php?delete=<?php echo $row['Dokter_ID']; ?>" class="action-btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">🗑️ Hapus</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="4">
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
