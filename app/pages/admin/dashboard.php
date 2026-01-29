<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['bilheteiro_user'])) {
    header("Location: /bilheteria/?route=loginBilheteiro");
    exit;
}

// Dados fictícios (depois ligamos no banco)
$totalIngressosVendidos = 750;
$ingressosNaoUsados = 105;
$totalDinheiro = 90500.75;
$nomeUser = $_SESSION['bilheteiro_user']['nome'] ?? 'Administrador';

$listaIngressos = [
  ['id'=>1,'nome'=>'Inteira','preco'=>50.00],
  ['id'=>2,'nome'=>'Meia','preco'=>25.00],
  ['id'=>3,'nome'=>'Isento','preco'=>0.00],
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard | Bilheteiro Pro</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f3f6fb;display:flex}
.sidebar{width:230px;background:#1f2d3d;color:#fff;min-height:100vh;padding:20px}
.sidebar h2{text-align:center;margin-bottom:30px}
.sidebar a{display:block;color:#cfd8dc;text-decoration:none;padding:12px;border-radius:6px;margin-bottom:8px}
.sidebar a:hover,.sidebar a.active{background:#1abc9c;color:#fff}
.main{flex:1;padding:25px 35px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.topbar h1{margin:0;color:#1f2d3d}
.page{display:none;animation:fade .4s ease}
.page.active{display:block}
@keyframes fade{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin:25px 0}
.card{background:#fff;padding:20px;border-radius:14px;box-shadow:0 8px 20px rgba(0,0,0,.08)}
.card h3{margin:0;font-size:14px;color:#777}
.card p{font-size:26px;margin:8px 0 0;font-weight:bold;color:#1f2d3d}
.section{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.box{background:#fff;padding:20px;border-radius:14px;box-shadow:0 8px 20px rgba(0,0,0,.08)}

.table{
  width:100%;
  border-collapse:collapse;
  margin-top:15px;
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 6px 16px rgba(0,0,0,.06);
}

.table thead{
  background:#f3f6fb;
}

.table th{
  padding:12px 14px;
  font-size:13px;
  text-transform:uppercase;
  letter-spacing:.5px;
  color:#555;
}

.table td{
  padding:12px 14px;
  border-bottom:1px solid #eee;
  vertical-align:middle;
}

.table th:nth-child(1),
.table td:nth-child(1){
  text-align:left;
}

.table th:nth-child(2),
.table td:nth-child(2){
  text-align:right;
}

.table td:nth-child(2) input{
  text-align:right;
}

.table tr:hover{
  background:#f9fbfd;
}

.table input{
  padding:8px 10px;
  border-radius:8px;
  border:1px solid #dcdfe3;
  width:110px;
  font-size:14px;
  transition:.2s;
}

.table input:focus{
  outline:none;
  border-color:#1abc9c;
  box-shadow:0 0 0 2px rgba(26,188,156,.15);
}

.btn{
  background:#1abc9c;
  color:#fff;
  padding:10px 18px;
  border:none;
  border-radius:10px;
  font-size:14px;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(26,188,156,.25);
  transition:.2s;
}

.btn:hover{
  background:#17a689;
  transform:translateY(-1px);
  box-shadow:0 6px 14px rgba(26,188,156,.3);
}


/* Container dos filtros */
#financeiro .filtros {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 20px;
  padding: 15px;
  border-radius: 12px;
  background: #f3f6fb;
  box-shadow: 0 4px 12px rgba(0,0,0,.05);
  align-items: flex-end;
}

/* Cada label + input/select */
#financeiro .filtros label {
  display: flex;
  flex-direction: column;
  font-size: 14px;
  color: #555;
}

/* Inputs e selects */
#financeiro .filtros input,
#financeiro .filtros select {
  padding: 8px 12px;
  border-radius: 8px;
  border: 1px solid #dcdfe3;
  font-size: 14px;
  margin-top: 4px;
  min-width: 140px;
  transition: 0.2s;
}

#financeiro .filtros input:focus,
#financeiro .filtros select:focus {
  outline: none;
  border-color: #1abc9c;
  box-shadow: 0 0 0 2px rgba(26,188,156,.15);
}

/* Botões de filtro */
#financeiro .filtros .btn {
  margin-top: 22px; /* alinhamento com os inputs */
  padding: 10px 18px;
  font-size: 14px;
}

.modal {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
  transition: opacity 0.3s ease;
}

.modal.show { display: flex; opacity: 1; }

.modal-content {
  background: #fff;
  padding: 25px 30px;
  border-radius: 16px;
  width: 360px;
  max-width: 90%;
  position: relative;
  box-shadow: 0 12px 32px rgba(0,0,0,0.25);
  animation: slideDown 0.3s ease;
  font-family: 'Segoe UI', sans-serif;
}

@keyframes slideDown {
  from { opacity: 0; transform: translateY(-15px); }
  to { opacity: 1; transform: translateY(0); }
}

.close {
  position: absolute;
  top: 12px;
  right: 18px;
  font-size: 22px;
  font-weight: bold;
  color: #888;
  cursor: pointer;
  transition: color 0.2s;
}
.close:hover { color: #333; }

.modal h3 {
  margin-top: 0;
  font-size: 20px;
  color: #1f2d3d;
  text-align: center;
  margin-bottom: 20px;
}

.modal label {
  display: block;
  margin-bottom: 12px;
  font-size: 14px;
  color: #555;
}

.modal input, .modal select {
  width: 100%;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1px solid #ccc;
  font-size: 14px;
  margin-top: 5px;
  transition: all 0.2s;
}

.modal input:focus, .modal select:focus {
  outline: none;
  border-color: #1abc9c;
  box-shadow: 0 0 0 3px rgba(26,188,156,0.15);
}

.modal button {
  background: #1abc9c;
  color: #fff;
  width: 100%;
  padding: 12px 0;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 15px;
  box-shadow: 0 5px 14px rgba(26,188,156,0.3);
  transition: all 0.2s;
}

.modal button:hover {
  background: #17a689;
  transform: translateY(-2px);
  box-shadow: 0 7px 18px rgba(26,188,156,0.4);
}
</style>
</head>

<body>

<div class="sidebar">
  <h2>Bilheteiro</h2>
  <a href="#" class="active" onclick="showPage('dashboard',this)">📊 Dashboard</a>
  <a href="#" onclick="showPage('ingressos',this)">🎟️ Ingressos</a>
  <a href="#" onclick="showPage('financeiro',this)">💰 Financeiro</a>
  <a href="#" onclick="showPage('config',this)">⚙️ Configurações</a>
</div>

<div class="main">

<div class="topbar">
  <h1>Painel Administrativo</h1>
  <div>
    👤 <?= $nomeUser ?> |
    <a href="/bilheteria/logout.php" style="color:#e74c3c;font-weight:bold;text-decoration:none">Sair</a>
  </div>
</div>

<!-- DASHBOARD -->
<div class="page active" id="dashboard">
  <div class="cards">
    <div class="card"><h3>Ingressos Vendidos</h3><p><?= $totalIngressosVendidos ?></p></div>
    <div class="card"><h3>Não Utilizados</h3><p><?= $ingressosNaoUsados ?></p></div>
    <div class="card"><h3>Total Arrecadado</h3><p>R$ <?= number_format($totalDinheiro,2,',','.') ?></p></div>
    <div class="card"><h3>Visitantes Únicos</h3><p>132</p></div>
  </div>

  <div class="section">
    <div class="box"><h3>Ingressos por Tipo</h3><canvas id="donutTipo"></canvas></div>
    <div class="box"><h3>Formas de Pagamento</h3><canvas id="donutPagamento"></canvas></div>
  </div><br>

  <div class="section">
    <div class="box"><h3>Faturamento por Dia</h3><canvas id="linhaFaturamento"></canvas></div>
  </div><br>

  <div class="section">
    <div class="box"><h3>Vendas por Tipo</h3><canvas id="barTipo"></canvas></div>
    <div class="box"><h3>Visitantes por Dia</h3><canvas id="linhaVisitantes"></canvas></div>
  </div>
</div>

<!-- OUTRAS TELAS -->
<div class="page" id="ingressos">
  <div class="box">
    <h2>🎟️ Gerenciar Ingressos</h2>
    <p>Edite os preços abaixo:</p>

    <form method="post" action="">
      <table class="table">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Preço (R$)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($listaIngressos as $i): ?>
          <tr>
            <td><?= htmlspecialchars($i['nome']) ?></td>
            <td>
              <input type="number" step="0.01" name="precos[<?= $i['id'] ?>]" value="<?= number_format($i['preco'],2,'.','') ?>">
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <br>
      <button class="btn">💾 Salvar Preços</button>
    </form>
  </div>
</div>
 <!-- FINANCEIRO -->
<div class="page" id="financeiro">
  <div class="box">
    <h2>💰 Financeiro</h2>

    <!-- Cards de resumo -->
    <div class="cards">
      <div class="card"><h3>Total Arrecadado</h3><p>R$ <?= number_format($totalDinheiro,2,',','.') ?></p></div>
      <div class="card"><h3>Ingressos Vendidos</h3><p><?= $totalIngressosVendidos ?></p></div>
      <div class="card"><h3>Ticket Médio</h3><p>R$ <?= number_format($totalDinheiro/$totalIngressosVendidos,2,',','.') ?></p></div>
      <div class="card"><h3>Visitantes Únicos</h3><p>132</p></div>
      <div class="card"><h3>Ingressos Cancelados</h3><p>12</p></div>
    </div>

    <br>

    <!-- Filtros -->
    <div class="filtros">
  <label>Data de:
    <input type="date" id="filterStart">
  </label>
  <label>Até:
    <input type="date" id="filterEnd">
  </label>
  <label>Visitante:
    <input type="text" id="filterVisitor" placeholder="Nome ou Email">
  </label>
  <label>Tipo Ingresso:
    <select id="filterTipo">
      <option value="">Todos</option>
      <option value="Inteira">Inteira</option>
      <option value="Meia">Meia</option>
      <option value="Isento">Isento</option>
    </select>
  </label>
  <label>Status:
    <select id="filterStatus">
      <option value="">Todos</option>
      <option value="Pago">Pago</option>
      <option value="Pendente">Pendente</option>
      <option value="Cancelado">Cancelado</option>
    </select>
  </label>
  <button class="btn" onclick="applyFilters()">Filtrar</button>
  <button class="btn" onclick="resetFilters()">Resetar</button>
  <button class="btn" onclick="exportCSV()">📥 Exportar CSV</button>
</div>

    <!-- Tabela Financeiro -->
    <table class="table" id="tabelaFinanceiro">
      <thead>
        <tr>
          <th>Visitante</th>
          <th>Data</th>
          <th>Ingressos</th>
          <th>Qtd</th>
          <th>Valor Unitário</th>
          <th>Total</th>
          <th>Pagamento</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="financeiroBody">
        <?php
        // Dados fictícios
        $vendas = [
          [
            'visitante'=>'João Silva',
            'data'=>'2026-01-29',
            'ingressos'=>['Inteira'=>2,'Meia'=>1],
            'valores'=>['Inteira'=>50,'Meia'=>25],
            'pagamento'=>'Pix',
            'status'=>'Pago'
          ],
          [
            'visitante'=>'Maria Oliveira',
            'data'=>'2026-01-29',
            'ingressos'=>['Inteira'=>3],
            'valores'=>['Inteira'=>50],
            'pagamento'=>'Cartão',
            'status'=>'Pago'
          ],
        ];

        foreach($vendas as $v){
          $tipos = implode(", ", array_keys($v['ingressos']));
          $quantidades = implode(", ", array_values($v['ingressos']));
          $valores = implode(", ", array_values($v['valores']));
          $total = 0;
          foreach($v['ingressos'] as $tipo=>$q){
            $total += $q * $v['valores'][$tipo];
          }
          echo "<tr data-visitante='{$v['visitante']}' data-tipo='{$tipos}' data-status='{$v['status']}' data-data='{$v['data']}'>
                  <td>{$v['visitante']}</td>
                  <td>{$v['data']}</td>
                  <td>{$tipos}</td>
                  <td>{$quantidades}</td>
                  <td>{$valores}</td>
                  <td>{$total}</td>
                  <td>{$v['pagamento']}</td>
                  <td>{$v['status']}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>

    <br>

    <!-- Gráficos -->
    <div class="section">
      <div class="box"><h3>Faturamento por Tipo</h3><canvas id="barTipo"></canvas></div>
      <div class="box"><h3>Formas de Pagamento</h3><canvas id="donutPagamento"></canvas></div>
    </div>
  </div>
</div>


<div class="page" id="config">
  <div class="box">
    <h2>👥 Usuários e Permissões</h2>

    <!-- Botão adicionar usuário -->
    <button class="btn" style="margin-bottom:15px;" onclick="abrirModal()">➕ Adicionar Usuário</button>

    <!-- Tabela estilizada -->
    <table class="table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Perfil</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="usuariosBody">
        <tr>
          <td>João Silva</td>
          <td>joao@exemplo.com</td>
          <td>Administrador</td>
          <td><span class="status ativo">Ativo</span></td>
          <td>
            <button class="btn small">✏️</button>
            <button class="btn small danger">🗑️</button>
          </td>
        </tr>
        <tr>
          <td>Maria Oliveira</td>
          <td>maria@exemplo.com</td>
          <td>Bilheteiro</td>
          <td><span class="status ativo">Ativo</span></td>
          <td>
            <button class="btn small">✏️</button>
            <button class="btn small danger">🗑️</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal para adicionar usuário -->
<div id="modalUsuario" class="modal">
  <div class="modal-content">
    <span class="close" onclick="fecharModal()">&times;</span>
    <h3>➕ Novo Usuário</h3>
    <label>Nome: <input type="text" id="novoNome"></label>
    <label>Email: <input type="email" id="novoEmail"></label>
    <label>Perfil:
      <select id="novoPerfil">
        <option value="Administrador">Administrador</option>
        <option value="Bilheteiro">Bilheteiro</option>
      </select>
    </label>
    <label>Status:
      <select id="novoStatus">
        <option value="Ativo">Ativo</option>
        <option value="Inativo">Inativo</option>
      </select>
    </label>
    <button class="btn" onclick="adicionarUsuario()">💾 Salvar</button>
  </div>
</div>

</div>

<script>
function showPage(id,el){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
  el.classList.add('active');
}

function applyFilters(){
  const start = document.getElementById('filterStart').value;
  const end = document.getElementById('filterEnd').value;
  const visitor = document.getElementById('filterVisitor').value.toLowerCase();
  const tipo = document.getElementById('filterTipo').value;
  const status = document.getElementById('filterStatus').value;

  document.querySelectorAll('#financeiroBody tr').forEach(tr=>{
    let show = true;
    const trDate = tr.dataset.data;
    const trVisitor = tr.dataset.visitante.toLowerCase();
    const trTipo = tr.dataset.tipo;
    const trStatus = tr.dataset.status;

    if(start && trDate<start) show=false;
    if(end && trDate>end) show=false;
    if(visitor && !trVisitor.includes(visitor)) show=false;
    if(tipo && !trTipo.includes(tipo)) show=false;
    if(status && trStatus!==status) show=false;

    tr.style.display = show ? '' : 'none';
  });
}

function resetFilters(){
  document.getElementById('filterStart').value='';
  document.getElementById('filterEnd').value='';
  document.getElementById('filterVisitor').value='';
  document.getElementById('filterTipo').value='';
  document.getElementById('filterStatus').value='';
  applyFilters();
}

// Exportar CSV
function exportCSV() {
  let csv = [];
  const rows = document.querySelectorAll("#tabelaFinanceiro tr");
  rows.forEach(row => {
    let cols = row.querySelectorAll("td, th");
    let rowData = [];
    cols.forEach(col => rowData.push('"' + col.innerText.replace(/"/g,'""') + '"'));
    csv.push(rowData.join(","));
  });
  const csvString = csv.join("\n");
  const blob = new Blob([csvString], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.setAttribute('hidden','');
  a.setAttribute('href', url);
  a.setAttribute('download','financeiro.csv');
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}

function abrirModal(){ document.getElementById('modalUsuario').style.display='flex'; }
function fecharModal(){ document.getElementById('modalUsuario').style.display='none'; }

function adicionarUsuario(){
  const nome = document.getElementById('novoNome').value;
  const email = document.getElementById('novoEmail').value;
  const perfil = document.getElementById('novoPerfil').value;
  const status = document.getElementById('novoStatus').value;

  if(!nome || !email){ alert('Preencha todos os campos!'); return; }

  const tbody = document.getElementById('usuariosBody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>${nome}</td>
    <td>${email}</td>
    <td>${perfil}</td>
    <td><span class="status ${status.toLowerCase()}">${status}</span></td>
    <td>
      <button class="btn small">✏️</button>
      <button class="btn small danger">🗑️</button>
    </td>`;
  tbody.appendChild(tr);

  // Limpar e fechar modal
  document.getElementById('novoNome').value='';
  document.getElementById('novoEmail').value='';
  document.getElementById('novoPerfil').value='Bilheteiro';
  document.getElementById('novoStatus').value='Ativo';
  fecharModal();
}

// Gráficos
new Chart(donutTipo,{type:'doughnut',data:{labels:['Inteira','Meia','Isento'],datasets:[{data:[90,50,10],backgroundColor:['#1abc9c','#3498db','#f1c40f']}]}});
new Chart(donutPagamento,{type:'doughnut',data:{labels:['Pix','Cartão'],datasets:[{data:[70,60],backgroundColor:['#2ecc71','#9b59b6']}]}});
new Chart(linhaFaturamento,{type:'line',data:{labels:['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],datasets:[{label:'R$',data:[320,540,430,610,720,980,1100],borderColor:'#3498db',tension:.4}]}});
new Chart(barTipo,{type:'bar',data:{labels:['Inteira','Meia','Isento'],datasets:[{label:'Ingressos',data:[90,50,10]}]}});
new Chart(linhaVisitantes,{type:'line',data:{labels:['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],datasets:[{label:'Visitantes',data:[10,18,14,20,28,40,33],borderColor:'#e74c3c',tension:.4}]}});
new Chart(document.getElementById('barTipo'),{
  type:'bar',
  data:{
    labels:['Inteira','Meia','Isento'],
    datasets:[{label:'Ingressos',data:[90,50,10],backgroundColor:['#1abc9c','#3498db','#f1c40f']}]
  }
});

new Chart(document.getElementById('donutPagamento'),{
  type:'doughnut',
  data:{
    labels:['Pix','Cartão'],
    datasets:[{data:[70,60],backgroundColor:['#2ecc71','#9b59b6']}]
  }
});

</script>

</body>
</html>