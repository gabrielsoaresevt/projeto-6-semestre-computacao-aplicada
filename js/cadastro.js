// Validação de cadastro/senha em tempo real
document.addEventListener('DOMContentLoaded', () => {
  const raInput = document.getElementById('ra');
  const senhaInput = document.getElementById('senha');
  const confirmarInput = document.getElementById('confirmar_senha');
  const form = document.querySelector('form');

  const rLower = document.getElementById('rLower');
  const rUpper = document.getElementById('rUpper');
  const rNum   = document.getElementById('rNum');
  const rSpec  = document.getElementById('rSpec');
  const createBtn = document.getElementById('createBtn');

  if (!senhaInput || !confirmarInput) return;

  // ------ Função de validação de senha ------
  function validate(senha) {
    const checks = {
      lower: /[a-z]/.test(senha),
      upper: /[A-Z]/.test(senha),
      num:   /[0-9]/.test(senha),
      spec:  /[!@#$%^&*()_+\-=\[\]{};:'",.<>?\\/|`~]/.test(senha),
      len:   senha.length >= 8
    };

    // Atualiza indicadores visuais
    if (rLower) rLower.className = checks.lower ? 'ok' : 'no';
    if (rUpper) rUpper.className = checks.upper ? 'ok' : 'no';
    if (rNum)   rNum.className   = checks.num   ? 'ok' : 'no';
    if (rSpec)  rSpec.className  = checks.spec  ? 'ok' : 'no';

    return Object.values(checks).every(Boolean);
  }

  // ------ Validação em tempo real ------
  senhaInput.addEventListener('input', () => {
    validate(senhaInput.value);

    if (confirmarInput.value.length > 0) {
      confirmarInput.style.borderColor =
        senhaInput.value === confirmarInput.value ? '#4CAF50' : '#f44336';
    }
  });

  confirmarInput.addEventListener('input', () => {
    confirmarInput.style.borderColor =
      senhaInput.value === confirmarInput.value ? '#4CAF50' : '#f44336';
  });

  // ------ Validação ao enviar (Submit) ------
  if (form) {
    form.addEventListener('submit', (e) => {
      const ra = raInput.value.trim();
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

  // ------ Botão de criação (localStorage) ------
  if (createBtn) {
    createBtn.addEventListener('click', () => {
      const ra = raInput.value.trim();
      const pw = senhaInput.value;

      if (!ra) {
        alert('Informe seu RA.');
        raInput.focus();
        return;
      }

      if (!validate(pw)) {
        alert('Senha inválida: verifique os requisitos.');
        senhaInput.focus();
        return;
      }

      // Simulação usando localStorage
      const usersRaw = localStorage.getItem('uninove_users');
      const users = usersRaw ? JSON.parse(usersRaw) : {};

      // Atenção: apenas simulação — nunca salve senhas assim em produção
      users[ra] = pw;
      localStorage.setItem('uninove_users', JSON.stringify(users));

      alert('Senha criada com sucesso! Agora faça login.');
      window.location.href = 'login.html';
    });
  }
});