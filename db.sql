# ************************************************************
# Sequel Ace SQL dump
# Version 20064
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 8.3.0)
# Database: absensi_larav8
# Generation Time: 2024-07-31 11:34:59 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis_file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `fileUpload` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table ijins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ijins`;

CREATE TABLE `ijins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `jenis_ijin_id` bigint unsigned NOT NULL,
  `nama_ijin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_ijin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_ijin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jenis_ijins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jenis_ijins`;

CREATE TABLE `jenis_ijins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table lemburs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lemburs`;

CREATE TABLE `lemburs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `long_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jarak_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_jam_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_keluar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_keluar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_keluar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak_keluar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_jam_keluar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_lembur` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lemburs_approved_by_foreign` (`approved_by`),
  CONSTRAINT `lemburs_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table lokasis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lokasis`;

CREATE TABLE `lokasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat_kantor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_kantor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radius` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lokasis_created_by_foreign` (`created_by`),
  CONSTRAINT `lokasis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `lokasis` WRITE;
/*!40000 ALTER TABLE `lokasis` DISABLE KEYS */;

INSERT INTO `lokasis` (`id`, `nama_lokasi`, `lat_kantor`, `long_kantor`, `radius`, `status`, `created_by`, `created_at`, `updated_at`)
VALUES
	(1,'Kantor Cabang A','-6.3707314','106.8138057','200','approved',1,'2024-07-03 12:05:02','2024-07-03 12:05:02');

/*!40000 ALTER TABLE `lokasis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mapping_shifts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mapping_shifts`;

CREATE TABLE `mapping_shifts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `shift_id` bigint unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_absen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_absen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_absen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak_masuk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_jam_absen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_masuk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulang_cepat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_jam_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_absen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lock_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_masuk_pengajuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_pulang_pengajuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pengajuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_pengajuan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `komentar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mapping_shifts_approved_by_foreign` (`approved_by`),
  CONSTRAINT `mapping_shifts_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_roles_table',1),
	(2,'2014_10_12_000001_create_users_table',1),
	(3,'2014_10_12_100000_create_password_resets_table',1),
	(4,'2019_08_19_000000_create_failed_jobs_table',1),
	(5,'2019_12_14_000001_create_personal_access_tokens_table',1),
	(6,'2022_09_16_095447_create_shifts_table',1),
	(7,'2022_09_19_032649_create_mapping_shifts_table',1),
	(8,'2022_09_20_074944_create_lemburs_table',1),
	(9,'2022_09_20_092230_create_cutis_table',1),
	(10,'2022_10_31_083510_create_lokasis_table',1),
	(11,'2022_11_02_061554_create_reset_cutis_table',1),
	(12,'2023_06_28_042019_create_files_table',1),
	(13,'2024_06_15_075202_create_notifications_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table personal_access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`)
VALUES
	(1,'admin','2024-07-03 12:05:02','2024-07-03 12:05:02'),
	(2,'user','2024-07-03 12:05:02','2024-07-03 12:05:02');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shifts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shifts`;

CREATE TABLE `shifts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_shift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_keluar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;

INSERT INTO `shifts` (`id`, `nama_shift`, `jam_masuk`, `jam_keluar`, `created_at`, `updated_at`)
VALUES
	(1,'Libur','00:00','00:00','2024-07-03 12:05:02','2024-07-03 12:05:02'),
	(2,'Pagi','08:00','17:00','2024-07-03 12:05:02','2024-07-03 12:05:02'),
	(3,'Siang','13:00','21:00','2024-07-03 12:05:02','2024-07-03 12:05:02'),
	(4,'Malam','21:00','05:00','2024-07-03 12:05:02','2024-07-10 15:41:47');

/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `npk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_karyawan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_join` date DEFAULT NULL,
  `status_nikah` enum('menikah','jomblo') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `lokasi_id` bigint unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `id_role` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_npk_unique` (`npk`),
  KEY `users_id_role_foreign` (`id_role`),
  CONSTRAINT `users_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `npk`, `name`, `foto_karyawan`, `email`, `telepon`, `username`, `password`, `tgl_lahir`, `gender`, `tgl_join`, `status_nikah`, `alamat`, `lokasi_id`, `email_verified_at`, `id_role`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'Admin',NULL,'admin@gmail.com','082343435456','admin','$2y$10$nz2zCgeb56D6BrV1WwbdW.lRB0RoLhSh.fWlhfpiqF536/hP2wfj6','2000-02-29','L','2024-07-01','menikah','Jln - jln',1,NULL,1,'q7rORg0zDEgL1SoPRbFYO03XxqsEGUIzDET2ckCBqocmkGWwIQAblqD1HmjI','2024-07-03 12:05:02','2024-07-10 16:16:22');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
