<?php
// Update these for your local DB.
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'crm_lamp');
define('DB_USER', 'root');
define('DB_PASS', ''); // ← set your password
// If your app is hosted in a subfolder, set base URL like '/crm-lamp/'
define('APP_BASE_URL', '/');
// Enable in dev to see errors
ini_set('display_errors', 1);
error_reporting(E_ALL);
