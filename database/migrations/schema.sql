-- =========================================================================
-- EMS_db - Employee Management System
-- Full normalized schema: Foreign Keys, Indexes, Constraints
-- MySQL 5.7 / utf8mb4
-- =========================================================================

CREATE DATABASE IF NOT EXISTS `EMS_db`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `EMS_db`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `activity_logs`, `chat_messages`, `holidays`, `notices`, `tasks`,
    `expenses`, `provident_funds`, `payslips`, `salaries`, `leave_applications`,
    `attendance`, `employee_bank_details`, `employee_documents`, `employees`,
    `customers`, `customer_tag`, `customer_tags`, `customer_documents`, `customer_notes`,
    `departments`, `role_permissions`, `permissions`, `roles`,
    `login_history`, `notifications`, `settings`, `menu_items`, `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- -------------------------------------------------------------------------
-- roles
-- -------------------------------------------------------------------------
CREATE TABLE `roles` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(50)  NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_roles_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- users
-- -------------------------------------------------------------------------
CREATE TABLE `users` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `role_id`        INT UNSIGNED NOT NULL,
    `first_name`     VARCHAR(50)  NOT NULL,
    `last_name`      VARCHAR(50)  NOT NULL,
    `username`       VARCHAR(50)  NOT NULL,
    `email`          VARCHAR(100) NOT NULL,
    `password`       VARCHAR(255) NOT NULL,
    `phone`          VARCHAR(20)  DEFAULT NULL,
    `avatar`         VARCHAR(255) DEFAULT NULL,
    `address`        VARCHAR(255) DEFAULT NULL,
    `status`         ENUM('active','inactive','suspended') NOT NULL DEFAULT 'active',
    `last_login`     DATETIME     DEFAULT NULL,
    `remember_token` VARCHAR(255) DEFAULT NULL,
    `password_reset_token` VARCHAR(255) DEFAULT NULL,
    `password_reset_expires` DATETIME DEFAULT NULL,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email` (`email`),
    UNIQUE KEY `uq_users_username` (`username`),
    KEY `idx_users_role` (`role_id`),
    CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- permissions & role_permissions
