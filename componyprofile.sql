-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for companyprofile
DROP DATABASE IF EXISTS `companyprofile`;
CREATE DATABASE IF NOT EXISTS `companyprofile` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `companyprofile`;

-- Dumping structure for table companyprofile.activity_logs
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.activity_logs: ~29 rows (approximately)
DELETE FROM `activity_logs`;
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
	(1, 1, 'logout', NULL, NULL, 'User logout', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:38:29', '2026-10-06 00:38:29'),
	(2, 3, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:38:53', '2026-10-06 00:38:53'),
	(3, 3, 'updated', 'App\\Models\\User', 2, 'Mengubah role admin-pict dari editor ke admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:43:47', '2026-10-06 00:43:47'),
	(4, 3, 'updated', 'App\\Models\\User', 1, 'Mengubah role admin 2 dari editor ke admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:43:51', '2026-10-06 00:43:51'),
	(5, 2, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:45:56', '2026-10-06 00:45:56'),
	(6, 2, 'deleted', NULL, NULL, 'Menghapus berita: Berita terkini', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:50:39', '2026-10-06 00:50:39'),
	(7, 2, 'updated', 'App\\Models\\News', 6, 'Memperbarui berita: Hari ini', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:50:50', '2026-10-06 00:50:50'),
	(8, 2, 'updated', 'App\\Models\\News', 5, 'Memperbarui berita: drfghg', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:51:05', '2026-10-06 00:51:05'),
	(9, 2, 'updated', 'App\\Models\\Tariff', 1, 'Memperbarui tarif: Domestic Tariffs', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 00:51:34', '2026-10-06 00:51:34'),
	(10, 1, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', '2026-10-06 00:59:37', '2026-10-06 00:59:37'),
	(11, 1, 'created', 'App\\Models\\News', 8, 'Menambahkan berita: Meeting UAT', '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', '2026-10-06 01:02:21', '2026-10-06 01:02:21'),
	(12, 3, 'updated', 'App\\Models\\Tariff', 1, 'Memperbarui tarif: Domestic Tariffs', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 01:07:36', '2026-10-06 01:07:36'),
	(13, 3, 'updated', 'App\\Models\\Tariff', 1, 'Memperbarui tarif: Domestic Tariffs', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 01:07:50', '2026-10-06 01:07:50'),
	(14, 3, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 19:41:45', '2026-10-06 19:41:45'),
	(15, 2, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 19:42:10', '2026-10-06 19:42:10'),
	(16, 2, 'updated', 'App\\Models\\News', 8, 'Memperbarui berita: Meeting UAT', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 21:52:16', '2026-10-06 21:52:16'),
	(17, 1, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', '2026-10-06 21:54:25', '2026-10-06 21:54:25'),
	(18, 1, 'created', 'App\\Models\\News', 9, 'Menambahkan berita: Ahahaahahah', '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', '2026-10-06 21:55:31', '2026-10-06 21:55:31'),
	(19, 1, 'logout', NULL, NULL, 'User logout', '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', '2026-10-06 21:56:47', '2026-10-06 21:56:47'),
	(20, 3, 'updated', 'App\\Models\\User', 3, 'Memperbarui user: Super Admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 21:57:37', '2026-10-06 21:57:37'),
	(21, 3, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', '2026-10-06 21:58:27', '2026-10-06 21:58:27'),
	(22, 3, 'logout', NULL, NULL, 'User logout', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:13:46', '2026-10-06 23:13:46'),
	(23, 3, 'login', NULL, NULL, 'User berhasil login', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:21:36', '2026-10-06 23:21:36'),
	(24, 3, 'updated', 'App\\Models\\User', 1, 'Mengubah role admin 2 dari admin ke super_admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:25:22', '2026-10-06 23:25:22'),
	(25, 3, 'updated', 'App\\Models\\User', 1, 'Mengubah role admin 2 dari super_admin ke admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:25:45', '2026-10-06 23:25:45'),
	(26, 3, 'updated', 'App\\Models\\User', 1, 'Mengubah role admin 2 dari admin ke super_admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:25:48', '2026-10-06 23:25:48'),
	(27, 3, 'updated', 'App\\Models\\User', 2, 'Mengubah role admin-pict dari admin ke super_admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:25:54', '2026-10-06 23:25:54'),
	(28, 3, 'updated', 'App\\Models\\User', 2, 'Mengubah role admin-pict dari super_admin ke admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:26:02', '2026-10-06 23:26:02'),
	(29, 3, 'updated', 'App\\Models\\User', 1, 'Mengubah role admin 2 dari super_admin ke admin', '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-06 23:26:05', '2026-10-06 23:26:05');

-- Dumping structure for table companyprofile.admin
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table companyprofile.admin: ~0 rows (approximately)
DELETE FROM `admin`;

-- Dumping structure for table companyprofile.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.cache: ~2 rows (approximately)
DELETE FROM `cache`;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('pict-admin-portal-cache-superadmin@pict.co.id|103.175.238.222', 'i:3;', 1791349090),
	('pict-admin-portal-cache-superadmin@pict.co.id|103.175.238.222:timer', 'i:1791349090;', 1791349090);

-- Dumping structure for table companyprofile.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table companyprofile.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table companyprofile.halaman
DROP TABLE IF EXISTS `halaman`;
CREATE TABLE IF NOT EXISTS `halaman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `kutipan` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tgl_isi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table companyprofile.halaman: ~0 rows (approximately)
DELETE FROM `halaman`;

-- Dumping structure for table companyprofile.info
DROP TABLE IF EXISTS `info`;
CREATE TABLE IF NOT EXISTS `info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tgl_isi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table companyprofile.info: ~0 rows (approximately)
DELETE FROM `info`;

-- Dumping structure for table companyprofile.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table companyprofile.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table companyprofile.members
DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `status` text NOT NULL,
  `token_ganti_password` text,
  `tgl_isi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table companyprofile.members: ~0 rows (approximately)
DELETE FROM `members`;

-- Dumping structure for table companyprofile.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.migrations: ~8 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_09_25_060844_create_news_table', 2),
	(5, '2026_10_01_025034_create_tariffs_table', 3),
	(6, '2026_10_01_060136_add_updated_by_to_news_and_tariffs_table', 4),
	(7, '2026_10_06_072626_add_role_to_users_table', 5),
	(8, '2026_10_06_073808_create_activity_logs_table', 6);

-- Dumping structure for table companyprofile.news
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_updated_by_foreign` (`updated_by`),
  CONSTRAINT `news_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.news: ~4 rows (approximately)
DELETE FROM `news`;
INSERT INTO `news` (`id`, `title`, `slug`, `category`, `image`, `excerpt`, `content`, `published_at`, `created_at`, `updated_at`, `updated_by`) VALUES
	(5, 'drfghg', 'drfghg', 'Minor', 'news/LcSJW8ReLAlQE8RyUZBHva344eMGjfBvzuMADtJ3.jpg', 'yggbb', 'ggbhb', '2026-09-28 19:27:27', '2026-09-28 19:27:27', '2026-10-06 00:51:05', 2),
	(6, 'Hari ini', 'hari-ini', 'hsushxu', 'news/kEzWRVyW2kpJLcu70NvahC6cOJETOfJw8h3rVMPm.jpg', 'ysusud', 'ydusuud\r\njhakjhakjf\r\nfsfsfs\r\nsfsfs\r\nsfs\r\nfs\r\nfs\r\nfs\r\nfs\r\nfs\r\nf', '2026-09-28 19:29:36', '2026-09-28 19:29:36', '2026-10-06 00:50:50', 2),
	(8, 'Meeting UAT', 'meeting-uat', 'TOS', 'news/0ndRB85m4802YRKxAnaL6gCed6YLkrEhz5dsZUYA.jpg', 'UAT', 'UAT a sbdajbadajda dadbajbdjadaj adbjadabdjad dabdjabdjabj  abfjfjafjafja ajfajfjafjjfja  jfaj\r\njafnfjanfk fajjfjanfjnjf afjanfjanfjanfjf afnjfnjanfjanjefje ajfbajbf\r\nfsbfhsbfbsjfwww\r\njfwjfjwfwjfbhbhwbfhwbfhwjbfwhjwh', '2026-10-06 01:02:21', '2026-10-06 01:02:21', '2026-10-06 21:52:16', 2),
	(9, 'Ahahaahahah', 'ahahaahahah', 'Operations', 'news/sh3ZdUvNIYlDFh2kpQMarALSK2mAN8l1nwroXA1u.jpg', 'Ahehehehhe', 'Hahshhehehehbsbshshs\r\njhd', '2026-10-06 21:55:31', '2026-10-06 21:55:31', '2026-10-06 21:55:31', 1);

-- Dumping structure for table companyprofile.partners
DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tgl_isi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table companyprofile.partners: ~0 rows (approximately)
DELETE FROM `partners`;

-- Dumping structure for table companyprofile.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table companyprofile.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.sessions: ~3 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('gSytCsQAB9GBpXbm5y3dxGZtpgBXmjSzgPmjUzyg', 3, '103.175.238.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/27.0.1 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJvT2l2dlZjTDNnMkg3RnVpYjY0dlVpbVJWU3BieE5LYUpCOFlTUnltIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL3BvcnRhYmxlLWdyaWV2YW5jZS1iYWNrc3BhY2Uubmdyb2stZnJlZS5kZXZcL3BpY3QtaW50ZXJuYWwtYWRtaW4tcG9ydGFsIiwicm91dGUiOiJkYXNoYm9hcmQifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjN9', 1791349107),
	('HSzhwPxfO1jd8XfaBU1M4wAOSDh0Dheeq5Q2h5DD', 2, '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'eyJfdG9rZW4iOiIwTmpzTlFVMGxoMDVUOFNrVlFGTnFiYnBsWnVBdmVzREdGYzhjMHpqIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9wb3J0YWJsZS1ncmlldmFuY2UtYmFja3NwYWNlLm5ncm9rLWZyZWUuZGV2XC9waWN0LWludGVybmFsLWFkbWluLXBvcnRhbFwvbmV3c1wvY3JlYXRlIiwicm91dGUiOiJuZXdzLmNyZWF0ZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==', 1791354368),
	('ZEbjYmzPrG3Ggqpul9zBypawIWgEglPB5EJDBpNz', 3, '103.175.238.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'eyJfdG9rZW4iOiJmejFUenBFNWM3Sjl6RlZFUHd1ME9BaFFuOHBBUzN6cjBzTm1aVVR1IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL3BvcnRhYmxlLWdyaWV2YW5jZS1iYWNrc3BhY2Uubmdyb2stZnJlZS5kZXYiLCJyb3V0ZSI6ImhvbWUifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjN9', 1791355395);

-- Dumping structure for table companyprofile.tariffs
DROP TABLE IF EXISTS `tariffs`;
CREATE TABLE IF NOT EXISTS `tariffs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'document',
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tariffs_updated_by_foreign` (`updated_by`),
  CONSTRAINT `tariffs_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.tariffs: ~1 rows (approximately)
DELETE FROM `tariffs`;
INSERT INTO `tariffs` (`id`, `tag`, `title`, `description`, `icon`, `pdf_path`, `sort_order`, `is_active`, `created_at`, `updated_at`, `updated_by`) VALUES
	(1, 'Domestic', 'Domestic Tariffs', 'Terbaru', 'document', 'tariffs/QKIjkj0BbD9Ycgg93J3PobeTsTqpHfE1UoJsAd5Z.pdf', 1, 1, '2026-09-30 20:06:52', '2026-10-06 01:07:50', NULL);

-- Dumping structure for table companyprofile.tutors
DROP TABLE IF EXISTS `tutors`;
CREATE TABLE IF NOT EXISTS `tutors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tgl_isi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table companyprofile.tutors: ~0 rows (approximately)
DELETE FROM `tutors`;

-- Dumping structure for table companyprofile.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','editor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'editor',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table companyprofile.users: ~3 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin 2', 'rangga@company.com', 'admin', NULL, '$2y$12$KGwhQCxtx/owZDZxEH3WSuJT9/ck.2PI1jA3et5Qop6M.FuxGdmnm', NULL, '2026-09-24 23:23:30', '2026-10-06 23:26:05'),
	(2, 'admin-pict', 'pict@admin.com', 'admin', NULL, '$2y$12$Xe54Bzohd/FAia2rflmCH.LM7tQbuqMxUhtFsIQhI0y7IFMv5s8K6', NULL, '2026-09-30 20:43:05', '2026-10-06 23:26:02'),
	(3, 'Super Admin', 'superadmin@pict.com', 'super_admin', NULL, '$2y$12$dIQc3ftvsvGLeyfXtgfLBuZRCjS7bqv1H2ZoBPH29aNL04uXNtNbG', 'V4Ww1toVlbkI5KQK0EcX4pKeTmp9MB6maVwaKpihWX2arY1hMr78NuRCuaPT', '2026-10-06 00:28:51', '2026-10-06 21:57:37');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
