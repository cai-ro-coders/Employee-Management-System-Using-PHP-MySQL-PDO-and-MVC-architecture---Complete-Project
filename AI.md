AI

Employee Management System Using PHP MySQL PDO and MVC architecture - Complete Project

Build a Complete Admin Employee Management System 
MVC Architecture PHP, MySQL PDO for database operations, Bootstrap 5, HTML5, CSS3, JavaScript, jQuery, AJAX, Font Awesome, SweetAlert2, 
DataTables, Chart.js 
follow modern PHP best practices using PDO and MVC architecture with Secure coding practices
MySQL database : 
database name : EMS_db
username : root
password : root

Employee Management System Database Schema

users
    id (PK)
    role_id (FK → roles.id)
    first_name
    last_names
    username
    email
    password
    phone
    avatar
    address
    status
    last_login
    remember_token
    created_at
    updated_at

roles
    id (PK)
    name (Admin, HR, Employee)
    description
    created_at
    updated_at

permissions
    id (PK)
    module_name
    action_name
    permission_key
    created_at

role_permissions
    role_id (FK → roles.id)
    permission_id (FK → permissions.id)

departments
    id (PK)
    name
    code
    status
    created_at
    updated_at

employees
    id (PK)
    user_id (FK → users.id)
    department_id (FK → departments.id)
    employee_code
    designation
    salary
    joining_date
    created_at
    updated_at

employee_documents
    id (PK)
    employee_id (FK → employees.id)
    document_title
    document_file
    file_type
    uploaded_at

employee_bank_details
    id (PK)
    employee_id (FK → employees.id)
    bank_name
    branch_name
    account_number
    account_title
    ifsc_swift_code
    tax_id_pan
    created_at
    updated_at

attendance
    id (PK)
    employee_id (FK → employees.id)
    date
    clock_in
    clock_out
    status
    notes
    created_at
    updated_at

leave_applications
    id (PK)
    employee_id (FK → employees.id)
    leave_type
    start_date
    end_date
    total_days
    reason
    status
    reviewed_by (FK → users.id)
    review_notes
    created_at
    updated_at

salaries
    id (PK)
    employee_id (FK → employees.id)
    basic_salary
    house_rent_allowance
    medical_allowance
    other_allowances
    pf_deduction_rate
    tax_deduction
    created_at
    updated_at

payslips
    id (PK)
    employee_id (FK → employees.id)
    payslip_number
    month
    year
    basic_salary
    total_allowances
    total_deductions
    pf_amount
    net_salary
    payment_status
    payment_date
    created_at

provident_funds
    id (PK)
    employee_id (FK → employees.id)
    payslip_id (FK → payslips.id)
    employee_contribution
    employer_contribution
    total_amount
    date_added
    created_at

expenses
    id (PK)
    title
    category
    amount
    expense_date
    purchased_by (FK → users.id)
    receipt_file
    status
    created_at

tasks
    id (PK)
    title
    description
    assigned_by (FK → users.id)
    assigned_to (FK → employees.id)
    due_date
    priority
    status
    created_at
    updated_at

notices
    id (PK)
    title
    content
    posted_by (FK → users.id)
    target_role_id (FK → roles.id)
    created_at
    updated_at

holidays
    id (PK)
    event_name
    start_date
    end_date
    description
    created_at

chat_messages
    id (PK)
    sender_id (FK → users.id)
    receiver_id (FK → users.id)
    message
    is_read
    created_at

menu_items
    id (PK)
    parent_id (FK → menu_items.id)
    title
    url
    icon_class
    permission_key
    sort_order
    is_active

Generate Realistic Data 50 records

Theme:

Modern
Professional
Mobile Friendly
Folder Structure

Generate complete MVC folder structure:

project/
│
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── helpers/
│
├── config/
├── public/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
│
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
├── vendor/
└── index.php

Develop a responsive web application with a modern dashboard and clean user interface.

Authentication Module

Implement:

