<?php
require_once __DIR__ . '/admin_helpers.php';
exigirAdmin();
$metodo = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int)$_GET['id'] : null;
try {
    if ($metodo === 'GET' && $id) {
        $stmt = $pdo->prepare('SELECT * FROM locais WHERE id = ?');
        $stmt->execute([$id]); $local = $stmt->fetch();
        if (!$local) erro('Local não encontrado.', 404);
        $stmtE = $pdo->prepare('SELECT esporte_id FROM local_esportes WHERE local_id = ?');
        $stmtE->execute([$id]); $local['esportes'] = array_map('intval', array_column($stmtE->fetchAll(), 'esporte_id'));
        $stmtI = $pdo->prepare('SELECT id, descricao, disponivel FROM local_infraestrutura WHERE local_id = ? ORDER BY id ASC');
        $stmtI->execute([$id]); $local['infraestrutura'] = $stmtI->fetchAll();
        $local['aberto'] = (bool)$local['aberto'];
        responder(['sucesso' => true, 'local' => $local]);
    }
    if ($metodo === 'GET') {
        $stmt = $pdo->query('SELECT l.*, (SELECT COALESCE(SUM(qtd_pessoas),0) FROM presencas p WHERE p.local_id = l.id AND p.data_jogo = CURDATE()) AS jogadores_hoje FROM locais l ORDER BY l.nome ASC');
        $locais = $stmt->fetchAll();
        $stmtE  = $pdo->prepare('SELECT e.nome, e.emoji FROM esportes e INNER JOIN local_esportes le ON le.esporte_id = e.id WHERE le.local_id = ?');
        foreach ($locais as &$l) {
            $stmtE->execute([$l['id']]); $l['esportes'] = $stmtE->fetchAll();
            $l['aberto'] = (bool)$l['aberto']; $l['jogadores_hoje'] = (int)$l['jogadores_hoje'];
        }
        responder(['sucesso' => true, 'locais' => $locais]);
    }
    if ($metodo === 'POST')   { $dados = corpoRequisicao(); salvarLocal($pdo, null, $dados); }
    if ($metodo === 'PUT')    { if (!$id) erro('Informe o ID.'); $dados = corpoRequisicao(); salvarLocal($pdo, $id, $dados); }
    if ($metodo === 'DELETE') { if (!$id) erro('Informe o ID.'); $pdo->prepare('DELETE FROM locais WHERE id = ?')->execute([$id]); responder(['sucesso' => true]); }
    erro('Método não permitido.', 405);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }

function salvarLocal(PDO $pdo, ?int $id, array $dados): void {
    $nome      = trim($dados['nome'] ?? '');
    $endereco  = trim($dados['endereco'] ?? '');
    $bairro    = trim($dados['bairro'] ?? '');
    $cidade    = trim($dados['cidade'] ?? 'Contagem, MG');
    $emoji     = trim($dados['emoji_capa'] ?? '🏟');
    $aberto    = !empty($dados['aberto']) ? 1 : 0;
    $lat       = isset($dados['latitude'])  && $dados['latitude']  !== null && $dados['latitude']  !== '' ? (float)$dados['latitude']  : null;
    $lng       = isset($dados['longitude']) && $dados['longitude'] !== null && $dados['longitude'] !== '' ? (float)$dados['longitude'] : null;
    $esportes  = $dados['esportes'] ?? [];
    $infra     = $dados['infraestrutura'] ?? [];
    if ($nome === '') erro('O nome do local é obrigatório.');
    $pdo->beginTransaction();
    if ($id === null) {
        $pdo->prepare('INSERT INTO locais (nome,endereco,bairro,cidade,latitude,longitude,emoji_capa,aberto) VALUES (?,?,?,?,?,?,?,?)')->execute([$nome,$endereco,$bairro,$cidade,$lat,$lng,$emoji,$aberto]);
        $id = (int)$pdo->lastInsertId();
    } else {
        $pdo->prepare('UPDATE locais SET nome=?,endereco=?,bairro=?,cidade=?,latitude=?,longitude=?,emoji_capa=?,aberto=? WHERE id=?')->execute([$nome,$endereco,$bairro,$cidade,$lat,$lng,$emoji,$aberto,$id]);
    }
    $pdo->prepare('DELETE FROM local_esportes WHERE local_id = ?')->execute([$id]);
    if (count($esportes) > 0) {
        $stmtE = $pdo->prepare('INSERT INTO local_esportes (local_id, esporte_id) VALUES (?,?)');
        foreach ($esportes as $eid) $stmtE->execute([$id,(int)$eid]);
    }
    $pdo->prepare('DELETE FROM local_infraestrutura WHERE local_id = ?')->execute([$id]);
    if (count($infra) > 0) {
        $stmtI = $pdo->prepare('INSERT INTO local_infraestrutura (local_id,descricao,disponivel) VALUES (?,?,?)');
        foreach ($infra as $item) { $desc = trim($item['descricao'] ?? ''); if ($desc==='') continue; $stmtI->execute([$id,$desc,!empty($item['disponivel'])?1:0]); }
    }
    $pdo->commit();
    responder(['sucesso' => true, 'id' => $id], 201);
}
