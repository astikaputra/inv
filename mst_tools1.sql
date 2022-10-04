-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2015 at 04:51 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mst_tools`
--

-- --------------------------------------------------------

--
-- Table structure for table `inv_assign`
--

CREATE TABLE IF NOT EXISTS `inv_assign` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `inv_id` int(11) DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`assign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `inv_assign`
--

INSERT INTO `inv_assign` (`assign_id`, `map_id`, `inv_id`, `seq`) VALUES
(31, 30, 2, 1),
(33, 29, 2, 1),
(34, 29, 4, 0),
(35, 30, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inv_category`
--

CREATE TABLE IF NOT EXISTS `inv_category` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `inv_category`
--

INSERT INTO `inv_category` (`id_cat`, `cat_name`) VALUES
(1, 'Computer'),
(2, 'Printer'),
(3, 'Aksesoris'),
(4, 'Ip Phone');

-- --------------------------------------------------------

--
-- Table structure for table `inv_items`
--

CREATE TABLE IF NOT EXISTS `inv_items` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_code` char(50) DEFAULT NULL,
  `id_cat` int(11) DEFAULT NULL,
  `inv_name` varchar(50) DEFAULT NULL,
  `sn` varchar(50) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `inv_status` int(2) DEFAULT '1',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `inv_items`
--

INSERT INTO `inv_items` (`inv_id`, `inv_code`, `id_cat`, `inv_name`, `sn`, `note`, `inv_status`) VALUES
(1, '12', 1, 'test', 'sdasd', 'asd', 1),
(2, 'DP-1F-ICT-02', 1, 'DP-1F-ICT-02', '1234455', 'Spek 2', 1),
(3, 'DP-1F-ICT-03', 1, 'DP-1F-ICT-03', '12345', 'test', 1),
(4, '25502', 4, '25502', '12345', 'tes', 1),
(5, 'DP-1F-MTY-01', 1, 'DP-1F-MTY-01', '12345678', 'test 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_locations`
--

CREATE TABLE IF NOT EXISTS `inv_locations` (
  `id_loc` int(11) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(50) DEFAULT NULL,
  `floor` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_loc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `inv_locations`
--

INSERT INTO `inv_locations` (`id_loc`, `loc_name`, `floor`) VALUES
(1, 'Control Room', 3),
(2, 'Paediatric', 3),
(3, 'Maternity Nurse', 3);

-- --------------------------------------------------------

--
-- Table structure for table `inv_mapping`
--

CREATE TABLE IF NOT EXISTS `inv_mapping` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT,
  `map_code` varchar(30) DEFAULT NULL,
  `map_name` varchar(50) DEFAULT NULL,
  `inv_id` int(11) DEFAULT NULL,
  `seq` int(11) DEFAULT NULL,
  PRIMARY KEY (`map_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `inv_mapping`
--

INSERT INTO `inv_mapping` (`map_id`, `map_code`, `map_name`, `inv_id`, `seq`) VALUES
(29, 'Mty', 'Maternity', NULL, NULL),
(30, 'Control Room', 'Control Room', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_database_connection`
--

CREATE TABLE IF NOT EXISTS `mst_database_connection` (
  `connection_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` varchar(50) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `database_name` varchar(50) DEFAULT NULL,
  `database_type` varchar(50) DEFAULT NULL COMMENT 'Uat or Production',
  PRIMARY KEY (`connection_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

--
-- Dumping data for table `mst_database_connection`
--

INSERT INTO `mst_database_connection` (`connection_id`, `hospital_id`, `ip_address`, `username`, `password`, `database_name`, `database_type`) VALUES
(10, 'SHDP', '10.83.129.37', 'root', '51l04m', 'mst_tools', 'Production');

-- --------------------------------------------------------

--
-- Table structure for table `mst_hospital`
--

CREATE TABLE IF NOT EXISTS `mst_hospital` (
  `hospital_id` varchar(10) NOT NULL COMMENT 'SHTS',
  `real_hospital_name` varchar(50) DEFAULT NULL,
  `hospital_address` tinytext,
  `employee_payer_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`hospital_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_hospital`
--

INSERT INTO `mst_hospital` (`hospital_id`, `real_hospital_name`, `hospital_address`, `employee_payer_id`) VALUES
('SHDP', 'INVENTORY MANAGEMENT TOOLS', 'JL. SUNSET ROAD NO. 818 KUTA, BADUNG, BALI  PHONE: +62 361 779900 FAX : 361 779933', 697);

-- --------------------------------------------------------

--
-- Table structure for table `mst_logs`
--

CREATE TABLE IF NOT EXISTS `mst_logs` (
  `logs_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `modul_id` int(10) DEFAULT '0',
  `requested_by` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102515 ;

--
-- Dumping data for table `mst_logs`
--

INSERT INTO `mst_logs` (`logs_id`, `user_id`, `modul_id`, `requested_by`, `timestamp`) VALUES
(102428, 1, 3, 'self ::1', '2015-01-07 11:34:11'),
(102429, 58, 2, 'astika from IP ::1', '2015-01-07 11:34:19'),
(102430, 1, 2, 'tri.ismardiko from IP ::1', '2015-01-07 11:39:24'),
(102431, 1, 3, 'self ::1', '2015-01-07 11:43:19'),
(102432, 58, 2, 'astika from IP ::1', '2015-01-07 11:43:30'),
(102433, 1, 2, 'tri.ismardiko from IP ::1', '2015-01-07 11:43:49'),
(102434, 1, 2, 'tri.ismardiko from IP ::1', '2015-01-07 11:50:35'),
(102435, 58, 2, 'astika from IP ::1', '2015-01-07 11:51:56'),
(102436, 58, 2, 'astika from IP ::1', '2015-01-07 11:53:13'),
(102437, 58, 2, 'astika from IP ::1', '2015-01-07 11:54:39'),
(102438, 58, 3, 'self ::1', '2015-01-07 12:27:36'),
(102439, 58, 2, 'astika from IP ::1', '2015-01-07 12:30:58'),
(102440, 58, 3, 'self ::1', '2015-01-07 12:34:00'),
(102441, 58, 2, 'astika from IP ::1', '2015-01-07 12:34:06'),
(102442, 58, 3, 'self ::1', '2015-01-07 12:34:38'),
(102443, 58, 2, 'astika from IP ::1', '2015-01-07 12:35:03'),
(102444, 58, 2, 'astika from IP ::1', '2015-01-08 04:33:35'),
(102445, 58, 2, 'astika from IP ::1', '2015-01-08 04:34:48'),
(102446, 58, 3, 'self ::1', '2015-01-08 04:45:59'),
(102447, 58, 2, 'astika from IP ::1', '2015-01-08 09:39:43'),
(102448, 58, 2, 'astika from IP ::1', '2015-01-08 12:37:07'),
(102449, 58, 2, 'astika from IP ::1', '2015-01-08 13:16:00'),
(102450, 58, 2, 'astika from IP ::1', '2015-01-09 05:29:34'),
(102451, 58, 2, 'astika from IP ::1', '2015-01-13 07:25:55'),
(102452, 58, 3, 'self ::1', '2015-01-13 09:07:20'),
(102453, 58, 2, 'astika from IP ::1', '2015-01-13 09:07:29'),
(102454, 58, 2, 'astika from IP ::1', '2015-01-14 01:01:33'),
(102455, 58, 3, 'self ::1', '2015-01-14 04:44:46'),
(102456, 58, 2, 'astika from IP ::1', '2015-01-14 04:45:24'),
(102457, 58, 2, 'astika from IP ::1', '2015-01-15 01:50:20'),
(102458, 58, 3, 'self ::1', '2015-01-15 05:15:09'),
(102459, 58, 2, 'astika from IP ::1', '2015-01-15 05:15:17'),
(102460, 58, 2, 'astika from IP ::1', '2015-01-16 05:42:33'),
(102461, 58, 2, 'astika from IP ::1', '2015-01-16 10:23:13'),
(102462, 58, 2, 'astika from IP ::1', '2015-01-19 03:35:30'),
(102463, 58, 3, 'self ::1', '2015-01-19 08:40:49'),
(102464, 58, 3, 'self ::1', '2015-01-19 08:40:53'),
(102465, 58, 2, 'astika from IP ::1', '2015-01-19 08:41:25'),
(102466, 58, 2, 'astika from IP ::1', '2015-01-20 06:55:30'),
(102467, 58, 3, 'self ::1', '2015-01-20 07:28:54'),
(102468, 58, 3, 'self ::1', '2015-01-20 07:29:50'),
(102469, 58, 3, 'self ::1', '2015-01-20 07:29:52'),
(102470, 58, 3, 'self ::1', '2015-01-20 07:33:16'),
(102471, 58, 3, 'self ::1', '2015-01-20 08:24:59'),
(102472, 58, 3, 'self ::1', '2015-01-20 08:25:02'),
(102473, 58, 3, 'self ::1', '2015-01-20 08:25:03'),
(102474, 58, 2, 'astika from IP ::1', '2015-01-20 08:27:08'),
(102475, 58, 2, 'astika from IP ::1', '2015-01-21 06:54:11'),
(102476, 58, 2, 'astika from IP ::1', '2015-01-21 06:54:52'),
(102477, 58, 2, 'astika from IP ::1', '2015-01-21 06:57:43'),
(102478, 58, 2, 'astika from IP ::1', '2015-01-21 06:58:07'),
(102479, 58, 2, 'astika from IP ::1', '2015-01-21 06:58:41'),
(102480, 58, 2, 'astika from IP ::1', '2015-01-21 07:06:56'),
(102481, 58, 2, 'astika from IP ::1', '2015-01-21 07:14:24'),
(102482, 58, 2, 'astika from IP ::1', '2015-01-21 07:15:10'),
(102483, 58, 2, 'astika from IP ::1', '2015-01-21 07:15:17'),
(102484, 58, 2, 'astika from IP ::1', '2015-01-21 07:33:35'),
(102485, 58, 2, 'astika from IP ::1', '2015-01-21 07:33:43'),
(102486, 58, 2, 'astika from IP ::1', '2015-01-22 08:26:35'),
(102487, 58, 2, 'astika from IP ::1', '2015-01-22 08:28:27'),
(102488, 58, 2, 'astika from IP ::1', '2015-01-22 08:31:02'),
(102489, 58, 2, 'astika from IP ::1', '2015-01-22 08:31:27'),
(102490, 58, 2, 'astika from IP ::1', '2015-01-22 08:31:46'),
(102491, 58, 2, 'astika from IP ::1', '2015-01-26 09:01:15'),
(102492, 58, 2, 'astika from IP ::1', '2015-01-26 09:12:20'),
(102493, 58, 2, 'astika from IP ::1', '2015-01-26 12:09:25'),
(102494, 58, 2, 'astika from IP ::1', '2015-01-27 05:57:53'),
(102495, 58, 3, 'self ::1', '2015-01-27 06:58:25'),
(102496, 58, 2, 'astika from IP ::1', '2015-01-27 06:58:39'),
(102497, 58, 2, 'astika from IP ::1', '2015-01-27 06:59:34'),
(102498, 58, 2, 'astika from IP ::1', '2015-01-27 07:01:22'),
(102499, 58, 2, 'astika from IP ::1', '2015-01-27 07:02:35'),
(102500, 58, 3, 'self ::1', '2015-01-27 07:02:38'),
(102501, 58, 2, 'astika from IP ::1', '2015-01-27 07:02:57'),
(102502, 58, 2, 'astika from IP ::1', '2015-01-28 12:27:35'),
(102503, 58, 3, 'self ::1', '2015-01-28 12:27:40'),
(102504, 58, 2, 'astika from IP ::1', '2015-01-28 12:27:47'),
(102505, 58, 2, 'astika from IP ::1', '2015-01-29 08:57:45'),
(102506, 58, 3, 'self ::1', '2015-01-29 08:57:47'),
(102507, 58, 2, 'astika from IP ::1', '2015-01-29 09:52:47'),
(102508, 58, 2, 'astika from IP ::1', '2015-01-29 09:55:42'),
(102509, 58, 2, 'astika from IP ::1', '2015-01-29 09:57:29'),
(102510, 58, 2, 'astika from IP ::1', '2015-01-30 01:19:26'),
(102511, 58, 3, 'self ::1', '2015-01-30 01:33:22'),
(102512, 58, 2, 'astika from IP ::1', '2015-01-30 01:33:30'),
(102513, 58, 3, 'self ::1', '2015-01-30 01:45:07'),
(102514, 58, 2, 'astika from IP ::1', '2015-01-30 01:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `mst_query_library`
--

CREATE TABLE IF NOT EXISTS `mst_query_library` (
  `query_id` int(10) NOT NULL AUTO_INCREMENT,
  `modul_id` int(11) DEFAULT NULL,
  `description` text,
  `query` text NOT NULL COMMENT 'Query Text',
  PRIMARY KEY (`query_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_statistics`
--

CREATE TABLE IF NOT EXISTS `mst_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul_name` varchar(50) NOT NULL,
  `sub_modul_name` varchar(50) NOT NULL,
  `session_id` int(11) NOT NULL,
  `ip_add` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_agent` varchar(50) NOT NULL,
  `browser_name` varchar(255) NOT NULL,
  `browser_version` varchar(255) NOT NULL,
  `os_version` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `access_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=196 ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_system_alert`
--

CREATE TABLE IF NOT EXISTS `mst_system_alert` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `hospital_id` varchar(10) NOT NULL,
  `connection_id` int(11) NOT NULL,
  `alert_modul` varchar(50) DEFAULT NULL,
  `mail_to` tinytext,
  `cc_to` tinytext,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mst_system_alert`
--

INSERT INTO `mst_system_alert` (`Id`, `hospital_id`, `connection_id`, `alert_modul`, `mail_to`, `cc_to`) VALUES
(1, 'SHTS', 9, 'stock_alert', 'tri.ismardiko@gmail.com', 'tri.ismardiko@simedika.com'),
(2, 'SHDP', 10, 'stock_alert', 'sumerthayasa@siloamhospitals.com', 'tri.ismardiko@simedika.com');

-- --------------------------------------------------------

--
-- Table structure for table `mst_tools`
--

CREATE TABLE IF NOT EXISTS `mst_tools` (
  `modul_id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11),
  `modul_mst_code` varchar(20) NOT NULL,
  `modul_name` varchar(50) DEFAULT NULL,
  `modul_description` varchar(50) DEFAULT NULL,
  `modul_icon` varchar(50) DEFAULT NULL,
  `modul_url` varchar(225) DEFAULT NULL,
  `modul_category_id` int(11) DEFAULT NULL,
  `modul_show` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`modul_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `mst_tools`
--

INSERT INTO `mst_tools` (`modul_id`, `parent_id`, `modul_mst_code`, `modul_name`, `modul_description`, `modul_icon`, `modul_url`, `modul_category_id`, `modul_show`) VALUES
(1, 0, 'mst_core', 'Configuration Tools', 'Administration tools for MedicOS Supporting Tools', 'manage_tools.png', 'core/sys_config/user', 1, 1),
(2, NULL, 'mst_core', 'Login', 'Login', NULL, 'core/login', 0, 0),
(3, 0, 'mst_core', 'Logout', 'Logout', 'logout.png', 'core/logout', 0, 0),
(4, NULL, 'mst_core', 'Choose Database', 'Change or choose database', 'db-select.png', 'core/select_database', 1, 1),
(20, NULL, 'MST 017', 'Used Cartridge', 'Used Cartridge Per Departement', 'cartridge.png', 'core/sys_config/use_cartridge', 5, 0),
(70, 0, 'inv-01', 'Inventory Modul', 'Inventory Modul', 'inventory.png', 'tools/sub_tools', 1, 1),
(26, NULL, 'MST 023', 'Class Correction', 'Manage patient price class', 'class_correction.png', 'manage_class', 5, 0),
(27, NULL, 'MST 024', 'Medicine Consumption', 'Daily medicine consumption / distribution report', 'medicine_consume.png', 'medicine_consume', 6, 1),
(30, NULL, 'MST 027', 'Patient Marketing Report', 'Data marketing patient report for marketing div', 'patient_report.png', 'marketing_report/marketing_patient_report_filter', 8, 0),
(69, 70, 'MST 018', 'Location Items', 'Modul Location Items', 'company.png', 'core/sys_config/location', 4, 1),
(67, NULL, 'MST 064', 'Data Exchange - Patient Data', 'Get Daily Patient Data For Open His', 'data_exchange.png', 'dataexchange/patientdata', 5, 0),
(71, 70, 'mst_category', 'Category Items', 'Modul Category Items', 'category.png', 'core/sys_config/category', 9, 1),
(72, 70, 'inv_items', 'Items Inventory', 'Modul Items Inventory', 'service_doc.png', 'core/sys_config/asset', 9, 1),
(73, 70, 'inv-map', 'Mapping Asset', 'Modul Mapping Asset', 'mappingasset.png', 'core/sys_config/mapping', 9, 1),
(74, 0, 'mst_report', 'Report', 'Report Inventory', 'report.png', 'core/sysconfig/report', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_tools_category`
--

CREATE TABLE IF NOT EXISTS `mst_tools_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `category_details` varchar(255) DEFAULT NULL,
  `category_icon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `mst_tools_category`
--

INSERT INTO `mst_tools_category` (`category_id`, `category_name`, `category_details`, `category_icon`) VALUES
(1, 'Systems Config', 'System Core Modules Category', NULL),
(2, 'Billing', 'Billing Modules Category', NULL),
(3, 'Registration & Schedule', 'Registration & Schedule Modules Category', NULL),
(4, 'Purchasing', 'Purchasing Modules Category', NULL),
(5, 'Administration', 'Administration Modules Category', NULL),
(6, 'Drugs And Med. Supplies', 'Drugs And Med. Supplies Modules Category', NULL),
(7, 'Item Services', 'Item Services Modules Category', NULL),
(8, 'Marketing', 'Marketing Modules Category', NULL),
(9, 'Other', 'Other Modules Category', NULL),
(10, 'Sales & Revenue', 'Sales & Revenue Modules Category', NULL),
(11, 'Finance', 'Finance Modules Category', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE IF NOT EXISTS `mst_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` tinytext,
  `oldpassword` tinytext,
  `real_name` varchar(50) DEFAULT NULL,
  `hospital_id` varchar(50) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `active` int(1) NOT NULL,
  `is_online` int(1) NOT NULL DEFAULT '0',
  `role_level` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`user_id`, `username`, `password`, `oldpassword`, `real_name`, `hospital_id`, `contact_number`, `email_address`, `active`, `is_online`, `role_level`) VALUES
(58, 'astika', 'YrcKKj/oMQxtPzLxyosDuSOxN4BRiP6gh7NciREW2/xdrWlVy9drlSDM1WULjubwWloKfakBGU0XeaeTHwS3rQ==', NULL, 'Astika Putra', 'SHDP', '0812221121', 'asdas', 1, 1, 'oracle');

-- --------------------------------------------------------

--
-- Table structure for table `mst_user_assign_database`
--

CREATE TABLE IF NOT EXISTS `mst_user_assign_database` (
  `assign_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `connection_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`assign_id`),
  UNIQUE KEY `user_id_connection_id` (`user_id`,`connection_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `mst_user_assign_database`
--

INSERT INTO `mst_user_assign_database` (`assign_id`, `user_id`, `connection_id`) VALUES
(1, 58, 10);

-- --------------------------------------------------------

--
-- Table structure for table `mst_user_assign_modul`
--

CREATE TABLE IF NOT EXISTS `mst_user_assign_modul` (
  `assign_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `modul_id` int(10) DEFAULT NULL,
  `priority` int(10) DEFAULT NULL,
  PRIMARY KEY (`assign_id`),
  UNIQUE KEY `user_id_modul_id` (`user_id`,`modul_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1124 ;

--
-- Dumping data for table `mst_user_assign_modul`
--

INSERT INTO `mst_user_assign_modul` (`assign_id`, `user_id`, `modul_id`, `priority`) VALUES
(1, 58, 1, 6),
(1123, 58, 74, 0),
(1122, 58, 73, 1),
(1120, 58, 71, 3),
(1119, 58, 70, 4),
(1116, 58, 69, 5),
(1121, 58, 72, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sub_mst_tools`
--

CREATE TABLE IF NOT EXISTS `sub_mst_tools` (
  `sub_modul_id` int(10) NOT NULL AUTO_INCREMENT,
  `modul_id` int(10) NOT NULL,
  `sub_modul_mst_code` varchar(20) NOT NULL,
  `sub_modul_name` varchar(50) DEFAULT NULL,
  `sub_modul_description` varchar(50) DEFAULT NULL,
  `sub_modul_icon` varchar(50) DEFAULT NULL,
  `sub_modul_url` varchar(225) DEFAULT NULL,
  `sub_modul_show` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sub_modul_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `sub_mst_tools`
--

INSERT INTO `sub_mst_tools` (`sub_modul_id`, `modul_id`, `sub_modul_mst_code`, `sub_modul_name`, `sub_modul_description`, `sub_modul_icon`, `sub_modul_url`, `sub_modul_show`) VALUES
(71, 70, 'sub-01', 'Category', 'Category Items', 'category.jpg', 'sub_tools/category', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cartride`
--

CREATE TABLE IF NOT EXISTS `tb_cartride` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cartridge` varchar(100) NOT NULL,
  `id_printer` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_cartride`
--

INSERT INTO `tb_cartride` (`id`, `cartridge`, `id_printer`, `keterangan`, `aktif`) VALUES
(1, 'HP 85 A', 4, 'Black Cartridge', 'Y'),
(2, 'HP 85 X', 4, 'Black Cartridge', 'Y'),
(3, 'HP 78 X', 3, 'Black Cartridge', 'Y'),
(4, 'HP 78 A', 3, 'Black Cartridge', 'Y'),
(5, 'Ribon LQ- 300', 5, 'Ribon', 'Y'),
(6, 'HP  131 A ', 6, 'Black  Carttidgr U/ Rabdurant', 'Y'),
(7, 'aa', 4, 'ASDRD', 'Y'),
(8, 'aa', 4, 'ASDRD', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_departemen`
--

CREATE TABLE IF NOT EXISTS `tb_departemen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_dept` varchar(50) NOT NULL,
  `id_lantai` int(5) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tb_departemen`
--

INSERT INTO `tb_departemen` (`id`, `nama_dept`, `id_lantai`, `keterangan`, `aktif`) VALUES
(1, 'ICT', 3, '<p>\r\n	Information Comuncation and Tehknologi</p>\r\n', 'N'),
(2, 'Medical Record', 2, 'Medical Record Room', 'Y'),
(3, 'Parmacy', 2, 'Parmacy Central', 'Y'),
(4, 'Purchasing', 4, 'Purchasing', 'Y'),
(5, 'HRD', 4, 'Human Resouce Development', 'Y'),
(6, 'IPD BPJS', 4, 'IPD BPJS Lantai 5', 'Y'),
(7, 'Marketing', 4, 'Account Officer', 'Y'),
(8, 'Cath Lab', 3, 'Cath Labolatory', 'Y'),
(9, 'Medical Supplies', 2, 'Medical Supplies / Storage', 'Y'),
(10, 'Lab', 2, 'labolatorium', 'Y'),
(11, 'Accounting', 2, 'Accountting Office', 'Y'),
(12, 'Call Center', 1, 'Call Center Lt 1', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pakai`
--

CREATE TABLE IF NOT EXISTS `tb_pakai` (
  `no` int(4) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `id_cartridge` int(4) NOT NULL,
  `id_departemen` int(4) NOT NULL,
  `qty` int(4) NOT NULL,
  `keterangan` text NOT NULL,
  `user_id` varchar(50) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_pakai`
--

INSERT INTO `tb_pakai` (`no`, `tgl`, `id_cartridge`, `id_departemen`, `qty`, `keterangan`, `user_id`) VALUES
(1, '2014-06-01', 1, 1, 2, 'terst', '58');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_tools`
--
CREATE TABLE IF NOT EXISTS `vw_tools` (
`modul_id` int(10)
,`modul_name` varchar(50)
,`modul_description` varchar(50)
,`modul_icon` varchar(50)
,`modul_url` varchar(225)
,`modulcategory_id` int(11)
);
-- --------------------------------------------------------

--
-- Structure for view `vw_tools`
--
DROP TABLE IF EXISTS `vw_tools`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tools` AS select `mst_user_assign_modul`.`modul_id` AS `modul_id`,`modul_name` AS `modul_name`,`modul_description` AS `modul_description`,`modul_icon` AS `modul_icon`,`modul_url` AS `modul_url`,`modul_category_id` AS `modulcategory_id` from ((`mst_user_assign_modul` join `mst_tools` on((`mst_user_assign_modul`.`modul_id` = `modul_id`))) join `mst_user` on((`mst_user`.`user_id` = `mst_user_assign_modul`.`user_id`))) where ((`modul_show` = 1) and (`mst_user_assign_modul`.`user_id` = 58)) order by `modul_name`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
