-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-10-2025 a las 09:51:57
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
-- Base de datos: `adrianhuelamo_libreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int NOT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`) VALUES
(1, 'Ficción'),
(2, 'Terror'),
(3, 'Novela'),
(4, 'Cómic'),
(5, 'Historia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `autor` varchar(40) NOT NULL,
  `id_categoria` int DEFAULT NULL,
  `precio` decimal(5,0) DEFAULT NULL,
  `visitas` int DEFAULT '0',
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `portada` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `titulo`, `autor`, `id_categoria`, `precio`, `visitas`, `fecha`, `portada`) VALUES
(1, 'Harry Potter y la piedra filosofal', 'JK Rowling', 1, 15, 18, '2019-12-31 23:00:00', 'harry_potter_1.jpg'),
(2, 'Harry Potter y la cámara secreta', 'JK Rowling', 1, 14, 10, '2020-01-01 23:00:00', 'harry_potter_2.jpg'),
(3, 'El ocho', 'Katherin Neville', 1, 10, 5, '2020-01-02 23:00:00', 'el_ocho.jpg'),
(4, 'Wonder Woman', 'William Moulton', 4, 10, 0, '2025-06-16 22:00:00', 'wonder_woman.jpg'),
(5, 'Alicia en el país de las maravillas', 'Lewis Carroll', 3, 11, 0, '2025-06-16 22:00:00', 'alicia_maravillas.jpg'),
(6, 'Los pilares de la tierra', 'Ken Follett', 5, 12, 0, '2025-06-16 22:00:00', 'pilares_tierra.jpg'),
(7, 'El alquimista', 'Paolo Coelho', 3, 12, 1, '2025-06-16 22:00:00', 'el_alquimista.jpg'),
(8, 'El fuego', 'Katherin Neville', 1, 10, 0, '2025-06-16 22:00:00', 'el_fuego.jpg'),
(9, 'La clave está en Rebeca', 'Ken Follett', 1, 8, 0, '2025-06-16 22:00:00', 'clave_Rebeca.jpg'),
(10, 'Secretos', 'Paolo Coelho', 1, 11, 0, '2025-06-19 22:00:00', 'secretos.jpg'),
(11, 'Harry Potter y el prisionero de Azkabán', 'JK Rowling', 1, 15, 0, '2025-06-16 22:00:00', 'harry_potter_3.jpg'),
(12, 'Harry Potter y el cáliz de fuego', 'JK Rowling', 1, 16, 0, '2025-06-16 22:00:00', 'harry_potter_4.jpg'),
(17, '50 sombras de joselu', 'GRR adahi', 5, 69, 0, '2025-10-19 22:00:00', 'el_fuego.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `username`, `password`) VALUES
(1, 'Laura', 'Martínez Pérez', 'laura.martinez@example.com', 'lauram', '5ac0852e770506dcd80f1a36d20ba7878bf82244b836d9324593bd14bc56dcb5'),
(3, 'Ana', 'Rodríguez Núñez', 'ana.rodriguez@example.com', 'pepe', '9dbd5c893b5b573a1aa909c8cade58df194310e411c590d9fb0d63431841fd67'),
(6, 'Adrian', 'Huelamo', 'adri41104@gmail.com', 'Adri', '$2y$12$7QKEBs7VJXQKc6f6kWlHIeQjwAmhtVTzgD5AaS5swIZFwRVlAE6BW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
