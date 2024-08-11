-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/08/2024 às 16:27
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `transportadoras`
--

CREATE TABLE `transportadoras` (
  `idtransportadora` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `cnpj_cpf` varchar(14) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `transportadoras`
--

INSERT INTO `transportadoras` (`idtransportadora`, `nome`, `cnpj_cpf`, `email`, `telefone`, `status`) VALUES
(1, 'Lucas Rico Bonfim', '12.345.678/000', 'lucasricobonfim@gmail.com', '44998487185', 1),
(4, 'Lucas Rico Bonfim', '12.345.6781111', 'lucasricobonfim@gmail.com', '44998487185', 1),
(7, 'Lucas Rico Bonfim', '12345678000195', 'lucasricobonfim@gmail.com', '44998487185', 1),
(8, 'Lucas Rico Bonfim', '12345678000177', 'lucasricobonfim@gmail.com', '44998487185', 1),
(9, 'Lucas Rico Bonfim', '12345678000178', 'lucasricobonfim@gmail.com', '44998487185', 1),
(11, 'Lucas Rico Bonfim', '12345678000110', 'lucasricobonfim@gmail.com', '44998487185', 1),
(12, 'Lucas Rico Bonfim', '11331494991234', 'lucasricobonfim@gmail.com', '44998487185', 1),
(13, 'Lucas Rico Bonfim', '11331494991239', 'lucasricobonfim@gmail.com', '44998487185', 1),
(21, 'Lucas Rico Bonfim', '1133142291239', 'lucasricobonfim@gmail.com', '44998487185', 1),
(22, 'Lucas Rico Bonfim', '1133142291237', 'lucasricobonfim@gmail.com', '44998487185', 1),
(23, 'Lucas Rico Bonfim', '11331422912372', 'lucasricobonfim@gmail.com', '44998487185', 1),
(24, 'BONFIM', '12454678949122', 'bonfim@gazin.com.br', '44998487185', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `login` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `idgrupo` int(11) NOT NULL COMMENT '1 - admin\r\n2 - usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nome`, `login`, `senha`, `idgrupo`) VALUES
(1, 'Lucas Bonfim', 'kaka', '123', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `transportadoras`
--
ALTER TABLE `transportadoras`
  ADD UNIQUE KEY `idtransportadora` (`idtransportadora`),
  ADD UNIQUE KEY `cnpj_ind` (`cnpj_cpf`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `transportadoras`
--
ALTER TABLE `transportadoras`
  MODIFY `idtransportadora` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;