<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SESSION['user_tipo'] !== 'bilheteiro') {
  header("Location: /bilheteria/bilheteiro/dashboard"); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Validação de Ingressos</title>
<script src="https://unpkg.com/html5-qrcode"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body{
  margin:0;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
  font-family:'Inter',sans-serif;
  display:flex;
  align-items:center;
  justify-content:center;
  height:100vh;
}

/* App container */
.app{
  background:#fff;
  width:100%;
  max-width:420px;
  height:90vh;
  border-radius:20px;
  padding:16px;
  display:flex;
  flex-direction:column;
  gap:12px;
  box-shadow:0 12px 30px rgba(0,0,0,.25);
}

/* Top bar */
.top-bar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:14px;
  color:#333;
}

/* Scanner */
#qr-reader{
  width:100%;
  aspect-ratio:1/1;
  border-radius:14px;
  overflow:hidden;
  background:#000;
}

/* Overlay modal */
.modal-overlay{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.6);
  display:none;
  align-items:center;
  justify-content:center;
  z-index:999;
}

/* Modal box */
.modal{
  background:#fff;
  padding:22px;
  border-radius:18px;
  width:90%;
  max-width:360px;
  display:flex;
  flex-direction:column;
  align-items:flex-start; /* 👈 tudo à esquerda por padrão */
  animation:pop .25s ease;
  box-shadow:0 12px 28px rgba(0,0,0,.25);
}

/* Title */
.modal-title{
  width:100%;
  text-align:center;
  font-size:18px;
  font-weight:700;
  color:#1e3c72;
  margin:4px 0 10px;
}

/* Resultado container à ESQUERDA */
.resultados{
  width:100%;
  margin-top:8px;
  display:flex;
  flex-direction:column;
  gap:6px;
  text-align:left;
}

.modal button{
  align-self:center;   /* 👈 força o botão pro centro */
  margin-top:16px;
}

/* Linhas */
.resultados p,
.resultados li{
  margin:0;
  font-size:14px;
  color:#333;
}

/* Badge */
.badge{
  margin-top:12px;
  padding:6px 14px;
  border-radius:999px;
  font-weight:600;
  font-size:13px;
}

.valid{background:#e7f7ef;color:#0f7a3d}
.invalid{background:#fdecea;color:#b00020}

/* Botão */
button{
  margin-top:16px;
  padding:10px 20px;
  border:none;
  border-radius:999px;
  background:#1e3c72;
  color:#fff;
  font-weight:600;
  cursor:pointer;
  transition:.2s;
}
button:hover{
  background:#16325d;
}
@keyframes pop{
  from{transform:scale(.8);opacity:0}
  to{transform:scale(1);opacity:1}
}
</style>
</head>
<body>

<div class="app">
  <div class="top-bar">
    <strong>👤 Bilheteiro</strong>
    <a href="/bilheteria/bilheteiro/logout">Sair</a>
  </div>
  <h2 style="text-align:center">Validação</h2>
  <div id="qr-reader"></div>
</div>

<div class="modal-overlay" id="modal">
  <div class="modal">
    <h3 id="m-msg" class="modal-title">Resultado</h3>

    <p><strong>👤 Nome:</strong> <span id="m-nome"></span></p>
    <p><strong>🔐 Código:</strong> <span id="m-codigo"></span></p>

    <p><strong>📅 Data do ingresso:</strong> <span id="m-data"></span></p>
    <p><strong>⏰ Hora da leitura:</strong> <span id="m-hora"></span></p>
    <p><strong>⌛ Validade:</strong><span id="m-validade"></span></p>

    <div class="resultados">
      <span>🎟️ Inteira: <span id="m-inteira"></span></span>
      <span>🎫 Meia: <span id="m-meia"></span></span>
      <span>🆓 Isento: <span id="m-isento"></span></span>
      <div><span id="m-status" class="badge"></span></div>
    </div>

    <button id="close">Fechar</button>
  </div>
</div>


<script>
let lendo = false;
let timeoutScan = null;

const modal      = document.getElementById("modal");
const statusEl   = document.getElementById("m-status");
const msgEl      = document.getElementById("m-msg");
const nomeEl     = document.getElementById("m-nome");
const dataEl     = document.getElementById("m-data");
const inteiraEl  = document.getElementById("m-inteira");
const meiaEl     = document.getElementById("m-meia");
const isentoEl   = document.getElementById("m-isento");
const codigoEl   = document.getElementById("m-codigo");
const horaEl     = document.getElementById("m-hora");
const validadeEl = document.getElementById("m-validade");

function abrirModal(i) {
  // Preenche dados
  nomeEl.textContent    = i.nome || '---';
  codigoEl.textContent  = i.codigo || '---';
  dataEl.textContent    = i.data || '---';
  inteiraEl.textContent = i.quantidade?.Inteira || 0;
  meiaEl.textContent    = i.quantidade?.Meia || 0;
  isentoEl.textContent  = i.quantidade?.Isento || 0;
  validadeEl.textContent = i.dataValidade || '---';

  horaEl.textContent     = new Date().toLocaleTimeString('pt-BR');
  validadeEl.textContent = i.mensagem || '';

  // Status visual
  if (i.status === 'ok') {
    statusEl.className = 'badge valid';
    statusEl.textContent = 'VÁLIDO';
  } else {
    statusEl.className = 'badge invalid';
    statusEl.textContent = 'INVÁLIDO';
  }

  msgEl.textContent = i.mensagem || 'Resultado';

  modal.style.display = "flex";
  pararLeitura();
}

function pararLeitura() {
  try {
    html5QrCode.stop();
  } catch(e){}
}

function iniciarLeitura() {
  lendo = false;
  html5QrCode.start(
    { facingMode: "environment" },
    { fps: 12, qrbox: { width: 260, height: 260 } },
    onScanSuccess,
    () => {}
  );
}

function onScanSuccess(txt) {
  if (lendo) return;
  lendo = true;

  const codigo = txt.trim();
  msgEl.textContent = "🔎 Validando ingresso...";
  
  // Timeout de segurança
  timeoutScan = setTimeout(() => {
    lendo = false;
  }, 5000);

  fetch("/bilheteria/bilheteiro/validar?codigo=" + encodeURIComponent(codigo))
    .then(r => r.json())
    .then(data => {
      clearTimeout(timeoutScan);
      abrirModal(data);
    })
    .catch(err => {
      clearTimeout(timeoutScan);
      lendo = false;
      alert("Erro ao validar ingresso. Verifique a conexão.");
      iniciarLeitura();
    });
}

// Fechar modal
document.getElementById("close").onclick = () => {
  modal.style.display = "none";
  iniciarLeitura();
};

// Inicia leitura
const html5QrCode = new Html5Qrcode("qr-reader");
iniciarLeitura();
</script>
</body>
</html>
