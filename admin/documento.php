<?php
require_once __DIR__ . '/../includes/helpers.php';
require_auth();
$pdo = db();
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$type = (string)($_GET['tipo'] ?? $_POST['tipo'] ?? 'frequencia');
$allowed = ['frequencia','participacao','relatorio','certificado'];
if (!in_array($type,$allowed,true)) $type='frequencia';
$student = student_by_id($id); if(!$student) exit('Aluno não encontrado.');
$start = (string)($_GET['inicio'] ?? $_POST['inicio'] ?? ($student['start_date'] ?: date('Y-m-01')));
$end = (string)($_GET['fim'] ?? $_POST['fim'] ?? date('Y-m-d'));
$stats = attendance_stats($id,$start,$end);
$stmt=$pdo->prepare('SELECT * FROM evaluations WHERE student_id=? AND evaluation_date BETWEEN ? AND ? ORDER BY evaluation_date ASC,id ASC');$stmt->execute([$id,$start,$end]);$evals=$stmt->fetchAll();
$first=$evals[0]??null;$last=$evals?end($evals):null;
$docNo = (string)($_POST['doc_no'] ?? document_number());
$issued = false;
if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action']??'')==='emit'){
  check_csrf();
  $pdo->prepare('INSERT INTO documents(student_id,type,period_start,period_end,document_number) VALUES(?,?,?,?,?)')->execute([$id,$type,$start,$end,$docNo]);
  $issued = true;
}
function radar_points(?array $ev, float $cx=150, float $cy=150, float $r=100): string {
  if(!$ev) return '';
  $keys=['coordination','balance','agility','strength','endurance','confidence'];
  $pts=[]; foreach($keys as $i=>$k){$a=-M_PI/2 + $i*(2*M_PI/count($keys));$rr=$r*((int)$ev[$k]/10);$pts[]=round($cx+cos($a)*$rr,1).','.round($cy+sin($a)*$rr,1);} return implode(' ',$pts);
}
function radar_grid(float $cx=150,float $cy=150,float $r=100): string { $out=''; for($lvl=2;$lvl<=10;$lvl+=2){$pts=[];for($i=0;$i<6;$i++){$a=-M_PI/2+$i*(2*M_PI/6);$rr=$r*($lvl/10);$pts[]=round($cx+cos($a)*$rr,1).','.round($cy+sin($a)*$rr,1);} $out.='<polygon points="'.implode(' ',$pts).'" fill="none" stroke="#d9ded5" stroke-width="1"/>'; } return $out; }
$site=app_config()['site'];
$labels=['frequencia'=>'DECLARAÇÃO DE FREQUÊNCIA','participacao'=>'DECLARAÇÃO DE PARTICIPAÇÃO','relatorio'=>'RELATÓRIO DE EVOLUÇÃO','certificado'=>'CERTIFICADO DE CONCLUSÃO'];
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($labels[$type]) ?> — <?= e($student['name']) ?></title>
<style>
:root{--ink:#101512;--green:#769f49;--sand:#d6c39e;--cream:#f5f0e8}*{box-sizing:border-box}body{margin:0;background:#e7e8e5;font-family:Arial,Helvetica,sans-serif;color:var(--ink)}.tools{position:sticky;top:0;z-index:5;background:#111611;color:#fff;padding:12px;display:flex;gap:10px;justify-content:center;align-items:end;flex-wrap:wrap}.tools label{font-size:11px}.tools input{display:block;margin-top:3px;padding:7px;border-radius:7px;border:0}.tools button,.tools a{border:0;border-radius:8px;padding:9px 12px;font-weight:700;cursor:pointer;text-decoration:none}.tools .primary{background:var(--green);color:#fff}.tools .light{background:#fff;color:#111}.paper{width:210mm;min-height:297mm;margin:18px auto;background:#fff;padding:17mm 17mm 15mm;box-shadow:0 10px 30px #0002;position:relative}.head{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:3px solid var(--green);padding-bottom:12px}.brand strong{font-size:25px}.brand b{color:var(--green)}.brand small{display:block;text-transform:uppercase;font-size:9px;letter-spacing:.8px;margin-top:4px}.cref{text-align:right;font-size:11px;color:#606660}.title{text-align:center;margin:26px 0}.title h1{font-size:25px;margin:0}.title p{font-size:11px;color:#6b716c}.identity{display:grid;grid-template-columns:1fr 1fr;gap:8px 20px;background:var(--cream);padding:14px;border-radius:10px;font-size:12px}.identity strong{display:block;font-size:10px;text-transform:uppercase;color:#6b716c;margin-bottom:2px}.doc-text{font-family:Georgia,serif;font-size:15px;line-height:1.75;text-align:justify;margin:28px 4px}.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin:18px 0}.stat{border:1px solid #dfe2dd;border-radius:10px;padding:12px;text-align:center}.stat strong{display:block;font-size:24px;color:var(--green)}.stat span{font-size:10px;color:#666}.chart-title{font-size:13px;text-transform:uppercase;letter-spacing:.8px;margin:22px 0 10px}.bars{display:grid;gap:9px}.bar-row{display:grid;grid-template-columns:105px 1fr 80px;gap:8px;align-items:center;font-size:11px}.track{height:12px;background:#ecefe9;border-radius:99px;overflow:hidden}.initial{height:100%;background:#c8cfc2}.current{height:100%;background:var(--green)}.compare{display:grid;grid-template-columns:1fr 1fr;gap:15px}.radar-wrap{text-align:center;border:1px solid #e0e3df;border-radius:12px;padding:10px}.legend{font-size:10px;color:#606660}.notes{border-left:4px solid var(--green);background:#f7f8f5;padding:14px;margin:20px 0;font-size:12px;line-height:1.55}.signature{margin-top:55px;text-align:center}.signature .line{width:240px;border-top:1px solid #444;margin:0 auto 6px}.signature strong,.signature span{display:block}.signature span{font-size:11px}.footer{position:absolute;left:17mm;right:17mm;bottom:12mm;border-top:1px solid #ddd;padding-top:8px;display:flex;justify-content:space-between;font-size:9px;color:#777}.certificate{min-height:230mm;display:grid;place-items:center;text-align:center;border:2px solid var(--sand);padding:22mm}.certificate h1{font-size:38px;margin:8px 0}.certificate h2{font-size:26px;color:var(--green);margin:8px}.certificate p{max-width:560px;line-height:1.6}.certificate .student-name{font-family:Georgia,serif;font-size:34px;border-bottom:1px solid #aaa;padding:10px 40px;margin:12px}.warning{font-size:9px;color:#777;margin-top:20px}@media print{body{background:#fff}.tools{display:none}.paper{margin:0;box-shadow:none;width:210mm;min-height:297mm;page-break-after:always}@page{size:A4;margin:0}}
</style></head><body>
<div class="tools">
  <form method="get" style="display:flex;gap:8px;align-items:end;flex-wrap:wrap"><input type="hidden" name="id" value="<?= $id ?>"><input type="hidden" name="tipo" value="<?= e($type) ?>"><label>Início<input type="date" name="inicio" value="<?= e($start) ?>"></label><label>Fim<input type="date" name="fim" value="<?= e($end) ?>"></label><button class="light">Atualizar período</button></form>
  <form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="emit"><input type="hidden" name="id" value="<?= $id ?>"><input type="hidden" name="tipo" value="<?= e($type) ?>"><input type="hidden" name="inicio" value="<?= e($start) ?>"><input type="hidden" name="fim" value="<?= e($end) ?>"><input type="hidden" name="doc_no" value="<?= e($docNo) ?>"><button class="primary">Registrar emissão e imprimir / salvar PDF</button></form>
  <a class="light" href="documentos.php?id=<?= $id ?>">Voltar</a>
</div>
<div class="paper">
<div class="head"><div class="brand"><strong>CARLOS <b>ANÍBAL</b></strong><small>Treinamento e Desenvolvimento Infantil</small></div><div class="cref">Profissional de Educação Física<br>CREF <?= e($site['cref']) ?><br><?= e($site['city']) ?></div></div>
<div class="title"><h1><?= e($labels[$type]) ?></h1><p>Documento nº <?= e($docNo) ?> · Período <?= e(date('d/m/Y',strtotime($start))) ?> a <?= e(date('d/m/Y',strtotime($end))) ?></p></div>
<div class="identity"><div><strong>Aluno</strong><?= e($student['name']) ?></div><div><strong>Idade</strong><?= age_from_birthdate($student['birth_date']) ?? '—' ?> anos</div><div><strong>Responsável</strong><?= e($student['responsible_name']) ?></div><div><strong>Programa</strong><?= e($student['program']) ?></div></div>

<?php if($type==='frequencia'): ?>
<div class="doc-text">Declaramos, para os fins cabíveis, que <strong><?= e($student['name']) ?></strong> participou de atividades físicas orientadas no programa <strong><?= e($student['program']) ?></strong>, sob acompanhamento do Professor Carlos Aníbal, no período acima indicado.</div>
<div class="stats"><div class="stat"><strong><?= $stats['total'] ?></strong><span>Aulas registradas</span></div><div class="stat"><strong><?= $stats['present'] ?></strong><span>Presenças</span></div><div class="stat"><strong><?= $stats['absent'] ?></strong><span>Faltas</span></div><div class="stat"><strong><?= $stats['percent'] ?>%</strong><span>Frequência</span></div></div>
<div class="doc-text">Carga horária efetivamente realizada: <strong><?= round($stats['minutes']/60,1) ?> horas</strong>.</div>
<?php elseif($type==='participacao'): ?>
<div class="doc-text">Declaramos que <strong><?= e($student['name']) ?></strong> participou do programa <strong><?= e($student['program']) ?></strong>, realizando atividades de desenvolvimento motor e condicionamento físico compatíveis com o planejamento individual definido para o período.</div>
<div class="stats"><div class="stat"><strong><?= $stats['present'] ?></strong><span>Sessões realizadas</span></div><div class="stat"><strong><?= round($stats['minutes']/60,1) ?>h</strong><span>Carga horária</span></div><div class="stat"><strong><?= $stats['percent'] ?>%</strong><span>Frequência</span></div><div class="stat"><strong><?= count($evals) ?></strong><span>Avaliações</span></div></div>
<?php elseif($type==='relatorio'): ?>
<div class="doc-text">Este relatório apresenta o acompanhamento físico e motor observado durante o período, utilizando uma escala interna de evolução de 1 a 10. Os indicadores servem ao planejamento do treinamento e não constituem diagnóstico clínico.</div>
<?php if($first && $last): ?>
<div class="compare"><div><div class="chart-title">Comparativo inicial x atual</div><div class="bars">
<?php foreach(['coordination'=>'Coordenação','balance'=>'Equilíbrio','agility'=>'Agilidade','strength'=>'Força','endurance'=>'Resistência','confidence'=>'Confiança'] as $key=>$label): ?>
<div class="bar-row"><span><?= e($label) ?></span><div><div class="track"><div class="initial" style="width:<?= (int)$first[$key]*10 ?>%"></div></div><div class="track" style="margin-top:3px"><div class="current" style="width:<?= (int)$last[$key]*10 ?>%"></div></div></div><strong><?= (int)$first[$key] ?> → <?= (int)$last[$key] ?></strong></div>
<?php endforeach; ?></div><div class="legend">Cinza = avaliação inicial · Verde = avaliação atual</div></div>
<div class="radar-wrap"><div class="chart-title">Painel de evolução</div><svg width="300" height="300" viewBox="0 0 300 300" role="img" aria-label="Gráfico radar de evolução"><?= radar_grid() ?><polygon points="<?= radar_points($first) ?>" fill="rgba(150,160,145,.18)" stroke="#9aa393" stroke-width="2"/><polygon points="<?= radar_points($last) ?>" fill="rgba(118,159,73,.2)" stroke="#769f49" stroke-width="3"/><?php $labs=['Coord.','Equil.','Agil.','Força','Resist.','Conf.'];for($i=0;$i<6;$i++){$a=-M_PI/2+$i*(2*M_PI/6);$x=150+cos($a)*123;$y=150+sin($a)*123;echo '<text x="'.round($x,1).'" y="'.round($y,1).'" font-size="10" text-anchor="middle" fill="#555">'.$labs[$i].'</text>';} ?></svg><div class="legend">Linha cinza: início · Linha verde: atual</div></div></div>
<div class="notes"><strong>Observação do professor</strong><br><?= nl2br(e($last['notes'] ?: 'O aluno apresentou evolução progressiva nas atividades realizadas. Recomenda-se continuidade do acompanhamento e progressão dos estímulos conforme o planejamento individual.')) ?></div>
<?php else: ?><div class="notes">Para exibir os gráficos, registre pelo menos uma avaliação dentro do período selecionado.</div><?php endif; ?>
<?php elseif($type==='certificado'): ?>
<div class="certificate"><div><p>Certificamos que</p><div class="student-name"><?= e($student['name']) ?></div><p>concluiu o ciclo do programa</p><h2><?= e($student['program']) ?></h2><p>participando de uma jornada de desenvolvimento motor, atividade física orientada e construção de hábitos ativos.</p><p><strong><?= $stats['present'] ?></strong> sessões registradas · <strong><?= round($stats['minutes']/60,1) ?> horas</strong> realizadas</p><div class="signature"><div class="line"></div><strong>Carlos Aníbal</strong><span>Profissional de Educação Física · CREF <?= e($site['cref']) ?></span></div></div></div>
<?php endif; ?>

<?php if($type!=='certificado'): ?><div class="signature"><div class="line"></div><strong>Carlos Aníbal</strong><span>Profissional de Educação Física · CREF <?= e($site['cref']) ?></span></div><?php endif; ?>
<div class="warning">Este documento registra atividade física orientada no âmbito profissional da Educação Física. Quando houver condição clínica, lesão ou recuperação, devem ser respeitadas as orientações e liberações do profissional de saúde responsável.</div>
<div class="footer"><span><?= e($site['instagram']) ?> · <?= e($site['whatsapp_display']) ?></span><span><?= e($docNo) ?></span></div>
</div>
<?php if($issued): ?><script>window.addEventListener('load',()=>setTimeout(()=>window.print(),250));</script><?php endif; ?>
</body></html>
