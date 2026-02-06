function abrirModal() {
  const modal = document.getElementById('termosTicketModal');
  if (modal) modal.classList.add('show');
}

function fecharModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.remove('show');
}

document.addEventListener('DOMContentLoaded', () => {
  const checkbox = document.getElementById('aceiteTermos');
  const btnConfirmar = document.getElementById('btnConfirmar');
  const btnCancelar = document.getElementById('btnCancelar');
  const modal = document.getElementById('termosTicketModal');

  if (checkbox && btnConfirmar) {
    checkbox.addEventListener('change', () => {
      btnConfirmar.disabled = !checkbox.checked;
    });
  }

  if (btnCancelar && modal) {
    btnCancelar.addEventListener('click', () => {
      modal.classList.remove('show');
    });
  }

  if (btnConfirmar) {
    btnConfirmar.addEventListener('click', enviarParaDadosPessoa);
  }
});

function enviarParaDadosPessoa() {
  const form = document.getElementById('form');
  if (!form) {
    console.error('Form não encontrado');
    return;
  }

  form.action = '/bilheteria/dados';
  form.method = 'POST';
  form.submit();
}
