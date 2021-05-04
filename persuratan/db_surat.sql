-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2021 at 08:51 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `staf_pengolah`
--

CREATE TABLE `staf_pengolah` (
  `id_staf` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `lama_proses` int(11) NOT NULL,
  `kinerja` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staf_pengolah`
--

INSERT INTO `staf_pengolah` (`id_staf`, `nama`, `lama_proses`, `kinerja`) VALUES
(1, 'Staf 01', 7, 2),
(2, 'Staf 02', 2, 1),
(3, 'Staf 03', 8, 2),
(4, 'Staf 04', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `no_surat_keluar` int(11) NOT NULL,
  `tanggal_surat_keluar` date NOT NULL,
  `perihal_surat_keluar` varchar(50) NOT NULL,
  `no_agenda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`no_surat_keluar`, `tanggal_surat_keluar`, `perihal_surat_keluar`, `no_agenda`) VALUES
(1, '2021-05-30', 'Surat Pengantar', 2);

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `no_agenda` int(11) NOT NULL,
  `tangggal_agenda` date NOT NULL,
  `no_surat` varchar(20) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `asal_surat` varchar(50) NOT NULL,
  `perihal_surat` varchar(100) NOT NULL,
  `id_staf` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`no_agenda`, `tangggal_agenda`, `no_surat`, `tanggal_surat`, `asal_surat`, `perihal_surat`, `id_staf`) VALUES
(1, '2021-04-14', '4343', '2021-04-07', 'PT. Ayamaru', 'Permohonan Surat Pengantar', 2),
(2, '2021-04-25', '120/ABB', '2021-04-25', 'PT. Almasentra', 'Permohonan Surat Pengantar', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staf_pengolah`
--
ALTER TABLE `staf_pengolah`
  ADD PRIMARY KEY (`id_staf`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`no_surat_keluar`),
  ADD KEY `no_agenda` (`no_agenda`);

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`no_agenda`),
  ADD KEY `id_staf` (`id_staf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staf_pengolah`
--
ALTER TABLE `staf_pengolah`
  MODIFY `id_staf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `no_surat_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `no_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_ibfk_1` FOREIGN KEY (`no_agenda`) REFERENCES `surat_masuk` (`no_agenda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`id_staf`) REFERENCES `staf_pengolah` (`id_staf`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
