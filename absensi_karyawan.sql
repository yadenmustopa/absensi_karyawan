-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.6.4-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for absensi_karyawan
CREATE DATABASE IF NOT EXISTS `absensi_karyawan` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `absensi_karyawan`;

-- Dumping structure for table absensi_karyawan.absens
CREATE TABLE IF NOT EXISTS `absens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('MASUK','TANPA_KETERANGAN','CUTI','IZIN') DEFAULT 'MASUK',
  `description` longtext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL COMMENT 'use time stamp',
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.absens: ~7 rows (approximately)
/*!40000 ALTER TABLE `absens` DISABLE KEYS */;
INSERT INTO `absens` (`id`, `user_id`, `status`, `description`, `created_at`, `updated_at`) VALUES
	(3, 31, 'MASUK', NULL, 1653350686, 1653350686),
	(31, 31, 'IZIN', '', 1653523449, 1653523449),
	(32, 36, 'TANPA_KETERANGAN', '', 1653523459, 1653523459),
	(33, 37, 'CUTI', '', 1653523467, 1653523467),
	(34, 38, 'MASUK', '', 1653523474, 1653523474),
	(35, 37, 'MASUK', '', 1653602613, 1653602613),
	(36, 39, 'TANPA_KETERANGAN', '', 1653602621, 1653602621);
/*!40000 ALTER TABLE `absens` ENABLE KEYS */;

-- Dumping structure for table absensi_karyawan.jabatans
CREATE TABLE IF NOT EXISTS `jabatans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) DEFAULT '',
  `description` longtext DEFAULT '',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.jabatans: ~12 rows (approximately)
/*!40000 ALTER TABLE `jabatans` DISABLE KEYS */;
INSERT INTO `jabatans` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(2, 'CTO', 'Chief Tech Officer', 1653226635, 1653226635),
	(4, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(5, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(6, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(7, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(8, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(9, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(10, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(11, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(12, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635),
	(13, 'CEO', 'Chief Everything Officer', 1653226635, 1653226635);
/*!40000 ALTER TABLE `jabatans` ENABLE KEYS */;

-- Dumping structure for table absensi_karyawan.karyawans
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `position` varchar(50) NOT NULL DEFAULT 'CEO',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `photo` longtext DEFAULT 'assets/images/avatar.png',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `address` (`address`) USING BTREE,
  KEY `no_hp` (`no_hp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.karyawans: ~11 rows (approximately)
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
INSERT INTO `karyawans` (`id`, `user_id`, `address`, `position`, `created_at`, `updated_at`, `no_hp`, `salary`, `photo`) VALUES
	(4, 31, 'mamam', 'CTO', 1653226635, 1653343788, '08562323822', 5000000, 'assets/images/avatar.png'),
	(9, 36, 'Jl Hz.', 'CTO', 1653344251, 1653483484, '0812313124', 5000000, 'assets/images/avatar.png'),
	(10, 37, NULL, 'CEO', 1653344389, 1653344389, NULL, NULL, 'assets/images/avatar.png'),
	(11, 38, NULL, 'CEO', 1653391979, 1653391979, NULL, NULL, 'assets/images/avatar.png'),
	(12, 39, NULL, 'CEO', 1653602423, 1653602423, NULL, NULL, 'assets/images/avatar.png'),
	(13, 40, NULL, 'CEO', 1653610049, 1653610049, NULL, NULL, 'uploads/6290bf201d6f5.webp'),
	(14, 41, NULL, 'CEO', 1653610068, 1653610068, NULL, NULL, 'assets/images/avatar.png'),
	(15, 42, NULL, 'CEO', 1653610082, 1653610082, NULL, NULL, 'uploads/6290bf0a06bd8.webp'),
	(16, 43, NULL, 'CEO', 1653610095, 1653610095, NULL, NULL, 'assets/images/avatar.png'),
	(17, 44, NULL, 'CEO', 1653610111, 1653610111, NULL, NULL, 'uploads/6290b81e43470.webp'),
	(18, 45, NULL, 'CEO', 1653612261, 1653612261, NULL, NULL, 'uploads/6290b743029b6.webp'),
	(20, 46, NULL, 'CEO', 1653657138, 1653657138, NULL, NULL, 'assets/images/avatar.png');
/*!40000 ALTER TABLE `karyawans` ENABLE KEYS */;

-- Dumping structure for table absensi_karyawan.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table absensi_karyawan.migrations: ~5 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2022-05-18-123135', 'App\\Database\\Migrations\\Users', 'default', 'App', 1653141303, 1),
	(2, '2022-05-18-123158', 'App\\Database\\Migrations\\Karyawans', 'default', 'App', 1653141303, 1),
	(3, '2022-05-18-123214', 'App\\Database\\Migrations\\Absens', 'default', 'App', 1653141303, 1),
	(4, '2022-05-22-121459', 'App\\Database\\Migrations\\Users', 'default', 'App', 1653392207, 2),
	(5, '2022-05-23-050333', 'App\\Database\\Migrations\\Karyawans', 'default', 'App', 1653392207, 2),
	(6, '2022-05-23-050347', 'App\\Database\\Migrations\\Jabatans', 'default', 'App', 1653392207, 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table absensi_karyawan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '0',
  `updated_at` int(15) DEFAULT 0,
  `created_at` int(15) DEFAULT 0,
  `username` varchar(20) DEFAULT '0',
  `password` varchar(50) DEFAULT '0',
  `role` enum('ADMIN','KARYAWAN') DEFAULT 'KARYAWAN',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `status` (`role`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.users: ~12 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `updated_at`, `created_at`, `username`, `password`, `role`) VALUES
	(1, 'ADMIN', 1653141331, 1653141331, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'ADMIN'),
	(31, 'Test', 1653226635, 1653226635, 'test', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(36, 'makana', 1653344251, 1653344251, 'mangkana', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ADMIN'),
	(37, 'Cikan', 1653344388, 1653344388, 'Tust', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(38, 'cikan', 1653391979, 1653391979, 'cik', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(39, 'magol', 1653602423, 1653602423, 'magol', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(40, 'dfsfd', 1653610049, 1653610049, 'dsfdsd', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ADMIN'),
	(41, 'fdsdf', 1653610068, 1653610068, 'ada', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(42, 'lahan', 1653610082, 1653610082, 'laan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(43, 'aku', 1653610095, 1653610095, 'aku', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(44, 'mantap', 1653610111, 1653610111, 'kocak', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(45, 'marwan', 1653612261, 1653612261, 'marwan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(46, 'Maman', 1653657138, 1653657138, 'Maman', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
