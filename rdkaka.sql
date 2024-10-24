-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/10/2024 às 19:23
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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
  `idtipofilial` smallint(6) NOT NULL COMMENT '1 - ADMIN\r\n2 - TRANSPORTADORA\r\n3 - CD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `filial`
--

TRUNCATE TABLE `filial`;
--
-- Despejando dados para a tabela `filial`
--

INSERT INTO `filial` (`idfilial`, `nome`, `cnpj_cpf`, `email`, `telefone`, `idsituacao`, `idtipofilial`) VALUES
(1, 'Matriz', '11331494990123', 'lucas.dossantos@gazin.com.br', '44998487185', 1, 1),
(22, 'IDH', '11111111111111', 'idh@transportes.com', '44111111111', 1, 2),
(23, 'ALFA', '22222222222222', 'alfa@transportes.com', '44222222222', 1, 2),
(24, 'RODONAVES', '33333333333333', 'rodonaves@transportes.com', '44333333333', 1, 2),
(25, 'DOURADINA', '44444444444444', 'douradina@transportes.com', '44444444444', 1, 3),
(26, 'IPAMERI', '55555555555555', 'ipameri@transportes.com', '55555555555', 1, 3),
(27, 'FEIRA DE SANTANA', '66666666666666', 'feira@transportes.com', '66666666666', 1, 3);

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
-- Tabela truncada antes do insert `grupos`
--

TRUNCATE TABLE `grupos`;
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
-- Tabela truncada antes do insert `situacao`
--

TRUNCATE TABLE `situacao`;
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
-- Tabela truncada antes do insert `solicitacoes_agendamentos`
--

TRUNCATE TABLE `solicitacoes_agendamentos`;
--
-- Despejando dados para a tabela `solicitacoes_agendamentos`
--

INSERT INTO `solicitacoes_agendamentos` (`idsolicitacao`, `idcd`, `placa`, `quantidadenota`, `observacao`, `idtransportadora`, `data`, `idsituacao`) VALUES
(17, 25, 'ABC-1234', 12, 'Ok', 22, '2024-10-21', 2),
(18, 26, 'ABC-1345', 12, 'Condutor: Antonio', 22, '2024-10-21', 1),
(19, 27, 'ASD-1234', 12, 'Condutor: Marjuri', 22, '2024-10-22', 1),
(20, 25, 'ASF-1234', 12, 'Teste: Lucas', 1, '2024-10-22', 1);

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
-- Tabela truncada antes do insert `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nome`, `login`, `senha`, `idgrupo`, `idfilial`, `idsituacao`) VALUES
(28, 'Lucas Gabriel', 'lucas.gabriel', '28284886917f9a2fa6952251e64ebea3', 1, 1, 1),
(29, 'Lucas Rico', 'lucas.bonfim', '7e246b7e60e825d99c65351fdd25752d', 1, 1, 1),
(30, 'Robson Alves', 'robson.alves', '7e246b7e60e825d99c65351fdd25752d', 2, 22, 1),
(31, 'Amanda Dias', 'amanda.dias', '7e246b7e60e825d99c65351fdd25752d', 2, 24, 1),
(32, 'Luana Delgado', 'luana.delgado', '28284886917f9a2fa6952251e64ebea3', 2, 23, 1),
(33, 'Altair Neves', 'altair.neves', '7e246b7e60e825d99c65351fdd25752d', 3, 25, 1),
(34, 'Tenisson Ben', 'ben.tenisson', '7e246b7e60e825d99c65351fdd25752d', 3, 26, 1),
(35, 'Tailan Loro', 'tailan.loro', '7e246b7e60e825d99c65351fdd25752d', 3, 27, 1);

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
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;