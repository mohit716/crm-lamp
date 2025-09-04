<?php
require_once __DIR__ . '/../inc/header.php';
require_once __DIR__ . '/../inc/csrf.php';
require_once __DIR__ . '/../inc/flash.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if ($password !== $confirm) {
        set_flash('error', 'Passwords do not match.');
        header('Location: ' . APP_BASE_URL . 'register.php');
        exit;
    }
    if (register_user($name, $email, $password)) {
        set_flash('success', 'Account created. You can now login.');
        header('Location: ' . APP_BASE_URL . 'login.php');
        exit;
    } else {
        set_flash('error', 'Could not create account (email may already exist).');
        header('Location: ' . APP_BASE_URL . 'register.php');
        exit;
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Register</h2>
    <form method="POST">
      <?= csrf_input() ?>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm" class="form-control" required />
      </div>
      <button class="btn btn-success">Create Account</button>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
