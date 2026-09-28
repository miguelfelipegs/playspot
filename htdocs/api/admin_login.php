<?php
require_once __DIR__ . '/admin_helpers.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') erro('Método não permitido.', 405);
garantirSenhaAdminExiste($pdo);
$dados = corpoRequisicao();
$senha = $dados['senha'] ?? '';
if ($senha === '') erro('Informe a senha.');
try {
    $config = $pdo->query('SELECT senha_hash FROM admin_config ORDER BY id DESC LIMIT 1')->fetch();
    if (!$config || !password_verify($senha, $config['senha_hash'])) erro('Senha incorreta.', 401);
    $_SESSION['admin'] = true;
    responder(['sucesso' => true]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
