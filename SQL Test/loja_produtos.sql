-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Jan-2025 às 21:58
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_produtos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `cod_prod` int(8) NOT NULL,
  `loj_prod` int(8) NOT NULL,
  `qtd_prod` decimal(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`cod_prod`, `loj_prod`, `qtd_prod`) VALUES
(101, 1, 150.000),
(102, 1, 200.000),
(103, 2, 100.000),
(170, 2, 50.000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lojas`
--

CREATE TABLE `lojas` (
  `loj_prod` int(8) NOT NULL,
  `desc_loj` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `lojas`
--

INSERT INTO `lojas` (`loj_prod`, `desc_loj`) VALUES
(1, 'LOJA CENTRAL'),
(2, 'LOJA FILIAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `cod_prod` int(8) NOT NULL,
  `loj_prod` int(8) NOT NULL,
  `desc_prod` char(40) NOT NULL,
  `dt_inclu_prod` date NOT NULL,
  `preco_prod` decimal(8,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`cod_prod`, `loj_prod`, `desc_prod`, `dt_inclu_prod`, `preco_prod`) VALUES
(101, 1, 'ARROZ BRANCO', '2023-01-15', 25.000),
(102, 1, 'FEIJAO PRETO', '2023-01-20', 10.500),
(103, 2, 'MACARRAO PARAFUSO', '2022-11-05', 15.250),
(104, 2, 'OLEO DE SOJA', '2023-02-10', 8.750),
(170, 2, 'LEITE CONDENSADO MOCOCA', '2010-12-30', 45.400);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`cod_prod`,`loj_prod`);

--
-- Índices para tabela `lojas`
--
ALTER TABLE `lojas`
  ADD PRIMARY KEY (`loj_prod`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`cod_prod`,`loj_prod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
