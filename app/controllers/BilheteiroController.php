<?php
namespace App\Controllers;

class BilheteiroController {

    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Se já estiver logado, redireciona conforme tipo
        if (!empty($_SESSION['bilheteiro_user'])) {
            if ($_SESSION['user_tipo'] === 'admin') {
                header("Location: /bilheteria/bilheteiro/dashboard");
            } else {
                header("Location: /bilheteria/bilheteiro/validacao");
            }
            exit;
        }

        require __DIR__ . '/../pages/bilheteiro/login.php';
    }

    public function dashboard() {
        $this->checkAuth('admin');
        require __DIR__ . '/../pages/admin/dashboard.php';
    }

    public function validacao() {
        $this->checkAuth('bilheteiro');
        require __DIR__ . '/../pages/bilheteiro/validacao.php';
    }

    public function validar() {
        $this->checkAuth();
        header('Content-Type: application/json');

        $codigo = $_GET['codigo'] ?? $_POST['codigo'] ?? '';
        if (!$codigo) {
            echo json_encode(['status' => 'error', 'message' => 'Código não informado']);
            exit;
        }

        $ingressosFake = [
            'ABC123' => [
                'nome' => 'João Silva',
                'data' => '20/01/2026',
                'quantidade' => ['Inteira'=>2, 'Meia'=>1, 'Isento'=>0]
            ],
            'XYZ456' => [
                'nome' => 'Maria Santos',
                'data' => '22/01/2026',
                'quantidade' => ['Inteira'=>1, 'Meia'=>2, 'Isento'=>0]
            ]
        ];

        if (isset($ingressosFake[$codigo])) {
            echo json_encode(array_merge(['status'=>'ok'], $ingressosFake[$codigo]));
        } else {
            echo json_encode(['status'=>'error', 'message'=>'Ingresso inválido']);
        }
    }

    public function doLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';

        if ($user === 'admin' && $pass === '1234') {
            $_SESSION['user_tipo'] = 'admin';
            $_SESSION['bilheteiro_user'] = $user;

            echo json_encode([
                'status' => 'ok',
                'redirect' => '/bilheteria/bilheteiro/dashboard'
            ]);
            exit;
        }

        if ($user === 'bilheteiro' && $pass === '1234') {
            $_SESSION['user_tipo'] = 'bilheteiro';
            $_SESSION['bilheteiro_user'] = $user;

            echo json_encode([
                'status' => 'ok',
                'redirect' => '/bilheteria/bilheteiro/validacao'
            ]);
            exit;
        }

        echo json_encode(['status' => 'error', 'message' => 'Usuário ou senha inválidos']);
        exit;
    }

    public function logout() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_destroy();

    header("Location: /bilheteria/bilheteiro/login");
    exit;
}

    private function checkAuth($tipo = null) {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['bilheteiro_user'])) {
            header("Location: /bilheteria/bilheteiro/login");
            exit;
        }

        if ($tipo && $_SESSION['user_tipo'] !== $tipo) {
            header("Location: /bilheteria/bilheteiro/login");
            exit;
        }
    }
}
