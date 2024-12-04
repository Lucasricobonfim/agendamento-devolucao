-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/12/2024 às 01:35
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
-- Despejando dados para a tabela `grupos`
--

INSERT INTO `grupos` (`idgrupo`, `descricao`) VALUES
(1, 'ADMIN'),
(2, 'TRANSPORTADORA'),
(3, 'CD');

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
  `dataoperacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimento_solicitacoes`
--

INSERT INTO `movimento_solicitacoes` (`idmovimento`, `idsolicitacao`, `idsituacao`, `observacao`, `dataoperacao`) VALUES
(25, 36, 1, 'teeste', '2024-11-15 12:13:01'),
(26, 36, 4, 'recusaddaa', '2024-11-15 12:18:20'),
(27, 36, 1, 'quero reagendar para outra data', '2024-11-15 12:19:04'),
(28, 36, 2, 'aceito', '2024-11-15 12:49:19'),
(29, 36, 3, 'finalizado', '2024-11-15 12:49:40'),
(30, 37, 1, 'teste', '2024-11-15 12:52:06'),
(31, 38, 1, 'teste', '2024-11-15 12:52:47'),
(32, 37, 2, 'aceitando', '2024-11-15 12:53:55'),
(33, 38, 4, 'recusar', '2024-11-15 12:54:01'),
(34, 37, 5, 'cancelar', '2024-11-15 12:54:07'),
(35, 37, 1, 'quero reagendar essa solicitacao', '2024-11-15 12:54:50'),
(36, 38, 1, 'rewagendar recusada', '2024-11-15 12:56:44'),
(37, 39, 1, 'teste', '2024-11-23 12:38:34'),
(38, 39, 4, 'estou recusando pq n ta filé', '2024-11-23 12:39:23'),
(39, 39, 1, 'estou reagendando isso pq tal', '2024-11-23 12:40:01'),
(40, 39, 2, 'estou aceitando tmj', '2024-11-23 12:40:24'),
(41, 39, 3, 'finalizado com sucessosooo', '2024-11-23 12:40:53'),
(42, 40, 1, 'teste', '2024-12-01 21:23:52'),
(43, 37, 4, 'recusar para teste', '2024-12-01 21:25:34'),
(44, 38, 2, 'aceitar', '2024-12-01 21:26:04'),
(45, 38, 5, 'cancelado', '2024-12-01 21:26:10'),
(46, 41, 1, 'teste', '2024-12-02 22:37:54'),
(47, 37, 5, 'cacnela', '2024-12-02 22:39:08'),
(48, 42, 1, 'teste', '2024-12-02 22:40:02'),
(49, 42, 4, 'recusada', '2024-12-02 22:40:25'),
(50, 43, 1, 'teste', '2024-12-02 22:42:27'),
(51, 44, 1, 'teste', '2024-12-02 22:42:39'),
(52, 45, 1, 'teste', '2024-12-02 22:42:48'),
(53, 43, 2, 'aceitado', '2024-12-02 22:43:15'),
(54, 45, 4, 'recusada', '2024-12-02 22:43:21'),
(55, 43, 5, 'recusada', '2024-12-02 22:44:06'),
(56, 44, 4, 'recusada', '2024-12-02 22:45:30'),
(57, 46, 1, 'teste', '2024-12-02 22:45:45'),
(58, 47, 1, 'teste', '2024-12-02 22:45:51'),
(59, 48, 1, 'teste', '2024-12-02 22:46:06'),
(60, 49, 1, 'te', '2024-12-02 22:46:15'),
(61, 46, 2, 'aceitado', '2024-12-02 22:46:51'),
(62, 47, 2, 'aceitado', '2024-12-02 22:46:55'),
(63, 46, 5, 'cancelado', '2024-12-02 22:47:01'),
(64, 47, 5, 'cancelado', '2024-12-02 22:47:33'),
(65, 50, 1, '; select * from filial', '2024-12-03 00:13:52'),
(66, 51, 1, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:37:29'),
(67, 52, 1, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:40:50'),
(68, 48, 2, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:43:30'),
(69, 49, 4, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:43:44'),
(70, 50, 2, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:43:59'),
(71, 48, 5, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:44:15'),
(72, 50, 3, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-03 23:44:55'),
(73, 53, 1, 'te', '2024-12-03 23:45:37'),
(74, 42, 1, 'tste', '2024-12-03 23:49:10'),
(75, 54, 1, 'teste', '2024-12-03 23:56:09'),
(76, 55, 1, 'teste', '2024-12-03 23:56:20'),
(77, 56, 1, 'twte', '2024-12-04 00:05:29'),
(78, 57, 1, 'teste', '2024-12-04 00:06:53'),
(79, 58, 1, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '2024-12-04 00:07:15'),
(80, 59, 1, 'teste', '2024-12-04 00:10:24'),
(81, 44, 1, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', '2024-12-04 00:10:43');

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
  `observacao` varchar(500) NOT NULL,
  `idtransportadora` int(11) NOT NULL,
  `data` date NOT NULL,
  `idsituacao` int(11) NOT NULL COMMENT '1 - PENDENTE CONFIRMAÇÂO\r\n2 - EM ANDAMENTO\r\n3 - FINALIZADO\r\n4 - RECUSADO\r\n5 - CANCELADO',
  `dataoperacao` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes_agendamentos`
--

INSERT INTO `solicitacoes_agendamentos` (`idsolicitacao`, `idcd`, `placa`, `quantidadenota`, `observacao`, `idtransportadora`, `data`, `idsituacao`, `dataoperacao`) VALUES
(36, 25, 'ACA1231', 2, 'finalizado', 22, '2024-11-25', 3, '2024-11-15'),
(37, 25, 'ACA1231', 2, 'cacnela', 22, '2024-11-16', 5, '2024-11-15'),
(38, 25, 'ACA2314', 3, 'cancelado', 22, '2024-11-16', 5, '2024-11-15'),
(39, 25, 'ASD2313', 2, 'finalizado com sucessosooo', 22, '2024-11-26', 3, '2024-11-23'),
(40, 26, 'ASD2131', 2, 'teste', 22, '2024-12-02', 1, '2024-12-01'),
(41, 26, 'ASD2113', 2, 'teste', 22, '2024-12-19', 1, '2024-12-02'),
(42, 25, 'ASD2131', 23, 'tste', 22, '2024-12-12', 1, '2024-12-03'),
(43, 25, 'TES2132', 3, 'recusada', 22, '2024-12-10', 5, '2024-12-02'),
(44, 25, 'TES2133', 3, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', 22, '2024-12-19', 1, '2024-12-03'),
(45, 25, 'TES2133', 3, 'recusada', 22, '2024-12-17', 4, '2024-12-02'),
(46, 25, 'DSA2213', 3, 'cancelado', 22, '2024-12-11', 5, '2024-12-02'),
(47, 25, 'DSA2213', 3, 'cancelado', 22, '2024-12-17', 5, '2024-12-02'),
(48, 25, 'DSA2213', 3, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', 22, '2024-12-25', 5, '2024-12-02'),
(49, 25, 'TET2321', 3, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', 22, '2024-12-28', 4, '2024-12-02'),
(50, 25, 'DAS2312', 222, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', 22, '2024-12-11', 3, '2024-12-02'),
(51, 25, 'DSA2313', 33, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', 22, '2024-12-04', 1, '2024-12-03'),
(52, 26, 'DSA3213', 3, 'Lorem Ipsum é simplesmente um texto modelo da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto modelo padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.', 24, '2024-12-11', 1, '2024-12-03'),
(55, 25, 'EAE1232', 3131, 'teste', 22, '2024-12-20', 1, '2024-12-03'),
(57, 25, 'ASD3213', 3, 'teste', 22, '2024-12-18', 1, '2024-12-03'),
(58, 27, 'DAS2313', 3, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 22, '2024-12-11', 1, '2024-12-03'),
(59, 25, 'AES1231', 323, 'teste', 22, '2024-12-25', 1, '2024-12-03');

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
(28, 'Lucas Gabriel', 'lucas.gabriel', 'd90446dfb40239c2ce08a478a423e7d7', 1, 1, 1),
(29, 'Lucas Rico Bonfim', 'lucas.bonfim', '$2y$10$6.FHWJBzAtBHVBGaEVC0FuFiV1yIJKamQ0jx1auSBYdmMHCX8qHpq', 1, 1, 1),
(30, 'Robson Alves', 'robson.alves', '$2y$10$kqzb5RsbZJe8QEqEEjpIneKD7L791coY7kapE3CF.IcGTd5U/Z58G', 2, 22, 1),
(31, 'Amanda Dias', 'amanda.dias', '$2y$10$zDgaANsPcHIt4D10mdLaleBcOu6g.dpK/VxZLNOA7VdeEZpvCz8Ly', 2, 24, 1),
(32, 'Luana Delgado', 'luana.delgado', '28284886917f9a2fa6952251e64ebea3', 2, 23, 1),
(33, 'Altair Neves a', 'altair.neves', '$2y$10$k8l7Y7jevWY1ZWLR3R/iCeH3BpmpnXr1sb/K0/0oDYcszYmc0wYra', 3, 25, 1),
(34, 'Tenisson Ben', 'ben.tenisson', '7e246b7e60e825d99c65351fdd25752d', 3, 26, 1),
(35, 'Tailan Loro', 'tailan.loro', '7e246b7e60e825d99c65351fdd25752d', 3, 27, 1),
(44, 'marcelo pinto', 'marcelo.pinto', '7e246b7e60e825d99c65351fdd25752d', 2, 23, 1),
(45, 'Lucas', 'lukao.silva', 'd41d8cd98f00b204e9800998ecf8427e', 1, 1, 1),
(46, 'd', 'lucas.bonfimdss', 'd41d8cd98f00b204e9800998ecf8427e', 1, 1, 1),
(47, 'te', 'lucas.bonfimds', '299c0eb4ad959899d57ea71cf815d972', 1, 1, 1);

--
-- Índices para tabelas despejadas
--

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
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `idusuario` (`idusuario`),
  ADD KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filial`
--
ALTER TABLE `filial`
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `movimento_solicitacoes`
--
ALTER TABLE `movimento_solicitacoes`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
