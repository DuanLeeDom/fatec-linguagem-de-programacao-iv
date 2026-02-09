<?php
require_once 'bancoDados.php';

$erro = "";
$sucesso = "";
$visitante_cpf = $_POST['visitantes'] ?? "";
$data_visita = $_POST['data'] ?? "";
$visitantes = [];

// Carrega visitantes no select
$conn = conectarBanco();
$result = $conn->query("SELECT cpf, nome FROM visitante ORDER BY nome");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $visitantes[] = $row;
    }
}
fecharBanco($conn);

// Se enviou o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($visitante_cpf) || empty($data_visita)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        $conn = conectarBanco();

        // Verifica se visitante existe
        $check_visitante = $conn->prepare("SELECT nome FROM visitante WHERE cpf = ?");
        $check_visitante->bind_param("s", $visitante_cpf);
        $check_visitante->execute();
        $result_visitante = $check_visitante->get_result();

        if ($result_visitante->num_rows === 0) {
            $erro = "Visitante não encontrado.";
        } else {
            // Verifica se já existe uma visita nessa data
            $check = $conn->prepare("SELECT id FROM datavisita WHERE visitantes = ? AND data = ?");
            $check->bind_param("ss", $visitante_cpf, $data_visita);
            $check->execute();  
            $check->store_result();

            if ($check->num_rows > 0) {
                $erro = "Já existe uma visita cadastrada para este visitante nesta data.";
            } else {
                $stmt = $conn->prepare("INSERT INTO datavisita (visitantes, data) VALUES (?, ?)");
                $stmt->bind_param("ss", $visitante_cpf, $data_visita);
                if ($stmt->execute()) {
                    $sucesso = "Visita cadastrada com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar visita.";
                }
                $stmt->close();
            }
            $check->close();
        }
        $check_visitante->close();
        fecharBanco($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Data de Visita</title>
</head>
<body>
    <h2>Cadastro de Data de Visita</h2>

    <?php if ($erro): ?>
        <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <p style="color:green;"><?= htmlspecialchars($sucesso) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Visitante:</label><br>
        <select name="visitantes" required>
            <option value="">Selecione</option>
            <?php foreach ($visitantes as $v): ?>
                <option value="<?= htmlspecialchars($v['cpf']) ?>" <?= $visitante_cpf == $v['cpf'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v['nome']) ?> - CPF: <?= htmlspecialchars($v['cpf']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Data da Visita:</label><br>
        <input type="date" name="data" value="<?= htmlspecialchars($data_visita) ?>" required><br><br>

        <input type="submit" value="Registrar Visita">
    </form>

    <a href="visitante.php">Cadastrar Novo Visitante</a>
</body>
</html>
