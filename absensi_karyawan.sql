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
CREATE DATABASE IF NOT EXISTS `absen_karyawan` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `absen_karyawan`;

-- membuang struktur untuk table absen_karyawan.absens
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

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table absen_karyawan.karyawans
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `position` enum('CEO','CTO','CFO','CMO','COO','WPP') DEFAULT 'CEO',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL COMMENT 'per month',
  `photo` longtext DEFAULT 'assets/images/avatar.png',
  PRIMARY KEY (`id`),
  KEY `address` (`address`),
  KEY `no_hp` (`no_hp`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table absen_karyawan.migrations
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

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table absen_karyawan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '0',
  `updated_at` int(15) DEFAULT 0,
  `created_at` int(15) DEFAULT 0,
  `username` varchar(20) DEFAULT '0',
  `password` varchar(50) DEFAULT '0',
  `role` enum('ADMIN','KARYAWAN') DEFAULT 'KARYAWAN',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `status` (`role`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
