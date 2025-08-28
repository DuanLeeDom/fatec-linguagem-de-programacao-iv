<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
</head>
<body>
    <?php
    $prod = htmlspecialchars(
        filter_input(INPUT_GET, "data")
    );
    $val = htmlspecialchars(
        filter_input(INPUT_GET, "valor")
    );
    $qtd = htmlspecialchars(
        filter_input(INPUT_GET, "qtd")
    );

    ?>
    <form action="">
        <label> produto </label>
        <input type="text" name="produto" value="<?= $prod ?>" /><br>
        <label> valor </label>
        <input type="text" name="valor" value="<?= $val ?>" /><br>
        <label> quantidade </label>
        <input type="text" name="quantidade" value="<?= $qtd ?>" /><br>
    </form>
</body>

</html>