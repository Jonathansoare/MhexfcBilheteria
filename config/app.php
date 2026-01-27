<?php
// Inicia sessão se ainda não iniciou
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambiente
if (!defined('APP_NAME')) define('APP_NAME', 'Bilheteria Museu');
if (!defined('APP_ENV'))  define('APP_ENV', 'local'); // local | prod

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = '/bilheteria'; // nome da pasta no htdocs

if (!defined('APP_URL')) define('APP_URL', $protocol . '://' . $host . $basePath);

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Banco de dados
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'bilheteria');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');

// Caminhos do projeto
if (!defined('BASE_PATH')) define('BASE_PATH', __DIR__);
if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', BASE_PATH . '/public');
if (!defined('COMPONENTS_PATH')) define('COMPONENTS_PATH', BASE_PATH . '/components');
if (!defined('ASSETS_PATH')) define('ASSETS_PATH', APP_URL . '/assets');

// Segurança
if (!defined('CSRF_TOKEN_NAME')) define('CSRF_TOKEN_NAME', 'csrf_token');
if (!defined('SESSION_NAME')) define('SESSION_NAME', 'bilheteria_session');

// Limites
if (!defined('MAX_TICKETS_PER_ORDER')) define('MAX_TICKETS_PER_ORDER', 10);

// Debug
if (!defined('DEBUG')) define('DEBUG', true);
if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}