-- Jalankan di phpMyAdmin > tab SQL (halaman utama, tanpa memilih database)
-- Script ini membuat ulang db_restoran dari nol.

DROP DATABASE IF EXISTS `db_restoran`;
CREATE DATABASE `db_restoran`;

USE `db_restoran`;

CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier`    INT AUTO_INCREMENT PRIMARY KEY,
  `nama_supplier`  VARCHAR(100) NOT NULL,
  `jenis_pasokan`  ENUM('Segar','Kering') NOT NULL,
  `barang_pasokan` VARCHAR(150) NOT NULL,
  `alamat_toko`    TEXT NOT NULL,
  `no_telepon`     VARCHAR(20) NOT NULL
);

INSERT INTO `supplier` (`nama_supplier`, `jenis_pasokan`, `barang_pasokan`, `alamat_toko`, `no_telepon`) VALUES
('CV Sumber Segar', 'Segar',  'Sayuran, daging',  'Jl. Pasar Baru No. 12, Bandung', '081234567890'),
('UD Berkah Tani',  'Kering', 'Beras, tepung',    'Jl. Raya Soreang No. 5, Bandung', '082198765432');

CREATE TABLE IF NOT EXISTS `user` (
  `id_user`  INT AUTO_INCREMENT PRIMARY KEY,
  `nama`     VARCHAR(100) NOT NULL,
  `username` VARCHAR(50)  NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role`     ENUM('admin','petugas') NOT NULL
);

-- Password: admin123 dan petugas123 (sudah di-hash dengan password_hash)
INSERT INTO `user` (`nama`, `username`, `password`, `role`) VALUES
('Muhammad Azis', 'admin',   '$2y$10$sNZg6yiEtl398XosVnNJaeE5AKunqYZMr3HxGOYTY.Q6hhW9rdQLi', 'admin'),
('Budi Petugas',  'petugas', '$2y$10$Nun3CYcy7aXclE1Hgjz5r.GvdDbltHqWoNUgdjEagWu7AtpK0gJZS', 'petugas');
