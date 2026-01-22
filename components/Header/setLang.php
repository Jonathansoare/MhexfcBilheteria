<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
    $lang = $_POST['lang'];
    $_SESSION['lang'] = $lang;
    echo json_encode(['status' => 'ok']);
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
