-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2025 at 02:29 AM
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
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `Id` char(36) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `cedula_numero` varchar(20) DEFAULT NULL,
  `captura_ruta` varchar(1020) NOT NULL,
  `pasaporte_numero` varchar(255) NOT NULL,
  `pasaporte_ruta` varchar(1020) NOT NULL,
  `fecha_nacimiento` timestamp NOT NULL,
  `tipo_visitante` varchar(23) NOT NULL,
  `tipo_estudiante` varchar(19) NOT NULL,
  `universidad` varchar(255) NOT NULL,
  `suscrito_newsletter` tinyint(1) NOT NULL,
  `suscrito_socials` tinyint(1) NOT NULL,
  `Puntos` int(10) NOT NULL,
  `EventosId` varchar(1020) NOT NULL,
  `Rol` varchar(100) NOT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
