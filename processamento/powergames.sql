-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Out-2024 às 19:26
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `powergames`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `cpf_cliente` varchar(11) NOT NULL,
  `pagamento` varchar(50) DEFAULT NULL,
  `total_venda` decimal(10,2) NOT NULL,
  `data_venda` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `dataNascimento` date NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `cpf`, `nome`, `sobrenome`, `dataNascimento`, `telefone`, `email`, `senha`) VALUES
(1, '324324234', 'Victor', 'Melo', '0000-00-00', '213213123', 'victorsilvamelo13123@hotmail.com', '$2y$10$4jJauIW1qExsGJD//m2UmO1vXlBmuwoPeLtSPih357vfllvvc51Gm');

-- --------------------------------------------------------

--
-- Estrutura da tabela `desenvolvedora`
--

CREATE TABLE `desenvolvedora` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `desenvolvedora`
--

INSERT INTO `desenvolvedora` (`id`, `nome`, `logo`) VALUES
(2, 'Sony Interactive Entertainment', 'https://exemplo.com/logos/sony.png'),
(3, 'Microsoft Game Studios', 'https://exemplo.com/logos/microsoft.png'),
(4, 'Nintendo', 'https://exemplo.com/logos/nintendo.png'),
(5, 'Ubisoft', 'https://exemplo.com/logos/ubisoft.png'),
(6, 'Electronic Arts (EA)', 'https://exemplo.com/logos/ea.png'),
(7, 'Square Enix', 'https://exemplo.com/logos/square_enix.png'),
(8, 'Capcom', 'https://exemplo.com/logos/capcom.png'),
(9, 'Bandai Namco Entertainment', 'https://exemplo.com/logos/bandai.png'),
(10, 'Sega', 'https://exemplo.com/logos/sega.png'),
(11, 'Konami', 'https://exemplo.com/logos/konami.png'),
(12, 'Bethesda Softworks', 'https://exemplo.com/logos/bethesda.png'),
(13, 'Rockstar Games', 'https://exemplo.com/logos/rockstar.png'),
(14, 'Activision Blizzard', 'https://exemplo.com/logos/activision.png'),
(15, 'CD Projekt Red', 'https://exemplo.com/logos/cdprojekt.png'),
(16, 'Take-Two Interactive', 'https://exemplo.com/logos/taketwo.png'),
(17, 'Koei Tecmo', 'https://exemplo.com/logos/koei.png'),
(18, 'Insomniac Games', 'https://exemplo.com/logos/insomniac.png'),
(19, 'FromSoftware', 'https://exemplo.com/logos/fromsoftware.png'),
(20, 'Warner Bros. Interactive Entertainment', 'https://exemplo.com/logos/warnerbros.png'),
(21, '2K Games', 'https://exemplo.com/logos/2k.png'),
(22, 'PlayGround Games', NULL),
(23, '22', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_carrinho`
--

CREATE TABLE `itens_carrinho` (
  `id` int(11) NOT NULL,
  `carrinho_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL,
  `venda_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `plataforma`
--

CREATE TABLE `plataforma` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `desenvolvedora_id` int(11) NOT NULL,
  `descricao` text DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `url_imagem` varchar(255) DEFAULT NULL,
  `desenvolvedora_nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `desenvolvedora_id`, `descricao`, `valor`, `url_imagem`, `desenvolvedora_nome`) VALUES
(2, 'Forza Horizon 5', 23, 'Corrida', '150.00', '../uploads/670ff1cf721c7_66fd88dc7deee_forza.jpg', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `id` int(11) NOT NULL,
  `cpf_cliente` varchar(11) NOT NULL,
  `data_venda` datetime NOT NULL,
  `valor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cpf_cliente` (`cpf_cliente`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `desenvolvedora`
--
ALTER TABLE `desenvolvedora`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrinho_id` (`carrinho_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices para tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venda_id` (`venda_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices para tabela `plataforma`
--
ALTER TABLE `plataforma`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desenvolvedora_id` (`desenvolvedora_id`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cpf_cliente` (`cpf_cliente`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `desenvolvedora`
--
ALTER TABLE `desenvolvedora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `plataforma`
--
ALTER TABLE `plataforma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`cpf_cliente`) REFERENCES `cliente` (`cpf`);

--
-- Limitadores para a tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD CONSTRAINT `itens_carrinho_ibfk_1` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinho` (`id`),
  ADD CONSTRAINT `itens_carrinho_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `venda` (`id`),
  ADD CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`desenvolvedora_id`) REFERENCES `desenvolvedora` (`id`);

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`cpf_cliente`) REFERENCES `cliente` (`cpf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
