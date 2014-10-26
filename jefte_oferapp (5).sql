-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17-Out-2014 às 16:39
-- Versão do servidor: 5.6.15-log
-- PHP Version: 5.3.29

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
  `email` varchar(250) NOT NULL,
  `login` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `cnpj-cpf` varchar(50) NOT NULL,
  `statos` enum('on','off') NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `cidade` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `level` enum('superadmin','admin') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`id`, `nome`, `email`, `login`, `senha`, `cnpj-cpf`, `statos`, `telefone`, `celular`, `cidade`, `estado`, `level`) VALUES
(1, 'Netyul', '', 'netyul', '**987jft', '', 'on', '', '', 0, 0, 'superadmin'),
(2, 'Root', '', 'root', 'oferapp2014', '', 'on', '', '', 0, 0, 'superadmin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `busca`
--

CREATE TABLE IF NOT EXISTS `busca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `busca` text CHARACTER SET latin1 NOT NULL,
  `veses` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id`, `nome`, `id_uf`) VALUES
(1, 'itabuna', 1),
(2, 'ilheus', 1),
(4, 'Salvador', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clicado`
--

CREATE TABLE IF NOT EXISTS `clicado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_clik` int(11) NOT NULL,
  `id_user_clicado` int(11) NOT NULL,
  `id_ganhar_presente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sigla` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`id`, `nome`, `sigla`) VALUES
(1, 'Bahia', 'BA'),
(2, 'São Paulo', 'SP'),
(3, 'Acre', 'AC'),
(4, 'Alagoas', 'AL'),
(5, 'Amapá', 'AP'),
(6, 'Amazonas', 'AM'),
(7, 'Ceará', 'CE'),
(8, 'Distrito Federal', 'DF'),
(9, 'Espírito Santo', 'ES'),
(10, 'Goiás', 'GO'),
(11, 'Maranhão', 'MA'),
(12, 'Mato Grosso', 'MT'),
(13, 'Mato Grosso do Sul', 'MS'),
(14, 'Minas Gerais', 'MG'),
(15, 'Pará', 'PA'),
(16, 'Paraíba', 'PB'),
(17, 'Paraná', 'PR'),
(18, 'Pernambuco', 'PE'),
(19, 'Piauí', 'PI'),
(20, 'Rio de Janeiro', 'RJ'),
(21, 'Rio Grande do Norte', 'RN'),
(22, 'Rio Grande do Sul', 'RS'),
(23, 'Rondônia', 'RO'),
(24, 'Roraima', 'RR'),
(25, 'Santa Catarina', 'SC'),
(26, 'Sergipe', 'SE'),
(27, 'Tocantins', 'TO'),
(28, 'Acre', 'AC'),
(29, 'Alagoas', 'AL'),
(30, 'Amapá', 'AP'),
(31, 'Amazonas', 'AM'),
(32, 'Ceará', 'CE'),
(33, 'Distrito Federal', 'DF'),
(34, 'Espírito Santo', 'ES'),
(35, 'Goiás', 'GO'),
(36, 'Maranhão', 'MA'),
(37, 'Mato Grosso', 'MT'),
(38, 'Mato Grosso do Sul', 'MS'),
(39, 'Minas Gerais', 'MG'),
(40, 'Pará', 'PA'),
(41, 'Paraíba', 'PB'),
(42, 'Paraná', 'PR'),
(43, 'Pernambuco', 'PE'),
(44, 'Piauí', 'PI'),
(45, 'Rio de Janeiro', 'RJ'),
(46, 'Rio Grande do Norte', 'RN'),
(47, 'Rio Grande do Sul', 'RS'),
(48, 'Rondônia', 'RO'),
(49, 'Roraima', 'RR'),
(50, 'Santa Catarina', 'SC'),
(51, 'Sergipe', 'SE'),
(52, 'Tocantins', 'TO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ganharpresente`
--

CREATE TABLE IF NOT EXISTS `ganharpresente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_presente` int(11) NOT NULL,
  `cliks` int(11) NOT NULL,
  `datacadidatura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `lojista`
--

CREATE TABLE IF NOT EXISTS `lojista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeEmpresa` varchar(500) NOT NULL,
  `nomeResponsavel` varchar(500) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(12) NOT NULL,
  `endereco` varchar(500) NOT NULL,
  `bairro` varchar(250) NOT NULL,
  `cidade` int(11) NOT NULL,
  `cep` varchar(13) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `tipoLojista` enum('fisica','Juridica') NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `img` varchar(35) NOT NULL,
  `nomeFantasia` varchar(50) NOT NULL,
  `statos` enum('on','off') NOT NULL,
  `id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_lojista` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL,
  `visualizado` enum('yes','not') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `quantidade` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `img` varchar(35) NOT NULL,
  `video` varchar(500) NOT NULL,
  `destaque` enum('sim','não') NOT NULL,
  `visualizacoes` int(11) NOT NULL,
  `id_lojista` int(11) NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `presentes`
--

CREATE TABLE IF NOT EXISTS `presentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `img` varchar(35) NOT NULL,
  `id_lojista` int(11) NOT NULL,
  `datatermino` varchar(10) NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rec_notificacao`
--

CREATE TABLE IF NOT EXISTS `rec_notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_lojista` int(11) NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes`
--

CREATE TABLE IF NOT EXISTS `solicitacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `vendido` enum('not','yes') NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_lojista` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabloide`
--

CREATE TABLE IF NOT EXISTS `tabloide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `img` varchar(32) NOT NULL,
  `destaque` enum('sim','não') NOT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_lojista` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
