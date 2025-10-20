-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2025 a las 21:29:57
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
-- Base de datos: `nintendo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consolas`
--

CREATE TABLE `consolas` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ventas` int(11) NOT NULL,
  `año_lanzamiento` date NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consolas`
--

INSERT INTO `consolas` (`codigo`, `nombre`, `ventas`, `año_lanzamiento`, `imagen`) VALUES
(1, 'Nintendo Switch', 150000000, '2017-03-03', 'switch.png'),
(2, 'Wii', 101630000, '2006-11-19', 'wii.jpg'),
(3, 'Nintendo DS', 154000000, '2004-11-21', 'ds.webp'),
(4, 'Nintendo 64', 32930000, '1996-06-23', 'N64.jpg'),
(5, 'Game Boy Advance', 81510000, '2001-03-21', 'gba.jpg'),
(6, 'Super Nintendo', 49100000, '1990-11-21', 'snes.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `codigo` int(11) NOT NULL,
  `genero` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`codigo`, `genero`) VALUES
(1, 'Aventura'),
(2, 'RPG'),
(3, 'Plataformas'),
(4, 'Racing'),
(5, 'Fighting');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sagas`
--

CREATE TABLE `sagas` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `numero_juegos` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sagas`
--

INSERT INTO `sagas` (`codigo`, `nombre`, `numero_juegos`, `fecha_creacion`) VALUES
(1, 'Mario Bros', 144, '1985-09-13'),
(2, 'Zelda', 33, '1986-02-21'),
(3, 'Pokemon', 89, '1996-02-27'),
(4, 'Kirby', 40, '1992-04-27'),
(5, 'Donkey Kong', 50, '1981-07-09'),
(6, 'Super Smash Bros', 6, '1999-01-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuegos`
--

CREATE TABLE `videojuegos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `consola` int(11) NOT NULL,
  `saga` int(11) NOT NULL,
  `genero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `videojuegos`
--

INSERT INTO `videojuegos` (`codigo`, `nombre`, `imagen`, `consola`, `saga`, `genero`) VALUES
(1, 'Pokemon Blanco', 'pokemonblanco.jpeg', 3, 3, 2),
(2, 'Mario Galaxy', 'mariogalaxy.jpeg', 2, 1, 3),
(3, 'Zelda Breath of the wild', 'zeldabotw.jpeg', 1, 2, 1),
(4, 'PokePark', 'pokepark.jpeg', 2, 3, 2),
(5, 'New Super Mario Bros', 'newsupermariobros.jpeg', 3, 1, 3),
(6, 'Mario Odissey', 'marioodissey.jpeg', 1, 1, 3),
(7, 'Pokemon Escarlata', 'pokemonescarlata.jpeg', 1, 3, 2),
(8, 'Zelda Skyward Sword', 'zeldawii.jpg', 2, 2, 1),
(9, 'Zelda Phantom Hourglass', 'zeldads.jpeg', 3, 2, 1),
(10, 'Super Mario 64', 'mario64.jpg', 4, 1, 3),
(11, 'Mario Kart Wii', 'mariokartwii.jpg', 2, 1, 4),
(12, 'Kirby Super Star Ultra', 'kirbysuperstar.webp', 3, 4, 3),
(13, 'Donkey Kong Country', 'DKcountry.png', 6, 5, 3),
(14, 'Super Smash Bros Brawl', 'smashbrawl.jpeg', 2, 6, 5),
(15, 'Pokemon Zafiro', 'pokemonzafiro.webp', 5, 3, 2),
(16, 'Zelda Ocarina of Time', 'zoot.jpg', 4, 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consolas`
--
ALTER TABLE `consolas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `sagas`
--
ALTER TABLE `sagas`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `consola` (`consola`),
  ADD KEY `saga` (`saga`),
  ADD KEY `genero` (`genero`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  ADD CONSTRAINT `videojuegos_ibfk_1` FOREIGN KEY (`saga`) REFERENCES `sagas` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `videojuegos_ibfk_2` FOREIGN KEY (`genero`) REFERENCES `generos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `videojuegos_ibfk_3` FOREIGN KEY (`consola`) REFERENCES `consolas` (`codigo`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
