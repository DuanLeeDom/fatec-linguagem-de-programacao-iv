<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
// funcao para preencher o conteudo da tag select
// $matriz - dados que serão utilizados para exibir as opcoes
// $vetorCampos  -lista de nomes do campos que serão utilizados
// $valorSelecionavel - para selecionar um valor inicial
function geraOption( $matriz, 
                     $vetorCampos, 
                     $valorSelecionavel = null){
    foreach ($matriz as $linha) {
        echo "<option ",
             $valorSelecionavel == $linha[$vetorCampos[0]] ?
                  " selected " : " ",
             " value = '" . $linha[$vetorCampos[0]] ."'>",
               $linha[$vetorCampos[1]],
                "</option>";                
    }
    
}