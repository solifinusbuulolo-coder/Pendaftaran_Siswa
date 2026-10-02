CREATE DATABASE IF NOT EXISTS db_siswa;
USE db_siswa;

-- 1. Buat Tabel Master Jurusan
CREATE TABLE IF NOT EXISTS tb_jurusan (
    id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(100) NOT NULL
);

-- 2. Isi Data Awal Jurusan
INSERT INTO tb_jurusan (nama_jurusan) VALUES 
('Rekayasa Perangkat Lunak'),
('Teknik Komputer & Jaringan'),
('Desain Komunikasi Visual');

-- 3. Hapus Tabel tb_siswa Lama (jika ingin memperbarui struktur secara bersih)
DROP TABLE IF EXISTS tb_siswa;

-- 4. Buat Ulang Tabel tb_siswa dengan kolom id_jurusan & foto
CREATE TABLE tb_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(10) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    id_jurusan INT NOT NULL,
    foto VARCHAR(255) NOT NULL,
    alasan TEXT NOT NULL,
    FOREIGN KEY (id_jurusan) REFERENCES tb_jurusan(id_jurusan) ON DELETE CASCADE
);
