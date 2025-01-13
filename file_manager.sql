-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk file-manager-2
CREATE DATABASE IF NOT EXISTS `file-manager-2` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `file-manager-2`;

-- membuang struktur untuk table file-manager-2.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.departments: ~4 rows (lebih kurang)
DELETE FROM `departments`;
INSERT INTO `departments` (`id`, `name`, `head_id`, `created_at`, `updated_at`) VALUES
	(1, 'IT Department', NULL, NULL, NULL),
	(2, 'HR Department', NULL, NULL, NULL),
	(3, 'Finance Department', NULL, NULL, NULL),
	(4, 'Marketing Department', NULL, NULL, NULL);

-- membuang struktur untuk table file-manager-2.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.failed_jobs: ~0 rows (lebih kurang)
DELETE FROM `failed_jobs`;

-- membuang struktur untuk table file-manager-2.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  `file_category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_folder_id_foreign` (`folder_id`),
  KEY `files_user_id_foreign` (`user_id`),
  KEY `files_department_id_foreign` (`department_id`),
  KEY `files_file_category_id_foreign` (`file_category_id`),
  CONSTRAINT `files_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `files_file_category_id_foreign` FOREIGN KEY (`file_category_id`) REFERENCES `file_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `files_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.files: ~7 rows (lebih kurang)
DELETE FROM `files`;
INSERT INTO `files` (`id`, `folder_id`, `user_id`, `department_id`, `file_category_id`, `name`, `path`, `type`, `size`, `is_favorite`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, NULL, 1, 1, NULL, 'Project Plan', '/files/project_plan.pdf', 'images', 2048, 0, NULL, NULL, NULL),
	(2, NULL, 2, 2, NULL, 'Employee Handbook', '/files/employee_handbook.pdf', 'images', 1024, 1, NULL, NULL, NULL),
	(4, NULL, 6, 1, 1, 'FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (1).docx', 'file-manager/FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (1).docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 15718, 1, NULL, '2024-11-17 05:03:50', '2024-11-17 12:13:42'),
	(6, NULL, 6, NULL, 1, 'Nota Dinas Pembimbing UJI PROPOSAL erda.pdf', 'file-manager/Nota Dinas Pembimbing UJI PROPOSAL erda.pdf', 'application/pdf', 359570, 1, NULL, '2024-11-17 12:13:00', '2024-11-17 12:13:14'),
	(7, 3, 6, NULL, 1, '2. Rancang Bangun Document Management System (2013).pdf', 'file-manager/2. Rancang Bangun Document Management System (2013).pdf', 'application/pdf', 166230, 0, NULL, '2024-11-17 12:33:45', '2024-11-17 12:49:19'),
	(8, NULL, 6, NULL, 1, '1. login.png', 'file-manager/1. login.png', 'image/png', 21343, 0, NULL, '2024-11-17 12:36:51', '2024-11-17 12:36:51'),
	(9, NULL, 6, NULL, 1, 'kepo.docx', 'file-manager/LEMBAR PENGESAHAN.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 53009, 0, '2024-12-14 15:09:08', '2024-12-14 14:22:25', '2024-12-14 15:09:08');

-- membuang struktur untuk table file-manager-2.file_categories
CREATE TABLE IF NOT EXISTS `file_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.file_categories: ~1 rows (lebih kurang)
DELETE FROM `file_categories`;
INSERT INTO `file_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'surat masuk', '2024-11-17 04:32:46', '2024-11-17 04:32:46');

-- membuang struktur untuk table file-manager-2.file_share
CREATE TABLE IF NOT EXISTS `file_share` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `file_id` bigint unsigned DEFAULT NULL,
  `folder_id` bigint unsigned DEFAULT NULL,
  `shared_with_id` bigint unsigned NOT NULL,
  `permission` enum('view','edit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'view',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_share_file_id_foreign` (`file_id`),
  KEY `file_share_folder_id_foreign` (`folder_id`),
  KEY `file_share_shared_with_id_foreign` (`shared_with_id`),
  CONSTRAINT `file_share_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_share_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_share_shared_with_id_foreign` FOREIGN KEY (`shared_with_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.file_share: ~12 rows (lebih kurang)
DELETE FROM `file_share`;
INSERT INTO `file_share` (`id`, `file_id`, `folder_id`, `shared_with_id`, `permission`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 2, 'view', NULL, NULL),
	(2, 2, NULL, 3, 'edit', NULL, NULL),
	(6, 6, NULL, 3, 'view', '2024-11-17 12:14:27', '2024-11-17 12:14:27'),
	(9, NULL, 3, 3, 'view', '2024-11-17 12:35:35', '2024-11-17 12:35:35'),
	(10, NULL, 3, 5, 'view', '2024-11-17 12:35:35', '2024-11-17 12:35:35'),
	(11, 8, NULL, 3, 'view', '2024-11-17 12:37:15', '2024-11-17 12:37:15'),
	(12, 8, NULL, 5, 'view', '2024-11-17 12:37:15', '2024-11-17 12:37:15'),
	(13, 9, NULL, 2, 'view', '2024-12-14 14:51:30', '2024-12-14 14:51:30'),
	(14, 9, NULL, 3, 'view', '2024-12-14 14:52:58', '2024-12-14 14:52:58'),
	(15, NULL, 4, 6, 'view', '2024-12-14 15:13:53', '2024-12-14 15:13:53'),
	(16, NULL, 5, 6, 'view', '2024-12-14 15:16:44', '2024-12-14 15:16:44'),
	(17, 4, NULL, 3, 'view', '2024-12-14 15:33:13', '2024-12-14 15:33:13');

-- membuang struktur untuk table file-manager-2.folders
CREATE TABLE IF NOT EXISTS `folders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `folders_user_id_foreign` (`user_id`),
  KEY `folders_department_id_foreign` (`department_id`),
  KEY `folders_parent_id_foreign` (`parent_id`),
  CONSTRAINT `folders_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `folders_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `folders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.folders: ~5 rows (lebih kurang)
DELETE FROM `folders`;
INSERT INTO `folders` (`id`, `user_id`, `department_id`, `name`, `parent_id`, `is_favorite`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Reports', NULL, 1, NULL, NULL, NULL),
	(2, 2, 2, 'Training', NULL, 0, NULL, NULL, NULL),
	(3, 6, NULL, 'ini', NULL, 0, NULL, '2024-11-17 12:31:36', '2024-11-17 12:50:51'),
	(4, 3, NULL, 'folder', NULL, 0, NULL, '2024-12-14 15:13:37', '2024-12-14 15:13:37'),
	(5, 3, NULL, 'secret', NULL, 0, NULL, '2024-12-14 15:16:29', '2024-12-14 15:16:29');

-- membuang struktur untuk table file-manager-2.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.migrations: ~14 rows (lebih kurang)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_10_12_070116_file__categories_table', 1),
	(7, '2024_10_26_070503_create_departments_table', 1),
	(8, '2024_10_26_070504_create_pegawai_table', 1),
	(9, '2024_10_26_070509_create_folders_table', 1),
	(10, '2024_10_26_070510_create_files_table', 1),
	(11, '2024_10_26_070513_create_file_share_table', 1),
	(12, '2024_11_03_072454_create_notifications_table', 1),
	(13, '2024_11_03_081556_add_disk_space_to_users_table', 1),
	(14, '2024_11_03_084607_add_image_to_users_table', 1);

-- membuang struktur untuk table file-manager-2.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.notifications: ~15 rows (lebih kurang)
DELETE FROM `notifications`;
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('13141e62-4dc1-40b5-9b7a-b213574bd68a', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (1).docx","sharer_name":"erda","message":"File \'FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (1).docx\' has been shared with you by erda."}', '2024-12-14 15:41:16', '2024-12-14 15:33:13', '2024-12-14 15:41:16'),
	('1dbb0464-868b-4fc7-b9ad-a5f13402edce', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"ini","sharer_name":"erda","message":"File \'ini\' has been shared with you by erda."}', '2024-11-17 12:41:12', '2024-11-17 12:35:35', '2024-11-17 12:41:12'),
	('2ece122d-3937-4457-8600-37ef8841eae6', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"Nota Dinas Pembimbing UJI PROPOSAL erda.pdf","sharer_name":"erda","message":"File \'Nota Dinas Pembimbing UJI PROPOSAL erda.pdf\' has been shared with you by erda."}', '2024-11-17 12:41:12', '2024-11-17 12:14:27', '2024-11-17 12:41:12'),
	('31d1c386-21cc-4bea-a452-cfcd25e631db', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 5, '{"file_name":"FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (2).docx","sharer_name":"erda","message":"File \'FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (2).docx\' has been shared with you by erda."}', NULL, '2024-11-17 12:16:11', '2024-11-17 12:16:11'),
	('3900e735-d521-4e99-b95c-95a43d949ece', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 5, '{"file_name":"1. login.png","sharer_name":"erda","message":"File \'1. login.png\' has been shared with you by erda."}', NULL, '2024-11-17 12:37:15', '2024-11-17 12:37:15'),
	('7639ec18-97a1-432e-8b0b-a77c04b5badf', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 5, '{"file_name":"coba","sharer_name":"erda","message":"File \'coba\' has been shared with you by erda."}', NULL, '2024-11-17 04:36:26', '2024-11-17 04:36:26'),
	('777c9234-f722-469d-9bd0-8c0c88d82826', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"coba","sharer_name":"erda","message":"File \'coba\' has been shared with you by erda."}', '2024-11-17 12:41:12', '2024-11-17 04:35:11', '2024-11-17 12:41:12'),
	('aa2be263-845b-47fd-9037-85a518737cc8', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 2, '{"file_name":"LEMBAR PENGESAHAN.docx","sharer_name":"erda","message":"File \'LEMBAR PENGESAHAN.docx\' has been shared with you by erda."}', NULL, '2024-12-14 14:51:33', '2024-12-14 14:51:33'),
	('b51205c2-8075-4300-bb9d-b8812c9bccf9', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 6, '{"file_name":"secret","sharer_name":"Jane Smith","message":"File \'secret\' has been shared with you by Jane Smith."}', '2024-12-14 15:32:53', '2024-12-14 15:16:44', '2024-12-14 15:32:53'),
	('b5d4619e-2f8a-4e76-a8ce-ba3145b467e4', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"1. login.png","sharer_name":"erda","message":"File \'1. login.png\' has been shared with you by erda."}', '2024-11-17 12:41:12', '2024-11-17 12:37:15', '2024-11-17 12:41:12'),
	('cb80d712-d1be-4089-a456-04dfd75213d5', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (2).docx","sharer_name":"erda","message":"File \'FORM VALIDASI PRESTASI (KOUR. KMHS PRODI) (2).docx\' has been shared with you by erda."}', '2024-11-17 12:41:12', '2024-11-17 12:16:11', '2024-11-17 12:41:12'),
	('d002525c-5f67-461d-90c4-6c22e8c6a78e', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 6, '{"file_name":"folder","sharer_name":"Jane Smith","message":"File \'folder\' has been shared with you by Jane Smith."}', '2024-12-14 15:14:38', '2024-12-14 15:13:53', '2024-12-14 15:14:38'),
	('e5ff0000-a3f1-4cea-8112-b9c64f615840', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 2, '{"file_name":"coba","sharer_name":"erda","message":"File \'coba\' has been shared with you by erda."}', NULL, '2024-11-17 04:35:11', '2024-11-17 04:35:11'),
	('f675931b-fd57-4bba-8e00-49bbbf0850ce', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 3, '{"file_name":"LEMBAR PENGESAHAN.docx","sharer_name":"erda","message":"File \'LEMBAR PENGESAHAN.docx\' has been shared with you by erda."}', '2024-12-14 14:54:17', '2024-12-14 14:52:58', '2024-12-14 14:54:17'),
	('fdb88c1b-c29d-4e16-9237-1e63608317eb', 'App\\Notifications\\FileSharedNotification', 'App\\Models\\User', 5, '{"file_name":"ini","sharer_name":"erda","message":"File \'ini\' has been shared with you by erda."}', NULL, '2024-11-17 12:35:35', '2024-11-17 12:35:35');

-- membuang struktur untuk table file-manager-2.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.password_resets: ~0 rows (lebih kurang)
DELETE FROM `password_resets`;

-- membuang struktur untuk table file-manager-2.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.password_reset_tokens: ~0 rows (lebih kurang)
DELETE FROM `password_reset_tokens`;

-- membuang struktur untuk table file-manager-2.pegawai
CREATE TABLE IF NOT EXISTS `pegawai` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pegawai_department_id_foreign` (`department_id`),
  CONSTRAINT `pegawai_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.pegawai: ~5 rows (lebih kurang)
DELETE FROM `pegawai`;
INSERT INTO `pegawai` (`id`, `name`, `department_id`, `phone_number`, `address`, `position`, `created_at`, `updated_at`) VALUES
	(1, 'John Doe', 1, '123456789', '123 Main St', 'Staf', NULL, NULL),
	(2, 'Jane Smith', 2, '987654321', '456 Elm St', 'Ketua Departemen', NULL, NULL),
	(3, 'Alice Johnson', 3, '555123456', '789 Maple St', 'Staf', NULL, NULL),
	(4, 'Bob Brown', 4, '444987654', '321 Oak St', 'Staf', NULL, NULL),
	(5, 'erda', 1, '', '', '', '2024-11-17 04:30:47', '2024-11-17 04:30:47');

-- membuang struktur untuk table file-manager-2.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.personal_access_tokens: ~0 rows (lebih kurang)
DELETE FROM `personal_access_tokens`;

-- membuang struktur untuk table file-manager-2.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `pegawai_id` bigint unsigned DEFAULT NULL,
  `disk_space` double(8,2) NOT NULL DEFAULT '0.00',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Membuang data untuk tabel file-manager-2.users: ~6 rows (lebih kurang)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `pegawai_id`, `disk_space`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@example.com', NULL, '$2y$10$Nb2gPVGuL1y8SditcDADYOyJ1FFWf.ft8jkNf32gCCw0D4haCyECu', 'admin', NULL, 0.00, NULL, NULL, NULL, NULL),
	(2, 'John Doe', 'john@example.com', NULL, '$2y$10$A7hpM1myfmvOVH7w7ND9JeaXM.dUxfRQMrf29WWwijfzE85fBfu0u', 'pegawai', 1, 0.00, NULL, NULL, NULL, NULL),
	(3, 'Jane Smith', 'jane@example.com', NULL, '$2y$10$nrr8.7AfOfR0tpieCL7sBOYpxzi9fNdGVIKb22yPu4A6n.Z3U90CW', 'pegawai', 2, 0.00, NULL, NULL, NULL, NULL),
	(4, 'Alice Johnson', 'alice@example.com', NULL, '$2y$10$m0AjvPHPMR9Sk852A1CP4.r6BiKx/EInkRrdD92Tl3XjDz9iYpfQ.', 'pegawai', 3, 0.00, NULL, NULL, NULL, NULL),
	(5, 'Bob Brown', 'bob@example.com', NULL, '$2y$10$WTGg2wtqXAwFcv9qb4LQT.TgdueZv0dPikiPV6do8Q47ta1LeMlOy', 'pegawai', 4, 0.00, NULL, NULL, NULL, NULL),
	(6, 'erda', 'erda@gmail.com', NULL, '$2y$10$61bqycBCF34FZjC/70h42.3waOC61EF3wlDx5qaKKvMNwragITj0G', 'pegawai', 5, 100.00, NULL, NULL, '2024-11-17 04:30:47', '2024-11-17 04:30:47');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
