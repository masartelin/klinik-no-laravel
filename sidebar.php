<div class="sidebar">
    <div class="sidebar-header">
        <h2>🏥 Klinik</h2>
        <p>Sistem Manajemen</p>
    </div>
    
    <div class="menu-section">
        <div class="menu-section-title">Data Master</div>
        <a href="dashboard.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">📊</span> Dashboard
        </a>
        <a href="form_pasien.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'form_pasien.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">👤</span> Data Pasien
        </a>
        <a href="form_dokter.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'form_dokter.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">👨‍⚕️</span> Data Dokter
        </a>
        <a href="form_poli.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'form_poli.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">🏥</span> Data Poli
        </a>
        <a href="listberobat.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'listberobat.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">💊</span> Berobat
        </a>
    </div>
    
    <div class="menu-section">
        <div class="menu-section-title">Laporan</div>
        <a href="list_dokter.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'list_dokter.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">📋</span> List Dokter
        </a>
        <a href="list_pasien.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'list_pasien.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">📋</span> List Pasien
        </a>
        <a href="list_data_berobat.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'list_data_berobat.php' ? 'active' : ''; ?>">
            <span class="menu-item-icon">📋</span> List Data Berobat
        </a>
    </div>
</div>
