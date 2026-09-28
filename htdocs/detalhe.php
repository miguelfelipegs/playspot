<?php /* Play Spot — Detalhe */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Play Spot — Local</title>
<link rel="icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/detalhe.css">
</head><body>
<main class="dt-page">
  <div class="dt-wrap">

    <button class="dt-back" type="button" onclick="window.location.href='index.php'">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>Voltar
    </button>

    <!-- Capa com emoji + status -->
    <div class="dt-hero">
      <div class="dt-status" id="statusRow"></div>
      <span class="dt-hero-emoji" id="spotEmoji">🏟</span>
    </div>

    <div class="dt-grid">
      <!-- Nome, endereço e tags -->
      <section class="dt-info">
        <h1 class="dt-name" id="spotName">Carregando…</h1>
        <div class="dt-loc">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <span id="spotLoc">—</span>
        </div>
        <!-- Esportes (laranja) + infraestrutura (cinza) -->
        <div class="dt-tags" id="spotTags"></div>
      </section>

      <!-- Jogadores confirmados + horários de hoje -->
      <div class="dt-players">
        <div class="dt-players-row">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <span id="playersCount">—</span>
        </div>
        <div class="dt-horarios" id="horariosList"></div>
      </div>

      <!-- Mapa -->
      <div class="dt-map" id="mapaBlock" hidden>
        <iframe id="mapaIframe" class="dt-map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa do local"></iframe>
        <a class="dt-map-link" id="linkGoogleMaps" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Abrir no Google Maps
        </a>
      </div>

      <!-- CTA (logado: Quero Jogar / deslogado: criar conta ou entrar) -->
      <div class="dt-cta" id="ctaArea"></div>
    </div>

  </div>
</main>

<!-- Modal Quero Jogar -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal-sheet" role="dialog" aria-modal="true" aria-labelledby="modalTitulo">
    <div class="modal-handle"></div>
    <div class="modal-title" id="modalTitulo">Quero Jogar!</div>
    <div class="modal-sub">Confirme sua presença neste local</div>
    <div class="modal-row"><span class="modal-label">Esporte</span><select class="modal-input" id="modalEsporte"></select></div>
    <div class="modal-row-split">
      <div class="modal-row"><span class="modal-label">Data</span><input class="modal-input" type="date" id="modalData"></div>
      <div class="modal-row"><span class="modal-label">Horário</span><input class="modal-input" type="time" id="modalHorario"></div>
    </div>
    <div class="modal-row"><span class="modal-label">Quantas pessoas vão com você?</span>
      <div class="pessoas-row"><button class="qtd-btn" type="button" id="qtdMenos">−</button><span class="qtd-num" id="qtdNum">1</span><button class="qtd-btn" type="button" id="qtdMais">+</button></div>
    </div>
    <div class="form-msg" id="modalMsg"></div>
    <button class="modal-confirm" type="button" id="btnConfirmarJogar">Confirmar presença</button>
  </div>
</div>

<div class="toast" id="toast"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg><span id="toastMsg">Presença confirmada!</span></div>

<script src="js/common.js"></script><script src="js/detalhe.js"></script>
</body></html>
