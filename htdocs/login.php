<?php /* Play Spot — Login */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Play Spot — Entrar</title>
<link rel="icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head><body>
<div id="app"><div class="screen active" id="login">
  <div class="orb1"></div><div class="orb2"></div>
  <div class="hero-area">
    <img src="logo.png" alt="Play Spot" class="app-logo">
    <div class="app-name">PLAY SPOT</div>
    <div class="app-tag-wrap"><span class="app-tag-pulse"></span><div class="app-tag">Conectando <em>jovens</em> ao <em>esporte</em></div></div>
  </div>
  <div class="form-area">
    <div class="form-msg" id="loginMsg"></div>
    <input class="input-field" type="email" id="loginEmail" placeholder="E-mail" autocomplete="email">
    <input class="input-field" type="password" id="loginSenha" placeholder="Senha" autocomplete="current-password">
    <button class="btn-orange fw" id="btnLogin">Entrar</button>
    <div class="divider">ou</div>
    <button class="btn-ghost fw" onclick="window.location.href='cadastro.php'">Criar conta nova</button>
    <button class="btn-ghost fw" style="margin-top:4px;font-size:0.82rem;opacity:0.7;" onclick="window.location.href='index.php'">← Voltar para os locais</button>
  </div>
</div></div>
<script src="js/common.js"></script><script src="js/login.js"></script>
</body></html>
