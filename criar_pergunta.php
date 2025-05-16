<?php
$codigo = $_GET['codigo_sala'] ?? '';
if (!$codigo) {
  die('Código da sala não informado');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Pergunta</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <h1>Adicionar Pergunta à Sala <?php echo htmlspecialchars($codigo); ?></h1>
  <form method="post" action="add_pergunta.php">
    <input type="hidden" name="codigo_sala" value="<?php echo htmlspecialchars($codigo); ?>">

    <label for="pergunta">Pergunta:</label>
    <input type="text" id="pergunta" name="pergunta" required>

    <label>Alternativas:</label>
    <input type="text" name="alternativas[]" placeholder="Alternativa A" required>
    <input type="text" name="alternativas[]" placeholder="Alternativa B" required>
    <input type="text" name="alternativas[]" placeholder="Alternativa C" required>
    <input type="text" name="alternativas[]" placeholder="Alternativa D" required>

    <label for="correta">Índice da alternativa correta (0 a 3):</label>
    <input type="number" id="correta" name="correta" min="0" max="3" required>

    <button type="submit">Adicionar Pergunta</button>
  </form>
</body>
</html>
