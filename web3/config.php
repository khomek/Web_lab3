<?php
// Конфигурация JWT
define('JWT_SECRET', 'galaktika_secret_key_2025_change_in_production');
define('JWT_ALGORITHM', 'HS256');
define('JWT_EXPIRE', 86400); // 24 часа

// Настройки базы данных
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'web_db');
define('DB_USER', 'postgres');
define('DB_PASS', 'postgres');
?>