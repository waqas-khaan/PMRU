-- ============================================================
-- Queries for current database schema
-- Auth (mysql_auth): users, roles, role_user, sessions, cache, jobs, etc.
-- Default DB: guardians, students
-- Use with MySQL; for SQLite remove backticks and adjust AUTO_INCREMENT.
-- ============================================================

-- ---------------------------------------------------------------------------
-- AUTH (run against school_auth_db / connection mysql_auth)
-- ---------------------------------------------------------------------------

-- All users with their role name
SELECT u.id, u.name, u.email, u.email_verified_at, r.name AS role_name
FROM users u
LEFT JOIN roles r ON r.id = u.role_id
ORDER BY u.id;

-- All roles
SELECT id, name, description, created_at FROM roles ORDER BY id;

-- Users by role (via role_user if using pivot)
-- SELECT u.id, u.name, u.email, r.name AS role_name
-- FROM users u
-- INNER JOIN role_user ru ON ru.user_id = u.id
-- INNER JOIN roles r ON r.role_id = ru.role_id;

-- Active sessions
SELECT id, user_id, ip_address, last_activity FROM sessions ORDER BY last_activity DESC;

-- Pending queue jobs
SELECT id, queue, attempts, available_at, created_at FROM jobs ORDER BY id;

-- Failed jobs
SELECT id, uuid, queue, failed_at FROM failed_jobs ORDER BY failed_at DESC;

-- ---------------------------------------------------------------------------
-- DEFAULT DB (guardians, students)
-- ---------------------------------------------------------------------------

-- All guardians
SELECT id, name, email, phone, relationship, address, created_at FROM guardians ORDER BY id;

-- All students with guardian name
SELECT s.id, s.name, s.email, s.phone, s.date_of_birth, s.gender, s.class, s.section, s.enrollment_date,
       g.name AS guardian_name, g.phone AS guardian_phone
FROM students s
LEFT JOIN guardians g ON g.id = s.guardian_id
ORDER BY s.id;

-- Students without a guardian
SELECT id, name, email, class, section FROM students WHERE guardian_id IS NULL;

-- Count students per class
SELECT class, COUNT(*) AS total FROM students WHERE class IS NOT NULL GROUP BY class ORDER BY class;

-- ---------------------------------------------------------------------------
-- USEFUL FILTERS / UPDATES (examples)
-- ---------------------------------------------------------------------------

-- Find user by email
-- SELECT * FROM users WHERE email = 'admin@example.com';

-- Find students by guardian id
-- SELECT * FROM students WHERE guardian_id = 1;

-- List migration batch (default connection)
-- SELECT * FROM migrations ORDER BY batch DESC, id DESC;
