const btnRA = document.getElementById("btn-ra");
const btnCPF = document.getElementById("btn-cpf");
const raInput = document.getElementById("ra-input");
const cpfInput = document.getElementById("cpf-input");

btnRA.addEventListener("click", () => {
  btnRA.classList.add("active");
  btnCPF.classList.remove("active");
  raInput.style.display = "block";
  cpfInput.style.display = "none";
});

btnCPF.addEventListener("click", () => {
  btnCPF.classList.add("active");
  btnRA.classList.remove("active");
  raInput.style.display = "none";
  cpfInput.style.display = "block";
});
