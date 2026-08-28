CREATE DATABASE IF NOT EXISTS klinik;
USE klinik;

-- Table Poli
CREATE TABLE Poli (
    Poli_ID VARCHAR(10) PRIMARY KEY,
    Nama_Poli VARCHAR(50) NOT NULL
);

-- Table Dokter
CREATE TABLE Dokter (
    Dokter_ID VARCHAR(10) PRIMARY KEY,
    Nama_Dokter VARCHAR(100) NOT NULL,
    Poli_ID VARCHAR(10),
    FOREIGN KEY (Poli_ID) REFERENCES Poli(Poli_ID)
);

-- Table Pasien
CREATE TABLE Pasien (
    PasienKlinik_ID VARCHAR(10) PRIMARY KEY,
    Nama_PasienKlinik VARCHAR(100) NOT NULL,
    Tanggal_LahirPasien DATE NOT NULL,
    Jenis_KelaminPasien VARCHAR(20) NOT NULL,
    Alamat_Pasien TEXT
);

-- Table Berobat
CREATE TABLE Berobat (
    No_Transaksi VARCHAR(10) PRIMARY KEY,
    PasienKlinik_ID VARCHAR(10),
    Tanggal_Berobat DATE NOT NULL,
    Dokter_ID VARCHAR(10),
    Keluhan_Pasien TEXT,
    Biaya_Adm DECIMAL(15, 0),
    FOREIGN KEY (PasienKlinik_ID) REFERENCES Pasien(PasienKlinik_ID),
    FOREIGN KEY (Dokter_ID) REFERENCES Dokter(Dokter_ID)
);

-- Insert sample data for Poli
INSERT INTO Poli (Poli_ID, Nama_Poli) VALUES
('PL001', 'Gigi'),
('PL002', 'Umum'),
('PL003', 'THT'),
('PL004', 'Mata'),
('PL005', 'Anak');

-- Insert sample data for Dokter
INSERT INTO Dokter (Dokter_ID, Nama_Dokter, Poli_ID) VALUES
('DR001', 'dr. Ratna', 'PL001'),
('DR002', 'dr. Rudy', 'PL002'),
('DR003', 'dr. Joko', 'PL003'),
('DR004', 'dr. Siti', 'PL004'),
('DR005', 'dr. Budi', 'PL005');

-- Insert sample data for Pasien
INSERT INTO Pasien (PasienKlinik_ID, Nama_PasienKlinik, Tanggal_LahirPasien, Jenis_KelaminPasien, Alamat_Pasien) VALUES
('PS001', 'Barata Yuda', '1972-07-29', 'Laki-Laki', 'Jl. Merdeka No. 10'),
('PS002', 'Indah Susanti', '2000-08-15', 'Perempuan', 'Jl. Sudirman No. 25'),
('PS003', 'Kurniawan', '2007-08-19', 'Laki-Laki', 'Jl. Gatot Subroto No. 5'),
('PS004', 'Siti Aminah', '1985-03-12', 'Perempuan', 'Jl. Ahmad Yani No. 15'),
('PS005', 'Budi Santoso', '1990-05-20', 'Laki-Laki', 'Jl. Diponegoro No. 30');

-- Insert sample data for Berobat
INSERT INTO Berobat (No_Transaksi, PasienKlinik_ID, Tanggal_Berobat, Dokter_ID, Keluhan_Pasien, Biaya_Adm) VALUES
('TR001', 'PS001', '2017-07-29', 'DR001', 'Sakit Gigi', 125000),
('TR002', 'PS002', '2017-08-15', 'DR002', 'Demam', 75000),
('TR003', 'PS003', '2017-08-19', 'DR003', 'Telinga', 90000);
