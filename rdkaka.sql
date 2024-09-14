-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/09/2024 às 18:25
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rdkaka`
--
CREATE DATABASE IF NOT EXISTS `rdkaka` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rdkaka`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `filial`
--

CREATE TABLE `filial` (
  `idfilial` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cnpj_cpf` varchar(14) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `idsituacao` smallint(6) NOT NULL COMMENT '1 - Ativo\r\n2 - Inativo',
  `idtipofilial` smallint(6) NOT NULL COMMENT '2 - TRANSPORTADORA\r\n3 - CD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filial`
--

INSERT INTO `filial` (`idfilial`, `nome`, `cnpj_cpf`, `email`, `telefone`, `idsituacao`, `idtipofilial`) VALUES
(1, 'Lucas Rico Bonfim', '11331494990123', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(2, 'Lucas Rico Bonfim', '11331494990121', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(3, 'Lucas Rico Bonfim', '11331494990125', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(4, 'GABRIEL', '11331494990129', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(5, 'Lucas Rico Bonfim', '11331494990126', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(6, 'Lucas Rico Bonfim', '11331494990100', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(7, 'LUKAO', '11331494990111', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(8, 'LEOZIN', '21331494990129', 'leozin@gmail.com', '44998487185', 1, 2),
(9, 'fabricio da silva', '99331494990129', 'fabricio@gmail.com', '44998487185', 2, 2),
(10, 'joao', '88331494990129', 'joao@gmail.com', '44998487185', 1, 2),
(11, 'Lucas Rico Bonfim', '22631494990121', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(12, 'SECO NAA', '55331494990129', 'seco@gmail.com', '44998487185', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupos`
--

CREATE TABLE `grupos` (
  `idgrupo` int(11) NOT NULL,
  `descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `grupos`
--

INSERT INTO `grupos` (`idgrupo`, `descricao`) VALUES
(1, 'ADMIN'),
(2, 'TRANSPORTADORA'),
(3, 'CD');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `login` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `idgrupo` int(11) NOT NULL COMMENT '1 - admin\r\n2 - usuario',
  `idfilial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nome`, `login`, `senha`, `idgrupo`, `idfilial`) VALUES
(1, 'IDH', 'kaka', '123', 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filial`
--
ALTER TABLE `filial`
  ADD PRIMARY KEY (`idfilial`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filial`
--
ALTER TABLE `filial`
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;