// js/cadastro.js

// helper: check requirements
const password = document.getElementById('password');
const raInput = document.getElementById('ra');

const rLen = document.getElementById('rLen');
const rLower = document.getElementById('rLower');
const rUpper = document.getElementById('rUpper');
const rNum = document.getElementById('rNum');
const rSpec = document.getElementById('rSpec');

const togglePw = document.getElementById('togglePw');
const createBtn = document.getElementById('createBtn');

togglePw.addEventListener('click', () => {
  password.type = password.type === 'password' ? 'text' : 'password';
});

// validation function
function validate(pw){
  const checks = {
    len: pw.length >= 8,
    lower: /[a-z]/.test(pw),
    upper: /[A-Z]/.test(pw),
    num: /\d/.test(pw),
    spec: /[^\w\s]/.test(pw)
  };
  // update UI
  rLen.className = checks.len ? 'ok' : 'no';
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
