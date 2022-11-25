-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2022 a las 08:10:28
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbattendanceuna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbactivity`
--

CREATE TABLE `tbactivity` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `manager` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbactivity_category`
--

CREATE TABLE `tbactivity_category` (
  `id` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbactivity_person`
--

CREATE TABLE `tbactivity_person` (
  `id_activity` int(11) NOT NULL,
  `id_person` varchar(13) NOT NULL,
  `entry_hour` time NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbactivity_subcategory`
--

CREATE TABLE `tbactivity_subcategory` (
  `id` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `id_subcategory` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategory`
--

CREATE TABLE `tbcategory` (
  `idcategory` int(11) NOT NULL,
  `namecategory` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbcategory`
--

INSERT INTO `tbcategory` (`idcategory`, `namecategory`) VALUES
(1, 'Académico'),
(2, 'Administrativo'),
(3, 'Estudiante'),
(4, 'Invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblog`
--

CREATE TABLE `tblog` (
  `id` int(11) NOT NULL,
  `error_message` varchar(5000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbperson`
--

CREATE TABLE `tbperson` (
  `id` varchar(12) NOT NULL,
  `name` varchar(50) NOT NULL,
  `first_lastname` varchar(50) NOT NULL,
  `second_lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `category` varchar(16) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `institutional_card` varchar(35) NOT NULL DEFAULT 'N/A',
  `phone` varchar(8) NOT NULL DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsubcategory`
--

CREATE TABLE `tbsubcategory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsubcategory_person`
--

CREATE TABLE `tbsubcategory_person` (
  `idperson` varchar(12) NOT NULL,
  `idsubcategory` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbactivity`
--
ALTER TABLE `tbactivity`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbactivity_category`
--
ALTER TABLE `tbactivity_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_activity` (`id_activity`);

--
-- Indices de la tabla `tbactivity_person`
--
ALTER TABLE `tbactivity_person`
  ADD PRIMARY KEY (`id_activity`,`id_person`),
  ADD KEY `id_person` (`id_person`);

--
-- Indices de la tabla `tbactivity_subcategory`
--
ALTER TABLE `tbactivity_subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_subcategory` (`id_subcategory`),
  ADD KEY `id_activity` (`id_activity`);

--
-- Indices de la tabla `tbcategory`
--
ALTER TABLE `tbcategory`
  ADD PRIMARY KEY (`namecategory`);

--
-- Indices de la tabla `tblog`
--
ALTER TABLE `tblog`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbperson`
--
ALTER TABLE `tbperson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_person_category` (`category`);

--
-- Indices de la tabla `tbsubcategory`
--
ALTER TABLE `tbsubcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbsubcategory_person`
--
ALTER TABLE `tbsubcategory_person`
  ADD PRIMARY KEY (`idperson`,`idsubcategory`),
  ADD KEY `fk_subcategory` (`idsubcategory`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbactivity`
--
ALTER TABLE `tbactivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `tbactivity_category`
--
ALTER TABLE `tbactivity_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbactivity_subcategory`
--
ALTER TABLE `tbactivity_subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblog`
--
ALTER TABLE `tblog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbsubcategory`
--
ALTER TABLE `tbsubcategory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbactivity_category`
--
ALTER TABLE `tbactivity_category`
  ADD CONSTRAINT `tbactivity_category_ibfk_1` FOREIGN KEY (`id_activity`) REFERENCES `tbactivity` (`id`);

--
-- Filtros para la tabla `tbactivity_person`
--
ALTER TABLE `tbactivity_person`
  ADD CONSTRAINT `tbactivity_person_ibfk_1` FOREIGN KEY (`id_activity`) REFERENCES `tbactivity` (`id`),
  ADD CONSTRAINT `tbactivity_person_ibfk_2` FOREIGN KEY (`id_person`) REFERENCES `tbperson` (`id`);

--
-- Filtros para la tabla `tbperson`
--
ALTER TABLE `tbperson`
  ADD CONSTRAINT `fk_person_category` FOREIGN KEY (`category`) REFERENCES `tbcategory` (`namecategory`);

--
-- Filtros para la tabla `tbsubcategory_person`
--
ALTER TABLE `tbsubcategory_person`
  ADD CONSTRAINT `fk_person` FOREIGN KEY (`idperson`) REFERENCES `tbperson` (`id`),
  ADD CONSTRAINT `fk_subcategory` FOREIGN KEY (`idsubcategory`) REFERENCES `tbsubcategory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
