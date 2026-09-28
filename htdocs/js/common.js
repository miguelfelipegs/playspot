var API = 'api';
function api(endpoint, options) {
  options = options || {};
  return fetch(API + '/' + endpoint, Object.assign({ headers: { 'Content-Type': 'application/json' }, credentials: 'same-origin' }, options))
    .then(function(res) {
      return res.json().catch(function() { return {}; }).then(function(dados) {
        if (!res.ok) throw new Error(dados.erro || 'Erro inesperado.');
        return dados;
      });
    });
}
function mostrarMsg(elId, texto, tipo) {
  var el = document.getElementById(elId); if (!el) return;
  el.textContent = texto; el.className = 'form-msg show ' + (tipo || 'error');
}
function limparMsg(elId) {
  var el = document.getElementById(elId); if (!el) return; el.className = 'form-msg';
}
function mostrarToast(texto) {
  var t = document.getElementById('toast'); if (!t) return;
  var m = document.getElementById('toastMsg'); if (m) m.textContent = texto;
  t.classList.add('show'); setTimeout(function() { t.classList.remove('show'); }, 3200);
}
function irPara(p) { window.location.href = p; }
function exigirSessao() {
  return api('sessao.php').then(function(d) {
    if (!d.logado) { window.location.href = 'login.php'; return null; }
    window.usuarioAtual = d.usuario; return d.usuario;
  }).catch(function() { window.location.href = 'login.php'; return null; });
}
function verificarSessao() {
  return api('sessao.php').then(function(d) {
    if (!d.logado) return null;
    window.usuarioAtual = d.usuario; return d.usuario;
  }).catch(function() { return null; });
}
