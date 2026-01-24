<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../helpers/i18n.php';
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'pt-br' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= t('payment_title') ?></title>

  <link rel="stylesheet" href="<?= APP_URL ?>/css/pagamento.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/components/Header/Header.css">
</head>

<body>

<?php require __DIR__ . '/../components/Header/Header.php'; ?>

<div class="pagamento-container"
     data-wait-pix="<?= t('pix_waiting') ?>"
     data-time-left="<?= t('pix_time_left') ?>"
     data-copy-pix="<?= t('pix_copy') ?>"
     data-pix-expired="<?= t('pix_expired') ?>"
     data-new-payment="<?= t('pix_new_payment') ?>"
     data-card-name="<?= t('card_name') ?>"
     data-card-number="<?= t('card_number') ?>"
     data-card-exp="<?= t('card_exp') ?>"
     data-card-cvv="<?= t('card_cvv') ?>"
     data-pay="<?= t('pay_now') ?>"
>
  <h2><?= t('choose_payment_method') ?></h2>

  <div class="pagamento-opcoes">
    <button class="btn-pagamento btn-pix-opcao" onclick="mostrarPix()">
      <img class="btn-pix" src="<?= APP_URL ?>/assets/img/logoPix.png" alt="PIX">
      <span>PIX</span>
    </button>

    <button class="btn-pagamento btn-cartao-opcao" onclick="mostrarCartao()">
      💳 <span><?= t('card') ?></span>
    </button>
  </div>

  <div id="areaPagamento"></div>
</div>

<script src="<?= APP_URL ?>/js/pagamento.js"></script>
<script src="<?= APP_URL ?>/components/Header/Header.js"></script>
</body>
</html>
