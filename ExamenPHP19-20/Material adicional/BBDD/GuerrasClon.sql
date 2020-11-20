-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-12-2019 a las 16:36:53
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
-- Base de datos: `GuerrasClon`
--
DROP DATABASE IF EXISTS `GuerrasClon`;
CREATE DATABASE IF NOT EXISTS `GuerrasClon` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `GuerrasClon`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jedis`
--

CREATE TABLE `jedis` (
  `id` int(3) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenya` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `raza` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `rango` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `jedis`
--

INSERT INTO `jedis` (`id`, `nombre`, `contrasenya`, `raza`, `rango`) VALUES
(1, 'yoda', '$2y$10$Floe3/AbE7FcHxKOzCJibeIONdXLIQ9oWi7FbEhg4gmMx4MMMNGQ6', 'lannik', 'M'),
(2, 'windu', '$2y$10$BhUBYP0qR..rZtmYsB/JFOrek1Z6Q3RLnx39uPLqwOYUiyCCCea6.', 'humano', 'M'),
(4, 'anakin', '$2y$10$zBC3.Pew1OEeIFJ4eXPrg.6LsLq6fR5iiCGAvo9aDygAwzAOVSxIm', 'humano', 'P'),
(5, 'ahsoka', '$2y$10$b/edlGk83ILf7gMj7SKQ5.cIkRHoRQHqnwdPhEtIedAQsNJGOHoIK', 'Togruta', 'P');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `misiones`
--

CREATE TABLE `misiones` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `ficha_mision` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `jedi_asociado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `misiones`
--

INSERT INTO `misiones` (`id`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `ficha_mision`, `jedi_asociado`) VALUES
(1, 'Utapau', 'MisiÃ³n en Utapau', '2019-01-01', '2019-12-08', 'Utapau.pdf', 'anakin'),
(2, 'Geonosis', 'mision geonosis', '2019-12-07', NULL, 'Geonosis.pdf', 'ahsoka'),
(3, 'Coruscant', 'mision de coruscant', '2020-01-02', NULL, 'Coruscant.pdf', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jedis`
--
ALTER TABLE `jedis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `misiones`
--
ALTER TABLE `misiones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jedis`
--
ALTER TABLE `jedis`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `misiones`
--
ALTER TABLE `misiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
