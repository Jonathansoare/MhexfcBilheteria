<?php
require __DIR__ . '/config.php';
$_SESSION['lang'] ?? 'SEM SESSÃO'

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?= APP_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS globais -->
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/Home.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/modal.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/pagamento.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/pagamento.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/components/Ticket/Ticket.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/components/ModalConfirmacao/ModalConfirmacao.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/components/termosTicketModal/termosTicketModal.css">
</head>
<body>

<?php require __DIR__ . "/components/Header/Header.php"; ?>

<?php require __DIR__ . '/router.php'; ?>

</body>
<!-- JS globais -->
<script src="<?= $baseUrl ?>/components/Ticket/Ticket.js" defer></script>
<script src="<?= $baseUrl ?>/app.js" defer></script>
<script src="<?= $baseUrl ?>/components/ModalConfirmacao/ModalConfirmacao.js" defer></script>
<script src="<?= $baseUrl ?>/components/termosTicketModal/termosTicketModal.js" defer></script>
<script src="<?= $baseUrl ?>/components/VisitanteForm/VisitanteForm.js" defer></script>
<script src="<?= $baseUrl ?>/components/Header/Header.js" defer></script>
<script src="<?= $baseUrl ?>/js/pagamento.js" defer></script>
</html>
