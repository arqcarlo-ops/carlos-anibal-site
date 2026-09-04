<?php
require_once __DIR__ . '/../includes/helpers.php';
require_auth();
$pdo = db();
$active = (int)$pdo->query("SELECT COUNT(*) FROM students WHERE status='ativo'")->fetchColumn();
$today = date('Y-m-d');
$todayClasses = (int)$pdo->query("SELECT COUNT(*) FROM attendance WHERE class_date=" . $pdo->quote($today))->fetchColumn();
$docsMonth = (int)$pdo->query("SELECT COUNT(*) FROM documents WHERE substr(issued_at,1,7)=" . $pdo->quote(date('Y-m')))->fetchColumn();
$evaluations = (int)$pdo->query("SELECT COUNT(*) FROM evaluations WHERE substr(evaluation_date,1,7)=" . $pdo->quote(date('Y-m')))->fetchColumn();
$students = $pdo->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 8")->fetchAll();
include __DIR__ . '/../includes/admin_header.php';
?>
<div class="admin-content">
  <div class="page-head"><div><h1>Dashboard</h1><p>Visão geral do acompanhamento.</p></div><a class="btn btn-primary" href="alunos.php?novo=1">+ Novo aluno</a></div>
  <div class="metric-grid">
    <div class="metric"><span>Alunos ativos</span><strong><?= $active ?></strong></div>
    <div class="metric"><span>Registros de aula hoje</span><strong><?= $todayClasses ?></strong></div>
    <div class="metric"><span>Avaliações este mês</span><strong><?= $evaluations ?></strong></div>
    <div class="metric"><span>Documentos emitidos</span><strong><?= $docsMonth ?></strong></div>
  </div>
  <section class="panel"><h2>Alunos recentes</h2><div class="table-wrap"><table><thead><tr><th>Aluno</th><th>Programa</th><th>Responsável</th><th>Status</th><th></th></tr></thead><tbody>
  <?php if (!$students): ?><tr><td colspan="5">Nenhum aluno cadastrado ainda.</td></tr><?php endif; ?>
  <?php foreach ($students as $s): ?><tr><td><?= e($s['name']) ?></td><td><?= e($s['program']) ?></td><td><?= e($s['responsible_name']) ?></td><td><span class="badge <?= $s['status']==='ativo'?'':'off' ?>"><?= e($s['status']) ?></span></td><td><a href="aluno.php?id=<?= (int)$s['id'] ?>">Abrir →</a></td></tr><?php endforeach; ?>
  </tbody></table></div></section>
</div>
<?php include __DIR__ . '/../includes/admin_footer.php'; ?>
