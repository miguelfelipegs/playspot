<?php
require_once __DIR__ . '/admin_helpers.php';
exigirAdmin();
try {
    $totalLocais   = (int)$pdo->query('SELECT COUNT(*) AS t FROM locais')->fetch()['t'];
    $totalUsuarios = (int)$pdo->query('SELECT COUNT(*) AS t FROM usuarios')->fetch()['t'];
    $totalAbertos  = (int)$pdo->query('SELECT COUNT(*) AS t FROM locais WHERE aberto = 1')->fetch()['t'];
    $presencasHoje = (int)$pdo->query('SELECT COALESCE(SUM(qtd_pessoas),0) AS t FROM presencas WHERE data_jogo = CURDATE()')->fetch()['t'];
    $maisAtivos    = $pdo->query('SELECT l.id, l.nome, l.bairro, COUNT(p.id) AS total_presencas FROM locais l LEFT JOIN presencas p ON p.local_id = l.id GROUP BY l.id ORDER BY total_presencas DESC LIMIT 5')->fetchAll();
    responder(['sucesso' => true, 'stats' => ['total_locais'=>$totalLocais,'total_usuarios'=>$totalUsuarios,'total_abertos'=>$totalAbertos,'presencas_hoje'=>$presencasHoje,'mais_ativos'=>$maisAtivos]]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
