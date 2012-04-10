-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Tiempo de generación: 10-04-2012 a las 11:02:04
-- Versión del servidor: 5.1.53
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tubus`
--
CREATE DATABASE `tubus` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1875 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45452 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=990 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=682074 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22638 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1039 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `urbanos_interurbanos`
--

DROP TABLE IF EXISTS `urbanos_interurbanos`;
CREATE TABLE IF NOT EXISTS `urbanos_interurbanos` (
  `parada_urbano` int(11) NOT NULL,
  `parada_interurbano` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_albacete`
--
CREATE DATABASE `tubus_albacete` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_albacete`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39124 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=172 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_DropDownList1`
--

DROP TABLE IF EXISTS `trayectos_a_DropDownList1`;
CREATE TABLE IF NOT EXISTS `trayectos_a_DropDownList1` (
  `trayecto_id` varchar(255) NOT NULL,
  `DropDownList1` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_api`
--
CREATE DATABASE `tubus_api` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_api`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

DROP TABLE IF EXISTS `ciudades`;
CREATE TABLE IF NOT EXISTS `ciudades` (
  `id_ciudad` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `google_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `estado` set('enabled','disabled') NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadisticas`
--

DROP TABLE IF EXISTS `estadisticas`;
CREATE TABLE IF NOT EXISTS `estadisticas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `version` varchar(255) DEFAULT NULL,
  `formato` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `funcion` varchar(255) DEFAULT NULL,
  `parametros` text,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `peticion` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80060 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quota`
--

DROP TABLE IF EXISTS `quota`;
CREATE TABLE IF NOT EXISTS `quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `hora` varchar(255) NOT NULL,
  `requests` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7596 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `administrador` tinyint(1) NOT NULL DEFAULT '0',
  `nombre` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `estado` set('enabled','disabled') NOT NULL,
  `quota` int(11) NOT NULL DEFAULT '300',
  `creado` datetime NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;
--
-- Base de datos: `tubus_apiwiki`
--
CREATE DATABASE `tubus_apiwiki` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_apiwiki`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archive`
--

DROP TABLE IF EXISTS `archive`;
CREATE TABLE IF NOT EXISTS `archive` (
  `ar_namespace` int(11) NOT NULL DEFAULT '0',
  `ar_title` varbinary(255) NOT NULL DEFAULT '',
  `ar_text` mediumblob NOT NULL,
  `ar_comment` tinyblob NOT NULL,
  `ar_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ar_user_text` varbinary(255) NOT NULL,
  `ar_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ar_minor_edit` tinyint(4) NOT NULL DEFAULT '0',
  `ar_flags` tinyblob NOT NULL,
  `ar_rev_id` int(10) unsigned DEFAULT NULL,
  `ar_text_id` int(10) unsigned DEFAULT NULL,
  `ar_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ar_len` int(10) unsigned DEFAULT NULL,
  `ar_page_id` int(10) unsigned DEFAULT NULL,
  `ar_parent_id` int(10) unsigned DEFAULT NULL,
  KEY `name_title_timestamp` (`ar_namespace`,`ar_title`,`ar_timestamp`),
  KEY `usertext_timestamp` (`ar_user_text`,`ar_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varbinary(255) NOT NULL,
  `cat_pages` int(11) NOT NULL DEFAULT '0',
  `cat_subcats` int(11) NOT NULL DEFAULT '0',
  `cat_files` int(11) NOT NULL DEFAULT '0',
  `cat_hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_title` (`cat_title`),
  KEY `cat_pages` (`cat_pages`)
) ENGINE=InnoDB DEFAULT CHARSET=binary AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorylinks`
--

DROP TABLE IF EXISTS `categorylinks`;
CREATE TABLE IF NOT EXISTS `categorylinks` (
  `cl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `cl_to` varbinary(255) NOT NULL DEFAULT '',
  `cl_sortkey` varbinary(70) NOT NULL DEFAULT '',
  `cl_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `cl_from` (`cl_from`,`cl_to`),
  KEY `cl_sortkey` (`cl_to`,`cl_sortkey`,`cl_from`),
  KEY `cl_timestamp` (`cl_to`,`cl_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `change_tag`
--

DROP TABLE IF EXISTS `change_tag`;
CREATE TABLE IF NOT EXISTS `change_tag` (
  `ct_rc_id` int(11) DEFAULT NULL,
  `ct_log_id` int(11) DEFAULT NULL,
  `ct_rev_id` int(11) DEFAULT NULL,
  `ct_tag` varbinary(255) NOT NULL,
  `ct_params` blob,
  UNIQUE KEY `change_tag_rc_tag` (`ct_rc_id`,`ct_tag`),
  UNIQUE KEY `change_tag_log_tag` (`ct_log_id`,`ct_tag`),
  UNIQUE KEY `change_tag_rev_tag` (`ct_rev_id`,`ct_tag`),
  KEY `change_tag_tag_id` (`ct_tag`,`ct_rc_id`,`ct_rev_id`,`ct_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `external_user`
--

DROP TABLE IF EXISTS `external_user`;
CREATE TABLE IF NOT EXISTS `external_user` (
  `eu_local_id` int(10) unsigned NOT NULL,
  `eu_external_id` varbinary(255) NOT NULL,
  PRIMARY KEY (`eu_local_id`),
  UNIQUE KEY `eu_external_id` (`eu_external_id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `externallinks`
--

DROP TABLE IF EXISTS `externallinks`;
CREATE TABLE IF NOT EXISTS `externallinks` (
  `el_from` int(10) unsigned NOT NULL DEFAULT '0',
  `el_to` blob NOT NULL,
  `el_index` blob NOT NULL,
  KEY `el_from` (`el_from`,`el_to`(40)),
  KEY `el_to` (`el_to`(60),`el_from`),
  KEY `el_index` (`el_index`(60))
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filearchive`
--

DROP TABLE IF EXISTS `filearchive`;
CREATE TABLE IF NOT EXISTS `filearchive` (
  `fa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fa_name` varbinary(255) NOT NULL DEFAULT '',
  `fa_archive_name` varbinary(255) DEFAULT '',
  `fa_storage_group` varbinary(16) DEFAULT NULL,
  `fa_storage_key` varbinary(64) DEFAULT '',
  `fa_deleted_user` int(11) DEFAULT NULL,
  `fa_deleted_timestamp` binary(14) DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `fa_deleted_reason` blob,
  `fa_size` int(10) unsigned DEFAULT '0',
  `fa_width` int(11) DEFAULT '0',
  `fa_height` int(11) DEFAULT '0',
  `fa_metadata` mediumblob,
  `fa_bits` int(11) DEFAULT '0',
  `fa_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `fa_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') DEFAULT 'unknown',
  `fa_minor_mime` varbinary(100) DEFAULT 'unknown',
  `fa_description` tinyblob,
  `fa_user` int(10) unsigned DEFAULT '0',
  `fa_user_text` varbinary(255) DEFAULT NULL,
  `fa_timestamp` binary(14) DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `fa_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fa_id`),
  KEY `fa_name` (`fa_name`,`fa_timestamp`),
  KEY `fa_storage_group` (`fa_storage_group`,`fa_storage_key`),
  KEY `fa_deleted_timestamp` (`fa_deleted_timestamp`),
  KEY `fa_user_timestamp` (`fa_user_text`,`fa_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=binary AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hitcounter`
--

DROP TABLE IF EXISTS `hitcounter`;
CREATE TABLE IF NOT EXISTS `hitcounter` (
  `hc_id` int(10) unsigned NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1 MAX_ROWS=25000;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `img_name` varbinary(255) NOT NULL DEFAULT '',
  `img_size` int(10) unsigned NOT NULL DEFAULT '0',
  `img_width` int(11) NOT NULL DEFAULT '0',
  `img_height` int(11) NOT NULL DEFAULT '0',
  `img_metadata` mediumblob NOT NULL,
  `img_bits` int(11) NOT NULL DEFAULT '0',
  `img_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `img_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL DEFAULT 'unknown',
  `img_minor_mime` varbinary(100) NOT NULL DEFAULT 'unknown',
  `img_description` tinyblob NOT NULL,
  `img_user` int(10) unsigned NOT NULL DEFAULT '0',
  `img_user_text` varbinary(255) NOT NULL,
  `img_timestamp` varbinary(14) NOT NULL DEFAULT '',
  `img_sha1` varbinary(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`img_name`),
  KEY `img_usertext_timestamp` (`img_user_text`,`img_timestamp`),
  KEY `img_size` (`img_size`),
  KEY `img_timestamp` (`img_timestamp`),
  KEY `img_sha1` (`img_sha1`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagelinks`
--

DROP TABLE IF EXISTS `imagelinks`;
CREATE TABLE IF NOT EXISTS `imagelinks` (
  `il_from` int(10) unsigned NOT NULL DEFAULT '0',
  `il_to` varbinary(255) NOT NULL DEFAULT '',
  UNIQUE KEY `il_from` (`il_from`,`il_to`),
  UNIQUE KEY `il_to` (`il_to`,`il_from`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interwiki`
--

DROP TABLE IF EXISTS `interwiki`;
CREATE TABLE IF NOT EXISTS `interwiki` (
  `iw_prefix` varbinary(32) NOT NULL,
  `iw_url` blob NOT NULL,
  `iw_local` tinyint(1) NOT NULL,
  `iw_trans` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `iw_prefix` (`iw_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipblocks`
--

DROP TABLE IF EXISTS `ipblocks`;
CREATE TABLE IF NOT EXISTS `ipblocks` (
  `ipb_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipb_address` tinyblob NOT NULL,
  `ipb_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ipb_by` int(10) unsigned NOT NULL DEFAULT '0',
  `ipb_by_text` varbinary(255) NOT NULL DEFAULT '',
  `ipb_reason` tinyblob NOT NULL,
  `ipb_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ipb_auto` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_anon_only` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_create_account` tinyint(1) NOT NULL DEFAULT '1',
  `ipb_enable_autoblock` tinyint(1) NOT NULL DEFAULT '1',
  `ipb_expiry` varbinary(14) NOT NULL DEFAULT '',
  `ipb_range_start` tinyblob NOT NULL,
  `ipb_range_end` tinyblob NOT NULL,
  `ipb_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_block_email` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_allow_usertalk` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipb_id`),
  UNIQUE KEY `ipb_address` (`ipb_address`(255),`ipb_user`,`ipb_auto`,`ipb_anon_only`),
  KEY `ipb_user` (`ipb_user`),
  KEY `ipb_range` (`ipb_range_start`(8),`ipb_range_end`(8)),
  KEY `ipb_timestamp` (`ipb_timestamp`),
  KEY `ipb_expiry` (`ipb_expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=binary AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job`
--

DROP TABLE IF EXISTS `job`;
CREATE TABLE IF NOT EXISTS `job` (
  `job_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_cmd` varbinary(60) NOT NULL DEFAULT '',
  `job_namespace` int(11) NOT NULL,
  `job_title` varbinary(255) NOT NULL,
  `job_params` blob NOT NULL,
  PRIMARY KEY (`job_id`),
  KEY `job_cmd` (`job_cmd`,`job_namespace`,`job_title`,`job_params`(128))
) ENGINE=InnoDB DEFAULT CHARSET=binary AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `l10n_cache`
--

DROP TABLE IF EXISTS `l10n_cache`;
CREATE TABLE IF NOT EXISTS `l10n_cache` (
  `lc_lang` varbinary(32) NOT NULL,
  `lc_key` varbinary(255) NOT NULL,
  `lc_value` mediumblob NOT NULL,
  KEY `lc_lang_key` (`lc_lang`,`lc_key`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `langlinks`
--

DROP TABLE IF EXISTS `langlinks`;
CREATE TABLE IF NOT EXISTS `langlinks` (
  `ll_from` int(10) unsigned NOT NULL DEFAULT '0',
  `ll_lang` varbinary(20) NOT NULL DEFAULT '',
  `ll_title` varbinary(255) NOT NULL DEFAULT '',
  UNIQUE KEY `ll_from` (`ll_from`,`ll_lang`),
  KEY `ll_lang` (`ll_lang`,`ll_title`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_search`
--

DROP TABLE IF EXISTS `log_search`;
CREATE TABLE IF NOT EXISTS `log_search` (
  `ls_field` varbinary(32) NOT NULL,
  `ls_value` varbinary(255) NOT NULL,
  `ls_log_id` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `ls_field_val` (`ls_field`,`ls_value`,`ls_log_id`),
  KEY `ls_log_id` (`ls_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logging`
--

DROP TABLE IF EXISTS `logging`;
CREATE TABLE IF NOT EXISTS `logging` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` varbinary(32) NOT NULL DEFAULT '',
  `log_action` varbinary(32) NOT NULL DEFAULT '',
  `log_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  `log_user` int(10) unsigned NOT NULL DEFAULT '0',
  `log_user_text` varbinary(255) NOT NULL DEFAULT '',
  `log_namespace` int(11) NOT NULL DEFAULT '0',
  `log_title` varbinary(255) NOT NULL DEFAULT '',
  `log_page` int(10) unsigned DEFAULT NULL,
  `log_comment` varbinary(255) NOT NULL DEFAULT '',
  `log_params` blob NOT NULL,
  `log_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `type_time` (`log_type`,`log_timestamp`),
  KEY `user_time` (`log_user`,`log_timestamp`),
  KEY `page_time` (`log_namespace`,`log_title`,`log_timestamp`),
  KEY `times` (`log_timestamp`),
  KEY `log_user_type_time` (`log_user`,`log_type`,`log_timestamp`),
  KEY `log_page_id_time` (`log_page`,`log_timestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=binary AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `math`
--

DROP TABLE IF EXISTS `math`;
CREATE TABLE IF NOT EXISTS `math` (
  `math_inputhash` varbinary(16) NOT NULL,
  `math_outputhash` varbinary(16) NOT NULL,
  `math_html_conservativeness` tinyint(4) NOT NULL,
  `math_html` blob,
  `math_mathml` blob,
  UNIQUE KEY `math_inputhash` (`math_inputhash`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objectcache`
--

DROP TABLE IF EXISTS `objectcache`;
CREATE TABLE IF NOT EXISTS `objectcache` (
  `keyname` varbinary(255) NOT NULL DEFAULT '',
  `value` mediumblob,
  `exptime` datetime DEFAULT NULL,
  PRIMARY KEY (`keyname`),
  KEY `exptime` (`exptime`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oldimage`
--

DROP TABLE IF EXISTS `oldimage`;
CREATE TABLE IF NOT EXISTS `oldimage` (
  `oi_name` varbinary(255) NOT NULL DEFAULT '',
  `oi_archive_name` varbinary(255) NOT NULL DEFAULT '',
  `oi_size` int(10) unsigned NOT NULL DEFAULT '0',
  `oi_width` int(11) NOT NULL DEFAULT '0',
  `oi_height` int(11) NOT NULL DEFAULT '0',
  `oi_bits` int(11) NOT NULL DEFAULT '0',
  `oi_description` tinyblob NOT NULL,
  `oi_user` int(10) unsigned NOT NULL DEFAULT '0',
  `oi_user_text` varbinary(255) NOT NULL,
  `oi_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `oi_metadata` mediumblob NOT NULL,
  `oi_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `oi_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL DEFAULT 'unknown',
  `oi_minor_mime` varbinary(100) NOT NULL DEFAULT 'unknown',
  `oi_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `oi_sha1` varbinary(32) NOT NULL DEFAULT '',
  KEY `oi_usertext_timestamp` (`oi_user_text`,`oi_timestamp`),
  KEY `oi_name_timestamp` (`oi_name`,`oi_timestamp`),
  KEY `oi_name_archive_name` (`oi_name`,`oi_archive_name`(14)),
  KEY `oi_sha1` (`oi_sha1`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_namespace` int(11) NOT NULL,
  `page_title` varbinary(255) NOT NULL,
  `page_restrictions` tinyblob NOT NULL,
  `page_counter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `page_is_new` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `page_random` double unsigned NOT NULL,
  `page_touched` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `page_latest` int(10) unsigned NOT NULL,
  `page_len` int(10) unsigned NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `name_title` (`page_namespace`,`page_title`),
  KEY `page_random` (`page_random`),
  KEY `page_len` (`page_len`)
) ENGINE=InnoDB  DEFAULT CHARSET=binary AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_props`
--

DROP TABLE IF EXISTS `page_props`;
CREATE TABLE IF NOT EXISTS `page_props` (
  `pp_page` int(11) NOT NULL,
  `pp_propname` varbinary(60) NOT NULL,
  `pp_value` blob NOT NULL,
  UNIQUE KEY `pp_page_propname` (`pp_page`,`pp_propname`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_restrictions`
--

DROP TABLE IF EXISTS `page_restrictions`;
CREATE TABLE IF NOT EXISTS `page_restrictions` (
  `pr_page` int(11) NOT NULL,
  `pr_type` varbinary(60) NOT NULL,
  `pr_level` varbinary(60) NOT NULL,
  `pr_cascade` tinyint(4) NOT NULL,
  `pr_user` int(11) DEFAULT NULL,
  `pr_expiry` varbinary(14) DEFAULT NULL,
  `pr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pr_id`),
  UNIQUE KEY `pr_pagetype` (`pr_page`,`pr_type`),
  KEY `pr_typelevel` (`pr_type`,`pr_level`),
  KEY `pr_level` (`pr_level`),
  KEY `pr_cascade` (`pr_cascade`)
) ENGINE=InnoDB DEFAULT CHARSET=binary AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagelinks`
--

DROP TABLE IF EXISTS `pagelinks`;
CREATE TABLE IF NOT EXISTS `pagelinks` (
  `pl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `pl_namespace` int(11) NOT NULL DEFAULT '0',
  `pl_title` varbinary(255) NOT NULL DEFAULT '',
  UNIQUE KEY `pl_from` (`pl_from`,`pl_namespace`,`pl_title`),
  UNIQUE KEY `pl_namespace` (`pl_namespace`,`pl_title`,`pl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protected_titles`
--

DROP TABLE IF EXISTS `protected_titles`;
CREATE TABLE IF NOT EXISTS `protected_titles` (
  `pt_namespace` int(11) NOT NULL,
  `pt_title` varbinary(255) NOT NULL,
  `pt_user` int(10) unsigned NOT NULL,
  `pt_reason` tinyblob,
  `pt_timestamp` binary(14) NOT NULL,
  `pt_expiry` varbinary(14) NOT NULL DEFAULT '',
  `pt_create_perm` varbinary(60) NOT NULL,
  UNIQUE KEY `pt_namespace_title` (`pt_namespace`,`pt_title`),
  KEY `pt_timestamp` (`pt_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `querycache`
--

DROP TABLE IF EXISTS `querycache`;
CREATE TABLE IF NOT EXISTS `querycache` (
  `qc_type` varbinary(32) NOT NULL,
  `qc_value` int(10) unsigned NOT NULL DEFAULT '0',
  `qc_namespace` int(11) NOT NULL DEFAULT '0',
  `qc_title` varbinary(255) NOT NULL DEFAULT '',
  KEY `qc_type` (`qc_type`,`qc_value`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `querycache_info`
--

DROP TABLE IF EXISTS `querycache_info`;
CREATE TABLE IF NOT EXISTS `querycache_info` (
  `qci_type` varbinary(32) NOT NULL DEFAULT '',
  `qci_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  UNIQUE KEY `qci_type` (`qci_type`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `querycachetwo`
--

DROP TABLE IF EXISTS `querycachetwo`;
CREATE TABLE IF NOT EXISTS `querycachetwo` (
  `qcc_type` varbinary(32) NOT NULL,
  `qcc_value` int(10) unsigned NOT NULL DEFAULT '0',
  `qcc_namespace` int(11) NOT NULL DEFAULT '0',
  `qcc_title` varbinary(255) NOT NULL DEFAULT '',
  `qcc_namespacetwo` int(11) NOT NULL DEFAULT '0',
  `qcc_titletwo` varbinary(255) NOT NULL DEFAULT '',
  KEY `qcc_type` (`qcc_type`,`qcc_value`),
  KEY `qcc_title` (`qcc_type`,`qcc_namespace`,`qcc_title`),
  KEY `qcc_titletwo` (`qcc_type`,`qcc_namespacetwo`,`qcc_titletwo`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recentchanges`
--

DROP TABLE IF EXISTS `recentchanges`;
CREATE TABLE IF NOT EXISTS `recentchanges` (
  `rc_id` int(11) NOT NULL AUTO_INCREMENT,
  `rc_timestamp` varbinary(14) NOT NULL DEFAULT '',
  `rc_cur_time` varbinary(14) NOT NULL DEFAULT '',
  `rc_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_user_text` varbinary(255) NOT NULL,
  `rc_namespace` int(11) NOT NULL DEFAULT '0',
  `rc_title` varbinary(255) NOT NULL DEFAULT '',
  `rc_comment` varbinary(255) NOT NULL DEFAULT '',
  `rc_minor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_bot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_new` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_cur_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_this_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_last_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_moved_to_ns` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_moved_to_title` varbinary(255) NOT NULL DEFAULT '',
  `rc_patrolled` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_ip` varbinary(40) NOT NULL DEFAULT '',
  `rc_old_len` int(11) DEFAULT NULL,
  `rc_new_len` int(11) DEFAULT NULL,
  `rc_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_logid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_log_type` varbinary(255) DEFAULT NULL,
  `rc_log_action` varbinary(255) DEFAULT NULL,
  `rc_params` blob,
  PRIMARY KEY (`rc_id`),
  KEY `rc_timestamp` (`rc_timestamp`),
  KEY `rc_namespace_title` (`rc_namespace`,`rc_title`),
  KEY `rc_cur_id` (`rc_cur_id`),
  KEY `new_name_timestamp` (`rc_new`,`rc_namespace`,`rc_timestamp`),
  KEY `rc_ip` (`rc_ip`),
  KEY `rc_ns_usertext` (`rc_namespace`,`rc_user_text`),
  KEY `rc_user_text` (`rc_user_text`,`rc_timestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=binary AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redirect`
--

DROP TABLE IF EXISTS `redirect`;
CREATE TABLE IF NOT EXISTS `redirect` (
  `rd_from` int(10) unsigned NOT NULL DEFAULT '0',
  `rd_namespace` int(11) NOT NULL DEFAULT '0',
  `rd_title` varbinary(255) NOT NULL DEFAULT '',
  `rd_interwiki` varbinary(32) DEFAULT NULL,
  `rd_fragment` varbinary(255) DEFAULT NULL,
  PRIMARY KEY (`rd_from`),
  KEY `rd_ns_title` (`rd_namespace`,`rd_title`,`rd_from`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision`
--

DROP TABLE IF EXISTS `revision`;
CREATE TABLE IF NOT EXISTS `revision` (
  `rev_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rev_page` int(10) unsigned NOT NULL,
  `rev_text_id` int(10) unsigned NOT NULL,
  `rev_comment` tinyblob NOT NULL,
  `rev_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rev_user_text` varbinary(255) NOT NULL DEFAULT '',
  `rev_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `rev_minor_edit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rev_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rev_len` int(10) unsigned DEFAULT NULL,
  `rev_parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`rev_id`),
  UNIQUE KEY `rev_page_id` (`rev_page`,`rev_id`),
  KEY `rev_timestamp` (`rev_timestamp`),
  KEY `page_timestamp` (`rev_page`,`rev_timestamp`),
  KEY `user_timestamp` (`rev_user`,`rev_timestamp`),
  KEY `usertext_timestamp` (`rev_user_text`,`rev_timestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=binary MAX_ROWS=10000000 AVG_ROW_LENGTH=1024 AUTO_INCREMENT=106 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `searchindex`
--

DROP TABLE IF EXISTS `searchindex`;
CREATE TABLE IF NOT EXISTS `searchindex` (
  `si_page` int(10) unsigned NOT NULL,
  `si_title` varchar(255) NOT NULL DEFAULT '',
  `si_text` mediumtext NOT NULL,
  UNIQUE KEY `si_page` (`si_page`),
  FULLTEXT KEY `si_title` (`si_title`),
  FULLTEXT KEY `si_text` (`si_text`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_stats`
--

DROP TABLE IF EXISTS `site_stats`;
CREATE TABLE IF NOT EXISTS `site_stats` (
  `ss_row_id` int(10) unsigned NOT NULL,
  `ss_total_views` bigint(20) unsigned DEFAULT '0',
  `ss_total_edits` bigint(20) unsigned DEFAULT '0',
  `ss_good_articles` bigint(20) unsigned DEFAULT '0',
  `ss_total_pages` bigint(20) DEFAULT '-1',
  `ss_users` bigint(20) DEFAULT '-1',
  `ss_active_users` bigint(20) DEFAULT '-1',
  `ss_admins` int(11) DEFAULT '-1',
  `ss_images` int(11) DEFAULT '0',
  UNIQUE KEY `ss_row_id` (`ss_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag_summary`
--

DROP TABLE IF EXISTS `tag_summary`;
CREATE TABLE IF NOT EXISTS `tag_summary` (
  `ts_rc_id` int(11) DEFAULT NULL,
  `ts_log_id` int(11) DEFAULT NULL,
  `ts_rev_id` int(11) DEFAULT NULL,
  `ts_tags` blob NOT NULL,
  UNIQUE KEY `tag_summary_rc_id` (`ts_rc_id`),
  UNIQUE KEY `tag_summary_log_id` (`ts_log_id`),
  UNIQUE KEY `tag_summary_rev_id` (`ts_rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templatelinks`
--

DROP TABLE IF EXISTS `templatelinks`;
CREATE TABLE IF NOT EXISTS `templatelinks` (
  `tl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `tl_namespace` int(11) NOT NULL DEFAULT '0',
  `tl_title` varbinary(255) NOT NULL DEFAULT '',
  UNIQUE KEY `tl_from` (`tl_from`,`tl_namespace`,`tl_title`),
  UNIQUE KEY `tl_namespace` (`tl_namespace`,`tl_title`,`tl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `text`
--

DROP TABLE IF EXISTS `text`;
CREATE TABLE IF NOT EXISTS `text` (
  `old_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_text` mediumblob NOT NULL,
  `old_flags` tinyblob NOT NULL,
  PRIMARY KEY (`old_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=binary MAX_ROWS=10000000 AVG_ROW_LENGTH=10240 AUTO_INCREMENT=106 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trackbacks`
--

DROP TABLE IF EXISTS `trackbacks`;
CREATE TABLE IF NOT EXISTS `trackbacks` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_page` int(11) DEFAULT NULL,
  `tb_title` varbinary(255) NOT NULL,
  `tb_url` blob NOT NULL,
  `tb_ex` blob,
  `tb_name` varbinary(255) DEFAULT NULL,
  PRIMARY KEY (`tb_id`),
  KEY `tb_page` (`tb_page`)
) ENGINE=InnoDB DEFAULT CHARSET=binary AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transcache`
--

DROP TABLE IF EXISTS `transcache`;
CREATE TABLE IF NOT EXISTS `transcache` (
  `tc_url` varbinary(255) NOT NULL,
  `tc_contents` blob,
  `tc_time` binary(14) NOT NULL,
  UNIQUE KEY `tc_url_idx` (`tc_url`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `updatelog`
--

DROP TABLE IF EXISTS `updatelog`;
CREATE TABLE IF NOT EXISTS `updatelog` (
  `ul_key` varbinary(255) NOT NULL,
  PRIMARY KEY (`ul_key`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varbinary(255) NOT NULL DEFAULT '',
  `user_real_name` varbinary(255) NOT NULL DEFAULT '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_newpass_time` binary(14) DEFAULT NULL,
  `user_email` tinyblob NOT NULL,
  `user_options` blob NOT NULL,
  `user_touched` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `user_token` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `user_email_authenticated` binary(14) DEFAULT NULL,
  `user_email_token` binary(32) DEFAULT NULL,
  `user_email_token_expires` binary(14) DEFAULT NULL,
  `user_registration` binary(14) DEFAULT NULL,
  `user_editcount` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=binary AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE IF NOT EXISTS `user_groups` (
  `ug_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ug_group` varbinary(16) NOT NULL DEFAULT '',
  UNIQUE KEY `ug_user_group` (`ug_user`,`ug_group`),
  KEY `ug_group` (`ug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_newtalk`
--

DROP TABLE IF EXISTS `user_newtalk`;
CREATE TABLE IF NOT EXISTS `user_newtalk` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_ip` varbinary(40) NOT NULL DEFAULT '',
  `user_last_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  KEY `user_id` (`user_id`),
  KEY `user_ip` (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_properties`
--

DROP TABLE IF EXISTS `user_properties`;
CREATE TABLE IF NOT EXISTS `user_properties` (
  `up_user` int(11) NOT NULL,
  `up_property` varbinary(32) NOT NULL,
  `up_value` blob,
  UNIQUE KEY `user_properties_user_property` (`up_user`,`up_property`),
  KEY `user_properties_property` (`up_property`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valid_tag`
--

DROP TABLE IF EXISTS `valid_tag`;
CREATE TABLE IF NOT EXISTS `valid_tag` (
  `vt_tag` varbinary(255) NOT NULL,
  PRIMARY KEY (`vt_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE IF NOT EXISTS `watchlist` (
  `wl_user` int(10) unsigned NOT NULL,
  `wl_namespace` int(11) NOT NULL DEFAULT '0',
  `wl_title` varbinary(255) NOT NULL DEFAULT '',
  `wl_notificationtimestamp` varbinary(14) DEFAULT NULL,
  UNIQUE KEY `wl_user` (`wl_user`,`wl_namespace`,`wl_title`),
  KEY `namespace_title` (`wl_namespace`,`wl_title`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
--
-- Base de datos: `tubus_b`
--
CREATE DATABASE `tubus_b` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_b`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=228 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195169 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1381 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2569 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_bi`
--
CREATE DATABASE `tubus_bi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_bi`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94918 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=483 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_co`
--
CREATE DATABASE `tubus_co` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_co`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130182 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=974 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=500 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_do`
--
CREATE DATABASE `tubus_do` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_do`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95228 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=173 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=486 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_elche`
--
CREATE DATABASE `tubus_elche` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_elche`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76817 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=926 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=314 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_gijon`
--
CREATE DATABASE `tubus_gijon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_gijon`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=169922 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=353 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=609 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_guipuzcoa`
--
CREATE DATABASE `tubus_guipuzcoa` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_guipuzcoa`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=316107 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=180 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1375 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=340 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_jaen`
--
CREATE DATABASE `tubus_jaen` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_jaen`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=173 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_layar`
--
CREATE DATABASE `tubus_layar` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_layar`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACTION_Table`
--

DROP TABLE IF EXISTS `ACTION_Table`;
CREATE TABLE IF NOT EXISTS `ACTION_Table` (
  `poiID` int(11) NOT NULL,
  `label` varchar(30) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `autoTriggerRange` int(10) DEFAULT NULL,
  `autoTriggerOnly` tinyint(1) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `contentType` varchar(255) DEFAULT 'application/vnd.layar.internal',
  `method` enum('GET','POST') DEFAULT 'GET',
  `activityType` int(2) DEFAULT NULL,
  `params` varchar(255) DEFAULT NULL,
  `closeBiw` tinyint(1) DEFAULT '0',
  `showActivity` tinyint(1) DEFAULT '1',
  `activityMessage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43412 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `POI_Table`
--

DROP TABLE IF EXISTS `POI_Table`;
CREATE TABLE IF NOT EXISTS `POI_Table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribution` varchar(150) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `lat` decimal(20,10) NOT NULL,
  `lon` decimal(20,10) NOT NULL,
  `imageURL` varchar(255) DEFAULT NULL,
  `line4` varchar(150) DEFAULT NULL,
  `line3` varchar(150) DEFAULT NULL,
  `line2` varchar(150) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `dimension` int(1) DEFAULT '1',
  `alt` int(10) DEFAULT NULL,
  `relativeAlt` int(10) DEFAULT NULL,
  `distance` decimal(20,10) NOT NULL,
  `inFocus` tinyint(1) DEFAULT '0',
  `doNotIndex` tinyint(1) DEFAULT '0',
  `showSmallBiw` tinyint(1) DEFAULT '1',
  `showBiwOnClick` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41632 ;
--
-- Base de datos: `tubus_leon`
--
CREATE DATABASE `tubus_leon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_leon`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35145 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=262 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_ma`
--
CREATE DATABASE `tubus_ma` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_ma`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=245 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=559 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=262938 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9142 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1227 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_madrid`
--
CREATE DATABASE `tubus_madrid` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_madrid`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=373 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2128867 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6594 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4626 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=433 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_mailing`
--
CREATE DATABASE `tubus_mailing` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_mailing`;
--
-- Base de datos: `tubus_sa`
--
CREATE DATABASE `tubus_sa` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_sa`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103572 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=774 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=423 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_se`
--
CREATE DATABASE `tubus_se` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_se`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211027 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1439 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=979 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_twitter`
--
CREATE DATABASE `tubus_twitter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_twitter`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dms`
--

DROP TABLE IF EXISTS `dms`;
CREATE TABLE IF NOT EXISTS `dms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `sender_screen_name` varchar(255) NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `recipient_screen_name` varchar(255) NOT NULL,
  `recipient_id` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `response_text` varchar(255) DEFAULT NULL,
  `estado` set('recibido','procesando','enviado','error','desfasado','noenviado','otro') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `twitter_id` varchar(255) NOT NULL,
  `screen_name` varchar(255) NOT NULL,
  `following` tinyint(1) NOT NULL,
  `bienvenida` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mentions`
--

DROP TABLE IF EXISTS `mentions`;
CREATE TABLE IF NOT EXISTS `mentions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) NOT NULL,
  `sender_screen_name` varchar(255) NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `response_text` varchar(255) DEFAULT NULL,
  `estado` set('recibido','procesando','enviado','error','desfasado','noenviado','otro') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=595098 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twitter_quota`
--

DROP TABLE IF EXISTS `twitter_quota`;
CREATE TABLE IF NOT EXISTS `twitter_quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(255) NOT NULL,
  `hora` varchar(255) NOT NULL,
  `quota` int(11) NOT NULL,
  `restante` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10788 ;
--
-- Base de datos: `tubus_usuarios`
--
CREATE DATABASE `tubus_usuarios` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_usuarios`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades_ip`
--

DROP TABLE IF EXISTS `ciudades_ip`;
CREATE TABLE IF NOT EXISTS `ciudades_ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7289 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `userid` varchar(255) NOT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendar_emails`
--

DROP TABLE IF EXISTS `recomendar_emails`;
CREATE TABLE IF NOT EXISTS `recomendar_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ciudad` varchar(255) NOT NULL,
  `parada` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `toadd` varchar(255) NOT NULL,
  `message` text,
  `ip` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1645 ;
--
-- Base de datos: `tubus_v`
--
CREATE DATABASE `tubus_v` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_v`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1239 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=337125 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1140 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1223 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_valladolid`
--
CREATE DATABASE `tubus_valladolid` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_valladolid`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149027 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=555 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_vigo`
--
CREATE DATABASE `tubus_vigo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_vigo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=376 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186529 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2383 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` varchar(255) DEFAULT NULL,
  `longitud` varchar(255) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  `foursquare_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1144 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentarios` text,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_DropDownList1`
--

DROP TABLE IF EXISTS `trayectos_a_DropDownList1`;
CREATE TABLE IF NOT EXISTS `trayectos_a_DropDownList1` (
  `trayecto_id` varchar(255) NOT NULL,
  `DropDownList1` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- Base de datos: `tubus_z`
--
CREATE DATABASE `tubus_z` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tubus_z`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_buscador`
--

DROP TABLE IF EXISTS `cache_buscador`;
CREATE TABLE IF NOT EXISTS `cache_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `querystring` varchar(255) NOT NULL,
  `results` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `explorador` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `horau` varchar(10) DEFAULT NULL,
  `diau` char(3) DEFAULT NULL,
  `aniou` varchar(4) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia_entre_paradas`
--

DROP TABLE IF EXISTS `distancia_entre_paradas`;
CREATE TABLE IF NOT EXISTS `distancia_entre_paradas` (
  `id_parada1` int(11) NOT NULL,
  `id_parada2` int(11) NOT NULL,
  `distancia` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_parada1`,`id_parada2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `nombre_parada` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=276 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141695 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_buscador`
--

DROP TABLE IF EXISTS `historial_buscador`;
CREATE TABLE IF NOT EXISTS `historial_buscador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `querystring` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1596 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_qr`
--

DROP TABLE IF EXISTS `historial_qr`;
CREATE TABLE IF NOT EXISTS `historial_qr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) NOT NULL,
  `parada_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_parada` int(11) NOT NULL,
  `f_horaria` int(11) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `linea` varchar(5) NOT NULL,
  `trayecto` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `html_lineas`
--

DROP TABLE IF EXISTS `html_lineas`;
CREATE TABLE IF NOT EXISTS `html_lineas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linea` int(11) NOT NULL,
  `html` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipl`
--

DROP TABLE IF EXISTS `ipl`;
CREATE TABLE IF NOT EXISTS `ipl` (
  `nip1` int(10) unsigned NOT NULL DEFAULT '0',
  `nip2` int(10) unsigned NOT NULL DEFAULT '0',
  `scta` char(2) NOT NULL,
  `sctl` varchar(64) NOT NULL,
  `sreg` varchar(128) NOT NULL,
  `scit` varchar(128) NOT NULL,
  `dlat` double NOT NULL,
  `dlon` double NOT NULL,
  `sisp` varchar(255) NOT NULL,
  `sidom` varchar(255) NOT NULL,
  PRIMARY KEY (`nip2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

DROP TABLE IF EXISTS `lineas`;
CREATE TABLE IF NOT EXISTS `lineas` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '000000',
  `id_ida` int(11) DEFAULT NULL,
  `id_vuelta` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `especial` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_linea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth`
--

DROP TABLE IF EXISTS `oauth`;
CREATE TABLE IF NOT EXISTS `oauth` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paradas`
--

DROP TABLE IF EXISTS `paradas`;
CREATE TABLE IF NOT EXISTS `paradas` (
  `id_parada` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `creada` datetime NOT NULL,
  `locatedby` varchar(255) DEFAULT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `virtual` int(11) NOT NULL DEFAULT '0',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  PRIMARY KEY (`id_parada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=966 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `userid` varchar(255) NOT NULL,
  PRIMARY KEY (`id_reporte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos`
--

DROP TABLE IF EXISTS `trayectos`;
CREATE TABLE IF NOT EXISTS `trayectos` (
  `id_trayecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_linea` int(11) NOT NULL,
  `salida` varchar(255) DEFAULT NULL,
  `llegada` varchar(255) DEFAULT NULL,
  `id_parada_salida` int(11) DEFAULT NULL,
  `id_parada_llegada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trayecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayectos_a_paradas`
--

DROP TABLE IF EXISTS `trayectos_a_paradas`;
CREATE TABLE IF NOT EXISTS `trayectos_a_paradas` (
  `id_trayecto` int(11) NOT NULL,
  `id_parada` int(11) NOT NULL,
  `posicion` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_trayecto`,`id_parada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `userkey` text NOT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `register_ip` varchar(255) NOT NULL,
  `last_ip` varchar(255) DEFAULT NULL,
  `recover_key` varchar(255) DEFAULT NULL,
  `recover_time` datetime DEFAULT NULL,
  `recover_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
