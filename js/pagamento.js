function mostrarPix() {
  const box = document.querySelector('.pagamento-container');

  document.getElementById('areaPagamento').innerHTML = `
    <div class="pix-area">
      <p class="pix-status">🕒 ${box.dataset.waitPix}</p>

      <div class="pix-timer">
        ${box.dataset.timeLeft}: <span id="pixTimer">10:00</span>
      </div>

      <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PIX-EXEMPLO">

      <div class="pix-codigo-wrapper">
        <input type="text" id="pixCodigo" value="00020126580014BR.GOV.BCB.PIX.483274726476237647236476278" readonly>
        <button onclick="copiarPix()">${box.dataset.copyPix}</button>
      </div>
    </div>
  `;

  iniciarContadorPix(10 * 60);
}

function copiarPix() {
  const input = document.getElementById('pixCodigo');
  input.select();
  input.setSelectionRange(0, 99999);
  document.execCommand("copy");
  alert("✔️ PIX copiado!");
}

function iniciarContadorPix(segundos) {
  const timerEl = document.getElementById('pixTimer');
  const statusEl = document.querySelector('.pix-status');
  const box = document.querySelector('.pagamento-container');

  let tempo = segundos;

  const interval = setInterval(() => {
    const min = Math.floor(tempo / 60);
    const sec = tempo % 60;
    timerEl.innerText = `${min}:${sec.toString().padStart(2, '0')}`;

    tempo--;

    if (tempo < 0) {
      clearInterval(interval);
      timerEl.innerText = "00:00";
      statusEl.innerText = `❌ ${box.dataset.pixExpired} ${box.dataset.newPayment}`;
    }
  }, 1000);
}

function mostrarCartao() {
  const box = document.querySelector('.pagamento-container');

  document.getElementById('areaPagamento').innerHTML = `
    <div class="cartao-area">
      <input type="text" placeholder="${box.dataset.cardName}">
      <input type="text" placeholder="${box.dataset.cardNumber}">
      <div class="cartao-linha">
        <input type="text" placeholder="${box.dataset.cardExp}">
        <input type="text" placeholder="${box.dataset.cardCvv}">
      </div>
      <button>${box.dataset.pay}</button>
    </div>
  `;
}
