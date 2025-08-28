<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="identificador">ID:</label>
        <input type="text" id="identificador" name="identificador" value=""><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" value=""><br><br>

        <input type="submit" value="Autenticar">
    </form>
</body>
</html>