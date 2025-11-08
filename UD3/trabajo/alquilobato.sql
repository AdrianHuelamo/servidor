-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2025 a las 23:41:42
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
-- Base de datos: `alquilobato`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog`
--

CREATE TABLE `blog` (
  `id_blog` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `resumen` text DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `id_autor` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `blog`
--

INSERT INTO `blog` (`id_blog`, `titulo`, `resumen`, `contenido`, `id_autor`, `fecha`, `imagen`) VALUES
(1, 'Por qué el alquiler de coches es clave para el crecimiento empresarial', 'Descubre cómo el alquiler de vehículos está cambiando la logística empresarial y ayudando a optimizar costes operativos.', 'Este es el contenido completo del primer post. Aquí se explicaría en detalle por qué el alquiler de coches es fundamental, hablando de flexibilidad, ahorro en mantenimiento y la capacidad de tener siempre un vehículo moderno y seguro para los empleados.', 2, '2025-10-29', 'images/image_1.jpg'),
(2, 'Los 5 mejores destinos para un viaje por carretera este verano', 'Prepara tu coche de alquiler y ¡a la aventura! Te mostramos rutas increíbles y paisajes que te dejarán sin aliento.', 'Contenido completo del segundo post. 1. Ruta de la Costa Azul. 2. Los Alpes Suizos. 3. La Toscana. 4. La Costa Oeste de EE.UU. 5. La Selva Negra en Alemania. Cada punto tendría una descripción de por qué es un gran destino.', 2, '2025-10-22', 'images/image_2.jpg'),
(3, 'Mantenimiento: Qué revisamos antes de entregarte un coche', 'Tu seguridad es nuestra prioridad. Te contamos el proceso de revisión de 30 puntos que pasa cada uno de nuestros coches.', 'Contenido completo del tercer post. Detallamos el checklist de seguridad: revisión de frenos, niveles de aceite, presión de neumáticos, limpieza interior y exterior, y comprobación del sistema electrónico.', 1, '2025-10-15', 'images/image_3.jpg'),
(5, 'Consejos de conducción segura para tus vacaciones de navidad', 'La nieve y el hielo requieren precaución. Te damos los mejores consejos para conducir seguro en condiciones invernales con tu coche de alquiler.', 'Contenido completo sobre conducción invernal. Incluye: revisar neumáticos, la importancia de los SUV 4x4, cómo frenar en hielo, qué llevar en el maletero (cadenas, manta, agua) y la importancia de reducir la velocidad.', 3, '2025-10-25', 'images/image_5.jpg'),
(6, '¿Por qué alquilar un SUV es la mejor opción para un viaje familiar?', 'Espacio, comodidad y seguridad. Analizamos por qué un SUV como el Tucson o el Qashqai es la elección preferida de las familias.', 'Contenido completo sobre las ventajas de un SUV. Espacio de maletero para carritos y maletas, mayor altura para mejor visibilidad, sistemas de seguridad avanzados (ISOFIX) y comodidad en asientos traseros para viajes largos.', 1, '2025-10-20', 'images/image_6.jpg'),
(7, 'Descubriendo joyas ocultas: Un fin de semana en coche por pueblos con encanto', 'A veces, los mejores destinos no están en los mapas turísticos. Te proponemos una ruta de fin de semana para descubrir lugares mágicos.', 'Contenido completo de una ruta de fin de semana. Por ejemplo, una ruta por pueblos medievales, detallando paradas, dónde comer y la flexibilidad que te da tener un coche de alquiler para explorar sin prisas.', 4, '2025-10-18', 'images/images-7.jpg'),
(8, 'Cómo ahorrar en tu próximo alquiler de coche: Trucos y consejos', 'Alquilar un coche no tiene por qué ser caro. Te desvelamos 5 trucos para conseguir el mejor precio en tu reserva.', 'Contenido completo sobre ahorro. 1. Reservar con antelación. 2. Evitar alquileres en aeropuertos (suelen tener tasas extra). 3. Elegir el tamaño de coche adecuado. 4. Revisar la política de combustible. 5. Aprovechar descuentos de larga estancia.', 1, '2025-10-12', 'images/image_8.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id_coche` int(11) NOT NULL,
  `nombre` varchar(55) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `año` year(4) DEFAULT NULL,
  `precio_hora` int(11) DEFAULT NULL,
  `precio_dia` int(11) DEFAULT NULL,
  `precio_mes` int(11) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `kilometros` int(11) DEFAULT 0,
  `transmision` varchar(20) DEFAULT 'Manual',
  `asientos` tinyint(4) DEFAULT 5,
  `maletero` smallint(6) DEFAULT 300,
  `combustible` varchar(20) DEFAULT 'Gasolina'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id_coche`, `nombre`, `id_categoria`, `año`, `precio_hora`, `precio_dia`, `precio_mes`, `imagen`, `kilometros`, `transmision`, `asientos`, `maletero`, `combustible`) VALUES
(1, 'M3 Competition', 1, '2024', 50, 350, 7000, 'images/bmw-m3.jpg', 0, 'Automático', 5, 480, 'Gasolina'),
(2, 'A4 S-Line', 2, '2023', 30, 220, 4500, 'images/audi-a4.avif', 15000, 'Automático', 5, 460, 'Gasolina'),
(3, 'Clase C', 3, '2024', 35, 240, 4800, 'images/mercedes-clase-c.webp', 0, 'Automático', 5, 455, 'Gasolina'),
(4, '911 Carrera', 4, '2023', 70, 500, 10000, 'images/porsche-911.webp', 12000, 'Automático', 4, 132, 'Gasolina'),
(5, 'Roma', 5, '2023', 100, 800, 16000, 'images/ferrari-roma.avif', 5000, 'Automático', 4, 272, 'Gasolina'),
(6, 'Camaro SS', 6, '2023', 40, 300, 6000, 'images/cheverlot-camaro.webp', 8000, 'Automático', 4, 258, 'Gasolina'),
(7, 'Wrangler Rubicon', 7, '2024', 30, 250, 5000, 'images/jeep-wrangler.jpg', 0, 'Automático', 5, 548, 'Gasolina'),
(8, 'Mustang GT', 8, '2024', 45, 320, 6500, 'images/ford-mustang.avif', 0, 'Automático', 4, 382, 'Gasolina'),
(9, 'Corolla', 9, '2023', 20, 150, 3000, 'images/toyota-corolla.avif', 25000, 'Automático', 5, 470, 'Híbrido'),
(10, 'Civic Type R', 10, '2024', 35, 260, 5200, 'images/honda-civic-r.jpg', 0, 'Manual', 4, 410, 'Gasolina'),
(11, 'Qashqai', 11, '2023', 25, 180, 3600, 'images/nissan-qashqai.jpg', 22000, 'Manual', 5, 504, 'Gasolina'),
(12, 'Golf GTI', 12, '2023', 30, 230, 4600, 'images/vw-golf-gti.jpg', 18000, 'Automático', 5, 374, 'Gasolina'),
(13, 'XC40', 13, '2024', 30, 240, 4800, 'images/volvo-xc40.jpg', 0, 'Automático', 5, 452, 'Híbrido'),
(14, 'Outback', 14, '2023', 25, 200, 4000, 'images/subaru-outback.jpg', 30000, 'Automático', 5, 561, 'Gasolina'),
(15, 'CX-5', 15, '2023', 25, 190, 3800, 'images/mazda-cx5.avif', 28000, 'Automático', 5, 522, 'Gasolina'),
(16, 'Tucson', 16, '2024', 25, 180, 3600, 'images/hyundai-tucson.jpg', 0, 'Manual', 5, 620, 'Híbrido'),
(17, 'Sportage', 17, '2024', 25, 180, 3600, 'images/kia-sportage.jpg', 0, 'Manual', 5, 591, 'Híbrido'),
(18, '500e', 18, '2023', 15, 120, 2400, 'images/fiat-500e.jpg', 15000, 'Automático', 4, 185, 'Eléctrico'),
(19, 'Clio', 19, '2023', 15, 130, 2600, 'images/renault-clio.jpg', 35000, 'Manual', 5, 391, 'Gasolina'),
(20, '308', 20, '2008', 15, 130, 2600, 'images/peugeot-308.jpg', 280000, 'Manual', 5, 309, 'Gasolina'),
(21, 'C3', 21, '2023', 15, 125, 2500, 'images/citroen-c3.jpg', 40000, 'Manual', 5, 300, 'Gasolina'),
(22, 'Huracan EVO', 22, '2023', 150, 1200, 25000, 'images/lambo-huracan.avif', 3000, 'Automático', 2, 100, 'Gasolina'),
(23, 'DB11', 23, '2023', 90, 700, 14000, 'images/aston-db11.jpg', 6000, 'Automático', 4, 270, 'Gasolina'),
(24, 'F-Pace', 24, '2023', 40, 300, 6000, 'images/jaguar-fpace.jpg', 13000, 'Automático', 5, 613, 'Gasolina'),
(25, 'Defender 110', 25, '2024', 50, 350, 7000, 'images/ld-defender.webp', 0, 'Automático', 5, 786, 'Diesel'),
(26, 'Model 3', 26, '2024', 35, 250, 5000, 'images/tesla-model3.jpg', 0, 'Automático', 5, 561, 'Eléctrico'),
(27, 'Eclipse Cross', 27, '2023', 20, 160, 3200, 'images/mitsubishi-eclipse.webp', 19000, 'Automático', 5, 405, 'Híbrido'),
(28, 'X5', 1, '2023', 45, 330, 6600, 'images/bmw-x5.webp', 11000, 'Automático', 5, 650, 'Híbrido'),
(29, 'Q5', 2, '2024', 40, 310, 6200, 'images/audi-q5.webp', 0, 'Automático', 5, 520, 'Híbrido'),
(30, 'GLE', 3, '2023', 45, 340, 6800, 'images/mercedes-gle.jpg', 9000, 'Automático', 5, 630, 'Híbrido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre`) VALUES
(1, 'BMW'),
(2, 'Audi'),
(3, 'Mercedes'),
(4, 'porsche'),
(5, 'Ferrari'),
(6, 'Cheverolet'),
(7, 'Jeep'),
(8, 'Ford'),
(9, 'Toyota'),
(10, 'Honda'),
(11, 'Nissan'),
(12, 'Volkswagen'),
(13, 'Volvo'),
(14, 'Subaru'),
(15, 'Mazda'),
(16, 'Hyundai'),
(17, 'Kia'),
(18, 'Fiat'),
(19, 'Renault'),
(20, 'Peugeot'),
(21, 'Citroën'),
(22, 'Lamborghini'),
(23, 'Aston Martin'),
(24, 'Jaguar'),
(25, 'Land Rover'),
(26, 'Tesla'),
(27, 'Mitsubishi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id_opinion` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `trabajo` varchar(100) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`id_opinion`, `comentario`, `nombre_cliente`, `trabajo`, `imagen`) VALUES
(1, '¡Un servicio increíble! Alquilé un BMW Serie 3 y el coche estaba impecable. El proceso fue rapidísimo. 100% recomendado.', 'José Luis Torrente', 'Policia', 'images/torrente.webp'),
(2, 'El Jeep Wrangler superó nuestras expectativas. Perfecto para la montaña. El personal de AlquiLobato fue muy amable.', 'Fernando Alonso', 'Piloto F1', 'images/elnano.jpg'),
(3, 'Utilizo AlquiLobato para mis viajes de negocios. Siempre puntuales y con coches limpios y modernos. Muy competitivo.', 'José Luis Puchades', 'Rabino', 'images/joselu.png'),
(4, 'Alquilamos un SUV (un Tucson) para las vacaciones. ¡Espacioso y muy limpio! El proceso fue sencillo y el precio justo. Repetiremos.', 'El Fary', 'Artista', 'images/elfary.jpg'),
(5, '¡Una experiencia de 10! Alquilé el Porsche 911 para el fin de semana. El coche era una maravilla, tal y como se describía. Servicio premium.', 'Vito Quiles', 'Periodista', 'images/vito_quiles.webp'),
(6, 'El Fiat 500e eléctrico es perfecto para moverse por la ciudad. La batería dura mucho y el coche es muy divertido. Súper económico.', 'Melendi', 'Artista', 'images/melendi.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_coche` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `coste_total` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_coche`, `fecha_inicio`, `fecha_fin`, `coste_total`, `fecha_creacion`) VALUES
(2, 25, 29, '2025-11-21 22:30:00', '2025-11-24 11:00:00', 2440.00, '2025-11-08 15:17:16'),
(6, 23, 23, '2025-11-25 19:00:00', '2025-11-26 18:00:00', 700.00, '2025-11-08 21:11:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `icono_flaticon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `titulo`, `descripcion`, `icono_flaticon`) VALUES
(1, 'Alquiler para Bodas', 'Un servicio elegante para tu día especial. Llega con estilo y la comodidad que te mereces.', 'flaticon-wedding-car'),
(2, 'Traslados Urbanos', 'Te llevamos de punto A a punto B dentro de la ciudad de forma rápida y segura.', 'flaticon-transportation'),
(3, 'Traslados al Aeropuerto', 'Empieza o termina tu viaje con comodidad. Te recogemos o te llevamos al aeropuerto puntualmente.', 'flaticon-car'),
(4, 'Tours por la Ciudad', 'Descubre la ciudad a tu propio ritmo con uno de nuestros coches y un conductor opcional.', 'flaticon-transportation');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `correo` varchar(55) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` varchar(25) DEFAULT 'user',
  `imagen` varchar(255) DEFAULT 'images/autores/default.png',
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `telefono`, `username`, `password`, `rol`, `imagen`, `bio`) VALUES
(1, 'Adrian', 'admin@solvam.es', 123456789, 'adri', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'admin', 'images/adri.avif', 'Filantropo, guapo, millonario, no hay adjetivos para describir al mejor en el mundo, una de las mayores personalidades del planeta'),
(2, 'Mariluz', 'mariluz@solvam.es', 987654321, 'mariluz', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'admin', 'images/mariluz.webp', 'Top Model internacional, 7 veces ganadora del miss universo, conocida por su simpatía, amabilidad y carisma'),
(3, 'Adahi', 'adahi@solvam.es', 515184818, 'adahi', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'editor', 'images/adahi.jpg', 'Luchador profesional de Lucha Turca, 8 veces campeón del mundo en esa disciplina'),
(4, 'Joselu', 'Joselu@israel.es', 841212561, 'joselu', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'editor', 'images/joselu.png', 'Exprimer ministro Israelí, buscado por 140 países Nº1 más buscado por la Interpol por sus relaciones con Al Qaeda, Isis entre otras organizaciones peligrosas'),
(5, 'Lorenzo', 'lorenzo@solvam.es', 987654321, 'lorenzo', '$2y$12$BbACIgRj3qbQ8rdnJi.rzuZ9lfTQEggm0Yd1Pb8nmJDxXB0k7yTde', 'user', 'images/autores/default.png', NULL),
(23, 'Pablo', 'pablo@elpol.com', 961547793, 'elPol', '$2y$12$fpRc6imZf6p1sa.iR4Eyb.wbAmaIRsjAACQNkJ9frrIraiSeGcLYC', 'user', 'images/autores/default.png', NULL),
(25, 'jorge', 'jorge@solvam.es', 961547793, 'jorge', '$2y$12$4WRWCgpgpozRKn10c9mneuI6YcpjJSbVAJLezuPRm4f7x.DsOSEDe', 'user', 'images/autores/default.png', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id_blog`),
  ADD KEY `fk_blog_autor` (`id_autor`);

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
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id_opinion`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_reserva_usuario` (`id_usuario`),
  ADD KEY `fk_reserva_coche` (`id_coche`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blog`
--
ALTER TABLE `blog`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id_coche` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id_opinion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `fk_blog_autor` FOREIGN KEY (`id_autor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `coches_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `marcas` (`id_marca`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_coche` FOREIGN KEY (`id_coche`) REFERENCES `coches` (`id_coche`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
