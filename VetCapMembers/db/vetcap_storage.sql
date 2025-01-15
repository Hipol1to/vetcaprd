-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 15, 2025 at 03:26 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vetcap_storage`
--

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
CREATE TABLE IF NOT EXISTS `emails` (
  `Id` char(36) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensaje` varchar(1020) NOT NULL,
  `remitente` varchar(255) NOT NULL,
  `destinatario` varchar(1020) NOT NULL,
  `adjuntos_ruta` varchar(1020) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `Id` char(36) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1020) NOT NULL,
  `foto_evento` varchar(1020) NOT NULL,
  `precio_inscripcion` int(10) NOT NULL,
  `fecha_apertura_inscripcion` timestamp NOT NULL,
  `fecha_cierre_inscripcion` timestamp NOT NULL,
  `fecha_evento` timestamp NOT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE IF NOT EXISTS `pagos` (
  `Id` char(36) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `comprobante_pago_ruta` varchar(1020) NOT NULL,
  `metodo_de_pago` varchar(255) NOT NULL,
  `pago_validado` tinyint(1) NOT NULL,
  `evento_id` varchar(255) NOT NULL,
  `usuario_id` varchar(255) NOT NULL,
  `cuenta_remitente` varchar(255) NOT NULL,
  `banco_remitente` varchar(255) NOT NULL,
  `tipo_cuenta_remitente` varchar(255) NOT NULL,
  `cuenta_destinatario` varchar(255) NOT NULL,
  `banco_destinatario` varchar(255) NOT NULL,
  `tipo_cuenta_destinatario` varchar(255) NOT NULL,
  `fecha_de_pago` timestamp NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `Id` char(36) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `cedula_numero` varchar(20) DEFAULT NULL,
  `captura_ruta` varchar(1020) NOT NULL,
  `cedula_validada` tinyint(1) DEFAULT '0',
  `pasaporte_numero` varchar(255) NOT NULL,
  `pasaporte_ruta` varchar(1020) NOT NULL,
  `fecha_nacimiento` timestamp NOT NULL,
  `tipo_visitante` varchar(23) NOT NULL,
  `tipo_estudiante` varchar(19) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `suscrito_newsletter` tinyint(1) NOT NULL,
  `suscrito_socials` tinyint(1) NOT NULL,
  `puntos` int(10) NOT NULL,
  `EventosId` varchar(1020) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
