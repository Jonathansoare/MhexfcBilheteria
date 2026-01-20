<?php
// ===== SIMULADOR PAGTESOURO (FAKE) =====

header('Content-Type: application/json; charset=utf-8');

$tipo = $_POST['tipo'] ?? 'br';
$valor = $_POST['valor'] ?? '0';
$servico = $_POST['servico'] ?? '23';

if ($tipo === 'br') {
    $nome = $_POST['nome'] ?? 'Visitante Brasileiro';
    $doc  = $_POST['cpf']  ?? gerarCpfFake();
} else {
    $nome = $_POST['nome_gringo'] ?? 'Visitante Estrangeiro';
    $doc  = gerarCpfFake(); // sempre fake na simulação
}

$payload = [
  "codigoServico" => $servico,
  "referencia" => uniqid("REF_"),
  "competencia" => date('mY'),
  "vencimento" => date('dmY', strtotime('+2 days')),
  "cnpjCpf" => $doc,
  "nomeContribuinte" => $nome,
  "valorPrincipal" => number_format((float)$valor, 2, '.', ''),
  "valorDescontos" => "0",
  "valorOutrasDeducoes" => "0",
  "valorMulta" => "0",
  "valorJuros" => "0",
  "valorOutrosAcrescimos" => "0",
  "modoNavegacao" => "2",
  "urlNotificacao" => "https://simulador.local/notificacao"
];

// ====== RESPOSTA FAKE DO PAGTESOURO ======
$responseFake = [
  "status" => "SUCESSO",
  "mensagem" => "Pagamento simulado com sucesso",
  "qrCodePix" => "00020101021226820014br.gov.bcb.pix2577simulador@pagtesouro.gov.br5204000053039865405{$payload['valorPrincipal']}5802BR5909SIMULADOR6009SAO PAULO62070503***6304ABCD",
  "linkPagamento" => "https://simulador.pagtesouro.gov.br/pagar/".$payload['referencia'],
  "payloadEnviado" => $payload
];

echo json_encode($responseFake, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


// ===== FUNÇÕES =====

function gerarCpfFake() {
  $n = [];
  for ($i = 0; $i < 9; $i++) $n[] = rand(0,9);
  $n[9] = calcDigito($n, 10);
  $n[10] = calcDigito($n, 11);
  return implode('', $n);
}

function calcDigito($n, $p) {
  $s = 0;
  for ($i = 0; $i < $p-1; $i++) {
    $s += $n[$i] * ($p - $i);
  }
  $r = $s % 11;
  return $r < 2 ? 0 : 11 - $r;
}
