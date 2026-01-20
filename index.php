<?php require __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= APP_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/modal.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/Home.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/pagamento.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/components/Ticket/Ticket.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/components/ModalConfirmacao/ModalConfirmacao.css">
</head>
<body>

<?php require __DIR__ . '/router.php'; ?>
</body>
<script src="<?= $baseUrl ?>/components/Ticket/Ticket.js" defer></script>
<script src="<?= $baseUrl ?>/app.js" defer></script>
<script src="<?= $baseUrl ?>/components/ModalConfirmacao/ModalConfirmacao.js" defer></script>
<script src="<?= $baseUrl ?>/components/VisitanteForm/VisitanteForm.js" defer></script>
<script src="<?= $baseUrl ?>/components/Header/Header.js" defer></script>
</html>
