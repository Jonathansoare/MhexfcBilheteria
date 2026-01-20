<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dados do Visitante</title>
<link rel="stylesheet" href="/css/dadospesson.css">
<script>
function tipoPessoa(tipo) {
  document.getElementById('br').style.display = tipo === 'br' ? 'block' : 'none';
  document.getElementById('gringo').style.display = tipo === 'gringo' ? 'block' : 'none';
}
</script>
</head>
<body>

<div class="container">
  <h2>Identificação do Visitante</h2>

  <form action="simulador-pagtesouro.php" method="POST">
    <label>Tipo de visitante</label>
    <div>
      <label><input type="radio" name="tipo" value="br" checked onclick="tipoPessoa('br')"> Brasileiro</label>
      <label><input type="radio" name="tipo" value="gringo" onclick="tipoPessoa('gringo')"> Estrangeiro</label>
    </div>

    <!-- BR -->
    <div id="br">
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="text" name="cpf" placeholder="CPF" required>
      <input type="email" name="email" placeholder="Email">
    </div>

    <!-- GRINGO -->
    <div id="gringo" style="display:none;">
      <input type="text" name="nome_gringo" placeholder="Nome completo" required>
      <input type="text" name="passaporte" placeholder="Passaporte" required>
      <input type="text" name="pais" placeholder="País de origem" required>
      <input type="email" name="email_gringo" placeholder="Email">
    </div>

    <hr>

    <input type="hidden" name="valor" value="<?= $_POST['total'] ?? '0' ?>">
    <input type="hidden" name="servico" value="23">

    <button type="submit">Gerar Pagamento</button>
  </form>
</div>

</body>
</html>
