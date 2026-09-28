<?php
require_once __DIR__ . '/admin_helpers.php';
exigirAdmin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') erro('Método não permitido.', 405);
$dados     = corpoRequisicao();
$senhaAtual = $dados['senha_atual'] ?? '';
$senhaNova  = $dados['senha_nova']  ?? '';
if (strlen($senhaNova) < 6) erro('A nova senha deve ter pelo menos 6 caracteres.');
try {
    $config = $pdo->query('SELECT id, senha_hash FROM admin_config ORDER BY id DESC LIMIT 1')->fetch();
    if (!$config || !password_verify($senhaAtual, $config['senha_hash'])) erro('Senha atual incorreta.', 401);
    $pdo->prepare('UPDATE admin_config SET senha_hash = ? WHERE id = ?')->execute([password_hash($senhaNova, PASSWORD_DEFAULT), $config['id']]);
    responder(['sucesso' => true, 'mensagem' => 'Senha atualizada com sucesso.']);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
