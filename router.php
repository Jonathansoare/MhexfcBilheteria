<?php
$page = $_GET['page'] ?? 'Home';

$allowed = ['Home','Bilheteria','dadosPesson','simulador-pagtesouro','gerar-pagamento','pagamento'];


if (!in_array($page, $allowed)) {
  $page = 'Home';
}

require __DIR__ . "/screens/{$page}.php";
