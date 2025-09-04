<?php
require_once __DIR__ . '/../../inc/header.php';
require_once __DIR__ . '/../../inc/auth.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/csrf.php';
require_once __DIR__ . '/../../inc/flash.php';

require_login();
$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    if ($name === '') {
        set_flash('error', 'Name is required.');
    } else {
        $pdo = pdo_conn();
        $stmt = $pdo->prepare("INSERT INTO contacts (user_id, name, email, phone, company, notes) VALUES (:u, :n, :e, :p, :c, :no)");
        $stmt->execute([
            ':u' => $user['id'],
            ':n' => $name,
            ':e' => $email ?: null,
            ':p' => $phone ?: null,
            ':c' => $company ?: null,
            ':no' => $notes ?: null,
        ]);
        set_flash('success', 'Contact created.');
        header('Location: ' . APP_BASE_URL . 'contacts/list.php');
        exit;
    }
}
?>
<h2>New Contact</h2>
<form method="POST">
  <?= csrf_input() ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Name *</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Company</label>
      <input type="text" name="company" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3"></textarea>
  </div>
  <button class="btn btn-success">Create</button>
  <a href="<?= APP_BASE_URL ?>contacts/list.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require_once __DIR__ . '/../../inc/footer.php'; ?>
