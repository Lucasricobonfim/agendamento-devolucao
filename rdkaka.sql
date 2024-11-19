-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/11/2024 às 19:08
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
-- Estrutura para tabela `anexo`
--

DROP TABLE IF EXISTS `anexo`;
CREATE TABLE `anexo` (
  `idmovimento` int(11) NOT NULL,
  `idsolicitacao` int(11) NOT NULL,
  `idsituacao` int(11) NOT NULL,
  `anexo` varchar(250) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `anexo`
--

INSERT INTO `anexo` (`idmovimento`, `idsolicitacao`, `idsituacao`, `anexo`, `data`) VALUES
(58, 77, 8, '897370 (8).jpeg', '2024-11-18 15:15:53'),
(59, 77, 8, '897370 (2).jpeg', '2024-11-18 15:15:53'),
(60, 78, 8, 'imagem - 2024-09-13T144508.768 - Copia.jpg', '2024-11-18 15:16:15'),
(61, 79, 8, 'Imagem do WhatsApp de 2024-10-29 à(s) 14.59.46_b8740fff.jpg', '2024-11-18 15:16:34'),
(62, 80, 8, '897370 (7).jpeg', '2024-11-18 15:16:50'),
(63, 81, 8, 'imagem - 2024-09-13T144502.142.jpg', '2024-11-18 15:17:07'),
(64, 82, 8, 'imagem - 2024-09-13T144501.379.jpg', '2024-11-18 15:17:28'),
(65, 83, 8, 'imagem - 2024-09-13T144508.768.jpg', '2024-11-18 15:17:45'),
(66, 84, 8, 'imagem (23).png', '2024-11-18 15:18:07'),
(67, 85, 8, 'imagem - 2024-09-13T144508.768.jpg', '2024-11-18 15:18:32'),
(68, 86, 8, 'imagem - 2024-09-13T144500.476.jpg', '2024-11-18 15:18:51'),
(69, 87, 8, '897370 (2).jpeg', '2024-11-19 11:50:54'),
(70, 87, 8, '897370 (3).jpeg', '2024-11-19 11:50:54'),
(71, 88, 8, '897370 (7).jpeg', '2024-11-19 11:53:47'),
(72, 88, 8, '897370 (5).jpeg', '2024-11-19 11:53:47'),
(73, 88, 8, '897370 (9).jpeg', '2024-11-19 11:53:47'),
(74, 88, 8, '897370 (8).jpeg', '2024-11-19 11:53:47'),
(75, 89, 8, '897370 (5).jpeg', '2024-11-19 11:54:10'),
(76, 89, 8, '897370 (9).jpeg', '2024-11-19 11:54:10'),
(77, 89, 8, 'imagem - 2024-09-13T144508.768 - Copia - Copia.jpg', '2024-11-19 11:54:10'),
(78, 90, 8, '897370 (7).jpeg', '2024-11-19 11:55:01'),
(79, 90, 8, '897370 (5).jpeg', '2024-11-19 11:55:01'),
(80, 90, 8, '897370 (9).jpeg', '2024-11-19 11:55:01'),
(81, 90, 8, '897370 (8).jpeg', '2024-11-19 11:55:01'),
(82, 91, 8, '897370 (9).jpeg', '2024-11-19 11:56:00'),
(83, 91, 8, '897370 (8).jpeg', '2024-11-19 11:56:00'),
(84, 91, 8, '897370 (2).jpeg', '2024-11-19 11:56:00');

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
-- Estrutura para tabela `movimento_solicitacoes`
--

DROP TABLE IF EXISTS `movimento_solicitacoes`;
CREATE TABLE `movimento_solicitacoes` (
  `idmovimento` int(11) NOT NULL,
  `idsolicitacao` int(11) NOT NULL,
  `idsituacao` int(11) NOT NULL,
  `observacao` varchar(500) NOT NULL,
  `dataoperacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimento_solicitacoes`
--

INSERT INTO `movimento_solicitacoes` (`idmovimento`, `idsolicitacao`, `idsituacao`, `observacao`, `dataoperacao`) VALUES
(55, 77, 8, '12', '2024-11-18 15:15:53'),
(56, 78, 8, '12', '2024-11-18 15:16:15'),
(57, 79, 8, 'TESTANDO ID', '2024-11-18 15:16:34'),
(58, 80, 8, 'TESTANDO ID', '2024-11-18 15:16:50'),
(59, 81, 8, 'TESTANDO ID', '2024-11-18 15:17:07'),
(60, 82, 8, 'TESTANDO ID', '2024-11-18 15:17:28'),
(61, 83, 8, 'TESTANDO ID', '2024-11-18 15:17:45'),
(62, 84, 8, 'TESTANDO ID', '2024-11-18 15:18:07'),
(63, 85, 8, 'TESTANDO ID', '2024-11-18 15:18:32'),
(64, 86, 8, 'TESTANDO ID', '2024-11-18 15:18:51'),
(65, 77, 7, 'TESTANDO ID TRANSPORTADORA', '2024-11-18 15:19:21'),
(66, 78, 7, 'TESTANDO ID TRANSPORTADORA', '2024-11-18 15:19:28'),
(67, 82, 7, 'TESTANDO ID TRANSPORTADORA', '2024-11-18 15:19:34'),
(68, 83, 7, 'TESTANDO ID TRANSPORTADORA', '2024-11-18 15:19:41'),
(69, 79, 7, 'TESTANDO ID TRANSPORTADORA', '2024-11-18 15:19:49'),
(70, 80, 6, 'TESTANDO ID CONTESTACAO', '2024-11-18 15:20:45'),
(71, 81, 6, 'TESTANDO ID CONTESTACAO', '2024-11-18 15:20:48'),
(72, 84, 6, 'TESTANDO ID CONTESTACAO', '2024-11-18 15:20:51'),
(73, 85, 6, 'TESTANDO ID CONTESTACAO', '2024-11-18 15:20:54'),
(74, 86, 6, 'TESTANDO ID CONTESTACAO', '2024-11-18 15:20:57'),
(75, 82, 9, 'qwdq', '2024-11-18 15:36:27'),
(76, 83, 9, 'FINALIZANDO INDENIZAÇÃO', '2024-11-18 15:37:33'),
(77, 80, 8, 'COMO TRATADO VIA EMAIL FAVOR AUTORIZAR', '2024-11-18 15:45:44'),
(78, 81, 10, 'CANCELANDO DEVIDO NAO PROCEDER', '2024-11-18 15:45:54'),
(79, 80, 7, 'AUTORIZANDO CONFORME COMBINADO', '2024-11-18 15:50:45'),
(80, 80, 9, 'FINALIZANDO INDENIZAÇÃO', '2024-11-18 15:51:35'),
(81, 87, 8, '213', '2024-11-19 11:50:54'),
(82, 88, 8, '12', '2024-11-19 11:53:47'),
(83, 89, 8, '12', '2024-11-19 11:54:10'),
(84, 90, 8, '12', '2024-11-19 11:55:01'),
(85, 91, 8, '12', '2024-11-19 11:56:00');

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
(9, 'FATURADO'),
(10, 'INDENIZAÇÃO CANCELADA');

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
  `idsituacao` int(11) NOT NULL COMMENT '1 - PENDENTE CONFIRMAÇÂO\r\n2 - EM ANDAMENTO\r\n3 - FINALIZADO\r\n4 - RECUSADO\r\n5 - CANCELADO',
  `dataoperacao` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes_agendamentos`
--

INSERT INTO `solicitacoes_agendamentos` (`idsolicitacao`, `idcd`, `placa`, `quantidadenota`, `observacao`, `idtransportadora`, `data`, `idsituacao`, `dataoperacao`) VALUES
(28, 25, 'SAA2321', 2, 'finalizado com sucesso tmj', 22, '2024-11-08', 3, '2024-11-08'),
(29, 25, 'VAS2131', 2, 'Finalizando', 22, '2024-11-09', 3, '2024-11-08'),
(30, 25, 'ASD2313', 2, 'CANCELADO, SOLICITAR REAGENDAMENTO', 22, '2024-11-09', 3, '2024-11-08'),
(31, 25, 'WEQ2312', 12, 'CANCELANDO NOVAMENTE', 22, '2024-11-28', 5, '2024-11-18'),
(38, 25, 'WEQ2131', 12, 'CANCELANDO NOVAMENTE', 22, '2024-11-21', 5, '2024-11-18'),
(39, 25, 'EWQ2131', 12, 'CANCELANDO NOVAMENTE', 22, '2024-11-28', 5, '2024-11-18'),
(40, 25, 'RQW3123', 12, 'BELEZA ZE', 22, '2024-11-21', 3, '2024-11-18'),
(41, 25, 'WQW2131', 12, 'Cert', 22, '2024-11-28', 3, '2024-11-18');

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
  `data` date NOT NULL DEFAULT current_timestamp(),
  `observacao` varchar(255) NOT NULL,
  `idsituacao` int(11) NOT NULL,
  `idnegocio` int(11) NOT NULL,
  `numero_nota2` varchar(50) NOT NULL,
  `cnpj` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes_indenizacao`
--

INSERT INTO `solicitacoes_indenizacao` (`idsolicitacao`, `numero_nota`, `tipo_indenizacao`, `idtransportadora`, `idcd`, `data`, `observacao`, `idsituacao`, `idnegocio`, `numero_nota2`, `cnpj`) VALUES
(77, '1232131', '100%', '22', '25', '2024-11-20', 'TESTANDO ID TRANSPORTADORA', 7, 52, '1231312', '11111111111111'),
(78, '1321313', '100%', '22', '25', '2024-11-21', 'TESTANDO ID TRANSPORTADORA', 7, 52, '123131', '11111111111111'),
(79, '232132131', '100%', '22', '25', '2024-11-20', 'TESTANDO ID TRANSPORTADORA', 7, 52, '1311313', '11111111111111'),
(80, '12312311', '100%', '22', '25', '2024-11-21', 'FINALIZANDO INDENIZAÇÃO', 9, 52, '12132213', '11111111111111'),
(81, '2131231', '100%', '22', '25', '2024-11-21', 'CANCELANDO DEVIDO NAO PROCEDER', 10, 52, '2131313', NULL),
(82, '22313213', '100%', '22', '25', '2024-11-20', 'qwdq', 9, 53, '1231322', '11111111111111'),
(83, '21321213', '100%', '22', '25', '2024-11-21', 'FINALIZANDO INDENIZAÇÃO', 9, 53, '2131323', '11111111111111'),
(84, '21312312', '100%', '22', '25', '2024-11-21', 'TESTANDO ID CONTESTACAO', 6, 53, '23213321', NULL),
(85, '23212', '100%', '22', '25', '2024-11-28', 'TESTANDO ID CONTESTACAO', 6, 53, '2323213', NULL),
(86, '21323123', '100%', '22', '25', '2024-11-28', 'TESTANDO ID CONTESTACAO', 6, 53, '11131132', NULL),
(87, '31232132', '30%', '24', '25', '2024-11-29', '213', 8, 53, '323233', NULL),
(88, '1233321', '30%', '22', '26', '2024-11-21', '12', 8, 53, '23131', NULL),
(89, '213123', '100%', '22', '26', '2024-11-27', '12', 8, 52, '123213', NULL),
(90, '312312', '100%', '24', '25', '2024-11-28', '12', 8, 52, '321313', NULL),
(91, '21323', '30%', '22', '25', '2024-11-21', '12', 8, 52, '232313', NULL);

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
(42, 'Jurandir', 'jurandir.123', '7e246b7e60e825d99c65351fdd25752d', 4, 52, 1),
(43, 'Vitoria', 'vitoria.xavier', '7e246b7e60e825d99c65351fdd25752d', 5, 53, 1),
(44, 'Claudia', 'claudia.lira', '7e246b7e60e825d99c65351fdd25752d', 6, 54, 1),
(45, 'Bianca', 'bianca.campos', '7e246b7e60e825d99c65351fdd25752d', 7, 55, 1),
(46, 'Amanda', 'amanda.123', '7e246b7e60e825d99c65351fdd25752d', 2, 24, 1),
(47, 'Ketson', 'ketson.alfa', '7e246b7e60e825d99c65351fdd25752d', 2, 23, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anexo`
--
ALTER TABLE `anexo`
  ADD PRIMARY KEY (`idmovimento`);

--
-- Índices de tabela `filial`
--
ALTER TABLE `filial`
  ADD PRIMARY KEY (`idfilial`);

--
-- Índices de tabela `movimento_solicitacoes`
--
ALTER TABLE `movimento_solicitacoes`
  ADD PRIMARY KEY (`idmovimento`);

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
-- AUTO_INCREMENT de tabela `anexo`
--
ALTER TABLE `anexo`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de tabela `filial`
--
ALTER TABLE `filial`
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `movimento_solicitacoes`
--
ALTER TABLE `movimento_solicitacoes`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `solicitacoes_indenizacao`
--
ALTER TABLE `solicitacoes_indenizacao`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
