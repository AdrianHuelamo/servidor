-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-01-2026 a las 21:24:55
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
(7, 4, 'Curl de Bíceps', 'Flexión de codo con barra o mancuernas.', 'Baja', 'curl.jpg', 0),
(8, 1, 'Press Inclinado con Mancuernas', 'Variante fundamental para enfatizar la parte superior del pectoral (clavicular). Ajusta el banco a 30-45 grados. Controla la bajada hasta estirar bien el pecho y empuja las mancuernas hacia arriba juntándolas ligeramente sin chocarlas.', 'Media', 'press_inclinado.jpg', 1),
(9, 1, 'Cruce de Poleas (Crossover)', 'Excelente ejercicio de aislamiento y bombeo final. De pie en medio de las poleas, inclina el tronco ligeramente y lleva las manos al centro apretando el pecho. Mantén los codos ligeramente flexionados para proteger la articulación.', 'Baja', 'cruce_poleas.jpg', 0),
(10, 2, 'Jalón al Pecho', 'Alternativa a las dominadas para ganar fuerza. Siéntate, sujeta la barra con un agarre amplio y tira verticalmente hacia la parte superior de tu pecho, inclinándote un poco hacia atrás. Evita usar el impulso de la espalda baja.', 'Baja', 'jalon_pecho.jpg', 0),
(11, 2, 'Remo Gironda (Polea Baja)', 'Trabaja el grosor de la espalda. Sentado con las piernas semiflexionadas, tira del agarre hacia el abdomen manteniendo la espalda recta y el pecho fuera. Céntrate en juntar las escápulas al final del movimiento.', 'Media', 'remo_gironda.jpg', 0),
(12, 3, 'Peso Muerto Rumano', 'Crucial para los isquiosurales (femorales) y glúteos. Con las piernas semirrígidas, baja la barra rozando tus piernas llevando la cadera hacia atrás hasta sentir un estiramiento profundo detrás de los muslos. Sube apretando el glúteo.', 'Alta', 'peso_muerto_rumano.jpg', 1),
(13, 3, 'Zancadas (Lunges)', 'Trabajo unilateral para corregir desequilibrios. Da un paso largo y baja verticalmente. Ideal para glúteo y cuádriceps. Puedes hacerlo con mancuernas a los lados o barra en la espalda.', 'Media', 'zancadas.jpg', 0),
(14, 3, 'Extensiones de Cuádriceps', 'Aislamiento puro para la parte frontal del muslo. Sentado en la máquina, extiende las piernas hasta bloquear suavemente y aguanta 1 segundo arriba. Baja lento. Perfecto para finalizar la rutina de pierna.', 'Baja', 'extensiones_cuadriceps.jpg', 0),
(15, 4, 'Press Francés con Barra Z', 'Constructor de masa para el tríceps. Tumbado en banco plano, baja la barra hacia tu frente flexionando solo los codos. Mantén los codos cerrados y apuntando al techo durante todo el movimiento.', 'Media', 'press_frances.jpg', 1),
(16, 4, 'Extensiones de Tríceps en Polea', 'Básico de polea. De pie, sujeta la cuerda o barra recta y empuja hacia abajo sin separar los codos de los costados. Aprieta fuerte el tríceps abajo.', 'Baja', 'triceps_polea.jpg', 0),
(17, 4, 'Curl Martillo', 'Variante del curl de bíceps con agarre neutro (palmas enfrentadas). Trabaja el bíceps y también el braquial y antebrazo, dando un aspecto de brazo más ancho.', 'Baja', 'curl_martillo.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_ejercicio` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id`, `id_user`, `id_ejercicio`, `created_at`) VALUES
(1, 4, 1, '2026-01-21 18:51:12');

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
(3, 'Errores comunes en novatos', 'Evita lesiones siguiendo estos consejos.', 'No cargues más peso del que controlas. La técnica siempre debe ir por delante del ego...', '2026-01-04', 'novatos.jpg'),
(4, 'Los 5 suplementos con mayor evidencia científica', 'No tires tu dinero. Descubre qué suplementos realmente funcionan para ganar masa muscular y fuerza según los últimos estudios.', 'En el mundo del fitness hay mucha desinformación. Sin embargo, la creatina monohidrato, la proteína de suero (Whey), la cafeína y la beta-alanina son de los pocos suplementos que han demostrado consistentemente su eficacia en estudios clínicos. La creatina, por ejemplo, mejora el rendimiento en ejercicios de alta intensidad y ayuda a la ganancia de masa magra. Por otro lado, la proteína en polvo es una herramienta excelente para llegar a tus requerimientos diarios de manera cómoda.', '2026-01-16', 'suplementos.jpg'),
(5, '¿Cardio antes o después de las pesas?', 'Resolvemos la eterna duda del gimnasio. Aprende a organizar tu sesión para maximizar la quema de grasa y la hipertrofia.', 'La respuesta corta es: depende de tu objetivo principal. Si buscas ganar fuerza y masa muscular, deberías priorizar el entrenamiento de pesas cuando tus reservas de glucógeno están llenas, dejando el cardio para el final. Si haces cardio intenso antes, fatigarás tus músculos y sistema nervioso, reduciendo tu rendimiento en el levantamiento. Sin embargo, un calentamiento ligero de 5-10 minutos antes de las pesas es muy recomendable.', '2026-01-19', 'cardio.jpg'),
(7, 'Domina la Sentadilla: Guía técnica paso a paso', 'Mejora tu profundidad y evita lesiones de rodilla con estos consejos clave para una sentadilla perfecta.', 'La sentadilla es la reina de los ejercicios de pierna, pero requiere técnica. 1. Coloca los pies a la anchura de los hombros con las puntas ligeramente hacia fuera. 2. Inicia el movimiento llevando la cadera atrás, no solo doblando las rodillas. 3. Mantén el pecho alto y la espalda neutra. 4. Rompe el paralelo (baja hasta que tu cadera esté por debajo de la rodilla) si tu movilidad lo permite. Evita que las rodillas colapsen hacia dentro al subir.', '2026-01-06', 'sentadilla.webp'),
(8, 'Receta: Batido post-entreno casero y económico', 'Olvídate de los batidos industriales caros. Prepara esta bomba de proteínas y carbohidratos en 2 minutos.', 'Ingredientes: 200ml de leche o bebida vegetal, 1 plátano maduro (carbohidratos rápidos), 1 scoop de proteína de chocolate o 150g de claras de huevo pasteurizadas, 1 cucharada de crema de cacahuete y hielo. Bátelo todo y tendrás una comida perfecta para recuperar glucógeno y reparar fibras después de una sesión intensa. ¡Y mucho más barato que comprarlo hecho!', '2026-01-01', 'batido.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinas`
--

CREATE TABLE `rutinas` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutinas`
--

INSERT INTO `rutinas` (`id`, `id_user`, `nombre`, `descripcion`, `created_at`) VALUES
(1, 4, 'Pecho', 'Adahi quiere Groenlandia', '2026-01-21 19:14:20'),
(2, 5, 'Espalda', '', '2026-01-21 20:20:51'),
(3, 5, 'Brazos', '', '2026-01-21 20:21:36'),
(4, 6, 'pierna', '', '2026-01-21 20:22:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina_ejercicios`
--

CREATE TABLE `rutina_ejercicios` (
  `id` int(11) NOT NULL,
  `id_rutina` int(11) NOT NULL,
  `id_ejercicio` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutina_ejercicios`
--

INSERT INTO `rutina_ejercicios` (`id`, `id_rutina`, `id_ejercicio`, `created_at`) VALUES
(1, 1, 1, '2026-01-21 19:18:28'),
(2, 1, 6, '2026-01-21 19:18:40'),
(3, 1, 7, '2026-01-21 19:18:45'),
(4, 2, 10, '2026-01-21 20:21:11'),
(5, 2, 4, '2026-01-21 20:21:19'),
(6, 2, 11, '2026-01-21 20:21:26'),
(7, 3, 7, '2026-01-21 20:21:42'),
(8, 3, 17, '2026-01-21 20:21:47'),
(9, 3, 16, '2026-01-21 20:21:50'),
(10, 4, 5, '2026-01-21 20:23:04'),
(11, 4, 13, '2026-01-21 20:23:08'),
(12, 4, 6, '2026-01-21 20:23:15');

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
(4, 'jorge', 'jorge@gym.com', '$2y$10$ad/uE8i3PV1Y7sFt4CttHOM6QWRX9/GuZUE1Lma8hrVexZl1KgDk2', 0),
(5, 'pol', 'pol@gym.com', '$2y$10$zGHA16TnRopQJIfu9WE6OekYuHM7Q75CWAveuTZL4RGShVNDz5vr6', 0),
(6, 'adahi', 'adahi@psoe.com', '$2y$10$75q1gEjz5A1kGaO5.Jd4dOnecJXwSveSKVHvdlPLqp2r4/A16fima', 0);

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
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_ejercicio` (`id_ejercicio`);

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
-- Indices de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rutina` (`id_rutina`),
  ADD KEY `id_ejercicio` (`id_ejercicio`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `ejercicios_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos_musculares` (`id`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD CONSTRAINT `rutinas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  ADD CONSTRAINT `rutina_ejercicios_ibfk_1` FOREIGN KEY (`id_rutina`) REFERENCES `rutinas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rutina_ejercicios_ibfk_2` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
