-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2026 a las 20:13:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `programacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_archivado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `dni`, `correo`, `pass`, `rol`, `fecha_creacion`, `fecha_archivado`) VALUES
(1, 'Lucas Rega', '50324349', 'regalucas@gmail.com', '$2y$10$jKjphm1vSIGKraV3D4TVPeh563AUPaVu1iAmTY.gEOVCNYu1ueLIW', 'usuario', '2026-11-04 21:26:57', NULL),
(2, 'alejandro', '3456899', 'alejando@gmail.com', '$2y$10$NX2B/HBu/EKF4nOeRQiGLeK4f5URVkM4IBNSn6B6CXCq36jMNHt3G', 'usuario', '2026-11-04 21:29:51', NULL),
(3, 'leo', '12345678', 'leo@gmail.com', '$2y$10$phtKBZKU0j3YJJ6QmJL1qerHKQmnwBXfRTL0hCC.6GVcMbB6.FK3S', 'usuario', '2026-11-04 21:49:12', NULL),
(4, 'pepe', '89123456', 'pepito@gmail.com', '$2y$10$XUs/jznfF4IB5uNP5aZR0ecjYB3agAU.rrVAr/fldjtFRbbCgXiBq', 'usuario', '2026-11-04 22:07:27', NULL),
(5, 'paula', '33456789', 'paula@gmail.com', '$2y$10$VtmxYqJkDNsJ25JjR/gAAeyLeRI/aUty.BbmjfnBP435rm1VZ.BWi', 'usuario', '2026-11-04 22:09:51', NULL),
(6, 'lucas rega', '50234567', 'lucasrega@gmail.com', '$2y$10$KbcUYBswheVz0mVEnQ.Xke0CJv/AigE5Z80zMN/qzbfhy85bzQFwy', 'usuario', '2026-11-07 15:22:35', NULL),
(7, 'Leonel Rega', '34567890', 'leonel@hotmail.com', '$2y$10$vUIxOh.3HS.nuKhiprm4QOCaUTuEgIrfajm.n9L4RIK6FHiso2LU2', 'admin', '2026-11-07 15:40:48', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
