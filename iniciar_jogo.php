<?php
// iniciar_jogo.php
include 'db.php';

$codigo = $_GET['codigo_sala'] ?? '';

if (!$codigo) {
    die('Código da sala não informado.');
}

// Verifica se sala existe
$stmt = $pdo->prepare("SELECT * FROM salas WHERE codigo_sala = ?");
$stmt->execute([$codigo]);
$sala = $stmt->fetch();

if (!$sala) {
    die('Sala não encontrada.');
}

// Atualiza o status da sala E marca como jogo iniciado
$stmt = $pdo->prepare("UPDATE salas SET status = 'em_andamento', jogo_iniciado = 1 WHERE codigo_sala = ?");
$stmt->execute([$codigo]);

echo "<script>
    alert('Jogo iniciado! Participantes receberão as perguntas.');
    window.location.href = 'ranking.php?codigo={$codigo}';
</script>";
?>
