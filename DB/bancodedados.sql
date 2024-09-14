-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/09/2024 às 04:44
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `taskify`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clicks_diarios`
--

CREATE TABLE `clicks_diarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clicks_diarios`
--

INSERT INTO `clicks_diarios` (`id`, `usuario_id`, `data`) VALUES
(1, 1, '2024-09-13'),
(2, 3, '2024-09-13'),
(3, 4, '2024-09-13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `status` enum('todo','done') DEFAULT 'todo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `imagem_perfil` varchar(255) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `idade` int(11) DEFAULT NULL,
  `sexo` enum('Masculino','Feminino','Outro') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `senha`, `nome`, `imagem_perfil`, `data_cadastro`, `idade`, `sexo`) VALUES
(1, 'joao', 'teste@gmail.com', '$2y$10$FMWWebT86DVxvIM6y9v8auZbccedkRrBPBQge8YVTZnVYyfG0Zu62', 'joao', '../Assets/profile_images/66e4dfdebee26.png', '2024-09-11 16:23:24', NULL, NULL),
(2, 'joao', 'nao@gmail.com', '$2y$10$BXzo37Mkr1vuqYB2sLVCZ.q79mbCEkSD/ssv4x2mefyf0sf8D7/0q', NULL, NULL, '2024-09-11 17:45:22', NULL, NULL),
(3, 'joao123', 'para@gmail.com', '$2y$10$16FvCfw0Z1EuUYxafTriO.n51A/pUll8FHAnUQ3ImebEZ.NfMX7Gu', 'Geovani', '../Assets/profile_images/66e4edda76d51.png', '2024-09-11 19:10:08', 20, 'Masculino'),
(4, 'breno', 'breno@gmail.com', '$2y$10$0V9wAUuiW8DucIHg4NtKQ.mXr8Tgo2c1aKVPPjChn0uQcltNRNXay', 'Breno', '../Assets/profile_images/66e4f808e261c.png', '2024-09-14 02:41:15', 42, 'Masculino');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clicks_diarios`
--
ALTER TABLE `clicks_diarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id_data` (`usuario_id`,`data`);

--
-- Índices de tabela `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clicks_diarios`
--
ALTER TABLE `clicks_diarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `clicks_diarios`
--
ALTER TABLE `clicks_diarios`
  ADD CONSTRAINT `clicks_diarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
