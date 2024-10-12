-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/10/2024 às 02:54
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

DROP TABLE IF EXISTS `filial`;
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
(3, 'Lucas Rico Bonfim', '11331494990125', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(4, 'GABRIEL', '11331494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(5, 'Lucas Rico Bonfim', '11331494990126', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(6, 'Lucas Rico Bonfim', '11331494990100', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(7, 'LUKAO', '11331494990111', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(8, 'LEOZIN', '21331494990129', 'leozin@gmail.com', '44998487185', 1, 2),
(9, 'Fabricio Silva TMJ', '99331494990129', 'fabricio@gmail.com.br', '44998487184', 1, 3),
(10, 'joao', '88331494990129', 'joao@gmail.com', '44998487185', 2, 2),
(11, 'Lucas Rico Bonfim', '22631494990121', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(12, 'SECO NAA', '55331494990129', 'seco@gmail.com', '44998487185', 1, 2),
(13, 'Lucas Rico Bonfim', '29331494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(14, 'Lucas Rico Bonfim', '27331494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(15, 'Lucas Rico Bonfim', '95331494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(16, 'Lucas Rico Bonfim', '45331494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(17, 'Ze Adriando', '91131494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(18, 'LEO KLEN', '11131494990129', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(19, 'Lucas Rico Bonfim', '11111111111111', 'lucasricobonfim@gmail.com', '44998487185', 2, 2),
(20, 'Lucas Rico Bonfim', '93314949901298', 'lucasricobonfim@gmail.com', '44998487185', 1, 2),
(21, 'Lucas Rico Bonfim', '99314949901295', 'lucasricobonfim@gmail.com', '44998487185', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupos`
--

DROP TABLE IF EXISTS `grupos`;
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
-- Estrutura para tabela `situacao`
--

DROP TABLE IF EXISTS `situacao`;
CREATE TABLE `situacao` (
  `idsituacao` int(11) NOT NULL,
  `situacao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `situacao`
--

INSERT INTO `situacao` (`idsituacao`, `situacao`) VALUES
(1, 'PEDENTE CONFIRMAÇÂO'),
(2, 'EM ANDAMENTO'),
(3, 'FINALIZADO'),
(4, 'RECUSADO'),
(5, 'CANCELADO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacoes_agendamentos`
--

DROP TABLE IF EXISTS `solicitacoes_agendamentos`;
CREATE TABLE `solicitacoes_agendamentos` (
  `idsolicitacao` int(11) NOT NULL,
  `idcd` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `quantidadenota` int(11) NOT NULL,
  `observacao` varchar(300) NOT NULL,
  `idtransportadora` int(11) NOT NULL,
  `data` date NOT NULL,
  `idsituacao` int(11) NOT NULL COMMENT '1 - PENDENTE CONFIRMAÇÂO\r\n2 - EM ANDAMENTO\r\n3 - FINALIZADO\r\n4 - RECUSADO\r\n5 - CANCELADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes_agendamentos`
--

INSERT INTO `solicitacoes_agendamentos` (`idsolicitacao`, `idcd`, `placa`, `quantidadenota`, `observacao`, `idtransportadora`, `data`, `idsituacao`) VALUES
(1, 9, '222', 2, 'teste', 6, '2024-10-09', 1),
(2, 21, 'TESTE15', 2, 'teste', 6, '2024-10-09', 1),
(3, 21, 'TESTE15', 2, 'teste', 6, '2024-10-09', 1),
(4, 9, '341', 1, '2222', 6, '2024-10-09', 1),
(5, 9, '2321321', 1, 'teste', 6, '2024-10-10', 1),
(6, 9, '31231', 1, 'teste', 6, '2024-10-23', 1),
(7, 9, '31231', 1, 'teste', 6, '2024-10-23', 1),
(8, 9, '2313', 1, '1', 6, '2024-10-10', 1),
(9, 9, 'teste', 1, 'teste', 6, '2024-10-10', 1),
(10, 9, 'yrste', 1, 'teste', 6, '2024-10-10', 1),
(11, 9, 'teste', 2, 'teste', 6, '2024-10-10', 1),
(12, 9, 'teste', 2, 'teste', 6, '2024-10-11', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `login` varchar(200) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `idgrupo` int(11) NOT NULL COMMENT '1 - admin\r\n2 - Transportadora\r\n3 - CD',
  `idfilial` int(11) NOT NULL,
  `idsituacao` int(11) NOT NULL COMMENT '1 - Ativo, 2 - Inativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nome`, `login`, `senha`, `idgrupo`, `idfilial`, `idsituacao`) VALUES
(19, 'Lucas Admin', 'lucas.bonfim', '202cb962ac59075b964b07152d234b70', 1, 6, 2),
(20, 'Lucas CD', 'lukao', '202cb962ac59075b964b07152d234b70', 3, 20, 2),
(25, 'Lucas Transportadora', 'kaka', '202cb962ac59075b964b07152d234b70', 2, 18, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filial`
--
ALTER TABLE `filial`
  ADD PRIMARY KEY (`idfilial`);

--
-- Índices de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  ADD PRIMARY KEY (`idsolicitacao`);

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
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;