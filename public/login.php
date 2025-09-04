<?php
require_once __DIR__ . '/../inc/header.php';
require_once __DIR__ . '/../inc/csrf.php';
require_once __DIR__ . '/../inc/flash.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (login_user($email, $password)) {
        set_flash('success', 'Logged in successfully.');
        header('Location: ' . APP_BASE_URL . 'contacts/list.php');
        exit;
    } else {
        set_flash('error', 'Invalid email or password.');
        header('Location: ' . APP_BASE_URL . 'login.php');
        exit;
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <h2>Login</h2>
    <form method="POST">
      <?= csrf_input() ?>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required />
      </div>
      <button class="btn btn-primary">Login</button>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
