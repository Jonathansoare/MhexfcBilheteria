<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Função env() protegida
|--------------------------------------------------------------------------
*/
if (!function_exists('env')) {
    function env($key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}

/*
|--------------------------------------------------------------------------
| Configurações da Aplicação
|--------------------------------------------------------------------------
*/
if (!defined('APP_NAME')) define('APP_NAME', env('APP_NAME', 'Bilheteria'));
if (!defined('APP_ENV'))  define('APP_ENV', env('APP_ENV', 'local'));
if (!defined('DEBUG'))    define('DEBUG', filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN));
if (!defined('TIMEZONE')) define('TIMEZONE', env('TIMEZONE', 'America/Sao_Paulo'));

date_default_timezone_set(TIMEZONE);

/*
|--------------------------------------------------------------------------
| URL Base
|--------------------------------------------------------------------------
*/
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = env('APP_BASE_PATH', '');

if (!defined('APP_URL')) define('APP_URL', $protocol . '://' . $host . $basePath);

/*
|--------------------------------------------------------------------------
| Banco de Dados
|--------------------------------------------------------------------------
*/
if (!defined('DB_HOST')) define('DB_HOST', env('DB_HOST', 'localhost'));
if (!defined('DB_NAME')) define('DB_NAME', env('DB_NAME', 'bilheteria'));
if (!defined('DB_USER')) define('DB_USER', env('DB_USER', 'root'));
if (!defined('DB_PASS')) define('DB_PASS', env('DB_PASS', ''));

/*
|--------------------------------------------------------------------------
| Debug
|--------------------------------------------------------------------------
*/
if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}
