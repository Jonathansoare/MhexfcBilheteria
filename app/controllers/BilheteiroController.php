<?php
namespace App\Controllers;

class BilheteiroController {

    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

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
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) session_start();

    $codigo = trim($_GET['codigo'] ?? '');

    if ($codigo === '') {
        echo json_encode(["status"=>"invalid","mensagem"=>"❌ Código vazio"]);
        return;
    }

    // Base fake (DEMO)
    $base = [
        "ABC123" => ["nome"=>"João Silva","data"=>"2026-01-31","quantidade"=>["Inteira"=>2,"Meia"=>1,"Isento"=>0]],
        "XYZ456" => ["nome"=>"Maria Santos","data"=>"2026-01-30","quantidade"=>["Inteira"=>1,"Meia"=>2,"Isento"=>0]],
        "VIP777" => ["nome"=>"Cliente VIP","data"=>"2026-01-31","quantidade"=>["Inteira"=>1,"Meia"=>0,"Isento"=>0]],
        "FREE999"=> ["nome"=>"Cortesia","data"=>"2026-01-29","quantidade"=>["Inteira"=>0,"Meia"=>0,"Isento"=>1]],
    ];

    if (!isset($base[$codigo])) {
        echo json_encode(["status"=>"invalid","mensagem"=>"❌ QR Code não encontrado"]);
        return;
    }

    $ingresso = $base[$codigo];

    $hoje = new \DateTime('today');
    $dataIngresso = new \DateTime($ingresso['data']);
    $agora = new \DateTime();

    // Sessão para controle diário
    if (!isset($_SESSION['usos'])) $_SESSION['usos'] = [];

    $usadoHoje = false;
    $horaUltimoUso = null;

    if (isset($_SESSION['usos'][$codigo])) {
        $registro = $_SESSION['usos'][$codigo];
        if ($registro['data'] === $hoje->format('Y-m-d')) {
            $usadoHoje = true;
            $horaUltimoUso = $registro['hora'];
        }
    }

    if ($hoje > $dataIngresso) {
        $status = 'expired';
        $mensagem = '❌ Ingresso expirado em ' . $dataIngresso->format('d/m/Y');
    } else {
        $status = 'ok';

        if ($hoje == $dataIngresso) {
            $mensagem = '⚠️ Válido somente hoje (' . $dataIngresso->format('d/m/Y') . ')';
        } else {
            $mensagem = '✅ Ingresso válido para ' . $dataIngresso->format('d/m/Y');
        }

        if ($usadoHoje) {
            $mensagem .= ' • ⚠️ Já validado hoje às ' . $horaUltimoUso;
        }

        // Marca uso do dia
        $_SESSION['usos'][$codigo] = [
            'data' => $hoje->format('Y-m-d'),
            'hora' => $agora->format('H:i:s')
        ];
    }

    echo json_encode([
        "status"=>$status,
        "mensagem"=>$mensagem,
        "codigo"=>$codigo,
        "nome"=>$ingresso['nome'],
        "data"=>$ingresso['data'],
        "quantidade"=>$ingresso['quantidade'],
        "hora_validacao"=>$agora->format('H:i:s')
    ]);
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

    private function checkAuth($tipo=null){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['bilheteiro_user']) || ($tipo && $_SESSION['user_tipo'] !== $tipo)) {
            header("Location: /bilheteria/bilheteiro/login");
            exit;
        }
    }
}
