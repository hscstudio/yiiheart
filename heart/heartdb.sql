-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14 Mei 2014 pada 10.49
-- Versi Server: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `heartdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_religion`
--

CREATE TABLE IF NOT EXISTS `ref_religion` (
  `id` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_religion`
--

INSERT INTO `ref_religion` (`id`, `name`, `status`, `created`, `createdBy`, `modified`, `modifiedBy`, `deleted`, `deletedBy`) VALUES
(0, '-', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'Islam', 1, '2014-04-18 13:31:10', 1, NULL, NULL, NULL, NULL),
(2, 'Kristen Katolik', 1, '2014-04-18 13:31:10', 1, NULL, NULL, NULL, NULL),
(3, 'Kristen Protestan', 1, '2014-04-18 13:31:10', 1, NULL, NULL, NULL, NULL),
(4, 'Hindu', 1, '2014-04-18 13:31:10', 1, NULL, NULL, NULL, NULL),
(5, 'Budha', 1, '2014-04-18 13:31:10', 1, NULL, NULL, NULL, NULL),
(6, 'Konghucu', 1, '2014-04-18 13:31:10', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_employee`
--

CREATE TABLE IF NOT EXISTS `tb_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_religion_id` int(3) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `born` varchar(50) DEFAULT NULL,
  `birthDay` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT '1',
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text,
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_employee_ref_religion1` (`ref_religion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_training`
--

CREATE TABLE IF NOT EXISTS `tb_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start` date DEFAULT NULL,
  `finish` date DEFAULT NULL,
  `note` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_employee`
--
ALTER TABLE `tb_employee`
  ADD CONSTRAINT `tb_employee_ibfk_1` FOREIGN KEY (`ref_religion_id`) REFERENCES `ref_religion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
