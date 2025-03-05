-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 05, 2025 at 06:26 AM
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
-- Table structure for table `diplomados`
--

DROP TABLE IF EXISTS `diplomados`;
CREATE TABLE IF NOT EXISTS `diplomados` (
  `Id` char(36) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1020) DEFAULT NULL,
  `modalidad` varchar(255) DEFAULT NULL,
  `foto_diplomado` varchar(1020) NOT NULL,
  `precio_inscripcion` decimal(10,2) NOT NULL,
  `fecha_inicio_diplomado` timestamp NOT NULL,
  `fecha_fin_diplomado` timestamp NOT NULL,
  `fecha_apertura_inscripcion` timestamp NULL DEFAULT NULL,
  `fecha_cierre_inscripcion` timestamp NULL DEFAULT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) DEFAULT '0',
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diplomados`
--

INSERT INTO `diplomados` (`Id`, `nombre`, `descripcion`, `modalidad`, `foto_diplomado`, `precio_inscripcion`, `fecha_inicio_diplomado`, `fecha_fin_diplomado`, `fecha_apertura_inscripcion`, `fecha_cierre_inscripcion`, `Fecha_creacion`, `activo`, `Fecha_modificacion`) VALUES
('9919aaff', 'Diplomado en Desarrollo Web Fullstack', 'Un diplomado intensivo para aprender desarrollo web tanto frontend como backend, utilizando las tecnologías más modernas.', 'En línea', 'web_fullstack.jpg', '15000.00', '2025-03-01 12:00:00', '2025-06-30 21:00:00', '2025-01-15 12:00:00', '2025-03-01 03:59:59', '2025-02-16 17:51:06', 1, '2025-02-16 20:12:10'),
('9919bff5', 'Diplomado en Ciberseguridad y Redes', 'Capacitación avanzada en seguridad informática, gestión de redes y protección de datos para empresas.', 'Presencial', 'ciberseguridad_redes.jpg', '18000.00', '2025-04-15 12:00:00', '2025-08-15 20:00:00', '2025-02-01 12:00:00', '2025-04-11 02:59:59', '2025-02-16 17:51:06', 1, '2025-02-16 20:12:16'),
('9919c17a', 'Diplomado en Inteligencia Artificial Aplicada', 'Explora el mundo de la IA, incluyendo aprendizaje automático, redes neuronales y proyectos prácticos.', 'Híbrido', 'ia_aplicada.jpg', '20000.00', '2025-05-10 13:00:00', '2025-09-10 19:00:00', '2025-03-01 12:00:00', '2025-05-06 02:59:59', '2025-02-16 17:51:06', 1, '2025-02-16 20:12:22'),
('9919c8f2', 'Diplomado en Gestión de Proyectos Ágiles', 'Aprende metodologías ágiles como Scrum y Kanban para liderar proyectos de manera eficiente.', 'En línea', 'gestion_agil.jpg', '12000.00', '2025-06-01 11:00:00', '2025-09-30 21:00:00', '2025-04-01 11:00:00', '2025-06-01 02:59:59', '2025-02-16 17:51:06', 1, '2025-02-16 20:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `direcciones_email`
--

DROP TABLE IF EXISTS `direcciones_email`;
CREATE TABLE IF NOT EXISTS `direcciones_email` (
  `id` binary(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `direcciones_email`
--

INSERT INTO `direcciones_email` (`id`, `email`, `Fecha_creacion`, `Fecha_modificacion`) VALUES
(0x80258db71f405797304f4f847c382ff4, 'thelegendstutorials@gmail.com', '2025-03-05 06:19:44', '2025-03-05 06:19:44'),
(0xd6995346a8a8b3d636da27da45689fb5, 'daigoromo@test.com', '2025-03-05 06:19:44', '2025-03-05 06:19:44');

-- --------------------------------------------------------

--
-- Table structure for table `direcciones_email_registradas`
--

DROP TABLE IF EXISTS `direcciones_email_registradas`;
CREATE TABLE IF NOT EXISTS `direcciones_email_registradas` (
  `id` binary(16) NOT NULL,
  `direccion_id` binary(16) NOT NULL,
  `direccion_email` varchar(255) NOT NULL,
  `lista_id` binary(16) NOT NULL,
  `nombre_lista` varchar(255) NOT NULL,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `direccion_id` (`direccion_id`,`lista_id`),
  KEY `lista_id` (`lista_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `direcciones_email_registradas`
