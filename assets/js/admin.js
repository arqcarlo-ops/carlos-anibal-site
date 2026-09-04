(() => {
  const b = document.getElementById('menuToggle');
  const s = document.getElementById('sidebar');
  if (b && s) b.addEventListener('click', () => s.classList.toggle('open'));
  document.querySelectorAll('[data-confirm]').forEach(el => el.addEventListener('click', e => {
    if (!confirm(el.dataset.confirm || 'Confirmar esta ação?')) e.preventDefault();
  }));
})();
