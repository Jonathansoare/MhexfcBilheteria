// ==============================
// MOSTRAR PIX AUTOMÁTICO
// ==============================
function mostrarPix() {
  const box = document.querySelector('.pagamento-container');
  const area = document.getElementById('areaPagamento');

  // Tela PIX (sem botões)
  area.innerHTML = `
    <div class="pix-area">
      <p class="pix-status">🕒 ${box.dataset.waitPix}</p>
      <div class="pix-timer">${box.dataset.timeLeft}: <span id="pixTimer">10:00</span></div>
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PIX-EXEMPLO" alt="QR Code PIX">
      <div class="pix-codigo-wrapper">
        <input type="text" id="pixCodigo" value="00020126580014BR.GOV.BCB.PIX.483274726476237647236476278" readonly>
      </div>
    </div>
  `;

  iniciarContadorPix(10 * 60);

  // Vai automaticamente para a tela de loading após 5 segundos
  setTimeout(() => mostrarLoading(), 5000);
}

// ==============================
// MOSTRAR CARTÃO AUTOMÁTICO
// ==============================
function mostrarCartao() {
  const box = document.querySelector('.pagamento-container');
  const area = document.getElementById('areaPagamento');
  const opcoes = document.querySelector('.pagamento-opcoes');
  const titulo = document.querySelector('.pagamento-container h2');
  const conteiner = document.querySelector('.pagamento-container');

  if(conteiner){
    conteiner.style.background = 'none';
    conteiner.style.boxShadow = 'none';
  }
  if(opcoes) opcoes.style.display = 'none';
  if(titulo) titulo.style.display = 'none';

  // Tela cartão (sem botões)
  area.innerHTML = `
    <div class="cartao-area">
  <div class="cartao-field">
    <label for="cardName">💳 ${box.dataset.cardName}</label>
    <input type="text" id="cardName" placeholder="${box.dataset.cardName}" readonly class="no-focus">
  </div>

  <div class="cartao-field">
    <label for="cardNumber">🔢 ${box.dataset.cardNumber}</label>
    <input type="text" id="cardNumber" placeholder="${box.dataset.cardNumber}" readonly class="no-focus">
  </div>

  <div class="cartao-row">
    <div class="cartao-field small">
      <label for="cardExp">📅 ${box.dataset.cardExp}</label>
      <input type="text" id="cardExp" placeholder="${box.dataset.cardExp}" readonly class="no-focus">
    </div>
    <div class="cartao-field small">
      <label for="cardCvv">🔒 ${box.dataset.cardCvv}</label>
      <input type="text" id="cardCvv" placeholder="${box.dataset.cardCvv}" readonly class="no-focus">
    </div>
  </div>

  <button class="btn-pagar" onclick="simularPagamento()">${box.dataset.pay}</button>
</div>
  `;

  // Vai automaticamente para a tela de loading após 5 segundos
  setTimeout(() => mostrarLoading(), 5000);
}

// ==============================
// CONTADOR PIX
// ==============================
let pixInterval;
function iniciarContadorPix(segundos) {
  const timerEl = document.getElementById('pixTimer');
  let tempo = segundos;

  if (pixInterval) clearInterval(pixInterval);

  pixInterval = setInterval(() => {
    const min = Math.floor(tempo / 60);
    const sec = tempo % 60;
    timerEl.innerText = `${min}:${sec.toString().padStart(2,'0')}`;
    tempo--;

    if (tempo < 0) {
      clearInterval(pixInterval);
      timerEl.innerText = "00:00";
    }
  }, 1000);
}

// ==============================
// TELA DE LOADING ANIMADO
// ==============================
function mostrarLoading() {
  const area = document.getElementById('areaPagamento');
  const opcoes = document.querySelector('.pagamento-opcoes');
  const titulo = document.querySelector('.pagamento-container h2');

  if(opcoes) opcoes.style.display = 'none';
  if(titulo) titulo.style.display = 'none';

  const box = document.querySelector('.pagamento-container');

  area.innerHTML = `
    <div class="loading-area">
      <div class="loader"></div>
      <p>${box.dataset.loadingText}</p>
    </div>
  `;

  // Depois de 3 segundos, vai para a tela final
  setTimeout(() => mostrarTelaTudoCerto(), 3000);
}

// ==============================
// TELA FINAL "TUDO CERTO"
// ==============================
function mostrarTelaTudoCerto() {
  const area = document.getElementById('areaPagamento');
  const opcoes = document.querySelector('.pagamento-opcoes');
  const titulo = document.querySelector('.pagamento-container h2');
  const conteiner = document.querySelector('.pagamento-container');

  if(conteiner){
    conteiner.style.background = 'none';
    conteiner.style.boxShadow = 'none';
  }
  if(opcoes) opcoes.style.display = 'none';
  if(titulo) titulo.style.display = 'none';

  const box = document.querySelector('.pagamento-container');

  area.innerHTML = `
    <div class="final-area">
      <div class="final-card">
        <div class="final-icon">✅</div>
        <h2>${box.dataset.finalTitle}</h2>
        <p>${box.dataset.finalMessage}</p>
        <p>${box.dataset.finalRules}</p>
        <p>${box.dataset.finalEnjoy}</p>
      </div>
    </div>
  `;
}