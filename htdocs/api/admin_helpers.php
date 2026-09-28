<?php
require_once __DIR__ . '/helpers.php';
const SENHA_ADMIN_PADRAO = 'playspot2026';
function garantirSenhaAdminExiste(PDO $pdo): void {
    $stmt = $pdo->query('SELECT COUNT(*) AS total FROM admin_config');
    if ((int)$stmt->fetch()['total'] === 0) {
        $hash = password_hash(SENHA_ADMIN_PADRAO, PASSWORD_DEFAULT);
        $pdo->prepare('INSERT INTO admin_config (senha_hash) VALUES (?)')->execute([$hash]);
    }
}
function adminLogado(): bool { return isset($_SESSION['admin']) && $_SESSION['admin'] === true; }
function exigirAdmin(): void { if (!adminLogado()) erro('Acesso restrito.', 401); }
