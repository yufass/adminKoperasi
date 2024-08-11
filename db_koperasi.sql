-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 08:27 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` int(11) NOT NULL,
  `no_pinjaman` varchar(7) NOT NULL,
  `username` varchar(50) NOT NULL,
  `angsuran` int(3) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `bayar` int(10) NOT NULL,
  `sisa` int(10) NOT NULL,
  `denda` int(10) DEFAULT NULL,
  `jumlah` int(10) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `no_pinjaman` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pinjaman_pokok` int(10) NOT NULL,
  `bunga` int(11) NOT NULL,
  `tgl_pinjaman` date DEFAULT NULL,
  `jangka_waktu` int(11) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `angsuran` int(10) NOT NULL,
  `keterangan` int(1) NOT NULL DEFAULT 1,
  `status` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `no_simpanan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tgl_simpanan` date NOT NULL,
  `simpanan` int(11) DEFAULT NULL,
  `jenis_simpanan` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`no_simpanan`, `username`, `tgl_simpanan`, `simpanan`, `jenis_simpanan`, `status`) VALUES
(1001, 'gia', '2024-06-30', 2000000, 'Simpanan Pokok', 2),
(1002, 'user', '2024-07-03', 2000000, 'Simpanan Pokok', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 1,
  `aktif` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `nama_lengkap`, `level`, `aktif`) VALUES
('admin', '$2y$10$Dv.ntxdlWFkwI3rANQ.JX.c25wtCAtCRNp8VfQsAyHHyVfq.cHfFK', 'Gia Bueno', 2, 2),
('user', '$2y$10$F3.u3OX92ZOzKNKN8DFLw.wgujz5.jpVHrM3TLRhgy4MBufl6j1xi', 'Aryo', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `username` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(11) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `profil` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`username`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_hp`, `profil`) VALUES
('admin', 'Gia Bueno', 'Bogor', '2004-05-16', 'Laki - Laki', 'Bogor', '083147797580', '252311.png'),
('user', 'Aryo', 'Bogor', '2004-09-24', 'Laki - Laki', 'Bogorr', '081212121212', 'hwang-yeji.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 1, 1),
(4, 2, 3),
(5, 2, 4),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 1, 3),
(10, 1, 5),
(11, 1, 6),
(12, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `icon`) VALUES
(1, 'Dashboard', 'flaticon-025-dashboard'),
(2, 'Pengguna', 'flaticon-381-user-9'),
(3, 'Pinjaman', 'flaticon-381-add-3'),
(4, 'Simpanan', 'flaticon-381-add-1'),
(5, 'Simpanan', 'flaticon-381-add-1'),
(6, 'Laporan', 'flaticon-072-printer'),
(7, 'Simulasi Pinjaman', 'flaticon-381-calculator-1');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`) VALUES
(1, 1, 'Dashboard', 'admin'),
(2, 3, 'Data Pinjaman', 'pinjaman'),
(3, 3, 'Tagihan Pinjaman', 'pinjaman/tagihan'),
(4, 4, 'Data Simpanan', 'simpanan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`no_pinjaman`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`no_simpanan`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angsuran`
--
ALTER TABLE `angsuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `no_pinjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `simpanan`
--
ALTER TABLE `simpanan`
  MODIFY `no_simpanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
