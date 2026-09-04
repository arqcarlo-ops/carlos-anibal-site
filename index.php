<?php
$config = require __DIR__ . '/config/config.php';
$site = $config['site'];
$waMessage = rawurlencode('Olá, Professor Carlos Aníbal! Gostaria de saber mais sobre o treinamento infantil e agendar uma avaliação.');
$waLink = 'https://wa.me/' . $site['whatsapp'] . '?text=' . $waMessage;
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#101411">
<meta name="description" content="Treinamento infantil personalizado em domicílio e condomínios em Feira de Santana. Desenvolvimento motor, coordenação, equilíbrio, agilidade e preparação esportiva.">
<title><?= htmlspecialchars($site['name']) ?> | Treinamento e Desenvolvimento Infantil</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header" id="inicio">
  <div class="container nav-wrap">
    <a class="brand" href="#inicio" aria-label="Carlos Aníbal - Início">
      <span class="brand-icon" aria-hidden="true">↗</span>
      <span><strong>CARLOS <em>ANÍBAL</em></strong><small>Treinamento e Desenvolvimento Infantil</small></span>
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Abrir menu" aria-expanded="false">☰</button>
    <nav class="main-nav" id="mainNav">
      <a href="#inicio">Início</a>
      <a href="#programas">Programas</a>
      <a href="#como-funciona">Como funciona</a>
      <a href="#professor">Professor</a>
      <a href="#atendimento">Atendimento</a>
      <a href="#contato">Contato</a>
    </nav>
    <a class="btn btn-whatsapp nav-cta" href="<?= $waLink ?>" target="_blank" rel="noopener">WhatsApp</a>
  </div>
</header>

<main>
<section class="hero">
  <div class="hero-media" aria-hidden="true"><img src="assets/img/hero-carlos.jpg" alt=""></div>
  <div class="hero-overlay"></div>
  <div class="container hero-grid">
    <div class="hero-copy reveal">
      <p class="eyebrow">Movimento hoje. Grandes conquistas amanhã.</p>
      <h1>DESENVOLVIMENTO <span>MOTOR</span> INFANTIL</h1>
      <p class="hero-lead">Treinamento físico orientado para crianças mais ativas, seguras e confiantes — com acompanhamento individual e evolução registrada.</p>
      <div class="hero-actions">
        <a class="btn btn-primary" href="<?= $waLink ?>" target="_blank" rel="noopener">Agendar avaliação</a>
        <a class="btn btn-ghost" href="#programas">Conhecer os programas</a>
      </div>
      <div class="trust-row">
        <span>✓ Atendimento domiciliar</span>
        <span>✓ Condomínios</span>
        <span>✓ Pequenos grupos</span>
        <span>✓ CREF <?= htmlspecialchars($site['cref']) ?></span>
      </div>
    </div>
  </div>
</section>

<section class="benefits section-light">
  <div class="container benefit-grid">
    <article><span class="round-icon">◎</span><h3>Coordenação</h3><p>Movimentos mais seguros e organizados.</p></article>
    <article><span class="round-icon">◒</span><h3>Equilíbrio</h3><p>Mais controle e estabilidade corporal.</p></article>
    <article><span class="round-icon">✦</span><h3>Força</h3><p>Desenvolvimento funcional adequado à idade.</p></article>
    <article><span class="round-icon">⚡</span><h3>Agilidade</h3><p>Respostas mais rápidas e melhor reação.</p></article>
    <article><span class="round-icon">♥</span><h3>Confiança</h3><p>Mais autonomia, participação e segurança.</p></article>
  </div>
</section>

