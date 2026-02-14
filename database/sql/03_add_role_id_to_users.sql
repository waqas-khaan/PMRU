-- ============================================================
-- Add role_id to users table (school_auth_db)
-- Run this on the auth database after roles table exists.
-- ============================================================

USE school_auth_db;

-- Add role_id column and foreign key to roles(id)
ALTER TABLE `users`
  ADD COLUMN `role_id` BIGINT UNSIGNED NULL AFTER `password`,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Optional: backfill from role_user pivot (one role per user)
-- UPDATE users u
-- INNER JOIN role_user ru ON ru.user_id = u.id
-- SET u.role_id = ru.role_id;
