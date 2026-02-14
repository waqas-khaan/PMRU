# Academics Module

Uses database **school_academics_db** (Laravel connection: `mysql_academics`).

## Run migrations

Ensure the database exists, then:

```bash
php artisan migrate --database=mysql_academics --path=Modules/Academics/database/migrations
```

## Routes (prefix: `/academics`)

- `GET /academics` — Dashboard
- Academic years, Terms, Classes (school-classes), Sections, Subjects, Class–Subjects, Timetable slots — full CRUD

## .env

Set `DB_ACADEMICS_*` (or they fall back to `DB_*`). Example:

- `DB_ACADEMICS_DATABASE=school_academics_db`
- `DB_ACADEMICS_USERNAME=root`
- `DB_ACADEMICS_PASSWORD=...`
