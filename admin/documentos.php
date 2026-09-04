<?php
require_once __DIR__ . '/../includes/helpers.php'; require_auth(); $pdo=db(); $id=(int)($_GET['id']??0); $student=student_by_id($id); if(!$student) exit('Aluno não encontrado.');
$stmt=$pdo->prepare('SELECT * FROM documents WHERE student_id=? ORDER BY issued_at DESC');$stmt->execute([$id]);$docs=$stmt->fetchAll();
include __DIR__.'/../includes/admin_header.php';
?>
<div class="admin-content"><div class="page-head"><div><h1>Documentos — <?= e($student['name']) ?></h1><p>Gere documentos prontos para imprimir ou salvar em PDF.</p></div><a class="btn btn-light" href="aluno.php?id=<?= $id ?>">← Ficha do aluno</a></div>
<section class="panel"><h2>Gerar documento</h2><div class="doc-grid">
  <div class="doc-card"><strong>Declaração de frequência</strong><span>Presenças, período, carga horária e percentual de frequência.</span><a class="btn btn-primary" href="documento.php?id=<?= $id ?>&tipo=frequencia" target="_blank">Gerar PDF</a></div>
  <div class="doc-card"><strong>Declaração de participação</strong><span>Comprovação de participação em atividade física orientada.</span><a class="btn btn-primary" href="documento.php?id=<?= $id ?>&tipo=participacao" target="_blank">Gerar PDF</a></div>
  <div class="doc-card"><strong>Relatório de evolução</strong><span>Folha com gráficos comparando avaliação inicial e atual.</span><a class="btn btn-primary" href="documento.php?id=<?= $id ?>&tipo=relatorio" target="_blank">Gerar PDF</a></div>
  <div class="doc-card"><strong>Certificado de conclusão</strong><span>Certificado do ciclo/programa concluído.</span><a class="btn btn-primary" href="documento.php?id=<?= $id ?>&tipo=certificado" target="_blank">Gerar PDF</a></div>
</div></section>
<section class="panel"><h2>Histórico de emissões</h2><div class="table-wrap"><table><thead><tr><th>Documento</th><th>Número</th><th>Período</th><th>Emitido em</th></tr></thead><tbody><?php if(!$docs):?><tr><td colspan="4">Nenhum documento emitido.</td></tr><?php endif;?><?php foreach($docs as $d):?><tr><td><?= e(ucfirst($d['type'])) ?></td><td><?= e($d['document_number']) ?></td><td><?= e(($d['period_start']?:'—').' a '.($d['period_end']?:'—')) ?></td><td><?= e(date('d/m/Y H:i',strtotime($d['issued_at']))) ?></td></tr><?php endforeach;?></tbody></table></div></section></div>
<?php include __DIR__.'/../includes/admin_footer.php';?>
