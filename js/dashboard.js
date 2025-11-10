const greet = document.getElementById('greet');
const logout = document.getElementById('logout');

const ra = sessionStorage.getItem('loggedRA');
if (!ra) {
  window.location.href = 'login.html';
} else {
  greet.innerHTML = `Olá, ${ra}!`;
}

logout.addEventListener('click', () => {
  sessionStorage.removeItem('loggedRA');
  window.location.href = 'login.html';
});
