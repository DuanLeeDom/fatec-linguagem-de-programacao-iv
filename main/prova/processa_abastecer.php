<?php
/**
 * Arquivo: processa_abastecer.php
 * Recebe e salva os dados do novo abastecimento na tabela Abastecimentos. (Requisito 7)
 */

// Inclui o arquivo de conexao
require_once 'Conexao.php';

// 1. Sanitizacao e filtro das variaveis POST (Requisito: Usar filter_input e htmlspecialchars)

// Filtragem para garantir que a placa tenha apenas caracteres permitidos
$placaVeiculo = htmlspecialchars(filter_input(INPUT_POST, "placaVeiculo", FILTER_SANITIZE_STRING));

// Filtragem para garantir que o codigo seja um inteiro
$codCombustivel = htmlspecialchars(filter_input(INPUT_POST, "codCombustivel", FILTER_SANITIZE_NUMBER_INT));

// Filtragem de data. Nota: A data deve ser um formato valido (YYYY-MM-DD)
$dataAbastecimento = htmlspecialchars(filter_input(INPUT_POST, "dataAbastecimento"));

// Filtragem para garantir que sejam floats, ou null se falhar
$litrosAbastecidos = filter_input(INPUT_POST, "litrosAbastecidos", FILTER_VALIDATE_FLOAT);
$precoLitro = filter_input(INPUT_POST, "precoLitro", FILTER_VALIDATE_FLOAT);

// Filtragem para garantir que seja um inteiro, ou null se falhar
$quilometrosRodados = filter_input(INPUT_POST, "quilometrosRodados", FILTER_VALIDATE_INT);

// 2. Validacao dos dados. Verifica se algo falhou na filtragem ou esta vazio
if (!$placaVeiculo || !$codCombustivel || !$dataAbastecimento || $litrosAbastecidos === false || $precoLitro === false || $quilometrosRodados === false) {
    // Se algum dado obrigatorio falhou ou e invalido, redireciona com erro
    header("Location: abastecer.php?erro=dados_invalidos");
    exit();
}

// 3. Conexao com o banco de dados
$pdo = conectarBanco();

// 4. Insercao no banco de dados
try {
    // Prepara o comando SQL (usando a constante)
    $stmt = $pdo->prepare(INSERT_ABASTECIMENTO);

    // Faz o bind dos parametros com os dados filtrados
    $stmt->bindParam(':dataAbastecimento', $dataAbastecimento);
    $stmt->bindParam(':litrosAbastecidos', $litrosAbastecidos);
    $stmt->bindParam(':precoLitro', $precoLitro);
    $stmt->bindParam(':quilometrosRodados', $quilometrosRodados);
    $stmt->bindParam(':placaVeiculo', $placaVeiculo);
    $stmt->bindParam(':codCombustivel', $codCombustivel);

    // Executa a insercao
    $stmt->execute();

    // Redireciona para a lista de abastecimentos do veiculo inserido
    header("Location: lista_abastecimentos.php?placa=$placaVeiculo&sucesso=true");
    exit();

} catch (PDOException $e) {
    // Em caso de erro, registra no log e redireciona com mensagem de erro
    error_log("Erro ao salvar abastecimento: " . $e->getMessage());
    header("Location: abastecer.php?placa=$placaVeiculo&erro=falha_bd");
    exit();
} finally {
    // Fecha a conexao didaticamente
    fecharBanco($pdo);
}

// Observacao: A validacao de dados e feita de forma procedural
// usando funcoes nativas, sem depender de classes complexas,
// o que se alinha ao padrao didatico e simples solicitado.
?>