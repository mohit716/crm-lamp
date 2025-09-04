<?php
require_once __DIR__ . '/../../inc/auth.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/csrf.php';
require_once __DIR__ . '/../../inc/flash.php';
require_once __DIR__ . '/../../inc/config.php';

require_login();
csrf_verify();
$user = current_user();
$pdo = pdo_conn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id AND user_id = :u");
    $stmt->execute([':id' => $id, ':u' => $user['id']]);
    set_flash('success', 'Contact deleted.');
}
header('Location: ' . APP_BASE_URL . 'contacts/list.php');
exit;
