// Validação de cadastro/senha em tempo real com checks dinâmicos
document.addEventListener('DOMContentLoaded', () => {
  const raInput = document.getElementById('ra');
  const senhaInput = document.getElementById('senha');
  const confirmarInput = document.getElementById('confirmar_senha');
  const form = document.querySelector('form');

  // Elementos de requisitos
  const reqLen = document.getElementById('req-len');
  const reqLower = document.getElementById('req-lower');
  const reqUpper = document.getElementById('req-upper');
  const reqNum = document.getElementById('req-num');
  const reqSpec = document.getElementById('req-spec');

  function checkPassword(pw) {
    const checks = {
      len: pw.length >= 8,
      lower: /[a-z]/.test(pw),
      upper: /[A-Z]/.test(pw),
      num: /[0-9]/.test(pw),
      spec: /[!@#$%^&*()_+\-=[\]{};:'".,<>?/\\|`~]/.test(pw)
    };

    // Atualizar visual dos requisitos
    if (reqLen) {
      checks.len ? reqLen.classList.add('atendido') : reqLen.classList.remove('atendido');
    }
    if (reqLower) {
      checks.lower ? reqLower.classList.add('atendido') : reqLower.classList.remove('atendido');
    }
    if (reqUpper) {
      checks.upper ? reqUpper.classList.add('atendido') : reqUpper.classList.remove('atendido');
    }
    if (reqNum) {
      checks.num ? reqNum.classList.add('atendido') : reqNum.classList.remove('atendido');
    }
    if (reqSpec) {
      checks.spec ? reqSpec.classList.add('atendido') : reqSpec.classList.remove('atendido');
    }

    return Object.values(checks).every(Boolean);
  }

  if (!senhaInput || !confirmarInput) return;

  // Validar senha em tempo real e atualizar checks
  senhaInput.addEventListener('input', () => {
    const pw = senhaInput.value;
    checkPassword(pw);

    // Feedback de confirmação
    if (confirmarInput.value) {
      confirmarInput.style.borderColor = (pw === confirmarInput.value) ? '#4CAF50' : '#f44336';
    }
  });

  // Feedback de confirmação
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

      if (!checkPassword(senha)) {
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
