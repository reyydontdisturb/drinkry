-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2026 at 03:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drinkry`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `subtotal` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_produk`, `jumlah`, `subtotal`) VALUES
(1, 0, 1, 2, 10000),
(2, 1, 1, 2, 10000),
(3, 1, 2, 1, 7000),
(4, 2, 1, 2, 10000),
(5, 3, 3, 1, 10000),
(6, 3, 4, 2, 6000),
(7, 4, 2, 1, 7000),
(8, 4, 3, 2, 20000),
(9, 4, 4, 1, 3000),
(10, 5, 4, 2, 6000),
(11, 6, 1, 2, 10000),
(12, 6, 3, 3, 30000),
(13, 7, 1, 1, 5000),
(14, 7, 2, 2, 14000),
(15, 7, 3, 1, 10000),
(16, 7, 4, 5, 15000),
(17, 8, 1, 1, 5000),
(18, 8, 2, 2, 14000),
(19, 8, 3, 1, 10000),
(20, 8, 4, 5, 15000),
(21, 9, 1, 3, 15000),
(22, 9, 2, 2, 14000),
(23, 9, 4, 2, 6000),
(24, 10, 2, 1, 7000),
(25, 11, 1, 1, 5000),
(26, 11, 2, 1, 7000),
(27, 12, 1, 1, 5000),
(28, 12, 2, 1, 7000),
(29, 13, 1, 3, 15000),
(30, 13, 2, 2, 14000),
(31, 14, 1, 3, 15000),
(32, 14, 2, 1, 7000),
(33, 14, 3, 1, 10000),
(34, 15, 1, 3, 15000),
(35, 15, 2, 1, 7000),
(36, 15, 3, 1, 10000),
(37, 16, 1, 2, 10000),
(38, 16, 2, 3, 21000),
(39, 17, 1, 2, 10000),
(40, 17, 4, 3, 9000),
(41, 18, 1, 2, 10000),
(42, 18, 4, 3, 9000),
(43, 19, 1, 2, 10000),
(44, 19, 3, 1, 10000),
(45, 19, 4, 2, 6000),
(46, 20, 1, 2, 10000),
(47, 20, 3, 1, 10000),
(48, 20, 4, 2, 6000),
(49, 21, 3, 1, 10000),
(50, 21, 4, 1, 3000),
(51, 22, 1, 1, 5000),
(52, 22, 2, 1, 7000),
(53, 22, 3, 1, 10000),
(54, 22, 4, 1, 3000),
(55, 23, 1, 2, 10000),
(56, 23, 3, 2, 20000),
(57, 23, 7, 2, 24000),
(58, 24, 1, 2, 10000),
(59, 24, 4, 2, 6000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`) VALUES
(1, 'rey'),
(2, 'nanda'),
(3, 'rey'),
(4, 'rey'),
(5, 'nanda'),
(6, 'nanda'),
(7, 'nanda'),
(8, 'jaki'),
(9, 'jaki'),
(10, 'pais'),
(11, 'pais'),
(12, 'rey'),
(13, 'rey'),
(14, 'nanda'),
(15, 'nanda'),
(16, 'rey'),
(17, 'bebby'),
(18, 'bebby'),
(19, 'customers'),
(20, 'customers'),
(21, 'customers'),
(22, 'customers'),
(23, 'customers'),
(24, 'patir'),
(25, 'customers'),
(26, 'customers'),
(27, 'customers');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `harga` int(11) NOT NULL DEFAULT 0,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `gambar`, `harga`, `stok`) VALUES
(1, 'es teh', 'esteh.jpg', 5000, 76),
(2, 'es jeruk', 'esjeruk.jpg', 7000, 92),
(3, 'kopi susu', 'kopisusu.jpg', 10000, 92),
(4, 'air mineral', 'airmineral.jpg', 3000, 85),
(7, 'Matcha Latte', 'matcha.jpg', 12000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tanggal`, `total`) VALUES
(1, 4, '2026-09-02 13:44:32', 17000),
(2, 5, '2026-09-02 13:56:21', 10000),
(3, 6, '2026-09-02 13:57:07', 16000),
(4, 7, '2026-09-02 13:58:36', 30000),
(5, 8, '2026-09-02 13:58:56', 6000),
(6, 9, '2026-09-02 14:03:19', 40000),
(7, 10, '2026-09-02 14:30:49', 44000),
(8, 11, '2026-09-02 14:31:24', 44000),
(9, 12, '2026-09-02 14:35:28', 35000),
(10, 13, '2026-09-02 14:37:46', 7000),
(11, 14, '2026-09-02 14:46:13', 12000),
(12, 15, '2026-09-02 14:47:12', 12000),
(13, 16, '2026-09-02 15:07:23', 29000),
(14, 17, '2026-09-03 12:36:46', 32000),
(15, 18, '2026-09-03 12:37:18', 32000),
(16, 19, '2026-09-04 08:03:54', 31000),
(17, 20, '2026-09-04 09:30:14', 19000),
(18, 21, '2026-09-04 09:32:15', 19000),
(19, 22, '2026-09-06 22:27:23', 26000),
(20, 23, '2026-09-06 22:28:03', 26000),
(21, 24, '2026-09-07 10:38:49', 13000),
(22, 25, '2026-09-07 11:28:41', 25000),
(23, 26, '2026-09-23 09:00:16', 54000),
(24, 27, '2026-09-23 09:00:46', 16000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
