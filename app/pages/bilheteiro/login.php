<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['bilheteiro_user'])) {
    header("Location: /bilheteria/bilheteiro/dashboard");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acesso ao Sistema</title>
<style>
body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: Arial, sans-serif;
}
.login-box {
    background: #fff;
    padding: 32px;
    border-radius: 14px;
    width: 100%;
    max-width: 360px;
    box-shadow: 0 10px 25px rgba(0,0,0,.2);
}
.login-box h2 {
    text-align: center;
    margin-bottom: 24px;
    color: #1e3c72;
}
.login-box input, .login-box button {
    width: 100%;
    padding: 12px;
    margin-bottom: 14px;
    border-radius: 8px;
    font-size: 15px;
}
.login-box input { border: 1px solid #ccc; }
.login-box button {
    background: #1e3c72;
    border: none;
    color: #fff;
    cursor: pointer;
}
.login-box button:hover { background: #16305a; }
.msg { text-align: center; font-size: 14px; color: red; }
</style>
</head>
<body>

<div class="login-box">
    <h2>Acesso ao Sistema</h2>
    <form id="loginForm">
        <input type="text" name="user" placeholder="Usuário" required>
        <input type="password" name="pass" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <div class="msg" id="msg"></div>
</div>

<script>
document.getElementById("loginForm").addEventListener("submit", e => {
    e.preventDefault();
    const msg = document.getElementById("msg");
    msg.textContent = "Entrando...";

    fetch('/bilheteria/bilheteiro/doLogin', {
        method: 'POST',
        body: new FormData(e.target)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            window.location.href = data.redirect;
        } else {
            msg.textContent = data.message;
        }
    })
    .catch(() => msg.textContent = 'Erro de conexão com o servidor');
});
</script>

</body>
</html>
