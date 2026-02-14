-- ============================================================
-- MODULE 4: FINANCE / EXAMS (complete clean schema)
-- Database: school_finance_exams_db (Laravel connection: mysql_finance)
-- Run this file in MySQL Workbench to create DB + all tables.
-- student_id references students.id in school_students_db (same server).
-- ============================================================

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS school_finance_exams_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE school_finance_exams_db;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- Academic years (for fee/exam context; can sync with academics DB)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `academic_years` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Terms (e.g. Term 1, Term 2) for fees and exams
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `terms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `terms_academic_year_id_index` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Fee types (e.g. Tuition, Transport, Lab, Library)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `fee_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Fee structure: amount per fee_type per term (optional: per class)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `fee_structures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL,
  `fee_type_id` bigint unsigned NOT NULL,
  `class_name` varchar(255) DEFAULT NULL COMMENT 'e.g. Class 1, Grade 10; NULL = applies to all',
  `amount` decimal(12, 2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_structures_term_id_index` (`term_id`),
  KEY `fee_structures_fee_type_id_index` (`fee_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Fee payments (student_id = students.id in school_students_db)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `fee_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL COMMENT 'References students.id in school_students_db',
  `fee_structure_id` bigint unsigned NOT NULL,
  `amount` decimal(12, 2) NOT NULL,
  `paid_at` date NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_payments_student_id_index` (`student_id`),
  KEY `fee_payments_fee_structure_id_index` (`fee_structure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Exams (e.g. Mid-term, Final; link to term/class/subject if needed)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `exams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL COMMENT 'Optional: filter by class',
  `subject_name` varchar(255) DEFAULT NULL COMMENT 'Optional: filter by subject',
  `total_marks` decimal(8, 2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exams_term_id_index` (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Exam results (student_id = students.id in school_students_db)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `exam_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL COMMENT 'References students.id in school_students_db',
  `marks` decimal(8, 2) NOT NULL,
  `grade` varchar(20) DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_results_exam_id_student_id_unique` (`exam_id`, `student_id`),
  KEY `exam_results_student_id_index` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Migration tracking (Laravel)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
