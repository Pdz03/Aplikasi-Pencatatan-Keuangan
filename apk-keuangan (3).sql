-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 09:59 AM
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
-- Database: `apk-keuangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `dompet`
--

CREATE TABLE `dompet` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_dompet` varchar(128) NOT NULL,
  `jenis_dompet` varchar(128) NOT NULL,
  `saldo_awal` decimal(10,0) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `tipe` enum('pemasukan','pengeluaran') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_dompet`
--

CREATE TABLE `saldo_dompet` (
  `id` int(11) NOT NULL,
  `id_dompet` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `saldo_sekarang` decimal(12,2) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saldo_dompet`
--

INSERT INTO `saldo_dompet` (`id`, `id_dompet`, `id_user`, `saldo_sekarang`, `updated_at`) VALUES
(1, 5, 1, 7000000.00, '2025-12-22 03:58:59'),
(2, 4, 1, 5000000.00, '2025-12-31 03:10:16'),
(3, 6, 1, 3300000.00, '2025-12-22 04:07:48'),
(4, 9, 1, 300000.00, '2025-12-22 04:44:03'),
(5, 5, 20, 8000000.00, '2025-12-31 03:21:25'),
(6, 4, 20, 6000000.00, '2026-01-28 05:26:56'),
(7, 4, 22, 8000000.00, '2026-01-22 07:31:10'),
(8, 5, 22, 1000000.00, '2025-12-31 03:53:43'),
(9, 6, 20, 2000000.00, '2026-01-07 06:51:54'),
(10, 7, 20, 17000000.00, '2026-01-06 03:53:46'),
(11, 10, 20, 500000.00, '2026-01-06 03:57:19'),
(12, 11, 20, 0.00, '2026-01-07 02:33:46'),
(13, 7, 22, 20000000.00, '2026-01-12 02:09:25'),
(14, 6, 22, 10000000.00, '2026-01-12 02:10:29'),
(15, 12, 20, 4000000.00, '2026-01-22 07:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_dompet` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `tipe` enum('pemasukan','pengeluaran') NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_user`, `id_dompet`, `id_kategori`, `tipe`, `jumlah`, `tanggal`, `keterangan`, `created_at`) VALUES
(3, 20, 4, 0, '', 5000000.00, '2025-12-22', 'Saldo Awal', '2025-12-22 03:54:28'),
(5, 20, 6, 0, '', 100000.00, '2025-12-22', 'Saldo Awal', '2025-12-22 03:59:43'),
(6, 20, 6, 0, 'pemasukan', 200000.00, '2025-12-22', 'Saldo Awal', '2025-12-22 04:07:48'),
(7, 20, 4, 0, 'pengeluaran', 3000000.00, '2025-12-22', 'FOYA FOYA', '2025-12-22 04:12:41'),
(8, 20, 4, 0, 'pemasukan', 200000.00, '2025-12-22', 'Menabung', '2025-12-22 04:13:48'),
(9, 20, 4, 0, 'pengeluaran', 200000.00, '2025-12-22', 'Transfer ke rekening lain', '2025-12-22 04:39:13'),
(11, 20, 9, 0, 'pemasukan', 100000.00, '2025-12-22', 'Saldo Awal', '2025-12-22 04:44:03'),
(12, 20, 5, 0, 'pengeluaran', 200000.00, '2025-12-22', 'Transfer ke rekening lain', '2025-12-22 04:44:32'),
(13, 20, 9, 0, 'pemasukan', 200000.00, '2025-12-22', 'Terima transfer', '2025-12-22 04:44:32'),
(14, 20, 4, 0, 'pemasukan', 2000000.00, '2025-12-31', 'Saldo Awal', '2025-12-31 03:10:16'),
(15, 20, 5, 0, 'pemasukan', 9000000.00, '2025-12-31', 'Saldo Awal', '2025-12-31 03:21:25'),
(16, 20, 4, 0, 'pemasukan', 4000000.00, '2025-12-31', 'Saldo Awal', '2025-12-31 03:21:39'),
(17, 22, 4, 0, 'pemasukan', 10000000.00, '2025-12-31', 'Saldo Awal', '2025-12-31 03:27:05'),
(18, 22, 4, 0, 'pengeluaran', 2000000.00, '2025-12-31', 'Transfer ke rekening lain', '2025-12-31 03:52:52'),
(19, 22, 5, 0, 'pemasukan', 2000000.00, '2025-12-31', 'Terima transfer', '2025-12-31 03:52:52'),
(20, 22, 5, 0, 'pemasukan', 1000000.00, '2025-12-31', 'Saldo Awal', '2025-12-31 03:53:43'),
(21, 20, 5, 0, 'pengeluaran', 1000000.00, '2025-12-31', 'Transfer ke rekening lain', '2025-12-31 03:56:31'),
(22, 20, 4, 0, 'pemasukan', 1000000.00, '2025-12-31', 'Terima transfer', '2025-12-31 03:56:31'),
(23, 20, 4, 0, 'pengeluaran', 1000000.00, '2026-01-05', 'Transfer ke rekening lain', '2026-01-05 02:19:16'),
(24, 20, 6, 0, 'pemasukan', 1000000.00, '2026-01-05', 'Terima transfer', '2026-01-05 02:19:16'),
(25, 20, 6, 0, 'pemasukan', 1000000.00, '2026-01-05', 'Saldo Awal', '2026-01-05 02:36:17'),
(26, 20, 5, 0, 'pengeluaran', 2000000.00, '2026-01-05', 'Transfer ke rekening lain', '2026-01-05 02:36:52'),
(27, 20, 6, 0, 'pemasukan', 2000000.00, '2026-01-05', 'Terima transfer', '2026-01-05 02:36:52'),
(28, 20, 7, 0, 'pemasukan', 17000000.00, '2026-01-06', 'Saldo Awal', '2026-01-06 03:53:46'),
(29, 20, 10, 0, 'pemasukan', 500000.00, '2026-01-06', 'Saldo Awal', '2026-01-06 03:57:19'),
(30, 20, 11, 0, 'pemasukan', 20.00, '2026-01-06', 'Saldo Awal', '2026-01-06 04:00:34'),
(31, 20, 4, 0, 'pemasukan', 2000000.00, '2026-01-06', 'Menabung', '2026-01-06 04:09:18'),
(32, 20, 4, 0, 'pengeluaran', 1000000.00, '2026-01-06', 'Makan Siang ', '2026-01-06 04:10:24'),
(33, 20, 11, 0, 'pengeluaran', 20.00, '2026-01-07', 'FOYA FOYA', '2026-01-07 02:33:46'),
(34, 20, 6, 0, 'pengeluaran', 1000000.00, '2026-01-07', 'Dinner', '2026-01-07 06:51:54'),
(35, 22, 7, 0, 'pemasukan', 20000000.00, '2026-01-12', 'Saldo Awal', '2026-01-12 02:09:25'),
(36, 22, 6, 0, 'pemasukan', 10000000.00, '2026-01-12', 'Saldo Awal', '2026-01-12 02:10:29'),
(37, 20, 12, 0, 'pemasukan', 4000000.00, '2026-01-22', 'Saldo Awal', '2026-01-22 07:05:21'),
(38, 22, 4, 0, 'pengeluaran', 1000000.00, '2026-01-22', 'Belanja', '2026-01-22 07:31:10'),
(39, 20, 4, 0, 'pemasukan', 1000000.00, '2026-01-28', 'top up ', '2026-01-28 05:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `no_wa` varchar(128) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'default.png',
  `password` varchar(128) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `no_wa`, `foto`, `password`, `is_verified`, `otp`, `created_at`, `id_role`) VALUES
(1, 'ifut padang', 'ifut', '62882008439545', 'avatar4.png', '$2y$10$IOQN8Z0BPTt45jnBZ6ksAOmfq6b1uWtc9JIQLikbt5Zar69MLWdqS', 1, '', '2025-12-16 01:38:42', 2),
(2, 'ifut malang', 'ifut', '62882008439545', 'avatar4.png', '$2y$10$Z6JdsJHpWPIxJ4vmSa9h1O6NucP.s85ZITyaNEet4dW1NxPsOUTnS', 1, '', '2025-12-16 01:45:58', 2),
(8, 'tuif berhasil', 'tuif', '62882008439545', 'avatar4.png', '$2y$10$oXUTX5RJT3w4dnUA26cZE.f5FJKaK3U4.tkHQXaQhfwEVkyeYiuJu', 1, '', '2025-12-16 02:29:18', 2),
(17, 'tuif magetan', 'tuiff', '62882008439545', 'profile-1767764739.jpg', '$2y$10$5gPY8jrliRz.exUHiBIEB.ndIX95Mbc.3rhqcJMkQ41QmXIrfNHxS', 1, '', '2025-12-16 07:17:10', 1),
(18, 'aifut sumberjo', 'aifutt', '62882008439545', 'avatar4.png', '$2y$10$whykX7t7fgBVATDAhnX5peKdEGSSEtF/WKQanf5.MHE6Yz7VzUT.O', 1, '', '2025-12-18 02:35:15', 2),
(20, 'fufut rt kulon', 'fufut', '62882008439545', 'profile-1767836476.jpg', '$2y$10$e6Vbp1..0f7aLbXMqrdPXu/D8w.u2LByTFOhyHw5uRbTaCiVs2vBy', 1, '', '2025-12-22 01:28:06', 2),
(21, 'sumbul', 'sumbul', '62882008439545', 'avatar4.png', '$2y$10$FI1FJ9nsiAMEBtrWQxeqQ.S8W8ANleLrjuG25tqAj/o3g1PoWFfaW', 1, '', '2025-12-29 02:28:40', 2),
(22, 'kidir karawita', 'kidir', '62882008439545', 'avatar4.png', '$2y$10$6JcYmnbSflvAvnQ7sa3u1.DT2HJvSD08YipsrNrkgQuhzqIw5qGiy', 1, '', '2025-12-29 02:33:46', 2),
(27, 'fina garut', 'fina ', '62882008439545', 'default.png', '$2y$10$LHRCtFFP7Zz3Lz.PeMsNLeaxyUlNZNb8mTbkVa0Z6svh7usDAAxry', 0, '828091', '2026-01-27 03:33:50', 2),
(31, 'sore', 'siang ', '62882008439545', 'default.png', '$2y$10$BxDC8DrLe3A5UmX53l/HAuJj8aguZBcr6XWpFp426SKtYMGYi4BGC', 1, '', '2026-01-27 04:27:49', 2),
(32, 'dinda', 'dinda', '62882008439545', 'default.png', '$2y$10$4vvHU8zXWgUzzyZN4Lnmn.7h3e2cFHf.txWXK1Hqxbqs0P7duD9ca', 1, '', '2026-01-27 09:14:26', 2),
(33, 'bambing', 'bambang', '62882008439545', 'default.png', '$2y$10$bv0Sc1Q4G8w.WblwhXhF0eqlfOdEvotsbjMBb.GFUTlIO3HEFd/sK', 0, '555027', '2026-01-28 01:00:13', 2),
(34, 'budi', 'bimbang ', '62882008439545', 'default.png', '$2y$10$bQmbH/E4bEYSgAN2hmSUAOAGXAuttCtMgn2YiL9PpHXFrevlj8glO', 0, '819343', '2026-01-28 01:15:38', 2),
(35, 'dudung', 'dudung', '62882008439545', 'default.png', '$2y$10$4xwCL9r6Jpm7DJlnYbxyreQBgC6qAKU0MSr.n3rfpkC7jy2bzNUuK', 1, '', '2026-01-28 03:37:45', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `id_role`, `id_menu`) VALUES
(1, 1, 1),
(3, 2, 2),
(5, 1, 3),
(8, 2, 5),
(9, 2, 6),
(10, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(5, 'Laporan'),
(6, 'Master Dompet'),
(7, 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL,
  `parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `id_menu`, `id_user`, `title`, `url`, `icon`, `is_active`, `parent_id`) VALUES
(1, 5, 1, 'Statement', 'dashboard', 'fas fa-home', 1, 0),
(2, 1, 1, 'Role', 'admin/role', 'fas fa-user-shield', 1, 0),
(3, 6, 1, 'Rekening Bank', '#', 'fas fa-university', 1, 0),
(4, 6, 1, 'BCA', 'bank/bca', 'far fa-circle', 1, 3),
(5, 6, 1, 'BRI', 'bank/bri', 'far fa-circle', 1, 3),
(6, 6, 1, 'BNI', 'bank/bni', 'far fa-circle', 1, 3),
(7, 6, 1, 'Mandiri', 'bank/mandiri', 'far fa-circle', 1, 3),
(8, 6, 1, 'E-Wallet', '#', 'fas fa-wallet', 1, 0),
(9, 6, 1, 'Dana', 'wallet/dana', 'far fa-circle', 1, 8),
(10, 6, 1, 'OVO', 'wallet/ovo', 'far fa-circle', 1, 8),
(11, 6, 1, 'GoPay', 'wallet/gopay', 'far fa-circle', 1, 8),
(12, 6, 1, 'ShopeePay', 'wallet/shopeepay', 'far fa-circle', 1, 8),
(13, 1, 1, 'Dashboard', 'admin', 'fas fa-house-user', 1, 0),
(14, 3, 1, 'Menu Management', 'menu', 'fas fa-folder-open', 1, 0),
(15, 3, 1, 'Submenu Management', 'menu/submenu', 'fas fa-clipboard-list', 1, 0),
(16, 2, NULL, 'My Profile', 'user/profile', 'fas fa-user', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dompet`
--
ALTER TABLE `dompet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_dompet`
--
ALTER TABLE `saldo_dompet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
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
-- AUTO_INCREMENT for table `dompet`
--
ALTER TABLE `dompet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saldo_dompet`
--
ALTER TABLE `saldo_dompet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
