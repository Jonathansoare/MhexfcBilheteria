<?php

// Carrega config principal
require __DIR__ . '/../../config/app.php';

// Sessão
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Autoload simples PSR-4
spl_autoload_register(function ($class) {

    // Espera algo como: App\Controllers\HomeController
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../';

    // Verifica se a classe usa o prefixo App\
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    // Remove "App\"
    $relativeClass = substr($class, strlen($prefix));

    // Converte namespace em caminho
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
