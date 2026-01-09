-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 09, 2026 at 12:16 AM
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
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rak` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `baris` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `box` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `kode`, `nama`, `rak`, `baris`, `box`, `image`, `ruang_id`) VALUES
(5, 'BMN-213', 'Dokumen keaungan', '1', '1', '1', '1767699531_Dispplay Welcome.jpg', 0),
(10, '11', 'saya', '2', '2', 'hitam', '1767699371_Dispplay Welcome.jpg', NULL),
(15, '1j', 'Tas Mewah uya kuya dan istri', '1', '3', '3', '1767757231_command git.png', 10),
(16, '113', 'kamera', '2', '7', '1', '1767757901_Screenshot 2026-01-04 221333.png', 10),
(17, '3', 'obeng', '1', '2', '3', '1767767823_Screenshot 2025-12-24 093816.png', 10),
(18, '4', 'kabel LAN', '1', '2', '3', '1767767846_Screenshot 2025-12-28 201415.png', 10),
(19, '5', 'acces point zte', '1', '2', '3', '1767767881_Screenshot 2025-12-29 133434.png', 10),
(20, '6', 'router mikrotik', '1', '2', '3', '1767767901_Screenshot 2025-12-29 133441.png', 10),
(21, '7', 'mouse', '1', '2', '3', '1767767964_command git.png', 10),
(22, '8', 'keyborad', '1', '2', '3', '1767767987_command git.png', 10),
(23, '9', 'komputer', '1', '2', '3', '1767768202_Screenshot 2026-01-07 105033.png', 10),
(24, '10', 'kamera', '1', '2', '3', '1767771962_command git.png', 10);

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
(20, '2026', 'Ruang Arsip');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
