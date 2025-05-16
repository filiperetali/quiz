<?php
// criar_sala.php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
  $stmt = $pdo->prepare("INSERT INTO salas (codigo_sala) VALUES (?)");
  $stmt->execute([$codigo]);
  $sala_id = $pdo->lastInsertId();
  // echo($codigo);
  header("Location: sala.php?codigo=$codigo");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Criar Sala</title>
  <link rel="stylesheet" href="estilo/estilo.css">
</head>
<body>
  <div class="container">
    <h1>🔐 Criar Nova Sala</h1>
    <form method="POST">
      <button type="submit" class="botao">Gerar Sala</button>
    </form>
    <a href="index.php" class="botao-voltar">← Voltar à Página Inicial</a>
  </div>
</body>
</html>
