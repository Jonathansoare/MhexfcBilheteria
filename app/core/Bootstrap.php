<?php
require __DIR__ . '/../../config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

spl_autoload_register(function ($class) {
    // Remove "App\" do início
    $class = str_replace('App\\', '', $class);

    // Converte namespace em pasta
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});