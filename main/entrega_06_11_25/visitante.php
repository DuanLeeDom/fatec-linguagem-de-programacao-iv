<?php
require_once 'bancoDados.php';

$erro = "";
$sucesso = "";
$cpf = $_POST['cpf'] ?? "";
$nome = $_POST['nome'] ?? "";
$email = $_POST['email'] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($cpf) || empty($nome) || empty($email)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } else {
        $conn = conectarBanco();

        // Verifica se CPF já existe
        $check = $conn->prepare("SELECT cpf FROM visitante WHERE cpf = ?");
        $check->bind_param("s", $cpf);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $erro = "CPF já cadastrado no sistema.";
        } else {
            // Insere novo visitante
            $stmt = $conn->prepare("INSERT INTO visitante (cpf, nome, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $cpf, $nome, $email);

            if ($stmt->execute()) {
                $sucesso = "Visitante cadastrado com sucesso!";
                $cpf = $nome = $email = "";
            } else {
                $erro = "Erro ao cadastrar visitante.";
            }
            $stmt->close();
        }
        $check->close();
        fecharBanco($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Visitante</title>
</head>
<style>
.form-visitante { max-width: 400px; margin: 20px auto; padding: 20px; background: #f9f9f9; border-radius: 8px; }
.form-visitante h2 { margin-bottom: 20px; color: #333; }
.form-visitante label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-visitante input { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; }
.form-visitante input[type="submit"] { background: #667eea; color: white; border: none; cursor: pointer; padding: 10px; }
.form-visitante input[type="submit"]:hover { background: #5568d3; }
.mensagem { padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; }
.erro { background: #fee; color: #c33; }
.sucesso { background: #efe; color: #3c3; }    
</style>
<body>
    <h2>Cadastro de Visitante</h2>

    <?php if ($erro): ?>
        <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <p style="color:green;"><?= htmlspecialchars($sucesso) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>CPF:</label><br>
        <input type="text" name="cpf" value="<?= htmlspecialchars($cpf) ?>" required><br>

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <a href="insereData.php">Cadastrar Data de Visita</a>
</body>
</html>
