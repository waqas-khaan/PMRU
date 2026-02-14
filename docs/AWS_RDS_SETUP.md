# AWS RDS MySQL Setup Guide – School System

This guide walks you through creating a MySQL database on AWS RDS and connecting the school-system Laravel app (all four module databases).

---

## 1. Create an RDS MySQL instance

### 1.1 Open RDS in AWS Console

1. Log in to [AWS Console](https://console.aws.amazon.com/).
2. Go to **RDS** (search "RDS" or under **Database**).
3. Click **Create database**.

### 1.2 Choose engine and template

- **Engine type:** MySQL (e.g. MySQL 8.0).
- **Templates:**
  - **Production** – Multi-AZ, higher availability.
  - **Dev/Test** – Single instance, lower cost.
  - **Free tier** – Only if your account is eligible.

### 1.3 Settings

- **DB instance identifier:** e.g. `school-system-db`.
- **Master username:** e.g. `admin` (or keep `admin`).
- **Master password:** Set a strong password and store it securely (you'll use it in `.env`).

### 1.4 Instance configuration

- **Instance class:** e.g. `db.t3.micro` (free tier) or `db.t3.small` for light production.
- **Storage:**
  - Type: e.g. **gp3**.
  - Allocate at least **20 GB** (or more for growth).
  - Enable **Storage autoscaling** and set a max limit if you want.

### 1.5 Connectivity

- **VPC:** Default VPC (or your app's VPC).
- **Subnet group:** Default (or your preferred).
- **Public access:**
  - **Yes** if your app or laptop is on the internet (dev / small setups).
  - **No** if the app runs only inside AWS (e.g. EC2 in same VPC).
- **VPC security group:** Create new or select existing. You will need to allow **inbound**:
  - **Type:** MySQL/Aurora
  - **Port:** 3306
  - **Source:**
    - Your IP (for dev) or
    - EC2 security group / CIDR of your app server (for production).
- **Availability Zone:** No preference (or choose one).
- **Database port:** 3306.

### 1.6 Database options

- **Initial database name:** Leave **blank** (we create all four databases in **Section 3**). If you prefer, you can set it to `school_auth_db` and then create only the other three in Section 3.
- **DB parameter group:** Default.
- **Option group:** Default.
- **Enable automated backups:** Yes (recommended).
- **Encryption:** Enable if you need encryption at rest.

Click **Create database** and wait until status is **Available**. Note the **Endpoint** (hostname).

---

## 2. Get RDS endpoint and connection details

Once your instance is **Available** (e.g. identifier `school-system-db`), you need its **Endpoint** to connect—not the instance name.

1. In RDS console, click your **DB instance** (e.g. `school-system-db`).
2. Copy from the **Connectivity & security** tab:
   - **Endpoint** (e.g. `school-system-db.xxxxxx.us-east-1.rds.amazonaws.com`) → this is what you use as `DB_HOST` in `.env` and in `mysql -h`.
   - **Port** (usually 3306).
3. You already have:
   - **Master username** and **Master password** from creation.

Use the **Endpoint** value everywhere the guide says `YOUR_RDS_ENDPOINT` or `your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com`.

---

## 3. Create the 4 separate databases (one per module)

You use **one RDS MySQL instance** and **four separate databases** on it—one for each module. Each database is independent (separate tables, no shared data).

| # | Database name             | Module   | Purpose |
|---|---------------------------|----------|---------|
| 1 | `school_auth_db`          | Auth     | Users, sessions, cache, queue, jobs |
| 2 | `school_students_db`      | Students | Students, guardians |
| 3 | `school_academics_db`     | Academics| Classes, subjects, timetable (future) |
| 4 | `school_finance_exams_db` | Finance  | Fees, exams, results (future) |

**Important:** AWS RDS "Create database" creates the **MySQL server (instance)**. The **databases** inside it you create with SQL below. If you set **Initial database name** to `school_auth_db` in step 1.6, **school_auth_db is already created**—create only the other three (Database 2, 3, 4 below).

### Step 3.1 – Connect to your RDS instance

**Option A – MySQL command line**

From your machine (install MySQL client if needed: `brew install mysql-client` on Mac):

```bash
mysql -h YOUR_RDS_ENDPOINT -P 3306 -u admin -p
```

Enter the master password. You should see the `mysql>` prompt.

**Option B – Using phpMyAdmin (on your PC)**

1. Open phpMyAdmin in your browser.
2. Click **Add** (or **New**) to add a new server, or use the **Login** form if it supports multiple servers.
3. Enter:
   - **Server / Host:** your RDS **Endpoint** (e.g. `school-system-db.xxxxxx.eu-north-1.rds.amazonaws.com`)
   - **Port:** `3306`
   - **Username:** your RDS master username (e.g. `admin`)
   - **Password:** your RDS master password
4. Click **Go** to connect. You should see the server in the left sidebar (no databases yet, or only `school_auth_db` if you set it at creation).

### Step 3.2 – Create each database

If **school_auth_db is already created** (e.g. you set it as Initial database name), create only these three:

```sql
CREATE DATABASE IF NOT EXISTS school_students_db      CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS school_academics_db     CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS school_finance_exams_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

If you need to create all four from scratch, run:

```sql
CREATE DATABASE IF NOT EXISTS school_auth_db          CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS school_students_db      CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS school_academics_db     CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS school_finance_exams_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Use the exact names above so they match your `.env`.

**phpMyAdmin:** After connecting to the RDS server, open the **Databases** tab (or **New** in the sidebar). Create each database with name exactly as above and collation **utf8mb4_unicode_ci**. Or use the **SQL** tab (with no database selected), paste the `CREATE DATABASE` lines above, and click **Go**.

### Step 3.3 – Verify the 4 databases

**Command line:** In the MySQL prompt, run `SHOW DATABASES;` — you should see all four. Then type `exit`.

**phpMyAdmin:** In the left sidebar you should see `school_auth_db`, `school_students_db`, `school_academics_db`, `school_finance_exams_db`.

---

## 4. Run the module SQL scripts

Run each script **in the correct database** so tables are created in the right place.

**Option A – MySQL command line** (from project root):

```bash
# Replace ENDPOINT, USER with your RDS endpoint and username

mysql -h ENDPOINT -P 3306 -u USER -p school_auth_db          < database/sql/01_auth_module.sql
mysql -h ENDPOINT -P 3306 -u USER -p school_students_db      < database/sql/02_students_module.sql
mysql -h ENDPOINT -P 3306 -u USER -p school_academics_db     < database/sql/03_academics_module.sql
mysql -h ENDPOINT -P 3306 -u USER -p school_finance_exams_db < database/sql/04_finance_exams_module.sql
```

**Option B – Using phpMyAdmin**

1. In the left sidebar, click **school_auth_db**.
2. Open the **Import** (or **SQL**) tab.
3. Either:
   - **Import:** Choose file `database/sql/01_auth_module.sql` from your project, then click **Go**.
   - **SQL:** Open `01_auth_module.sql` in a text editor, copy all content, paste into the SQL box, then click **Go**.
4. Repeat for the other three: select **school_students_db** → import or paste `02_students_module.sql`; then **school_academics_db** → `03_academics_module.sql`; then **school_finance_exams_db** → `04_finance_exams_module.sql`.

After each import, check the **Structure** tab to confirm the tables were created.

---

## 5. (Optional) SSL for RDS

If RDS enforces or supports SSL:

1. Download the RDS CA bundle (e.g. from [AWS RDS CA docs](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/UsingWithRDS.SSL.html)).
2. Save it in the project, e.g. `storage/app/rds-ca.pem`.
3. In `.env` set:
   ```env
   MYSQL_ATTR_SSL_CA=/absolute/path/to/your/project/storage/app/rds-ca.pem
   ```
   (Use the path where you saved the PEM file.)

`config/database.php` already passes this into the MySQL options for each connection.

---

## 6. Add database config to the project (`.env`)

Copy `.env.example` to `.env` if you haven't already, then set DB variables.

**Single RDS instance (one host, four databases):**

```env
# ======================
# Default / Auth Module DB (RDS)
# ======================
DB_CONNECTION=mysql_auth
DB_HOST=your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com
DB_PORT=3306
DB_DATABASE=school_auth_db
DB_USERNAME=admin
DB_PASSWORD=your_rds_master_password

# Auth connection (uses above by default; set explicitly for RDS)
DB_AUTH_HOST=your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com
DB_AUTH_PORT=3306
DB_AUTH_DATABASE=school_auth_db
DB_AUTH_USERNAME=admin
DB_AUTH_PASSWORD=your_rds_master_password

# ======================
# Students Module DB (same RDS)
# ======================
DB_STUDENTS_HOST=your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com
DB_STUDENTS_PORT=3306
DB_STUDENTS_DATABASE=school_students_db
DB_STUDENTS_USERNAME=admin
DB_STUDENTS_PASSWORD=your_rds_master_password

# ======================
# Academics Module DB (same RDS)
# ======================
DB_ACADEMICS_HOST=your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com
DB_ACADEMICS_PORT=3306
DB_ACADEMICS_DATABASE=school_academics_db
DB_ACADEMICS_USERNAME=admin
DB_ACADEMICS_PASSWORD=your_rds_master_password

# ======================
# Finance / Exams Module DB (same RDS)
# ======================
DB_FINANCE_HOST=your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com
DB_FINANCE_PORT=3306
DB_FINANCE_DATABASE=school_finance_exams_db
DB_FINANCE_USERNAME=admin
DB_FINANCE_PASSWORD=your_rds_master_password
```

Replace:

- `your-rds-endpoint.xxxxxx.us-east-1.rds.amazonaws.com` → your RDS **Endpoint**.
- `your_rds_master_password` → your RDS master password.

If you use **different RDS instances** per module, set each module's `DB_*_HOST` (and port/user/pass) to that instance's endpoint and credentials.

---

## 7. Verify from the app

```bash
php artisan config:clear
php artisan db:show
php artisan db:show --database=mysql_auth
php artisan db:show --database=mysql_students
```

If you use migrations instead of the SQL files, run them **per connection** (e.g. with a custom artisan command or by setting default connection and running migrate for each DB). The SQL scripts in `database/sql/` are ready to use on a fresh RDS and avoid migration order issues.

---

## 8. Security checklist

- Restrict **security group** to your app server IP or security group (avoid 0.0.0.0/0 in production).
- Use a **strong master password**; consider a secrets manager for production.
- Prefer **private subnet** and **no public access** when the app runs in the same VPC.
- Enable **encryption at rest** and **SSL (TLS)** for RDS if required by your policy.
- Never commit `.env` or real passwords to git.

---

## Quick reference – DB ↔ files

| Module   | Database name             | SQL file                                  | Laravel connection   |
|----------|---------------------------|-------------------------------------------|----------------------|
| Auth     | school_auth_db            | `database/sql/01_auth_module.sql`         | mysql_auth           |
| Students | school_students_db        | `database/sql/02_students_module.sql`     | mysql_students       |
| Academics| school_academics_db       | `database/sql/03_academics_module.sql`    | mysql_academics      |
| Finance  | school_finance_exams_db   | `database/sql/04_finance_exams_module.sql` | mysql_finance        |

Use the same RDS endpoint and port for all; only the database name (and optionally user/password) changes per module in `.env`.
