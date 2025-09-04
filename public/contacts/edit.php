<?php
require_once __DIR__ . '/../../inc/header.php';
require_once __DIR__ . '/../../inc/auth.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/csrf.php';
require_once __DIR__ . '/../../inc/flash.php';

require_login();
$user = current_user();
$pdo = pdo_conn();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id AND user_id = :u LIMIT 1");
$stmt->execute([':id' => $id, ':u' => $user['id']]);
$contact = $stmt->fetch();
if (!$contact) {
    set_flash('error', 'Contact not found.');
    header('Location: ' . APP_BASE_URL . 'contacts/list.php');
    exit;
}

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
        $stmt2 = $pdo->prepare("UPDATE contacts SET name=:n, email=:e, phone=:p, company=:c, notes=:no WHERE id=:id AND user_id=:u");
        $stmt2->execute([
            ':n' => $name,
            ':e' => $email ?: null,
            ':p' => $phone ?: null,
            ':c' => $company ?: null,
            ':no' => $notes ?: null,
            ':id' => $id,
            ':u' => $user['id']
        ]);
        set_flash('success', 'Contact updated.');
        header('Location: ' . APP_BASE_URL . 'contacts/list.php');
        exit;
    }
}
?>
<h2>Edit Contact</h2>
<form method="POST">
  <?= csrf_input() ?>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Name *</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($contact['name']) ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Company</label>
      <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($contact['company'] ?? '') ?>">
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($contact['notes'] ?? '') ?></textarea>
  </div>
  <button class="btn btn-primary">Save Changes</button>
  <a href="<?= APP_BASE_URL ?>contacts/list.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require_once __DIR__ . '/../../inc/footer.php'; ?>
