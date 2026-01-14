-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2026 at 07:13 AM
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
-- Database: `inventaris_bmn`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rak` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `box` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `baris` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `kode`, `tahun`, `nama`, `rak`, `box`, `baris`, `image`, `ruang_id`) VALUES
(32, 'dadad', 2016, 'saya', 'fafa1', 'fafa', 'afa1222', '', 10),
(33, 'ju000', 2016, 'saya', 'saya', 'aku', 'saya', '', 10),
(34, 'memberikan', 2017, 'kamera', '1', '1', '1', '1767961763_Screenshot 2025-12-24 093816.png', 11),
(35, 'memberikan', 2016, 'Menerapkan Prosedur  	Menerapkan Prosedur Kesehatan, Keselamatan dan Keamanan Kerja (K3', '11', '1', '1', '1768132181_command git.png', 10),
(36, 'memberikan', 2018, 'kamera', '1', '2', '2', NULL, 12),
(37, '11', 2016, 'humas', '1', '1', '12', '1768132205_Screenshot 2025-12-28 201415.png', 10),
(38, 'yoga1', 2016, 'muhammad yoga1', '111', '1271', '131', '', 10),
(39, '11', 2017, 'humas', '1', '3', '2', '', 11),
(40, 'saya', 2017, 'azril', '1', '2', '3', '1768184429_command git.png', 11),
(41, 'hk.000.11', 2016, 'kegiatan renang', '1', '2', '3', '1768195488_Screenshot 2025-12-24 093816.png', 10),
(42, '1', 2016, '123', '4', '5', '6', NULL, 10),
(43, 'kl20', 2016, 'komputer 112', '1', '2', '3', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` int NOT NULL,
  `nama_ruang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `nama_ruang`, `keterangan`) VALUES
(10, '2016', 'Ruang Arsip'),
(11, '2017', 'Ruang Arsip'),
(12, '2018', 'Ruang Arsip'),
(13, '2019', 'Ruang Arsip'),
(14, '2020', 'Ruang Arsip'),
(15, '2021', 'Ruang Arsip'),
(16, '2022', 'Ruang Arsip'),
(17, '2023', 'Ruang Arsip'),
(18, '2024', 'Ruang Arsip'),
(19, '2025', 'Ruang Arsip'),
(20, '2026', 'Ruang Arsip'),
(21, '2027', 'Gedung Rektorat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
