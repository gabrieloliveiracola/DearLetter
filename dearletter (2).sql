-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Jan-2024 às 16:50
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dearletter`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bilhete`
--

CREATE TABLE `bilhete` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `texto` varchar(100) DEFAULT NULL,
  `cor` varchar(10) DEFAULT NULL,
  `destinatario` varchar(20) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `bilhete`
--

INSERT INTO `bilhete` (`id`, `idUser`, `texto`, `cor`, `destinatario`, `data`, `hora`) VALUES
(77, 132, 'te amo <3', '#ff0059', 'Mirella', '2023-11-30', '09:33:35'),
(78, 133, 'i love you', '#ff0000', 'vini', '2023-11-30', '09:36:05'),
(85, 137, 'oi', '#e66b6b', 'Jose', '2023-12-07', '09:45:05'),
(89, 136, 'oi', '#000000', 'gabriel', '2023-12-07', '10:04:11'),
(90, 136, 'oii', '#000000', 'gabriel', '2023-12-07', '10:06:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia`
--

CREATE TABLE `denuncia` (
  `idUser` int(11) NOT NULL,
  `idBilhete` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `denuncia`
--

INSERT INTO `denuncia` (`idUser`, `idBilhete`, `motivo`) VALUES
(132, 78, 'denuncia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUser` int(11) NOT NULL,
  `cpf` char(11) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(225) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUser`, `cpf`, `nome`, `email`, `senha`, `img`) VALUES
(132, '44877096876', 'Gabriel Oliveira Cola', 'gabrieloliveiracola2005@gmail.com', '$2y$10$Oa5BCg30Id3uXVd7k1ieHOqJMM6A3ud850Sim637Un3HJ0omwcKh.', '../arquivos/1200px-Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg'),
(133, '52060396832', 'Valéria da Silva Sartório', 'valeriasartorio3@gmail.com', '$2y$10$0.klOgBV9XERyOSRuBSy3OjKcqClCEv6nBVuEg1xDsjqU0v/wQYHy', '../img/perfil.png'),
(134, '56912434894', 'Laura Gabriela Pagliuzo', 'laurapagliuzo9@gmail.com', '$2y$10$TW1GYyU.WqJCZXiWE2pRceRXGGa//G5R7O6ub1YfsyamjEA0aVOHG', '../arquivos/blog-14v.jpg'),
(135, '123.456.789', 'Jurema', 'juremalinda@gmail.com', '$2y$10$5EcB8F6J6U/uWHSMEGUvAe/jQ802I0LX.l0XeUl7SkDzjC1aAZvWi', '../img/perfil.png'),
(136, '46211827814', 'vinicius rafael do vale', 'vinirafael07@gmail.com', '$2y$10$rBbbtuLLhm7Hwl/agaW9RuSDpnoAMMF3BYTzzJRRSQWQ7eK1Kq1GK', '../arquivos/02gambarini_779-24.jpg'),
(137, '12345678914', 'fulano', 'fulano@email.com', '$2y$10$b4VG8/hh7Ys1WzSeE9gBzuITJRpgi6/t94XFRxz6l/ECxUIzZxKqO', '../arquivos/02gambarini_779-24.jpg'),
(138, '11122233344', 'Jurema', 'jurema@email.com', '$2y$10$IBhW1fFfGoj8bz/JAdfIqOKQMyzbb4me7UstVQurEXmZUhMDKv4M6', '../img/perfil.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bilhete`
--
ALTER TABLE `bilhete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Índices para tabela `denuncia`
--
ALTER TABLE `denuncia`
  ADD PRIMARY KEY (`idUser`,`idBilhete`),
  ADD KEY `idBilhete` (`idBilhete`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bilhete`
--
ALTER TABLE `bilhete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bilhete`
--
ALTER TABLE `bilhete`
  ADD CONSTRAINT `bilhete_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `usuario` (`idUser`);

--
-- Limitadores para a tabela `denuncia`
--
ALTER TABLE `denuncia`
  ADD CONSTRAINT `denuncia_ibfk_1` FOREIGN KEY (`idBilhete`) REFERENCES `bilhete` (`id`),
  ADD CONSTRAINT `denuncia_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `usuario` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
