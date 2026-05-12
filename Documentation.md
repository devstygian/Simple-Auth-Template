# Simple-Auth-Template — Full Documentation

This document covers everything you need to know about **Simple-Auth-Template** — from project structure and database setup, to how each file works and how to extend the system.

---

## Table of Contents

1. [Overview](#overview)
2. [Repository Structure](#repository-structure)
3. [File Reference](#file-reference)
4. [Database Schema](#database-schema)
5. [Configuration](#configuration)
6. [Auth Flow (Detailed)](#auth-flow-detailed)
7. [Core Functions](#core-functions)
8. [Pages & Routes](#pages--routes)
9. [Session Management](#session-management)
10. [Security Practices](#security-practices)
11. [UI & Styling](#ui--styling)
12. [Extending the Template](#extending-the-template)
13. [Common Errors & Fixes](#common-errors--fixes)
14. [FAQ](#faq)

---

## Overview

**Simple-Auth-Template** is a plain PHP + MySQL authentication starter kit. It provides the minimum viable auth system — register, login, session guard, and logout — in a clean folder structure that's easy to read, customize, and scale.

It does **not** use any PHP framework. Everything is written in procedural PHP with a lightweight MVC-lite organization, making it beginner-friendly while still being structured enough for real projects.

---

## Repository Structure

```
Simple-Auth-Template/
│
├── public/                  # Entry point — all browser-accessible files
│   ├── index.php            # Landing / redirect page
│   ├── login.php            # Login page
│   ├── register.php         # Registration page
│   ├── dashboard.php        # Protected page (requires login)
│   ├── logout.php           # Destroys session and redirects
│   └── assets/
│       ├── css/             # Stylesheets
│       ├── js/              # JavaScript files
│       └── img/             # Images / icons
│
├── includes/                # Core backend logic (not browser-accessible)
│   ├── db.php               # Database connection
│   ├── auth.php             # Auth functions (login, register, guard)
│   ├── config.php           # App configuration (DB credentials, constants)
│   └── functions.php        # General helper functions
│
├── templates/               # Shared HTML partials
│   ├── header.php           # HTML head + navbar
│   └── footer.php           # Closing tags + scripts
│
├── database/
│   └── schema.sql           # MySQL table definitions
│
├── README.md
├── DOCUMENTATION.md
├── LICENSE
└── .gitignore
```

> **Note:** Only the `public/` folder should be the web root. The `includes/` and `templates/` folders are intentionally kept outside to prevent direct browser access.

---

## File Reference

### `includes/config.php`
Stores all global configuration constants. This is the first file you should edit after cloning.

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'simple_auth');
define('BASE_URL', 'http://localhost/Simple-Auth-Template/public');
?>
```

---

### `includes/db.php`
Handles the MySQL database connection using `mysqli`. It uses the constants defined in `config.php`.

```php
<?php
require_once 'config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

---

### `includes/auth.php`
The heart of the system. Contains all authentication logic:

- `register_user($username, $email, $password)` — validates and saves a new user
- `login_user($email, $password)` — checks credentials and starts a session
- `is_logged_in()` — returns `true` if a valid session exists
- `auth_guard()` — redirects to login if user is not authenticated
- `logout_user()` — destroys the session and redirects

---

### `includes/functions.php`
General-purpose helper functions used across the app. Examples:

- `sanitize($input)` — strips and escapes user input
- `redirect($url)` — shorthand for `header("Location: ...")` + `exit`
- `set_flash($type, $message)` — stores a one-time session message
- `get_flash($type)` — retrieves and clears the flash message

---

### `templates/header.php`
Included at the top of every page. Contains the `<head>` block, meta tags, CSS links, and the navigation bar. Modify this to change the global layout or add Bootstrap/Font Awesome CDN links.

---

### `templates/footer.php`
Included at the bottom of every page. Contains closing `</body>` and `</html>` tags, and any global JS script tags.

---

## Database Schema

The system uses a single `users` table.

```sql
CREATE DATABASE IF NOT EXISTS simple_auth;

USE simple_auth;

CREATE TABLE users (
    id          INT(11) AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Column Breakdown

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT, PK, AUTO_INCREMENT | Unique identifier for each user |
| `username` | VARCHAR(100) | Display name chosen during registration |
| `email` | VARCHAR(150), UNIQUE | Used as the login identifier |
| `password` | VARCHAR(255) | Bcrypt-hashed password (never plain text) |
| `created_at` | TIMESTAMP | Auto-set when the record is created |

> **Never store plain text passwords.** Simple-Auth-Template uses PHP's `password_hash()` with the `PASSWORD_BCRYPT` algorithm by default.

---

## Configuration

After cloning, open `includes/config.php` and update the following:

| Constant | Default | Description |
|----------|---------|-------------|
| `DB_HOST` | `localhost` | Your MySQL server host |
| `DB_USER` | `root` | MySQL username |
| `DB_PASS` | *(empty)* | MySQL password |
| `DB_NAME` | `simple_auth` | Name of your database |
| `BASE_URL` | `http://localhost/...` | Full base URL of the project |

---

## Auth Flow (Detailed)

### Registration Flow

```
User fills register form
        ↓
Client-side validation (v2+)
        ↓
Server receives POST data
        ↓
sanitize() cleans all inputs
        ↓
Check if email already exists in DB
        ↓ (if exists → show error)
password_hash() hashes the password
        ↓
INSERT new user into `users` table
        ↓
Redirect to login with success message
```

---

### Login Flow

```
User fills login form
        ↓
Server receives POST data
        ↓
sanitize() cleans inputs
        ↓
SELECT user WHERE email = input
        ↓ (if not found → show error)
password_verify() checks hash against input
        ↓ (if mismatch → show error)
$_SESSION['user_id'] and ['username'] are set
        ↓
Redirect to dashboard
```

---

### Auth Guard Flow

```
User requests a protected page (e.g. dashboard.php)
        ↓
auth_guard() is called at the top of the page
        ↓
Checks if $_SESSION['user_id'] is set
        ↓ (if not set → redirect to login.php)
Page loads normally
```

---

### Logout Flow

```
User clicks logout
        ↓
logout.php is loaded
        ↓
session_unset() clears session variables
        ↓
session_destroy() destroys the session
        ↓
Redirect to login.php
```

---

## Core Functions

### `register_user($username, $email, $password)`
Registers a new user. Returns `true` on success or an error string on failure.

```php
$result = register_user('john', 'john@email.com', 'secret123');
if ($result === true) {
    redirect(BASE_URL . '/login.php');
} else {
    echo $result; // Error message
}
```

---

### `login_user($email, $password)`
Verifies credentials and starts a session. Returns `true` on success or an error string.

```php
$result = login_user('john@email.com', 'secret123');
if ($result === true) {
    redirect(BASE_URL . '/dashboard.php');
}
```

---

### `auth_guard()`
Call this at the very top of any page that requires a logged-in user. If the session is missing, it redirects immediately.

```php
<?php
require_once '../includes/auth.php';
auth_guard(); // Redirects to login if not authenticated
?>
```

---

### `is_logged_in()`
Returns a boolean. Useful for conditionally showing UI elements (e.g. hiding the login button if already logged in).

```php
if (is_logged_in()) {
    echo "Welcome back!";
}
```

---

## Pages & Routes

| File | URL | Access | Description |
|------|-----|--------|-------------|
| `index.php` | `/` | Public | Landing page, redirects based on session |
| `register.php` | `/register.php` | Public | New user registration form |
| `login.php` | `/login.php` | Public | Login form |
| `dashboard.php` | `/dashboard.php` | Protected | Main page after login |
| `logout.php` | `/logout.php` | Protected | Destroys session, redirects to login |

---

## Session Management

Sessions are PHP native (`$_SESSION`). The following keys are used:

| Key | Set When | Value |
|-----|----------|-------|
| `$_SESSION['user_id']` | Login success | User's `id` from DB |
| `$_SESSION['username']` | Login success | User's `username` from DB |
| `$_SESSION['flash']` | After form actions | Temporary status messages |

Sessions are destroyed completely on logout via `session_unset()` + `session_destroy()`.

---

## Security Practices

Simple-Auth-Template follows these security principles out of the box:

| Practice | How It's Applied |
|----------|-----------------|
| **Password Hashing** | `password_hash()` with `PASSWORD_BCRYPT` |
| **Input Sanitization** | `sanitize()` wraps `htmlspecialchars()` + `trim()` |
| **No Plain Text Passwords** | Passwords are never stored or logged as plain text |
| **Session-based Auth** | No tokens stored in URLs or cookies manually |
| **Protected Routes** | `auth_guard()` must be called on every protected page |

### What's NOT included (yet) — planned for v2+

- CSRF token protection on forms
- Rate limiting on login attempts
- Prepared statements (recommended upgrade — replace `mysqli_query` with `mysqli_prepare`)
- HTTPS enforcement

> **Recommended:** Switch all raw `mysqli_query()` calls to **prepared statements** before deploying to production. This prevents SQL injection.

---

## UI & Styling

The base template uses plain HTML and CSS. To upgrade the UI:

### Adding Bootstrap

In `templates/header.php`, add inside `<head>`:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
```

And before `</body>` in `templates/footer.php`:

```html
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
```

### Adding Font Awesome

In `templates/header.php`, add inside `<head>`:

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
```

---

## Extending the Template

### Adding a New Protected Page

1. Create `public/your-page.php`
2. Add `auth_guard()` at the top
3. Include header and footer templates

```php
<?php
require_once '../includes/auth.php';
auth_guard();
require_once '../templates/header.php';
?>

<h1>Your Page</h1>

<?php require_once '../templates/footer.php'; ?>
```

---

### Adding a New Database Column

1. Run the ALTER query in phpMyAdmin or CLI:

```sql
ALTER TABLE users ADD COLUMN profile_pic VARCHAR(255) DEFAULT NULL;
```

2. Update `register_user()` in `auth.php` to include the new field in the INSERT query.

---

### Adding Roles (v3 Preview)

Add a `role` column to the users table:

```sql
ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user';
```

Then create a role guard function in `auth.php`:

```php
function admin_guard() {
    auth_guard();
    if ($_SESSION['role'] !== 'admin') {
        redirect(BASE_URL . '/dashboard.php');
    }
}
```

---

## Common Errors & Fixes

| Error | Likely Cause | Fix |
|-------|-------------|-----|
| `Connection failed` | Wrong DB credentials | Check `config.php` values |
| Blank page after login | Session not starting | Add `session_start()` at top of `auth.php` |
| Redirect loop on dashboard | `auth_guard()` misconfigured | Make sure `session_start()` runs before the guard check |
| `Call to undefined function` | Missing `require_once` | Ensure `auth.php` is included on the page |
| Password always wrong | Hashing issue | Make sure you're hashing on register, not on login |

---

## FAQ

**Q: Can I use this with a framework like Laravel?**
Yes, but you'd essentially be replacing most of the logic. The roadmap includes an optional Laravel conversion in v4 for those who want to migrate.

**Q: Is this safe for production?**
The core is a solid starting point, but before going live you should add CSRF protection, use prepared statements everywhere, and enforce HTTPS. See the [Security Practices](#security-practices) section.

**Q: Can I add OAuth (Google/GitHub login)?**
Not out of the box, but it's a great v3/v4 contribution idea. You'd add a `provider` and `provider_id` column to the users table and handle the OAuth callback in a new file.

**Q: Why no framework?**
By design. Simple-Auth-Template is meant to be readable and educational. Anyone who knows basic PHP can understand and modify it without needing to learn a framework first.

---

*Documentation maintained by the Simple-Auth-Template contributors. For issues or suggestions, open a GitHub Issue.*