function preencherPerfil(u) {
  document.getElementById('perfilAvatar').textContent = u.avatar_iniciais||'??';
  document.getElementById('perfilNome').textContent   = u.nome;
  document.getElementById('perfilEmail').textContent  = u.email;
  if (u.bairro) { document.getElementById('perfilBairro').textContent=u.bairro+', '+(u.cidade||'Contagem, MG'); document.getElementById('perfilBairroBlock').style.display='block'; }
  var esp=u.esportes||[];
  if (esp.length>0) { document.getElementById('perfilEsportesTags').innerHTML=esp.map(function(e){return '<span class="spot-tag">'+e.emoji+' '+e.nome+'</span>';}).join(''); document.getElementById('perfilEsportesBlock').style.display='block'; }
}
function carregarPresencas() {
  api('perfil_presencas.php').then(function(d){
    var lista=d.presencas||[]; if(!lista.length)return;
    document.getElementById('perfilPresencasList').innerHTML=lista.map(function(p){
      var data=new Date(p.data_jogo+'T00:00:00').toLocaleDateString('pt-BR'), h=p.horario?' às '+p.horario:'', pes=p.qtd_pessoas==1?'1 pessoa':p.qtd_pessoas+' pessoas';
      return '<div class="infra-item" style="flex-direction:column;align-items:flex-start;gap:2px;"><strong style="color:var(--white);font-size:0.88rem;">'+p.local_nome+'</strong><span style="font-size:0.75rem;color:var(--muted);">'+data+h+' — '+pes+'</span></div>';
    }).join('');
    document.getElementById('perfilPresencasBlock').style.display='block';
  }).catch(function(){});
}
document.getElementById('btnLogout').addEventListener('click',function(){
  api('logout.php',{method:'POST'}).catch(function(){}).then(function(){window.location.href='index.php';});
});
exigirSessao().then(function(u){ if(!u)return; preencherPerfil(u); carregarPresencas(); });
