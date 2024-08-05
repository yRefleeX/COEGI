-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 05-Ago-2024 às 19:16
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.1

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
  `verificacao` tinyint(1) NOT NULL,
  `data_expiracao` date NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `cpf` char(14) NOT NULL,
  `rg` char(12) NOT NULL,
  `cnh` char(10) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `rotas` varchar(50) NOT NULL,
  `telefone` char(15) NOT NULL,
  `periodo` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `pathRes` varchar(100) NOT NULL,
  `path_2x2_1` varchar(100) NOT NULL,
  `path_2x2_2` varchar(100) NOT NULL,
  `pathCrlv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `redsenha_email`
--

CREATE TABLE `redsenha_email` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(10) NOT NULL,
  `data_expiracao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

CREATE TABLE `rotas` (
  `id` int(11) NOT NULL,
  `motorista_id` int(11) NOT NULL,
  `pontos_rota` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pontos_rota`)),
  `pontos_rota_manha` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pontos_rota_manha`)),
  `pontos_rota_noite` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pontos_rota_noite`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `verificacao_email`
--

CREATE TABLE `verificacao_email` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codigo_verificacao` varchar(10) NOT NULL,
  `data_expiracao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Índices para tabela `redsenha_email`
--
ALTER TABLE `redsenha_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Índices para tabela `rotas`
--
ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorista_id` (`motorista_id`);

--
-- Índices para tabela `verificacao_email`
--
ALTER TABLE `verificacao_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `motorista`
--
ALTER TABLE `motorista`
  MODIFY `motorista_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `redsenha_email`
--
ALTER TABLE `redsenha_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `verificacao_email`
--
ALTER TABLE `verificacao_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `rotas`
--
ALTER TABLE `rotas`
  ADD CONSTRAINT `rotas_ibfk_1` FOREIGN KEY (`motorista_id`) REFERENCES `motorista` (`motorista_id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_token_verificacao` ON SCHEDULE EVERY 1 HOUR STARTS '2024-06-14 15:19:22' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM verificacao_email WHERE data_expiracao < DATE_SUB(NOW(), INTERVAL 1 HOUR)$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_old_token_red` ON SCHEDULE EVERY 1 HOUR STARTS '2024-06-14 15:22:55' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM redsenha_email WHERE data_expiracao < DATE_SUB(NOW(), INTERVAL 1 HOUR)$$

CREATE DEFINER=`root`@`localhost` EVENT `delete_old_motorista_verificacao` ON SCHEDULE EVERY 1 MONTH STARTS '2024-08-05 14:07:07' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM motorista WHERE verificacao = 0 AND data_expiracao < DATE_SUB(NOW(), INTERVAL 1 MONTH)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
