<?php
session_start();

// Armazenando valores na sessão
$_SESSION["data"] = new DateTime();
$_SESSION["minhaData"] = "2023-10-01";

// Criando cookie válido por 60 segundos
setcookie("pagina", "index.php", time() + 60);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula_01</title>
</head>

<body>
    <?php
    echo "meu primeiro print!", "<br>";
    echo var_dump($_REQUEST), "<br>";
    echo var_dump($_POST), "<br>";
    echo var_dump($_GET), "<br>";
    echo var_dump($_COOKIE), "<br>";
    echo var_dump($_SESSION), "<br>";

    echo "minhaData => " . print_r($_SESSION["minhaData"], true) . "<br>";
    echo "data => " . var_dump($_SESSION["data"]) . "<br>";

    if (isset($_SESSION["OBJdata"])) {
        echo "OBJdata => " . var_dump(json_decode($_SESSION["OBJdata"])) . "<br>";
    }

    session_unset();
    ?>

    <!-- Formulário -->
    <form action="cadastro.php" method="get">
        nome: <input type="text" name="txtnome" value=""><br />
        altura: <input type="number" step="0.01" name="txtaltura" value=""><br />
        <input type="submit" value="Enviar">
    </form>
</body>

</html>