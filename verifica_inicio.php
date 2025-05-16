<?php
// verifica_inicio.php
include 'db.php';

$pid = $_GET['pid'] ?? 0;

$stmt = $pdo->prepare("SELECT s.status 
                       FROM participantes p 
                       JOIN salas s ON s.id = p.sala_id 
                       WHERE p.id = ?");
$stmt->execute([$pid]);
$sala = $stmt->fetch();

header('Content-Type: application/json');

if ($sala) {
    echo json_encode(['iniciado' => $sala['status'] === 'em_andamento']);
} else {
    echo json_encode(['iniciado' => false]);
}
