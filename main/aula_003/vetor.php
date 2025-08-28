<?php
session_start();

$parametros = '';
echo var_dump($vetor = $_SESSION['vetor']);

foreach ($vetor as $key => $value) {
    echo "$key: $value<br>";
    if ($parametros != "") {
        $parametros .= "&";
    }
    $parametros .= "$key=$value";
}
echo "<a href='formulario.php?$parametros'>Enviar</a><br>";
// header("location:formulario.php?parametros")
