<?php
require_once __DIR__ . '/helpers.php';
$esporteId = isset($_GET['esporte']) && $_GET['esporte'] !== '' ? (int)$_GET['esporte'] : null;
$busca     = trim($_GET['busca'] ?? '');
try {
    $sql = 'SELECT l.id, l.nome, l.endereco, l.bairro, l.cidade, l.emoji_capa, l.aberto,
            (SELECT COALESCE(SUM(p.qtd_pessoas),0) FROM presencas p WHERE p.local_id = l.id AND p.data_jogo = CURDATE()) AS jogadores_hoje
            FROM locais l';
    $cond = []; $params = [];
    if ($esporteId) {
        $sql .= ' INNER JOIN local_esportes le ON le.local_id = l.id';
        $cond[] = 'le.esporte_id = ?'; $params[] = $esporteId;
    }
    if ($busca !== '') {
        $cond[] = '(l.nome LIKE ? OR l.bairro LIKE ?)';
        $params[] = "%{$busca}%"; $params[] = "%{$busca}%";
    }
    if ($cond) $sql .= ' WHERE ' . implode(' AND ', $cond);
    $sql .= ' GROUP BY l.id ORDER BY l.nome ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $locais = $stmt->fetchAll();
    $stmtE  = $pdo->prepare('SELECT e.id, e.nome, e.emoji FROM esportes e INNER JOIN local_esportes le ON le.esporte_id = e.id WHERE le.local_id = ?');
    foreach ($locais as &$l) {
        $stmtE->execute([$l['id']]);
        $l['esportes']       = $stmtE->fetchAll();
        $l['jogadores_hoje'] = (int)$l['jogadores_hoje'];
        $l['aberto']         = (bool)$l['aberto'];
    }
    responder(['sucesso' => true, 'locais' => $locais]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
