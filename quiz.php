<?php
// quiz.php
include 'db.php';
$pid = $_GET['pid'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM participantes WHERE id = ?");
$stmt->execute([$pid]);
$participante = $stmt->fetch();

if (!$participante) die("Participante não encontrado");

$stmt = $pdo->prepare("SELECT * FROM perguntas WHERE sala_id = ? AND id NOT IN (SELECT pergunta_id FROM respostas WHERE participante_id = ?) LIMIT 1");
$stmt->execute([$participante['sala_id'], $pid]);
$pergunta = $stmt->fetch();

if (!$pergunta) {
  // Buscar o código da sala com base no ID da sala
  $stmt = $pdo->prepare("SELECT codigo_sala FROM salas WHERE id = ?");
  $stmt->execute([$participante['sala_id']]);
  $sala = $stmt->fetch();

  $codigo = $sala['codigo_sala'] ?? '';

echo "<!DOCTYPE html>";
echo "<html lang='pt-BR'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Quiz</title>";
echo "<link rel='stylesheet' href='estilo/estilo.css'>";
echo "</head>";
echo "<body>";
  echo "<div class='container agradecimento'>";
  echo "<h1>Obrigado por participar!</h1>";
  echo "<a href='ranking.php?codigo={$codigo}' class='botao-voltar'>Ver Ranking</a>";
  echo "</div>";

  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $resposta = $_POST['resposta'];
  $inicio = $_POST['inicio'];
  $tempo = time() - $inicio;
  $correta = strtoupper($resposta) === strtoupper($pergunta['correta']);

  $stmt = $pdo->prepare("INSERT INTO respostas (participante_id, pergunta_id, resposta, tempo_resposta, correta) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$pid, $pergunta['id'], $resposta, $tempo, $correta]);

  header("Location: quiz.php?pid=$pid");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz</title>
  <link rel="stylesheet" href="estilo/estilo.css">
</head>
<body>
  <div class="quiz-container">
    <h2 class="pergunta-titulo"><?php echo $pergunta['pergunta']; ?></h2>
    <form method="POST" class="quiz-form">
      <input type="hidden" name="inicio" value="<?php echo time(); ?>">
      <div class="alternativas">
        <label class="alternativa">
          <input type="radio" name="resposta" value="A">
          <?php echo $pergunta['alternativa_a']; ?>
        </label>
        <label class="alternativa">
          <input type="radio" name="resposta" value="B">
          <?php echo $pergunta['alternativa_b']; ?>
        </label>
        <label class="alternativa">
          <input type="radio" name="resposta" value="C">
          <?php echo $pergunta['alternativa_c']; ?>
        </label>
        <label class="alternativa">
          <input type="radio" name="resposta" value="D">
          <?php echo $pergunta['alternativa_d']; ?>
        </label>
      </div>
      <button type="submit" class="botao">Enviar</button>
    </form>
  </div>
</body>
</html>
