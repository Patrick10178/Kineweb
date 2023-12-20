-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2023 a las 20:13:57
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `descripcion`) VALUES
(1, 'Kinesiologo'),
(2, 'secretaria'),
(3, 'paciente'),
(4, 'Ex paciente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `horario_id` int(11) NOT NULL,
  `terapia` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `paciente_id`, `horario_id`, `terapia`, `fecha`, `estado_id`) VALUES
(19, 14721095, 2, 'rotura hombro', '2023-10-14', 1),
(20, 20250990, 6, 'fractura pies', '2023-10-27', 1),
(21, 10364640, 3, 'esguince', '2023-10-21', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `descripcion`) VALUES
(1, 'Pendiente'),
(2, 'Realizada'),
(3, 'Cancelada'),
(4, 'Asistida'),
(5, 'Perdida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `nombre_horario` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `nombre_horario`) VALUES
(1, '08:30 AM a 09:00 AM'),
(2, '09:00 AM a 09:30 AM'),
(3, '09:30 AM a 10:00 AM'),
(4, '10:00 AM a 10:30 AM'),
(5, '10:30 AM a 11:00 AM'),
(6, '11:00 AM a 11:30 AM'),
(7, '11:30 AM a 12:00 PM'),
(8, '12:00 PM a 12:30 PM'),
(9, '12:30 PM a 01:00 PM'),
(10, '01:00 PM a 01:30 PM'),
(11, '01:30 PM a 02:00 PM'),
(12, '03:00 PM a 03:30 PM'),
(13, '03:30 PM a 04:00 PM'),
(14, '04:00 PM a 04:30 PM'),
(15, '04:30 PM a 05:00 PM'),
(16, '05:00 PM a 05:30 PM'),
(17, '05:30 PM a 06:00 PM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `outgoing_msg_id` int(11) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `is_read`) VALUES
(41, 20250300, 14721095, 'Hola!', 1),
(42, 20250300, 14721095, 'como esta?', 1),
(43, 14721095, 20250300, 'bien, gracias', 1),
(44, 20250300, 14721095, 'tengo una duda, puedo trotar mas de una hora?', 1),
(45, 14721095, 20250300, 'claro!! siempre y cuando no se esfuerce demasiado', 1),
(46, 20250990, 20250300, 'Hola eduardo!', 1),
(47, 20250990, 20250300, 'todo bien?', 1),
(48, 20250300, 20250990, 'Sii, cualquier cosa le estaré escribiendo:)', 1),
(52, 20250300, 10364640, 'hola', 1),
(53, 20250300, 14721095, 'hola', 1),
(54, 14721095, 20250300, 'k tal', 1),
(55, 20250300, 14721095, 'hola ', 1),
(56, 20250300, 14721095, 'hola', 1),
(57, 20250300, 14721095, 'tengo una duda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidoP` varchar(45) NOT NULL,
  `apellidoM` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `nace` date NOT NULL,
  `img` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidoP`, `apellidoM`, `correo`, `telefono`, `contrasena`, `id_cargo`, `nace`, `img`) VALUES
(10364640, 'DANIEl', 'aravena', 'aravena', 'asdasd@gmail.com', 934822921, '81dc9bdb52d04dc20036dbd8313ed055', 3, '2001-10-18', '1689104585m.png'),
(14721095, 'Ricardo', 'Azañero', 'Palma', 'ricardo@gmail.com', 992044528, '81dc9bdb52d04dc20036dbd8313ed055', 3, '1975-07-27', '1689101953m2.png'),
(20250300, 'Constanza', 'Aguilera', 'Rojo', 'coni@gmail.com', 934822921, '81dc9bdb52d04dc20036dbd8313ed055', 1, '1999-05-12', '1657420041avatar-review-4.96e6182.png'),
(20250990, 'Eduardo', 'Portilla', 'Piñero', 'edu@gmail.com', 964542156, '81dc9bdb52d04dc20036dbd8313ed055', 3, '2000-07-22', '1657679528Avatar-Profile-Vector.png'),
(21368689, 'Ruth', 'Higinio', 'Periche', 'ruth@gmail.com', 992044524, '81dc9bdb52d04dc20036dbd8313ed055', 2, '1975-12-05', '1657420181Lovepik_com-401451004-cartoon-avatar.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id_videos` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `nombrev` varchar(45) NOT NULL,
  `link` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL,
  `coment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id_videos`, `id_paciente`, `nombrev`, `link`, `estado`, `coment`) VALUES
(251, 20250990, 'Terapia N°1', 'https://www.youtube.com/embed/GIUow-xGDaU', 2, 'me ayudo bastante con el dolor'),
(252, 20250990, 'Terapia N°2', 'https://www.youtube.com//embed/J3UrwJ33Y5w', 2, 'xcvxcvxcvxcvx'),
(253, 20250990, 'Terapia N°3', 'https://www.youtube.com/embed/WC-75AU2yL8', 1, ''),
(254, 20250990, 'Terapia N°4', 'https://www.youtube.com/embed/gllNzjCsuuk', 1, NULL),
(257, 14721095, 'kasjdhasjkh', 'https://www.youtube.com/embed/xRij65BjNEE', 2, 'asdasd\r\n\r\n'),
(258, 10364640, 'terapia', 'https://www.youtube.com/embed/xRij65BjNEE', 2, ''),
(259, 14721095, 'Terapia N°1', 'https://www.youtube.com/embed/xRij65BjNEE', 2, 'buena');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `paciente_id_idx` (`paciente_id`),
  ADD KEY `horario_id_idx` (`horario_id`),
  ADD KEY `estado_id_idx` (`estado_id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cargo_idx` (`id_cargo`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_videos`),
  ADD KEY `id_paciente_idx` (`id_paciente`),
  ADD KEY `id_estado_idx` (`estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id_videos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `estado_id` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_id` FOREIGN KEY (`horario_id`) REFERENCES `horario` (`id_horario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paciente_id` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `id_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`);

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `id_estado` FOREIGN KEY (`estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
