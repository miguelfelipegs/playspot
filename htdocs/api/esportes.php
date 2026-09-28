<?php
require_once __DIR__ . '/helpers.php';
try {
    $stmt = $pdo->query('SELECT id, nome, emoji FROM esportes ORDER BY id ASC');
    responder(['sucesso' => true, 'esportes' => $stmt->fetchAll()]);
} catch (PDOException $e) { erro('Erro: ' . $e->getMessage(), 500); }
