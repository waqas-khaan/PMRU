-- ============================================================
-- School System - STUDENTS MODULE
-- Database: school_students_db (connection: mysql_students)
-- Run this on the database used for students and guardians.
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- Guardians
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Students (references guardians; app also supports full_name)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` text,
  `guardian_id` bigint unsigned DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_email_unique` (`email`),
  KEY `students_guardian_id_index` (`guardian_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: if your app uses "full_name" (and first_name/last_name), run after table creation:
-- ALTER TABLE students ADD COLUMN full_name VARCHAR(255) NULL AFTER name;
-- ALTER TABLE students ADD COLUMN first_name VARCHAR(255) NULL AFTER full_name;
-- ALTER TABLE students ADD COLUMN last_name VARCHAR(255) NULL AFTER first_name;
-- Then backfill: UPDATE students SET full_name = name WHERE full_name IS NULL;

-- ------------------------------------------------------------
-- Migration tracking (if you run migrations on this connection)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
