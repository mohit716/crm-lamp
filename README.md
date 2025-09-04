# CRM (LAMP Stack)

A lightweight CRM built with **PHP + MySQL** featuring:
- User authentication (register, login, logout) with `password_hash()`.
- Session management.
- CRUD for **Contacts** (scoped to the logged-in user).
- Basic CSRF protection on state-changing requests.
- Minimal Bootstrap UI via CDN.

> **Status**: Day‑1 baseline that runs end-to-end (auth + contacts CRUD).  
> Roadmap ideas are listed below to keep the repo credibly “in progress,” not abandoned.

---

## Quick Start

### 1) Requirements
- PHP 8+
- MySQL 5.7+/MariaDB 10.4+
- Apache (or any web server configured for PHP)
- Windows (XAMPP/WAMP) or macOS/Linux (MAMP/Homebrew/LAMP)

### 2) Create the DB
```sql
-- Create database and tables
-- You can also use migrations/001_init.sql
CREATE DATABASE crm_lamp DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
```

Then run the migration:
```bash
mysql -u root -p crm_lamp < migrations/001_init.sql
```

### 3) Configure DB credentials
Copy `inc/config.php`, update the placeholders:
```php
// inc/config.php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'crm_lamp');
define('DB_USER', 'root');
define('DB_PASS', 'your_mysql_password');
define('APP_BASE_URL', '/'); // Adjust if not at web root
```

### 4) Serve the app
Point your web root to the `public/` folder (recommended).  
On XAMPP: copy this folder into `htdocs/crm-lamp` and visit `http://localhost/crm-lamp/`.

---

## Default Flow
1. Register a user (email + password).
2. Log in.
3. Create Contacts (name, email, phone, company, notes).
4. Edit/Delete your own contacts only.

---

## Security Notes
- Uses **PDO** + prepared statements (no string concatenation)  
- Passwords stored via `password_hash()` / `password_verify()`  
- CSRF token on POST forms for create/edit/delete  
- Output escaped with `htmlspecialchars()`

> For production, add HTTPS, SameSite cookies, stricter cookie flags, and rate limiting.

---

## Roadmap (To keep the repo realistically “in progress”)
- Pagination & searching on contacts
- Company & Deal entities (simple pipeline stages)
- Import from CSV
- Simple role/permission levels (owner vs member)
- Docker dev stack (compose) + PHPUnit tests
- REST API endpoints (token auth)

---

## Structure
```
crm-lamp/
├── inc/
│   ├── auth.php
│   ├── config.php
│   ├── csrf.php
│   ├── db.php
│   ├── flash.php
│   ├── footer.php
│   └── header.php
├── migrations/
│   └── 001_init.sql
└── public/
    ├── index.php
    ├── login.php
    ├── logout.php
    ├── register.php
    └── contacts/
        ├── create.php
        ├── delete.php
        ├── edit.php
        └── list.php
```

---

## License
MIT
