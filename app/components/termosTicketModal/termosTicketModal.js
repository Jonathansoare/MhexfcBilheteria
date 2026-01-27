// Abre o modal de termos
function abrirModal() {
  const modal = document.getElementById('termosTicketModal');
  if (modal) modal.classList.add('show');
}

// Fecha o modal
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

  // Botão Confirmar envia para a rota “dados” do router
  if (btnConfirmar) {
    btnConfirmar.addEventListener('click', () => {
      enviarParaDadosPessoa();
    });
  }
});

// Função para enviar o formulário para a rota correta via Router
function enviarParaDadosPessoa() {
  const form = document.getElementById('form');

  if (!form) {
    console.error('Form não encontrado');
    return;
  }

  // Rota via Router
  form.action = '/bilheteria/?route=dados';
  form.method = 'POST';
  form.submit();
}