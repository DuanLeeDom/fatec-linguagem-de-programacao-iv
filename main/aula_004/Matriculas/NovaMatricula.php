<!DOCTYPE html>
<!-- inserir o codigo php 
    para conectar ao banco de dados
    e obter a lista de alunos e de disciplinas
-->
<?php
// fornece acesso as constantes já definidas
// e a funcao conexao()
include_once '../Funcoes/BancoD.php';
include_once '../Funcoes/funcoesHTML.php';
// estabelece uma conexao com o BD
$meuBanco = conexao();
//obter lista de alunos;
$listaAlunos = $meuBanco->query(SELECTALUNOS);
// obter lista de disciplinas
$listaDisciplinas = $meuBanco->query(SELECTDISCIPLINAS);
// VARIAVEIS GERAIS
$umaData = getdate();
$ano = $umaData["year"];
$semestre = $umaData["month"] < 7 ? 1 : 2;
$situacao = "cursando";
$nota = 0;
$faltas = 0;
$ra = "";
$disciplina = "";
//recebe parametros sobre erro de execução
$erro = htmlspecialchars(filter_input(INPUT_GET, "err"));
if ($erro) {
    $ra = htmlspecialchars(filter_input(INPUT_GET, "ra"));
    $semestre = htmlspecialchars(filter_input(INPUT_GET, "semestre"));
    $ano = htmlspecialchars(filter_input(INPUT_GET, "ano"));
    $disciplina = htmlspecialchars(filter_input(INPUT_GET, "disciplina"));
}


?>

<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Nova Matrícula</title>
</head>

<body>
    <span>
        <?= $erro; ?>
    </span>

    <form action="inserir.php" method="post">
        <h2>Nova Matrícula</h2>
        <div>
            <label for="ra">Aluno</labeL>
            <select name="ra" id="ra">
                <!--
                        <option value="1">Joao</option>
                        <option value="2">Maria</option>
                    -->
                <?php
                $lista = $listaAlunos->fetchAll();
                geraOption($lista, ["RA", "nome"], $ra);
                //                    foreach ($lista as $linha) {
//                        echo "<option ",
//                             $ra == $linha["RA"] ? " selected ": " "   
//                             , "value='",$linha['RA'],"'>"
//                                   ,$linha["nome"]
//                            ,"</option>";                       
//                    }
                ?>
            </select>
        </div>
        <div>
            <label for="disciplina">Disciplina</labeL>
            <select name="disciplina" id="disciplina">
                <!--
                    <option value="alg">Algoritmos</option>
                    <option value="php">Linguagem de programacao IV</option>
                    -->
                <?php
                $lista = $listaDisciplinas->fetchAll();
                geraOption($lista, ["Cod_disc", "Nome"], $disciplina);
                //                    foreach ($lista as $linha) {
//                        echo "<option ",
//                                $disciplina == $linha["Cod_disc"] ? " selected " :  " ",
//                                " value='",$linha['Cod_disc'],"'>"
//                                   ,$linha["Nome"]
//                            ,"</option>";                       
//                    }
                ?>
            </select>
        </div>
        <div>
            <label for="ano">Ano</labeL>
            <input type="number" name="ano" id="ano" value="<?= $ano ?>" />
        </div>
        <div>
            <label for="semestre">semestre</labeL>
            <input type="number" name="semestre" id="semestre" value="<?= $semestre ?>" />
        </div>
        <div>
            <label>Situacao</labeL>
            <label><?= $situacao ?></label>
        </div>
        <div>
            <label>Nota</labeL>
            <label><?= $nota ?></label>
        </div>
        <div>
            <label>Faltas</labeL>
            <label><?= $faltas ?></label>
        </div>
        <input type="submit" value="Salvar" />
    </form>
</body>

</html>