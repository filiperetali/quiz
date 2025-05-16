-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Abr-2025 às 14:15
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quizi`
--
CREATE DATABASE IF NOT EXISTS `quizi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `quizi`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `sala_id` int(11) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `tempo_total` int(11) DEFAULT 0,
  `acertos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `sala_id` int(11) DEFAULT NULL,
  `pergunta` text DEFAULT NULL,
  `alternativa_a` varchar(255) DEFAULT NULL,
  `alternativa_b` varchar(255) DEFAULT NULL,
  `alternativa_c` varchar(255) DEFAULT NULL,
  `alternativa_d` varchar(255) DEFAULT NULL,
  `correta` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `participante_id` int(11) DEFAULT NULL,
  `pergunta_id` int(11) DEFAULT NULL,
  `resposta` char(1) DEFAULT NULL,
  `tempo_resposta` int(11) DEFAULT NULL,
  `correta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `codigo_sala` varchar(6) DEFAULT NULL,
  `status` enum('aberta','em_andamento','finalizada') DEFAULT 'aberta',
  `jogo_iniciado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sala_id` (`sala_id`);

--
-- Índices para tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sala_id` (`sala_id`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participante_id` (`participante_id`),
  ADD KEY `pergunta_id` (`pergunta_id`);

--
-- Índices para tabela `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_sala` (`codigo_sala`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT de tabela `salas`
--
ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`sala_id`) REFERENCES `salas` (`id`);

--
-- Limitadores para a tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD CONSTRAINT `perguntas_ibfk_1` FOREIGN KEY (`sala_id`) REFERENCES `salas` (`id`);

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`participante_id`) REFERENCES `participantes` (`id`),
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
