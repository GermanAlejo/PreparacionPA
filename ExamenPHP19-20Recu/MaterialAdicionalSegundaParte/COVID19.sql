-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-06-2020 a las 22:40:15
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `COVID19`
--
CREATE DATABASE IF NOT EXISTS `COVID19` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `COVID19`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `hospital`
--

INSERT INTO `hospital` (`id`, `nombre`, `direccion`) VALUES
(1, 'Virgen Macarena', 'Calle Dr. Fedriani, 3, 41009 Sevilla'),
(2, 'Virgen del Rocio', 'Av. Manuel Siurot, S/n, 41013 Sevilla'),
(3, 'Valme', 'Ctra. de Cádiz Km. 548,9, 41014 Sevilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id_prueba` int(2) NOT NULL,
  `nombre_paciente` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `dni_paciente` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `localidad_paciente` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_prueba` date NOT NULL,
  `resultado_prueba` tinyint(1) NOT NULL,
  `hospital_asociado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id_prueba`, `nombre_paciente`, `dni_paciente`, `localidad_paciente`, `fecha_prueba`, `resultado_prueba`, `hospital_asociado`) VALUES
(1, 'Francisco', '54298645X', 'Sevilla', '2020-03-25', 0, 1),
(2, 'Ángeles', '17803564M', 'Dos Hermanas', '2020-03-24', 1, 1),
(5, 'Juan Antonio', '34515743B', 'Arahal', '2020-03-28', 0, 2),
(6, 'Tom', '98765432G', 'Marchena', '2020-03-28', 1, 3),
(7, 'Jerry', '34521763V', 'Montequinto', '2020-03-26', 1, 3),
(8, 'Victoria', '90654123U', 'Paradas', '2020-03-26', 1, 1),
(46, 'alvaro', '12345673X', 'arahal', '2020-10-11', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `username` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_hospital` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`username`, `password`, `nombre`, `apellidos`, `id_hospital`) VALUES
('alicia', 'alicia1234', 'Alicia', 'Balbuena', 1),
('jose', 'jose1234', 'José', 'Aguilar', 3),
('manuel', 'manuel1234', 'Manuel', 'Benítez', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id_prueba`),
  ADD KEY `hospital_asociado` (`hospital_asociado`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id_hospital` (`id_hospital`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id_prueba` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD CONSTRAINT `prueba_ibfk_1` FOREIGN KEY (`hospital_asociado`) REFERENCES `hospital` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_hospital`) REFERENCES `hospital` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
