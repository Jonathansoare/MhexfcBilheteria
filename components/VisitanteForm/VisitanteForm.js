 // Alterna visibilidade entre CPF e Passaporte
  function trocarDocumento() {
    const tipo = document.getElementById('tipoVisitante').value;
    const cpf = document.getElementById('cpf');
    const passaporte = document.getElementById('passaporte');
    const labelCpf = document.getElementById('label-cpf');
    const labelPassaporte = document.getElementById('label-passaporte');

    if(tipo === 'br') {
      cpf.style.display = 'block';
      labelCpf.style.display = 'block';
      passaporte.style.display = 'none';
      labelPassaporte.style.display = 'none';
    } else {
      cpf.style.display = 'none';
      labelCpf.style.display = 'none';
      passaporte.style.display = 'block';
      labelPassaporte.style.display = 'block';
    }
  }

  
function validCpf(cpf) {
  cpf = cpf.replace(/[^\d]+/g,'');
  if(cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
}

function validarForm() {
  let valid = true;
  const tipo = document.getElementById('tipoVisitante').value;

  const nome = document.getElementById('nome').value.trim();
  if (nome.length < 3) {
    document.getElementById('nome').style.border = '1px solid red'
    valid = false;

  }

  if(tipo==='br') {
    const cpf = document.getElementById('cpf').value.replace(/\D/g,'');
    if(!validCpf(cpf)){ document.getElementById('cpf').style.border = '1px solid red'; valid=false; }
  } else {
    const passaporte = document.getElementById('passaporte').value.trim();
    if(passaporte.length < 6){ document.getElementById('passaporte').style.border = '1px solid red'; valid=false; }
  }

  const email = document.getElementById('email').value.trim();
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if(!emailRegex.test(email)){ document.getElementById('email').style.border = '1px solid red'; valid=false; }

  const telefone = document.getElementById('telefone').value.trim();
  if(telefone.length < 10){ document.getElementById('telefone').style.border = '1px solid red'; valid=false; }

  return valid;
}
