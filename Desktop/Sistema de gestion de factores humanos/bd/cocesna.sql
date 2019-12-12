-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2019 a las 01:27:55
-- Versión del servidor: 10.1.33-MariaDB
-- Versión de PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cocesna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accionrespuestafiltro`
--

CREATE TABLE `accionrespuestafiltro` (
  `idAccionRespuestaFiltro` int(11) NOT NULL,
  `descripcionAccion` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `accionrespuestafiltro`
--

INSERT INTO `accionrespuestafiltro` (`idAccionRespuestaFiltro`, `descripcionAccion`) VALUES
(1, 'Finalizar Monitoreo'),
(2, 'Evaluar Estado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areaevaluacion`
--

CREATE TABLE `areaevaluacion` (
  `idAreaEvaluacion` int(11) NOT NULL,
  `descripcionAreaEvaluacion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idCartillaMonitoreoPersonal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `areaevaluacion`
--

INSERT INTO `areaevaluacion` (`idAreaEvaluacion`, `descripcionAreaEvaluacion`, `idCartillaMonitoreoPersonal`) VALUES
(10, 'Enfermedades', 1),
(11, 'Estado de ánimo', 1),
(16, 'Automedicación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartillamonitoreopersonal`
--

CREATE TABLE `cartillamonitoreopersonal` (
  `idCartilla` int(11) NOT NULL,
  `formatoCartilla` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `descripcionCartilla` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `cartillamonitoreopersonal`
--

INSERT INTO `cartillamonitoreopersonal` (`idCartilla`, `formatoCartilla`, `descripcionCartilla`) VALUES
(1, 'c002', 'Encuesta N°2 CENAMER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correosistema`
--

CREATE TABLE `correosistema` (
  `id_correo` int(11) NOT NULL,
  `correo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password_correo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `correosistema`
--

INSERT INTO `correosistema` (`id_correo`, `correo`, `password_correo`) VALUES
(1, 'pruebacocesna1@gmail.com', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestasrealizadas`
--

CREATE TABLE `encuestasrealizadas` (
  `id_encuestasRealizada` int(11) NOT NULL,
  `no_empleado` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `id_posicion` int(3) NOT NULL,
  `id_turno` int(3) NOT NULL,
  `fecha_aplicacion` date NOT NULL,
  `hora_aplicacion` time NOT NULL,
  `condicion_optima` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `encuestasrealizadas`
--

INSERT INTO `encuestasrealizadas` (`id_encuestasRealizada`, `no_empleado`, `id_posicion`, `id_turno`, `fecha_aplicacion`, `hora_aplicacion`, `condicion_optima`) VALUES
(23, 'emp11', 2, 2, '2019-09-25', '11:16:20', 0),
(24, 'emp11', 1, 1, '2019-09-26', '21:34:41', 1),
(28, 'emp-24', 1, 1, '2019-09-28', '20:41:37', 0),
(29, 'emp-25', 1, 2, '2019-09-28', '20:42:04', 1),
(30, 'emp-27', 2, 2, '2019-09-28', '20:42:47', 0),
(34, 'emp-26', 1, 1, '2019-09-28', '20:51:00', 1),
(38, 'emp-27', 3, 3, '2019-10-02', '09:34:35', 0),
(40, 'emp-24', 1, 2, '2019-10-02', '17:20:58', 1),
(62, 'emp13', 1, 1, '2019-10-06', '17:57:11', 0),
(71, 'emp-24', 1, 1, '2019-10-06', '18:20:54', 0),
(74, 'emp-27', 1, 1, '2019-10-06', '22:55:27', 1),
(82, 'emp-20', 1, 1, '2019-10-07', '23:15:00', 0),
(83, 'emp-24', 1, 1, '2019-10-07', '05:22:00', 0),
(87, 'emp-26', 1, 1, '2019-10-07', '20:21:00', 0),
(95, 'emp-26', 1, 1, '2019-10-09', '17:07:02', 0),
(96, 'emp-20', 1, 1, '2019-10-09', '05:30:00', 0),
(97, 'emp-21', 1, 1, '2019-10-09', '05:12:00', 0),
(98, 'emp-24', 1, 1, '2019-10-09', '17:18:33', 0),
(99, 'emp-27', 1, 1, '2019-10-09', '17:18:56', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacionestado`
--

CREATE TABLE `evaluacionestado` (
  `id_evaluacionEstado` int(11) NOT NULL,
  `id_encuestasRealizada` int(11) NOT NULL,
  `idAreaEvaluacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `evaluacionestado`
--

INSERT INTO `evaluacionestado` (`id_evaluacionEstado`, `id_encuestasRealizada`, `idAreaEvaluacion`) VALUES
(14, 23, 11),
(17, 28, 11),
(18, 30, 11),
(24, 38, 11),
(43, 62, 10),
(52, 71, 10),
(62, 82, 10),
(67, 83, 10),
(76, 95, 11),
(77, 96, 10),
(78, 97, 11),
(79, 98, 16),
(80, 99, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logins`
--

CREATE TABLE `logins` (
  `id_login` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `logins`
--

INSERT INTO `logins` (`id_login`, `id_user`, `fecha`, `hora`) VALUES
(8, 1, '2019-10-05', '15:37:44'),
(9, 2, '2019-10-05', '15:38:10'),
(10, 3, '2019-10-05', '15:54:22'),
(11, 4, '2019-10-05', '15:54:35'),
(12, 5, '2019-10-05', '17:07:06'),
(13, 6, '2019-10-05', '17:07:46'),
(14, 7, '2019-10-05', '17:08:04'),
(15, 8, '2019-10-05', '17:08:14'),
(16, 9, '2019-10-05', '17:08:24'),
(17, 10, '2019-10-05', '17:08:32'),
(18, 11, '2019-10-05', '17:08:54'),
(19, 12, '2019-10-05', '17:09:08'),
(20, 13, '2019-10-05', '17:09:18'),
(21, 14, '2019-10-05', '17:09:27'),
(22, 15, '2019-10-05', '17:09:54'),
(23, 16, '2019-10-05', '17:10:02'),
(24, 17, '2019-10-05', '17:10:11'),
(25, 18, '2019-10-05', '17:10:19'),
(26, 19, '2019-10-05', '17:10:27'),
(27, 20, '2019-10-05', '17:10:36'),
(28, 21, '2019-10-05', '17:10:48'),
(29, 22, '2019-10-05', '17:10:57'),
(30, 23, '2019-10-05', '17:11:15'),
(31, 24, '2019-10-05', '19:08:58'),
(32, 25, '2019-10-05', '21:27:13'),
(33, 26, '2019-10-05', '21:37:37'),
(34, 27, '2019-10-05', '21:41:38'),
(35, 28, '2019-10-05', '21:42:28'),
(36, 29, '2019-10-05', '21:43:20'),
(37, 30, '2019-10-05', '22:12:48'),
(38, 31, '2019-10-06', '00:25:35'),
(39, 32, '2019-10-06', '00:31:16'),
(40, 33, '2019-10-06', '01:04:19'),
(41, 34, '2019-10-06', '01:04:45'),
(42, 35, '2019-10-06', '01:36:54'),
(43, 36, '2019-10-06', '01:37:49'),
(44, 37, '2019-10-06', '01:38:33'),
(45, 38, '2019-10-06', '08:12:25'),
(46, 39, '2019-10-06', '09:42:01'),
(47, 40, '2019-10-06', '09:43:53'),
(48, 41, '2019-10-06', '09:46:32'),
(49, 42, '2019-10-06', '10:08:02'),
(50, 43, '2019-10-06', '10:09:32'),
(51, 44, '2019-10-06', '10:52:39'),
(52, 45, '2019-10-06', '10:54:24'),
(53, 46, '2019-10-06', '10:55:13'),
(54, 47, '2019-10-06', '10:55:36'),
(55, 48, '2019-10-06', '10:56:03'),
(56, 49, '2019-10-06', '10:58:12'),
(57, 50, '2019-10-06', '10:58:40'),
(58, 51, '2019-10-06', '10:58:59'),
(59, 52, '2019-10-06', '11:00:53'),
(60, 53, '2019-10-06', '11:01:23'),
(61, 54, '2019-10-06', '11:02:27'),
(62, 55, '2019-10-06', '11:03:04'),
(63, 56, '2019-10-06', '11:03:40'),
(64, 57, '2019-10-06', '11:04:21'),
(65, 58, '2019-10-06', '11:09:36'),
(66, 59, '2019-10-06', '11:10:15'),
(67, 60, '2019-10-06', '11:15:32'),
(68, 61, '2019-10-06', '11:15:59'),
(69, 62, '2019-10-06', '11:20:57'),
(70, 63, '2019-10-06', '11:34:32'),
(71, 64, '2019-10-06', '11:36:55'),
(72, 65, '2019-10-06', '11:37:32'),
(73, 66, '2019-10-06', '11:40:40'),
(74, 67, '2019-10-06', '11:41:26'),
(75, 68, '2019-10-06', '14:21:40'),
(76, 69, '2019-10-06', '17:15:59'),
(77, 70, '2019-10-06', '17:16:09'),
(78, 71, '2019-10-06', '17:22:46'),
(79, 72, '2019-10-06', '17:33:50'),
(80, 73, '2019-10-06', '17:38:22'),
(81, 74, '2019-10-06', '17:42:19'),
(82, 75, '2019-10-06', '17:53:08'),
(83, 76, '2019-10-06', '17:54:34'),
(84, 77, '2019-10-06', '17:56:18'),
(85, 78, '2019-10-06', '17:56:33'),
(86, 79, '2019-10-06', '17:58:02'),
(87, 80, '2019-10-06', '17:59:16'),
(88, 81, '2019-10-06', '18:00:07'),
(89, 82, '2019-10-06', '18:01:44'),
(90, 83, '2019-10-06', '18:02:29'),
(91, 84, '2019-10-06', '18:03:47'),
(92, 85, '2019-10-06', '18:04:45'),
(93, 86, '2019-10-06', '18:07:32'),
(94, 87, '2019-10-06', '18:10:05'),
(95, 88, '2019-10-06', '18:10:15'),
(96, 89, '2019-10-06', '18:23:53'),
(97, 90, '2019-10-06', '18:29:59'),
(98, 91, '2019-10-06', '18:58:39'),
(99, 92, '2019-10-06', '18:58:54'),
(100, 93, '2019-10-06', '19:34:16'),
(101, 94, '2019-10-06', '19:35:13'),
(102, 95, '2019-10-06', '20:18:13'),
(103, 96, '2019-10-06', '22:51:17'),
(104, 97, '2019-10-06', '22:55:19'),
(105, 98, '2019-10-06', '22:55:54'),
(106, 99, '2019-10-06', '23:05:39'),
(107, 100, '2019-10-06', '23:33:47'),
(108, 101, '2019-10-06', '23:48:41'),
(109, 102, '2019-10-06', '23:54:35'),
(110, 103, '2019-10-07', '00:26:57'),
(111, 104, '2019-10-07', '00:31:37'),
(112, 105, '2019-10-07', '00:32:11'),
(113, 106, '2019-10-07', '01:33:47'),
(114, 107, '2019-10-07', '06:56:50'),
(115, 108, '2019-10-07', '07:18:22'),
(116, 109, '2019-10-07', '07:19:45'),
(117, 110, '2019-10-07', '07:20:49'),
(118, 111, '2019-10-07', '07:35:22'),
(119, 112, '2019-10-07', '07:41:40'),
(120, 113, '2019-10-07', '07:44:42'),
(121, 114, '2019-10-07', '07:45:51'),
(122, 115, '2019-10-07', '07:47:26'),
(123, 116, '2019-10-07', '07:48:39'),
(124, 117, '2019-10-07', '07:49:45'),
(125, 118, '2019-10-07', '07:50:17'),
(126, 119, '2019-10-07', '07:52:47'),
(127, 120, '2019-10-07', '07:53:26'),
(128, 121, '2019-10-07', '07:53:38'),
(129, 122, '2019-10-07', '08:09:42'),
(130, 123, '2019-10-07', '08:10:18'),
(131, 124, '2019-10-07', '08:13:21'),
(132, 125, '2019-10-07', '08:13:35'),
(133, 126, '2019-10-07', '08:16:18'),
(134, 127, '2019-10-07', '08:19:41'),
(135, 128, '2019-10-07', '08:20:07'),
(136, 129, '2019-10-07', '08:24:07'),
(137, 130, '2019-10-07', '08:24:30'),
(138, 131, '2019-10-07', '08:25:28'),
(139, 132, '2019-10-07', '08:25:52'),
(140, 133, '2019-10-07', '08:26:20'),
(141, 134, '2019-10-07', '08:26:48'),
(142, 135, '2019-10-07', '08:27:08'),
(143, 136, '2019-10-07', '08:27:28'),
(144, 137, '2019-10-07', '08:28:27'),
(145, 138, '2019-10-07', '08:28:37'),
(146, 139, '2019-10-07', '08:37:44'),
(147, 140, '2019-10-07', '08:38:03'),
(148, 141, '2019-10-07', '09:04:41'),
(149, 142, '2019-10-07', '09:05:11'),
(150, 143, '2019-10-07', '09:05:42'),
(151, 144, '2019-10-07', '09:06:42'),
(152, 145, '2019-10-07', '09:08:02'),
(153, 146, '2019-10-07', '09:08:46'),
(154, 147, '2019-10-07', '09:08:59'),
(155, 148, '2019-10-07', '09:09:21'),
(156, 149, '2019-10-07', '09:10:52'),
(157, 150, '2019-10-07', '09:15:45'),
(158, 151, '2019-10-07', '15:54:12'),
(159, 152, '2019-10-07', '15:54:34'),
(160, 153, '2019-10-07', '16:08:44'),
(161, 154, '2019-10-07', '16:09:20'),
(162, 155, '2019-10-07', '16:09:55'),
(163, 156, '2019-10-07', '16:14:05'),
(164, 157, '2019-10-07', '16:14:17'),
(165, 158, '2019-10-07', '16:14:50'),
(166, 159, '2019-10-07', '16:19:08'),
(167, 160, '2019-10-07', '16:23:56'),
(168, 161, '2019-10-07', '16:26:31'),
(169, 162, '2019-10-07', '16:26:48'),
(170, 163, '2019-10-07', '16:27:01'),
(171, 164, '2019-10-07', '16:27:30'),
(172, 165, '2019-10-07', '16:29:14'),
(173, 166, '2019-10-07', '16:29:29'),
(174, 167, '2019-10-07', '16:29:52'),
(175, 168, '2019-10-07', '16:30:04'),
(176, 169, '2019-10-07', '16:33:20'),
(177, 170, '2019-10-07', '16:33:59'),
(178, 171, '2019-10-07', '16:34:53'),
(179, 172, '2019-10-07', '16:35:22'),
(180, 173, '2019-10-07', '16:35:42'),
(181, 174, '2019-10-07', '16:35:54'),
(182, 175, '2019-10-07', '16:36:12'),
(183, 176, '2019-10-07', '16:36:27'),
(184, 177, '2019-10-07', '16:40:20'),
(185, 178, '2019-10-07', '16:40:32'),
(186, 179, '2019-10-07', '16:40:47'),
(187, 180, '2019-10-07', '16:42:05'),
(188, 181, '2019-10-07', '17:03:45'),
(189, 182, '2019-10-07', '17:04:09'),
(190, 183, '2019-10-07', '17:08:10'),
(191, 184, '2019-10-07', '17:08:42'),
(192, 185, '2019-10-07', '17:08:55'),
(193, 186, '2019-10-07', '17:09:10'),
(194, 187, '2019-10-07', '17:09:22'),
(195, 188, '2019-10-07', '17:11:12'),
(196, 189, '2019-10-07', '17:11:34'),
(197, 190, '2019-10-07', '17:13:07'),
(198, 191, '2019-10-07', '17:13:18'),
(199, 192, '2019-10-07', '17:25:04'),
(200, 193, '2019-10-07', '20:14:40'),
(201, 194, '2019-10-07', '20:15:07'),
(202, 195, '2019-10-07', '20:17:26'),
(203, 196, '2019-10-09', '15:05:33'),
(204, 197, '2019-10-09', '15:37:44'),
(205, 198, '2019-10-09', '15:39:21'),
(206, 199, '2019-10-09', '15:47:39'),
(207, 200, '2019-10-09', '16:44:37'),
(208, 201, '2019-10-09', '16:45:59'),
(209, 202, '2019-10-09', '16:46:26'),
(210, 203, '2019-10-09', '16:48:47'),
(211, 204, '2019-10-09', '16:49:31'),
(212, 205, '2019-10-09', '16:49:53'),
(213, 206, '2019-10-09', '16:51:11'),
(214, 207, '2019-10-09', '16:51:48'),
(215, 208, '2019-10-09', '16:53:14'),
(216, 209, '2019-10-09', '16:55:37'),
(217, 210, '2019-10-09', '16:57:30'),
(218, 211, '2019-10-09', '16:57:47'),
(219, 212, '2019-10-09', '17:03:21'),
(220, 213, '2019-10-09', '17:09:04'),
(221, 214, '2019-10-09', '17:09:21'),
(222, 215, '2019-10-09', '17:09:42'),
(223, 216, '2019-10-09', '17:11:33'),
(224, 217, '2019-10-09', '17:12:06'),
(225, 218, '2019-10-09', '17:15:55'),
(226, 219, '2019-10-09', '17:17:54'),
(227, 220, '2019-10-09', '17:18:21'),
(228, 221, '2019-10-09', '17:18:48'),
(229, 222, '2019-10-09', '17:19:09'),
(230, 223, '2019-10-09', '17:20:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id_personal` int(3) NOT NULL,
  `nombres` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `sexo` enum('M','F','','') COLLATE latin1_spanish_ci NOT NULL,
  `no_empleado` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id_personal`, `nombres`, `apellidos`, `fecha_nacimiento`, `fecha_ingreso`, `sexo`, `no_empleado`, `activo`) VALUES
(1, 'Victor', 'Vance', '2019-09-01', '2019-09-02', 'M', 'emp1', 1),
(2, 'Tommy', 'Vercetti', '2019-09-02', '2019-09-03', 'M', 'emp2', 1),
(3, 'Carl', 'Johnson', '2019-09-04', '2019-09-06', 'M', 'emp3', 1),
(4, 'Toni', 'Cipriani', '2019-09-06', '2019-09-14', 'M', 'emp4', 1),
(5, 'Claude', 'Speed', '2019-09-12', '2019-09-11', 'M', 'emp5', 1),
(6, 'Niko', 'Bellic', '2019-09-11', '2019-09-15', 'M', 'emp6', 1),
(1, 'Raul Enrique', 'Castillo Flores', '1980-02-28', '2002-07-12', 'M', 'emp-20', 1),
(1, 'Jose Alejandro', 'Fiallos Ordoñez', '1977-05-16', '1996-06-15', 'M', 'emp-21', 1),
(1, 'Sandra Lizbeth', 'Mejía Raudales', '1995-08-29', '2010-01-13', 'F', 'emp-22', 1),
(1, 'Pedro Josué', 'Ramos Canales', '1999-09-10', '2019-05-10', 'M', 'emp-23', 1),
(1, 'Gabriela', 'Antunez Pozadas', '1990-11-15', '2007-01-23', 'F', 'emp-24', 1),
(1, 'Oscar Carlos', 'Perdomo Castillo', '1994-04-17', '2000-12-02', 'M', 'emp-25', 1),
(1, 'Christias Alejandro', 'Matute', '1993-11-14', '2008-06-19', 'M', 'emp-26', 1),
(1, 'Lizeth', 'Rodriguez Raudales', '1994-07-30', '2015-06-14', 'F', 'emp-27', 1),
(1, 'Nicole Abigail', 'Morales Flores', '1997-04-10', '2017-04-18', 'F', 'emp-28', 1),
(1, 'Miriam Alejandra', 'Valladares Rodriguez', '1992-10-15', '2018-05-23', 'F', 'emp-29', 1),
(1, 'Ruben Ariel', 'Escobar Canales', '1996-01-13', '2019-10-04', 'M', 'emp-30', 1),
(1, 'Jose Eduardo', 'Valladares Rodriguez', '1994-11-08', '2013-02-20', 'M', 'emp-31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicion`
--

CREATE TABLE `posicion` (
  `id_posicion` int(3) NOT NULL,
  `posicion` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `posicion`
--

INSERT INTO `posicion` (`id_posicion`, `posicion`) VALUES
(1, 'Posicion 1'),
(2, 'Posicion 2'),
(3, 'Posicion 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `idPregunta` int(11) NOT NULL,
  `idTipoRespuesta` int(11) NOT NULL,
  `idAreaEvaluacion` int(11) NOT NULL,
  `descripcionPregunta` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idPregunta`, `idTipoRespuesta`, `idAreaEvaluacion`, `descripcionPregunta`) VALUES
(18, 1, 10, '¿Tengo algún malestar físico?'),
(19, 1, 10, '¿Tengo algún dolor?'),
(20, 1, 10, '¿Tengo algún sintoma?'),
(21, 1, 10, '¿Representa ese síntoma alguna enfermedad?'),
(22, 1, 11, '¿Me siento bajo presión psicológica?'),
(23, 1, 11, '¿Siento que tengo problemas en mi ambiente laboral?'),
(24, 1, 11, '¿Siento que tengo problemas personales?'),
(25, 2, 11, '¿Que tan cansado se siente?'),
(26, 1, 11, '¿Tengo sueño constantemente?'),
(33, 1, 16, '¿Me encuentro usando algún medicamento autorecetado?'),
(34, 1, 16, '¿Me encuentro usando algún medicamento recomendado por un amigo?'),
(35, 1, 16, '¿He vuelto a tomar algún medicamento sin consultar a algún especialista?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntafiltro`
--

CREATE TABLE `preguntafiltro` (
  `idPreguntaFiltro` int(11) NOT NULL,
  `descripcionPreguntaFiltro` longtext COLLATE utf8_unicode_ci NOT NULL,
  `idCartilla` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `preguntafiltro`
--

INSERT INTO `preguntafiltro` (`idPreguntaFiltro`, `descripcionPreguntaFiltro`, `idCartilla`) VALUES
(1, '¿Se encuentra en condiciones para realizar su turno?', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rangorespuestasescalaxpregunta`
--

CREATE TABLE `rangorespuestasescalaxpregunta` (
  `idRango` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `valorMinimo` int(11) NOT NULL,
  `ValorMaximo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rangorespuestasescalaxpregunta`
--

INSERT INTO `rangorespuestasescalaxpregunta` (`idRango`, `idPregunta`, `valorMinimo`, `ValorMaximo`) VALUES
(6, 25, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisitospassword`
--

CREATE TABLE `requisitospassword` (
  `idRequisito` int(11) NOT NULL,
  `caracterEspecial` tinyint(4) NOT NULL,
  `digito` tinyint(4) NOT NULL,
  `minuscula` tinyint(4) NOT NULL,
  `mayuscula` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `requisitospassword`
--

INSERT INTO `requisitospassword` (`idRequisito`, `caracterEspecial`, `digito`, `minuscula`, `mayuscula`) VALUES
(1, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestacerradaxpregunta`
--

CREATE TABLE `respuestacerradaxpregunta` (
  `idRespuestaXPreguntaCerradas` int(11) NOT NULL,
  `RespuestaPermitida` longtext COLLATE utf8_unicode_ci NOT NULL,
  `idPreguntaCerrada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestafiltroxaccion`
--

CREATE TABLE `respuestafiltroxaccion` (
  `idRepuestaFiltroXAccion` int(11) NOT NULL,
  `idAccionRespuestaFiltro` int(11) NOT NULL,
  `idPreguntaFiltro` int(11) NOT NULL,
  `valorRespuesta` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `respuestafiltroxaccion`
--

INSERT INTO `respuestafiltroxaccion` (`idRepuestaFiltroXAccion`, `idAccionRespuestaFiltro`, `idPreguntaFiltro`, `valorRespuesta`) VALUES
(1, 1, 1, 'Si'),
(2, 2, 1, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestascerradas_x_evaluacionestado`
--

CREATE TABLE `respuestascerradas_x_evaluacionestado` (
  `id_RespuestaCerrada_X_EvaluacionEstado` int(11) NOT NULL,
  `id_evaluacionEstado` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `respuestaCerrada` varchar(10) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `respuestascerradas_x_evaluacionestado`
--

INSERT INTO `respuestascerradas_x_evaluacionestado` (`id_RespuestaCerrada_X_EvaluacionEstado`, `id_evaluacionEstado`, `idPregunta`, `respuestaCerrada`) VALUES
(8, 14, 22, 'No'),
(9, 14, 23, 'Si'),
(10, 14, 24, 'No'),
(11, 14, 26, 'Si'),
(19, 17, 22, 'No'),
(20, 17, 23, 'Si'),
(21, 17, 24, 'Si'),
(22, 17, 26, 'No'),
(23, 18, 22, 'Si'),
(24, 18, 23, 'No'),
(25, 18, 24, 'Si'),
(26, 18, 26, 'Si'),
(46, 24, 22, 'No'),
(47, 24, 23, 'No'),
(48, 24, 24, 'No'),
(49, 24, 26, 'No'),
(160, 43, 18, 'Si'),
(161, 43, 19, 'Si'),
(162, 43, 20, 'Si'),
(163, 43, 21, 'Si'),
(196, 52, 18, 'Si'),
(197, 52, 19, 'Si'),
(198, 52, 20, 'Si'),
(199, 52, 21, 'Si'),
(214, 62, 18, 'Si'),
(215, 62, 19, 'No'),
(216, 62, 20, 'Si'),
(217, 62, 21, 'No'),
(230, 67, 18, 'Si'),
(231, 67, 19, 'Si'),
(232, 67, 20, 'Si'),
(233, 67, 21, 'Si'),
(272, 76, 22, 'Si'),
(273, 76, 23, 'Si'),
(274, 76, 24, 'Si'),
(275, 76, 26, 'Si'),
(280, 77, 18, 'Si'),
(281, 77, 19, 'Si'),
(282, 77, 20, 'Si'),
(283, 77, 21, 'Si'),
(288, 78, 22, 'Si'),
(289, 78, 23, 'Si'),
(290, 78, 24, 'Si'),
(291, 78, 26, 'Si'),
(292, 79, 33, 'Si'),
(293, 79, 34, 'No'),
(294, 79, 35, 'Si'),
(295, 80, 33, 'Si'),
(296, 80, 34, 'Si'),
(297, 80, 35, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestasescalas_x_evaluacionestado`
--

CREATE TABLE `respuestasescalas_x_evaluacionestado` (
  `id_RespuestaEscala_X_EvaluacionEstado` int(11) NOT NULL,
  `id_evaluacionEstado` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `respuestaEscala` varchar(10) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `respuestasescalas_x_evaluacionestado`
--

INSERT INTO `respuestasescalas_x_evaluacionestado` (`id_RespuestaEscala_X_EvaluacionEstado`, `id_evaluacionEstado`, `idPregunta`, `respuestaEscala`) VALUES
(8, 14, 25, '3'),
(9, 17, 25, '3'),
(10, 18, 25, '3'),
(12, 24, 25, '5'),
(34, 76, 25, '1'),
(35, 78, 25, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seglog`
--

CREATE TABLE `seglog` (
  `SegLogKey` int(11) NOT NULL,
  `SegLogFecha` date DEFAULT NULL,
  `SegLogHora` time DEFAULT NULL,
  `SegUsrKey` int(11) DEFAULT NULL,
  `SegUsrUsuario` varchar(20) DEFAULT NULL,
  `SegLogDetalle` mediumtext,
  `SegLogLlave` int(11) DEFAULT NULL,
  `SegLogTabla` varchar(60) DEFAULT NULL,
  `SegLogAccion` mediumtext,
  `SegLogComando` mediumtext,
  `SegLogIp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seglog`
--

INSERT INTO `seglog` (`SegLogKey`, `SegLogFecha`, `SegLogHora`, `SegUsrKey`, `SegUsrUsuario`, `SegLogDetalle`, `SegLogLlave`, `SegLogTabla`, `SegLogAccion`, `SegLogComando`, `SegLogIp`) VALUES
(79, '2019-10-04', '21:42:41', 3, 'Ruben Ariel Escobar ', 'Eliminó [Dolor] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(80, '2019-10-04', '21:43:28', 3, 'Ruben Ariel Escobar ', 'Agregó [dolor] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(81, '2019-10-04', '21:43:59', 3, 'Ruben Ariel Escobar ', 'Agregó la pregunta [siente dolor] de tipo cerrada a la encuesta del área de evaluación [dolor]', NULL, NULL, NULL, NULL, NULL),
(82, '2019-10-04', '21:44:08', 3, 'Ruben Ariel Escobar ', 'Atualizó la pregunta con id [47] de la encuesta del área de evaluación [dolor]. Antiguos valores: (tipo: [Cerrada], descripcion: [siente dolor]). Nuevos valores: (tipo: [Escala], rango: [-], descripcion: [¿siente dolor?]).', NULL, NULL, NULL, NULL, NULL),
(83, '2019-10-04', '21:44:35', 3, 'Ruben Ariel Escobar ', 'Atualizó la pregunta con id [47] de la encuesta del área de evaluación [dolor]. Antiguos valores: (tipo: [Escala]). Nuevos valores: (tipo: [Cerrada]).', NULL, NULL, NULL, NULL, NULL),
(84, '2019-10-04', '21:45:00', 3, 'Ruben Ariel Escobar ', 'Agregó la pregunta [¿que tanto?] de tipo escala numérica con un rango de [1-3] a la encuesta del área de evaluación [dolor]', NULL, NULL, NULL, NULL, NULL),
(85, '2019-10-04', '21:45:13', 3, 'Ruben Ariel Escobar ', 'Atualizó la pregunta con id [48] de la encuesta del área de evaluación [dolor]. Antiguos valores: (rango: [1-3]). Nuevos valores: (rango: [1-5]).', NULL, NULL, NULL, NULL, NULL),
(86, '2019-10-04', '21:45:30', 3, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [¿que tanto?] de tipo [Escala] de la encuesta del área de evaluación [dolor]', NULL, NULL, NULL, NULL, NULL),
(87, '2019-10-04', '21:45:42', 3, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [¿siente dolor?] de tipo [Cerrada] de la encuesta del área de evaluación [dolor]', NULL, NULL, NULL, NULL, NULL),
(88, '2019-10-04', '21:46:02', 3, 'Ruben Ariel Escobar ', 'Renombró el área [dolor]. Nuevo valor: [A borrar]', NULL, NULL, NULL, NULL, NULL),
(89, '2019-10-04', '21:46:15', 3, 'Ruben Ariel Escobar ', 'Eliminó [A borrar] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(91, '2019-10-06', '19:34:42', 93, 'Ruben Ariel Escobar ', 'Actualizó la descripción de la pregunta filtro. Antíguo valor: [¿Se encuentra en condiciones para realizar su jornada? ]. Nuevo valor: [ ¿Se encuentra en condiciones para realizar su turno? ] ', NULL, NULL, NULL, NULL, NULL),
(92, '2019-10-06', '19:40:07', 94, 'Ruben Ariel Escobar ', 'Actualizó la descripción de la pregunta filtro. Antíguo valor: [¿Se encuentra en condiciones para realizar su turno? ]. Nuevo valor: [ ¿Se encuentra en condiciones para realizar su jornada? ] ', NULL, NULL, NULL, NULL, NULL),
(93, '2019-10-07', '07:16:38', 107, 'Ruben Ariel Escobar ', 'Agregó [Nerviosa] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(94, '2019-10-07', '07:17:04', 107, 'Ruben Ariel Escobar ', 'Agregó la pregunta [nerivos cerrada 1] de tipo cerrada a la encuesta del área de evaluación [Nerviosa]', NULL, NULL, NULL, NULL, NULL),
(95, '2019-10-07', '07:17:24', 107, 'Ruben Ariel Escobar ', 'Agregó la pregunta [nervios escala 1] de tipo escala numérica con un rango de [1-6] a la encuesta del área de evaluación [Nerviosa]', NULL, NULL, NULL, NULL, NULL),
(96, '2019-10-07', '07:20:56', 110, 'Ruben Ariel Escobar ', 'Eliminó [Nerviosa] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(97, '2019-10-07', '07:21:12', 110, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [nervios escala 1] de tipo [Escala] de la encuesta del área de evaluación [Nerviosa]', NULL, NULL, NULL, NULL, NULL),
(98, '2019-10-07', '07:21:16', 110, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [nerivos cerrada 1] de tipo [Cerrada] de la encuesta del área de evaluación [Nerviosa]', NULL, NULL, NULL, NULL, NULL),
(99, '2019-10-07', '07:21:22', 110, 'Ruben Ariel Escobar ', 'Eliminó [Nerviosa] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(100, '2019-10-07', '07:34:25', 110, 'Ruben Ariel Escobar ', 'Agregó [nervios] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(101, '2019-10-07', '07:34:36', 110, 'Ruben Ariel Escobar ', 'Agregó la pregunta [cerrada 1] de tipo cerrada a la encuesta del área de evaluación [nervios]', NULL, NULL, NULL, NULL, NULL),
(102, '2019-10-07', '07:34:48', 110, 'Ruben Ariel Escobar ', 'Agregó la pregunta [escala 1] de tipo escala numérica con un rango de [1-3] a la encuesta del área de evaluación [nervios]', NULL, NULL, NULL, NULL, NULL),
(103, '2019-10-07', '07:41:50', 112, 'Ruben Ariel Escobar ', 'Eliminó [nervios] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(104, '2019-10-07', '08:09:07', 121, 'Ruben Ariel Escobar ', 'Agregó [nervios] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(105, '2019-10-07', '08:09:16', 121, 'Ruben Ariel Escobar ', 'Agregó la pregunta [cerrada1] de tipo cerrada a la encuesta del área de evaluación [nervios]', NULL, NULL, NULL, NULL, NULL),
(106, '2019-10-07', '08:09:25', 121, 'Ruben Ariel Escobar ', 'Agregó la pregunta [escala 1] de tipo escala numérica con un rango de [1-5] a la encuesta del área de evaluación [nervios]', NULL, NULL, NULL, NULL, NULL),
(107, '2019-10-07', '08:11:16', 123, 'Ruben Ariel Escobar ', 'Eliminó [nervios] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(108, '2019-10-07', '08:12:47', 123, 'Ruben Ariel Escobar ', 'Agregó [nervios] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(109, '2019-10-07', '08:12:56', 123, 'Ruben Ariel Escobar ', 'Agregó la pregunta [asd] de tipo cerrada a la encuesta del área de evaluación [nervios]', NULL, NULL, NULL, NULL, NULL),
(110, '2019-10-07', '08:13:04', 123, 'Ruben Ariel Escobar ', 'Agregó la pregunta [gh] de tipo escala numérica con un rango de [1-2] a la encuesta del área de evaluación [nervios]', NULL, NULL, NULL, NULL, NULL),
(111, '2019-10-07', '08:16:27', 126, 'Ruben Ariel Escobar ', 'Eliminó [nervios] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(112, '2019-10-07', '08:19:02', 126, 'Ruben Ariel Escobar ', 'Agregó [f] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(113, '2019-10-07', '08:19:11', 126, 'Ruben Ariel Escobar ', 'Agregó la pregunta [2e] de tipo cerrada a la encuesta del área de evaluación [f]', NULL, NULL, NULL, NULL, NULL),
(114, '2019-10-07', '08:19:18', 126, 'Ruben Ariel Escobar ', 'Agregó la pregunta [] de tipo escala numérica con un rango de [2-3] a la encuesta del área de evaluación [f]', NULL, NULL, NULL, NULL, NULL),
(115, '2019-10-07', '08:19:21', 126, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [] de tipo [Escala] de la encuesta del área de evaluación [f]', NULL, NULL, NULL, NULL, NULL),
(116, '2019-10-07', '08:19:31', 126, 'Ruben Ariel Escobar ', 'Agregó la pregunta [jj] de tipo escala numérica con un rango de [1-4] a la encuesta del área de evaluación [f]', NULL, NULL, NULL, NULL, NULL),
(117, '2019-10-07', '08:20:13', 128, 'Ruben Ariel Escobar ', 'Eliminó [f] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(118, '2019-10-07', '08:23:34', 128, 'Ruben Ariel Escobar ', 'Agregó [t] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(119, '2019-10-07', '08:23:48', 128, 'Ruben Ariel Escobar ', 'Agregó la pregunta [cerrada] de tipo cerrada a la encuesta del área de evaluación [t]', NULL, NULL, NULL, NULL, NULL),
(120, '2019-10-07', '08:23:54', 128, 'Ruben Ariel Escobar ', 'Agregó la pregunta [] de tipo escala numérica con un rango de [1-4] a la encuesta del área de evaluación [t]', NULL, NULL, NULL, NULL, NULL),
(121, '2019-10-07', '08:25:14', 130, 'Ruben Ariel Escobar ', 'Eliminó [t] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(122, '2019-10-07', '08:25:59', 132, 'Ruben Ariel Escobar ', 'Agregó [k] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(123, '2019-10-07', '08:26:07', 132, 'Ruben Ariel Escobar ', 'Agregó la pregunta [r] de tipo cerrada a la encuesta del área de evaluación [k]', NULL, NULL, NULL, NULL, NULL),
(124, '2019-10-07', '08:26:54', 134, 'Ruben Ariel Escobar ', 'Eliminó [k] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(125, '2019-10-07', '17:25:37', 192, 'Ruben Ariel Escobar ', 'Agregó [Nervios] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(126, '2019-10-07', '17:26:12', 192, 'Ruben Ariel Escobar ', 'Agregó la pregunta [pregunta de escala] de tipo escala numérica con un rango de [1-10] a la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(127, '2019-10-07', '17:36:22', 192, 'Ruben Ariel Escobar ', 'Agregó la pregunta [pregunta cerrada] de tipo cerrada a la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(128, '2019-10-07', '17:36:40', 192, 'Ruben Ariel Escobar ', 'Agregó la pregunta [pregunta escala] de tipo escala numérica con un rango de [1-2] a la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(129, '2019-10-07', '17:50:01', 192, 'Ruben Ariel Escobar ', 'Agregó la pregunta [pregunta Escala] de tipo escala numérica con un rango de [1-5] a la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(130, '2019-10-07', '17:50:14', 192, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [pregunta Escala] de tipo [Escala] de la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(131, '2019-10-07', '17:50:24', 192, 'Ruben Ariel Escobar ', 'Agregó la pregunta [escala] de tipo escala numérica con un rango de [1-5] a la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(132, '2019-10-07', '17:54:00', 192, 'Ruben Ariel Escobar ', 'Eliminó la pregunta [escala] de tipo [Escala] de la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(133, '2019-10-07', '17:54:06', 192, 'Ruben Ariel Escobar ', 'Agregó la pregunta [escala numerica] de tipo cerrada a la encuesta del área de evaluación [Nervios]', NULL, NULL, NULL, NULL, NULL),
(134, '2019-10-07', '20:16:13', 194, 'Ruben Ariel Escobar ', 'Eliminó [Automedicación] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(135, '2019-10-09', '15:10:22', 196, 'Ruben Ariel Escobar ', 'Actualizó la descripción de la pregunta filtro. Antíguo valor: [¿Se encuentra en condiciones para realizar su jornada? ]. Nuevo valor: [ ¿Se encuentra en condiciones para realizar su turno? ] ', NULL, NULL, NULL, NULL, NULL),
(136, '2019-10-09', '15:47:50', 199, 'Ruben Ariel Escobar ', 'Agregó [Jaqueca] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(137, '2019-10-09', '15:47:55', 199, 'Ruben Ariel Escobar ', 'Eliminó [Jaqueca] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(138, '2019-10-09', '15:49:30', 199, 'Ruben Ariel Escobar ', 'Agregó [Mareo] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(139, '2019-10-09', '15:50:05', 199, 'Ruben Ariel Escobar ', 'Eliminó [Mareo] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(140, '2019-10-09', '15:50:56', 199, 'Ruben Ariel Escobar ', 'Agregó [hh] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(141, '2019-10-09', '15:51:00', 199, 'Ruben Ariel Escobar ', 'Eliminó [hh] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(142, '2019-10-09', '17:16:02', 218, 'Ruben Ariel Escobar ', 'Eliminó [Nervios] de la lista de áreas de evaluacion', NULL, NULL, NULL, NULL, NULL),
(143, '2019-10-09', '17:16:15', 218, 'Ruben Ariel Escobar ', 'Agregó [Automedicación] como nueva área de evaluacion', NULL, NULL, NULL, NULL, NULL),
(144, '2019-10-09', '17:16:42', 218, 'Ruben Ariel Escobar ', 'Agregó la pregunta [¿Me encuentro usando algún medicamento autorecetado?] de tipo cerrada a la encuesta del área de evaluación [Automedicación]', NULL, NULL, NULL, NULL, NULL),
(145, '2019-10-09', '17:17:08', 218, 'Ruben Ariel Escobar ', 'Agregó la pregunta [¿Me encuentro usando algún medicamento recomendado por un amigo?] de tipo cerrada a la encuesta del área de evaluación [Automedicación]', NULL, NULL, NULL, NULL, NULL),
(146, '2019-10-09', '17:17:38', 218, 'Ruben Ariel Escobar ', 'Agregó la pregunta [¿He vuelto a tomar algún medicamento sin consultar a algún especialista?] de tipo cerrada a la encuesta del área de evaluación [Automedicación]', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiporespuesta`
--

CREATE TABLE `tiporespuesta` (
  `idTipoRespuesta` int(11) NOT NULL,
  `descripcionTipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tiporespuesta`
--

INSERT INTO `tiporespuesta` (`idTipoRespuesta`, `descripcionTipo`) VALUES
(1, 'cerrada'),
(2, 'escala numerica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposusuario`
--

CREATE TABLE `tiposusuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `descripcionTipoUsuario` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tiposusuario`
--

INSERT INTO `tiposusuario` (`idTipoUsuario`, `descripcionTipoUsuario`) VALUES
(1, 'Administrador'),
(2, 'Controlador'),
(4, 'R.R.H.H.'),
(3, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id_turno` int(3) NOT NULL,
  `turno` varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id_turno`, `turno`, `hora_inicio`, `hora_fin`, `activo`) VALUES
(1, 'Mañana', '08:00:00', '12:00:00', 1),
(2, 'Tarde', '12:00:00', '18:00:00', 1),
(3, 'Noche', '18:00:00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Raul Enrique Castillo Flores', 'auth_key1', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Raul@gmail.com', 10, 201905, 201905, NULL),
(2, 'Sandra Lizbeth Mejía Raudales', 'auth_key2', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201905, 201905, NULL),
(3, 'John Doe RRHH', 'auth_key3', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201905, 201905, NULL),
(4, 'Fulano de Tal', 'auth_key4', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'ft@gmail.com', 10, 201905, 201905, NULL),
(5, 'Ruben Ariel Escobar Canales', 'auth_key5', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201905, 201905, NULL),
(6, 'Raul Enrique Castillo Flores', 'auth_key6', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Raul@gmail.com', 10, 201905, 201905, NULL),
(7, 'Jose Alejandro Fiallos Ordoñez', 'auth_key7', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'joseAlejandro@gmail.com', 10, 201905, 201905, NULL),
(8, 'Sandra Lizbeth Mejía Raudales', 'auth_key8', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201905, 201905, NULL),
(9, 'Gabriela Antunez Pozadas', 'auth_key9', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201905, 201905, NULL),
(10, 'Oscar Carlos Perdomo Castillo', 'auth_key10', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201905, 201905, NULL),
(11, 'Christias Alejandro Matute', 'auth_key11', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'christian@gmail.com', 10, 201905, 201905, NULL),
(12, 'Nicole Abigail Morales Flores', 'auth_key12', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'nicole@gmail.com', 10, 201905, 201905, NULL),
(13, 'Ruben Ariel Escobar Canales', 'auth_key13', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201905, 201905, NULL),
(14, 'Ruben Ariel Escobar Canales', 'auth_key14', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201905, 201905, NULL),
(15, 'Sandra Lizbeth Mejía Raudales', 'auth_key15', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201905, 201905, NULL),
(16, 'Pedro Josué Ramos Canales', 'auth_key16', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201905, 201905, NULL),
(17, 'Gabriela Antunez Pozadas', 'auth_key17', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201905, 201905, NULL),
(18, 'Oscar Carlos Perdomo Castillo', 'auth_key18', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201905, 201905, NULL),
(19, 'Christias Alejandro Matute', 'auth_key19', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'christian@gmail.com', 10, 201905, 201905, NULL),
(20, 'Miriam Alejandra Valladares Rodriguez', 'auth_key20', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'miriam@gmail.com', 10, 201905, 201905, NULL),
(21, 'Sandra Lizbeth Mejía Raudales', 'auth_key21', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201905, 201905, NULL),
(22, 'Christias Alejandro Matute', 'auth_key22', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'christian@gmail.com', 10, 201905, 201905, NULL),
(23, 'Ruben Ariel Escobar Canales', 'auth_key23', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201905, 201905, NULL),
(24, 'Ruben Ariel Escobar Canales', 'auth_key24', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201905, 201905, NULL),
(25, 'Jose Eduardo Valladares Rodriguez', 'auth_key25', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201905, 201905, NULL),
(26, 'Ruben Ariel Escobar Canales', 'auth_key26', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201905, 201905, NULL),
(27, 'John Doe RRHH', 'auth_key27', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201905, 201905, NULL),
(28, 'Sandra Lizbeth Mejía Raudales', 'auth_key28', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201905, 201905, NULL),
(29, 'John Doe RRHH', 'auth_key29', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201905, 201905, NULL),
(30, 'Jose Eduardo Valladares Rodriguez', 'auth_key30', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201905, 201905, NULL),
(31, 'Pedro Josué Ramos Canales', 'auth_key31', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201906, 201906, NULL),
(32, 'Jose Eduardo Valladares Rodriguez', 'auth_key32', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(33, 'Ruben Ariel Escobar Canales', 'auth_key33', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(34, 'Jose Eduardo Valladares Rodriguez', 'auth_key34', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(35, 'Ruben Ariel Escobar Canales', 'auth_key35', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(36, 'Jose Eduardo Valladares Rodriguez', 'auth_key36', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(37, 'Jose Eduardo Valladares Rodriguez', 'auth_key37', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(38, 'Jose Eduardo Valladares Rodriguez', 'auth_key38', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(39, 'Pedro Josué Ramos Canales', 'auth_key39', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201906, 201906, NULL),
(40, 'Jose Eduardo Valladares Rodriguez', 'auth_key40', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(41, 'Sandra Lizbeth Mejía Raudales', 'auth_key41', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(42, 'Jose Eduardo Valladares Rodriguez', 'auth_key42', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(43, 'Jose Eduardo Valladares Rodriguez', 'auth_key43', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(44, 'Lizeth Rodriguez Raudales', 'auth_key44', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Liz@gmail.com', 10, 201906, 201906, NULL),
(45, 'Jose Eduardo Valladares Rodriguez', 'auth_key45', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(46, 'Ruben Ariel Escobar Canales', 'auth_key46', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(47, 'Ruben Ariel Escobar Canales', 'auth_key47', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(48, 'John Doe RRHH', 'auth_key48', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(49, 'Lizeth Rodriguez Raudales', 'auth_key49', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Liz@gmail.com', 10, 201906, 201906, NULL),
(50, 'Ruben Ariel Escobar Canales', 'auth_key50', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(51, 'John Doe RRHH', 'auth_key51', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(52, 'Sandra Lizbeth Mejía Raudales', 'auth_key52', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(53, 'John Doe RRHH', 'auth_key53', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(54, 'Sandra Lizbeth Mejía Raudales', 'auth_key54', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(55, 'John Doe RRHH', 'auth_key55', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(56, 'Jose Eduardo Valladares Rodriguez', 'auth_key56', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(57, 'John Doe RRHH', 'auth_key57', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(58, 'Sandra Lizbeth Mejía Raudales', 'auth_key58', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(59, 'Jose Eduardo Valladares Rodriguez', 'auth_key59', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(60, 'Sandra Lizbeth Mejía Raudales', 'auth_key60', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(61, 'Sandra Lizbeth Mejía Raudales', 'auth_key61', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(62, 'Jose Eduardo Valladares Rodriguez', 'auth_key62', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(63, 'Jose Eduardo Valladares Rodriguez', 'auth_key63', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(64, 'Jose Eduardo Valladares Rodriguez', 'auth_key64', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(65, 'Jose Eduardo Valladares Rodriguez', 'auth_key65', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(66, 'Sandra Lizbeth Mejía Raudales', 'auth_key66', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(67, 'Jose Eduardo Valladares Rodriguez', 'auth_key67', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'josevalladares@gmail.com', 10, 201906, 201906, NULL),
(68, 'Ruben Ariel Escobar Canales', 'auth_key68', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(69, 'Gabriela Antunez Pozadas', 'auth_key69', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201906, 201906, NULL),
(70, 'Oscar Carlos Perdomo Castillo', 'auth_key70', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201906, 201906, NULL),
(71, 'John Doe RRHH', 'auth_key71', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(72, 'Oscar Carlos Perdomo Castillo', 'auth_key72', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201906, 201906, NULL),
(73, 'John Doe RRHH', 'auth_key73', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(74, 'Sandra Lizbeth Mejía Raudales', 'auth_key74', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(75, 'Pedro Josué Ramos Canales', 'auth_key75', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201906, 201906, NULL),
(76, 'Gabriela Antunez Pozadas', 'auth_key76', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201906, 201906, NULL),
(77, 'Ruben Ariel Escobar Canales', 'auth_key77', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(78, 'John Doe RRHH', 'auth_key78', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(79, 'Gabriela Antunez Pozadas', 'auth_key79', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201906, 201906, NULL),
(80, 'Oscar Carlos Perdomo Castillo', 'auth_key80', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201906, 201906, NULL),
(81, 'Raul Enrique Castillo Flores', 'auth_key81', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Raul@gmail.com', 10, 201906, 201906, NULL),
(82, 'Lizeth Rodriguez Raudales', 'auth_key82', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Liz@gmail.com', 10, 201906, 201906, NULL),
(83, 'Nicole Abigail Morales Flores', 'auth_key83', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'nicole@gmail.com', 10, 201906, 201906, NULL),
(84, 'John Doe RRHH', 'auth_key84', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(85, 'Sandra Lizbeth Mejía Raudales', 'auth_key85', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(86, 'Pedro Josué Ramos Canales', 'auth_key86', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201906, 201906, NULL),
(87, 'Pedro Josué Ramos Canales', 'auth_key87', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201906, 201906, NULL),
(88, 'Gabriela Antunez Pozadas', 'auth_key88', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201906, 201906, NULL),
(89, 'Oscar Carlos Perdomo Castillo', 'auth_key89', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201906, 201906, NULL),
(90, 'Jose Eduardo Valladares Rodriguez', 'auth_key90', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(91, 'John Doe RRHH', 'auth_key91', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(92, 'Jose Eduardo Valladares Rodriguez', 'auth_key92', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(93, 'Ruben Ariel Escobar Canales', 'auth_key93', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(94, 'Ruben Ariel Escobar Canales', 'auth_key94', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(95, 'Ruben Ariel Escobar Canales', 'auth_key95', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(96, 'Sandra Lizbeth Mejía Raudales', 'auth_key96', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201906, 201906, NULL),
(97, 'Lizeth Rodriguez Raudales', 'auth_key97', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Liz@gmail.com', 10, 201906, 201906, NULL),
(98, 'John Doe RRHH', 'auth_key98', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201906, 201906, NULL),
(99, 'Jose Eduardo Valladares Rodriguez', 'auth_key99', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(100, 'Ruben Ariel Escobar Canales', 'auth_key100', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(101, 'Ruben Ariel Escobar Canales', 'auth_key101', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(102, 'Ruben Ariel Escobar Canales', 'auth_key102', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201906, 201906, NULL),
(103, 'Ruben Ariel Escobar Canales', 'auth_key103', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(104, 'Ruben Ariel Escobar Canales', 'auth_key104', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(105, 'Ruben Ariel Escobar Canales', 'auth_key105', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(106, 'Ruben Ariel Escobar Canales', 'auth_key106', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(107, 'Ruben Ariel Escobar Canales', 'auth_key107', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(108, 'Sandra Lizbeth Mejía Raudales', 'auth_key108', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(109, 'John Doe RRHH', 'auth_key109', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(110, 'Ruben Ariel Escobar Canales', 'auth_key110', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(111, 'Sandra Lizbeth Mejía Raudales', 'auth_key111', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(112, 'Ruben Ariel Escobar Canales', 'auth_key112', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(113, 'Ruben Ariel Escobar Canales', 'auth_key113', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(114, 'Ruben Ariel Escobar Canales', 'auth_key114', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(115, 'Ruben Ariel Escobar Canales', 'auth_key115', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(116, 'Ruben Ariel Escobar Canales', 'auth_key116', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(117, 'Ruben Ariel Escobar Canales', 'auth_key117', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(118, 'Ruben Ariel Escobar Canales', 'auth_key118', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(119, 'Ruben Ariel Escobar Canales', 'auth_key119', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(120, 'Sandra Lizbeth Mejía Raudales', 'auth_key120', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(121, 'Ruben Ariel Escobar Canales', 'auth_key121', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(122, 'Sandra Lizbeth Mejía Raudales', 'auth_key122', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(123, 'Ruben Ariel Escobar Canales', 'auth_key123', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(124, 'Ruben Ariel Escobar Canales', 'auth_key124', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(125, 'Sandra Lizbeth Mejía Raudales', 'auth_key125', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(126, 'Ruben Ariel Escobar Canales', 'auth_key126', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(127, 'Sandra Lizbeth Mejía Raudales', 'auth_key127', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(128, 'Ruben Ariel Escobar Canales', 'auth_key128', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(129, 'Sandra Lizbeth Mejía Raudales', 'auth_key129', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(130, 'Ruben Ariel Escobar Canales', 'auth_key130', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(131, 'Sandra Lizbeth Mejía Raudales', 'auth_key131', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(132, 'Ruben Ariel Escobar Canales', 'auth_key132', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(133, 'Sandra Lizbeth Mejía Raudales', 'auth_key133', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(134, 'Ruben Ariel Escobar Canales', 'auth_key134', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(135, 'Sandra Lizbeth Mejía Raudales', 'auth_key135', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(136, 'John Doe RRHH', 'auth_key136', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(137, 'Sandra Lizbeth Mejía Raudales', 'auth_key137', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(138, 'Jose Eduardo Valladares Rodriguez', 'auth_key138', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(139, 'Jose Eduardo Valladares Rodriguez', 'auth_key139', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(140, 'John Doe RRHH', 'auth_key140', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(141, 'John Doe RRHH', 'auth_key141', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(142, 'Jose Eduardo Valladares Rodriguez', 'auth_key142', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(143, 'Ruben Ariel Escobar Canales', 'auth_key143', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(144, 'Ruben Ariel Escobar Canales', 'auth_key144', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(145, 'Ruben Ariel Escobar Canales', 'auth_key145', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(146, 'Ruben Ariel Escobar Canales', 'auth_key146', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(147, 'Ruben Ariel Escobar Canales', 'auth_key147', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(148, 'Pedro Josué Ramos Canales', 'auth_key148', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201907, 201907, NULL),
(149, 'Ruben Ariel Escobar Canales', 'auth_key149', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(150, 'Pedro Josué Ramos Canales', 'auth_key150', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Pedro@gmail.com', 10, 201907, 201907, NULL),
(151, 'Ruben Ariel Escobar Canales', 'auth_key151', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(152, 'Sandra Lizbeth Mejía Raudales', 'auth_key152', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(153, 'Ruben Ariel Escobar Canales', 'auth_key153', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(154, 'Ruben Ariel Escobar Canales', 'auth_key154', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(155, 'Ruben Ariel Escobar Canales', 'auth_key155', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(156, 'Ruben Ariel Escobar Canales', 'auth_key156', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(157, 'Sandra Lizbeth Mejía Raudales', 'auth_key157', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(158, 'Fulano de Tal', 'auth_key158', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'ft@gmail.com', 10, 201907, 201907, NULL),
(159, 'Sandra Lizbeth Mejía Raudales', 'auth_key159', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(160, 'Ruben Ariel Escobar Canales', 'auth_key160', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(161, 'Ruben Ariel Escobar Canales', 'auth_key161', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(162, 'Sandra Lizbeth Mejía Raudales', 'auth_key162', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(163, 'Ruben Ariel Escobar Canales', 'auth_key163', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(164, 'Sandra Lizbeth Mejía Raudales', 'auth_key164', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(165, 'Ruben Ariel Escobar Canales', 'auth_key165', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(166, 'Sandra Lizbeth Mejía Raudales', 'auth_key166', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(167, 'Ruben Ariel Escobar Canales', 'auth_key167', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(168, 'Sandra Lizbeth Mejía Raudales', 'auth_key168', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(169, 'Ruben Ariel Escobar Canales', 'auth_key169', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(170, 'Sandra Lizbeth Mejía Raudales', 'auth_key170', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(171, 'Ruben Ariel Escobar Canales', 'auth_key171', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(172, 'Ruben Ariel Escobar Canales', 'auth_key172', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(173, 'Sandra Lizbeth Mejía Raudales', 'auth_key173', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(174, 'Ruben Ariel Escobar Canales', 'auth_key174', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(175, 'Sandra Lizbeth Mejía Raudales', 'auth_key175', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(176, 'Ruben Ariel Escobar Canales', 'auth_key176', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(177, 'Sandra Lizbeth Mejía Raudales', 'auth_key177', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(178, 'Ruben Ariel Escobar Canales', 'auth_key178', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(179, 'Ruben Ariel Escobar Canales', 'auth_key179', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(180, 'Sandra Lizbeth Mejía Raudales', 'auth_key180', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(181, 'John Doe RRHH', 'auth_key181', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(182, 'Ruben Ariel Escobar Canales', 'auth_key182', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(183, 'John Doe RRHH', 'auth_key183', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(184, 'Ruben Ariel Escobar Canales', 'auth_key184', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(185, 'John Doe RRHH', 'auth_key185', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(186, 'John Doe RRHH', 'auth_key186', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201907, 201907, NULL),
(187, 'Ruben Ariel Escobar Canales', 'auth_key187', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(188, 'Jose Eduardo Valladares Rodriguez', 'auth_key188', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(189, 'Ruben Ariel Escobar Canales', 'auth_key189', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(190, 'Sandra Lizbeth Mejía Raudales', 'auth_key190', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(191, 'Ruben Ariel Escobar Canales', 'auth_key191', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(192, 'Ruben Ariel Escobar Canales', 'auth_key192', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(193, 'Sandra Lizbeth Mejía Raudales', 'auth_key193', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Sandra@gmail.com', 10, 201907, 201907, NULL),
(194, 'Ruben Ariel Escobar Canales', 'auth_key194', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(195, 'Jose Eduardo Valladares Rodriguez', 'auth_key195', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201907, 201907, NULL),
(196, 'Ruben Ariel Escobar Canales', 'auth_key196', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(197, 'John Doe RRHH', 'auth_key197', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'jdrh@gmail.com', 10, 201909, 201909, NULL),
(198, 'Jose Eduardo Valladares Rodriguez', 'auth_key198', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(199, 'Ruben Ariel Escobar Canales', 'auth_key199', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(200, 'Lizeth Rodriguez Raudales', 'auth_key200', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Liz@gmail.com', 10, 201909, 201909, NULL),
(201, 'Ruben Ariel Escobar Canales', 'auth_key201', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(202, 'Nicole Abigail Morales Flores', 'auth_key202', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'nicole@gmail.com', 10, 201909, 201909, NULL),
(203, 'Oscar Carlos Perdomo Castillo', 'auth_key203', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'oscar@gmail.com', 10, 201909, 201909, NULL),
(204, 'Ruben Ariel Escobar Canales', 'auth_key204', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(205, 'Gabriela Antunez Pozadas', 'auth_key205', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201909, 201909, NULL),
(206, 'Jose Alejandro Fiallos Ordoñez', 'auth_key206', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'joseAlejandro@gmail.com', 10, 201909, 201909, NULL),
(207, 'Ruben Ariel Escobar Canales', 'auth_key207', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(208, 'Christias Alejandro Matute', 'auth_key208', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'christian@gmail.com', 10, 201909, 201909, NULL),
(209, 'Ruben Ariel Escobar Canales', 'auth_key209', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(210, 'Ruben Ariel Escobar Canales', 'auth_key210', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(211, 'Jose Alejandro Fiallos Ordoñez', 'auth_key211', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'joseAlejandro@gmail.com', 10, 201909, 201909, NULL),
(212, 'Christias Alejandro Matute', 'auth_key212', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'christian@gmail.com', 10, 201909, 201909, NULL),
(213, 'Jose Eduardo Valladares Rodriguez', 'auth_key213', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(214, 'Ruben Ariel Escobar Canales', 'auth_key214', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(215, 'Jose Eduardo Valladares Rodriguez', 'auth_key215', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(216, 'Ruben Ariel Escobar Canales', 'auth_key216', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(217, 'Jose Eduardo Valladares Rodriguez', 'auth_key217', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(218, 'Ruben Ariel Escobar Canales', 'auth_key218', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(219, 'Jose Alejandro Fiallos Ordoñez', 'auth_key219', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'joseAlejandro@gmail.com', 10, 201909, 201909, NULL),
(220, 'Gabriela Antunez Pozadas', 'auth_key220', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Gabriela@gmail.com', 10, 201909, 201909, NULL),
(221, 'Lizeth Rodriguez Raudales', 'auth_key221', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'Liz@gmail.com', 10, 201909, 201909, NULL),
(222, 'Ruben Ariel Escobar Canales', 'auth_key222', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL),
(223, 'Ruben Ariel Escobar Canales', 'auth_key223', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', NULL, 'escobarruben837@gmail.com', 10, 201909, 201909, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `no_empleado` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `idTipoUsuario` int(11) NOT NULL,
  `nombre` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `correo` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`no_empleado`, `idTipoUsuario`, `nombre`, `password`, `correo`) VALUES
('emp-20', 2, 'Raul Enrique Castillo Flores', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'Raul@gmail.com'),
('emp-21', 2, 'Jose Alejandro Fiallos Ordoñez', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'joseAlejandro@gmail.com'),
('emp-24', 2, 'Gabriela Antunez Pozadas', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'Gabriela@gmail.com'),
('emp-25', 2, 'Oscar Carlos Perdomo Castillo', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'oscar@gmail.com'),
('emp-26', 2, 'Christias Alejandro Matute', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'christian@gmail.com'),
('emp-27', 2, 'Lizeth Rodriguez Raudales', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'Liz@gmail.com'),
('emp-28', 2, 'Nicole Abigail Morales Flores', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'nicole@gmail.com'),
('emp-29', 2, 'Miriam Alejandra Valladares Rodriguez', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'miriam@gmail.com'),
('emp-30', 1, 'Ruben Ariel Escobar Canales', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'escobarruben837@gmail.com'),
('emp-31', 3, 'Jose Eduardo Valladares Rodriguez', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'escobarruben837@gmail.com'),
('emp11', 2, 'John Doe', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'jdoe@gmail.com'),
('emp12', 1, 'Fulano de Tal', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'ft@gmail.com'),
('emp13', 4, 'John Doe RRHH', 'bU9GWGRJT2xhckQxSmszZjdRRVJvZz09', 'jdrh@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accionrespuestafiltro`
--
ALTER TABLE `accionrespuestafiltro`
  ADD PRIMARY KEY (`idAccionRespuestaFiltro`),
  ADD UNIQUE KEY `idAccionRespuestaFiltro` (`idAccionRespuestaFiltro`);

--
-- Indices de la tabla `areaevaluacion`
--
ALTER TABLE `areaevaluacion`
  ADD PRIMARY KEY (`idAreaEvaluacion`),
  ADD UNIQUE KEY `idAreaEvaluacion_UNIQUE` (`idAreaEvaluacion`),
  ADD KEY `FK_AreaEvaluacion_CartillaMonitoreoPersonal` (`idCartillaMonitoreoPersonal`);

--
-- Indices de la tabla `cartillamonitoreopersonal`
--
ALTER TABLE `cartillamonitoreopersonal`
  ADD PRIMARY KEY (`idCartilla`),
  ADD UNIQUE KEY `idCartilla_UNIQUE` (`idCartilla`);

--
-- Indices de la tabla `correosistema`
--
ALTER TABLE `correosistema`
  ADD PRIMARY KEY (`id_correo`),
  ADD UNIQUE KEY `id_correo` (`id_correo`);

--
-- Indices de la tabla `encuestasrealizadas`
--
ALTER TABLE `encuestasrealizadas`
  ADD PRIMARY KEY (`id_encuestasRealizada`),
  ADD UNIQUE KEY `id_encuestasRealizada` (`id_encuestasRealizada`),
  ADD KEY `FK_Encuestas_Usuarios` (`no_empleado`);

--
-- Indices de la tabla `evaluacionestado`
--
ALTER TABLE `evaluacionestado`
  ADD PRIMARY KEY (`id_evaluacionEstado`),
  ADD UNIQUE KEY `id_evaluacionEstado` (`id_evaluacionEstado`),
  ADD KEY `FK_EvaluacionEstado_AreaEvaluacion` (`idAreaEvaluacion`),
  ADD KEY `FK_EvaluacionEstado_EncuestaRealizada` (`id_encuestasRealizada`);

--
-- Indices de la tabla `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `id_login` (`id_login`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`idPregunta`),
  ADD UNIQUE KEY `idPregunta_UNIQUE` (`idPregunta`),
  ADD KEY `FK_pregunta_TipoRespuesta` (`idTipoRespuesta`),
  ADD KEY `FK_Pregunta_AreaEvaluacion` (`idAreaEvaluacion`);

--
-- Indices de la tabla `preguntafiltro`
--
ALTER TABLE `preguntafiltro`
  ADD PRIMARY KEY (`idPreguntaFiltro`),
  ADD UNIQUE KEY `idPreguntaFiltro` (`idPreguntaFiltro`),
  ADD KEY `FK_PreguntaFiltro_CartillaMonitoreoPersonal` (`idCartilla`);

--
-- Indices de la tabla `rangorespuestasescalaxpregunta`
--
ALTER TABLE `rangorespuestasescalaxpregunta`
  ADD PRIMARY KEY (`idRango`),
  ADD UNIQUE KEY `idRango_UNIQUE` (`idRango`),
  ADD KEY `FK_RangoRespuestasEscalaXPregunta_Pregunta` (`idPregunta`);

--
-- Indices de la tabla `requisitospassword`
--
ALTER TABLE `requisitospassword`
  ADD PRIMARY KEY (`idRequisito`),
  ADD UNIQUE KEY `idRequisito` (`idRequisito`);

--
-- Indices de la tabla `respuestacerradaxpregunta`
--
ALTER TABLE `respuestacerradaxpregunta`
  ADD PRIMARY KEY (`idRespuestaXPreguntaCerradas`),
  ADD UNIQUE KEY `idRespuestaXPreguntaCerradas` (`idRespuestaXPreguntaCerradas`),
  ADD KEY `FK_RespuestaCerrada_Pregunta` (`idPreguntaCerrada`);

--
-- Indices de la tabla `respuestafiltroxaccion`
--
ALTER TABLE `respuestafiltroxaccion`
  ADD PRIMARY KEY (`idRepuestaFiltroXAccion`),
  ADD UNIQUE KEY `idRepuestaFiltroXAccion` (`idRepuestaFiltroXAccion`),
  ADD KEY `FK_RespuestaFiltro_AccionRespuestaFiltro` (`idAccionRespuestaFiltro`),
  ADD KEY `FK_RespuestaFiltro_PreguntaFiltro` (`idPreguntaFiltro`);

--
-- Indices de la tabla `respuestascerradas_x_evaluacionestado`
--
ALTER TABLE `respuestascerradas_x_evaluacionestado`
  ADD PRIMARY KEY (`id_RespuestaCerrada_X_EvaluacionEstado`),
  ADD UNIQUE KEY `id_RespuestaCerrada_X_EvaluacionEstado` (`id_RespuestaCerrada_X_EvaluacionEstado`),
  ADD KEY `FK_RespuestaCerrada_EvaluacionEstado` (`id_evaluacionEstado`),
  ADD KEY `FK_RespuestaCerradaEvaluacionEstado_Pregunta` (`idPregunta`);

--
-- Indices de la tabla `respuestasescalas_x_evaluacionestado`
--
ALTER TABLE `respuestasescalas_x_evaluacionestado`
  ADD PRIMARY KEY (`id_RespuestaEscala_X_EvaluacionEstado`),
  ADD UNIQUE KEY `id_RespuestaEscala_X_EvaluacionEstado` (`id_RespuestaEscala_X_EvaluacionEstado`),
  ADD KEY `FK_RespuestaEscala_EvaluacionEstado` (`id_evaluacionEstado`),
  ADD KEY `FK_RespuestaEscalaEvaluacionEstado_Pregunta` (`idPregunta`);

--
-- Indices de la tabla `seglog`
--
ALTER TABLE `seglog`
  ADD PRIMARY KEY (`SegLogKey`);

--
-- Indices de la tabla `tiporespuesta`
--
ALTER TABLE `tiporespuesta`
  ADD PRIMARY KEY (`idTipoRespuesta`),
  ADD UNIQUE KEY `idTipoRespuesta_UNIQUE` (`idTipoRespuesta`);

--
-- Indices de la tabla `tiposusuario`
--
ALTER TABLE `tiposusuario`
  ADD PRIMARY KEY (`idTipoUsuario`),
  ADD UNIQUE KEY `idTipoUsuario` (`idTipoUsuario`),
  ADD UNIQUE KEY `descripcionTipoUsuario` (`descripcionTipoUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`no_empleado`),
  ADD UNIQUE KEY `no_empleado` (`no_empleado`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `FK_Usuarios_TiposUsuario` (`idTipoUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accionrespuestafiltro`
--
ALTER TABLE `accionrespuestafiltro`
  MODIFY `idAccionRespuestaFiltro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `areaevaluacion`
--
ALTER TABLE `areaevaluacion`
  MODIFY `idAreaEvaluacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cartillamonitoreopersonal`
--
ALTER TABLE `cartillamonitoreopersonal`
  MODIFY `idCartilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `correosistema`
--
ALTER TABLE `correosistema`
  MODIFY `id_correo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `encuestasrealizadas`
--
ALTER TABLE `encuestasrealizadas`
  MODIFY `id_encuestasRealizada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `evaluacionestado`
--
ALTER TABLE `evaluacionestado`
  MODIFY `id_evaluacionEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `logins`
--
ALTER TABLE `logins`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `preguntafiltro`
--
ALTER TABLE `preguntafiltro`
  MODIFY `idPreguntaFiltro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rangorespuestasescalaxpregunta`
--
ALTER TABLE `rangorespuestasescalaxpregunta`
  MODIFY `idRango` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `requisitospassword`
--
ALTER TABLE `requisitospassword`
  MODIFY `idRequisito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `respuestacerradaxpregunta`
--
ALTER TABLE `respuestacerradaxpregunta`
  MODIFY `idRespuestaXPreguntaCerradas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestafiltroxaccion`
--
ALTER TABLE `respuestafiltroxaccion`
  MODIFY `idRepuestaFiltroXAccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `respuestascerradas_x_evaluacionestado`
--
ALTER TABLE `respuestascerradas_x_evaluacionestado`
  MODIFY `id_RespuestaCerrada_X_EvaluacionEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT de la tabla `respuestasescalas_x_evaluacionestado`
--
ALTER TABLE `respuestasescalas_x_evaluacionestado`
  MODIFY `id_RespuestaEscala_X_EvaluacionEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `seglog`
--
ALTER TABLE `seglog`
  MODIFY `SegLogKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de la tabla `tiporespuesta`
--
ALTER TABLE `tiporespuesta`
  MODIFY `idTipoRespuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiposusuario`
--
ALTER TABLE `tiposusuario`
  MODIFY `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areaevaluacion`
--
ALTER TABLE `areaevaluacion`
  ADD CONSTRAINT `FK_AreaEvaluacion_CartillaMonitoreoPersonal` FOREIGN KEY (`idCartillaMonitoreoPersonal`) REFERENCES `cartillamonitoreopersonal` (`idCartilla`);

--
-- Filtros para la tabla `encuestasrealizadas`
--
ALTER TABLE `encuestasrealizadas`
  ADD CONSTRAINT `FK_Encuestas_Usuarios` FOREIGN KEY (`no_empleado`) REFERENCES `usuarios` (`no_empleado`);

--
-- Filtros para la tabla `evaluacionestado`
--
ALTER TABLE `evaluacionestado`
  ADD CONSTRAINT `FK_EvaluacionEstado_AreaEvaluacion` FOREIGN KEY (`idAreaEvaluacion`) REFERENCES `areaevaluacion` (`idAreaEvaluacion`),
  ADD CONSTRAINT `FK_EvaluacionEstado_EncuestaRealizada` FOREIGN KEY (`id_encuestasRealizada`) REFERENCES `encuestasrealizadas` (`id_encuestasRealizada`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_Pregunta_AreaEvaluacion` FOREIGN KEY (`idAreaEvaluacion`) REFERENCES `areaevaluacion` (`idAreaEvaluacion`),
  ADD CONSTRAINT `FK_pregunta_TipoRespuesta` FOREIGN KEY (`idTipoRespuesta`) REFERENCES `tiporespuesta` (`idTipoRespuesta`);

--
-- Filtros para la tabla `preguntafiltro`
--
ALTER TABLE `preguntafiltro`
  ADD CONSTRAINT `FK_PreguntaFiltro_CartillaMonitoreoPersonal` FOREIGN KEY (`idCartilla`) REFERENCES `cartillamonitoreopersonal` (`idCartilla`);

--
-- Filtros para la tabla `rangorespuestasescalaxpregunta`
--
ALTER TABLE `rangorespuestasescalaxpregunta`
  ADD CONSTRAINT `FK_RangoRespuestasEscalaXPregunta_Pregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`);

--
-- Filtros para la tabla `respuestacerradaxpregunta`
--
ALTER TABLE `respuestacerradaxpregunta`
  ADD CONSTRAINT `FK_RespuestaCerrada_Pregunta` FOREIGN KEY (`idPreguntaCerrada`) REFERENCES `pregunta` (`idPregunta`);

--
-- Filtros para la tabla `respuestafiltroxaccion`
--
ALTER TABLE `respuestafiltroxaccion`
  ADD CONSTRAINT `FK_RespuestaFiltro_AccionRespuestaFiltro` FOREIGN KEY (`idAccionRespuestaFiltro`) REFERENCES `accionrespuestafiltro` (`idAccionRespuestaFiltro`),
  ADD CONSTRAINT `FK_RespuestaFiltro_PreguntaFiltro` FOREIGN KEY (`idPreguntaFiltro`) REFERENCES `preguntafiltro` (`idPreguntaFiltro`);

--
-- Filtros para la tabla `respuestascerradas_x_evaluacionestado`
--
ALTER TABLE `respuestascerradas_x_evaluacionestado`
  ADD CONSTRAINT `FK_RespuestaCerradaEvaluacionEstado_Pregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`),
  ADD CONSTRAINT `FK_RespuestaCerrada_EvaluacionEstado` FOREIGN KEY (`id_evaluacionEstado`) REFERENCES `evaluacionestado` (`id_evaluacionEstado`);

--
-- Filtros para la tabla `respuestasescalas_x_evaluacionestado`
--
ALTER TABLE `respuestasescalas_x_evaluacionestado`
  ADD CONSTRAINT `FK_RespuestaEscalaEvaluacionEstado_Pregunta` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`),
  ADD CONSTRAINT `FK_RespuestaEscala_EvaluacionEstado` FOREIGN KEY (`id_evaluacionEstado`) REFERENCES `evaluacionestado` (`id_evaluacionEstado`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_Usuarios_TiposUsuario` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tiposusuario` (`idTipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
