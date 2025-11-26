// Validação de cadastro/senha em tempo real
document.addEventListener('DOMContentLoaded', () => {
  const raInput = document.getElementById('ra');
  const senhaInput = document.getElementById('senha');
  const confirmarInput = document.getElementById('confirmar_senha');
  const form = document.querySelector('form');

  function validate(pw) {
    const checks = {
      len: pw.length >= 8,
      lower: /[a-z]/.test(pw),
      upper: /[A-Z]/.test(pw),
      num: /[0-9]/.test(pw),
      spec: /[!@#$%^&*()_+\-=[\]{};:'".,<>?/\\|`~]/.test(pw)
    };
    return Object.values(checks).every(Boolean);
  }

  if (!senhaInput || !confirmarInput) return;

  // Feedback de confirmação
  senhaInput.addEventListener('input', () => {
    if (confirmarInput.value) {
      confirmarInput.style.borderColor = (senhaInput.value === confirmarInput.value) ? '#4CAF50' : '#f44336';
    }
  });

  confirmarInput.addEventListener('input', () => {
    if (senhaInput.value) {
      confirmarInput.style.borderColor = (senhaInput.value === confirmarInput.value) ? '#4CAF50' : '#f44336';
    }
  });

  // Validar ao enviar
  if (form) {
    form.addEventListener('submit', (e) => {
      const ra = raInput ? raInput.value.trim() : '';
      const senha = senhaInput.value;
      const confirmar = confirmarInput.value;

      if (!ra) {
        e.preventDefault();
        alert('Digite seu RA!');
        return;
      }

      if (!validate(senha)) {
        e.preventDefault();
        alert('Senha não atende aos requisitos de segurança!');
        return;
      }

      if (senha !== confirmar) {
        e.preventDefault();
        alert('As senhas não conferem!');
        return;
      }
    });
  }
});
