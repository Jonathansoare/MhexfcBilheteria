<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SESSION['user_tipo'] !== 'bilheteiro') {
  header("Location: /bilheteria/bilheteiro/dashboard");
  exit;
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
.app{
  background:#fff;
  width:100%;
  max-width:420px;
  height:92vh;
  border-radius:22px;
  padding:16px;
  display:flex;
  flex-direction:column;
  gap:12px;
  box-shadow:0 12px 30px rgba(0,0,0,.25);
}
.top-bar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:14px;
}
.switcher{
  display:flex;
  background:#eef2ff;
  border-radius:999px;
  padding:4px;
  gap:4px;
}
.switcher button{
  flex:1;
  border:none;
  background:transparent;
  padding:10px;
  border-radius:999px;
  font-weight:600;
  cursor:pointer;
}
.switcher button.active{
  background:#1e3c72;
  color:#fff;
}
#qr-reader{
  width:100%;
  aspect-ratio:1/1;
  border-radius:14px;
  overflow:hidden;
  background:#000;
}
.cpf-box{
  display:flex;
  gap:8px;
  margin-top:12px;
}
.cpf-box input{
  flex:1;
  padding:12px;
  border-radius:12px;
  border:1px solid #ccc;
  font-size:15px;
}
.cpf-box button{
  padding:12px 18px;
  border-radius:12px;
  border:none;
  background:#1e3c72;
  color:#fff;
  font-weight:600;
}
.modal-overlay{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.6);
  display:none;
  align-items:center;
  justify-content:center;
  z-index:999;
}
.modal{
  background:#fff;
  padding:22px;
  border-radius:18px;
  width:90%;
  max-width:360px;
  animation:pop .25s ease;
  box-shadow:0 12px 28px rgba(0,0,0,.25);
}
.modal-title{
  text-align:center;
  font-size:18px;
  font-weight:700;
  color:#1e3c72;
}
.resultados{
  margin-top:10px;
  font-size:14px;
  display:flex;
  flex-direction:column;
  gap:4px;
}
.badge{
  margin-top:10px;
  padding:6px 14px;
  border-radius:999px;
  font-weight:600;
  font-size:13px;
}
.valid{background:#e7f7ef;color:#0f7a3d}
.invalid{background:#fdecea;color:#b00020}

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

  <div class="switcher">
    <button id="btnQr" class="active">📷 QR Code</button>
    <button id="btnCpf">🧾 CPF</button>
  </div>

  <div id="modoQr">
    <div id="qr-reader"></div>
  </div>

  <div id="modoCpf" style="display:none;">
    <div class="cpf-box">
      <input type="text" id="cpfBusca" placeholder="Digite o CPF">
      <button onclick="buscarPorCPF()">Buscar</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="modal">
  <div class="modal">
    <h3 class="modal-title">Resultado</h3>
    <div class="resultados">
      <p><strong>👤 Nome:</strong> <span id="m-nome"></span></p>
      <p><strong>🔐 Código:</strong> <span id="m-codigo"></span></p>
      <p><strong>📅 Data:</strong> <span id="m-data"></span></p>
      <p><strong>🎟️ Inteira:</strong> <span id="m-inteira"></span></p>
      <p><strong>🎫 Meia:</strong> <span id="m-meia"></span></p>
      <p><strong>🆓 Isento:</strong> <span id="m-isento"></span></p>
      <div><span id="m-status" class="badge"></span></div>
    </div>
    <button onclick="fecharModal()">Fechar</button>
  </div>
</div>

<script>
const btnQr   = document.getElementById("btnQr");
const btnCpf  = document.getElementById("btnCpf");
const modoQr  = document.getElementById("modoQr");
const modoCpf = document.getElementById("modoCpf");
const modal   = document.getElementById("modal");

const nomeEl    = document.getElementById("m-nome");
const codigoEl  = document.getElementById("m-codigo");
const dataEl    = document.getElementById("m-data");
const inteiraEl = document.getElementById("m-inteira");
const meiaEl    = document.getElementById("m-meia");
const isentoEl  = document.getElementById("m-isento");
const statusEl  = document.getElementById("m-status");

let html5QrCode = new Html5Qrcode("qr-reader");

btnQr.onclick = () => {
  btnQr.classList.add("active");
  btnCpf.classList.remove("active");
  modoQr.style.display="block";
  modoCpf.style.display="none";
  iniciarLeitura();
};

btnCpf.onclick = () => {
  btnCpf.classList.add("active");
  btnQr.classList.remove("active");
  modoCpf.style.display="block";
  modoQr.style.display="none";
  pararLeitura();
};

function abrirModal(i){
  nomeEl.textContent    = i.nome || '---';
  codigoEl.textContent  = i.codigo || '---';
  dataEl.textContent    = i.data || '---';
  inteiraEl.textContent = i.quantidade?.Inteira || 0;
  meiaEl.textContent    = i.quantidade?.Meia || 0;
  isentoEl.textContent  = i.quantidade?.Isento || 0;

  if(i.status === 'ok'){
    statusEl.className = 'badge valid';
    statusEl.textContent = 'VÁLIDO';
  }else{
    statusEl.className = 'badge invalid';
    statusEl.textContent = 'INVÁLIDO';
  }
  modal.style.display = 'flex';
}

function fecharModal(){
  modal.style.display='none';
  iniciarLeitura();
}

function iniciarLeitura(){
  html5QrCode.start(
    { facingMode: "environment" },
    { fps: 12, qrbox: { width: 260, height: 260 } },
    txt => {
      fetch("/bilheteria/bilheteiro/validar?codigo=" + encodeURIComponent(txt))
        .then(r => r.json())
        .then(d => abrirModal(d));
    }
  ).catch(()=>{});
}

function pararLeitura(){
  try{ html5QrCode.stop(); }catch(e){}
}

function buscarPorCPF(){
  const cpf = document.getElementById("cpfBusca").value;
  fetch("/bilheteria/bilheteiro/buscar-cpf?cpf=" + encodeURIComponent(cpf))
    .then(r => r.json())
    .then(d => abrirModal(d));
}

// Inicia câmera automaticamente ao abrir
iniciarLeitura();
</script>

</body>
</html>
