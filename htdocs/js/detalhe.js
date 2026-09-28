var esportesCatalogo=[], localAtual=null, qtdPessoas=1;
function obterIdDaUrl(){ return new URLSearchParams(window.location.search).get('id'); }
function esc(t){ return String(t==null?'':t).replace(/[&<>"']/g,function(c){return{'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];}); }
function hojeLocal(){ var d=new Date(); return d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0'); }

var ICON_PLAY='<svg viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>';
var ICON_CLOCK='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';

function renderizarCTA(u) {
  var a = document.getElementById('ctaArea');
  if (u) {
    a.innerHTML = '<div class="dt-cta-box"><p class="dt-cta-text">Bora jogar? Confirme sua presença neste local.</p>'
      + '<div class="dt-cta-btns"><button class="dt-btn dt-btn-dark" id="btnAbrirModal" type="button">'+ICON_PLAY+'Quero Jogar Aqui</button></div></div>';
    document.getElementById('btnAbrirModal').addEventListener('click', abrirModalJogar);
  } else {
    a.innerHTML = '<div class="dt-cta-box"><p class="dt-cta-text">Quer jogar aqui? Crie uma conta gratuita.</p>'
      + '<div class="dt-cta-btns">'
      + '<button class="dt-btn dt-btn-dark" type="button" onclick="window.location.href=\'cadastro.php\'">Criar conta</button>'
      + '<button class="dt-btn dt-btn-outline" type="button" onclick="window.location.href=\'login.php\'">Entrar</button>'
      + '</div></div>';
  }
}
function carregarDetalhe(id) {
  return api('local.php?id=' + id).then(function(d) { localAtual=d.local; preencherDetalhe(d.local); }).catch(function(e) { console.error(e); });
}
function preencherDetalhe(l) {
  document.title = 'Play Spot — ' + l.nome;
  document.getElementById('spotEmoji').textContent = l.emoji_capa || '🏟';
  document.getElementById('spotName').textContent  = l.nome;
  document.getElementById('spotLoc').textContent   = (l.endereco?l.endereco+' — ':'')+(l.bairro?l.bairro+', ':'')+(l.cidade||'');
  document.getElementById('statusRow').innerHTML   = l.aberto?'<span class="dt-status-chip">Aberto agora</span>':'<span class="dt-status-chip fechado">Fechado</span>';

  var j=l.jogadores_hoje;
  document.getElementById('playersCount').textContent = j===0?'Nenhum jogador confirmado para hoje':j===1?'1 jogador confirmado para hoje':j+' jogadores confirmados para hoje';
  document.getElementById('horariosList').innerHTML = (l.horarios_hoje||[]).map(function(h){
    return '<span class="dt-horario">'+ICON_CLOCK+esc(h.horario)+' · '+h.qtd_pessoas+' '+(h.qtd_pessoas===1?'pessoa':'pessoas')+'</span>';
  }).join('');

  // Esportes (laranja) + itens de infraestrutura (cinza; riscado se indisponível)
  var tags = l.esportes.map(function(e){ return '<span class="dt-tag esporte">'+esc(e.emoji)+' '+esc(e.nome)+'</span>'; })
    .concat((l.infraestrutura||[]).map(function(i){
      return '<span class="dt-tag'+(i.disponivel?'':' off')+'" title="'+(i.disponivel?'Disponível':'Indisponível')+'">'+esc(i.descricao)+'</span>';
    }));
  document.getElementById('spotTags').innerHTML = tags.join('');

  if (l.latitude&&l.longitude) {
    document.getElementById('mapaIframe').src='https://www.google.com/maps?q='+l.latitude+','+l.longitude+'&output=embed';
    document.getElementById('linkGoogleMaps').href='https://www.google.com/maps?q='+l.latitude+','+l.longitude;
    document.getElementById('mapaBlock').hidden=false;
  }
}
function abrirModalJogar() {
  if (!localAtual) return;
  var p = esportesCatalogo.length>0?Promise.resolve():api('esportes.php').then(function(d){esportesCatalogo=d.esportes;});
  p.then(function(){
    var ids=localAtual.esportes.map(function(e){return e.id;});
    document.getElementById('modalEsporte').innerHTML=esportesCatalogo.filter(function(e){return ids.indexOf(e.id)!==-1;}).map(function(e){return '<option value="'+e.id+'">'+esc(e.emoji)+' '+esc(e.nome)+'</option>';}).join('');
    document.getElementById('modalData').value=hojeLocal();
    var a=new Date(); document.getElementById('modalHorario').value=String(a.getHours()).padStart(2,'0')+':'+String(a.getMinutes()).padStart(2,'0');
    qtdPessoas=1; document.getElementById('qtdNum').textContent=1; limparMsg('modalMsg');
    document.getElementById('modalOverlay').classList.add('open');
  });
}
function fecharModal(){ document.getElementById('modalOverlay').classList.remove('open'); }
document.getElementById('modalOverlay').addEventListener('click',function(e){if(e.target.id==='modalOverlay')fecharModal();});
document.addEventListener('keydown',function(e){if(e.key==='Escape')fecharModal();});
document.getElementById('qtdMenos').addEventListener('click',function(){qtdPessoas=Math.max(1,qtdPessoas-1);document.getElementById('qtdNum').textContent=qtdPessoas;});
document.getElementById('qtdMais').addEventListener('click',function(){qtdPessoas=Math.min(20,qtdPessoas+1);document.getElementById('qtdNum').textContent=qtdPessoas;});
document.getElementById('btnConfirmarJogar').addEventListener('click',function(){
  limparMsg('modalMsg');
  var esporteId=document.getElementById('modalEsporte').value, dataJogo=document.getElementById('modalData').value, horario=document.getElementById('modalHorario').value, btn=document.getElementById('btnConfirmarJogar');
  if (!dataJogo){mostrarMsg('modalMsg','Escolha uma data.');return;} if (!horario){mostrarMsg('modalMsg','Escolha um horário.');return;}
  btn.disabled=true; btn.textContent='Confirmando...';
  api('presenca.php',{method:'POST',body:JSON.stringify({local_id:localAtual.id,esporte_id:esporteId,qtd_pessoas:qtdPessoas,data_jogo:dataJogo,horario:horario})})
    .then(function(d){fecharModal();mostrarToast(d.mensagem||'Presença confirmada!');carregarDetalhe(localAtual.id);})
    .catch(function(e){mostrarMsg('modalMsg',e.message);})
    .finally(function(){btn.disabled=false;btn.textContent='Confirmar presença';});
});
var id=obterIdDaUrl();
if (!id){window.location.href='index.php';}
else{verificarSessao().then(function(u){renderizarCTA(u);return carregarDetalhe(id);});}
