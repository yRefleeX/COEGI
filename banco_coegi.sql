-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Set-2024 às 06:45
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
  `verificacao` tinyint(1) NOT NULL,
  `data_expiracao` date NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `placa` char(7) NOT NULL,
  `renavam` char(11) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `rotas` varchar(50) NOT NULL,
  `telefone` char(15) NOT NULL,
  `periodo` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `path_2x2_1` varchar(100) NOT NULL,
  `path_2x2_2` varchar(100) NOT NULL,
  `pathCrlv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `motorista`
--

INSERT INTO `motorista` (`motorista_id`, `verificacao`, `data_expiracao`, `nome`, `sobrenome`, `placa`, `renavam`, `preco`, `rotas`, `telefone`, `periodo`, `email`, `senha`, `path_2x2_1`, `path_2x2_2`, `pathCrlv`) VALUES
(2, 1, '2024-10-02', 'gabriel', 'adsa', '', '3979762820', '233.00', 'sdf', '19982367555', '123', 'mesterplayer25@gmail.com', '$2y$10$pLwq1nvpgAOEkJR.sJQX5.bSf6tcIkhMzOWuy4ZMNfAwgXQz8.V9O', 'imagens_2x2_1/66d50fcbdffe4.png', 'imagens_2x2_2/66d50fcbdffe5.png', 'imagensCrlv/66d50fcbdffe6.pdf'),
(4, 1, '2024-10-02', 'André', 'Takeo', 'BRA2E19', '70767386443', '222.00', 'jundiai', '19939467445', 'todos os turnos', 'gabriel.matozinhos@aluno.ifsp.edu.br', '$2y$10$0N8KwK5/5v69zXru94CGie37qgYFRA1VLSgBKksFuGpbt0LznUsPi', 'imagens_2x2_1/66d530c5e4cfe.png', 'imagens_2x2_2/66d530c5e4d08.png', 'imagensCrlv/66d530c5e4d09.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `redsenha_email`
--

CREATE TABLE `redsenha_email` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(10) NOT NULL,
  `data_expiracao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

CREATE TABLE `rotas` (
  `id` int(11) NOT NULL,
  `motorista_id` int(11) NOT NULL,
  `pontos_rota_tarde` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `pontos_rota_manha` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pontos_rota_manha`)),
  `pontos_rota_noite` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pontos_rota_noite`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `rotas`
--

INSERT INTO `rotas` (`id`, `motorista_id`, `pontos_rota_tarde`, `pontos_rota_manha`, `pontos_rota_noite`) VALUES
(2, 2, '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[-47.149844,-22.948514],[-47.147827,-22.941717],[-47.157011,-22.938318],[-47.163706,-22.936045],[-47.184563,-22.944167],[-47.203188,-22.957524],[-47.21426,-22.956813]]}}', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[-47.14993,-22.948751],[-47.147913,-22.942072],[-47.142334,-22.94227],[-47.137871,-22.935472],[-47.123966,-22.926461],[-47.108517,-22.918555],[-47.087746,-22.90812],[-47.076244,-22.890251],[-47.076244,-22.877282],[-47.0644,-22.871588],[-47.0541,-22.865262]]}}', NULL),
(3, 4, NULL, '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[-47.151441,-22.950033],[-47.168088,-22.907334],[-47.181475,-22.933588],[-47.186795,-22.953512]]}}', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[-47.150411,-22.949401],[-47.029762,-22.886454],[-47.038172,-22.98197]]}}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `verificacao_email`
--

CREATE TABLE `verificacao_email` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codigo_verificacao` varchar(10) NOT NULL,
  `data_expiracao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `motorista`
--
ALTER TABLE `motorista`
  ADD PRIMARY KEY (`motorista_id`),
  ADD UNIQUE KEY `cnh` (`renavam`),
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
  MODIFY `motorista_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `redsenha_email`
--
ALTER TABLE `redsenha_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `verificacao_email`
--
ALTER TABLE `verificacao_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
