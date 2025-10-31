-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-10-2025 a las 12:46:55
-- Versión del servidor: 8.0.43-0ubuntu0.24.04.1
-- Versión de PHP: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alquilobato`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id_coche` int NOT NULL,
  `nombre` varchar(55) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_categoria` int NOT NULL,
  `año` year DEFAULT NULL,
  `precio_hora` int DEFAULT NULL,
  `precio_dia` int DEFAULT NULL,
  `precio_mes` int DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id_coche`, `nombre`, `id_categoria`, `año`, `precio_hora`, `precio_dia`, `precio_mes`, `imagen`) VALUES
(1, 'M3 Competition', 1, '2024', 50, 350, 7000, 'img/bmw-m3.jpg'),
(2, 'A4 S-Line', 2, '2023', 30, 220, 4500, 'img/audi-a4.jpg'),
(3, 'Clase C', 3, '2024', 35, 240, 4800, 'img/mercedes-clase-c.jpg'),
(4, '911 Carrera', 4, '2023', 70, 500, 10000, 'img/porsche-911.jpg'),
(5, 'Roma', 5, '2023', 100, 800, 16000, 'img/ferrari-roma.jpg'),
(6, 'Camaro SS', 6, '2023', 40, 300, 6000, 'img/chevrolet-camaro.jpg'),
(7, 'Wrangler Rubicon', 7, '2024', 30, 250, 5000, 'img/jeep-wrangler.jpg'),
(8, 'Mustang GT', 8, '2024', 45, 320, 6500, 'img/ford-mustang.jpg'),
(9, 'Corolla', 9, '2023', 20, 150, 3000, 'img/toyota-corolla.jpg'),
(10, 'Civic Type R', 10, '2024', 35, 260, 5200, 'img/honda-civic-r.jpg'),
(11, 'Qashqai', 11, '2023', 25, 180, 3600, 'img/nissan-qashqai.jpg'),
(12, 'Golf GTI', 12, '2023', 30, 230, 4600, 'img/vw-golf-gti.jpg'),
(13, 'XC40', 13, '2024', 30, 240, 4800, 'img/volvo-xc40.jpg'),
(14, 'Outback', 14, '2023', 25, 200, 4000, 'img/subaru-outback.jpg'),
(15, 'CX-5', 15, '2023', 25, 190, 3800, 'img/mazda-cx5.jpg'),
(16, 'Tucson', 16, '2024', 25, 180, 3600, 'img/hyundai-tucson.jpg'),
(17, 'Sportage', 17, '2024', 25, 180, 3600, 'img/kia-sportage.jpg'),
(18, '500e', 18, '2023', 15, 120, 2400, 'img/fiat-500e.jpg'),
(19, 'Clio', 19, '2023', 15, 130, 2600, 'img/renault-clio.jpg'),
(20, '308', 20, '2008', 15, 130, 2600, 'img/peugeot-308.jpg'),
(21, 'C3', 21, '2023', 15, 125, 2500, 'img/citroen-c3.jpg'),
(22, 'Huracan EVO', 22, '2023', 150, 1200, 25000, 'img/lambo-huracan.jpg'),
(23, 'DB11', 23, '2023', 90, 700, 14000, 'img/aston-db11.jpg'),
(24, 'F-Pace', 24, '2023', 40, 300, 6000, 'img/jaguar-fpace.jpg'),
(25, 'Defender 110', 25, '2024', 50, 350, 7000, 'img/lr-defender.jpg'),
(26, 'Model 3', 26, '2024', 35, 250, 5000, 'img/tesla-model3.jpg'),
(27, 'Eclipse Cross', 27, '2023', 20, 160, 3200, 'img/mitsubishi-eclipse.jpg'),
(28, 'X5', 1, '2023', 45, 330, 6600, 'img/bmw-x5.jpg'),
(29, 'Q5', 2, '2024', 40, 310, 6200, 'img/audi-q5.jpg'),
(30, 'GLE', 3, '2023', 45, 340, 6800, 'img/mercedes-gle.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int NOT NULL,
  `nombre` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre`, `logo`) VALUES
(1, 'BMW', NULL),
(2, 'Audi', NULL),
(3, 'Mercedes', NULL),
(4, 'porsche', NULL),
(5, 'Ferrari', NULL),
(6, 'Cheverolet', NULL),
(7, 'Jeep', NULL),
(8, 'Ford', NULL),
(9, 'Toyota', NULL),
(10, 'Honda', NULL),
(11, 'Nissan', NULL),
(12, 'Volkswagen', NULL),
(13, 'Volvo', NULL),
(14, 'Subaru', NULL),
(15, 'Mazda', NULL),
(16, 'Hyundai', NULL),
(17, 'Kia', NULL),
(18, 'Fiat', NULL),
(19, 'Renault', NULL),
(20, 'Peugeot', NULL),
(21, 'Citroën', NULL),
(22, 'Lamborghini', NULL),
(23, 'Aston Martin', NULL),
(24, 'Jaguar', NULL),
(25, 'Land Rover', NULL),
(26, 'Tesla', NULL),
(27, 'Mitsubishi', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nombre` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `telefono`, `username`, `password`) VALUES
(1, 'admin', 'admin@solvam.es', 123456789, 'admin', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde'),
(2, 'mariluz', 'mariluz@solvam.es', 987654321, 'mariluz', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde'),
(3, 'Adahi', 'adahi@solvam.es', 515184818, 'adahi', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde'),
(4, 'Joselu', 'Joselu@israel.es', 841212561, 'joselu', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id_coche`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id_coche` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `coches_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `marcas` (`id_marca`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
