(() => {
  const navToggle = document.getElementById('navToggle');
  const mainNav = document.getElementById('mainNav');
  if (navToggle && mainNav) {
    navToggle.addEventListener('click', () => {
      const open = mainNav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    mainNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mainNav.classList.remove('open')));
  }

  const reveal = new IntersectionObserver(entries => {
    entries.forEach(entry => entry.isIntersecting && entry.target.classList.add('in'));
  }, {threshold: .08});
  document.querySelectorAll('.reveal').forEach(el => reveal.observe(el));

  const form = document.getElementById('contactForm');
  if (form) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const data = new FormData(form);
      const number = form.dataset.whatsapp;
      const text = [
        'Olá, Professor Carlos Aníbal! Gostaria de agendar uma avaliação.',
        '',
        `Responsável: ${data.get('responsavel')}`,
        `WhatsApp: ${data.get('telefone')}`,
        `Criança: ${data.get('crianca')}`,
        `Idade: ${data.get('idade')} anos`,
        `Local: ${data.get('local')}`,
        `Bairro/condomínio: ${data.get('bairro') || 'não informado'}`,
        `Interesse: ${data.get('interesse')}`,
        `Objetivo: ${data.get('objetivo') || 'não informado'}`
      ].join('\n');
      window.open(`https://wa.me/${number}?text=${encodeURIComponent(text)}`, '_blank', 'noopener');
    });
  }
})();
