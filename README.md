# Portfolio Hub

A PHP web app for building and sharing professional resumes. Users register, fill out their profile, and get a public resume page anyone can view with no login required.

## Features

- Public resume directory - browse all registered users on the landing page
- User accounts - register, log in, log out
- Resume editor - update name, email, phone, location, bio, skills, education, experience, and projects
- Public resume page - shareable link for each user at `public_resume.php?id={id}`
- Input sanitization and session-based auth throughout

## Stack

- **Backend:** PHP (no framework)
- **Database:** PostgreSQL (via `pg_connect`)
- **Frontend:** Vanilla CSS + JavaScript

## File Overview

| File | Purpose |
|---|---|
| `index.php` | Public landing page; lists all users with name, location, bio preview, and skills |
| `register.php` | New user registration |
| `login.php` | Session-based login |
| `logout.php` | Destroys session and redirects |
| `portfolio.php` | Logged-in dashboard |
| `edit_resume.php` | Resume editor form (requires login) |
| `public_resume.php` | Public-facing resume view for any user |
| `config.php` | DB connection, session start, shared helper functions |
| `style.css` | All styles |
| `portfolio.js` | Frontend interactions |
| `validation.js` | Client-side form validation |

## Setup

**Requirements:** PHP with the `pgsql` extension, PostgreSQL.

1. Clone the repo.

2. Create a PostgreSQL database named `portfolio_db`.

3. Create the `users` table:

```sql
CREATE TABLE users (
  id        SERIAL PRIMARY KEY,
  full_name TEXT NOT NULL,
  email     TEXT UNIQUE NOT NULL,
  phone     TEXT,
  location  TEXT,
  bio       TEXT,
  skills    TEXT,
  education TEXT,
  experience TEXT,
  projects  TEXT,
  password  TEXT NOT NULL,
  created_at TIMESTAMPTZ DEFAULT NOW()
);
```

4. Update credentials in `config.php` if your PostgreSQL setup differs from the defaults (`postgres`/`postgres` on port `5432`).

5. Serve the project from a web server with PHP support (Apache, Nginx, or `php -S localhost:8000` for local dev).

## Configuration

All database settings live in `config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'postgres');
define('DB_PASS', 'postgres');
define('DB_PORT', '5432');
```

## Security Notes

- Passwords should be hashed with `password_hash()` before storing - verify your `register.php` does this before deploying.
- `config.php` contains plaintext database credentials. Keep it out of version control in production or use environment variables.
- The app uses parameterized queries (`pg_query_params`) to prevent SQL injection.
- User input is sanitized via `htmlspecialchars` + `strip_tags` on all form fields.

## License

MIT
