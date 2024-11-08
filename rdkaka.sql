-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/11/2024 às 22:17
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
-- Despejando dados para a tabela `filial`
--

INSERT INTO `filial` (`idfilial`, `nome`, `cnpj_cpf`, `email`, `telefone`, `idsituacao`, `idtipofilial`) VALUES
(1, 'Matriz', '11331494990123', 'lucas.dossantos@gazin.com.br', '44998487185', 1, 1),
(22, 'IDH', '11111111111111', 'idh@transportes.com', '44111111111', 1, 2),
(23, 'ALFA', '22222222222222', 'alfa@transportes.com', '44222222222', 1, 2),
(24, 'RODONAVES', '33333333333333', 'rodonaves@transportes.com', '44333333333', 1, 2),
(25, 'DOURADINA', '44444444444444', 'douradina@transportes.com', '44444444444', 1, 3),
(26, 'IPAMERI', '55555555555555', 'ipameri@transportes.com', '55555555555', 1, 3),
(27, 'FEIRA DE SANTANA', '66666666666666', 'feira@transportes.com', '66666666666', 1, 3),
(52, 'ATACADO', '', 'teste@teste.com', '11111111111', 1, 4),
(53, 'ECOMMERCE', '', 'teste@teste.com', '11111111111', 1, 5),
(54, 'NOVA VENDA', '', 'teste@teste.com', '11111111111', 1, 6),
(55, 'POS VENDAS', '', 'teste@teste.com', '11111111111', 1, 7);

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
(3, 'CD'),
(4, 'ATACADO'),
(5, 'ECOMMERCE'),
(6, 'NOVA VENDA'),
(7, 'POS VENDAS');

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
(1, 'PEDENTE CONFIRMAÇÃO'),
(2, 'EM ANDAMENTO'),
(3, 'FINALIZADO'),
(4, 'RECUSADO'),
(5, 'CANCELADO'),
(6, 'EM CONTESTAÇÃO'),
(7, 'INDENIZAÇÃO AUTORIZADA'),
(8, 'INDENIZAÇÃO PENDENTE'),
(9, 'FATURADO');

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
(17, 25, 'ABC-1234', 12, 'ok', 22, '2024-10-21', 3),
(18, 26, 'ABC-1345', 12, 'Condutor: Antonio', 22, '2024-10-21', 1),
(19, 27, 'ASD-1234', 12, 'Condutor: Marjuri', 22, '2024-10-22', 1),
(20, 25, 'ASF-1234', 12, 'Teste: Lucas', 1, '2024-10-22', 1),
(21, 25, 'EWQ2131', 121, 'ok', 22, '2024-11-14', 2),
(22, 25, 'DRE2131', 12, 'ok', 22, '2024-11-15', 4),
(23, 25, 'EEW1231', 12, '12', 22, '2024-11-13', 1),
(24, 25, 'WTE1231', 12, '12', 1, '2024-11-15', 1),
(25, 25, 'DWQ1231', 12, '12', 22, '2024-11-15', 1),
(26, 26, 'DQW2131', 12, '12', 22, '2024-11-15', 1),
(27, 27, 'DEF1231', 12, '12', 22, '2024-11-22', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacoes_indenizacao`
--

DROP TABLE IF EXISTS `solicitacoes_indenizacao`;
CREATE TABLE `solicitacoes_indenizacao` (
  `idsolicitacao` int(11) NOT NULL,
  `numero_nota` varchar(50) NOT NULL,
  `tipo_indenizacao` enum('15%','30%','100%') NOT NULL,
  `idtransportadora` varchar(100) NOT NULL,
  `idcd` varchar(100) NOT NULL,
  `observacao` varchar(50) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `anexo` varchar(255) DEFAULT NULL,
  `idsituacao` int(11) NOT NULL,
  `idnegocio` int(11) NOT NULL,
  `numero_nota2` varchar(50) NOT NULL,
  `cnpj` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes_indenizacao`
--

INSERT INTO `solicitacoes_indenizacao` (`idsolicitacao`, `numero_nota`, `tipo_indenizacao`, `idtransportadora`, `idcd`, `observacao`, `data`, `anexo`, `idsituacao`, `idnegocio`, `numero_nota2`, `cnpj`) VALUES
(43, '12312', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144502.142.jpg', 7, 52, '123132', '11111111111111'),
(44, '21312321', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144508.768.jpg', 7, 52, '12321321', '11111111111111'),
(45, '12312321', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144508.768.jpg', 7, 52, '12312321', '11111111111111'),
(46, '1231232', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144502.142.jpg', 7, 52, '1232131', '11111111111111'),
(47, '12312312', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144508.768.jpg', 7, 53, '33121223', '11111111111111'),
(48, '2132213', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathAnotação 2024-11-04 171202.png', 7, 53, '12321311', '11111111111111'),
(49, '12312', '30%', '22', '25', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144501.379.jpg', 7, 53, '121231', '11111111111111'),
(50, '1232121', '30%', '22', '25', 'att', '2024-11-09', 'C:fakepathimagem - 2024-09-13T144500.476.jpg', 7, 53, '321213', '11111111111111'),
(51, '21313213', '30%', '22', '26', 'att', '2024-11-15', 'C:fakepathimagem - 2024-09-13T144502.142.jpg', 7, 53, '1322313', '11111111111111'),
(52, '123132', '100%', '22', '26', 'att', '2024-11-14', 'C:fakepathimagem - 2024-09-13T144501.379.jpg', 7, 53, '123123', '11111111111111');

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
(28, 'Tigresa', 'lucas.gabriel', '7e246b7e60e825d99c65351fdd25752d', 1, 1, 1),
(29, 'Lucas Rico', 'lucas.bonfim', '7e246b7e60e825d99c65351fdd25752d', 1, 1, 1),
(30, 'Robson Alves', 'robson.alves', '7e246b7e60e825d99c65351fdd25752d', 2, 22, 1),
(31, 'Amanda Dias', 'amanda.dias', '7e246b7e60e825d99c65351fdd25752d', 2, 24, 1),
(32, 'Luana Delgado', 'luana.delgado', '28284886917f9a2fa6952251e64ebea3', 2, 23, 1),
(33, 'Altair Neves', 'altair.neves', '7e246b7e60e825d99c65351fdd25752d', 3, 25, 1),
(34, 'Tenisson Ben', 'ben.tenisson', '7e246b7e60e825d99c65351fdd25752d', 3, 26, 1),
(35, 'Tailan Loro', 'tailan.loro', '7e246b7e60e825d99c65351fdd25752d', 3, 27, 1),
(42, 'Kevelyn', 'kevelyn.123', '7e246b7e60e825d99c65351fdd25752d', 4, 52, 1),
(43, 'Vitoria', 'vitoria.xavier', '7e246b7e60e825d99c65351fdd25752d', 5, 53, 1),
(44, 'Claudia', 'claudia.lira', '7e246b7e60e825d99c65351fdd25752d', 6, 54, 1),
(45, 'Bianca', 'bianca.campos', '7e246b7e60e825d99c65351fdd25752d', 7, 55, 1),
(46, 'Amanda', 'amanda.123', '7e246b7e60e825d99c65351fdd25752d', 2, 24, 1);

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
-- Índices de tabela `solicitacoes_indenizacao`
--
ALTER TABLE `solicitacoes_indenizacao`
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
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `solicitacoes_indenizacao`
--
ALTER TABLE `solicitacoes_indenizacao`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
