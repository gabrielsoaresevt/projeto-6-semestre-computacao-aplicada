// Dashboard JS: modo escuro
const toggleBtn = document.getElementById('mode');

if (toggleBtn) {
  toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    toggleBtn.textContent = document.body.classList.contains('dark-mode')
      ? 'Modo Claro'
      : 'Modo Escuro';
  });
}
