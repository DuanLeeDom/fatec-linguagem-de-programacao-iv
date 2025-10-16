<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function conexao()
{
     $dsn = "mysql:host=localhost;dbname=escola";
     $user = "root";
     $pass = "";
     $conn = new PDO($dsn, $user, $pass);
     $conn->setAttribute(
          PDO::ATTR_ERRMODE,
          PDO::ERRMODE_EXCEPTION
     );

     return $conn;
}

// relacao de constantes SQL que serão usadas
// do decorrer do projeto

const SELECTALUNOS
     = "select * from aluno";
const SELECTDISCIPLINAS
     = "select * from disciplinas";

const INSERTMATRICULA
     = "insert into matriculado "
     . "(ano, semestre,nota,faltas,situacao,"
     . " cod_disc,ra) values "
     . "(:ano, :semestre, :nota, :faltas,"
     . " :situacao, :cod_disc, :ra)";