--

INSERT INTO `direcciones_email_registradas` (`id`, `direccion_id`, `direccion_email`, `lista_id`, `nombre_lista`, `Fecha_creacion`, `Fecha_modificacion`) VALUES
(0xe703e1cb30923c9f7d9df4f5ce9e183f, 0x80258db71f405797304f4f847c382ff4, 'thelegendstutorials@gmail.com', 0x217999151a006c2872fdcad4a4ea8f5f, 'werpale', '2025-03-05 06:20:09', '2025-03-05 06:20:09'),
(0xbf8402b6c81fe92a74b06993e9a5d7b9, 0xc8b84e401494a093ad52e5de55777892, 'compai@yopmail.com', 0x6d39bcad066192dcbd9dc49b1c8366a3, 'suplidores vetboca', '2025-03-05 05:53:51', '2025-03-05 05:53:51'),
(0xf4234fd3efd91e470e57168e80606355, 0x1dfd63225fafe73a1bde68097b27d0fb, 'hipolitoprz2001@gmail.com', 0x6d39bcad066192dcbd9dc49b1c8366a3, 'suplidores vetboca', '2025-03-05 05:53:51', '2025-03-05 05:53:51'),
(0xc1049cbece16dfa44691bfc07bf02e55, 0x5a602b587221ec9a2a899d977fc33243, 'info@vetcaprd.com', 0x6d39bcad066192dcbd9dc49b1c8366a3, 'suplidores vetboca', '2025-03-05 05:53:51', '2025-03-05 05:53:51'),
(0x3f291fd6cdfd424fc6635b637db52f42, 0x80258db71f405797304f4f847c382ff4, 'thelegendstutorials@gmail.com', 0xec99b0ebc4129a0344e87f9f4dc2f1c1, 'janasu', '2025-03-05 06:19:44', '2025-03-05 06:19:44'),
(0xe78dd1ab13d245165d9889556523530f, 0xd6995346a8a8b3d636da27da45689fb5, 'daigoromo@test.com', 0xec99b0ebc4129a0344e87f9f4dc2f1c1, 'janasu', '2025-03-05 06:19:44', '2025-03-05 06:19:44'),
(0x3d635f80fed2d555be54e03b5d40a60a, 0x04c8cdb298bab3ae5a564ed39b660ad6, 'thelegendstutorials@gmail.com', 0x6d39bcad066192dcbd9dc49b1c8366a3, 'suplidores vetboca', '2025-03-05 05:53:51', '2025-03-05 05:53:51');

--
-- Triggers `direcciones_email_registradas`
--
DROP TRIGGER IF EXISTS `add_email_after_insert`;
DELIMITER $$
CREATE TRIGGER `add_email_after_insert` AFTER INSERT ON `direcciones_email_registradas` FOR EACH ROW BEGIN
    -- Check if the email already exists in direcciones_email
    IF NOT EXISTS (
        SELECT 1 FROM direcciones_email WHERE email = NEW.direccion_email
    ) THEN
        -- Insert the new email into direcciones_email
        INSERT INTO direcciones_email (id, email)
        VALUES (UNHEX(REPLACE(UUID(), '-', '')), NEW.direccion_email);
    END IF;
