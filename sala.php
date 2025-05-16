<?php
// sala.php
include 'db.php';
include 'topo.php';

$codigo = $_GET['codigo'] ?? '';

// Buscar sala pelo código
$stmt = $pdo->prepare("SELECT * FROM salas WHERE codigo_sala = ?");
$stmt->execute([$codigo]);
$sala = $stmt->fetch();

if (!$sala) die("Sala não encontrada");

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pergunta = trim($_POST['pergunta'] ?? '');
    $a = trim($_POST['a'] ?? '');
    $b = trim($_POST['b'] ?? '');
    $c = trim($_POST['c'] ?? '');
    $d = trim($_POST['d'] ?? '');
    $correta = strtoupper(trim($_POST['correta'] ?? ''));

    if ($pergunta && in_array($correta, ['A', 'B', 'C', 'D'])) {
        $stmt = $pdo->prepare("INSERT INTO perguntas (sala_id, pergunta, alternativa_a, alternativa_b, alternativa_c, alternativa_d, correta)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$sala['id'], $pergunta, $a, $b, $c, $d, $correta]);

        $mensagem = "Pergunta adicionada com sucesso!";
    } else {
        $mensagem = "Preencha a pergunta e escolha a alternativa correta (A/B/C/D).";
    }
}

// Importação via CSV
if (isset($_POST['importar']) && isset($_FILES['arquivo_csv'])) {
    $arquivoTmp = $_FILES['arquivo_csv']['tmp_name'];
    
    if (($handle = fopen($arquivoTmp, 'r')) !== false) {
        // Ignorar cabeçalho
        fgetcsv($handle, 1000, ',');

        $importadas = 0;
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $pergunta = trim($data[0] ?? '');
            $a = trim($data[1] ?? '');
            $b = trim($data[2] ?? '');
            $c = trim($data[3] ?? '');
            $d = trim($data[4] ?? '');
            $correta = strtoupper(trim($data[5] ?? ''));

            if ($pergunta && in_array($correta, ['A', 'B', 'C', 'D'])) {
                $stmt = $pdo->prepare("INSERT INTO perguntas (sala_id, pergunta, alternativa_a, alternativa_b, alternativa_c, alternativa_d, correta)
                                       VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$sala['id'], $pergunta, $a, $b, $c, $d, $correta]);
                $importadas++;
            }
        }
        fclose($handle);

        $mensagem = "$importadas perguntas importadas com sucesso.";
    } else {
        $mensagem = "Erro ao abrir o arquivo.";
    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sala <?php echo htmlspecialchars($codigo); ?></title>
    <link rel="stylesheet" href="estilo/estilo.css">
</head>
<body class="tela">
    <div class="container">
        <h1>🎮 Sala: <?php echo htmlspecialchars($codigo); ?></h1>

        <section>
            <h2>📁 Importar perguntas via CSV</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="arquivo_csv" accept=".csv" required>
                <button type="submit" name="importar" class="botao">Importar CSV</button>
            </form>
        </section>

        <?php if (isset($mensagem)) echo "<p><strong>$mensagem</strong></p>"; ?>

        <section>
        <section>
        <section>
    <h2>➕ Adicionar pergunta manualmente</h2>
    <form method="POST" class="pergunta-form">
        <div class="campo">
            <label for="pergunta">Pergunta</label>
            <input type="text" id="pergunta" name="pergunta" placeholder="Digite a pergunta" required>
        </div>

        <div class="alternativas">
            <div class="campo">
                <label for="a">Alternativa A</label>
                <input type="text" id="a" name="a" placeholder="Alternativa A" required>
            </div>
            <div class="campo">
                <label for="b">Alternativa B</label>
                <input type="text" id="b" name="b" placeholder="Alternativa B" required>
            </div>
            <div class="campo">
                <label for="c">Alternativa C</label>
                <input type="text" id="c" name="c" placeholder="Alternativa C" required>
            </div>
            <div class="campo">
                <label for="d">Alternativa D</label>
                <input type="text" id="d" name="d" placeholder="Alternativa D" required>
            </div>
        </div>

        <div class="campo">
            <label for="correta">Alternativa Correta</label>
            <select id="correta" name="correta" required>
                <option value="">Escolha a correta</option>
                <option value="A">Alternativa A</option>
                <option value="B">Alternativa B</option>
                <option value="C">Alternativa C</option>
                <option value="D">Alternativa D</option>
            </select>
        </div>

        <button type="submit" class="botao">Salvar Pergunta</button>
    </form>
</section>

        <a href="iniciar_jogo.php?codigo_sala=<?php echo $sala['codigo_sala']; ?>" class="botao-voltar">🚀 Iniciar Jogo</a>

        <h2>👥 Participantes:</h2>
        <div id="lista">Carregando participantes...</div>
    </div>

    <script>
        setInterval(() => {
            fetch('participantes.php?codigo=<?php echo $codigo; ?>')
                .then(r => r.text())
                .then(t => document.getElementById('lista').innerHTML = t);
        }, 2000);
    </script>
</body>
</html>

