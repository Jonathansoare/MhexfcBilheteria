
function abrirModal() {
  const modal = document.getElementById('termosTicketModal');
  if (modal) modal.classList.add('show');
}

function fecharModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.remove('.overlay.show ');
}

document.addEventListener('DOMContentLoaded', () => {
  const checkbox = document.getElementById('aceiteTermos');
  const btn = document.getElementById('btnConfirmar');

  if (checkbox && btn) {
    checkbox.addEventListener('change', () => {
      btn.disabled = !checkbox.checked;
    });
  }
});

function cancelarTermos() {
  const btn = document.getElementById('btnCancelar');
  const modal = document.getElementById('termosTicketModal');

  btn.addEventListener('click', () => {
    modal.classList.remove('show');
  });
}
