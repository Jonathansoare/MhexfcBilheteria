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

  // Habilita botão Confirmar só se aceitar os termos
  if (checkbox && btnConfirmar) {
    checkbox.addEventListener('change', () => {
      btnConfirmar.disabled = !checkbox.checked;
    });
  }

  // Botão Cancelar fecha o modal
  if (btnCancelar && modal) {
    btnCancelar.addEventListener('click', () => {
      modal.classList.remove('show');
    });
  }
});

function enviarParaDadosPesson() {
  const form = document.getElementById('form'); // MESMO ID do seu form antigo

  if (!form) {
    console.error('Form não encontrado');
    return;
  }

  form.action = '/bilheteria/screens/dadosPesson.php';
  form.method = 'POST';
  form.submit();
}

