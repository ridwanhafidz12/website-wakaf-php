-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2024 at 06:47 PM
-- Server version: 10.2.44-MariaDB-cll-lve
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkbk5879_db_ziswaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemasukan`
--

INSERT INTO `pemasukan` (`id`, `user_id`, `jumlah`, `bulan`, `program_id`) VALUES
(65, 'A001', 10000, '2024-08-09', 24),
(66, 'A005', 100000, '2024-08-07', 24),
(67, 'A006', 1000000, '2024-08-09', 24),
(68, 'A007', 250000, '2024-08-09', 24),
(69, 'A008', 500000, '2024-08-09', 24),
(70, 'A009', 250000, '2024-08-09', 24),
(71, 'A006', 5100000, '2024-08-09', 24),
(72, 'A010', 100000, '2024-08-09', 25),
(73, 'A006', 750000, '2024-08-09', 25),
(74, 'A011', 500000, '2024-08-09', 25),
(75, 'A024', 100000, '2024-08-21', 26),
(76, 'A024', 500000, '2024-08-21', 26),
(77, 'A028', 350000, '2024-08-17', 26),
(78, 'A029', 50000, '2024-08-23', 26),
(79, 'A030', 150000, '2024-08-23', 26),
(80, 'A031', 50000, '2024-08-23', 26),
(81, 'A032', 300000, '2024-08-24', 26),
(82, 'A033', 100000, '2024-08-24', 26),
(83, 'A012', 1000000, '2024-08-09', 25),
(84, 'A013', 500000, '2024-08-09', 25),
(85, 'A014', 50000, '2024-08-09', 25),
(86, 'A015', 100000, '2024-08-09', 25),
(87, 'A016', 500000, '2024-08-12', 25),
(88, 'A017', 1000000, '2024-08-10', 25),
(89, 'A018', 4500000, '2024-08-10', 25),
(90, 'A019', 3000, '2024-08-14', 27),
(91, 'A020', 300000, '2024-08-15', 27),
(92, 'A021', 600000, '2024-08-16', 27),
(93, 'A022', 100000, '2024-08-16', 27),
(94, 'A023', 30000, '2024-08-16', 27),
(95, 'A024', 300000, '2024-08-16', 27),
(96, 'A025', 200000, '2024-08-16', 27),
(97, 'A026', 100000, '2024-08-16', 27),
(98, 'A001', 30000, '2024-08-16', 27),
(99, 'A034', 300000, '2024-08-27', 26),
(100, 'A035', 1000000, '2024-08-28', 26),
(101, 'A018', 1200000, '2024-08-30', 26),
(102, 'A036', 500000, '2024-08-30', 26),
(103, 'A037', 140000, '2024-08-30', 26),
(104, 'A039', 300000, '2024-08-30', 26),
(105, 'A040', 1000000, '2024-08-30', 26),
(106, 'A041', 5000000, '2024-09-01', 26),
(110, 'A042', 100000, '2024-09-01', 26),
(111, 'A057', 500000, '2024-09-06', 26),
(120, 'A058', 150000, '2024-09-06', 26),
(126, 'A001', 10000, '2024-09-06', 26),
(130, 'A060', 100000, '2024-09-08', 26),
(131, 'A061', 100000, '2024-09-13', 26),
(132, 'A002', 1500000, '2024-09-14', 27),
(133, 'A062', 1000000, '2024-09-16', 28),
(134, 'A065', 30000, '2024-09-28', 28),
(138, 'A069', 1500000, '2024-09-28', 28),
(139, 'A071', 1000000, '2024-09-29', 28),
(140, 'A072', 100000, '2024-10-04', 28),
(141, 'A024', 100000, '2024-10-04', 28),
(142, 'A073', 1000000, '2024-10-06', 28),
(143, 'A038', 2936000, '2024-10-14', 28);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `target_amount` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `program_name`, `target_amount`, `description`, `image`) VALUES
(24, 'Wakaf Genteng', 6500000, 'Wakaf Genteng Untuk Asrama Santri', 'uploads/WhatsApp Image 2024-08-09 at 16.07.51_8ec0949e.jpg'),
(25, 'Wakaf Herbel', 9000000, 'Wakaf Bata Ringan/Herbel Untuk Asrama Santri', 'uploads/WhatsApp Image 2024-08-10 at 14.12.00_ef0aab36.jpg'),
(26, 'Wakaf Lantai Keramik', 12000000, 'Program Wakaf Keramik Lantai untuk Asrama Pondok Azzakiyyah\r\n\r\nYuk wakaf, sepuluribuan jadi amal sholeh, jariyyah hingga akhir.\r\n\r\nBismillah, guna melengkapi pembangunan kelas & asrama, diperluankan keramik untuk lantai.  Dengan harga perkeramiknya sebesar Rp 10.000,-.  Total kebutuhan keramik sebanyak 1200 keramik. \r\n', 'uploads/WhatsApp Image 2024-08-21 at 14.20.11_d94d5e55.jpg'),
(27, 'Wakaf Kayu Reng', 3000000, 'Wakaf Kayu Reng Untuk Asrama Santri', 'uploads/971d2dc9-8350-44df-a6bd-376f92c9b5fa.jpeg'),
(28, 'Wakaf Conblock / Paving ', 13500000, 'Seribu Bisa Wakaf Conblock\r\nKebutuhan 13.500 biji\r\nPer biji 1000 Rupiah', 'uploads/IMG-20240913-WA0028.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `nama`) VALUES
(1, 'A001', 'Tn. Muhammad Ridwan Nuur Hafidz'),
(2, 'A002', 'Ust Tulus Prasetyo'),
(3, 'A003', 'Usth Isnaini Mangasiroh'),
(4, 'A004', 'Tn. Achmad Bagas Irawan'),
(5, 'A005', 'Ny. Fitria'),
(6, 'A006', 'Tn. Novi Sugiyanto'),
(7, 'A007', 'Ny. Roesmini'),
(8, 'A008', 'Ny. Sartika'),
(9, 'A009', 'Tn. Bagjan Suparjan'),
(10, 'A010', 'Tn. Seno Budiharjo'),
(11, 'A011', 'Tn. Maryanto'),
(12, 'A012', 'Tn. Indriana Wiijaya'),
(13, 'A013', 'Ny. Rita Sulistyawati'),
(14, 'A014', 'Ny. Henny Tri Pujiastuti'),
(15, 'A015', 'Ny. Diah Prihadi'),
(16, 'A016', 'Tn. Engkus Kusnadi'),
(17, 'A017', 'Tn. Heru Nuryono'),
(18, 'A018', 'Tn. Erlangga Maharesi'),
(19, 'A019', 'Tn. Mohammad Dafa Hayyan Mufida'),
(20, 'A020', 'Tn. Sugiyanto'),
(21, 'A021', 'Ny. Agustina Pancawati'),
(22, 'A022', 'Ny. Aisyah'),
(23, 'A023', 'Ny. Risna Hermina'),
(24, 'A024', 'Hamba Allah'),
(25, 'A025', 'Ny. Noviamy'),
(26, 'A026', 'Ny. Yuni Astuti'),
(27, 'A027', 'Ws. Nailul Widad'),
(28, 'A028', 'Ny. Atifah Khairina Muthmainnah'),
(29, 'A029', 'Tn. Riman dan Ny. Saroh'),
(30, 'A030', 'Tn. Jumali'),
(31, 'A031', 'Kel. Muh. Rifnanjar ( Sulawesi tengah )'),
(32, 'A032', 'Nasi liwet Bu darmi solo'),
(33, 'A033', 'Ny Ibu Ida'),
(34, 'A034', 'Tn. Ibnu mutaqin'),
(35, 'A035', 'Ny. Siti rohani'),
(36, 'A036', 'Tn. Muhammad Hofi'),
(37, 'A037', 'Hamba Allah '),
(38, 'A038', 'Ny. Nurul '),
(39, 'A039', 'Ny. Nurul '),
(40, 'A040', 'Tn. Hariyadi'),
(41, 'A041', 'Tn. Sugeng Rahayu'),
(56, 'A042', 'Ny. Marfuah '),
(57, 'A057', 'Ny. Lisnasari'),
(58, 'A058', 'Ny. Ajeng Ardine'),
(59, 'A059', 'Tn. Ahmad Sumuaji '),
(61, 'A061', 'Pengurus pesantren azzakiyyah '),
(62, 'A062', 'Mbah bagus dan Mbah sunarni'),
(65, 'A065', 'Ny. Ummu Qonita '),
(70, 'A069', 'Ny. Na\'imatun Shafiyyah Ghuraba'),
(71, 'A071', 'Tn. Imam mashuri'),
(72, 'A072', 'Tn. Asep Permana '),
(73, 'A073', 'Almh Yamangsi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemasukan_ibfk_1` (`program_id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD CONSTRAINT `pemasukan_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
