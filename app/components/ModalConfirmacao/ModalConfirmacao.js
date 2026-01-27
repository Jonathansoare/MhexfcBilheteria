function abrirModal() {
  const modal = document.getElementById('modalHome');
  const modalList = modal.querySelector('.modal-list');
  modalList.innerHTML = '';

  const ingressos = [];
  let totalGeral = 0;
  const validade = document.getElementById('validadeTexto').innerText;

  document.querySelectorAll('.ticket').forEach(ticket => {
    const id = ticket.querySelector('input[type="hidden"]').id.replace('i-', '');
    const label = ticket.querySelector('.ticket-info strong').innerText;
    const price = parseFloat(ticket.querySelector('input[type="hidden"]').dataset.price);
    const qty = parseInt(document.getElementById(`q-${id}`).innerText);

    if (qty > 0) {
      ingressos.push({ label, qtd: qty, total: price * qty });
    }
  });

  ingressos.forEach(i => {
    const div = document.createElement('div');
    div.className = 'modal-item';
    div.innerHTML = `<span>${i.label} x ${i.qtd}</span><span>R$ ${i.total.toFixed(2).replace('.',',')}</span>`;
    modalList.appendChild(div);
    totalGeral += i.total;
  });

  modalList.innerHTML += `<div class="modal-item"><span>Validade:</span><span>${validade}</span></div>`;
  modalList.innerHTML += `<div class="modal-item total"><span>Total:</span><span>R$ ${totalGeral.toFixed(2).replace('.',',')}</span></div>`;

  modal.classList.add('show');
}

function fecharModal(id) {
  document.getElementById(id).classList.remove('show');
}

function confirmarPagamento() {
  const ingressos = [];
  let total = 0;
  const validade = document.getElementById('validadeTexto').innerText;

  document.querySelectorAll('.ticket').forEach(ticket => {
    const id = ticket.querySelector('input[type="hidden"]').id.replace('i-', '');
    const label = ticket.querySelector('.ticket-info strong').innerText;
    const price = parseFloat(ticket.querySelector('input[type="hidden"]').dataset.price);
    const qty = parseInt(document.getElementById(`q-${id}`).innerText);

    if (qty > 0) {
      ingressos.push(`${qty}x ${label}`);
      total += qty * price;
    }
  });

  fetch('/bilheteria/actions/salvarResumo.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ ingressos, validade, total })
  }).then(() => {
    window.location.href = '/bilheteria/screens/dadosPesson.php';
  });
}


function enviarParaPagamento() {
  const form = document.getElementById('form');

  // Cria inputs hidden com os dados do resumo (se ainda não existirem)
  const modal = document.getElementById('modalHome');

  // Remove antigos (evita duplicar)
  document.querySelectorAll('.resumo-hidden').forEach(e => e.remove());

  // Validade
  const validade = document.getElementById('validade').value;
  const inputValidade = document.createElement('input');
  inputValidade.type = 'hidden';
  inputValidade.name = 'validade';
  inputValidade.value = validade;
  inputValidade.className = 'resumo-hidden';
  form.appendChild(inputValidade);

  // Quantidades já estão no form: quantities[...]

  // Envia o form
  form.action = '/bilheteria/screens/dadosPesson.php';
  form.method = 'POST';
  form.submit();
}


