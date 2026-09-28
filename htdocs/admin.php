<?php /* Play Spot — Admin */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Play Spot — Admin</title>
<link rel="icon" href="favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">
</head><body>
<div class="admin-login-wrap" id="adminLoginWrap">
  <div class="admin-login-card">
    <img src="logo.png" alt="Play Spot">
    <div class="admin-login-title">PAINEL ADMIN</div>
    <div class="admin-login-sub">Acesso restrito</div>
    <div class="form-msg" id="loginMsg"></div>
    <div style="display:flex;flex-direction:column;gap:12px;">
      <input class="input-field" type="password" id="adminSenha" placeholder="Senha de acesso">
      <button class="btn-orange" id="btnAdminLogin">Entrar</button>
    </div>
  </div>
</div>
<div class="admin-shell" id="adminShell">
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-logo"><img src="logo.png" alt=""><div><span>PLAY SPOT</span><small>Admin</small></div></div>
    <nav class="admin-nav">
      <button class="admin-nav-item active" data-page="dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>Dashboard
      </button>
      <button class="admin-nav-item" data-page="locais">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>Locais
      </button>
      <button class="admin-nav-item" data-page="config">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9"/></svg>Configurações
      </button>
    </nav>
    <div class="admin-nav-footer">
      <button class="admin-nav-item" id="btnAdminSair">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Sair
      </button>
    </div>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <div style="display:flex;align-items:center;gap:14px;">
        <button class="menu-toggle" id="menuToggle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
        <div><div class="admin-page-title" id="pageTitle">Dashboard</div><div class="admin-page-sub" id="pageSub">Visão geral da plataforma</div></div>
      </div>
    </div>
    <div class="admin-content">
      <div class="admin-page active" id="page-dashboard">
        <div class="stats-grid">
          <div class="stat-card"><span class="stat-icon">🏟</span><div class="stat-value" id="statLocais">—</div><div class="stat-label">Locais cadastrados</div></div>
          <div class="stat-card"><span class="stat-icon">✅</span><div class="stat-value" id="statAbertos">—</div><div class="stat-label">Locais abertos</div></div>
          <div class="stat-card"><span class="stat-icon">👥</span><div class="stat-value" id="statUsuarios">—</div><div class="stat-label">Usuários cadastrados</div></div>
          <div class="stat-card"><span class="stat-icon">🏃</span><div class="stat-value" id="statPresencas">—</div><div class="stat-label">Confirmações hoje</div></div>
        </div>
        <div class="panel"><div class="panel-title">Locais mais ativos</div><div id="rankAtivos"></div></div>
      </div>
      <div class="admin-page" id="page-locais" style="display:none;">
        <div class="toolbar"><div></div><button class="btn-add" id="btnNovoLocal"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" width="16" height="16"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Novo local</button></div>
        <table class="locais-table">
          <thead><tr><th>Local</th><th>Bairro</th><th>Esportes</th><th>Status</th><th>Jogadores hoje</th><th></th></tr></thead>
          <tbody id="tabelaLocais"><tr class="empty-row"><td colspan="6">Carregando...</td></tr></tbody>
        </table>
      </div>
      <div class="admin-page" id="page-config" style="display:none;">
        <div class="panel config-card">
          <div class="panel-title">Trocar senha de acesso</div>
          <div class="form-msg" id="senhaMsg"></div>
          <div style="display:flex;flex-direction:column;gap:14px;">
            <div class="form-group"><span class="form-label">Senha atual</span><input class="input-field" type="password" id="senhaAtual"></div>
            <div class="form-group"><span class="form-label">Nova senha</span><input class="input-field" type="password" id="senhaNova" placeholder="Mínimo 6 caracteres"></div>
            <button class="btn-orange" id="btnTrocarSenha">Atualizar senha</button>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<div class="modal-overlay" id="modalLocal">
  <div class="modal-box">
    <div class="modal-header"><h3 id="modalLocalTitulo">Novo local</h3><button class="modal-close" id="btnFecharModalLocal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>
    <div class="modal-body">
      <div class="form-msg" id="modalLocalMsg"></div>
      <input type="hidden" id="fLocalId">
      <div class="form-row">
        <div class="form-group"><span class="form-label">Nome do local</span><input class="input-field" type="text" id="fNome" placeholder="Ex: Quadra do Riacho"></div>
        <div class="form-group"><span class="form-label">Emoji de capa</span><input class="input-field" type="text" id="fEmoji" placeholder="🏀" maxlength="4"></div>
      </div>
      <div class="form-group"><span class="form-label">Endereço</span><input class="input-field" type="text" id="fEndereco" placeholder="Rua, número"></div>
      <div class="form-row">
        <div class="form-group"><span class="form-label">Bairro</span><input class="input-field" type="text" id="fBairro"></div>
        <div class="form-group"><span class="form-label">Cidade</span><input class="input-field" type="text" id="fCidade" value="Contagem, MG"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><span class="form-label">Latitude</span><input class="input-field" type="text" id="fLatitude" placeholder="Ex: -19.9320"></div>
        <div class="form-group"><span class="form-label">Longitude</span><input class="input-field" type="text" id="fLongitude" placeholder="Ex: -44.0536"></div>
      </div>
      <div class="checkbox-row"><input type="checkbox" id="fAberto" checked><span>Local está aberto atualmente</span></div>
      <div class="form-group"><span class="form-label">Esportes disponíveis</span><div class="chip-select" id="fEsportes"></div></div>
      <div class="form-group"><span class="form-label">Infraestrutura</span><div class="infra-rows" id="fInfraRows"></div><button class="btn-link-add" id="btnAddInfra">+ Adicionar item de infraestrutura</button></div>
    </div>
    <div class="modal-footer"><button class="btn-cancel" id="btnCancelarLocal">Cancelar</button><button class="btn-orange" id="btnSalvarLocal" style="flex:1;">Salvar local</button></div>
  </div>
</div>
<script src="js/admin.js"></script>
</body></html>
