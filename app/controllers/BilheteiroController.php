<?php
namespace App\Controllers;

class BilheteiroController {

    public function login() {
        require __DIR__ . '/../pages/bilheteiro/login.php';
    }

    public function dashboard() {
        $this->checkAuth();
        require __DIR__ . '/../pages/admin/dashboard.php'; // Dashboard agora na pasta admin
    }

    public function validacao() {
        $this->checkAuth();
        require __DIR__ . '/../pages/bilheteiro/validacao.php';
    }

    public function validar() {
        $this->checkAuth();
        header('Content-Type: application/json');

        $codigo = $_POST['codigo'] ?? '';
        if (!$codigo) {
            echo json_encode(['status' => 'error', 'message' => 'Código não informado']);
            exit;
        }

        // Dados de teste (simula consulta ao banco)
        $ingressosFake = [
            'ABC123' => [
                'nome'      => 'João Silva',
                'data'      => '20/01/2026',
                'quantidade'=> ['Inteira'=>2, 'Meia'=>1, 'Isento'=>0]
            ],
            'XYZ456' => [
                'nome'      => 'Maria Santos',
                'data'      => '22/01/2026',
                'quantidade'=> ['Inteira'=>1, 'Meia'=>2, 'Isento'=>0]
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


        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';


    // EXEMPLO SIMPLES
        if ($user === 'admin' && $pass === '1234') {
        $_SESSION['bilheteiro_user'] = $user;
        echo json_encode(['status' => 'ok']);
        } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuário ou senha inválidos']);
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /bilheteria/?route=loginBilheteiro");
        exit;
    }

    private function checkAuth() {
        if (empty($_SESSION['bilheteiro_user'])) {
            header("Location: /bilheteria/?route=loginBilheteiro");
            exit;
        }
    }
}