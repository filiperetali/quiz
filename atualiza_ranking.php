<?php
include 'db.php';
$codigo = $_GET['codigo'] ?? '';

$stmt = $pdo->prepare("SELECT id FROM salas WHERE codigo_sala = ?");
$stmt->execute([$codigo]);
$sala = $stmt->fetch();

if (!$sala) die();

$stmt = $pdo->query("SELECT p.nome, COUNT(r.correta) AS acertos, SUM(r.tempo_resposta) AS tempo
  FROM participantes p
  LEFT JOIN respostas r ON r.participante_id = p.id AND r.correta = 1
  WHERE p.sala_id = {$sala['id']}
  GROUP BY p.id
  ORDER BY acertos DESC, tempo ASC");

while ($linha = $stmt->fetch()) {
  echo "<tr><td>{$linha['nome']}</td><td>{$linha['acertos']}</td><td>{$linha['tempo']}s</td></tr>";
}
?>
