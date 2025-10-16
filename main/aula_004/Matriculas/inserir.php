<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/*
 * Recebi os dados da página novaMatricula.php
 * insere estes dados na tabela Matricula
 * e redireciona para a página novaMatricula
 * 
 */
include_once '../Funcoes/BancoD.php';
// receber os dados inseridos em novaMatricula.

$ra = filter_input(INPUT_POST, "ra");
$disciplina = filter_input(INPUT_POST, "disciplina");
$ano = filter_input(INPUT_POST, "ano");
$semestre = filter_input(INPUT_POST, "semestre");
$situacao = "cursando";
$nota = 0;
$faltas = 0;

// preparar a execução do comando SQL de inserção
// 1o. obter uma conexao com o BD
$conexao = conexao();
// 2o. enviar a solicitação de qual SQL será utilizado
$comandoPreparado = $conexao->prepare(INSERTMATRICULA);
// 3o. atribuiraos parametros do sql o conteudo das variaveis
// recebidas do formulario
$comandoPreparado->bindParam(":ra", $ra);
$comandoPreparado->bindParam(":ano", $ano);
$comandoPreparado->bindParam(":semestre", $semestre);
$comandoPreparado->bindParam(":situacao", $situacao);
$comandoPreparado->bindParam(":nota", $nota);
$comandoPreparado->bindParam(":faltas", $faltas);
$comandoPreparado->bindParam(":cod_disc", $disciplina);

//4o executar o sql4
try {
    $conexao->beginTransaction();
    $comandoPreparado->execute();
    $conexao->commit();
    header("location:NovaMatricula.php");
} catch (PDOException $exc) {
    $tipo = $exc->getMessage();
    if (str_contains($tipo, "PRIMARY")) {
        $erro = "Chave Duplicada";

    }
    header("location:NovaMatricula.php?err=$erro"
        . "&ra=$ra&ano=$ano&semestre=$semestre"
        . "&disciplina=$disciplina");
}





