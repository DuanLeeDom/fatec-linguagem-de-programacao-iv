<?php
session_start();

// Verificação do usuário: se não estiver autenticado, redireciona para login
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
</head>
<body>
    <a href="logout.php">Sair</a>

    <h2>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
    <p>Nível de acesso: <?php echo htmlspecialchars($_SESSION['nivel'], ENT_QUOTES, 'UTF-8'); ?></p>
</body>
</html>
