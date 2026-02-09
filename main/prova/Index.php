<?php
/**
 * Arquivo: index.php
 * Lista todos os veiculos cadastrados no banco de dados,
 * permitindo ao usuario visualizar a lista de abastecimentos
 * ou registrar um novo abastecimento. (Requisito 1)
 */

// Inclui o arquivo de conexao
require_once 'Conexao.php';

// Inicia a conexao com o banco
$pdo = conectarBanco();

// Prepara e executa a consulta
// Usa a constante de comando SQL definida em Conexao.php
try {
    $stmt = $pdo->prepare(SELECT_VEICULOS);
    $stmt->execute();
    $veiculos = $stmt->fetchAll();
} catch (PDOException $e) {
    // Trata erro de consulta
    error_log("Erro ao listar veiculos: " . $e->getMessage());
    $veiculos = []; // Garante que a variavel esteja definida mesmo em erro
}

// Fecha a conexao didaticamente
fecharBanco($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Veiculos - LP IV</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 80%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-novo { display: inline-block; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Lista de Veiculos Cadastrados</h1>

    <a href="abastecer.php" class="btn-novo">Realizar Novo Abastecimento Geral</a>

    <?php if (count($veiculos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($veiculo['placa']); ?></td>
                        <td><?php echo htmlspecialchars($veiculo['modelo']); ?></td>
                        <td>
                            <a href="lista_abastecimentos.php?placa=<?php echo htmlspecialchars($veiculo['placa']); ?>">
                                Ver Abastecimentos
                            </a>
                             | 
                            <a href="abastecer.php?placa=<?php echo htmlspecialchars($veiculo['placa']); ?>">
                                Novo Abastecimento
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum veiculo cadastrado.</p>
    <?php endif; ?>

</body>
</html>