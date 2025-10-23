// js/dashboard.js
const greet = document.getElementById('greet');
const logout = document.getElementById('logout');

const ra = sessionStorage.getItem('loggedRA');
if (!ra) {
  // no session -> redirect to login
  window.location.href = 'login.html';
} else {
  // Display RA or a nicer name. The example image shows "Emilly" — you can adapt.
  // For demo we show RA and a friendly name (if you want to change, edit below)
  greet.innerHTML = `Olá, ${ra}!`;
}

logout.addEventListener('click', () => {
  sessionStorage.removeItem('loggedRA');
  window.location.href = 'login.html';
});
