<?php
// Prevent multiple inclusions
if (!defined('CONFIG_LOADED')) {
    define('CONFIG_LOADED', true);

    // Database configuration for InfinityFree
    define('DB_HOST', 'sql105.infinityfree.com'); // InfinityFree database host
    define('DB_NAME', 'if0_39079519_test');    // Your database name from InfinityFree
    define('DB_USER', 'if0_39079519');         // Your database username from InfinityFree
    define('DB_PASS', 'password');         // Your database password from InfinityFree

    // API configuration
    define('API_VERSION', '1.0');
    define('ALLOWED_ORIGINS', [
        'http://localhost:8080',
        'http://binusgat.rf.gd',
        'https://binusgat.rf.gd'
    ]);

    // Security configuration
    define('PASSWORD_MIN_LENGTH', 6);
    define('MAX_LOGIN_ATTEMPTS', 5);
    define('LOGIN_TIMEOUT_MINUTES', 15);
}
?> 