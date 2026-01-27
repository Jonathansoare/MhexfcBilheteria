<?php
namespace App\Core;

class Router {
    public static function run() {
        $route = $_POST['route'] ?? $_GET['route'] ?? 'home';

        $routes = [
            'home'      => ['controller' => 'HomeController', 'method' => 'index'],
            'dados'     => ['controller' => 'HomeController', 'method' => 'dados'],
            'pagamento' => ['controller' => 'HomeController', 'method' => 'pagamento'],
            'setLang'   => ['controller' => 'HomeController', 'method' => 'setLang'],
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