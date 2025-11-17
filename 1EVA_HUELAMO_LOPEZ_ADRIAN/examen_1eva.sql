-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2025 a las 08:57:34
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
-- Base de datos: `examen_1eva`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `id_editorial` int(11) NOT NULL,
  `nombre_editorial` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`id_editorial`, `nombre_editorial`, `telefono`, `email`) VALUES
(1, 'Planeta', 913276000, 'contacto@planeta.es'),
(2, 'Anagrama', 932174364, 'info@anagrama-ed.es'),
(3, 'Alfaguara', 917453200, 'info@alfaguara.es'),
(4, 'SM Ediciones', 917451500, 'atencioncliente@grupo-sm.com'),
(5, 'Tusquets Editores', 934870300, 'info@tusquetseditores.com'),
(6, 'Espasa', 913218400, 'contacto@espasa.es'),
(7, 'Siruela', 914310345, 'editorial@siruela.com'),
(8, 'Destino', 932702200, 'info@destino.es'),
(9, 'RBA Libros', 933662400, 'info@rbalibros.com'),
(10, 'Salamandra', 934877900, 'contacto@editorialsalamandra.es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `autor` varchar(40) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `precio` decimal(5,0) DEFAULT NULL,
  `visitas` int(11) DEFAULT 0,
  `fecha` date DEFAULT curdate(),
  `portada` varchar(100) DEFAULT NULL,
  `id_editorial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `titulo`, `autor`, `id_categoria`, `precio`, `visitas`, `fecha`, `portada`, `id_editorial`) VALUES
(1, 'Harry Potter y la piedra filosofal', 'JK Rowling', 1, 15, 11, '2020-01-01', 'harry_potter_1.jpg', 1),
(2, 'Harry Potter y la cámara secreta', 'JK Rowling', 1, NULL, 8, '2020-01-02', 'harry_potter_2.jpg', 2),
(3, 'El ocho', 'Katherin Neville', 1, 10, 5, '2020-01-03', 'el_ocho.jpg', 6),
(4, 'Wonder Woman', 'William Moulton', 4, 10, 0, '2025-06-17', 'wonder_woman.jpg', 3),
(5, 'Alicia en el país de las maravillas', 'Lewis Carroll', 3, 11, 0, '2025-06-17', 'alicia_maravillas.jpg', 2),
(7, 'El alquimista', 'Paolo Coelho', 3, NULL, 1, '2025-06-17', 'sin_portada.jpg', 1),
(8, 'El fuego', 'Katherin Neville', 1, 10, 0, '2025-06-17', 'el_fuego.jpg', 5),
(9, 'La clave está en Rebeca', 'Ken Follett', 1, 8, 0, '2025-06-17', 'clave_Rebeca.jpg', 4),
(10, 'Secretos', 'Paolo Coelho', 1, 11, 0, '2025-06-17', 'secretos.jpg', 5),
(11, 'Harry Potter y el prisionero de Azkabán', 'JK Rowling', 1, 15, 0, '2025-06-17', 'harry_potter_3.jpg', 4),
(12, 'Harry Potter y el cáliz de fuego', 'JK Rowling', 1, 16, 0, '2025-06-17', 'harry_potter_4.jpg', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `username`, `password`) VALUES
(1, 'Laura', 'Martínez Pérez', 'laura.martinez@example.com', 'lauram', '5ac0852e770506dcd80f1a36d20ba7878bf82244b836d9324593bd14bc56dcb5'),
(2, 'Carlos', 'García López', 'carlos.garcia@example.com', 'cgarcia', '117c7a4c1f7a0c9b01a2b52fefc1fd54832d77f1c45bcf23918967fc0453fe79'),
(3, 'Ana', 'Rodríguez Núñez', 'ana.rodriguez@example.com', 'anar', '9dbd5c893b5b573a1aa909c8cade58df194310e411c590d9fb0d63431841fd67'),
(6, 'Mariluz', 'Ruiz', 'mariluz@solvam.es', 'maluz', '$2y$10$wO7Los5SRBzz1kBX2Xbu5OkUW.sstzj8sFPvIp15vEouEhl6NL16e'),
(7, 'Aitor', 'Menta', 'aitormenta@solvam.es', 'admin', '$2y$10$Wxt4fx3X6kHnPiyTQHVE8.YoAf/3KxkLdpX9toVWF5qfA3Up0HoHW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`id_editorial`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_editorial` (`id_editorial`);

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
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `id_editorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libros_ibfk_2` FOREIGN KEY (`id_editorial`) REFERENCES `editoriales` (`id_editorial`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
