-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2025 at 07:39 PM
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

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`Id`, `titulo`, `mensaje`, `remitente`, `destinatario`, `adjuntos_ruta`) VALUES
('UUID()', 'TITULOSS', 'MEINSAJES', 'REDMITENTESS', 'K DETINO PAPADIO', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `Id` char(36) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1020) DEFAULT NULL,
  `descripcion2` varchar(1020) DEFAULT NULL,
  `foto_evento` varchar(1020) NOT NULL,
  `foto_titulo` varchar(1020) DEFAULT NULL,
  `precio_inscripcion` int(10) NOT NULL,
  `fecha_apertura_inscripcion` timestamp NULL DEFAULT NULL,
  `fecha_cierre_inscripcion` timestamp NULL DEFAULT NULL,
  `fecha_evento` timestamp NOT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) DEFAULT '0',
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eventos`
--

INSERT INTO `eventos` (`Id`, `nombre`, `descripcion`, `descripcion2`, `foto_evento`, `foto_titulo`, `precio_inscripcion`, `fecha_apertura_inscripcion`, `fecha_cierre_inscripcion`, `fecha_evento`, `Fecha_creacion`, `activo`, `Fecha_modificacion`) VALUES
('unguid', 'VETCAP HORIZONS 2025', 'vesca joraison eh una muvi', NULL, '../assets/img/horizon.png', NULL, 7500, NULL, NULL, '2025-02-28 22:30:00', '2025-01-20 06:46:23', 0, '2025-01-21 05:43:04'),
('seroochochenta', 'VETCAmp', 'campamento y pile baina rara con lo animale waodiomio', NULL, '../assets/img/horizon.png', NULL, 7500, NULL, NULL, '2025-03-01 02:30:00', '2025-01-20 10:46:23', 1, '2025-01-21 09:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `finanzas`
--

DROP TABLE IF EXISTS `finanzas`;
CREATE TABLE IF NOT EXISTS `finanzas` (
  `Id` char(36) NOT NULL,
  `nombre_titular_completo` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `banco` varchar(10) NOT NULL,
  `tipo_cuenta` varchar(30) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `ambiente` varchar(30) NOT NULL,
  `cliente_id` varchar(1020) DEFAULT NULL,
  `numero_cuenta` varchar(100) DEFAULT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finanzas`
--

