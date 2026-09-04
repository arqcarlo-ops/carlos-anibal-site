<?php
require_once __DIR__ . '/../includes/helpers.php';
start_secure_session();
if (!empty($_SESSION['user_id'])) redirect('dashboard.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        redirect('dashboard.php');
    }
    $error = 'E-mail ou senha inválidos.';
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Área do Professor</title><link rel="stylesheet" href="../assets/css/admin.css"></head>
<body class="login-page">
<div class="login-card">
  <div class="login-brand"><strong>CARLOS <b>ANÍBAL</b></strong><br><small>Painel administrativo</small></div>
  <h1>Área do Professor</h1><p>Entre para gerenciar alunos, frequência, avaliações e documentos.</p>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label>E-mail<input type="email" name="email" required autocomplete="username"></label>
    <label>Senha<input type="password" name="password" required autocomplete="current-password"></label>
    <button class="btn btn-primary" type="submit">Entrar no painel</button>
  </form>
  <div class="login-help">Primeiro acesso: consulte o arquivo README.md do projeto e altere a senha imediatamente.</div>
</div>
</body></html>
