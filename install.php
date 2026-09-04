<?php
require_once __DIR__ . '/includes/helpers.php';
$config = app_config();
$dbCfg = $config['db'];
$ok = '';
$error = '';
$driver = $dbCfg['driver'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    start_secure_session();
    check_csrf();
    $name = trim((string)($_POST['name'] ?? 'Carlos Aníbal'));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Informe um e-mail válido.';
    } elseif (strlen($password) < 10) {
        $error = 'Use uma senha com pelo menos 10 caracteres.';
    } else {
        try {
            if ($driver === 'mysql') {
                $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $dbCfg['host'], $dbCfg['port'], $dbCfg['database'], $dbCfg['charset']);
                $pdo = new PDO($dsn, $dbCfg['username'], $dbCfg['password'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
                $sql = file_get_contents(__DIR__ . '/database.sql');
                $clean = preg_replace('/^--.*$/m', '', (string)$sql);
                foreach (array_filter(array_map('trim', preg_split('/;\s*(?:\r?\n|$)/', $clean))) as $statement) {
                    if (stripos($statement, 'INSERT INTO users') === 0) continue;
                    $pdo->exec($statement);
                }
                $stmt = $pdo->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
                $stmt->execute([$email]);
                if ($stmt->fetchColumn()) {
                    $pdo->prepare('UPDATE users SET name=?,password_hash=? WHERE email=?')->execute([$name,password_hash($password,PASSWORD_DEFAULT),$email]);
                } else {
                    $pdo->prepare('INSERT INTO users(name,email,password_hash) VALUES(?,?,?)')->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
                }
                $ok = 'Banco MySQL instalado e administrador criado. Apague install.php do servidor.';
            } else {
                $pdo = db();
                $stmt = $pdo->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
                $stmt->execute([$email]);
                $existing = $stmt->fetchColumn();
                if ($existing) {
                    $pdo->prepare('UPDATE users SET name=?,password_hash=? WHERE id=?')->execute([$name,password_hash($password,PASSWORD_DEFAULT),$existing]);
                } else {
                    $pdo->prepare('INSERT INTO users(name,email,password_hash) VALUES(?,?,?)')->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
                }
                $ok = 'SQLite configurado e administrador criado. Apague install.php do servidor.';
            }
        } catch (Throwable $e) {
            $error = 'Não foi possível instalar: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Instalação — Carlos Aníbal</title><style>body{margin:0;font-family:system-ui;background:#101511;color:#fff;min-height:100vh;display:grid;place-items:center;padding:20px}.card{width:min(560px,100%);background:#fff;color:#111;padding:28px;border-radius:22px}.brand{font-size:26px;font-weight:900}.brand b{color:#79a844}.info{background:#f3f0e8;padding:12px;border-radius:10px;margin:14px 0;font-size:13px}label{display:block;font-size:12px;font-weight:700;margin-top:12px}input{width:100%;padding:12px;border:1px solid #ddd;border-radius:9px;margin-top:5px;box-sizing:border-box}.btn{margin-top:16px;border:0;border-radius:10px;background:#79a844;color:#fff;padding:12px 16px;font-weight:800}.ok{background:#edf5e7;color:#48662c;padding:12px;border-radius:10px}.err{background:#fff0ef;color:#993f39;padding:12px;border-radius:10px}.small{font-size:11px;color:#777}</style></head><body><div class="card"><div class="brand">CARLOS <b>ANÍBAL</b></div><h1>Instalação do painel</h1><div class="info">Driver configurado: <strong><?=e($driver)?></strong>. Para MySQL, preencha primeiro os dados em <code>config/config.php</code>.</div><?php if($ok):?><div class="ok"><?=e($ok)?><br><a href="admin/login.php">Ir para o painel →</a></div><?php endif;?><?php if($error):?><div class="err"><?=e($error)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label>Nome do administrador<input name="name" value="Carlos Aníbal" required></label><label>E-mail do administrador<input type="email" name="email" required></label><label>Nova senha administrativa<input type="password" name="password" minlength="10" required></label><button class="btn">Instalar / configurar</button></form><p class="small">Por segurança, exclua este arquivo do servidor após a instalação.</p></div></body></html>