END
$$
DELIMITER ;

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
('UUID()', 'TITULOSS', 'MEINSAJES', 'REDMITENTESS', 'K DETINO PAPADIO', NULL),
('67c71a9a5b113', 'thelegendstutorials@gmail.com', '<p><span style=\"font-size: 36pt;\"><strong>taan traan taaaaannnnn</strong></span></p>\r\n<p><span style=\"font-size: 36pt;\"><strong><img src=\"cid:fileImage0\"></strong></span></p>', 'thelegendstutorials@gmail.com', 'thelegendstutorials@gmail.com', NULL),
('67c7c4683dcb3', 'thelegendstutorials@gmail.com', '<p><strong>Suscribete a nuestras redes sociales</strong></p>\r\n<p><strong><img src=\"cid:fileImage0\"></strong></p>', 'thelegendstutorials@gmail.com', 'thelegendstutorials@gmail.com', NULL),
('67c7def2bad3a', 'La mejor promocion del word', '<h1>Les invitamos a nuestra gran promocion, Guay Mi Madre!</h1>\r\n<p><img src=\"cid:fileImage0\"></p>\r\n<p><span style=\"font-size: 18pt;\"><strong>No te la puedes perder!</strong></span></p>', 'thelegendstutorials@gmail.com', 'thelegendstutorials@gmail.com,hipolitoprz2001@gmail.com,erlocrio@gmail.com,compai@yopmail.com', NULL);

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
  `precio_inscripcion` decimal(10,2) NOT NULL,
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
('unguid', 'VETCAP HORIZONS 2025', 'vesca joraison eh una muvi', NULL, '../assets/img/horizon.png', NULL, '0.00', NULL, NULL, '2025-04-28 21:30:00', '2025-01-20 06:46:23', 0, '2025-03-02 02:54:01'),
('seroochochenta', 'VETCAmp', 'campamento y pile baina rara con lo animale waodiomios', NULL, '../assets/img/vetcap_tour_template.png', NULL, '7500.00', NULL, NULL, '2025-04-29 01:30:00', '2025-01-20 10:46:23', 1, '2025-03-02 02:54:07');

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
-- Table structure for table `lista_direcciones_email`
--

DROP TABLE IF EXISTS `lista_direcciones_email`;
CREATE TABLE IF NOT EXISTS `lista_direcciones_email` (
  `id` binary(16) NOT NULL,
  `nombre_lista` varchar(255) NOT NULL,
  `descripcion` text,
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lista_direcciones_email`
--

INSERT INTO `lista_direcciones_email` (`id`, `nombre_lista`, `descripcion`, `Fecha_creacion`, `Fecha_modificacion`) VALUES
(0x6d39bcad066192dcbd9dc49b1c8366a3, 'suplidores vetboca', 'suplidores medicamentos caninos', '2025-03-04 21:02:51', '2025-03-04 21:02:51'),
(0xec99b0ebc4129a0344e87f9f4dc2f1c1, 'janasu', 'itakunate', '2025-03-05 06:19:44', '2025-03-05 06:19:44'),
(0x217999151a006c2872fdcad4a4ea8f5f, 'werpale', 'sipi', '2025-03-05 06:20:09', '2025-03-05 06:20:09');

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
  `diplomado_id` char(36) DEFAULT NULL,
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
  KEY `usuario_id` (`usuario_id`),
  KEY `fk_diplomado` (`diplomado_id`)
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
  `token_reinicio` varchar(255) DEFAULT NULL,
  `reinicio_completo` tinyint(1) DEFAULT '0',
  `Fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`Id`, `nombre`, `apellido`, `telefono`, `correo_electronico`, `usuario`, `contrasena`, `tipo_documento`, `cedula_numero`, `cedula_ruta`, `cedula_validada`, `pasaporte_numero`, `pasaporte_ruta`, `fecha_nacimiento`, `pasaporte_validado`, `tipo_visitante`, `tipo_estudiante`, `universidad`, `suscrito_newsletter`, `suscrito_socials`, `puntos`, `rol`, `activo`, `token_activacion`, `token_reinicio`, `reinicio_completo`, `Fecha_creacion`, `Fecha_modificacion`) VALUES
