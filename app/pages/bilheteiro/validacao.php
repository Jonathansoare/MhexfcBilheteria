<?php
session_start();

// Proteção: apenas bilheteiros podem acessar
if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'bilheteiro') {
    header('Location: ?route=login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Validação de Ingressos</title>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<style>
body {
    font-family: Arial, sans-serif;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:flex-start;
    min-height:100vh;
    margin:0;
    padding:20px;
    background:#f0f0f0;
}

h1 {
    margin-bottom:30px;
    text-align:center;
    color:#333;
}

#qr-reader {
    width: 400px;
    margin-bottom:30px;
}

#info {
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    width:400px;
}

#info p {
    margin:5px 0;
    font-size:16px;
}

.valid {
    color:green;
}

.invalid {
    color:red;
}
</style>
</head>
<body>

<h1>Validação de Ingressos</h1>

<div id="qr-reader"></div>

<div id="info">
    <p><strong>Nome:</strong> <span id="nome">---</span></p>
    <p><strong>Data da compra:</strong> <span id="data">---</span></p>
    <p><strong>Ingressos:</strong></p>
    <ul>
        <li>Inteira: <span id="inteira">0</span></li>
        <li>Meia: <span id="meia">0</span></li>
        <li>Isento: <span id="isento">0</span></li>
    </ul>
    <p id="status"></p>
</div>

<script>
function atualizarInfo(ingresso) {
    document.getElementById('nome').innerText = ingresso.nome;
    document.getElementById('data').innerText = ingresso.data_compra;
    document.getElementById('inteira').innerText = ingresso.inteira || 0;
    document.getElementById('meia').innerText = ingresso.meia || 0;
    document.getElementById('isento').innerText = ingresso.isento || 0;
    document.getElementById('status').innerText = ingresso.valido ? "Válido" : "Inválido";
    document.getElementById('status').className = ingresso.valido ? "valid" : "invalid";
}

// Configuração do leitor de QR code
const html5QrCode = new Html5Qrcode("qr-reader");

function onScanSuccess(decodedText, decodedResult) {
    // Exemplo: decodedText = ID do ingresso
    console.log(`QR Code detectado: ${decodedText}`);

    // Simula requisição AJAX para verificar ingresso no backend
    fetch("?route=verificarIngresso&id=" + decodedText)
        .then(res => res.json())
        .then(data => atualizarInfo(data))
        .catch(err => console.error(err));
}

function onScanFailure(error) {
    // ignorar erros menores
}

// Inicia scanner
html5QrCode.start(
    { facingMode: "environment" },
    {
        fps: 10,
        qrbox: 250
    },
    onScanSuccess,
    onScanFailure
);
</script>

</body>
</html>