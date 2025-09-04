<?php
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../inc/config.php';
logout_user();
header('Location: ' . APP_BASE_URL);
exit;
