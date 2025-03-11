-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2025 a las 19:19:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
(1, 'God Of War Ragnarok ', 'kratos el calvo', 24.99, 'uploads/kratos4k.jpg'),
(2, 'Death Stranding', 'hombre que camina cerros', 12.00, 'uploads/muerto.jpeg'),
(4, 'Minecraft', 'un juego de cuadrados hecho en java,ggs', 14.99, 'uploads/maincra.png'),
(5, 'Batman Arkham Asylum', 'La historia comienza cuando el Joker se rinde voluntariamente y lleva a Batman al Asilo de Arkham, donde rápidamente desata un plan para tomar el control del lugar y liberar a los criminales internos. Batman debe enfrentar a una serie de villanos emblemáticos, como Harley Quinn, Poison Ivy y Scarecrow, mientras investiga el oscuro secreto detrás del manicomio.', 11.99, 'uploads/batman3.jpg'),
(6, 'Batman Arkham City', 'El principal antagonista es el Joker, pero Batman también enfrenta a otros enemigos icónicos como Two-Face, The Penguin, Mr. Freeze, y Ra\'s al Ghul. La trama se centra en descubrir los secretos del siniestro plan conocido como Protocolo 10, desarrollado por Hugo Strange, quien controla Arkham City y conoce la identidad secreta de Batman.', 18.99, 'uploads/batmancity.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_creacion`) VALUES
(1, 'Juan Pérez', 'admin@example.com', '1212', 'admin', '2024-10-09 18:34:18'),
(2, 'Maty Moran', 'matymoran4@gmail.com', '$2y$10$dktzLO3RE5799tpG.mNnIuKYEjj.mfWIDzVl9K7w7GYhLbtYiCiwO', 'admin', '2024-10-09 18:55:44'),
(3, 'Batman', 'batman@gmail.com', '$2y$10$.PHlstLOaDa2A.CKF6CcyuTxzAQaN/NEDxx8aPz9Ksy2VNfX7v8S6', 'usuario', '2024-10-09 20:44:32'),
(4, 'Batman', 'batman2@gmail.com', '$2y$10$IdleSu7xFVly.0WJI3Ml/.BrYVsa2czLkxNZ1NalB8Pz3Wk6EvOlu', '', '2024-10-24 21:38:40'),
(5, 'Maty Moran', 'matymoran5@gmail.com', '$2y$10$2fa2VBZZ8EfjVfTBkF.AHeWaFQfr5hNy8REefcKA2T9KIIAPPJy/K', 'admin', '2025-02-24 19:28:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
