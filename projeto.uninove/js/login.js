// js/login.js

const loginRA = document.getElementById('loginRA');
const loginPw = document.getElementById('loginPw');
const loginBtn = document.getElementById('loginBtn');
const eye2 = document.getElementById('eye2');

eye2.addEventListener('click', () => {
  loginPw.type = loginPw.type === 'password' ? 'text' : 'password';
});

// NOTE: intentional bug: case-insensitive comparison (this is the "erro proposital")
loginBtn.addEventListener('click', () => {
  const ra = loginRA.value.trim();
  const pw = loginPw.value;

  if (!ra) { alert('Informe seu RA'); return; }
  if (!pw) { alert('Informe sua senha'); return; }

  const usersRaw = localStorage.getItem('uninove_users');
  const users = usersRaw ? JSON.parse(usersRaw) : {};

  if (!users[ra]) {
    alert('Usuário não encontrado. Verifique o RA ou faça primeiro acesso.');
    return;
  }

  const saved = users[ra];

  // INTENTIONAL BUG: compare lowercase versions -> ignores case
  if (saved.toLowerCase() === pw.toLowerCase()) {
    // success: store current session (simple)
    sessionStorage.setItem('loggedRA', ra);
    window.location.href = 'dashboard.html';
  } else {
    alert('Senha incorreta.');
  }
});
