<?php
// Ambiente
define('APP_NAME', 'Bilheteria Museu');
define('APP_ENV', 'local'); // local | prod
define('APP_URL', 'http://172.20.10.6/bilheteria');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'bilheteria');
define('DB_USER', 'root');
define('DB_PASS', '');

// Caminhos do projeto
define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH . '/public');
define('COMPONENTS_PATH', BASE_PATH . '/components');
define('ASSETS_PATH', APP_URL . '/assets');
$baseUrl = '/bilheteria'; // se estiver no htdocs/bilheteria


// Segurança
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_NAME', 'bilheteria_session');

// Paginação / limites
define('MAX_TICKETS_PER_ORDER', 10);

// Pagamento (exemplo futuro)
define('PAGAMENTO_PROVIDER', 'PagTesouro');

// Debug
define('DEBUG', true);
if (DEBUG) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
} else {
  ini_set('display_errors', 0);
}
