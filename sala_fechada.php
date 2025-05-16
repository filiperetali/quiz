<!DOCTYPE html>
<html>
<head>
  <title>Sala Fechada</title>
  <link rel="stylesheet" href="estilo/estilo.css">
  <style>
    body {
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: white;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
    }
    .box {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    h1 {
      margin-bottom: 20px;
    }
    a {
      color: #f3f3f3;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>Esta sala já iniciou o jogo!</h1>
    <p>Infelizmente você não pode mais entrar.</p>
    <p><a href="participante.php">Voltar ao início</a></p>
  </div>
</body>
</html>
