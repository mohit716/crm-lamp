<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
require_once __DIR__ . '/db.php';

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
    return current_user() !== null;
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: ' . APP_BASE_URL . 'login.php');
        exit;
    }
}

function register_user(string $name, string $email, string $password): bool {
    $pdo = pdo_conn();
    $sql = "INSERT INTO users (name, email, password_hash) VALUES (:n, :e, :p)";
    $stmt = $pdo->prepare($sql);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    try {
        return $stmt->execute([':n' => $name, ':e' => $email, ':p' => $hash]);
    } catch (PDOException $e) {
        // likely duplicate email
        return false;
    }
}

function login_user(string $email, string $password): bool {
    $pdo = pdo_conn();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :e LIMIT 1");
    $stmt->execute([':e' => $email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];
        return true;
    }
    return false;
}

function logout_user(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
