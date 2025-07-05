CREATE DATABASE IF NOT EXISTS pengumpulantugas;
USE pengumpulantugas;

-- Tabel Pengguna (Users)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Mata Praktikum
DROP TABLE IF EXISTS `mata_praktikum`;
CREATE TABLE `mata_praktikum` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_praktikum` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT
);

-- Tabel Modul
DROP TABLE IF EXISTS `modul`;
CREATE TABLE `modul` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_praktikum` INT NOT NULL,
    `nama_modul` VARCHAR(255) NOT NULL,
    `file_materi` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_praktikum`) REFERENCES `mata_praktikum`(`id`) ON DELETE CASCADE
);

-- Tabel Pendaftaran Praktikum
DROP TABLE IF EXISTS `pendaftaran_praktikum`;
CREATE TABLE `pendaftaran_praktikum` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_mahasiswa` INT NOT NULL,
    `id_praktikum` INT NOT NULL,
    `tanggal_daftar` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_mahasiswa`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_praktikum`) REFERENCES `mata_praktikum`(`id`) ON DELETE CASCADE,
    UNIQUE(`id_mahasiswa`, `id_praktikum`)
);

-- Tabel Pengumpulan Tugas
DROP TABLE IF EXISTS `pengumpulan_tugas`;
CREATE TABLE `pengumpulan_tugas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_modul` INT NOT NULL,
    `id_mahasiswa` INT NOT NULL,
    `file_laporan` VARCHAR(255) NOT NULL,
    `tanggal_kumpul` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `nilai` INT,
    `feedback` TEXT,
    FOREIGN KEY (`id_modul`) REFERENCES `modul`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_mahasiswa`) REFERENCES `users`(`id`) ON DELETE CASCADE
);