<?php
// aguardando.php
$pid = $_GET['pid'] ?? 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aguardando Início</title>
  <link rel="stylesheet" href="estilo/estilo.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #e0eafc, #cfdef3);
      margin: 0;
      padding: 30px;
      text-align: center;
      color: #333;
    }

    h1 {
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 30px;
      letter-spacing: 1px;
    }

    #loading-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 300px;
    }

    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #6c63ff;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    p {
      font-size: 1.1rem;
      color: #574b90;
      margin-top: 20px;
    }

    a {
      text-decoration: none;
      color: #6c63ff;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    a:hover {
      color: #574b90;
    }
  </style>
</head>
<body style="display:flex; flex-direction: column;">
  <h1>Aguardando o jogo começar...</h1>

  <div id="loading-container">
    <div class="loader"></div>
  </div>

  <p>Estamos preparando o seu quiz. Isso pode levar alguns segundos...</p>

  <script>
    const pid = <?php echo json_encode($pid); ?>;

    setInterval(() => {
      console.log('verificando status da sala...');
      console.log(pid)

      fetch(`verifica_inicio.php?pid=${pid}`)
        .then(response => response.json())
        .then(data => {
          if (data.iniciado) {
            alert("Data.iniciado")
            window.location.href = `quiz.php?pid=${pid}`;
          }
        })
        .catch(error => console.error('Erro ao verificar início:', error));
    }, 2000);
  </script>
</body>
</html>