-- -------------------------------------------------------------------------
CREATE TABLE `permissions` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `module_name`   VARCHAR(50)  NOT NULL,
    `action_name`   VARCHAR(50)  NOT NULL,
    `permission_key` VARCHAR(100) NOT NULL,
    `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_permissions_key` (`permission_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_permissions` (
    `role_id`       INT UNSIGNED NOT NULL,
    `permission_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    KEY `idx_rp_permission` (`permission_id`),
    CONSTRAINT `fk_rp_role`       FOREIGN KEY (`role_id`)       REFERENCES `roles` (`id`)       ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_rp_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- departments
-- -------------------------------------------------------------------------
CREATE TABLE `departments` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(100) NOT NULL,
    `code`       VARCHAR(20)  NOT NULL,
    `status`     ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_departments_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- employees
-- -------------------------------------------------------------------------
CREATE TABLE `employees` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`       INT UNSIGNED NOT NULL,
    `department_id` INT UNSIGNED NOT NULL,
    `employee_code` VARCHAR(20)  NOT NULL,
    `designation`   VARCHAR(100) DEFAULT NULL,
    `salary`        DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `joining_date`  DATE         DEFAULT NULL,
    `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_employees_code` (`employee_code`),
    KEY `idx_emp_user` (`user_id`),
    KEY `idx_emp_dept` (`department_id`),
    CONSTRAINT `fk_emp_user` FOREIGN KEY (`user_id`)       REFERENCES `users` (`id`)       ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_emp_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- employee_documents
-- -------------------------------------------------------------------------
CREATE TABLE `employee_documents` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`    INT UNSIGNED NOT NULL,
    `document_title` VARCHAR(150) NOT NULL,
    `document_file`  VARCHAR(255) NOT NULL,
    `file_type`      VARCHAR(20)  DEFAULT NULL,
    `uploaded_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_empdoc_employee` (`employee_id`),
    CONSTRAINT `fk_empdoc_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- employee_bank_details
-- -------------------------------------------------------------------------
CREATE TABLE `employee_bank_details` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`    INT UNSIGNED NOT NULL,
    `bank_name`      VARCHAR(100) DEFAULT NULL,
    `branch_name`    VARCHAR(100) DEFAULT NULL,
    `account_number` VARCHAR(50)  DEFAULT NULL,
    `account_title`  VARCHAR(150) DEFAULT NULL,
    `ifsc_swift_code` VARCHAR(30) DEFAULT NULL,
    `tax_id_pan`     VARCHAR(30)  DEFAULT NULL,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_bank_employee` (`employee_id`),
    CONSTRAINT `fk_bank_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- attendance
-- -------------------------------------------------------------------------
CREATE TABLE `attendance` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id` INT UNSIGNED NOT NULL,
    `date`        DATE         NOT NULL,
    `clock_in`    TIME         DEFAULT NULL,
    `clock_out`   TIME         DEFAULT NULL,
    `status`      ENUM('present','absent','on_leave','half_day') NOT NULL DEFAULT 'present',
    `notes`       VARCHAR(255) DEFAULT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_attendance_emp_date` (`employee_id`, `date`),
    KEY `idx_att_date` (`date`),
    CONSTRAINT `fk_att_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- leave_applications
-- -------------------------------------------------------------------------
CREATE TABLE `leave_applications` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`  INT UNSIGNED NOT NULL,
    `leave_type`   ENUM('sick','casual','annual','maternity','paternity','unpaid') NOT NULL DEFAULT 'casual',
    `start_date`   DATE         NOT NULL,
    `end_date`     DATE         NOT NULL,
    `total_days`   INT UNSIGNED NOT NULL DEFAULT 1,
    `reason`       TEXT         DEFAULT NULL,
    `status`       ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `reviewed_by`  INT UNSIGNED DEFAULT NULL,
    `review_notes` VARCHAR(255) DEFAULT NULL,
    `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_leave_emp` (`employee_id`),
    KEY `idx_leave_status` (`status`),
    CONSTRAINT `fk_leave_employee` FOREIGN KEY (`employee_id`)  REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_leave_reviewer` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`)      ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- salaries
-- -------------------------------------------------------------------------
CREATE TABLE `salaries` (
    `id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`        INT UNSIGNED NOT NULL,
    `basic_salary`       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `house_rent_allowance` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `medical_allowance`  DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `other_allowances`   DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `pf_deduction_rate`  DECIMAL(5,2)  NOT NULL DEFAULT 12.00,
    `tax_deduction`      DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `created_at`         TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_salary_employee` (`employee_id`),
    CONSTRAINT `fk_salary_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- payslips
-- -------------------------------------------------------------------------
CREATE TABLE `payslips` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`     INT UNSIGNED NOT NULL,
    `payslip_number`  VARCHAR(30)  NOT NULL,
    `month`           TINYINT UNSIGNED NOT NULL,
    `year`            SMALLINT UNSIGNED NOT NULL,
    `basic_salary`    DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `total_allowances` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `total_deductions` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `pf_amount`       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `net_salary`      DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `payment_status`  ENUM('paid','unpaid','partial') NOT NULL DEFAULT 'unpaid',
    `payment_date`    DATE         DEFAULT NULL,
    `created_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_payslip_number` (`payslip_number`),
    KEY `idx_payslip_emp_month` (`employee_id`, `month`, `year`),
    CONSTRAINT `fk_payslip_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- provident_funds
-- -------------------------------------------------------------------------
CREATE TABLE `provident_funds` (
    `id`                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`          INT UNSIGNED NOT NULL,
    `payslip_id`           INT UNSIGNED NOT NULL,
    `employee_contribution` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `employer_contribution` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `total_amount`         DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `date_added`           DATE         NOT NULL,
    `created_at`           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_pf_emp` (`employee_id`),
    KEY `idx_pf_payslip` (`payslip_id`),
    CONSTRAINT `fk_pf_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_pf_payslip`  FOREIGN KEY (`payslip_id`)  REFERENCES `payslips`  (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- expenses
-- -------------------------------------------------------------------------
CREATE TABLE `expenses` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`        VARCHAR(150) NOT NULL,
    `category`     VARCHAR(100) DEFAULT NULL,
    `amount`       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `expense_date` DATE         NOT NULL,
    `purchased_by` INT UNSIGNED DEFAULT NULL,
    `receipt_file` VARCHAR(255) DEFAULT NULL,
    `status`       ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_expense_date` (`expense_date`),
    KEY `idx_expense_by` (`purchased_by`),
    CONSTRAINT `fk_expense_user` FOREIGN KEY (`purchased_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- tasks
-- -------------------------------------------------------------------------
CREATE TABLE `tasks` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(150) NOT NULL,
    `description` TEXT         DEFAULT NULL,
    `assigned_by` INT UNSIGNED DEFAULT NULL,
    `assigned_to` INT UNSIGNED DEFAULT NULL,
    `due_date`    DATE         DEFAULT NULL,
    `priority`    ENUM('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
    `status`      ENUM('todo','in_progress','done') NOT NULL DEFAULT 'todo',
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_task_assignee` (`assigned_to`),
    KEY `idx_task_status` (`status`),
    CONSTRAINT `fk_task_by`  FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`)     ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_task_to`  FOREIGN KEY (`assigned_to`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- notices
-- -------------------------------------------------------------------------
CREATE TABLE `notices` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`          VARCHAR(150) NOT NULL,
    `content`        TEXT         NOT NULL,
    `posted_by`      INT UNSIGNED DEFAULT NULL,
    `target_role_id` INT UNSIGNED DEFAULT NULL,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_notice_role` (`target_role_id`),
    CONSTRAINT `fk_notice_user` FOREIGN KEY (`posted_by`)      REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_notice_role` FOREIGN KEY (`target_role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- holidays
-- -------------------------------------------------------------------------
CREATE TABLE `holidays` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_name`  VARCHAR(150) NOT NULL,
    `start_date`  DATE         NOT NULL,
    `end_date`    DATE         DEFAULT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_holiday_start` (`start_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- chat_messages
-- -------------------------------------------------------------------------
CREATE TABLE `chat_messages` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sender_id`   INT UNSIGNED NOT NULL,
    `receiver_id` INT UNSIGNED NOT NULL,
    `message`     TEXT         NOT NULL,
    `is_read`     TINYINT(1)   NOT NULL DEFAULT 0,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_chat_sender` (`sender_id`),
    KEY `idx_chat_receiver` (`receiver_id`),
    CONSTRAINT `fk_chat_sender`   FOREIGN KEY (`sender_id`)   REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_chat_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- menu_items
-- -------------------------------------------------------------------------
CREATE TABLE `menu_items` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `parent_id`     INT UNSIGNED DEFAULT NULL,
    `title`         VARCHAR(100) NOT NULL,
    `url`           VARCHAR(255) DEFAULT NULL,
    `icon_class`    VARCHAR(50)  DEFAULT NULL,
    `permission_key` VARCHAR(100) DEFAULT NULL,
    `sort_order`    INT          NOT NULL DEFAULT 0,
    `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY `idx_menu_parent` (`parent_id`),
    CONSTRAINT `fk_menu_parent` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- customers
-- -------------------------------------------------------------------------
CREATE TABLE `customers` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name`     VARCHAR(50)  NOT NULL,
    `last_name`      VARCHAR(50)  NOT NULL,
    `company`        VARCHAR(100) DEFAULT NULL,
    `email`          VARCHAR(100) DEFAULT NULL,
    `phone`          VARCHAR(20)  DEFAULT NULL,
    `mobile`         VARCHAR(20)  DEFAULT NULL,
    `website`        VARCHAR(150) DEFAULT NULL,
    `industry`       VARCHAR(80)  DEFAULT NULL,
    `customer_type`  ENUM('individual','business') NOT NULL DEFAULT 'individual',
    `status`         ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `address`        VARCHAR(255) DEFAULT NULL,
    `city`           VARCHAR(80)  DEFAULT NULL,
    `state`          VARCHAR(80)  DEFAULT NULL,
    `country`        VARCHAR(80)  DEFAULT NULL,
    `postal_code`    VARCHAR(20)  DEFAULT NULL,
    `notes`          TEXT         DEFAULT NULL,
    `profile_image`  VARCHAR(255) DEFAULT NULL,
    `deleted_at`     DATETIME     DEFAULT NULL,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_customer_name` (`last_name`, `first_name`),
    KEY `idx_customer_email` (`email`),
    KEY `idx_customer_status` (`status`),
    KEY `idx_customer_deleted` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- customer_notes & customer_documents (timeline support)
-- -------------------------------------------------------------------------
CREATE TABLE `customer_notes` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_id` INT UNSIGNED NOT NULL,
    `user_id`     INT UNSIGNED DEFAULT NULL,
    `note`        TEXT         NOT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_cnote_customer` (`customer_id`),
    CONSTRAINT `fk_cnote_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_cnote_user`     FOREIGN KEY (`user_id`)     REFERENCES `users` (`id`)     ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer_documents` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_id` INT UNSIGNED NOT NULL,
    `title`       VARCHAR(150) NOT NULL,
    `file_path`   VARCHAR(255) NOT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_cdoc_customer` (`customer_id`),
    CONSTRAINT `fk_cdoc_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer_tags` (
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50)  NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_ctag_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `customer_tag` (
    `customer_id` INT UNSIGNED NOT NULL,
    `tag_id`      INT UNSIGNED NOT NULL,
    PRIMARY KEY (`customer_id`, `tag_id`),
    KEY `idx_ctag` (`tag_id`),
    CONSTRAINT `fk_ctag_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_ctag_tag`      FOREIGN KEY (`tag_id`)      REFERENCES `customer_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- notifications & settings
-- -------------------------------------------------------------------------
CREATE TABLE `notifications` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT UNSIGNED NOT NULL,
    `title`       VARCHAR(150) NOT NULL,
    `message`     TEXT         NOT NULL,
    `type`        VARCHAR(30)  NOT NULL DEFAULT 'info',
    `is_read`     TINYINT(1)   NOT NULL DEFAULT 0,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_notif_user` (`user_id`, `is_read`),
    CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `settings` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `setting_key`   VARCHAR(100) NOT NULL,
    `setting_value` TEXT         DEFAULT NULL,
    `group_name`    VARCHAR(50)  DEFAULT 'general',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_settings_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- login_history & activity_logs
-- -------------------------------------------------------------------------
CREATE TABLE `login_history` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED DEFAULT NULL,
    `ip_address` VARCHAR(45)  DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `status`     ENUM('success','failed') NOT NULL DEFAULT 'success',
    `message`    VARCHAR(255) DEFAULT NULL,
    `login_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_login_user` (`user_id`),
    KEY `idx_login_date` (`login_at`),
    CONSTRAINT `fk_login_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `activity_logs` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT UNSIGNED DEFAULT NULL,
    `action`      VARCHAR(50)  NOT NULL,
    `module`      VARCHAR(50)  NOT NULL,
    `description` VARCHAR(500) DEFAULT NULL,
    `ip_address`  VARCHAR(45)  DEFAULT NULL,
    `user_agent`  VARCHAR(255) DEFAULT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_act_user` (`user_id`),
    KEY `idx_act_module` (`module`),
    KEY `idx_act_date` (`created_at`),
    CONSTRAINT `fk_act_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
