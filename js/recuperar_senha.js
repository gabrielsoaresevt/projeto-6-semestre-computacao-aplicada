// Validação de email em recuperação de senha
document.addEventListener('DOMContentLoaded', () => {
  const emailInput = document.getElementById('email');
  const form = document.querySelector('form');

  if (!form) return;

  // Validar ao enviar
  form.addEventListener('submit', (e) => {
    const email = emailInput.value.trim();

    // Validar se o email está vazio
    if (!email) {
      e.preventDefault();
      alert('Digite seu email!');
      return;
    }

    // Validar formato do email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      e.preventDefault();
      alert('Email inválido!');
      return;
    }
  });
});
