<?php
// participante.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codigo = trim($_POST['codigo'] ?? '');
  $nome = trim($_POST['nome'] ?? '');

  $stmt = $pdo->prepare("SELECT * FROM salas WHERE codigo_sala = ?");
  $stmt->execute([$codigo]);
  $sala = $stmt->fetch();

  if ($sala) {
    // Verifica se o jogo já foi iniciado
    if ($sala['jogo_iniciado']) {
      header("Location: sala_fechada.php");
      exit;
    }

    // Insere o participante
    $stmt = $pdo->prepare("INSERT INTO participantes (sala_id, nome) VALUES (?, ?)");
    $stmt->execute([$sala['id'], $nome]);
    header("Location: aguardando.php?pid=" . $pdo->lastInsertId());
    exit;
  } else {
    $erro = "Código da sala inválido.";
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Entrar como Participante</title>
  <link rel="stylesheet" href="estilo/estilo.css">
</head>
<body style="display: flex;flex-direction:column;">
  <h1>🎮 Entrar na Sala</h1>

  <div class="card">
    <form method="POST">
      <div class="campo">
        <label for="codigo">Código da Sala</label>
        <input type="text" id="codigo" name="codigo" placeholder="Digite o código da sala" required>
      </div>

      <div class="campo">
        <label for="nome">Seu Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
      </div>

      <button type="submit" class="botao">Entrar</button>
    </form>
  </div>
</body>
</html>

