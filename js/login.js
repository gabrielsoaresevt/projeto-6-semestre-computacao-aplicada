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

// Formatação automática de CPF
cpfInput.addEventListener("input", (e) => {
  let value = e.target.value.replace(/\D/g, ""); // Remove tudo que não é dígito
  
  if (value.length > 11) {
    value = value.slice(0, 11); // Limita a 11 dígitos
  }
  
  // Formata: XXX.XXX.XXX-XX
  if (value.length <= 3) {
    e.target.value = value;
  } else if (value.length <= 6) {
    e.target.value = value.slice(0, 3) + "." + value.slice(3);
  } else if (value.length <= 9) {
    e.target.value = value.slice(0, 3) + "." + value.slice(3, 6) + "." + value.slice(6);
  } else {
    e.target.value = value.slice(0, 3) + "." + value.slice(3, 6) + "." + value.slice(6, 9) + "-" + value.slice(9);
  }
});
