-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-01-2026 a las 22:34:25
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
-- Base de datos: `gym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `dificultad` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `id_grupo`, `titulo`, `descripcion`, `dificultad`, `imagen`, `destacado`) VALUES
(1, 1, 'Press de Banca', 'El ejercicio rey para el pecho. Túmbate y empuja la barra.', 'Media', 'press_banca.jpg', 1),
(2, 1, 'Aperturas con Mancuernas', 'Ideal para estirar las fibras del pectoral.', 'Baja', 'aperturas.jpg', 0),
(3, 2, 'Dominadas', 'Levanta tu propio peso colgado de una barra.', 'Alta', 'dominadas.jpg', 1),
(4, 2, 'Remo con Barra', 'Tracción horizontal para ganar densidad de espalda.', 'Media', 'remo.jpg', 0),
(5, 3, 'Sentadilla Libre', 'Flexión de rodillas con peso. Trabaja todo el tren inferior.', 'Alta', 'sentadilla.jpg', 1),
(6, 3, 'Prensa de Piernas', 'Empuje de piernas en máquina, más seguro para la espalda.', 'Baja', 'prensa.jpg', 0),
(7, 4, 'Curl de Bíceps', 'Flexión de codo con barra o mancuernas.', 'Baja', 'curl.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_musculares`
--

CREATE TABLE `grupos_musculares` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos_musculares`
--

INSERT INTO `grupos_musculares` (`id`, `nombre`, `imagen`, `descripcion`) VALUES
(1, 'Pectoral', 'pecho.png', 'Músculos del pecho, clave para los empujes.'),
(2, 'Espalda', 'espalda.png', 'Dorsales y trapecios. Darán amplitud a tu figura.'),
(3, 'Piernas', 'piernas.png', 'Cuádriceps, femorales y glúteos. La base del cuerpo.'),
(4, 'Brazos', 'brazos.png', 'Bíceps y tríceps. Músculos pequeños pero vistosos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `resumen` varchar(255) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `resumen`, `contenido`, `fecha_publicacion`, `imagen`) VALUES
(1, 'La importancia del descanso', '¿Sabías que el músculo crece cuando duermes?', 'Muchos piensan que el músculo crece en el gym, pero lo hace mientras descansas. Dormir 8 horas es fundamental para la hipertrofia...', '2026-01-10', 'descanso.jpg'),
(2, 'Proteína: ¿Cuánta necesitas?', 'Guía rápida sobre el consumo de proteínas.', 'Se recomienda entre 1.6g y 2g de proteína por cada kilo de peso corporal si estás entrenando fuerza...', '2025-12-24', 'proteina.jpg'),
(3, 'Errores comunes en novatos', 'Evita lesiones siguiendo estos consejos.', 'No cargues más peso del que controlas. La técnica siempre debe ir por delante del ego...', '2026-01-04', 'novatos.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `rol`) VALUES
(1, 'admin', 'admin@gym.com', '$2y$10$tEFp5pBPsyRDeW4NK3N2ruZ8C3PuUaidxDv3Wx7LbMRsDml1Atacq', 1),
(2, 'pol7', 'pol@gmail.com', '$2y$12$8abtOyzSH789JwW3j9J2Uucy6TNYPecLReeKhQclu14v4i6uam8..', 0),
(3, 'pol', 'pol7@gmail.com', '$2y$12$.1oHHh48ghkp7I5J29VZqOkl/w4tMo7MV6uvK3bPF0Lt24n1rizsy', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `ejercicios_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos_musculares` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
