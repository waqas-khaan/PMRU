-- Run this on database: school_students_db (connection: mysql_students)
-- Choose ONE of the options below.

-- Option A: Make first_name nullable (keeps column name; app will still send first_name/last_name from full_name)
ALTER TABLE students MODIFY COLUMN first_name VARCHAR(255) NULL;

-- Option B: Rename first_name to full_name (matches form/controller; recommended)
ALTER TABLE students CHANGE COLUMN first_name full_name VARCHAR(255) NOT NULL;

-- If your table also has last_name and you use Option B, you may drop or keep it:
-- ALTER TABLE students DROP COLUMN last_name;
