<?php
include 'db.php';

$codigo = $_GET['codigo'] ?? '';

$stmt = $pdo->prepare("
    SELECT p.nome 
    FROM participantes p
    JOIN salas s ON p.sala_id = s.id
    WHERE s.codigo_sala = ?
");
$stmt->execute([$codigo]);

$participantes = $stmt->fetchAll();

foreach ($participantes as $p) {
    // echo "<h2>" . htmlspecialchars($p['nome']) . "</h2>";
    echo '<div class="nome-participante">👤 Participante: <span>' . htmlspecialchars($p['nome']) . '</span></div>';

}
?>
