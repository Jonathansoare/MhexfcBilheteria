<?php
namespace App\Controllers;

class HomeController {
    public function index() {
        require __DIR__ . '/../pages/home.php';
    }

    public function dados() {
        require __DIR__ . '/../pages/dados.php';
    }

    public function pagamento(){
        require __DIR__ . '/../pages/pagamento.php';
    }
    public function qrCodeFake(){
        require __DIR__ . '/../pages/qrcodes-demo.php';
    }

    public function setLang() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
            if(session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['lang'] = $_POST['lang'];
            echo json_encode(['status' => 'ok']);
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
    }
}