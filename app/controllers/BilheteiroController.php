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
                'data' => '2026-01-20',
                'quantidade' => ['Inteira'=>2, 'Meia'=>1, 'Isento'=>0],
                'codigo' => 'qweqweqwe123123qweqwe',
                'dataValidade' => '2026-02-05 23:59:59'
            ],
            'XYZ456' => [
                'nome' => 'Maria Santos',
                'data' => '2026-01-22',
                'quantidade' => ['Inteira'=>1, 'Meia'=>2, 'Isento'=>0],
                'codigo' => 'zxcvzxcv456456zxcvzxcv',
                'dataValidade' => '2026-02-05 23:59:59'
            ],
            'VIP777' => [
                'nome' => 'Carlos VIP',
                'data' => '2026-02-10',
                'quantidade' => ['Inteira'=>1, 'Meia'=>0, 'Isento'=>0],
                'codigo' => 'asdasdasd7777asdasdasd',
                'dataValidade' => '2026-02-05 23:59:59'
            ],
            'FREE999' => [
                'nome' => 'Ana Cortesia',
                'data' => '2026-02-05',
                'quantidade' => ['Inteira'=>0, 'Meia'=>0, 'Isento'=>1],
                'codigo' => 'hjgfhgdhg3773yghsdhdghgsfh',
                'dataValidade' => '2026-02-05 23:59:59'
            ],
            'TEST2026' => [
                'nome' => 'Evento Teste',
                'data' => '2026-03-01',
                'quantidade' => ['Inteira'=>1, 'Meia'=>0, 'Isento'=>0],
                'codigo' => 'testevent2026code',
                'dataValidade' => '2026-02-28 23:59:59',
            ],
            'ING12345' => [
                'nome' => 'Paulo Rocha',
                'data' => '2026-02-18',
                'quantidade' => ['Inteira'=>1, 'Meia'=>0, 'Isento'=>0],
                'codigo' => 'plmokn12345ijnuhbgt',
                'dataValidade' => '2026-02-25 23:59:59',
            ],
            'DEMO001' => [
                'nome' => 'Simulação Bilheteiro',
                'data' => '2026-02-20',
                'quantidade' => ['Inteira'=>0, 'Meia'=>1, 'Isento'=>0],
                'codigo' => 'demo0001bilheteiro',
                'dataValidade' => '2026-02-25 23:59:59',
            ],
            'DEMO002' => [
                'nome' => 'Simulação Admin',
                'data' => '2026-02-21',
                'quantidade' => ['Inteira'=>2, 'Meia'=>0, 'Isento'=>0],
                'codigo' => 'demo0002admin',
                'dataValidade' => '2026-02-25 23:59:59',
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
