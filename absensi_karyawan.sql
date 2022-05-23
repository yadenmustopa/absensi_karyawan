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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.absens: ~0 rows (approximately)
/*!40000 ALTER TABLE `absens` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.jabatans: ~0 rows (approximately)
/*!40000 ALTER TABLE `jabatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `jabatans` ENABLE KEYS */;

-- Dumping structure for table absensi_karyawan.karyawans
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT '',
  `position` varchar(50) NOT NULL DEFAULT 'CEO',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT '',
  `salary` int(11) DEFAULT 0 COMMENT 'per month',
  `photo` longtext DEFAULT 'assets/images/avatar.png',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `address` (`address`) USING BTREE,
  KEY `no_hp` (`no_hp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.karyawans: ~4 rows (approximately)
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
INSERT INTO `karyawans` (`id`, `user_id`, `address`, `position`, `created_at`, `updated_at`, `no_hp`, `salary`, `photo`) VALUES
	(4, 31, '', 'CEO', 1653226635, 1653226635, '', 0, 'assets/images/avatar.png'),
	(5, 32, '', 'CEO', 1653226943, 1653226943, '', 0, 'assets/images/avatar.png'),
	(6, 33, '', 'CEO', 1653259437, 1653259437, '', 0, 'assets/images/avatar.png'),
	(7, 34, '', 'CEO', 1653261408, 1653261408, '', 0, 'assets/images/avatar.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table absensi_karyawan.migrations: ~2 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2022-05-18-123135', 'App\\Database\\Migrations\\Users', 'default', 'App', 1653141303, 1),
	(2, '2022-05-18-123158', 'App\\Database\\Migrations\\Karyawans', 'default', 'App', 1653141303, 1),
	(3, '2022-05-18-123214', 'App\\Database\\Migrations\\Absens', 'default', 'App', 1653141303, 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- Dumping data for table absensi_karyawan.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `updated_at`, `created_at`, `username`, `password`, `role`) VALUES
	(1, 'ADMIN', 1653141331, 1653141331, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'ADMIN'),
	(31, 'Test', 1653226635, 1653226635, 'test', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(32, 'coba', 1653226943, 1653226943, 'lok', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(33, 'test uy', 1653259437, 1653259437, 'asa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN'),
	(34, 'alah', 1653261408, 1653261408, 'siah', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'KARYAWAN');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
