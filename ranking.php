<?php
// ranking.php
include 'db.php';

$codigo = $_GET['codigo'] ?? '';

$stmt = $pdo->prepare("SELECT id FROM salas WHERE codigo_sala = ?");
$stmt->execute([$codigo]);
$sala = $stmt->fetch();

if (!$sala) die("Sala inválida");

$stmt = $pdo->prepare("
  SELECT p.nome, COUNT(r.correta) AS acertos, SUM(r.tempo_resposta) AS tempo
  FROM participantes p
  LEFT JOIN respostas r ON r.participante_id = p.id AND r.correta = 1
  WHERE p.sala_id = ?
  GROUP BY p.id
  ORDER BY acertos DESC, tempo ASC
");
$stmt->execute([$sala['id']]);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Quiz Game - Ranking</title>
  <link rel="stylesheet" href="estilo/estilo.css">
  <script>
    function atualizarRanking() {
      fetch('ranking_dados.php?codigo=<?php echo urlencode($codigo); ?>')
        .then(response => response.text())
        .then(html => {
          document.getElementById('tabela-ranking').innerHTML = html;
        })
        .catch(error => console.error('Erro ao atualizar ranking:', error));
    }

    setInterval(atualizarRanking, 5000); // Atualiza a cada 5 segundos
    window.onload = atualizarRanking; // Atualiza logo ao carregar a página
  </script>
</head>
<body>
  <div class="container">
    <h1>Ranking</h1>
    <table class="ranking-table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Acertos</th>
          <th>Tempo</th>
        </tr>
      </thead>
      <tbody id="tabela-ranking">
        <tr><td colspan="3">Carregando...</td></tr>
      </tbody>
    </table>
  </div>
</body>

</html>

