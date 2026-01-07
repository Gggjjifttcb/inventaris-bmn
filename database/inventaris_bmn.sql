-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 06, 2026 at 01:25 PM
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
(6, '213', 'laptop asusu 12', '1', 'dda', 'da', NULL, 2),
(7, '214', 'dmlaa', '0', 'fs', 'dad', '1767704033_Screenshot 2025-12-28 201415.png', 2),
(10, '11', 'saya', '2', '2', 'hitam', '1767699371_Dispplay Welcome.jpg', NULL),
(12, '11', 'tas', '1', '2', 'hh', '1767702562_Screenshot 2025-12-28 201428.png', 7),
(13, 'memberikan', 'memberikan', 'kuning', 'dua', 'hitam', '1767702520_Screenshot 2026-01-04 221333.png', 7),
(14, 'memberikan', 'kamera', '2', '2', '1', '1767705119_Screenshot 2025-12-29 133454.png', 5);

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
(1, ' KEUANGAN', 'Gedung Rektorat'),
(2, 'TIK', 'Gedung Rektorat'),
(3, 'SPM', 'Gedung Rektorat'),
(4, 'UNIT BAHASA', 'Gedung Rektorat'),
(5, 'ENGINERING', 'Gedung Rektorat'),
(6, 'KLINIK', 'Gedung Rektorat'),
(7, 'HUMAS', 'Gedung Rektorat'),
(8, 'ADUM', 'Gedung Rektorat'),
(9, 'ADAK', 'Gedung Rektorat');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
