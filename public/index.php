<?php
require_once __DIR__ . '/../inc/header.php';
if (is_logged_in()) {
    echo '<div class="p-4 bg-light rounded-3"><h1 class="display-6">Welcome back!</h1><p class="lead">Jump into your contacts.</p><a class="btn btn-primary" href="'.APP_BASE_URL.'contacts/list.php">Go to Contacts</a></div>';
} else {
    echo '<div class="p-4 bg-light rounded-3"><h1 class="display-6">Welcome to CRM</h1><p class="lead">Please log in or create an account to manage your contacts.</p><a class="btn btn-primary me-2" href="'.APP_BASE_URL.'login.php">Login</a><a class="btn btn-outline-secondary" href="'.APP_BASE_URL.'register.php">Register</a></div>';
}
require_once __DIR__ . '/../inc/footer.php';
