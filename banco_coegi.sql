-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Maio-2024 às 05:48
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_coegi`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `motorista`
--

CREATE TABLE `motorista` (
  `motorista_id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `cpf` char(14) NOT NULL,
  `rg` char(12) NOT NULL,
  `cnh` char(10) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `rotas` varchar(50) NOT NULL,
  `telefone` char(15) NOT NULL,
  `periodo` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `motorista`
--

INSERT INTO `motorista` (`motorista_id`, `nome`, `sobrenome`, `cpf`, `rg`, `cnh`, `preco`, `rotas`, `telefone`, `periodo`, `email`, `senha`) VALUES
(1, 'aa', 'aa', '107.970.368-30', '532.268.278-', '1111111111', '333.00', 'aaa', '(19) 98323-3788', 'manhã', 'aaa@gmail.com', '12345678'),
(3, 'aa', 'aa', '532.268.278-39', '56.728.893-6', '2222222222', '111.00', 'bbb', '(19) 98277-3804', 'tarde', 'bbb@gmail.com', '4444');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `motorista`
--
ALTER TABLE `motorista`
  ADD PRIMARY KEY (`motorista_id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `rg` (`rg`),
  ADD UNIQUE KEY `cnh` (`cnh`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `motorista`
--
ALTER TABLE `motorista`
  MODIFY `motorista_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
