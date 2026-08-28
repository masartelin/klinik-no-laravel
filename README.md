# APLIKASI PENGELOLAAN KLINIK - Grok xAI

## Setup Tools & Cara Menjalankan

### 1. Tools yang dibutuhkan
- **Laragon** (direkomendasikan) atau **XAMPP**
- PHP 7.4+ / 8.x
- MySQL / MariaDB
- Browser modern

### 2. Setup Database
1. Buka **phpMyAdmin** (http://localhost/phpmyadmin)
2. Import file `database.sql`  
   atau jalankan query di dalamnya (CREATE DATABASE + tables + sample data)

### 3. Konfigurasi Koneksi
Edit file `koneksi.php` jika password MySQL berbeda:
```php
$pass = ""; // isi password MySQL Anda
```

### 4. Menjalankan Aplikasi
1. Letakkan folder project di:
   - Laragon: `C:\laragon\www\`
   - XAMPP: `C:\xampp\htdocs\`
2. Akses: `http://localhost/Paket-A---Soal-Praktik---Klinik-main/`
   (atau rename folder menjadi `klinik`)

### 5. Fitur sesuai Soal
| No | Fitur | Status |
|----|-------|--------|
| 1 | Menu Form (Data Pasien, Dokter, Poli, Berobat) | ✅ |
| 2 | Menu Laporan (List Dokter, List Pasien, List Data Berobat) | ✅ |
| 3 | Link Berobat → form listberobat | ✅ |
| 4 | Table Poli, Dokter, Pasien, Berobat + tipe data | ✅ |
| 5 | Sample data Poli, Dokter, Pasien | ✅ |
| 6 | File koneksi.php | ✅ |
| 7 | Form listberobat (Add New + tabel relasi) | ✅ |
| 8 | AddNewButton → form input berobat | ✅ |
| 9 | List dari relasi Berobat + Pasien + Poli + Dokter | ✅ |
| 10 | EditHyperLink → form Edit | ✅ |
| 11 | DelHyperlink → hapus record | ✅ |
| 12-19 | Form Input Berobat (No Transaksi free, Combo Pasien, Tanggal/Bulan/Tahun array, Combo Dokter, Submit → listberobat, Clear) | ✅ |
| 20-28 | Form Edit Berobat (pre-filled, update, redirect) | ✅ |
| 29 | Hapus record via Del | ✅ |

### Struktur File
```
├── index.php              → redirect ke dashboard
├── dashboard.php          → ringkasan
├── koneksi.php            → koneksi DB
├── database.sql           → schema + sample
├── sidebar.php / .css     → menu navigasi
├── form_pasien.php
├── form_dokter.php
├── form_poli.php
├── form_berobat.php       → Add + Edit berobat
├── listberobat.php        → list + delete
├── list_pasien.php
├── list_dokter.php
└── list_data_berobat.php
```

### Catatan
- Usia dihitung otomatis dari Tanggal_LahirPasien
- Biaya diformat Rupiah (titik pemisah ribuan)
- Tanggal form: Combo 1-31, Combo Januari-Desember (simpan 1-12), Textbox Tahun