<section class="programs" id="programas">
  <div class="container">
    <div class="section-heading reveal">
      <p class="eyebrow dark">Uma jornada que continua</p>
      <h2>DO MOVIMENTO À <span>DESCOBERTA DO ESPORTE</span></h2>
      <p>O primeiro ciclo cria a base. Depois, a criança evolui, experimenta estímulos esportivos e constrói hábitos que podem acompanhar toda a vida.</p>
    </div>
    <div class="journey-line reveal">
      <article class="program-card featured">
        <div class="program-number">01</div>
        <div class="program-image"><img src="assets/img/movimento-kids.jpg" alt="Criança em atividade de desenvolvimento motor"></div>
        <div class="program-body">
          <p class="kicker">12 semanas</p>
          <h3>Movimento Kids</h3>
          <p>Base do desenvolvimento motor com coordenação, equilíbrio, força funcional, agilidade, resistência e confiança.</p>
          <ul><li>Avaliação inicial</li><li>Plano individual</li><li>Relatórios de evolução</li><li>Certificado de conclusão</li></ul>
        </div>
      </article>
      <article class="program-card">
        <div class="program-number">02</div>
        <div class="program-body">
          <p class="kicker">Próximo nível</p>
          <h3>Pequenos Atletas</h3>
          <p>Amplia habilidades e apresenta estímulos ligados a diferentes modalidades esportivas.</p>
          <ul><li>Velocidade e reação</li><li>Coordenação com bola</li><li>Potência e resistência</li><li>Perfil de afinidade esportiva</li></ul>
          <div class="sport-tags"><span>Futebol</span><span>Atletismo</span><span>Tênis</span><span>Beach Tennis</span><span>Vôlei</span><span>+ modalidades</span></div>
        </div>
      </article>
      <article class="program-card">
        <div class="program-number">03</div>
        <div class="program-body">
          <p class="kicker">Continuidade</p>
          <h3>Pequenas Atitudes, Grandes Conquistas</h3>
          <p>Consolidação de disciplina, constância, autonomia e hábitos saudáveis, podendo acompanhar a modalidade esportiva escolhida.</p>
          <ul><li>Metas pessoais</li><li>Autonomia</li><li>Constância</li><li>Hábitos ativos</li></ul>
        </div>
      </article>
    </div>
    <div class="sports-direction reveal">
      <div><strong>Direcionamento esportivo</strong><p>Ao longo do programa, o professor observa habilidades, interesse e facilidade da criança para orientar a família sobre modalidades que podem combinar melhor com seu perfil.</p></div>
      <span class="direction-arrow">→</span>
      <div class="direction-result"><strong>Desenvolver → experimentar → descobrir → praticar</strong></div>
    </div>
  </div>
</section>

<section class="how" id="como-funciona">
  <div class="container">
    <div class="section-heading centered reveal">
      <p class="eyebrow">Como funciona</p>
      <h2>5 ETAPAS DO ACOMPANHAMENTO</h2>
    </div>
    <div class="steps">
      <article><span>01</span><h3>Avaliação inicial</h3><p>Conversa com os responsáveis e observação das habilidades motoras e rotina da criança.</p></article>
      <article><span>02</span><h3>Plano individual</h3><p>Objetivos claros e atividades adequadas à idade, ao espaço e às necessidades do aluno.</p></article>
      <article><span>03</span><h3>Treinamento orientado</h3><p>Sessões práticas, dinâmicas e progressivas, individuais ou em pequenos grupos.</p></article>
      <article><span>04</span><h3>Evolução acompanhada</h3><p>Frequência, avaliações periódicas e registro do desenvolvimento ao longo do ciclo.</p></article>
      <article><span>05</span><h3>Relatório e certificado</h3><p>Resumo gráfico da evolução, declaração de participação/frequência e certificado de conclusão.</p></article>
    </div>
  </div>
</section>

<section class="parents section-light">
  <div class="container parents-grid">
    <div class="parents-copy reveal">
      <p class="eyebrow dark">Acompanhamento de verdade</p>
      <h2>OS PAIS ACOMPANHAM CADA ETAPA</h2>
      <p>O programa não termina na aula. O responsável acompanha presença, evolução e os resultados observados durante o período.</p>
      <div class="parent-items">
        <div><strong>Frequência</strong><span>Controle de participação em cada sessão.</span></div>
        <div><strong>Evolução motora</strong><span>Comparação entre avaliações ao longo do ciclo.</span></div>
        <div><strong>Relatório periódico</strong><span>Resumo com gráficos e observações do professor.</span></div>
        <div><strong>Declaração</strong><span>Participação e frequência, quando solicitado.</span></div>
        <div><strong>Certificado</strong><span>Conclusão do ciclo e passagem para o próximo programa.</span></div>
      </div>
      <p class="fine-print">A declaração registra participação/frequência em atividade física orientada e não substitui automaticamente exigências escolares, médicas ou fisioterapêuticas.</p>
    </div>
    <div class="parents-visual reveal"><img src="assets/img/inclusao-grupo.jpg" alt="Professor acompanhando crianças em atividade física inclusiva"></div>
  </div>
</section>

