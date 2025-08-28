<?php

// Criar ou objeter uma sessão
session_start();

// Obter os valores das caixas de texto
$id = htmlspecialchars(filter_input(INPUT_POST, 'identificador'), ENT_QUOTES, 'UTF-8');
$senha = htmlspecialchars(filter_input(INPUT_POST, 'senha'), ENT_QUOTES, 'UTF-8');

// verificar os dados se são compativeis com algum usuário
switch ($id) {
    case "aluno":
        if ($senha === "123456") {
            // Guardar info na sessão
            $_SESSION['usuario'] = $id; // Armazenar usuário na sessão
            $_SESSION['nivel'] = 'basico';
            // redirecionar para a pagina home.php
            header("location: home.php");

        } else {
            session_unset();
            // redirecionar para a pagina index.php
            header("location: index.php");
        };
        break;
    case "professor":
        if ($senha === "997654") {
            // Guardar info na sessão
            $_SESSION['usuario'] = $id; // Armazenar usuário na sessão
            $_SESSION['nivel'] = 'avancado';
            // redirecionar para a pagina home.php
            header("location: home.php");
        } else {
            session_unset();
            // redirecionar para a pagina index.php
            header("location: index.php");
        }
        break;
    default:
        // Se não for aluno ou professor, redirecionar para a página de login
        header("Location: index.php");
        exit;
};

?>