('6820cf4344237842', 'Hipolito', 'Perez Peña', '8092343334', 'thelegendstutorials@gmail.com', 'sober', '$2y$10$/VrvOvjt31Ege99jDSdf3uP61LbaNybZieKrVraTVkbakKgpWZ8V6', NULL, '40229604604', 'C:\\wamp64\\www\\vesca\\VetCapMembers/uploads/67b6681089051_front_calendario_baloncesto.jpg_.d1vis10n._C:\\wamp64\\www\\vesca\\VetCapMembers/uploads/67b668108905b_back_3-years.png', 0, NULL, NULL, '2025-02-11 04:00:00', 0, 'Visitante', 'Estudiante de inicio', 'ucateci', NULL, NULL, 0, 'cliente', 1, '4da5637f741051d741fdbe8468da1c04', '7275ebe243460c5debbe3a265774f5d5', 1, '2025-02-18 01:17:16', '2025-02-19 23:24:00'),
('db7a0c5d235a8701', 'segunda prueba', 'registro', '8092343334', 'blackencio123@gmail.com', 'soberbia', '$2y$10$RHPD/JbSQNKyGQQBvDo1i.PhwfLKa6kFYwPFEgeusFjyi08/eld5a', NULL, NULL, NULL, 0, NULL, NULL, '2025-01-10 04:00:00', 0, 'Visitante', 'Estudiante de termino', 'ucateci', NULL, NULL, 0, 'cliente', 1, 'a766b746d44be739a2833370b2932729', NULL, 0, '2025-01-17 17:58:17', '2025-01-17 18:03:31'),
('69358c73aedf255e', 'fwffw', 'efeg', '8298902312', 'blackencio123@gmail.com', 'soberbias', '$2y$10$Q0v0wgHNgjNaH.O1jF9JG.2de94NItdtFihB.zLpVOL3vvWXtL8NC', NULL, '37563856358', 'C:\\wamp64\\www\\vesca\\VetCapMembers/uploads/6795b4f14888b_front_IMG_0049.JPG_.d1vis10n._C:\\wamp64\\www\\vesca\\VetCapMembers/uploads/6795b4f148894_back_Sin título-1.png', 0, NULL, NULL, '2025-01-15 04:00:00', 0, 'Estudiante veterinario', 'Estudiante de inicio', 'unapec', NULL, NULL, 0, 'cliente', 1, 'a3ae8bf942e8b10f5ad0d8e452ee8298', NULL, 0, '2025-01-17 18:09:25', '2025-01-26 04:07:13'),
('0214794ae6c9068d', 'nouni', 'user', '8298902312', 'compai@yopmail.com', 'nouni', '$2y$10$EN5EYfrQY.AaKm2Hf5NrC.I4sJzsvBleOVwuei631ry/SMxeyfVqi', NULL, NULL, NULL, 0, NULL, NULL, '1997-05-14 03:00:00', 0, 'Visitante', NULL, NULL, NULL, NULL, 0, 'cliente', 1, '882f230ee273705901ac031d1d523e91', NULL, 0, '2025-02-20 23:06:42', '2025-02-20 23:07:42'),
('b610c332b6fbf2c1', 'baduser', 'test', '8298902312', 'compai@yopmail.com', 'nouni2', '$2y$10$fWvvEhbbFLd8d4p2azdhJ.Rn3EFWsaabsG9AFZOm/NNZ3dmC1dvwu', NULL, NULL, NULL, 0, NULL, NULL, '2025-02-07 04:00:00', 0, 'Estudiante veterinario', NULL, NULL, NULL, NULL, 0, 'cliente', 0, 'e363292e62daf12a491fa604f96b4683', NULL, 0, '2025-02-20 23:09:54', '2025-02-20 23:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_diplomados`
--

DROP TABLE IF EXISTS `usuario_diplomados`;
CREATE TABLE IF NOT EXISTS `usuario_diplomados` (
  `usuario_id` char(36) NOT NULL,
  `diplomado_id` char(36) NOT NULL,
  `Fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`,`diplomado_id`),
  KEY `diplomado_id` (`diplomado_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
