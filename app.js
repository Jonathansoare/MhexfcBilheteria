const prices = {
  inteira: 10,
  meia: 5,
  isento: 0
};

function vibrar() {
  if (navigator.vibrate) navigator.vibrate(30);
}

function abrirModal() {
  const lista = document.getElementById('modalLista');
  lista.innerHTML = '';

  let total = 0;

  ['inteira','meia','isento'].forEach(id => {
    const qtd = parseInt(document.getElementById('i-' + id).value);

    if (qtd > 0) {
      const ticketEl = document.querySelector('#i-' + id).closest('.ticket');
      const label = ticketEl.querySelector('strong').innerText;
      const preco = parseFloat(
        ticketEl.querySelector('span').innerText.replace('R$','').replace(',','.')
      );

      const subtotal = qtd * preco;
      total += subtotal;

      lista.innerHTML += `
        <div class="modal-item">
          <span>${label} (${qtd})</span>
          <strong>R$ ${subtotal.toFixed(2).replace('.',',')}</strong>
        </div>`;
    }
  });

  document.getElementById('modalValidade').innerText =
    document.getElementById('validadeTexto').innerText;

  document.getElementById('modalTotal').innerText =
    total.toFixed(2).replace('.',',');

  document.getElementById('modalConfirmacao').classList.add('show');
}

function fecharModal() {
  document.getElementById('modalConfirmacao').classList.remove('show');
}

function confirmarPagamento() {
  const total = document.getElementById('modalTotal').innerText;
  const validade = document.getElementById('modalValidade').innerText;

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = "http://localhost/bilheteria/screens/pagamento.php"; // Caminho absoluto

  const inputTotal = document.createElement('input');
  inputTotal.type = 'hidden';
  inputTotal.name = 'total';
  inputTotal.value = total;

  const inputValidade = document.createElement('input');
  inputValidade.type = 'hidden';
  inputValidade.name = 'validade';
  inputValidade.value = validade;

  form.appendChild(inputTotal);
  form.appendChild(inputValidade);

  document.body.appendChild(form);
  form.submit();
}


