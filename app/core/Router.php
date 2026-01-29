<?php
namespace App\Core;

class Router {
    public static function run() {
        // Recebe a rota via POST ou GET
        $route = $_POST['route'] ?? $_GET['route'] ?? 'home';

        $routes = [
            'home'            => ['controller' => 'HomeController', 'method' => 'index'],
            'dados'           => ['controller' => 'HomeController', 'method' => 'dados'],
            'pagamento'       => ['controller' => 'HomeController', 'method' => 'pagamento'],
            'setLang'         => ['controller' => 'HomeController', 'method' => 'setLang'],
            'loginBilheteiro' => ['controller' => 'BilheteiroController', 'method' => 'login'],
            'dashboardBilheteiro' => ['controller' => 'BilheteiroController', 'method' => 'dashboard'],
            'validacaoBilheteiro' => ['controller' => 'BilheteiroController', 'method' => 'validacao'],
            'validarBilheteiro'   => ['controller' => 'BilheteiroController', 'method' => 'validar'],
            'doLogin' => ['controller' => 'BilheteiroController', 'method' => 'doLogin'],
            'logoutBilheteiro'    => ['controller' => 'BilheteiroController', 'method' => 'logout']
        ];

        if (!isset($routes[$route])) {
            $route = 'home';
        }

        $config = $routes[$route];

        $controllerName = "\\App\\Controllers\\" . $config['controller'];
        $controller = new $controllerName;
        $method = $config['method'];

        $controller->$method();
    }
}