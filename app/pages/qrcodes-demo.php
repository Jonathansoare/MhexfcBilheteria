<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>QR Codes de Teste - DEMO</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<style>
body{
  margin:0;
  font-family: Arial, sans-serif;
  background:#f2f4f8;
  padding:20px;
}

h1{
  text-align:center;
  color:#1e3c72;
}

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
  gap:20px;
  margin-top:30px;
}

.card{
  background:#fff;
  border-radius:14px;
  padding:14px;
  box-shadow:0 6px 15px rgba(0,0,0,.1);
  text-align:center;
}

.card h3{
  margin:8px 0 4px;
  font-size:14px;
  color:#333;
}

.card small{
  display:block;
  font-size:12px;
  color:#666;
  margin-bottom:6px;
}

canvas{
  margin:auto;
}
</style>
</head>
<body>

<h1>🎭 QR Codes de Teste (Modo DEMO)</h1>

<div class="grid" id="qrs"></div>

<script>
const qrs = [
  { code: "ABC123", desc: "Compra João Silva – 2 Inteiras + 1 Meia" },
  { code: "XYZ456", desc: "Compra Maria Santos – 1 Inteira + 2 Meias" },
  { code: "VIP777", desc: "Ingresso VIP – Acesso Total" },
  { code: "FREE999", desc: "Isento – Cortesia" },
  { code: "TEST2026", desc: "Evento Teste 2026" },
  { code: "ING12345", desc: "Ingresso padrão" },
  { code: "DEMO001", desc: "Simulação bilheteiro" },
  { code: "DEMO002", desc: "Simulação admin" }
];

const container = document.getElementById("qrs");

qrs.forEach(item => {
  const card = document.createElement("div");
  card.className = "card";

  const title = document.createElement("h3");
  title.innerText = item.code;

  const desc = document.createElement("small");
  desc.innerText = item.desc;

  const canvas = document.createElement("canvas");

  card.appendChild(canvas);
  card.appendChild(title);
  card.appendChild(desc);
  container.appendChild(card);

  QRCode.toCanvas(canvas, item.code, { width: 140 });
});
</script>

</body>
</html>
