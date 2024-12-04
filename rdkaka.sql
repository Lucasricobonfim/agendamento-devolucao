-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/12/2024 às 18:21
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
(47, 41, 1, 'Seguiremos a devolução na data informada as 18:00\nNome do Condutor: Rogerio Andrade\nUm dos volumes está indo trocados. ', '2024-12-04 12:42:22'),
(48, 41, 2, 'Ok, agendado', '2024-12-04 12:52:20'),
(49, 41, 5, 'Estou cancelando devido atraso na devolução', '2024-12-04 12:52:47'),
(50, 41, 1, 'Estaremos encaminhando novamente', '2024-12-04 12:54:14'),
(51, 41, 2, 'Aceito, espero que finalize tudo certo', '2024-12-04 12:55:44'),
(52, 41, 3, 'Finalizado', '2024-12-04 12:57:05'),
(53, 42, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:02'),
(54, 43, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:13'),
(55, 44, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:21'),
(56, 45, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:30'),
(57, 46, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:37'),
(58, 47, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:44'),
(59, 48, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:28:52'),
(60, 49, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:29:02'),
(61, 50, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:29:13'),
(62, 51, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:29:21'),
(63, 52, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:29:30'),
(64, 53, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:29:43'),
(65, 54, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:29:52'),
(66, 55, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:02'),
(67, 56, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:12'),
(68, 57, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:20'),
(69, 58, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:27'),
(70, 59, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:35'),
(71, 60, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:43'),
(72, 61, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:50'),
(73, 62, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:30:58'),
(74, 63, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:07'),
(75, 64, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:16'),
(76, 65, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:24'),
(77, 66, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:31'),
(78, 67, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:40'),
(79, 68, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:48'),
(80, 69, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:31:55'),
(81, 70, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:32:02'),
(82, 71, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:32:10'),
(83, 72, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:32:21'),
(84, 73, 1, '12', '2024-12-04 16:33:40'),
(85, 74, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:33:59'),
(86, 75, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:07'),
(87, 76, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:15'),
(88, 77, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:22'),
(89, 78, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:31'),
(90, 79, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:40'),
(91, 80, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:51'),
(92, 81, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:34:58'),
(93, 82, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:35:05'),
(94, 83, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:35:12'),
(95, 84, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:35:18'),
(96, 85, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:36:07'),
(97, 86, 1, 'Condutor: Rogerio Andrade, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:36:14'),
(98, 87, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:36:40'),
(99, 88, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:36:47'),
(100, 89, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:36:54'),
(101, 90, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:00'),
(102, 91, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:09'),
(103, 92, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:21'),
(104, 93, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:29'),
(105, 94, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:39'),
(106, 95, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:45'),
(107, 96, 1, 'Condutor: Limeiro Deungaro, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:37:51'),
(108, 97, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:39:45'),
(109, 98, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:39:54'),
(110, 99, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:01'),
(111, 100, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:07'),
(112, 101, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:14'),
(113, 102, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:20'),
(114, 103, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:26'),
(115, 104, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:32'),
(116, 105, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:39'),
(117, 106, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 16:40:51'),
(118, 42, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:41:58'),
(119, 43, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:02'),
(120, 44, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:05'),
(121, 45, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:08'),
(122, 46, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:12'),
(123, 47, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:16'),
(124, 48, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:19'),
(125, 49, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:22'),
(126, 50, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:26'),
(127, 54, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:29'),
(128, 55, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:33'),
(129, 51, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:36'),
(130, 52, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:39'),
(131, 100, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:45'),
(132, 99, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 16:42:48'),
(133, 42, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:42'),
(134, 53, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:45'),
(135, 91, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:47'),
(136, 92, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:50'),
(137, 93, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:53'),
(138, 94, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:56'),
(139, 95, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:43:59'),
(140, 43, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:44:14'),
(141, 44, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:44:19'),
(142, 96, 4, 'Não estamos disponiveis na data informada, favor reagendar.', '2024-12-04 16:44:36'),
(143, 97, 4, 'Não estamos disponiveis na data informada, favor reagendar.', '2024-12-04 16:44:39'),
(144, 98, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:44:47'),
(145, 45, 3, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', '2024-12-04 16:45:53'),
(146, 46, 3, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', '2024-12-04 16:45:59'),
(147, 47, 3, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', '2024-12-04 16:46:02'),
(148, 48, 3, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', '2024-12-04 16:46:05'),
(149, 49, 3, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', '2024-12-04 16:47:15'),
(150, 50, 3, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', '2024-12-04 16:47:18'),
(151, 51, 3, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', '2024-12-04 16:47:23'),
(152, 52, 3, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', '2024-12-04 16:47:27'),
(153, 54, 3, 'Finalizando', '2024-12-04 16:51:54'),
(154, 55, 3, 'Finalizando', '2024-12-04 16:51:58'),
(155, 98, 3, 'Finalizando', '2024-12-04 16:52:01'),
(156, 99, 3, 'Finalizando', '2024-12-04 16:52:04'),
(157, 100, 3, 'Finalizando', '2024-12-04 16:52:07'),
(158, 56, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:14'),
(159, 57, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:17'),
(160, 58, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:19'),
(161, 59, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:22'),
(162, 60, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:24'),
(163, 61, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:27'),
(164, 62, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:30'),
(165, 63, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:33'),
(166, 64, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:35'),
(167, 65, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:38'),
(168, 66, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:41'),
(169, 67, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:44'),
(170, 68, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:47'),
(171, 69, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:49'),
(172, 72, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:55'),
(173, 85, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:53:58'),
(174, 88, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:00'),
(175, 87, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:03'),
(176, 86, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:09'),
(177, 70, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:15'),
(178, 71, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:19'),
(179, 89, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:22'),
(180, 90, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:25'),
(181, 101, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 16:54:29'),
(182, 102, 4, 'Não estamos disponiveis na data informada, favor reagendar.\n', '2024-12-04 16:54:37'),
(183, 104, 4, 'Não estamos disponíveis na data informada, favor reagendar.\n', '2024-12-04 16:54:47'),
(184, 103, 4, 'Não estamos disponiveis na data informada, favor reagendar.', '2024-12-04 16:55:50'),
(185, 105, 4, 'Não estamos disponíveis na data informada, favor reagendar.', '2024-12-04 16:56:01'),
(186, 56, 3, 'Finalizando', '2024-12-04 16:56:17'),
(187, 57, 3, 'Finalizando', '2024-12-04 16:56:21'),
(188, 58, 3, 'Finalizando', '2024-12-04 16:56:25'),
(189, 59, 3, 'Finalizando', '2024-12-04 16:56:30'),
(190, 60, 3, 'Finalizando', '2024-12-04 16:56:49'),
(191, 61, 3, 'Finalizando', '2024-12-04 16:56:55'),
(192, 62, 3, 'Finalizando', '2024-12-04 16:57:01'),
(193, 63, 3, 'Finalizando', '2024-12-04 16:57:06'),
(194, 64, 3, 'Finalizando', '2024-12-04 16:57:09'),
(195, 65, 3, 'Finalizando', '2024-12-04 16:57:13'),
(196, 66, 3, 'Finalizando', '2024-12-04 16:57:16'),
(197, 67, 3, 'Finalizando', '2024-12-04 16:57:20'),
(198, 68, 3, 'Finalizando', '2024-12-04 16:57:24'),
(199, 69, 3, 'Finalizando', '2024-12-04 16:57:28'),
(200, 70, 3, 'Finalizando', '2024-12-04 16:57:32'),
(201, 71, 3, 'Finalizando', '2024-12-04 16:57:36'),
(202, 72, 3, 'Finalizando', '2024-12-04 16:57:41'),
(203, 85, 3, 'Finalizando', '2024-12-04 16:57:44'),
(204, 86, 3, 'Finalizando', '2024-12-04 16:57:47'),
(205, 87, 3, 'Finalizando', '2024-12-04 16:57:50'),
(206, 88, 3, 'Finalizando', '2024-12-04 16:57:55'),
(207, 89, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:58:05'),
(208, 90, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:58:10'),
(209, 101, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:58:15'),
(210, 73, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:28'),
(211, 74, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:31'),
(212, 75, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:35'),
(213, 76, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:38'),
(214, 77, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:41'),
(215, 78, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:43'),
(216, 79, 2, 'Confirmado agendamento na data informada.', '2024-12-04 16:59:46'),
(217, 80, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:59:54'),
(218, 81, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 16:59:57'),
(219, 82, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 17:00:00'),
(220, 106, 4, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 17:00:06'),
(221, 83, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 17:00:19'),
(222, 84, 2, 'Confirmado agendamento na data informada. \n', '2024-12-04 17:00:25'),
(223, 73, 3, 'FINALIZANDO', '2024-12-04 17:00:34'),
(224, 74, 3, 'FINALIZANDO', '2024-12-04 17:00:37'),
(225, 75, 3, 'FINALIZANDO', '2024-12-04 17:00:41'),
(226, 76, 3, 'FINALIZANDO', '2024-12-04 17:00:47'),
(227, 77, 3, 'FINALIZANDO', '2024-12-04 17:00:51'),
(228, 78, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 17:01:02'),
(229, 79, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 17:01:05'),
(230, 83, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 17:01:08'),
(231, 84, 5, 'Cancelando devido atraso, favor reagendar.', '2024-12-04 17:01:11'),
(232, 53, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:03:46'),
(233, 80, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:04:06'),
(234, 81, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:04:13'),
(235, 82, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:04:19'),
(236, 91, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:04:28'),
(237, 92, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:04:34'),
(238, 93, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:10:35'),
(239, 94, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:10:42'),
(240, 95, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:10:49'),
(241, 96, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:10:55'),
(242, 78, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:11:07'),
(243, 79, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:11:14'),
(244, 83, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:11:20'),
(245, 84, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:11:26'),
(246, 89, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:11:31'),
(247, 97, 1, 'Estamos reagendando, por gentileza verificar', '2024-12-04 17:12:10'),
(248, 53, 2, 'Confirmado agendamento na data informada.', '2024-12-04 17:13:06'),
(249, 91, 2, 'Confirmado agendamento na data informada.', '2024-12-04 17:13:09'),
(250, 92, 2, 'Confirmado agendamento na data informada.', '2024-12-04 17:13:13'),
(251, 93, 2, 'Confirmado agendamento na data informada.', '2024-12-04 17:13:16'),
(252, 94, 2, 'Confirmado agendamento na data informada.', '2024-12-04 17:13:18'),
(253, 97, 2, 'Confirmado agendamento na data informada.', '2024-12-04 17:13:22'),
(254, 53, 3, 'FINALIZANDO', '2024-12-04 17:13:29'),
(255, 95, 2, 'FINALIZANDO', '2024-12-04 17:13:33'),
(256, 96, 2, 'FINALIZANDO', '2024-12-04 17:13:39'),
(257, 91, 3, 'FINALIZANDO', '2024-12-04 17:13:48'),
(258, 92, 3, 'FINALIZANDO', '2024-12-04 17:13:52'),
(259, 93, 3, 'FINALIZANDO', '2024-12-04 17:13:56'),
(260, 94, 3, 'FINALIZANDO', '2024-12-04 17:13:59'),
(261, 95, 3, 'FINALIZANDO', '2024-12-04 17:14:03'),
(262, 96, 3, 'FINALIZANDO', '2024-12-04 17:14:18'),
(263, 97, 3, 'FINALIZANDO', '2024-12-04 17:14:21'),
(264, 78, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:15:13'),
(265, 79, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:15:19'),
(266, 80, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:15:22'),
(267, 81, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:15:25'),
(268, 78, 3, 'FINALIZANDO', '2024-12-04 17:15:42'),
(269, 79, 3, 'FINALIZANDO', '2024-12-04 17:15:47'),
(270, 80, 3, 'FINALIZANDO', '2024-12-04 17:15:50'),
(271, 81, 3, 'FINALIZANDO', '2024-12-04 17:15:54'),
(272, 82, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:16:53'),
(273, 83, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:16:55'),
(274, 84, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:16:59'),
(275, 89, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:17:29'),
(276, 107, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:17:56'),
(277, 108, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:18:04'),
(278, 109, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:18:15'),
(279, 110, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:18:22'),
(280, 111, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:18:37'),
(281, 112, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:18:47'),
(282, 113, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:18:54'),
(283, 114, 1, 'Condutor: Rodrigo Carvalho, seguiremos a devolução na data informada e chegaremos as 18:00, informo que um dos volumes está com a embalagem avariada.', '2024-12-04 17:19:01'),
(284, 107, 2, 'ACEITO', '2024-12-04 17:19:13'),
(285, 108, 2, 'ACEITO', '2024-12-04 17:19:15'),
(286, 109, 2, 'ACEITO', '2024-12-04 17:19:19'),
(287, 110, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:19:38'),
(288, 111, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:19:41'),
(289, 112, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:19:45'),
(290, 113, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:19:51'),
(291, 114, 2, 'Confirmado agendamento na data informada. ', '2024-12-04 17:19:54');

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
(41, 25, 'AAA1D13', 14, 'Finalizado', 22, '2024-12-26', 3, '2024-12-04'),
(42, 25, 'ADS1231', 12, 'Cancelando devido atraso, favor reagendar.', 22, '2024-12-10', 5, '2024-12-04'),
(43, 25, 'WQD2132', 12, 'Cancelando devido atraso, favor reagendar.', 22, '2024-12-19', 5, '2024-12-04'),
(44, 25, 'EDW2132', 12, 'Cancelando devido atraso, favor reagendar.', 22, '2024-12-20', 5, '2024-12-04'),
(45, 25, 'DWQ2132', 12, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', 22, '2024-12-28', 3, '2024-12-04'),
(46, 25, 'DQW1231', 12, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', 22, '2024-12-27', 3, '2024-12-04'),
(47, 25, 'DQQ3213', 12, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', 22, '2024-12-19', 3, '2024-12-04'),
(48, 25, 'WQD3421', 12, 'Devolução concluída, somente as notas NF: 123456 e NF: 123456 foram recusadas.', 22, '2024-12-11', 3, '2024-12-04'),
(49, 25, 'DWQ3443', 12, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', 22, '2024-12-20', 3, '2024-12-04'),
(50, 25, 'QEW1231', 32, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', 22, '2024-12-19', 3, '2024-12-04'),
(51, 25, 'WSQ4332', 12, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', 22, '2024-12-26', 3, '2024-12-04'),
(52, 25, 'EWT2334', 12, 'Devolução concluída, retornaram as notas; 123456, 213213, 31231, 1231232, 3122321, 32131, 231313.', 22, '2024-12-19', 3, '2024-12-04'),
(53, 25, 'EWQ3522', 43, 'FINALIZANDO', 22, '2024-12-18', 3, '2024-12-04'),
(54, 25, 'REW1312', 1231, 'Finalizando', 22, '2024-12-27', 3, '2024-12-04'),
(55, 25, 'EWQ2442', 123, 'Finalizando', 22, '2024-12-17', 3, '2024-12-04'),
(56, 26, 'EYH2342', 12, 'Finalizando', 22, '2024-12-13', 3, '2024-12-04'),
(57, 26, 'EQW2411', 13, 'Finalizando', 22, '2024-12-13', 3, '2024-12-04'),
(58, 26, 'EWQ1244', 12, 'Finalizando', 22, '2024-12-13', 3, '2024-12-04'),
(59, 26, 'DWQ4545', 12, 'Finalizando', 22, '2024-12-13', 3, '2024-12-04'),
(60, 26, 'WQD5465', 12, 'Finalizando', 22, '2024-12-20', 3, '2024-12-04'),
(61, 26, 'WQY6754', 12, 'Finalizando', 22, '2024-12-12', 3, '2024-12-04'),
(62, 26, 'FWE3523', 12, 'Finalizando', 22, '2024-12-25', 3, '2024-12-04'),
(63, 26, 'DQW6T45', 12, 'Finalizando', 22, '2024-12-13', 3, '2024-12-04'),
(64, 26, 'EWQ4532', 12, 'Finalizando', 22, '2024-12-21', 3, '2024-12-04'),
(65, 26, 'EWQ5435', 12, 'Finalizando', 22, '2024-12-19', 3, '2024-12-04'),
(66, 26, 'EWQ5432', 12, 'Finalizando', 22, '2024-12-23', 3, '2024-12-04'),
(67, 26, 'EQE2134', 12, 'Finalizando', 22, '2024-12-16', 3, '2024-12-04'),
(68, 26, 'DWQ4345', 12, 'Finalizando', 22, '2024-12-30', 3, '2024-12-04'),
(69, 26, 'DWQ4321', 12, 'Finalizando', 22, '2024-12-25', 3, '2024-12-04'),
(70, 26, 'DWQ4213', 12, 'Finalizando', 22, '2024-12-30', 3, '2024-12-04'),
(71, 26, 'EWQ5435', 12, 'Finalizando', 22, '2024-12-23', 3, '2024-12-04'),
(72, 26, 'WQE1231', 12, 'Finalizando', 22, '2024-12-20', 3, '2024-12-04'),
(73, 27, 'WQE1231', 12, 'FINALIZANDO', 23, '2024-12-18', 3, '2024-12-04'),
(74, 27, 'EWE1231', 12, 'FINALIZANDO', 23, '2024-12-25', 3, '2024-12-04'),
(75, 27, 'DEW2131', 12, 'FINALIZANDO', 23, '2024-12-19', 3, '2024-12-04'),
(76, 27, 'WQD3123', 12, 'FINALIZANDO', 23, '2024-12-28', 3, '2024-12-04'),
(77, 27, 'DWQ4211', 12, 'FINALIZANDO', 23, '2024-12-27', 3, '2024-12-04'),
(78, 27, 'DQD4141', 12, 'FINALIZANDO', 23, '2024-12-18', 3, '2024-12-04'),
(79, 27, 'EEE1241', 12, 'FINALIZANDO', 23, '2024-12-18', 3, '2024-12-04'),
(80, 27, 'EWQ1233', 12, 'FINALIZANDO', 23, '2024-12-19', 3, '2024-12-04'),
(81, 27, 'WDQ2131', 12, 'FINALIZANDO', 23, '2024-12-19', 3, '2024-12-04'),
(82, 27, 'WEQ2132', 12, 'Confirmado agendamento na data informada. ', 23, '2024-12-19', 2, '2024-12-04'),
(83, 27, 'DQD3213', 12, 'Confirmado agendamento na data informada. ', 23, '2024-12-10', 2, '2024-12-04'),
(84, 27, 'EWQ2132', 12, 'Confirmado agendamento na data informada. ', 23, '2024-12-09', 2, '2024-12-04'),
(85, 26, 'QWD2131', 12, 'Finalizando', 23, '2024-12-19', 3, '2024-12-04'),
(86, 26, 'EWQ1232', 21, 'Finalizando', 23, '2024-12-19', 3, '2024-12-04'),
(87, 26, 'WQQ1232', 132, 'Finalizando', 23, '2024-12-25', 3, '2024-12-04'),
(88, 26, 'DWQ2312', 12, 'Finalizando', 23, '2024-12-21', 3, '2024-12-04'),
(89, 26, 'DWQ3213', 12, 'Confirmado agendamento na data informada. ', 23, '2024-12-25', 2, '2024-12-04'),
(90, 26, 'WDE2131', 12, 'Cancelando devido atraso, favor reagendar.', 23, '2024-12-27', 5, '2024-12-04'),
(91, 25, 'EWE2143', 12, 'FINALIZANDO', 23, '2024-12-20', 3, '2024-12-04'),
(92, 25, 'QWE3212', 12, 'FINALIZANDO', 23, '2024-12-20', 3, '2024-12-04'),
(93, 25, 'DWQ3223', 12, 'FINALIZANDO', 23, '2024-12-12', 3, '2024-12-04'),
(94, 25, 'EQE2131', 12, 'FINALIZANDO', 23, '2024-12-19', 3, '2024-12-04'),
(95, 25, 'DWQ2131', 12, 'FINALIZANDO', 23, '2024-12-11', 3, '2024-12-04'),
(96, 25, 'EDW3213', 12, 'FINALIZANDO', 23, '2024-12-19', 3, '2024-12-04'),
(97, 25, 'QWD2312', 12, 'FINALIZANDO', 24, '2024-12-20', 3, '2024-12-04'),
(98, 25, 'EEG1231', 12, 'Finalizando', 24, '2024-12-26', 3, '2024-12-04'),
(99, 25, 'EDW3212', 12, 'Finalizando', 24, '2024-12-12', 3, '2024-12-04'),
(100, 25, 'DQW4312', 12, 'Finalizando', 24, '2024-12-19', 3, '2024-12-04'),
(101, 26, 'QWD5323', 12, 'Cancelando devido atraso, favor reagendar.', 24, '2024-12-27', 5, '2024-12-04'),
(102, 26, 'QWE5233', 12, 'Não estamos disponiveis na data informada, favor reagendar.\n', 24, '2024-12-25', 4, '2024-12-04'),
(103, 26, 'DWQ4324', 12, 'Não estamos disponiveis na data informada, favor reagendar.', 24, '2024-12-12', 4, '2024-12-04'),
(104, 26, 'DQW4124', 12, 'Não estamos disponíveis na data informada, favor reagendar.\n', 24, '2024-12-19', 4, '2024-12-04'),
(105, 26, 'CON1800', 21, 'Não estamos disponíveis na data informada, favor reagendar.', 24, '2024-12-18', 4, '2024-12-04'),
(106, 27, 'QWD2131', 12, 'Cancelando devido atraso, favor reagendar.', 24, '2024-12-24', 4, '2024-12-04'),
(107, 26, 'WEQ1233', 12, 'ACEITO', 22, '2024-12-25', 2, '2024-12-04'),
(108, 26, 'QWS2321', 12, 'ACEITO', 22, '2024-12-19', 2, '2024-12-04'),
(109, 26, 'EDW1232', 12, 'ACEITO', 22, '2024-12-19', 2, '2024-12-04'),
(110, 25, 'WQD3212', 12, 'Confirmado agendamento na data informada. ', 22, '2024-12-21', 2, '2024-12-04'),
(111, 25, 'DWQ2131', 12, 'Confirmado agendamento na data informada. ', 22, '2024-12-18', 2, '2024-12-04'),
(112, 25, 'WQD3231', 12, 'Confirmado agendamento na data informada. ', 22, '2024-12-20', 2, '2024-12-04'),
(113, 25, 'DQW2131', 12, 'Confirmado agendamento na data informada. ', 22, '2024-12-20', 2, '2024-12-04'),
(114, 25, 'WQD3212', 12, 'Confirmado agendamento na data informada. ', 22, '2024-12-18', 2, '2024-12-04');

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
(36, 'Lucas Gabriel', 'lucas.gabriel', '$2y$10$Pb0IqtZ18nGMZerpVJIi6uQrWSJwgaoCcZ4qU5.R3EHXrx7cUTMC.', 1, 1, 1),
(37, 'Lucas Bonfim', 'lucas.bonfim', '$2y$10$N.QIfW6YLnrWfNufuLEo5ObovqJebwmtCvrUUlUlPwikla/05wqnu', 1, 1, 1),
(38, 'Robson Alves', 'robson.alvez', '$2y$10$fkYX3JjmtYTJwYdUJ5nEz.lKvr7TMJ1eAFluKjUtPlQ1POFFr/wrK', 2, 22, 1),
(39, 'Altair Neves', 'altair.neves', '$2y$10$npUqjAkVSlY2KYg.jekBqeXf3gng1MT2kglE5Qb6TyM59Dtjw5dzm', 3, 25, 1),
(40, 'Tenisson Geisiel', 'tenisson.geisiel', '$2y$10$3cyO/mL.KIo/ObzVjA/vxe/uL3rV56AiXnfeUk6askL1/4sU2Ho9W', 3, 26, 1),
(41, 'Tailan Gabriel', 'tailan.gabriel', '$2y$10$xsGVXge.I0shWEvwwQE6Z.AWa4NKW8uCN3Y7lwcM3XZIwG/Z5UnI.', 3, 27, 1),
(42, 'Ketson Andrade', 'ketson.andrade', '$2y$10$HQKxFv5KgKP6tpPIUdwhZufQI35cNWio.bjNe6bzeGilaGx2tNEp.', 2, 23, 1),
(43, 'Amanda Torres', 'amanda.tores', '$2y$10$5Sf5XZWQqmMk22yhuWe3JO6GK0Ud2WeAKT2AtVtjtOD8EHd.LiKH6', 2, 24, 1);

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
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filial`
--
ALTER TABLE `filial`
  MODIFY `idfilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `movimento_solicitacoes`
--
ALTER TABLE `movimento_solicitacoes`
  MODIFY `idmovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

--
-- AUTO_INCREMENT de tabela `solicitacoes_agendamentos`
--
ALTER TABLE `solicitacoes_agendamentos`
  MODIFY `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
