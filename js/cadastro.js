// Validação de cadastro/senha em tempo real
document.addEventListener('DOMContentLoaded', () => {
  const raInput = document.getElementById('ra');
  const senhaInput = document.getElementById('senha');
  const confirmarInput = document.getElementById('confirmar_senha');
  const form = document.querySelector('form');

  if (!senhaInput || !confirmarInput) return;

  // Validar confirmação de senha em tempo real
  senhaInput.addEventListener('input', () => {
    const senha = senhaInput.value;
    if (confirmarInput.value) {
      if (senha === confirmarInput.value) {
        confirmarInput.style.borderColor = '#4CAF50';
      } else {
        confirmarInput.style.borderColor = '#f44336';
      }
    }
  });

  confirmarInput.addEventListener('input', () => {
    if (senhaInput.value) {
      if (senhaInput.value === confirmarInput.value) {
        confirmarInput.style.borderColor = '#4CAF50';
      } else {
        confirmarInput.style.borderColor = '#f44336';
      }
    }
  });

  // Validar ao enviar
  if (form) {
    form.addEventListener('submit', (e) => {
      const ra = raInput.value.trim();
      const senha = senhaInput.value;
      const confirmar = confirmarInput.value;

      // Validar RA
      if (!ra) {
        e.preventDefault();
        alert('Digite seu RA!');
        return;
      }

      // Verificar requisitos de senha
      const temLength = senha.length >= 8;
      const temLower = /[a-z]/.test(senha);
      const temUpper = /[A-Z]/.test(senha);
      const temNumber = /[0-9]/.test(senha);
      const temSpecial = /[!@#$%^&*()_+\-=\[\]{};:'"",.<>?\\/\\|`~]/.test(senha);

      if (!temLength || !temLower || !temUpper || !temNumber || !temSpecial) {
        e.preventDefault();
        alert('Senha não atende aos requisitos de segurança!');
        return;
      }

      // Verificar se as senhas são iguais
      if (senha !== confirmar) {
        e.preventDefault();
        alert('As senhas não conferem!');
        return;
      }
    });
  }
});
  rLower.className = checks.lower ? 'ok' : 'no';
  rUpper.className = checks.upper ? 'ok' : 'no';
  rNum.className = checks.num ? 'ok' : 'no';
  rSpec.className = checks.spec ? 'ok' : 'no';
  return Object.values(checks).every(Boolean);
}

password.addEventListener('input', (e) => {
  validate(e.target.value);
});

createBtn.addEventListener('click', () => {
  const ra = raInput.value.trim();
  const pw = password.value;

  if (!ra) {
    alert('Informe seu RA.');
    raInput.focus();
    return;
  }

  if (!validate(pw)) {
    alert('Senha inválida: verifique os requisitos.');
    password.focus();
    return;
  }

  // Save to localStorage (simulation of backend)
  // Structure: store single user or object of users
  const usersRaw = localStorage.getItem('uninove_users');
  const users = usersRaw ? JSON.parse(usersRaw) : {};

  // Save as plain text (NOTE: só para simulação — em produção NÃO FAÇA)
  users[ra] = pw;
  localStorage.setItem('uninove_users', JSON.stringify(users));

  alert('Senha criada com sucesso! Agora faça login.');
  window.location.href = 'login.html';
});
