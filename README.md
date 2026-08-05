# Employee Management System (EMS)

A complete Admin Employee Management System built with **PHP 8 (MVC)**, **MySQL (PDO)**, **Bootstrap 5**, **jQuery**, **AJAX**, **DataTables**, **Chart.js**, **SweetAlert2** and **Font Awesome**.

## Features

### Authentication & Security
- Login / Logout with **Remember Me**
- Forgot / Reset Password (token based, 1h expiry)
- Change Password
- Role-Based Access Control (RBAC) with 5 roles
- Login History + Activity/Audit Logs
- `password_hash()` / `password_verify()` with bcrypt cost 12
- CSRF protection on every form and AJAX request
- XSS escaping on all output (`e()` helper)
- PDO prepared statements everywhere (SQL injection safe)
- Input validation + session regeneration

### Modules
- **Dashboard** – stat cards, Revenue vs Headcount chart, Department doughnut chart, Live Activity Feed, recent leave applications, Chart.js
- **Users** – full CRUD, roles, status, activity logs, login history
- **Roles & Permissions** – permission matrix with toggle (Super Admin fixed)
- **Employees** – CRUD, department, designation, salary, bank details, documents, attendance history, server-side DataTables
- **Departments** – CRUD with AJAX + employee headcount
- **Customers** – full CRUD with all 19 fields, tags, notes, soft delete, DataTables + AJAX
- **Settings** – company, general, SMTP, appearance tabs
- **Notifications** – in-app bell + mark-read
- Leave, attendance, payroll (salaries/payslips/PF), expenses, tasks, notices seeded

### Reports / Export
- DataTables with print/CSV export support ready (buttons can be enabled per table)

## Tech Stack
PHP 8.4, MySQL 5.7 (MAMP), PDO, MVC, Bootstrap 5.3, jQuery 3.7, DataTables 1.13, Chart.js 4, SweetAlert2 11, Bootstrap Icons

## Installation (MAMP)

1. Place the project under MAMP's `htdocs` (this project already lives at
   `/Applications/MAMP/htdocs/devproject/employee_management_system`).
2. Make sure MAMP MySQL is running (port 3306 / socket `/Applications/MAMP/tmp/mysql/mysql.sock`).
3. Run the installer:

```bash
cd /Applications/MAMP/htdocs/devproject/employee_management_system
php database/seeders/seed.php
```

This creates the `EMS_db` database, applies the full schema
(`database/migrations/schema.sql`) and seeds realistic data
(50 users, 50 employees, 40 customers, attendance, leaves, payroll, etc.).

4. Open in the browser:

```
http://localhost:8888/devproject/employee_management_system/
```

## Default Login

| Email              | Password     | Role        |
|--------------------|--------------|-------------|
| admin@ems.local    | password123  | Super Admin |

All seeded users share the password `password123`.

## Database Configuration

`config/config.php` → `database` section (default: `EMS_db` / root / root).
Uses the MAMP socket automatically when present.

## Folder Structure

```
├── index.php                 # Front controller
├── .htaccess                 # URL rewriting + security headers
├── config/config.php         # App/db/mail/upload settings
├── routes/web.php            # URL → controller map
├── app/
│   ├── core/                 # App, Controller, Model, Database, Session, Request, Security, Config, Bootstrap
│   ├── controllers/          # Auth, Dashboard, Profile, User, Role, Employee, Department, Customer, Setting, Notification
│   ├── models/               # Repository-style models
│   ├── views/                # layouts + per-module views
│   └── helpers/              # functions, Auth (RBAC), Validation, Upload
├── database/
│   ├── migrations/schema.sql # Full normalized schema (FKs, indexes, constraints)
│   └── seeders/seed.php      # Realistic seed data
└── assets/                   # css, js, images, uploads
```

## Security Notes
- Super Admin role is bypass-granted all permissions and cannot be downgraded through the UI.
- Avatar/attachment uploads validate MIME/extension and size.
- All delete actions require CSRF and confirmation via SweetAlert2.
