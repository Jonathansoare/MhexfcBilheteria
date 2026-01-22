<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers/i18n.php';

// Tickets disponíveis
$tickets = [
  'inteira' => ['label' => t('ticket_full'), 'price' => 10],
  'meia' => [
    'label' => t('ticket_half'),
    'price' => 5,
    'description' => t('ticket_half_desc')
  ],
  'isento' => [
    'label' => t('ticket_free'),
    'price' => 0,
    'description' => t('ticket_free_desc')
  ],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= t('museum_title') ?></title>
</head>
<body>

<section class="hero-img">
  <img src="/bilheteria/assets/img/05PORTICOFHD.jpg" alt="<?= t('hero_alt') ?>">
</section>

<div class="container">
  <h2><?= t('museum_title') ?></h2>
  <p><?= t('museum_subtitle') ?></p>

  <ul class="info-list">
    <li>📍 <?= t('museum_location') ?></li>
    <li>🕘 <?= t('museum_hours') ?></li>
    <li>🅿️ <?= t('museum_parking') ?></li>
  </ul>

  <div class="map-card">
    <a href="https://www.google.com/maps?q=Forte+de+Copacabana" target="_blank">
      <img src="/bilheteria/assets/img/placehordMap.png" alt="<?= t('map_alt') ?>">
    </a>
    <a class="map-link" href="https://www.google.com/maps?q=Forte+de+Copacabana" target="_blank">
      📍 <?= t('view_on_maps') ?>
    </a>
  </div>

  <h3><?= t('select_ticket') ?></h3>

  <form method="POST" action="/bilheteria/screens/Pagamento.php" id="form">

    <?php foreach ($tickets as $id => $ticket):
      $label = $ticket['label'];
      $price = $ticket['price'];
      $description = $ticket['description'] ?? '';
      include __DIR__.'/../components/Ticket/Ticket.php';
    endforeach; ?>

    <span class="infor-beneficios"><?= t('law_benefits') ?></span>

    <h3><?= t('ticket_validity') ?></h3>
    <div class="validade">
      <button type="button" class="active" onclick="setValidade('hoje',this)"><?= t('today') ?></button>
      <button type="button" onclick="setValidade('3dias',this)"><?= t('three_days') ?></button>
      <button type="button" onclick="setValidade('7dias',this)"><?= t('seven_days') ?></button>
    </div>

    <input type="hidden" name="validade" id="validade" value="hoje">

    <div class="summary">
      <p><?= t('total_tickets') ?>: <strong id="totalIngressos">0</strong></p>
      <p><?= t('total_value') ?>: <strong>R$ <span id="totalValor">0,00</span></strong></p>
      <p><?= t('validity') ?>: <strong id="validadeTexto"><?= t('today') ?></strong></p>

      <button type="button" id="btnContinuar" class="btn" disabled onclick="abrirModal()">
        <?= t('continue') ?>
      </button>

      <p class="redirect"><?= t('gov_redirect') ?></p>
    </div>
  </form>
</div>

<?php
$modalTitle = t('confirm_tickets');
$modalId = 'modalHome';
$onConfirm = "confirmarPagamento()";
include __DIR__.'/../components/ModalConfirmacao/ModalConfirmacao.php';
?>

</body>
</html>
