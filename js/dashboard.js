// Dashboard JS: modo escuro/claro
const toggleBtn = document.getElementById('mode');

if (toggleBtn) {
  // Carrega preferência salva no localStorage
  const savedDarkMode = localStorage.getItem('darkMode') === 'true';
  if (savedDarkMode) {
    document.body.classList.add('dark-mode');
    toggleBtn.textContent = 'Modo Claro';
  } else {
    toggleBtn.textContent = 'Modo Escuro';
  }

  // Toggle e salva preferência
  toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const isDarkMode = document.body.classList.contains('dark-mode');
    toggleBtn.textContent = isDarkMode ? 'Modo Claro' : 'Modo Escuro';
    localStorage.setItem('darkMode', isDarkMode);
  });
}

