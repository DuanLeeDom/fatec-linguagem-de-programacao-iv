<?php
/**
 * Arquivo: lista_abastecimentos.php
 * Exibe a lista de abastecimentos de um veiculo especifico,
 * ordenados pela data. (Requisito 8)
 */

// Inclui o arquivo de conexao
require_once 'Conexao.php';

// Sanitizacao e filtro da variavel de entrada (placa do veiculo)
$placa_veiculo = htmlspecialchars(filter_input(INPUT_GET, "placa", FILTER_SANITIZE_STRING));

// Verifica se a placa foi fornecida
if (!$placa_veiculo) {
    // Se nao tiver placa, volta para o index
    header("Location: index.php");
    exit();
}

// Inicia a conexao com o banco
$pdo = conectarBanco();
$abastecimentos = []; // Inicia a variavel

// Busca os abastecimentos do veiculo
try {
    $stmt = $pdo->prepare(SELECT_ABASTECIMENTOS_VEICULO);
    $stmt->bindParam(':placa', $placa_veiculo);
    $stmt->execute();
    $abastecimentos = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erro ao listar abastecimentos: " . $e->getMessage());
}

// Fecha a conexao didaticamente
fecharBanco($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Abastecimentos do Veiculo - LP IV</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 80%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { color: #007bff; text-decoration: none; }
        .sucesso { color: green; font-weight: bold; }
    </style>
</head>
<body>

    <?php if (filter_input(INPUT_GET, "sucesso")): ?>
        <p class="sucesso">Abastecimento registrado com sucesso para o veiculo <?php echo htmlspecialchars($placa_veiculo); ?>!</p>
    <?php endif; ?>

    <h1>Lista de Abastecimentos do Veiculo: <?php echo htmlspecialchars($placa_veiculo); ?></h1>
    
    <p>
        <a href="index.php">Voltar para a lista de Veiculos</a> | 
        <a href="abastecer.php?placa=<?php echo htmlspecialchars($placa_veiculo); ?>">Registrar Novo Abastecimento</a>
    </p>

    <?php if (count($abastecimentos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Litros</th>
                    <th>Preco/Litro (R$)</th>
                    <th>Combustivel</th>
                    <th>Km Rodados (Total)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($abastecimentos as $abastecimento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($abastecimento['dataAbastecimento']))); ?></td>
                        <td><?php echo htmlspecialchars(number_format($abastecimento['litrosAbastecidos'], 2, ',', '.')); ?></td>
                        <td><?php echo htmlspecialchars(number_format($abastecimento['precoLitro'], 2, ',', '.')); ?></td>
                        <td><?php echo htmlspecialchars($abastecimento['tipoCombustivel']); ?></td>
                        <td><?php echo htmlspecialchars($abastecimento['quilometrosRodados']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum abastecimento encontrado para o veiculo <?php echo htmlspecialchars($placa_veiculo); ?>.</p>
    <?php endif; ?>

</body>
</html>