<section class="attendance" id="atendimento">
  <div class="container attendance-grid">
    <div class="attendance-visual reveal"><img src="assets/img/grupo-contato.jpg" alt="Atendimento infantil com professor e crianças"></div>
    <div class="attendance-copy reveal">
      <p class="eyebrow">O treinamento vai até seu filho</p>
      <h2>ATENDIMENTO EM CASA E CONDOMÍNIOS</h2>
      <p>Carlos não trabalha em um local fixo. O atendimento é planejado para acontecer onde a família já possui estrutura e conforto.</p>
      <div class="service-cards">
        <article><h3>Na sua casa</h3><p>Treino individual em quintal, garagem, área externa ou outro espaço adequado.</p></article>
        <article><h3>No condomínio</h3><p>Quadras, academias, áreas verdes e espaços comuns, conforme disponibilidade.</p></article>
        <article><h3>Pequenos grupos</h3><p>Irmãos, amigos ou crianças do mesmo condomínio em turmas reduzidas.</p></article>
      </div>
      <a class="btn btn-primary" href="#contato">Consultar atendimento na minha região</a>
    </div>
  </div>
</section>

<section class="inclusive section-dark">
  <div class="container inclusive-grid">
    <div class="inclusive-copy reveal">
      <p class="eyebrow">Inclusão e acolhimento</p>
      <h2>CADA CRIANÇA TEM SEU RITMO.</h2>
      <p>As atividades podem ser adaptadas para diferentes perfis e necessidades, sempre dentro da atuação do profissional de Educação Física e respeitando orientações médicas ou fisioterapêuticas quando existirem.</p>
      <ul class="check-list"><li>Atendimento individualizado</li><li>Ambiente seguro e motivador</li><li>Progressão adequada</li><li>Participação e confiança</li></ul>
    </div>
    <div class="inclusive-visual reveal"><img src="assets/img/professor-criancas.jpg" alt="Professor com crianças em atividade física inclusiva"></div>
  </div>
</section>

<section class="professor" id="professor">
  <div class="container professor-grid">
    <div class="professor-card reveal"><img src="assets/img/hero-carlos.jpg" alt="Professor Carlos Aníbal"><div><strong>Carlos Aníbal</strong><span>Profissional de Educação Física</span><span>CREF <?= htmlspecialchars($site['cref']) ?></span></div></div>
    <div class="professor-copy reveal">
      <p class="eyebrow dark">Conheça o professor</p>
      <h2>PROFESSOR CARLOS ANÍBAL</h2>
      <p>Atendimento voltado ao desenvolvimento motor infantil, condicionamento físico e preparação esportiva, com planejamento individual, acompanhamento e comunicação próxima com os responsáveis.</p>
      <div class="credentials">
        <span>Profissional de Educação Física</span><span>CREF ativo</span><span>Atendimento infantil</span><span>Pequenos grupos</span><span>Relatórios de evolução</span>
      </div>
      <a class="btn btn-dark" href="<?= $waLink ?>" target="_blank" rel="noopener">Falar com o professor</a>
    </div>
  </div>
</section>

<section class="faq section-light">
  <div class="container">
    <div class="section-heading centered reveal"><p class="eyebrow dark">Perguntas frequentes</p><h2>ANTES DE COMEÇAR</h2></div>
    <div class="faq-grid">
      <details><summary>Qual a idade para participar?</summary><p>O atendimento é pensado principalmente para crianças em idade escolar. A faixa e o plano são definidos na avaliação inicial.</p></details>
      <details><summary>O treino é individual ou em grupo?</summary><p>As duas opções são possíveis. O atendimento individual oferece foco total; pequenos grupos favorecem interação e motivação.</p></details>
      <details><summary>Precisa ter academia em casa?</summary><p>Não. O programa pode usar materiais portáteis e o espaço disponível, desde que seja adequado e seguro para a atividade.</p></details>
      <details><summary>Meu filho já pratica um esporte. Pode participar?</summary><p>Sim. O treinamento pode atuar como preparação física complementar e ajudar a desenvolver capacidades úteis à modalidade.</p></details>
      <details><summary>É emitida declaração de frequência?</summary><p>Sim. O painel administrativo registra presença e permite gerar declaração de participação/frequência conforme o período realizado.</p></details>
      <details><summary>Como funciona o retorno à atividade física?</summary><p>Quando houver condição clínica, lesão ou recuperação, o treinamento deve respeitar a liberação e as orientações do profissional de saúde responsável.</p></details>
    </div>
  </div>
