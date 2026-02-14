# Finance & Exams Module

Uses database **school_finance_exams_db** (Laravel connection: `mysql_finance`).  
`student_id` in `fee_payments` and `exam_results` references `students.id` in **school_students_db** (cross-DB; no FK).

## Run migrations

Create the database (e.g. in MySQL Workbench) or ensure it exists, then:

```bash
php artisan migrate --database=mysql_finance --path=Modules/Finance/database/migrations
```

## Routes (prefix: `/finance`)

- `GET /finance` — Dashboard
- Academic years, Terms, Fee types, Fee structures, Fee payments, Exams, Exam results — full CRUD

## .env

Ensure `config/database.php` has the `mysql_finance` connection and set:

- `DB_FINANCE_DATABASE=school_finance_exams_db`
- (Optional) `DB_FINANCE_HOST`, `DB_FINANCE_USERNAME`, `DB_FINANCE_PASSWORD` if different from default.
