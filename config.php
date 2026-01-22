<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambiente
define('APP_NAME', 'Bilheteria Museu');
define('APP_ENV', 'local'); // local | prod

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = '/bilheteria'; // nome da pasta no htdocs

define('APP_URL', $protocol . '://' . $host . $basePath);

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
$baseUrl = $basePath; // usado em links CSS/JS

// Segurança
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_NAME', 'bilheteria_session');

// Paginação / limites
define('MAX_TICKETS_PER_ORDER', 10);

// Debug
define('DEBUG', true);
if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}
