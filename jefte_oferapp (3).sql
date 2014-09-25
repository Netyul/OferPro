-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Set-2014 às 08:24
-- Versão do servidor: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jefte_oferapp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `sobrenome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `login` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `cnpj-cpf` varchar(50) NOT NULL,
  `statos` enum('off','on') NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `celular` varchar(13) NOT NULL,
  `cidade` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`id`, `nome`, `sobrenome`, `email`, `login`, `senha`, `cnpj-cpf`, `statos`, `telefone`, `celular`, `cidade`, `estado`) VALUES
(1, 'Netyul', '', '', 'netyul', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '', 'on', '', '', 0, 0),
(2, 'Root', '', '', 'root', '8171680b361b27e79d0327ec6e36be4033a8079e', '', 'on', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `description`, `keywords`, `datacadastro`) VALUES
(1, 'Oferta', '', '', '2014-08-31 20:08:28'),
(2, 'tabloide', '', '', '2014-08-31 20:08:28'),
(3, 'sorteio', '', '', '2014-08-31 20:08:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(500) NOT NULL,
  `id_uf` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id`, `nome`, `id_uf`) VALUES
(1, 'itabuna', 1),
(2, 'ilheus', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sigla` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`id`, `nome`, `sigla`) VALUES
(1, 'Bahia', 'ba'),
(2, 'São Paulo', 'sp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `home-oferapp`
--

CREATE TABLE IF NOT EXISTS `home-oferapp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `Titulo` varchar(200) NOT NULL,
  `slogan` varchar(500) NOT NULL,
  `meta-keywords` text NOT NULL,
  `meta-description` text NOT NULL,
  `carregar-inicial` int(11) NOT NULL,
  `link-facebook` varchar(300) NOT NULL,
  `link-google` varchar(300) NOT NULL,
  `link-youtube` varchar(300) NOT NULL,
  `email-contato` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `home-oferapp`
--

INSERT INTO `home-oferapp` (`id`, `Titulo`, `slogan`, `meta-keywords`, `meta-description`, `carregar-inicial`, `link-facebook`, `link-google`, `link-youtube`, `email-contato`) VALUES
(1, 'OferApp', 'As ofertas mais próximas em suas mãos!', 'Ofertas de Produtos, Ofertas de Serviços, Ofertas e Promoções, Oferapp, Ofertas próximas de você ', 'Não bata pernas, não perca tempo, as ofertas mais próximas em suas mãos só aqui na OferApp!', 12, '', '', '', 'jefteamorim@netyul.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lojista`
--

CREATE TABLE IF NOT EXISTS `lojista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome-empresa` varchar(500) NOT NULL,
  `nome-responsavel` varchar(500) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(12) NOT NULL,
  `endereco` varchar(500) NOT NULL,
  `bairro` varchar(250) NOT NULL,
  `cidade` int(11) NOT NULL,
  `cep` varchar(13) NOT NULL,
  `cpf-cnpj` varchar(20) NOT NULL,
  `tipo-lojista` enum('fisica','Juridica') NOT NULL,
  `telefone` varchar(10) NOT NULL,
  `celular` varchar(11) NOT NULL,
  `img` varchar(32) NOT NULL,
  `nome-fantasia` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `lojista`
--

INSERT INTO `lojista` (`id`, `nome-empresa`, `nome-responsavel`, `email`, `senha`, `endereco`, `bairro`, `cidade`, `cep`, `cpf-cnpj`, `tipo-lojista`, `telefone`, `celular`, `img`, `nome-fantasia`) VALUES
(1, 'OferApp', 'Jefté Amorim da costa', 'jefteamorim@gmail.com', 'c612b5d831ba', 'avenida paulista, 34', 'centro', 2, '05880330', '14444444/0001-00', 'fisica', '1128219526', '11951208689', 'tabloide.jpg', 'OferApp'),
(2, 'OferApp', 'Jefté Amorim da costa', 'jefteamorim@gmail.com', 'c612b5d831ba', 'avenida paulista, 34', 'centro', 2, '05880330', '14444444/0001-00', 'fisica', '1128219526', '11951208689', 'tabloide.jpg', 'OferApp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `oferapp`
--

CREATE TABLE IF NOT EXISTS `oferapp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `titulo` varchar(200) COLLATE utf8_bin NOT NULL,
  `slogan` varchar(500) COLLATE utf8_bin NOT NULL,
  `keywords` varchar(500) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin NOT NULL,
  `generation` varchar(100) COLLATE utf8_bin NOT NULL,
  `autor` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `oferapp`
--

INSERT INTO `oferapp` (`id`, `titulo`, `slogan`, `keywords`, `description`, `generation`, `autor`, `email`) VALUES
(0, 'OferApp', 'As ofertas mais próximas em suas mãos!', 'Ofertas de Produtos, Ofertas de Serviços, Ofertas e Promoções, Oferapp, Ofertas próximas de você ', 'Não bata pernas, não perca tempo, as ofertas mais próximas em suas mãos só aqui na OferApp!', 'Netyul', 'Jefte Amorim da Costa', 'jefteamorim@netyul.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ofertas`
--

CREATE TABLE IF NOT EXISTS `ofertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `tipo` enum('serviço','produto') NOT NULL,
  `descricao` text NOT NULL,
  `qunatidade` int(11) NOT NULL,
  `valor` varchar(9) NOT NULL,
  `img` varchar(32) NOT NULL,
  `video` varchar(500) NOT NULL,
  `destaque` enum('sim','não') NOT NULL,
  `id_lojista` int(11) NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Extraindo dados da tabela `ofertas`
--

INSERT INTO `ofertas` (`id`, `titulo`, `tipo`, `descricao`, `qunatidade`, `valor`, `img`, `video`, `destaque`, `id_lojista`, `datacadastro`) VALUES
(1, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:46:36'),
(2, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:46:51'),
(3, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(4, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(5, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(6, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(7, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(8, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(9, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(10, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(11, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(12, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(13, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(14, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(15, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(16, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(17, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(18, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(19, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(20, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(21, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(22, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(23, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(24, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(25, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(26, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(27, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(28, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(29, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(30, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(31, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(32, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(33, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(34, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(35, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00'),
(36, 'OferApp Ofertas', 'serviço', 'OferApp fornece a você a melhor solução para anunciar seus serviços e negócios na web e Mobile ', 1, '45,00', 'tabloide.jpg', '', 'sim', 1, '2014-09-05 10:48:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sorteios`
--

CREATE TABLE IF NOT EXISTS `sorteios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(200) NOT NULL,
  `tipo` enum('serviço',' produtos') NOT NULL,
  `descricao` text NOT NULL,
  `img` varchar(32) NOT NULL,
  `datasorteio` varchar(10) NOT NULL,
  `destaque` enum('sim','não') NOT NULL,
  `id_lojista` int(11) NOT NULL,
  `datacadasto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabloide`
--

CREATE TABLE IF NOT EXISTS `tabloide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `tipo` enum('produto','serviço') NOT NULL,
  `descricao` text NOT NULL,
  `img` varchar(32) NOT NULL,
  `destaque` enum('sim','não') NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_lojista` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `datanascimento` varchar(10) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `celular` varchar(13) NOT NULL,
  `sexo` enum('feminino','masculino') NOT NULL,
  `estatos` enum('ativada','desativada') NOT NULL,
  `img` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `datanascimento`, `senha`, `celular`, `sexo`, `estatos`, `img`) VALUES
(1, 'admim oferapp', 'admin@admin.com.br', '', 'd033e22ae348aeb5660fc2140aec35850c4da997', '', 'feminino', 'ativada', ''),
(2, 'admin2', 'admin2', '11/11/1111', '123', '1111111111', 'masculino', 'ativada', ''),
(3, 'Jefte Amorim  da Costa', 'jefteamorim@gmail.com', '11/02/1991', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '11951208689', 'masculino', 'ativada', ''),
(20, 'gisele lira dos santos', 'giselemaclyra@gmail.com', '05/10/1998', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '11951208689', 'feminino', 'ativada', ''),
(19, 'Jefte Amorim  da Costa', 'sdfsdfsd@zcvvdzvdv.br', '26/08/1998', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '11951208689', 'masculino', 'ativada', ''),
(16, 'Jefte Amorim  da Costa', 'jefteamorim@netyul.com.br', '11/02/1991', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '1111111111', 'masculino', 'ativada', ''),
(17, 'Jefte Amorim  da Costa', 'gisele-lira2012@hotmail.com', '01/02/1999', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '1111111111', 'feminino', 'ativada', ''),
(18, 'Jefte Amorim  da Costa', 'sdfsdfsd@zcvvdzvdv.vd', '01/02/1999', '65d9a5fb5f9fb065f1d59275ed32c30f4a6e3977', '1111111111', 'masculino', 'ativada', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
