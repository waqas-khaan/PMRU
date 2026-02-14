-- ============================================================
-- Delete all data: Students, Academics, Finance (module data only)
-- Run this on your current MySQL connection (e.g. RDS).
-- Does NOT touch Auth DB (users, sessions, etc.).
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- 1. STUDENTS MODULE (school_students_db)
-- ------------------------------------------------------------
USE school_students_db;

TRUNCATE TABLE `students`;
TRUNCATE TABLE `guardians`;
-- TRUNCATE TABLE `migrations`;

-- ------------------------------------------------------------
-- 2. ACADEMICS MODULE (school_academics_db)
-- ------------------------------------------------------------
USE school_academics_db;

TRUNCATE TABLE `timetable_slots`;
TRUNCATE TABLE `class_subjects`;
TRUNCATE TABLE `sections`;
TRUNCATE TABLE `classes`;
TRUNCATE TABLE `subjects`;
TRUNCATE TABLE `terms`;
TRUNCATE TABLE `academic_years`;
-- TRUNCATE TABLE `migrations`;

-- ------------------------------------------------------------
-- 3. FINANCE MODULE (school_finance_exams_db)
-- ------------------------------------------------------------
USE school_finance_exams_db;

TRUNCATE TABLE `exam_results`;
TRUNCATE TABLE `exams`;
TRUNCATE TABLE `fee_payments`;
TRUNCATE TABLE `fee_structures`;
TRUNCATE TABLE `fee_types`;
TRUNCATE TABLE `terms`;
TRUNCATE TABLE `academic_years`;
-- TRUNCATE TABLE `migrations`;

SET FOREIGN_KEY_CHECKS = 1;
