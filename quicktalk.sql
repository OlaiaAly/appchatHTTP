-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Abr-2023 às 21:06
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quicktalk`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `chat`
--

CREATE TABLE `chat` (
  `Id` int(11) NOT NULL,
  `Sender` int(11) NOT NULL,
  `Reciever` int(11) NOT NULL,
  `Message` varchar(500) NOT NULL,
  `Image` varchar(1000) NOT NULL,
  `Creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `chat`
--

-- INSERT INTO `chat` (`Id`, `Sender`, `Reciever`, `Message`, `Image`, `Creation`) VALUES
-- (2, 5, 2, 'KMK', '', '2023-04-22 08:52:20'),
-- (3, 5, 2, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis ipsa nam necessitatibus, optio eveniet ullam sequi in eum minima magni corrupti voluptatem esse et! Labore molestiae blanditiis error. Excepturi, iusto.', '', '2023-04-22 08:56:06'),
-- (4, 5, 2, 'lll', '', '2023-04-22 09:28:47'),
-- (5, 5, 2, '', 'c171329326000e08015f437b57a97feb.jpg', '2023-04-22 09:30:35'),
-- (6, 5, 2, '', 'c9a4aab8a56a9479f1fca3320fd83d6b.jpg', '2023-04-22 09:35:16'),
-- (7, 5, 2, '', '7784cabf0b7175c1fe65033df9e53d68.jpg', '2023-04-22 09:35:28'),
-- (8, 5, 2, 'kkk', '', '2023-04-22 09:37:18'),
-- (9, 5, 2, 'KMK', '', '2023-04-22 09:37:27'),
-- (10, 2, 5, 'Na boa???', '', '2023-04-22 09:37:33'),
-- (11, 5, 2, 'nice', '', '2023-04-22 09:48:13'),
-- (12, 2, 5, 'eai??', '', '2023-04-22 09:48:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conversations`
--

CREATE TABLE `conversations` (
  `Id` int(11) NOT NULL,
  `MainUser` int(11) NOT NULL,
  `OtherUser` int(11) NOT NULL,
  `Unread` varchar(1) NOT NULL DEFAULT 'n',
  `Modification` timestamp NOT NULL DEFAULT current_timestamp(),
  `Creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `conversations`
--

INSERT INTO `conversations` (`Id`, `MainUser`, `OtherUser`, `Unread`, `Modification`, `Creation`) VALUES
(9, 5, 2, 'y', '2023-04-22 07:48:19', '2023-04-22 08:28:22'),
(10, 2, 5, 'y', '2023-04-22 07:48:13', '2023-04-22 08:28:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Username` varchar(15) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(70) NOT NULL,
  `Picture` varchar(1000) NOT NULL DEFAULT 'user.jpg',
  `Online` datetime NOT NULL,
  `Token` varchar(100) NOT NULL,
  `Secure` bigint(11) NOT NULL,
  `Creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`Id`, `Username`, `Email`, `Password`, `Picture`, `Online`, `Token`, `Secure`, `Creation`) VALUES
(2, 'Tino Vambo', 'tino@lostenfound.com', '$2y$10$EO6x4J/7SGjdUYIM9oS3suwBg38ij.imgFWTElXLFHH7pYIb6Po/u', '43aa23bc65e84626a3bb6f19c23e5c65.jpg', '2023-04-22 11:02:58', '8e196c7754df3c94ea4a3addb13ba1be1e44baab', 9001327478, '2023-04-17 03:34:04'),
(5, 'Aly OLaia', 'olaiaaly@gmail.com', '$2y$10$H.ED1bfAsTyApI9zxPUg.eg4Y/ol8kQqhlvqaNVNXWvxq4xt5gxfG', 'd2a57dec4f922e3f7498df499e9fe126.jpg', '2023-04-23 03:57:27', 'bfc6372f19e58c4016bf5cf13efb712ff4acb588', 20811752715, '2023-04-22 08:27:12');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chat`
--
ALTER TABLE `chat`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `conversations`
--
ALTER TABLE `conversations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
