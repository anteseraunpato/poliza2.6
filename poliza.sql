-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-05-2025 a las 00:10:48
-- Versión del servidor: 8.0.41
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `poliza`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capitulos`
--

DROP TABLE IF EXISTS `capitulos`;
CREATE TABLE IF NOT EXISTS `capitulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `capitulos` int NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `capitulos`
--

INSERT INTO `capitulos` (`id`, `capitulos`, `denominacion`) VALUES
(1, 2100, 'MATERIALES DE ADMINISTRACION, EMISION DE DOCUMENTOS Y ARTICULOS \r\nOFICIALES.'),
(2, 2300, 'MATERIAS PRIMAS Y MATERIALES DE PRODUCCION Y \r\nCOMERCIALIZACION '),
(3, 2400, ' MATERIALES Y ARTICULOS DE CONSTRUCCION Y DE REPARACION '),
(4, 2200, 'ALIMENTOS Y UTENSILIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_xml`
--

DROP TABLE IF EXISTS `datos_xml`;
CREATE TABLE IF NOT EXISTS `datos_xml` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `subtotal` varchar(255) DEFAULT NULL,
  `moneda` varchar(255) DEFAULT NULL,
  `rfc_emisor` varchar(255) DEFAULT NULL,
  `rfc_receptor` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `datos_xml`
--

INSERT INTO `datos_xml` (`id`, `fecha`, `total`, `subtotal`, `moneda`, `rfc_emisor`, `rfc_receptor`, `uuid`) VALUES
(135, '2024-12-04T11:11:04', '2852.41', '2458.97', 'MXN', 'CKO2102037I8', 'SEP210905778', '0775888A-0D11-4C0B-BF94-026A658CDA40'),
(136, '2025-02-20T07:51:24', '358.00', '394.83', 'MXN', 'OOM960429832', 'SEP210905778', '73D2459A-FB91-46DB-AF9F-5E3631266688'),
(137, '2025-02-12T17:26:03', '468.00', '403.45', 'MXN', 'PEAM750905MG0', 'SEP210905778', '5c1324a9-3a22-4fe3-8b25-1a275d1b12ed'),
(138, '2025-02-09T12:25:06', '1506.00', '1496.56', 'MXN', 'ODM950324V2A', 'SEP210905778', '76099D9D-6833-3047-B262-9091A36E850C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

DROP TABLE IF EXISTS `partidas`;
CREATE TABLE IF NOT EXISTS `partidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cap` int DEFAULT NULL,
  `partida` varchar(255) NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cap` (`id_cap`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`id`, `id_cap`, `partida`, `denominacion`) VALUES
(2, 1, '21101 ', 'MATERIALES Y UTILES DE OFICINA'),
(3, 3, '24901 ', 'OTROS MATERIALES Y ARTICULOS DE CONSTRUCCION Y REPARACION'),
(4, 1, '21201 ', 'Materiales y útiles de impresión y reproducción'),
(5, 2, '23101', 'Productos alimenticios, agropecuarios y forestales adquiridos \r\ncomo materia prima'),
(6, 4, '22101', 'Productos alimenticios para el Ejército, Fuerza Aérea y Armada \r\nMexicanos, y para los efectivos que participen en programas de \r\nseguridad pública ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `polizas`
--

DROP TABLE IF EXISTS `polizas`;
CREATE TABLE IF NOT EXISTS `polizas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `rfc_emisor` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `partida` int NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  `observaciones` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `partida` (`partida`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `polizas`
--

INSERT INTO `polizas` (`id`, `uuid`, `fecha`, `rfc_emisor`, `total`, `partida`, `denominacion`, `observaciones`) VALUES
(23, 'A40387C7-FA23-3F47-81BA-A7A2CAC4877C', '2025-04-01', 'ODM950324V2A', 996.00, 2, 'MATERIALES Y UTILES DE OFICINA', ''),
(25, 'bf45b0fa-8f9f-4e5e-afda-618c25fbfe51', '2025-04-01', 'PCS870128871', 877.00, 6, 'Productos alimenticios para el Ejército, Fuerza Aérea y Armada \r\nMexicanos, y para los efectivos que participen en programas de \r\nseguridad pública ', ''),
(26, 'dad04c9f-a427-4fb7-af95-d5c31e7b05e4', '2025-04-01', 'PEAM750905MG0', 992.50, 2, 'MATERIALES Y UTILES DE OFICINA', ''),
(27, '0775888A-0D11-4C0B-BF94-026A658CDA40', '2025-04-01', 'CKO2102037I8', 2852.41, 5, 'Productos alimenticios, agropecuarios y forestales adquiridos \r\ncomo materia prima', ''),
(28, '0775888A-0D11-4C0B-BF94-026A658CDA40', '2025-04-01', 'CKO2102037I8', 2852.41, 6, 'Productos alimenticios para el Ejército, Fuerza Aérea y Armada \r\nMexicanos, y para los efectivos que participen en programas de \r\nseguridad pública ', ''),
(29, '73D2459A-FB91-46DB-AF9F-5E3631266688', '2025-04-01', 'OOM960429832', 358.00, 4, 'Materiales y útiles de impresión y reproducción', ''),
(30, '76099D9D-6833-3047-B262-9091A36E850C', '2025-04-01', 'ODM950324V2A', 1506.00, 5, 'Productos alimenticios, agropecuarios y forestales adquiridos \r\ncomo materia prima', ''),
(31, '76099D9D-6833-3047-B262-9091A36E850C', '2025-04-01', 'ODM950324V2A', 1506.00, 5, 'Productos alimenticios, agropecuarios y forestales adquiridos \r\ncomo materia prima', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `edad` int NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `pregunta_seguridad` varchar(255) DEFAULT NULL,
  `respuesta_seguridad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_completo`, `nombre_usuario`, `correo_electronico`, `edad`, `telefono`, `fecha_nacimiento`, `localidad`, `genero`, `contraseña`, `pregunta_seguridad`, `respuesta_seguridad`) VALUES
(1, 'Alberto Mauricio Balam Lopéz', 'Mauricio', 'balamlopeza@gmail.com', 20, '9995032755', '2004-05-25', 'Izamal', 'male', '$2y$10$Svl4STJZBFRCmPaMRrw5buDqRl/e0BWQWfO3vS.3.ldXHxWg0lAxi', '¿Cual es el nombre de mi perro?', 'Polar'),
(2, 'Carlos Ruiz ', 'Ruiz', 'ruiz@gmail.com', 20, '897374927923', '2004-07-16', 'Kimbila', 'male', '$2y$10$wRqKzscn1e1xyi.bH.KC7e7Sxq2Wz46dpGFlfarMfwfTCBtT2LbbS', '¿Cual es el nombre de mi perro?', 'Firulais'),
(3, 'Ingrid Ivette Euan Baas', 'Ingrid', 'Ivette@gmail.com', 21, '9999908389', '2004-10-20', 'Izamal', 'female', '$2y$10$z6yacSxB3xvPuySqJEq/Vu3/1drHw7LYXBKmnhqoQkrFmMSz3S6Pe', '¿Cual es el nombre de mi perro?', 'ARES'),
(4, 'Jorge Carlos Azcorra Osorio', 'jcao', 'jorgecarlos@hotmail.com', 25, '9999471001', '1990-11-20', 'merida', 'male', '$2y$10$jyHTEzF0xMhV4XVx2XtEH.iyYKqlUtzWk7LjxAIFOZe1Qia6O9nou', 'cuantos años tienes', '34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `xmls_subidos`
--

DROP TABLE IF EXISTS `xmls_subidos`;
CREATE TABLE IF NOT EXISTS `xmls_subidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_xml` varchar(255) NOT NULL,
  `ruta_xml` varchar(255) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `xmls_subidos`
--

INSERT INTO `xmls_subidos` (`id`, `nombre_xml`, `ruta_xml`, `id_usuario`) VALUES
(107, '1.- CBTA284 76099D9D-6833-3047-B262-9091A36E850C.xml', 'uploads/xml/1.- CBTA284 76099D9D-6833-3047-B262-9091A36E850C.xml', 1),
(108, '2.- CBTA284 5C1324A9-3A22-4FE3-8B25-1A275D1B12ED.xml', 'uploads/xml/2.- CBTA284 5C1324A9-3A22-4FE3-8B25-1A275D1B12ED.xml', 1),
(114, '3.- CBTA284 73D2459A-FB91-46DB-AF9F-5E3631266688.xml', 'uploads/xml/3.- CBTA284 73D2459A-FB91-46DB-AF9F-5E3631266688.xml', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`id_cap`) REFERENCES `capitulos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `polizas`
--
ALTER TABLE `polizas`
  ADD CONSTRAINT `polizas_ibfk_1` FOREIGN KEY (`partida`) REFERENCES `partidas` (`id`);

--
-- Filtros para la tabla `xmls_subidos`
--
ALTER TABLE `xmls_subidos`
  ADD CONSTRAINT `xmls_subidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
