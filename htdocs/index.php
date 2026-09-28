<?php /* Play Spot */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Play Spot — Esportes em Contagem</title>
<link rel="icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head><body>
<div id="app"><div class="screen active" id="home">
  <div class="topbar">
    <div class="topbar-logo"><img src="logo.png" alt="Play Spot"><span>PLAY SPOT</span></div>
    <div id="topbarAcao"></div>
  </div>
  <div class="search-bar">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input type="text" id="buscaInput" placeholder="Buscar local ou bairro...">
  </div>
  <div class="filter-row" id="filtroEsportes"><div class="chip active" data-esporte="">Todos</div></div>
  <div class="list-scroll"><div id="listaLocais"><div class="empty-state"><span>⏳</span>Carregando...</div></div></div>
</div></div>
<script src="js/common.js"></script><script src="js/index.js"></script>
</body></html>
