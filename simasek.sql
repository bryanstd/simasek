-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2025 at 05:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simasek`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_terakhir`
--

CREATE TABLE `aktivitas_terakhir` (
  `id` int NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `aktivitas_terakhir`
--

INSERT INTO `aktivitas_terakhir` (`id`, `action`) VALUES
(5, 'Siswa dihapus: 17'),
(6, 'Siswa dihapus: Dedi Kurniawan'),
(7, 'Siswa baru ditambahkan: NIS 1250, Nama: fawijfoawj'),
(8, 'Siswa baru ditambahkan: fffffffffafaw'),
(9, 'Siswa dihapus: fffffffffafaw'),
(10, 'Siswa dihapus: fawijfoawj'),
(11, 'Data siswa diperbarui: Ayu Lestari'),
(12, 'Data siswa diperbarui: Sinta Rahay'),
(13, 'Siswa baru ditambahkan, Marvel'),
(14, 'Siswa dihapus: Marvel');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `role` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nis` decimal(8,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `email`, `password`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `nis`) VALUES
(1, 'admin', 'bryan@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Bryan Geraldo Lim', 'Pontianak', '1998-04-03', 'Jl. Menteng, Jakarta Pusat', '1234'),
(2, 'siswa', 'oliver@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Oliver Marvel Jonathan', 'Pontianak', '1998-04-03', 'Jl. Sudirman No.43', '1235'),
(3, 'siswa', 'nathan@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Nathan Pratama', 'Pontianak', '2006-02-14', 'Jl. Melati No.12, Pontianak', '1236'),
(4, 'siswa', 'amira@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Amira Salsabila', 'Pontianak', '2007-06-21', 'Kompleks Permata Indah Blok B/3', '1237'),
(5, 'siswa', 'rizky@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Rizky Hidayat', 'Singkawang', '2006-11-02', 'Perumahan Merdeka No.5', '1238'),
(6, 'siswa', 'putri@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Putri Anindya', 'Pontianak', '2007-03-30', 'Jl. Khatulistiwa Raya 45', '1239'),
(7, 'siswa', 'adit@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Adit Saputra', 'Pontianak', '2005-09-17', 'Gg. Mawar RT 02 RW 05', '1240'),
(8, 'siswa', 'dina@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Dina Wulandari', 'Sintang', '2006-12-05', 'Jl. A. Yani No.77', '1241'),
(9, 'siswa', 'fauzan@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Fauzan Nur', 'Pontianak', '2007-08-09', 'Perum. Graha Mas Blok C/2', '1242'),
(10, 'siswa', 'lina@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Lina Kartika', 'Kubu Raya', '2006-04-28', 'Jl. Sutan Syahrir 10', '1243'),
(11, 'siswa', 'arif@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Arif Maulana', 'Pontianak', '2005-01-11', 'Komplek Bumi Indah No.9', '1244'),
(12, 'siswa', 'maya@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Maya Putri', 'Mempawah', '2007-07-06', 'Jl. Merdeka 88', '1245'),
(13, 'siswa', 'ilham@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Ilham Prasetyo', 'Pontianak', '2006-10-23', 'Gg. Melur No.4', '1246'),
(14, 'siswa', 'sinta@simasek.edu', '0cc175b9c0f1b6a831c399e269772661', 'Sinta Rahay', 'Pontianak', '2007-05-14', 'Perum. Bumi Lestari 12', '1247'),
(16, 'siswa', 'ayu@simasek.edu', '$2y$10$P0Cf.YYWkQoVc8R.aFF3Ze/rEwrDwrDjEN5UB/wn5m71cJuqTzREq', 'Ayu Lestari', 'Pontianak', '2005-12-30', 'Kompleks Graha Permata No.6', '1249');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_terakhir`
--
ALTER TABLE `aktivitas_terakhir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_terakhir`
--
ALTER TABLE `aktivitas_terakhir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
