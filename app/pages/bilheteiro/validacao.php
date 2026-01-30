<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['bilheteiro_user'])) {
    header('Location: /bilheteria/?route=loginBilheteiro');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Validação de Ingressos</title>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}

body{
    margin:0;
    min-height:100vh;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    font-family:'Inter',Arial,sans-serif;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:12px;
}

.app{
    background:#fff;
    width:100%;
    max-width:480px;
    height:80vh;
    border-radius:18px;
    padding:14px;
    display:flex;
    flex-direction:column;
    gap:12px;
    overflow-y:auto;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:4px 6px;
}

.top-bar .user{
    font-size:13px;
    color:#444;
}

.logout-btn{
    background:#e53935;
    color:#fff;
    text-decoration:none;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    transition:.2s;
}

.logout-btn:hover{
    background:#c62828;
}

h1{
    font-size:20px;
    margin:0;
    text-align:center;
    color:#1e3c72;
    font-weight:700;
}

#qr-reader{
    width:100%;
    max-height:260px;
    aspect-ratio:1/1;
    overflow:hidden;
}

.card{
    background:#f8f9fb;
    border-radius:14px;
    padding:12px;
}

.card p,.card li{
    font-size:14px;
    margin:6px 0;
    color:#333;
}

.card strong{color:#1e3c72}

ul{padding-left:16px}

.status{
    margin-top:8px;
    font-weight:600;
    font-size:15px;
}

.badge{
    display:inline-block;
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge.valid{background:#e7f7ef;color:#0f7a3d}
.badge.invalid{background:#fdecea;color:#b00020}

.fade{animation:fadeIn .3s ease}

@keyframes fadeIn{
    from{opacity:0;transform:translateY(4px)}
    to{opacity:1;transform:translateY(0)}
}
</style>
</head>
<body>

<div class="app">

    <div class="top-bar">
        <span class="user">👤 Bilheteiro</span>
        <a href="/bilheteria/?route=logoutBilheteiro" class="logout-btn">Sair</a>
    </div>

    <h1>Validação de Ingressos</h1>

    <div id="qr-reader"></div>

    <div class="card fade" id="info">
        <p><strong>Nome:</strong> <span id="nome">---</span></p>
        <p><strong>Data da compra:</strong> <span id="data">---</span></p>

        <p><strong>Ingressos:</strong></p>
        <ul>
            <li>Inteira: <span id="inteira">0</span></li>
            <li>Meia: <span id="meia">0</span></li>
            <li>Isento: <span id="isento">0</span></li>
        </ul>

        <div class="status">
            Status:
            <span id="status" class="badge">---</span>
        </div>
    </div>
</div>

<script>
const infoCard = document.getElementById('info');

function atualizarInfo(ingresso){
    infoCard.classList.remove('fade');
    void infoCard.offsetWidth;
    infoCard.classList.add('fade');

    document.getElementById('nome').innerText = ingresso.nome || '---';
    document.getElementById('data').innerText = ingresso.data || '---';

    document.getElementById('inteira').innerText = ingresso.quantidade?.Inteira ?? 0;
    document.getElementById('meia').innerText    = ingresso.quantidade?.Meia ?? 0;
    document.getElementById('isento').innerText  = ingresso.quantidade?.Isento ?? 0;

    const statusEl = document.getElementById('status');
    if(ingresso.status === 'ok'){
        statusEl.innerText = "Válido";
        statusEl.className = "badge valid";
    } else {
        statusEl.innerText = "Inválido";
        statusEl.className = "badge invalid";
    }
}

const html5QrCode = new Html5Qrcode("qr-reader");

html5QrCode.start(
    { facingMode:"environment" },
    { fps: 10, qrbox: { width: 250, height: 400 } },
    decodedText => {
        fetch("/bilheteria/?route=validarBilheteiro&codigo="+encodeURIComponent(decodedText))
            .then(r=>r.json())
            .then(atualizarInfo)
            .catch(console.error);
    },
    ()=>{}
);
</script>

</body>
</html>
