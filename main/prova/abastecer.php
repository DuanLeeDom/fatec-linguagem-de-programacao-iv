<?php
/**
 * Arquivo: abastecer.php
 * Formulario para registrar as informacoes de um novo abastecimento.
 * Inclui listas de veiculos e combustiveis. (Requisitos 2, 3, 5, 6)
 */

// Inclui o arquivo de conexao
require_once 'Conexao.php';

$pdo = conectarBanco();

$placa_selecionada = htmlspecialchars(filter_input(INPUT_GET, "placa") ?? '');

try {
    $stmt_veiculos = $pdo->prepare(SELECT_VEICULOS);
    $stmt_veiculos->execute();
    $veiculos = $stmt_veiculos->fetchAll();
} catch (PDOException $e) {
    error_log("Erro ao buscar veiculos para o form: " . $e->getMessage());
    $veiculos = [];
}

// 2. Busca a lista de Combustiveis (CodCombustivel - Descricao) (Requisito 5)
try {
    $stmt_combustiveis = $pdo->prepare(SELECT_COMBUSTIVEIS);
    $stmt_combustiveis->execute();
    $combustiveis = $stmt_combustiveis->fetchAll();
} catch (PDOException $e) {
    error_log("Erro ao buscar combustiveis para o form: " . $e->getMessage());
    $combustiveis = [];
}

// Fecha a conexao didaticamente
fecharBanco($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Abastecimento - LP IV</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { width: 50%; margin: 20px 0; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="date"], select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        a { color: #007bff; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>

    <h1>Registrar Novo Abastecimento</h1>

    <form action="processa_abastecer.php" method="POST">

        <div>
            <label for="placaVeiculo">Veiculo (Placa - Modelo):</label>
            <select id="placaVeiculo" name="placaVeiculo" required>
                <option value="">-- Selecione um Veiculo --</option>
                <?php foreach ($veiculos as $veiculo): ?>
                    <option value="<?php echo htmlspecialchars($veiculo['placa']); ?>"
                        <?php echo ($veiculo['placa'] === $placa_selecionada) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['modelo']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </div>

        <div>
            <label for="codCombustivel">Tipo de Combustivel:</label>
            <select id="codCombustivel" name="codCombustivel" required>
                <option value="">-- Selecione o Combustivel --</option>
                <?php foreach ($combustiveis as $combustivel): ?>
                    <option value="<?php echo htmlspecialchars($combustivel['codCombustivel']); ?>">
                        <?php echo htmlspecialchars($combustivel['descricao']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </div>

        <div>
            <label for="dataAbastecimento">Data do Abastecimento:</label>
            <input type="date" id="dataAbastecimento" name="dataAbastecimento" required max="<?php echo date('Y-m-d'); ?>">
        </div>

        <div>
            <label for="litrosAbastecidos">Litros Abastecidos:</label>
            <input type="number" id="litrosAbastecidos" name="litrosAbastecidos" step="0.01" min="0.01" required>
        </div>

        <div>
            <label for="precoLitro">Preco do Litro (R$):</label>
            <input type="number" id="precoLitro" name="precoLitro" step="0.01" min="0.01" required>
        </div>

        <div>
            <label for="quilometrosRodados">Quilometros Rodados no Veiculo (Total/Atual):</label>
            <input type="number" id="quilometrosRodados" name="quilometrosRodados" step="1" min="1" required>
        </div>

        <button type="submit">Salvar Abastecimento</button>
        <a href="index.php">Voltar para a Lista de Veiculos</a>

    </form>

</body>
</html>