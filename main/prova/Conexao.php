<?php
/**
 * Arquivo: Conexao.php
 * Responsavel por estabelecer a conexao com o banco de dados MySQL
 * usando a classe PDO.
 */

// Define as constantes de comandos SQL
const SELECT_VEICULOS = "SELECT placa, modelo FROM Veiculo";
const SELECT_COMBUSTIVEIS = "SELECT codCombustivel, descricao FROM Combustivel";
const INSERT_ABASTECIMENTO = "INSERT INTO Abastecimentos (dataAbastecimento, litrosAbastecidos, precoLitro, quilometrosRodados, placaVeiculo, codCombustivel) VALUES (:dataAbastecimento, :litrosAbastecidos, :precoLitro, :quilometrosRodados, :placaVeiculo, :codCombustivel)";
const SELECT_ABASTECIMENTOS_VEICULO = "SELECT A.dataAbastecimento, A.litrosAbastecidos, A.precoLitro, A.quilometrosRodados, C.descricao AS tipoCombustivel FROM Abastecimentos AS A JOIN Combustivel AS C ON A.codCombustivel = C.codCombustivel WHERE A.placaVeiculo = :placa ORDER BY A.dataAbastecimento DESC";

/**
 * Funcao para conectar ao banco de dados usando PDO.
 * @return PDO O objeto de conexao PDO.
 */
function conectarBanco() {
    // Parametros de conexao declarados diretamente
    $host = '127.0.0.1';
    $usuario = 'root';
    $senha = '';
    $banco = 'fatec_lp4_p2';
    $charset = 'utf8mb4';

    // Monta a string DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$banco;charset=$charset";
    
    try {
        // Cria e retorna o objeto PDO
        $pdo = new PDO($dsn, $usuario, $senha);
        return $pdo;
    } catch (PDOException $e) {
        // Em caso de erro, registra no log e para o script
        error_log("Erro de conexao PDO: " . $e->getMessage());
        die("Falha grave ao conectar ao banco de dados.");
    }
}

/**
 * Funcao auxiliar para fechar a conexao PDO.
 * Geralmente nao e estritamente necessario fechar, pois o PHP
 * faz a coleta de lixo, mas e boa pratica para ser didatico.
 * @param PDO $pdo O objeto de conexao PDO.
 */
function fecharBanco($pdo) {
    // Simplesmente atribui null ao objeto para liberar recursos
    $pdo = null;
}
?>