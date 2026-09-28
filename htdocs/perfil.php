<?php /* Play Spot — Perfil */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Play Spot — Minha Conta</title>
<link rel="icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<style>html,body{height:auto!important;overflow:auto!important;}#app{height:auto!important;overflow:visible!important;}#perfil{height:auto!important;overflow:visible!important;min-height:100vh;}</style>
</head><body>
<div id="app"><div class="screen active" id="perfil">
  <div class="topbar"><button class="back-btn" onclick="window.location.href='index.php'">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>Voltar
  </button></div>
  <div class="form-scroll" style="overflow:visible;">
    <div style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:12px 0 20px;">
      <div class="avatar-circle" id="perfilAvatar" style="width:80px;height:80px;font-size:1.8rem;">??</div>
      <div class="detalhe-name" id="perfilNome" style="margin:0;">Carregando...</div>
      <div class="detalhe-loc" style="margin:0;"><span id="perfilEmail">—</span></div>
    </div>
    <div class="info-block" id="perfilBairroBlock" style="display:none;"><div class="info-block-title">Localização</div><div class="infra-item"><div class="infra-dot"></div><span id="perfilBairro">—</span></div></div>
    <div class="info-block" id="perfilEsportesBlock" style="display:none;"><div class="info-block-title">Esportes favoritos</div><div class="spot-tags" id="perfilEsportesTags"></div></div>
    <div class="info-block" id="perfilPresencasBlock" style="display:none;"><div class="info-block-title">Minhas confirmações recentes</div><div class="infra-list" id="perfilPresencasList"></div></div>
    <button class="btn-ghost fw" id="btnLogout" style="margin-top:8px;margin-bottom:32px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" style="margin-right:6px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Sair da conta
    </button>
  </div>
</div></div>
<script src="js/common.js"></script><script src="js/perfil.js"></script>
</body></html>
