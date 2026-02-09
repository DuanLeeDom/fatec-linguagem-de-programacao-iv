/*
 * Arquivo: Db_script.sql
 * Script para criar o banco de dados e as tabelas
 * necessario para a Avaliacao P2.
 */

-- Cria o banco de dados se nao existir
CREATE DATABASE IF NOT EXISTS `fatec_lp4_p2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fatec_lp4_p2`;

-- Tabela Veiculo
CREATE TABLE IF NOT EXISTS `Veiculo` (
  `placa` varchar(7) NOT NULL PRIMARY KEY,
  `modelo` varchar(100) NOT NULL,
  `quilometragem` int NOT NULL
);

-- Tabela Combustivel
CREATE TABLE IF NOT EXISTS `Combustivel` (
  `codCombustivel` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL
);

-- Tabela Abastecimentos
-- Relacionamentos: Veiculo (placa) e Combustivel (codCombustivel)
CREATE TABLE IF NOT EXISTS `Abastecimentos` (
  `codAbastecimento` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `dataAbastecimento` date NOT NULL,
  `litrosAbastecidos` decimal(10,2) NOT NULL,
  `precoLitro` decimal(10,2) NOT NULL,
  `quilometrosRodados` int NOT NULL,
  `placaVeiculo` varchar(7) NOT NULL,
  `codCombustivel` int NOT NULL,
  CONSTRAINT `fk_veiculo` FOREIGN KEY (`placaVeiculo`) REFERENCES `Veiculo` (`placa`),
  CONSTRAINT `fk_combustivel` FOREIGN KEY (`codCombustivel`) REFERENCES `Combustivel` (`codCombustivel`)
);

-- Inserindo dados de exemplo na tabela Veiculo
INSERT INTO `Veiculo` (`placa`, `modelo`, `quilometragem`) VALUES
('ABC1234', 'Fusca', 150000),
('XYZ5678', 'Corsa', 85000),
('DEF9012', 'Palio', 120000);

-- Inserindo dados de exemplo na tabela Combustivel
INSERT INTO `Combustivel` (`descricao`) VALUES
('Gasolina Comum'),
('Etanol'),
('Diesel'),
('Gasolina Aditivada');

-- Inserindo alguns abastecimentos de exemplo
INSERT INTO `Abastecimentos` (`dataAbastecimento`, `litrosAbastecidos`, `precoLitro`, `quilometrosRodados`, `placaVeiculo`, `codCombustivel`) VALUES
('2024-05-10', 30.50, 5.89, 450, 'ABC1234', 1),
('2024-05-15', 25.00, 3.99, 320, 'XYZ5678', 2),
('2024-05-20', 45.00, 6.20, 500, 'ABC1234', 4);