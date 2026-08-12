# Simple-Auth-Template

**Simple-Auth-Template** is a clean, lightweight, and reusable PHP authentication system built as an open-source starter template for modern web applications. Whether you're spinning up a new project or learning how authentication works under the hood, this repo gives you a solid, production-ready foundation — no frameworks required.

![Status](https://img.shields.io/badge/status-in%20development-yellow)
![Type](https://img.shields.io/badge/type-open--source-blue)
![PHP](https://img.shields.io/badge/backend-PHP-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/database-MySQL-4479A1?logo=mysql)
![License](https://img.shields.io/badge/license-MIT-green)

---

## About

Simple-Auth-Template was created to solve a simple but repetitive problem: every project needs authentication, yet most developers end up rewriting the same login/register logic from scratch. This template eliminates that friction by giving you a clean, well-structured auth base you can clone, customize, and build on immediately.

It's purposely kept framework-free (plain PHP + MySQL) so it's easy to understand, easy to modify, and easy to integrate into any environment.

> For full documentation including repository structure, database schema, and advanced configuration — see the **[Wiki / Docs](https://github.com/yourname/Simple-Auth-Template/wiki)**.

---

## Tech Stack

| Layer     | Technology                                      |
|-----------|-------------------------------------------------|
| Frontend  | HTML, CSS, Bootstrap *(optional)*, Font Awesome |
| Backend   | PHP *(Procedural / MVC-lite)*                   |
| Database  | MySQL                                           |

---

## Core Features (MVP)

- ✅ User Registration
- ✅ User Login
- ✅ Password Hashing via `password_hash()` / `password_verify()`
- ✅ Session-based Authentication
- ✅ Protected Pages with Auth Guard
- ✅ Logout System

---

## Auth Flow

```
Register  →  Validate Input  →  Hash Password  →  Save to DB
Login     →  Check Credentials  →  Start Session
Request   →  Check Session Auth
Access    →  Allow / Redirect to Login
Logout    →  Destroy Session → Redirect
```

The flow is intentionally simple and transparent — no magic, no hidden middleware. Every step is readable and traceable in the source code.

---

## Setup Guide

### Prerequisites

- PHP 7.4+
- MySQL 5.7+ or MariaDB
- XAMPP / WAMP / Laragon (or any Apache local server)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/yourname/Simple-Auth-Template.git

# 2. Navigate into the project folder
cd Simple-Auth-Template

# 3. Import the database schema
#    Open phpMyAdmin and import: database/schema.sql
#    Or via CLI:
mysql -u root -p your_database_name < database/schema.sql

# 4. Configure your database connection
#    Edit includes/config.php and update your DB credentials

# 5. Run the project via XAMPP / Apache
#    Open your browser and go to:
http://localhost/Simple-Auth-Template/public
```

---

##  UI Stack (Optional Upgrade)

The core system works with plain HTML/CSS, but you can enhance it with:

- **Bootstrap** — for responsive layout and pre-built components
- **Font Awesome** — for clean UI icons (lock, user, envelope, etc.)

Simply link them via CDN in `templates/header.php` to get started.

---

## Roadmap

| Version | Features |
|---------|----------|
| **v1** *(current)* | Login system, Register system, Session Auth |
| **v2** | Form validation (client + server), Password reset, Email verification |
| **v3** | Role-based access (admin / user), Profile page |
| **v4** | REST API version, Optional Laravel conversion |

> Contributions targeting any of these milestones are very welcome!

---

## Contributing

This project is open-source and welcomes contributions of all kinds. Here's how to get involved:

1. Fork the repository
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m "Add: your feature description"`
4. Push to your branch: `git push origin feature/your-feature-name`
5. Open a Pull Request

Please keep code clean, readable, and consistent with the existing style. Bug reports and feature suggestions via Issues are also highly appreciated.

---

## License

This project is licensed under the **MIT License** — free to use, modify, and distribute. See the [LICENSE](LICENSE) file for details.

---

## Author

Built with by **lzynox**
- GitHub: [@devstygian](https://github.com/devstygian)

---

> **Simple-Auth-Template** — Built for developers who want a clean, simple, and reusable authentication foundation using PHP + MySQL. Star ⭐ the repo if you find it useful!
