<?php
require_once __DIR__ . '/../includes/helpers.php';
require_auth();
$pdo = db();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $stmt = $pdo->prepare('INSERT INTO students (name,birth_date,responsible_name,phone,address,condominium,program,start_date,status,notes) VALUES (?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute([
        trim((string)$_POST['name']), $_POST['birth_date'] ?: null, trim((string)$_POST['responsible_name']), trim((string)$_POST['phone']), trim((string)$_POST['address']), trim((string)$_POST['condominium']), $_POST['program'], $_POST['start_date'] ?: null, $_POST['status'], trim((string)$_POST['notes'])
    ]);
    redirect('aluno.php?id=' . (int)$pdo->lastInsertId());
}
$q = trim((string)($_GET['q'] ?? ''));
if ($q !== '') {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE name LIKE ? OR responsible_name LIKE ? OR condominium LIKE ? ORDER BY name');
    $like = '%' . $q . '%'; $stmt->execute([$like,$like,$like]);
    $students = $stmt->fetchAll();
} else {
    $students = $pdo->query('SELECT * FROM students ORDER BY status DESC, name')->fetchAll();
}
include __DIR__ . '/../includes/admin_header.php';
?>
<div class="admin-content">
  <div class="page-head"><div><h1>Alunos</h1><p>Cadastro e acompanhamento dos alunos.</p></div><a class="btn btn-primary" href="#novo">+ Novo aluno</a></div>
  <section class="panel"><form method="get" style="display:flex;gap:10px"><input name="q" value="<?= e($q) ?>" placeholder="Buscar aluno, responsável ou condomínio"><button class="btn btn-light">Buscar</button></form></section>
  <section class="panel"><div class="table-wrap"><table><thead><tr><th>Aluno</th><th>Idade</th><th>Programa</th><th>Responsável</th><th>Condomínio</th><th>Status</th><th></th></tr></thead><tbody>
  <?php if (!$students): ?><tr><td colspan="7">Nenhum aluno encontrado.</td></tr><?php endif; ?>
  <?php foreach ($students as $s): ?><tr><td><strong><?= e($s['name']) ?></strong></td><td><?= age_from_birthdate($s['birth_date']) ?? '—' ?></td><td><?= e($s['program']) ?></td><td><?= e($s['responsible_name']) ?></td><td><?= e($s['condominium'] ?: '—') ?></td><td><span class="badge <?= $s['status']==='ativo'?'':'off' ?>"><?= e($s['status']) ?></span></td><td><a href="aluno.php?id=<?= (int)$s['id'] ?>">Abrir →</a></td></tr><?php endforeach; ?>
  </tbody></table></div></section>

  <section class="panel" id="novo"><h2>Novo aluno</h2>
    <form method="post" class="form-grid">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <label>Nome da criança<input required name="name"></label><label>Data de nascimento<input type="date" name="birth_date"></label>
      <label>Responsável<input required name="responsible_name"></label><label>WhatsApp<input name="phone" inputmode="tel"></label>
      <label class="full">Endereço<input name="address"></label><label>Condomínio<input name="condominium"></label>
      <label>Programa<select name="program"><option>Movimento Kids</option><option>Pequenos Atletas</option><option>Pequenas Atitudes, Grandes Conquistas</option><option>Preparação esportiva</option><option>Retorno ao Movimento</option></select></label>
      <label>Data de início<input type="date" name="start_date"></label><label>Status<select name="status"><option value="ativo">Ativo</option><option value="inativo">Inativo</option></select></label>
      <label class="full">Observações<textarea name="notes" rows="4"></textarea></label>
      <div class="full"><button class="btn btn-primary">Cadastrar aluno</button></div>
    </form>
  </section>
</div>
<?php include __DIR__ . '/../includes/admin_footer.php'; ?>
