<<<<<<< HEAD
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
=======
const toggleBtn = document.getElementById("toggle-theme");

toggleBtn.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");
  toggleBtn.textContent = document.body.classList.contains("dark-mode")
    ? "Modo Claro"
    : "Modo Escuro";
});
>>>>>>> 1526cf9129c816ec86f23245fc63f6e562501c40
