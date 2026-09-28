<?php
require_once __DIR__ . '/helpers.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) erro('Informe o ID do local.');
try {
    $stmt = $pdo->prepare('SELECT * FROM locais WHERE id = ?');
    $stmt->execute([$id]);
    $local = $stmt->fetch();
    if (!$local) erro('Local não encontrado.', 404);

    $stmtE = $pdo->prepare('SELECT e.id, e.nome, e.emoji FROM esportes e INNER JOIN local_esportes le ON le.esporte_id = e.id WHERE le.local_id = ?');
    $stmtE->execute([$id]);
    $local['esportes'] = $stmtE->fetchAll();

    $stmtI = $pdo->prepare('SELECT descricao, disponivel FROM local_infraestrutura WHERE local_id = ? ORDER BY disponivel DESC, id ASC');
    $stmtI->execute([$id]);
    $local['infraestrutura'] = array_map(function($i){ $i['disponivel']=(bool)$i['disponivel']; return $i; }, $stmtI->fetchAll());

    $stmtP = $pdo->prepare('SELECT COUNT(*) AS total, COALESCE(SUM(qtd_pessoas),0) AS pessoas FROM presencas WHERE local_id = ? AND data_jogo = CURDATE()');
    $stmtP->execute([$id]);
    $p = $stmtP->fetch();
    $local['jogadores_hoje']     = (int)$p['pessoas'];
    $local['confirmacoes_hoje']  = (int)$p['total'];
    $local['aberto']             = (bool)$local['aberto'];

    $stmtH = $pdo->prepare('SELECT horario, qtd_pessoas FROM presencas WHERE local_id = ? AND data_jogo = CURDATE() AND horario IS NOT NULL ORDER BY horario ASC');
    $stmtH->execute([$id]);
    $local['horarios_hoje'] = array_map(function($h){ return ['horario'=>substr($h['horario'],0,5),'qtd_pessoas'=>(int)$h['qtd_pessoas']]; }, $stmtH->fetchAll());

    responder(['sucesso' => true, 'local' => $local]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
