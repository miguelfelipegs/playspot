api('esportes.php').then(function(d) {
  var c = document.getElementById('cadEsportes');
  c.innerHTML = d.esportes.map(function(e) { return '<div class="chip" data-esporte-id="' + e.id + '">' + e.emoji + ' ' + e.nome + '</div>'; }).join('');
  c.querySelectorAll('.chip').forEach(function(ch) { ch.addEventListener('click', function() { ch.classList.toggle('active'); }); });
}).catch(function(e) { console.error(e); });
document.getElementById('btnCadastro').addEventListener('click', function() {
  limparMsg('cadastroMsg');
  var nome = document.getElementById('cadNome').value.trim();
  var email = document.getElementById('cadEmail').value.trim();
  var senha = document.getElementById('cadSenha').value;
  var bairro = document.getElementById('cadBairro').value.trim();
  var esportes = Array.from(document.querySelectorAll('#cadEsportes .chip.active')).map(function(c) { return parseInt(c.dataset.esporteId); });
  if (!nome || !email || !senha) { mostrarMsg('cadastroMsg', 'Nome, e-mail e senha são obrigatórios.'); return; }
  api('cadastro.php', { method: 'POST', body: JSON.stringify({ nome:nome, email:email, senha:senha, bairro:bairro, esportes:esportes }) })
    .then(function() { window.location.href = 'index.php'; })
    .catch(function(e) { mostrarMsg('cadastroMsg', e.message); });
});
