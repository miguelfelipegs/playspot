var API='api', esportesCatalogo=[], infraIdSeq=0;
function api(endpoint,options){options=options||{};return fetch(API+'/'+endpoint,Object.assign({headers:{'Content-Type':'application/json'},credentials:'same-origin'},options)).then(function(res){return res.json().catch(function(){return{};}).then(function(d){if(!res.ok)throw new Error(d.erro||'Erro.');return d;});});}
function mostrarMsg(id,txt,tipo){var el=document.getElementById(id);if(!el)return;el.textContent=txt;el.className='form-msg show '+(tipo||'error');}
function limparMsg(id){var el=document.getElementById(id);if(el)el.className='form-msg';}
async function verificarSessaoAdmin(){try{var d=await api('admin_sessao.php');if(d.logado)mostrarShell();else document.getElementById('adminLoginWrap').style.display='flex';}catch(e){document.getElementById('adminLoginWrap').style.display='flex';}}
function mostrarShell(){document.getElementById('adminLoginWrap').style.display='none';document.getElementById('adminShell').classList.add('active');carregarDashboard();carregarLocaisTabela();}
document.getElementById('btnAdminLogin').addEventListener('click',async function(){
  limparMsg('loginMsg');var senha=document.getElementById('adminSenha').value;if(!senha){mostrarMsg('loginMsg','Informe a senha.');return;}
  try{await api('admin_login.php',{method:'POST',body:JSON.stringify({senha:senha})});document.getElementById('adminSenha').value='';mostrarShell();}catch(e){mostrarMsg('loginMsg',e.message);}
});
document.getElementById('adminSenha').addEventListener('keydown',function(e){if(e.key==='Enter')document.getElementById('btnAdminLogin').click();});
document.getElementById('btnAdminSair').addEventListener('click',async function(){await api('admin_logout.php',{method:'POST'});document.getElementById('adminShell').classList.remove('active');document.getElementById('adminLoginWrap').style.display='flex';});
var titulos={dashboard:['Dashboard','Visão geral da plataforma'],locais:['Locais','Gerencie os espaços esportivos'],config:['Configurações','Segurança do painel']};
document.querySelectorAll('.admin-nav-item[data-page]').forEach(function(btn){
  btn.addEventListener('click',function(){
    var page=btn.dataset.page;
    document.querySelectorAll('.admin-nav-item[data-page]').forEach(function(b){b.classList.remove('active');});
    btn.classList.add('active');
    document.querySelectorAll('.admin-page').forEach(function(p){p.style.display='none';});
    document.getElementById('page-'+page).style.display='block';
    document.getElementById('pageTitle').textContent=titulos[page][0];
    document.getElementById('pageSub').textContent=titulos[page][1];
    document.getElementById('adminSidebar').classList.remove('open');
    if(page==='dashboard')carregarDashboard();
    if(page==='locais')carregarLocaisTabela();
  });
});
document.getElementById('menuToggle').addEventListener('click',function(){document.getElementById('adminSidebar').classList.toggle('open');});
async function carregarDashboard(){
  try{var d=await api('admin_stats.php'),s=d.stats;
    document.getElementById('statLocais').textContent=s.total_locais;
    document.getElementById('statAbertos').textContent=s.total_abertos;
    document.getElementById('statUsuarios').textContent=s.total_usuarios;
    document.getElementById('statPresencas').textContent=s.presencas_hoje;
    document.getElementById('rankAtivos').innerHTML=s.mais_ativos.length?s.mais_ativos.map(function(l){return'<div class="rank-row"><div><div class="rank-name">'+l.nome+'</div><div class="rank-sub">'+(l.bairro||'—')+'</div></div><div class="rank-count">'+l.total_presencas+'</div></div>';}).join(''):'<div class="rank-row"><span class="rank-sub">Nenhuma confirmação ainda.</span></div>';
  }catch(e){console.error(e);}
}
async function carregarLocaisTabela(){
  var tbody=document.getElementById('tabelaLocais');
  try{var d=await api('admin_locais.php');
    if(!d.locais.length){tbody.innerHTML='<tr class="empty-row"><td colspan="6">Nenhum local cadastrado.</td></tr>';return;}
    tbody.innerHTML=d.locais.map(function(l){
      return'<tr><td><div class="loc-nome-cell"><div class="loc-emoji-mini">'+(l.emoji_capa||'🏟')+'</div>'+l.nome+'</div></td>'
        +'<td>'+(l.bairro||'—')+'</td>'
        +'<td>'+l.esportes.map(function(e){return'<span class="tag-mini">'+e.emoji+' '+e.nome+'</span>';}).join('')+'</td>'
        +'<td><span class="status-pill '+(l.aberto?'aberto':'fechado')+'">'+(l.aberto?'Aberto':'Fechado')+'</span></td>'
        +'<td>'+l.jogadores_hoje+'</td>'
        +'<td><div class="row-actions">'
        +'<div class="icon-btn" onclick="editarLocal('+l.id+')" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div>'
        +'<div class="icon-btn danger" onclick="excluirLocal('+l.id+',\''+l.nome.replace(/'/g,"\\'")+'\')" title="Excluir"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg></div>'
        +'</div></td></tr>';
    }).join('');
  }catch(e){tbody.innerHTML='<tr class="empty-row"><td colspan="6">'+e.message+'</td></tr>';}
}
async function garantirCatalogo(){if(!esportesCatalogo.length){var d=await api('esportes.php');esportesCatalogo=d.esportes;}}
function novaLinhaInfra(desc,disp){
  var id='infra-'+(infraIdSeq++),row=document.createElement('div');
  row.className='infra-row';
  row.innerHTML='<input type="checkbox"'+(disp?' checked':'')+'><input type="text" class="input-field" placeholder="Ex: Iluminação noturna" value="'+((desc||'').replace(/"/g,'&quot;'))+'"><div class="icon-btn danger"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>';
  row.querySelector('.icon-btn').addEventListener('click',function(){row.remove();});
  return row;
}
document.getElementById('btnAddInfra').addEventListener('click',function(){document.getElementById('fInfraRows').appendChild(novaLinhaInfra('',true));});
async function abrirModalLocal(local){
  await garantirCatalogo(); limparMsg('modalLocalMsg');
  document.getElementById('modalLocalTitulo').textContent=local?'Editar local':'Novo local';
  document.getElementById('fLocalId').value=local?local.id:'';
  document.getElementById('fNome').value=local?local.nome:'';
  document.getElementById('fEmoji').value=local?local.emoji_capa:'🏟';
  document.getElementById('fEndereco').value=local?(local.endereco||''):'';
  document.getElementById('fBairro').value=local?(local.bairro||''):'';
  document.getElementById('fCidade').value=local?local.cidade:'Contagem, MG';
  document.getElementById('fLatitude').value=local?(local.latitude||''):'';
  document.getElementById('fLongitude').value=local?(local.longitude||''):'';
  document.getElementById('fAberto').checked=local?!!local.aberto:true;
  document.getElementById('fEsportes').innerHTML=esportesCatalogo.map(function(e){return'<div class="chip'+(local&&local.esportes.indexOf(e.id)!==-1?' active':'')+'" data-id="'+e.id+'">'+e.emoji+' '+e.nome+'</div>';}).join('');
  document.querySelectorAll('#fEsportes .chip').forEach(function(c){c.addEventListener('click',function(){c.classList.toggle('active');});});
  var ic=document.getElementById('fInfraRows');ic.innerHTML='';
  if(local&&local.infraestrutura.length){local.infraestrutura.forEach(function(i){ic.appendChild(novaLinhaInfra(i.descricao,!!i.disponivel));});}
  else{ic.appendChild(novaLinhaInfra('',true));}
  document.getElementById('modalLocal').classList.add('open');
}
function fecharModalLocal(){document.getElementById('modalLocal').classList.remove('open');}
document.getElementById('btnNovoLocal').addEventListener('click',function(){abrirModalLocal(null);});
document.getElementById('btnFecharModalLocal').addEventListener('click',fecharModalLocal);
document.getElementById('btnCancelarLocal').addEventListener('click',fecharModalLocal);
document.getElementById('modalLocal').addEventListener('click',function(e){if(e.target.id==='modalLocal')fecharModalLocal();});
async function editarLocal(id){try{var d=await api('admin_locais.php?id='+id);abrirModalLocal(d.local);}catch(e){alert(e.message);}}
async function excluirLocal(id,nome){
  if(!confirm('Excluir "'+nome+'"? Esta ação não pode ser desfeita.'))return;
  try{await api('admin_locais.php?id='+id,{method:'DELETE'});carregarLocaisTabela();carregarDashboard();}catch(e){alert(e.message);}
}
document.getElementById('btnSalvarLocal').addEventListener('click',async function(){
  limparMsg('modalLocalMsg');
  var id=document.getElementById('fLocalId').value;
  var nome=document.getElementById('fNome').value.trim();
  if(!nome){mostrarMsg('modalLocalMsg','O nome é obrigatório.');return;}
  var latR=document.getElementById('fLatitude').value.trim(), lngR=document.getElementById('fLongitude').value.trim();
  var lat=latR!==''?parseFloat(latR.replace(',','.')):null, lng=lngR!==''?parseFloat(lngR.replace(',','.')):null;
  if(latR!==''&&isNaN(lat)){mostrarMsg('modalLocalMsg','Latitude inválida.');return;}
  var esportes=Array.from(document.querySelectorAll('#fEsportes .chip.active')).map(function(c){return parseInt(c.dataset.id);});
  var infra=Array.from(document.querySelectorAll('#fInfraRows .infra-row')).map(function(r){return{descricao:r.querySelector('input[type="text"]').value.trim(),disponivel:r.querySelector('input[type="checkbox"]').checked};}).filter(function(i){return i.descricao!=='';});
  var payload={nome:nome,emoji_capa:document.getElementById('fEmoji').value.trim()||'🏟',endereco:document.getElementById('fEndereco').value.trim(),bairro:document.getElementById('fBairro').value.trim(),cidade:document.getElementById('fCidade').value.trim(),latitude:lat,longitude:lng,aberto:document.getElementById('fAberto').checked,esportes:esportes,infraestrutura:infra};
  var btn=document.getElementById('btnSalvarLocal');btn.disabled=true;btn.textContent='Salvando...';
  try{
    if(id){await api('admin_locais.php?id='+id,{method:'PUT',body:JSON.stringify(payload)});}
    else{await api('admin_locais.php',{method:'POST',body:JSON.stringify(payload)});}
    fecharModalLocal();carregarLocaisTabela();carregarDashboard();
  }catch(e){mostrarMsg('modalLocalMsg',e.message);}
  finally{btn.disabled=false;btn.textContent='Salvar local';}
});
document.getElementById('btnTrocarSenha').addEventListener('click',async function(){
  limparMsg('senhaMsg');
  var sa=document.getElementById('senhaAtual').value,sn=document.getElementById('senhaNova').value;
  if(!sa||!sn){mostrarMsg('senhaMsg','Preencha os dois campos.');return;}
  try{var d=await api('admin_trocar_senha.php',{method:'POST',body:JSON.stringify({senha_atual:sa,senha_nova:sn})});mostrarMsg('senhaMsg',d.mensagem,'success');document.getElementById('senhaAtual').value='';document.getElementById('senhaNova').value='';}
  catch(e){mostrarMsg('senhaMsg',e.message);}
});
verificarSessaoAdmin();
