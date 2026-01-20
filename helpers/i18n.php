<?php

if (!function_exists('t')) {
  function t(string $key): string {
    static $lang = null;


    if ($lang === null) {
      // Idioma padrão
      $locale = $_SESSION['lang'] ?? 'pt-BR';

      $file = __DIR__ . "/../lang/{$locale}.php";

      if (!file_exists($file)) {
        $file = __DIR__ . "/../lang/pt-BR.php";
      }

      $lang = require $file;
    }

    return $lang[$key] ?? $key;
  }
}