</section>

<section class="contact" id="contato">
  <div class="container contact-grid">
    <div class="contact-copy reveal">
      <p class="eyebrow">Vamos conversar?</p>
      <h2>SEU FILHO PODE IR MAIS LONGE.</h2>
      <p>Preencha os dados abaixo. Ao enviar, o WhatsApp será aberto com uma mensagem pronta para o professor.</p>
      <form id="contactForm" class="contact-form" data-whatsapp="<?= htmlspecialchars($site['whatsapp']) ?>">
        <div class="field-row"><label>Nome do responsável<input required name="responsavel" autocomplete="name"></label><label>WhatsApp<input required name="telefone" inputmode="tel" autocomplete="tel"></label></div>
        <div class="field-row"><label>Nome da criança<input required name="crianca"></label><label>Idade<input required name="idade" type="number" min="3" max="18"></label></div>
        <label>Onde deseja realizar o treinamento?<select name="local" required><option value="">Selecione</option><option>Minha residência</option><option>Meu condomínio</option><option>Área comum do condomínio</option><option>Ainda não sei</option></select></label>
        <label>Bairro / condomínio<input name="bairro" placeholder="Ex.: SIM, Santa Mônica, condomínio..."></label>
        <label>Principal interesse<select name="interesse"><option>Movimento Kids</option><option>Pequenos Atletas</option><option>Preparação esportiva</option><option>Retorno gradual à atividade física</option><option>Pequenos grupos</option><option>Quero orientação do professor</option></select></label>
        <label>Conte um pouco sobre o objetivo<textarea name="objetivo" rows="4" placeholder="Ex.: melhorar coordenação, sair do sedentarismo, iniciar um esporte..."></textarea></label>
        <button class="btn btn-primary" type="submit">Enviar pelo WhatsApp</button>
      </form>
    </div>
    <aside class="contact-aside reveal">
      <div class="contact-box"><span>WhatsApp</span><strong><?= htmlspecialchars($site['whatsapp_display']) ?></strong><a href="<?= $waLink ?>" target="_blank" rel="noopener">Abrir conversa →</a></div>
      <div class="contact-box"><span>Atendimento</span><strong><?= htmlspecialchars($site['city']) ?></strong><p>Domicílio e áreas comuns de condomínios.</p></div>
      <div class="contact-box"><span>Instagram</span><strong><?= htmlspecialchars($site['instagram']) ?></strong><a href="<?= htmlspecialchars($site['instagram_url']) ?>" target="_blank" rel="noopener">Ver Instagram →</a></div>
      <blockquote>“Movimento hoje é a base para um futuro com mais saúde, autonomia e confiança.”</blockquote>
    </aside>
  </div>
</section>

<section class="final-cta">
  <div class="container final-cta-inner reveal"><div><p class="eyebrow">Movimento hoje</p><h2>UM FUTURO MELHOR <span>AMANHÃ.</span></h2><p>Agende uma avaliação e dê o primeiro passo para o desenvolvimento do seu filho.</p></div><a class="btn btn-primary" href="<?= $waLink ?>" target="_blank" rel="noopener">Agendar agora pelo WhatsApp</a></div>
</section>
</main>

<footer class="site-footer">
  <div class="container footer-top">
    <a class="brand" href="#inicio"><span class="brand-icon">↗</span><span><strong>CARLOS <em>ANÍBAL</em></strong><small>Treinamento e Desenvolvimento Infantil</small></span></a>
    <div class="footer-meta"><span>Profissional de Educação Física</span><span>CREF <?= htmlspecialchars($site['cref']) ?></span><span><?= htmlspecialchars($site['city']) ?></span></div>
    <div class="footer-links"><a href="<?= htmlspecialchars($site['instagram_url']) ?>" target="_blank" rel="noopener">Instagram</a><a href="<?= $waLink ?>" target="_blank" rel="noopener">WhatsApp</a><a href="admin/login.php">Área do Professor</a></div>
  </div>
  <div class="container footer-bottom"><span>© <?= date('Y') ?> Carlos Aníbal. Todos os direitos reservados.</span><span>Site demonstrativo — revise textos, dados e políticas antes da publicação.</span></div>
</footer>

<a class="floating-wa" href="<?= $waLink ?>" target="_blank" rel="noopener" aria-label="Falar no WhatsApp">WA</a>
<script src="assets/js/script.js"></script>
</body>
</html>
