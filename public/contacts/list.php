<?php
require_once __DIR__ . '/../../inc/header.php';
require_once __DIR__ . '/../../inc/auth.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/flash.php';

require_login();
$user = current_user();
$pdo = pdo_conn();

$stmt = $pdo->prepare("SELECT * FROM contacts WHERE user_id = :u ORDER BY created_at DESC");
$stmt->execute([':u' => $user['id']]);
$contacts = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Your Contacts</h2>
  <a href="<?= APP_BASE_URL ?>contacts/create.php" class="btn btn-primary">+ New Contact</a>
</div>

<?php if (!$contacts): ?>
  <div class="alert alert-info">No contacts yet. Click "New Contact" to add one.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr>
        <th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Added</th><th style="width:150px">Actions</th>
      </tr></thead>
      <tbody>
        <?php foreach ($contacts as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
            <td><?= htmlspecialchars($c['phone'] ?? '') ?></td>
            <td><?= htmlspecialchars($c['company'] ?? '') ?></td>
            <td><?= htmlspecialchars($c['created_at']) ?></td>
            <td>
              <a class="btn btn-sm btn-outline-secondary" href="<?= APP_BASE_URL ?>contacts/edit.php?id=<?= (int)$c['id'] ?>">Edit</a>
              <form action="<?= APP_BASE_URL ?>contacts/delete.php" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this contact?');">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>" />
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../inc/footer.php'; ?>
