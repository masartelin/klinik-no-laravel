<?php
include 'koneksi.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM Poli WHERE Poli_ID = '$id'";
    mysqli_query($conn, $delete_query);
    header("Location: form_poli.php");
    exit();
}

// Handle Edit mode
$is_edit = false;
$edit_id = "";
$nama = "";

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $is_edit = true;
    
    $query = "SELECT * FROM Poli WHERE Poli_ID = '$edit_id'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nama = $row['Nama_Poli'];
    }
}

// Auto generate ID untuk mode tambah
if (!$is_edit) {
    $edit_id = generateNextId($conn, 'Poli', 'Poli_ID', 'PL');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_input = $_POST['nama'];
    $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] == '1';
    
    if ($is_edit) {
        $update_query = "UPDATE Poli SET Nama_Poli = '$nama_input' WHERE Poli_ID = '$id'";
        mysqli_query($conn, $update_query);
    } else {
        if (empty($id)) {
            $id = generateNextId($conn, 'Poli', 'Poli_ID', 'PL');
        }
        $insert_query = "INSERT INTO Poli (Poli_ID, Nama_Poli) VALUES ('$id', '$nama_input')";
        mysqli_query($conn, $insert_query);
    }
    
    header("Location: form_poli.php");
    exit();
}

// Get all poli data
$query = "SELECT * FROM Poli ORDER BY Poli_ID";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Poli - Klinik</title>
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>🏥 Data Poli</h1>
            <p>Kelola data poli klinik</p>
        </div>
        
        <div class="card-header" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
            <a href="form_poli.php?add=1" class="btn btn-primary">➕ Tambah Baru</a>
        </div>
        
        <?php if (isset($_GET['add']) || $is_edit): ?>
        <div class="form-container">
            <h2 class="form-title"><?php echo $is_edit ? '✏️ Edit Data Poli' : '➕ Tambah Data Poli'; ?></h2>
            
            <form method="POST" action="">
                <input type="hidden" name="is_edit" value="<?php echo $is_edit ? '1' : '0'; ?>">
                <div class="form-group">
                    <label>📋 Poli_ID (Otomatis)</label>
                    <input type="text" name="id" value="<?php echo $edit_id; ?>" readonly style="background:#f0f0f0;" required>
                </div>
                <div class="form-group">
                    <label>🏥 Nama Poli</label>
                    <input type="text" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan nama poli" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">✅ Simpan</button>
                    <button type="reset" class="btn btn-danger">🔄 Reset</button>
                    <a href="form_poli.php" class="btn" style="background: #6c757d; color: white;">❌ Batal</a>
                </div>
            </form>
        </div>
        <?php endif; ?>
        
        <div class="content-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Poli</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><strong><?php echo $row['Poli_ID']; ?></strong></td>
                                <td><?php echo $row['Nama_Poli']; ?></td>
                                <td>
                                    <a href="form_poli.php?edit=<?php echo $row['Poli_ID']; ?>" class="action-btn btn-warning">✏️ Edit</a>
                                    <a href="form_poli.php?delete=<?php echo $row['Poli_ID']; ?>" class="action-btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">🗑️ Hapus</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-state-icon">🏥</div>
                                    <p>Belum ada data poli</p>
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