INSERT INTO `finanzas` (`Id`, `nombre_titular_completo`, `correo_electronico`, `banco`, `tipo_cuenta`, `moneda`, `ambiente`, `cliente_id`, `numero_cuenta`, `Fecha_creacion`, `Fecha_modificacion`) VALUES
('becd8c36-d8e5-11ef-868c-88b111d5da49', 'John Doe', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', 'USD', 'Sandbox', 'Ae15xLTKadxt1n17OTKnYK9GKc6TTcqvBM5CHt1IXAAKKwlTtx_RJ82ndJssVjy8ioL6Hw3bxz2teIqU', NULL, '2025-01-22 17:24:31', '2025-01-22 17:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE IF NOT EXISTS `pagos` (
  `Id` char(36) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `comprobante_pago_ruta` varchar(1020) DEFAULT NULL,
  `metodo_de_pago` varchar(255) NOT NULL,
  `pago_validado` tinyint(1) NOT NULL DEFAULT '0',
  `evento_id` char(36) NOT NULL,
  `usuario_id` char(36) NOT NULL,
  `cuenta_remitente` varchar(255) NOT NULL,
  `banco_remitente` varchar(255) NOT NULL,
  `tipo_cuenta_remitente` varchar(255) NOT NULL,
  `cuenta_destinatario` varchar(255) NOT NULL,
  `banco_destinatario` varchar(255) NOT NULL,
  `tipo_cuenta_destinatario` varchar(255) NOT NULL,
  `fecha_de_pago` timestamp NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `evento_id` (`evento_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`Id`, `monto`, `comprobante_pago_ruta`, `metodo_de_pago`, `pago_validado`, `evento_id`, `usuario_id`, `cuenta_remitente`, `banco_remitente`, `tipo_cuenta_remitente`, `cuenta_destinatario`, `banco_destinatario`, `tipo_cuenta_destinatario`, `fecha_de_pago`, `fecha_creacion`, `fecha_modificacion`) VALUES
('6BD69344JM7512709', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-23 01:10:20', '2025-01-23 01:10:20', '2025-01-23 01:10:20'),
('3L064225PM768942F', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-23 01:47:28', '2025-01-23 01:47:28', '2025-01-23 01:47:28'),
('1JW09638GM040102K', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-23 17:10:37', '2025-01-23 17:10:37', '2025-01-23 17:10:37'),
('6B564593E3159082G', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:26:22', '2025-01-24 18:26:22', '2025-01-24 18:26:22'),
('1VB50508C4599611B', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:31:00', '2025-01-24 18:31:00', '2025-01-24 18:31:00'),
('2R102525N7701125X', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:37:54', '2025-01-24 18:37:54', '2025-01-24 18:37:54'),
('2UK84542M4662715Y', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:40:21', '2025-01-24 18:40:21', '2025-01-24 18:40:21'),
('62P37190FB5050303', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:44:20', '2025-01-24 18:44:20', '2025-01-24 18:44:20'),
('26N05294G8164734C', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:47:23', '2025-01-24 18:47:23', '2025-01-24 18:47:23'),
('3NN197841P193493L', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:49:50', '2025-01-24 18:49:50', '2025-01-24 18:49:50'),
('4AB58128YX7545409', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:50:46', '2025-01-24 18:50:46', '2025-01-24 18:50:46'),
('3963303413565361M', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:52:48', '2025-01-24 18:52:48', '2025-01-24 18:52:48'),
('0FS634478N748194R', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:53:46', '2025-01-24 18:53:46', '2025-01-24 18:53:46'),
('31682684MY886103L', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:54:32', '2025-01-24 18:54:32', '2025-01-24 18:54:32'),
('48105191SA849654F', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 18:57:13', '2025-01-24 18:57:13', '2025-01-24 18:57:13'),
('1BD33233LA1362426', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:02:21', '2025-01-24 19:02:21', '2025-01-24 19:02:21'),
('4CE58412E64269836', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:04:40', '2025-01-24 19:04:40', '2025-01-24 19:04:40'),
('3YL79174HG579944D', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:06:09', '2025-01-24 19:06:09', '2025-01-24 19:06:09'),
('29X87160UF259904B', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:08:07', '2025-01-24 19:08:07', '2025-01-24 19:08:07'),
('6S976636NU040600P', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:10:29', '2025-01-24 19:10:29', '2025-01-24 19:10:29'),
('16J82784D67945128', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:13:17', '2025-01-24 19:13:17', '2025-01-24 19:13:17'),
('42A31436GC345784C', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:15:24', '2025-01-24 19:15:24', '2025-01-24 19:15:24'),
('3LY08286DE4525122', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:16:39', '2025-01-24 19:16:39', '2025-01-24 19:16:39'),
('4JA858358H590043C', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:21:23', '2025-01-24 19:21:23', '2025-01-24 19:21:23'),
('6HT0710717971834U', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:24:55', '2025-01-24 19:24:55', '2025-01-24 19:24:55'),
('4BX13613A96291704', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:26:33', '2025-01-24 19:26:33', '2025-01-24 19:26:33'),
('1T787355BE811725X', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:28:06', '2025-01-24 19:28:06', '2025-01-24 19:28:06'),
('0NB068636V3382116', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:30:39', '2025-01-24 19:30:39', '2025-01-24 19:30:39'),
('1FT93015VM733803B', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:35:13', '2025-01-24 19:35:13', '2025-01-24 19:35:13'),
('5CK402543F0014359', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 19:36:54', '2025-01-24 19:36:54', '2025-01-24 19:36:54'),
('0D707895L73978102', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 20:58:53', '2025-01-24 20:58:53', '2025-01-24 20:58:53'),
('59067998JE659264J', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 21:05:19', '2025-01-24 21:05:19', '2025-01-24 21:05:19'),
('19085054NL475954P', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 21:36:34', '2025-01-24 21:36:34', '2025-01-24 21:36:34'),
('94B57643P4144105U', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'unguid', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 21:41:17', '2025-01-24 21:41:17', '2025-01-24 21:41:17'),
('1PW24267CD372504V', '7500.00', NULL, 'Tarjeta de débito/crédito vía PayPal', 0, 'seroochochenta', '69358c73aedf255e', 'Verificar en PayPal con Id de Transaccion', 'PayPal', 'Tarjeta de débito/crédito', 'sb-1oqee33661271@business.example.com', 'PayPal', 'prueba', '2025-01-24 21:56:57', '2025-01-24 21:56:57', '2025-01-24 21:56:57');

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
  `contrasena` varchar(255) DEFAULT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `cedula_numero` varchar(20) DEFAULT NULL,
  `cedula_ruta` varchar(1020) DEFAULT NULL,
  `cedula_validada` tinyint(1) DEFAULT '0',
  `pasaporte_numero` varchar(255) DEFAULT NULL,
  `pasaporte_ruta` varchar(1020) DEFAULT NULL,
  `fecha_nacimiento` timestamp NOT NULL,
  `pasaporte_validado` tinyint(1) DEFAULT '0',
  `tipo_visitante` varchar(23) NOT NULL,
  `tipo_estudiante` varchar(50) DEFAULT NULL,
  `universidad` varchar(255) DEFAULT NULL,
  `suscrito_newsletter` tinyint(1) DEFAULT NULL,
  `suscrito_socials` tinyint(1) DEFAULT NULL,
  `puntos` int(10) NOT NULL DEFAULT '0',
  `rol` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT '0',
  `token_activacion` varchar(255) DEFAULT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`Id`, `nombre`, `apellido`, `telefono`, `correo_electronico`, `usuario`, `contrasena`, `tipo_documento`, `cedula_numero`, `cedula_ruta`, `cedula_validada`, `pasaporte_numero`, `pasaporte_ruta`, `fecha_nacimiento`, `pasaporte_validado`, `tipo_visitante`, `tipo_estudiante`, `universidad`, `suscrito_newsletter`, `suscrito_socials`, `puntos`, `rol`, `activo`, `token_activacion`, `Fecha_creacion`, `Fecha_modificacion`) VALUES
('dd7f0e28ab089d5c', 'prueba', 'registro', '8092343334', 'thelegendstutorials@gmail.com', 'sober', '$2y$10$1CCS3vhiyzmtPvgFWlFpreRgw/p51AmXw5ApDF5PowXnXAW84I7Uy', NULL, NULL, NULL, 0, NULL, NULL, '2025-01-14 04:00:00', 0, 'Visitante', 'Estudiante a mediados de carrea', 'ucateci', NULL, NULL, 0, 'cliente', 0, 'eb54f51097847ca27f9b03c0b4661ee3', '2025-01-17 01:36:37', '2025-01-17 01:36:37'),
('db7a0c5d235a8701', 'segunda prueba', 'registro', '8092343334', 'blackencio123@gmail.com', 'soberbia', '$2y$10$RHPD/JbSQNKyGQQBvDo1i.PhwfLKa6kFYwPFEgeusFjyi08/eld5a', NULL, NULL, NULL, 0, NULL, NULL, '2025-01-10 04:00:00', 0, 'Visitante', 'Estudiante de termino', 'ucateci', NULL, NULL, 0, 'cliente', 1, 'a766b746d44be739a2833370b2932729', '2025-01-17 17:58:17', '2025-01-17 18:03:31'),
('69358c73aedf255e', 'fwffw', 'efeg', '8298902312', 'blackencio123@gmail.com', 'soberbias', '$2y$10$Q0v0wgHNgjNaH.O1jF9JG.2de94NItdtFihB.zLpVOL3vvWXtL8NC', NULL, '40229604604', '_.d1vis10n._', 0, NULL, NULL, '2025-01-15 04:00:00', 0, 'Estudiante veterinario', 'Estudiante de inicio', 'unapec', NULL, NULL, 0, 'cliente', 1, 'a3ae8bf942e8b10f5ad0d8e452ee8298', '2025-01-17 18:09:25', '2025-01-20 06:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_eventos`
--

DROP TABLE IF EXISTS `usuario_eventos`;
CREATE TABLE IF NOT EXISTS `usuario_eventos` (
  `usuario_id` char(36) NOT NULL,
  `evento_id` char(36) NOT NULL,
  `Fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`,`evento_id`),
  KEY `evento_id` (`evento_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
