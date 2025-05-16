<?php
// ranking_dados.php
include 'db.php';

$codigo = $_GET['codigo'] ?? '';

$stmt = $pdo->prepare("SELECT id FROM salas WHERE codigo_sala = ?");
$stmt->execute([$codigo]);
$sala = $stmt->fetch();

if (!$sala) {
  echo "<tr><td colspan='3'>Sala inválida</td></tr>";
  exit;
}

$stmt = $pdo->prepare("
  SELECT p.nome, COUNT(r.correta) AS acertos, SUM(r.tempo_resposta) AS tempo
  FROM participantes p
  LEFT JOIN respostas r ON r.participante_id = p.id AND r.correta = 1
  WHERE p.sala_id = ?
  GROUP BY p.id
  ORDER BY acertos DESC, tempo ASC
");
$stmt->execute([$sala['id']]);

while ($linha = $stmt->fetch()) {
  echo "<tr>";
  echo "<td>{$linha['nome']}</td>";
  echo "<td>{$linha['acertos']}</td>";
  echo "<td>{$linha['tempo']}s</td>";
  echo "</tr>";
}
// echo "chamou";