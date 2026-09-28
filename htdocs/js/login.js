document.getElementById('btnLogin').addEventListener('click', function() {
  limparMsg('loginMsg');
  var email = document.getElementById('loginEmail').value.trim();
  var senha = document.getElementById('loginSenha').value;
  if (!email || !senha) { mostrarMsg('loginMsg', 'Preencha e-mail e senha.'); return; }
  api('login.php', { method: 'POST', body: JSON.stringify({ email: email, senha: senha }) })
    .then(function() {
      var v = new URLSearchParams(window.location.search).get('voltar');
      window.location.href = v ? decodeURIComponent(v) : 'index.php';
    }).catch(function(e) { mostrarMsg('loginMsg', e.message); });
});
document.getElementById('loginSenha').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') document.getElementById('btnLogin').click();
});
api('sessao.php').then(function(d) { if (d.logado) window.location.href = 'index.php'; }).catch(function() {});
