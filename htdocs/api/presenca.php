<?php
require_once __DIR__ . '/helpers.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') erro('Método não permitido.', 405);
$usuarioId = exigirLogin();
$dados     = corpoRequisicao();
$localId   = (int)($dados['local_id'] ?? 0);
$esporteId = isset($dados['esporte_id']) && $dados['esporte_id'] !== '' ? (int)$dados['esporte_id'] : null;
$qtd       = max(1, min(20, (int)($dados['qtd_pessoas'] ?? 1)));
$dataJogo  = $dados['data_jogo'] ?? date('Y-m-d');
$horario   = trim($dados['horario'] ?? '');
if (!$localId) erro('Informe o local.');
if ($horario !== '' && !preg_match('/^\d{2}:\d{2}$/', $horario)) erro('Horário inválido.');
$horarioSql = $horario !== '' ? $horario . ':00' : null;
try {
    $v = $pdo->prepare('SELECT id FROM locais WHERE id = ?');
    $v->execute([$localId]);
    if (!$v->fetch()) erro('Local não encontrado.', 404);
    $stmt = $pdo->prepare('INSERT INTO presencas (local_id, usuario_id, esporte_id, data_jogo, horario, qtd_pessoas) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$localId, $usuarioId, $esporteId, $dataJogo, $horarioSql, $qtd]);
    $stmtT = $pdo->prepare('SELECT COALESCE(SUM(qtd_pessoas),0) AS total FROM presencas WHERE local_id = ? AND data_jogo = ?');
    $stmtT->execute([$localId, $dataJogo]);
    responder(['sucesso' => true, 'mensagem' => 'Presença confirmada! Bom jogo! 🎉', 'jogadores_hoje' => (int)$stmtT->fetch()['total']], 201);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
