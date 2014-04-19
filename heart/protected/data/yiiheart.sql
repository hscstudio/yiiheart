-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2014 at 04:30 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yiiheart`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_religion`
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
-- Dumping data for table `ref_religion`
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
-- Table structure for table `tb_admin`
--

CREATE TABLE IF NOT EXISTS `tb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_employee_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_admin_tb_employee1` (`tb_employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `tb_employee_id`, `username`, `password`, `status`, `created`, `createdBy`, `modified`, `modifiedBy`, `deleted`, `deletedBy`) VALUES
(1, 1, 'admin', '$2a$13$byV6fF7bZGd5J6k80Rzulu37cyytQIN3HzaAJuJFaUFVOJeRPKtSG', 1, NULL, NULL, '2014-04-18 10:22:14', 1, NULL, 0),
(2, 1, 'coba', '$2a$13$vXVFGV67lUQYcqjxaSPulOwsCMKn3e8TJ62rl4f4DasX8cLdG7Bzi', 1, '2014-04-19 09:29:00', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_authassignment`
--

CREATE TABLE IF NOT EXISTS `tb_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_authassignment`
--

INSERT INTO `tb_authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `tb_authitem`
--

CREATE TABLE IF NOT EXISTS `tb_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_authitem`
--

INSERT INTO `tb_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, NULL, NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Guest', 2, NULL, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `tb_authitemchild`
--

CREATE TABLE IF NOT EXISTS `tb_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_employee`
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
  `address` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_employee_ref_religion1` (`ref_religion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_employee`
--

INSERT INTO `tb_employee` (`id`, `ref_religion_id`, `name`, `born`, `birthDay`, `gender`, `phone`, `email`, `address`, `photo`, `status`, `created`, `createdBy`, `modified`, `modifiedBy`, `deleted`, `deletedBy`) VALUES
(1, 1, 'Hafid Mukhlasin', 'Jember', '2014-04-11', 1, '081559915720', 'milisstudio@gmail.com', '', '', 1, NULL, NULL, '2014-04-19 10:39:18', 1, NULL, NULL),
(4, 0, 'Name', NULL, '2014-04-19', 1, NULL, NULL, NULL, '', 0, '2014-04-18 08:34:13', 1, '2014-04-19 10:00:34', 1, '2014-04-19 10:00:34', 1),
(5, 0, 'Hafid Mukhlasin', NULL, NULL, 1, NULL, NULL, NULL, '', 0, '2014-04-18 08:34:13', 1, '2014-04-19 10:00:45', 1, '2014-04-19 10:00:45', 1),
(6, 0, 'Halo', '', '0000-00-00', 1, '', '', '', '', 0, '2014-04-18 11:48:11', 1, '2014-04-19 10:00:49', 1, '2014-04-19 10:00:49', 1),
(7, 1, 'Peter', 'Jakarta', '2014-04-11', 1, 'yy', 'xxx@gmail.com', '1', '1', 1, '2014-04-19 09:49:39', 1, NULL, NULL, NULL, NULL),
(8, 1, 'Peter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2014-04-19 09:51:19', 1, '2014-04-19 10:00:39', 1, '2014-04-19 10:00:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_rights`
--

CREATE TABLE IF NOT EXISTS `tb_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_training`
--

CREATE TABLE IF NOT EXISTS `tb_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start` date DEFAULT NULL,
  `finish` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_training`
--

INSERT INTO `tb_training` (`id`, `name`, `start`, `finish`, `note`, `status`, `created`, `createdBy`, `modified`, `modifiedBy`, `deleted`, `deletedBy`) VALUES
(1, 'Diklat Intelejen Tingkat Dasar Angkatan I', '2014-04-21', '2014-04-25', '', 123456, '2014-04-18 14:33:44', 1, '2014-04-19 20:37:27', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_training_document`
--

CREATE TABLE IF NOT EXISTS `tb_training_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_training_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_training_document_tb_training1` (`tb_training_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_training_document`
--

INSERT INTO `tb_training_document` (`id`, `tb_training_id`, `name`, `filename`, `description`, `status`, `created`, `createdBy`, `modified`, `modifiedBy`, `deleted`, `deletedBy`) VALUES
(1, 1, 'Test', 'filename', '', 1, '2014-04-18 16:32:35', 1, '2014-04-18 16:48:16', 1, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_employee`
--
ALTER TABLE `tb_employee`
  ADD CONSTRAINT `tb_employee_ibfk_1` FOREIGN KEY (`ref_religion_id`) REFERENCES `ref_religion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_training_document`
--
ALTER TABLE `tb_training_document`
  ADD CONSTRAINT `tb_training_document_ibfk_1` FOREIGN KEY (`tb_training_id`) REFERENCES `tb_training` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
