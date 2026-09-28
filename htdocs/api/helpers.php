<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/db.php';

function responder($dados, int $status = 200): void {
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}
function erro(string $mensagem, int $status = 400): void {
    responder(['sucesso' => false, 'erro' => $mensagem], $status);
}
function corpoRequisicao(): array {
    $json = json_decode(file_get_contents('php://input'), true);
    return is_array($json) ? $json : [];
}
function usuarioLogado(): ?int { return $_SESSION['usuario_id'] ?? null; }
function exigirLogin(): int {
    $id = usuarioLogado();
    if (!$id) erro('Você precisa estar logado.', 401);
    return $id;
}
function gerarIniciais(string $nome): string {
    $partes = preg_split('/\s+/', trim($nome));
    $iniciais = '';
    foreach (array_slice($partes, 0, 2) as $p)
        if ($p !== '') $iniciais .= mb_strtoupper(mb_substr($p, 0, 1));
    return $iniciais !== '' ? $iniciais : '??';
}
