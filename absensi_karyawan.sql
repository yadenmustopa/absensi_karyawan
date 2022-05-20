-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.7.3-MariaDB-log - mariadb.org binary distribution
-- OS Server:                    Win64
-- HeidiSQL Versi:               11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk absen_karyawan
DROP DATABASE IF EXISTS `absen_karyawan`;
CREATE DATABASE IF NOT EXISTS `absen_karyawan` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `absen_karyawan`;

-- membuang struktur untuk table absen_karyawan.absens
DROP TABLE IF EXISTS `absens`;
CREATE TABLE IF NOT EXISTS `absens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('MASUK','TANPA_KETERANGAN','CUTI','IZIN') DEFAULT 'MASUK',
  `description` longtext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL COMMENT 'use time stamp',
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel absen_karyawan.absens: ~3 rows (lebih kurang)
DELETE FROM `absens`;
/*!40000 ALTER TABLE `absens` DISABLE KEYS */;
INSERT INTO `absens` (`id`, `user_id`, `status`, `description`, `created_at`, `updated_at`) VALUES
	(1, 2, 'IZIN', NULL, 1652947728, NULL),
	(2, 2, 'IZIN', NULL, 1652947888, NULL),
	(3, 2, 'IZIN', NULL, 1652947909, NULL);
/*!40000 ALTER TABLE `absens` ENABLE KEYS */;

-- membuang struktur untuk table absen_karyawan.karyawans
DROP TABLE IF EXISTS `karyawans`;
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `position` enum('CEO','CTO','CFO','CMO','COO','WPP') DEFAULT 'CEO',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL COMMENT 'per month',
  `photo` longtext DEFAULT 'assets/avatar.png',
  PRIMARY KEY (`id`),
  KEY `address` (`address`),
  KEY `no_hp` (`no_hp`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel absen_karyawan.karyawans: ~1 rows (lebih kurang)
DELETE FROM `karyawans`;
/*!40000 ALTER TABLE `karyawans` DISABLE KEYS */;
INSERT INTO `karyawans` (`id`, `user_id`, `address`, `position`, `created_at`, `updated_at`, `no_hp`, `salary`, `photo`) VALUES
	(4, 1, 'Kp Bacot', 'CTO', 1652942712, 1652942712, '08545656444', 5000000, 'assets/avatar.png');
/*!40000 ALTER TABLE `karyawans` ENABLE KEYS */;

-- membuang struktur untuk table absen_karyawan.migrations
DROP TABLE IF EXISTS `migrations`;
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

-- Membuang data untuk tabel absen_karyawan.migrations: ~2 rows (lebih kurang)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2022-05-18-123135', 'App\\Database\\Migrations\\Users', 'default', 'App', 1652937438, 1),
	(2, '2022-05-18-123158', 'App\\Database\\Migrations\\Karyawans', 'default', 'App', 1652937438, 1),
	(3, '2022-05-18-123214', 'App\\Database\\Migrations\\Absens', 'default', 'App', 1652937438, 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- membuang struktur untuk table absen_karyawan.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '0',
  `updated_at` int(15) DEFAULT 0,
  `created_at` int(15) DEFAULT 0,
  `username` varchar(20) DEFAULT '0',
  `password` varchar(50) DEFAULT '0',
  `status` enum('ADMIN','KARYAWAN') DEFAULT 'KARYAWAN',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel absen_karyawan.users: ~2 rows (lebih kurang)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `updated_at`, `created_at`, `username`, `password`, `status`) VALUES
	(00000000001, 'aduh', 1652945432, 1652937485, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'ADMIN');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
