<?php
require_once __DIR__ . '/helpers.php';
$id = usuarioLogado();
if (!$id) { responder(['logado' => false]); }
$stmt = $pdo->prepare('SELECT id, nome, email, bairro, cidade, avatar_iniciais FROM usuarios WHERE id = ?');
$stmt->execute([$id]);
$usuario = $stmt->fetch();
if (!$usuario) { responder(['logado' => false]); }
$stmtEsp = $pdo->prepare('SELECT e.id, e.nome, e.emoji FROM esportes e INNER JOIN usuario_esportes ue ON ue.esporte_id = e.id WHERE ue.usuario_id = ?');
$stmtEsp->execute([$id]);
$usuario['esportes'] = $stmtEsp->fetchAll();
responder(['logado' => true, 'usuario' => $usuario]);