- Login
- Logout
- Remember Me
- Forgot Password
- Reset Password
- Change Password
- Role Based Access Control (RBAC)
- Login History
- Secure Login
- User Profile Management
- Password hashing using password_hash()
- CSRF protection
- XSS Protection
- Session management
- SQL injection protection using PDO prepared statements
- Input validation and sanitization

Dashboard
Create an attractive Bootstrap dashboard showing:

Features:
- Total Customers
- Total employees
- Montly Pay
- Leave Applied
- Leave Approved
- Leave Pending
- Leave Rejected
- Employees on leave today
- Recent Activities
- Notifications
- Total Revenue
- Live Activity Feed

Use Chart.js for all charts.
------------------------------------

User Management

- CRUD Users
- Roles
- Permissions
- User Activity Log
- User Status
- User Profile Picture

Roles:

- Super Admin
- Admin
- Manager
- Support Staff

------------------------------------

Customer Module

Customer CRUD

Fields:

- Customer ID
- First Name
- Last Name
- Company
- Email
- Phone
- Mobile
- Website
- Industry
- Customer Type
- Status
- Address
- City
- State
- Country
- Postal Code
- Notes
- Profile Image

Features:

- Search
- Filter
- Pagination
- DataTables
- AJAX CRUD
- Soft Delete
- Customer Timeline
- Customer Notes
- Customer Documents
- Customer Tags
------------------------------------
Email Module
Email Templates
Bulk Email
SMTP Configuration
Email Logs
------------------------------------
Reports Module
Generate reports:
Export:
PDF
Excel
CSV
------------------------------------
Notification System
Toast Notifications
Email Notifications
SMS Ready
In-app Notifications
------------------------------------
File Manager
Upload Documents
Images
------------------------------------
Settings Module
Company Settings
SMTP Settings
Currency
Language
Timezone
Theme
Logo
Backup
------------------------------------
Audit Logs
Track:
Login
Logout
CRUD Operations
Role Changes
Deleted Records
------------------------------------
Database
Generate normalized MySQL database.
Include:
- Foreign Keys
- Indexes
- Constraints
- Seed Data
------------------------------------
Coding Standards
Use:
- SOLID Principles
- DRY
- KISS
- PSR Standards
- Repository Pattern where appropriate
- Services Layer
- Helper Functions
- Reusable Components
------------------------------------
AJAX
Use AJAX for:
- CRUD Operations
- Search
- Pagination
- Filters
- Status Updates
- Notifications
- File Uploads
------------------------------------
Professional Admin Dashboard
Responsive
Mobile Friendly
Dark Mode Ready
Loading Spinners
Skeleton Loaders
Modern Cards
Beautiful Tables
Animations
Hover Effects
Bootstrap Modals
------------------------------------
DataTables
Include:
Server-side Processing
Sorting
Searching
Filtering
Export Buttons
Print
CSV
Excel
PDF
------------------------------------
SweetAlert2
Use for:
Delete Confirmation
Success Messages
Errors
Warnings
Confirmations
------------------------------------

Sidebar Menu Structure
Dashboard

Employee Management
    ├── All Employees
    ├── Add Employee
    ├── Employee Documents
    └── Bank & Payment Info

Organization
    ├── Departments
    └── Company Holidays

Time & Attendance
    ├── Daily Attendance
    ├── Attendance Logs
    └── Leave Applications

Payroll & Finance
    ├── Salary Structure
    ├── Generate Payslips
    ├── Provident Funds (PF)
    └── Company Expenses

Workplace & Communication
    ├── Task Board
    ├── Notice Board
    └── Internal Chat

User & Security Access
    ├── Manage Users
    ├── Roles & Permissions
    ├── Notifications
    └── Backups

Settings
    ├── Company Settings
    ├── General Settings
    ├── Email (SMTP)
    ├── Currency
    ├── Appearance
    ├── Integrations
    └── System Information

Account Settings
    ├── My Profile 
    └── Logout