<?php
if (!empty($_SESSION['bilheteiro_user'])) {
    header("Location: /bilheteria/?route=dashboardBilheteiro");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
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

.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 15px;
}

.login-box button {
    width: 100%;
    padding: 12px;
    background: #1e3c72;
    border: none;
    border-radius: 8px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

.login-box button:hover {
    background: #16305a;
}

.msg {
    text-align: center;
    margin-top: 10px;
    font-size: 14px;
    color: red;
}
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
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const msg  = document.getElementById("msg");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        msg.textContent = "Entrando...";

        const formData = new FormData(form);

        try {
            const res = await fetch("/bilheteria/?route=doLogin", {
                method: "POST",
                body: formData
            });

            const data = await res.json();

            if (data.status === "ok") {
                window.location.href = "/bilheteria/?route=dashboardBilheteiro";
            } else {
                msg.textContent = data.message || "Erro ao entrar";
            }
        } catch (err) {
            msg.textContent = "Erro de conexão";
        }
    });
});
</script>

</body>
</html>