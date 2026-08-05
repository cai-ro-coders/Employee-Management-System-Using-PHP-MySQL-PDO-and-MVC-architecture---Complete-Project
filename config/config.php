<?php
declare(strict_types=1);

/**
 * Application Configuration
 * DB: EMS_db / root / root (MAMP MySQL)
 */

return [
    'app' => [
        'name'        => 'Employee Management System',
        'short_name'  => 'EMS',
        'url'         => 'http://localhost:8888/devproject/employee_management_system',
        'env'         => 'development',
        'timezone'    => 'Asia/Manila',
        'version'     => '1.0.0',
        'debug'       => true,
        'session_name'=> 'EMS_SESSION',
        'session_lifetime' => 7200,
    ],

    'database' => [
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'socket'   => '/Applications/MAMP/tmp/mysql/mysql.sock',
        'database' => 'EMS_db',
        'username' => 'root',
        'password' => 'root',
        'charset'  => 'utf8mb4',
        'collation'=> 'utf8mb4_unicode_ci',
    ],

    'mail' => [
        'driver' => 'smtp',
        'host'   => '',
        'port'   => 587,
        'username' => '',
        'password' => '',
        'encryption' => 'tls',
        'from_email' => 'noreply@ems.local',
        'from_name'  => 'EMS Admin',
    ],

    'uploads' => [
        'path'      => __DIR__ . '/../assets/uploads/',
        'max_size'  => 5242880,
        'allowed'   => ['jpg','jpeg','png','gif','webp','pdf','doc','docx','xls','xlsx','txt','csv'],
    ],

    'security' => [
        'password_cost' => 12,
        'login_threshold' => 5,
        'login_lockout'   => 15,
    ],
];
