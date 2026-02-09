<?php
/**
 * Arquivo: bancoDados.php
 * Responsável pela conexão com o banco de dados MySQL
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function conectarBanco() {
    $host = '127.0.0.1';
    $usuario = 'root';
    $senha = '';
    $banco = 'exercicio';
    $charset = 'utf8mb4';

    try {
        $conn = new mysqli($host, $usuario, $senha, $banco);
        $conn->set_charset($charset);
        return $conn;
    } catch (Exception $e) {
        error_log("Erro de conexão: " . $e->getMessage());
        die("Falha ao conectar ao banco de dados.");
    }
}

function fecharBanco($conn) {
    if ($conn && !$conn->connect_error) {
        $conn->close();
    }
}
?>
