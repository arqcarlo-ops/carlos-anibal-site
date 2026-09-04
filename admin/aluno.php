<?php
require_once __DIR__ . '/../includes/helpers.php';
require_auth();
$pdo = db();
$id = (int)($_GET['id'] ?? 0);
$student = student_by_id($id);
if (!$student) { http_response_code(404); exit('Aluno não encontrado.'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    if (($_POST['action'] ?? '') === 'delete') {
        $pdo->prepare('DELETE FROM students WHERE id=?')->execute([$id]);
        redirect('alunos.php');
    }
    $stmt = $pdo->prepare('UPDATE students SET name=?,birth_date=?,responsible_name=?,phone=?,address=?,condominium=?,program=?,start_date=?,status=?,notes=? WHERE id=?');
    $stmt->execute([trim((string)$_POST['name']),$_POST['birth_date']?:null,trim((string)$_POST['responsible_name']),trim((string)$_POST['phone']),trim((string)$_POST['address']),trim((string)$_POST['condominium']),$_POST['program'],$_POST['start_date']?:null,$_POST['status'],trim((string)$_POST['notes']),$id]);
    redirect('aluno.php?id=' . $id . '&ok=1');
}
$stats = attendance_stats($id);
$evals = latest_evaluations($id, 2);
include __DIR__ . '/../includes/admin_header.php';
?>
<div class="admin-content">
  <div class="page-head"><div class="student-header"><div class="avatar"><?= e(strtoupper(substr($student['name'],0,1))) ?></div><div><h1><?= e($student['name']) ?></h1><p><?= e($student['program']) ?> · <?= age_from_birthdate($student['birth_date']) ?? 'idade não informada' ?> anos</p></div></div><a class="btn btn-light" href="alunos.php">← Voltar</a></div>
  <?php if (isset($_GET['ok'])): ?><div class="alert">Dados atualizados.</div><?php endif; ?>
  <div class="student-nav"><a href="aluno.php?id=<?= $id ?>">Cadastro</a><a href="frequencia.php?id=<?= $id ?>">Frequência</a><a href="avaliacoes.php?id=<?= $id ?>">Avaliações</a><a href="documentos.php?id=<?= $id ?>">Documentos</a></div>
  <div class="metric-grid" style="margin-top:18px"><div class="metric"><span>Aulas registradas</span><strong><?= $stats['total'] ?></strong></div><div class="metric"><span>Presenças</span><strong><?= $stats['present'] ?></strong></div><div class="metric"><span>Frequência</span><strong><?= $stats['percent'] ?>%</strong></div><div class="metric"><span>Avaliações</span><strong><?= count($evals) ?></strong></div></div>
  <section class="panel"><h2>Dados do aluno</h2><form method="post" class="form-grid"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <label>Nome<input required name="name" value="<?= e($student['name']) ?>"></label><label>Nascimento<input type="date" name="birth_date" value="<?= e($student['birth_date']) ?>"></label><label>Responsável<input required name="responsible_name" value="<?= e($student['responsible_name']) ?>"></label><label>WhatsApp<input name="phone" value="<?= e($student['phone']) ?>"></label><label class="full">Endereço<input name="address" value="<?= e($student['address']) ?>"></label><label>Condomínio<input name="condominium" value="<?= e($student['condominium']) ?>"></label><label>Programa<select name="program"><?php foreach (['Movimento Kids','Pequenos Atletas','Pequenas Atitudes, Grandes Conquistas','Preparação esportiva','Retorno ao Movimento'] as $p): ?><option <?= $student['program']===$p?'selected':'' ?>><?= e($p) ?></option><?php endforeach; ?></select></label><label>Início<input type="date" name="start_date" value="<?= e($student['start_date']) ?>"></label><label>Status<select name="status"><option value="ativo" <?= $student['status']==='ativo'?'selected':'' ?>>Ativo</option><option value="inativo" <?= $student['status']==='inativo'?'selected':'' ?>>Inativo</option></select></label><label class="full">Observações<textarea name="notes" rows="4"><?= e($student['notes']) ?></textarea></label><div class="full actions"><button class="btn btn-primary">Salvar alterações</button><button class="btn btn-danger" name="action" value="delete" data-confirm="Excluir este aluno e todo o histórico?">Excluir aluno</button></div></form></section>
</div>
<?php include __DIR__ . '/../includes/admin_footer.php'; ?>
