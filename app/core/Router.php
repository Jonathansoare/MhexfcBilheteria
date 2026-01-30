<?php
namespace App\Core;

class Router {
    public static function run() {

        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');

        $routes = [
            ''                     => ['controller' => 'HomeController', 'method' => 'index'],
            'home'                 => ['controller' => 'HomeController', 'method' => 'index'],

            // Bilheteiro
            'bilheteiro/login'     => ['controller' => 'BilheteiroController', 'method' => 'login'],
            'bilheteiro/dashboard' => ['controller' => 'BilheteiroController', 'method' => 'dashboard'],
            'bilheteiro/validacao' => ['controller' => 'BilheteiroController', 'method' => 'validacao'],
            'bilheteiro/validar'   => ['controller' => 'BilheteiroController', 'method' => 'validar'],
            'bilheteiro/doLogin'  => ['controller' => 'BilheteiroController', 'method' => 'doLogin'],
            'bilheteiro/logout'    => ['controller' => 'BilheteiroController', 'method' => 'logout'],
        ];


        if (!isset($routes[$url])) {
            // DEBUG temporário 👇
            // echo "Rota não encontrada: " . htmlspecialchars($url);
            $url = '';
        }

        $config = $routes[$url];
        $controllerName = "\\App\\Controllers\\" . $config['controller'];
        $controller = new $controllerName;
        $method = $config['method'];

        $controller->$method();
    }
}
