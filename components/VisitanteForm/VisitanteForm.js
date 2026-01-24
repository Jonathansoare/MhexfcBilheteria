function trocarDocumento() {
  const tipo = document.getElementById('tipoVisitante').value;
  const cpfInput = document.getElementById('cpf');
  const passaporteInput = document.getElementById('passaporte');
  const cpfLabel = document.getElementById('label-cpf');
  const passLabel = document.getElementById('label-passaporte');

  if (tipo === 'gringo') {
    cpfInput.style.display = "none";
    cpfLabel.style.display = "none";
    passaporteInput.style.display = "block";
    passLabel.style.display = "block";
    cpfInput.required = false;
    passaporteInput.required = true;
  } else {
    cpfInput.style.display = "block";
    cpfLabel.style.display = "block";
    passaporteInput.style.display = "none";
    passLabel.style.display = "none";
    cpfInput.required = true;
    passaporteInput.required = false;
  }
}


function validarForm() {
  const tipo = document.getElementById('tipoVisitante').value;
  const nome = document.getElementById('nome').value.trim();
  const cpf = document.getElementById('cpf').value.trim();
  const passaporte = document.getElementById('passaporte').value.trim();
  const email = document.getElementById('email').value.trim();
  const telefone = document.getElementById('telefone').value.trim();

  if (!nome || !email || !telefone || (tipo === 'br' && !cpf) || (tipo === 'gringo' && !passaporte)) {
    alert("Preencha todos os campos obrigatórios.");
    return;
  }

  if (!email.includes("@")) {
    alert("Digite um e-mail válido.");
    return;
  }

  if (tipo === 'br' && !validarCPF(cpf)) {
    alert("CPF inválido.");
    return;
  }

  // Cria form invisível pra enviar tudo via POST
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "/bilheteria/screens/pagamento.php";

  adicionarCampo(form, "tipo", tipo);
  adicionarCampo(form, "nome", nome);
  adicionarCampo(form, "cpf", cpf);
  adicionarCampo(form, "passaporte", passaporte);
  adicionarCampo(form, "email", email);
  adicionarCampo(form, "telefone", telefone);

  // 👉 Tickets e validade (se existirem)
  document.querySelectorAll("input[name^='quantities']").forEach(input => {
    adicionarCampo(form, input.name, input.value);
  });

  const validade = document.querySelector("input[name='validade']")?.value;
  if (validade) {
    adicionarCampo(form, "validade", validade);
  }

  document.body.appendChild(form);
  form.submit();
}

// ================= Helpers =================

function adicionarCampo(form, nome, valor) {
  const input = document.createElement("input");
  input.type = "hidden";
  input.name = nome;
  input.value = valor;
  form.appendChild(input);
}

function validarCPF(cpf) {
  cpf = cpf.replace(/\D/g, '');
  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

  let soma = 0, resto;

  for (let i = 1; i <= 9; i++)
    soma += parseInt(cpf.substring(i-1, i)) * (11 - i);

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(9, 10))) return false;

  soma = 0;
  for (let i = 1; i <= 10; i++)
    soma += parseInt(cpf.substring(i-1, i)) * (12 - i);

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(10, 11))) return false;

  return true;
}
