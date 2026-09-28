<?php /* Play Spot — Cadastro */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Play Spot — Criar Conta</title>
<link rel="icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head><body>
<div id="app"><div class="screen active" id="cadastro">
  <div class="topbar"><button class="back-btn" onclick="window.location.href='login.php'">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>Voltar
  </button></div>
  <div class="form-scroll">
    <div class="section-title-small">Criar conta</div>
    <div class="form-msg" id="cadastroMsg"></div>
    <div class="avatar-pick">
      <div class="avatar-circle" id="avatarPreview">📸</div>
      <div class="avatar-text"><strong>Foto de perfil</strong>Opcional — usaremos suas iniciais</div>
    </div>
    <div class="form-group"><span class="form-label">Nome completo</span><input class="input-field" type="text" id="cadNome" placeholder="Seu nome"></div>
    <div class="form-group"><span class="form-label">E-mail</span><input class="input-field" type="email" id="cadEmail" placeholder="seuemail@exemplo.com"></div>
    <div class="form-group"><span class="form-label">Senha</span><input class="input-field" type="password" id="cadSenha" placeholder="Mínimo 6 caracteres"></div>
    <div class="form-group"><span class="form-label">Bairro</span><input class="input-field" type="text" id="cadBairro" placeholder="Seu bairro em Contagem"></div>
    <div class="form-group"><span class="form-label">Esportes favoritos</span><div class="filter-row" id="cadEsportes" style="padding:4px 0;"></div></div>
    <button class="btn-orange fw" id="btnCadastro" style="margin-top:8px;">Criar minha conta</button>
  </div>
</div></div>
<script src="js/common.js"></script><script src="js/cadastro.js"></script>
</body></html>
