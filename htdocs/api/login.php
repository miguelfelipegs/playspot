<?php
require_once __DIR__ . '/helpers.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') erro('Método não permitido.', 405);
$dados = corpoRequisicao();
$email = trim($dados['email'] ?? '');
$senha = $dados['senha'] ?? '';
if ($email === '' || $senha === '') erro('Informe e-mail e senha.');
try {
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) erro('E-mail ou senha incorretos.', 401);
    $_SESSION['usuario_id']   = (int) $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $stmtEsp = $pdo->prepare('SELECT e.id, e.nome, e.emoji FROM esportes e INNER JOIN usuario_esportes ue ON ue.esporte_id = e.id WHERE ue.usuario_id = ?');
    $stmtEsp->execute([$usuario['id']]);
    responder(['sucesso' => true, 'usuario' => [
        'id' => (int)$usuario['id'], 'nome' => $usuario['nome'],
        'email' => $usuario['email'], 'bairro' => $usuario['bairro'],
        'cidade' => $usuario['cidade'], 'avatar_iniciais' => $usuario['avatar_iniciais'],
        'esportes' => $stmtEsp->fetchAll(),
    ]]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
