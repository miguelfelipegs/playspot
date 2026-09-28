<?php
require_once __DIR__ . '/helpers.php';
$usuarioId = exigirLogin();
try {
    $stmt = $pdo->prepare('SELECT p.data_jogo, p.horario, p.qtd_pessoas, l.nome AS local_nome FROM presencas p INNER JOIN locais l ON l.id = p.local_id WHERE p.usuario_id = ? ORDER BY p.data_jogo DESC, p.criado_em DESC LIMIT 5');
    $stmt->execute([$usuarioId]);
    $presencas = $stmt->fetchAll();
    foreach ($presencas as &$p) {
        $p['qtd_pessoas'] = (int)$p['qtd_pessoas'];
        if ($p['horario']) $p['horario'] = substr($p['horario'], 0, 5);
    }
    responder(['sucesso' => true, 'presencas' => $presencas]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
