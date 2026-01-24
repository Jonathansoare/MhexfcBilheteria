<?php
session_start();
require __DIR__ . '/../helpers/i18n.php';
require __DIR__ . '/../config.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// === Segurança básica ===
$quantities  = is_array($_POST['quantities'] ?? null) ? $_POST['quantities'] : [];
$validadeKey = $_POST['validade'] ?? 'hoje';

// === Labels e preços ===
$labels = [
  'inteira' => 'Ingresso Inteiro',
  'meia'    => 'Meia-entrada',
  'isento'  => 'Isento'
];

$prices = [
  'inteira' => 10,
  'meia'    => 5,
  'isento'  => 0
];

// === Monta o resumo ===
$ingressos = [];
$total = 0;

foreach ($quantities as $id => $qtd) {
  $id  = (string)$id;
  $qtd = max(0, (int)$qtd);

  if ($qtd > 0 && isset($labels[$id], $prices[$id])) {
    $ingressos[] = "{$qtd}x {$labels[$id]}";
    $total += $qtd * $prices[$id];
  }
}

// === Texto da validade ===
$validade = match ($validadeKey) {
  '3dias' => t('valid_3_days'),
  '7dias' => t('valid_7_days'),
  default => t('valid_today')
};
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= t('payment_summary') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= APP_URL ?>/css/dadosPesson.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/components/VisitanteForm/VisitanteForm.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/components/Header/Header.css">
</head>
<body>

<?php include __DIR__ . '/../components/Header/Header.php'; ?>

<div class="pagamento-container">

  <div class="resumo-box">
    <h1 class="resumo-titulo"><?= t('payment_summary') ?></h1>

    <div class="resumo-item">
      <strong><?= t('tickets') ?>:</strong>

      <ul class="resumo-lista">
        <?php if (count($ingressos) === 0): ?>
          <li><?= t('no_tickets') ?></li>
        <?php else: ?>
          <?php foreach ($ingressos as $i): ?>
            <li><?= htmlspecialchars($i) ?></li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>

    <p class="resumo-item">
      <strong><?= t('validity') ?>:</strong> <?= htmlspecialchars($validade) ?>
    </p>

    <p class="resumo-item total">
      <strong><?= t('total_to_pay') ?>:</strong>
      R$ <?= number_format($total, 2, ',', '.') ?>
    </p>
  </div>

  <?php include __DIR__ . '/../components/VisitanteForm/VisitanteForm.php'; ?>

</div>

<!-- JS -->
<script src="<?= APP_URL ?>/components/VisitanteForm/VisitanteForm.js"></script>
<script src="<?= APP_URL ?>/js/dadosPesson.js"></script>
<script src="<?= APP_URL ?>/components/Header/Header.js"></script>

</body>
</html>
