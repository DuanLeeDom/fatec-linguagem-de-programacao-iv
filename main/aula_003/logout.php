<?php

session_start(); // Inicia a sessão para manipular as variáveis de sessão
session_unset(); // Limpa todas as variáveis de sessão
header("Location: index.php"); // Redireciona para a página de login

?>