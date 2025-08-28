<?php
// Recebendo e tratando os dados
$nome = filter_input(INPUT_GET, 'txtnome', FILTER_SANITIZE_SPECIAL_CHARS);
$altura = filter_input(INPUT_GET, 'txtaltura', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

// Exibindo os dados usando operador ternário
echo $nome ? "Nome informado: $nome<br>" : "Nome não informado.<br>";
echo $altura ? "Altura informada: $altura<br>" : "Altura não informada.<br>";
?>
