<?php
namespace App\Core;

class Auth {
  public static function check() {
    if (empty($_SESSION['usuario'])) {
      header("Location: /login");
      exit;
    }
  }
}