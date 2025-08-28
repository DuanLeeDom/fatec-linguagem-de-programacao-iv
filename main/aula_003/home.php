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

    <?php
        echo $_SESSION["usuario"], "<br>";
        echo $_SESSION["nivel"], "<br>";

        // TESTE DE ARMAZENAMENTO DE VETOR EM SESSÃO
        $vetor['valor'] = 526.00;
        $vetor['data'] = "mesa";
        $vetor['qtd'] = 30;
        
        // CORREÇÃO: Armazenar o vetor na sessão
        $_SESSION['vetor'] = $vetor;
    ?>
    <a href="vetor.php">Vetor</a>
</body>
</html>