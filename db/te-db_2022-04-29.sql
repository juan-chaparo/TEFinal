-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-04-2022 a las 05:27:44
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `te`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_mensajes`
--

CREATE TABLE `ta_mensajes` (
  `ID_MENSAJE` int(11) NOT NULL,
  `MENSAJE` varchar(150) NOT NULL,
  `FECHA_ENVIO` datetime NOT NULL,
  `PATH_ARCHIVO` varchar(250) DEFAULT NULL,
  `ID_USUARIO_E` int(11) NOT NULL,
  `ID_USUARIO_R` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ta_mensajes`
--

INSERT INTO `ta_mensajes` (`ID_MENSAJE`, `MENSAJE`, `FECHA_ENVIO`, `PATH_ARCHIVO`, `ID_USUARIO_E`, `ID_USUARIO_R`) VALUES
(1, 'Hola ¿Cómo estás?', '2022-04-03 20:36:47', NULL, 1, 60),
(2, 'Oiga conteste!!!', '2022-04-03 21:11:56', NULL, 1, 60),
(3, 'Callese castrosa', '2022-04-04 15:34:27', NULL, 2, 1),
(4, 'Hola soy nuevo', '2022-04-04 15:42:26', NULL, 3, 60),
(5, 'Que me importa', '2022-04-04 16:03:11', NULL, 2, 3),
(6, 'Juan Pablo es una zorra', '2022-04-04 17:16:39', NULL, 2, 1),
(7, 'Hola, quiere jugar lol?', '2022-04-06 00:00:00', NULL, 2, 3),
(8, 'Hola jijijija', '2022-04-06 20:49:08', NULL, 2, 1),
(9, 'Puta', '2022-04-06 21:06:12', './file/79f39d634cff5c444235e1d01b6adf21,pdf', 2, 3),
(10, 'Hola, jijijija', '2022-04-07 15:14:00', './file/ed5e8f4beaf9f09e67b0e7e5e82f0cd2,docx', 2, 3),
(11, 'lol o miedo', '2022-04-12 16:34:05', NULL, 2, 1),
(12, 'juas juas', '2022-04-13 19:22:20', NULL, 2, 3),
(13, 'bety', '2022-04-14 19:44:16', './file/Taller 2.pdf', 1, 22),
(21, 'Hola maria', '2022-04-21 11:10:57', NULL, 60, 4),
(22, 'Hola maria', '2022-04-21 11:41:13', NULL, 60, 8),
(23, 'Hola otto', '2022-04-21 11:45:02', NULL, 60, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_tweets`
--

CREATE TABLE `ta_tweets` (
  `ID_TWEET` int(11) NOT NULL,
  `TWEET` varchar(250) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ESTADO` tinyint(1) NOT NULL,
  `FECHA_CREACION` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ta_tweets`
--

INSERT INTO `ta_tweets` (`ID_TWEET`, `TWEET`, `ID_USUARIO`, `ESTADO`, `FECHA_CREACION`) VALUES
(14, 'adios mundo', 2, 1, '2022-04-12 19:03:34'),
(15, 'justo?', 1, 1, '2022-04-12 19:14:42'),
(18, 'a', 1, 1, '2022-04-14 21:18:48'),
(39, 'c ', 60, 0, '2022-04-21 10:48:28'),
(40, 'c ', 60, 1, '2022-04-21 10:49:04'),
(41, 'fff ', 60, 0, '2022-04-21 10:49:22'),
(42, 'c ', 60, 0, '2022-04-21 11:48:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ta_usuarios`
--

CREATE TABLE `ta_usuarios` (
  `USER` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CONTRA` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ID_TIPO_DOCUMENTO` int(11) DEFAULT NULL,
  `DOCUMENTO` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `PATHIMAGEN` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA_NACIMIENTO` datetime DEFAULT NULL,
  `NOMBRE` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `APELLIDO` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COLOR` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `CORREO` varchar(150) DEFAULT NULL,
  `DIRECCION` varchar(150) DEFAULT NULL,
  `HIJOS` int(11) NOT NULL,
  `ID_ESTADO_CIVIL` int(11) DEFAULT NULL,
  `ID_USUARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ta_usuarios`
--

INSERT INTO `ta_usuarios` (`USER`, `CONTRA`, `ID_TIPO_DOCUMENTO`, `DOCUMENTO`, `PATHIMAGEN`, `FECHA_NACIMIENTO`, `NOMBRE`, `APELLIDO`, `COLOR`, `CORREO`, `DIRECCION`, `HIJOS`, `ID_ESTADO_CIVIL`, `ID_USUARIO`) VALUES
('r', 'deb43edd55258f84accc9927f2a87833', 1, '1002480566', './file/49c8b18e0f8be5505d22e201211b9856,jpeg', '2022-03-16 00:00:00', 'Leidy', 'Carolina', '#caa0a0', 'r@gmail.com', 'cra 2', 6, 1, 1),
('q', '55b9e787fe388d80664892d2777e5f02', 4, '10024805661', 'popo', '2022-03-01 00:00:00', 'pepe', 'perez', '#8c91d9', 'porque', '5', 5, 1, 2),
('w', '91997fbd70b1089897ac0de3fa73d5c8', 1, '151561', './file/c1a1ae078fd48600e0b1056519314102,jpg', '2020-02-20 00:00:00', 'Diego', 'Castaneda', '#ff0000', NULL, NULL, 0, NULL, 3),
('e', '97a0c0260314b0ff36c2ead3e9dbb15b', 4, '12', './file/cbfab038ebf91313908b08b31fbef938,png', '2022-04-06 00:00:00', 'Yeimy', 'Castaneda', '#dcc7c7', NULL, NULL, 0, NULL, 4),
('t', '158a6df78962e9caa5878a40c446e3c0', 3, '123fd', './file/fafb6495d6d794eb054576c666addea4,png', '2022-04-04 00:00:00', 'Diego', 'jaja', '#dfc3c3', NULL, NULL, 0, NULL, 5),
('y', '643d8011c2778534aee796bff8312714', 2, '12333', 'popo', '2022-04-05 00:00:00', 'pepe', 'perez', '#d2b7b7', 'porque', '5', 5, 1, 6),
('vgjgjgv', 'cbe2f875f443fec083d9f640725dc425', 2, '544', './file/4679b615aa3cd21aa07b7328462ed11e,jpg', '2022-04-05 00:00:00', 'dgd54g', 'fdf', '#d31717', NULL, NULL, 0, NULL, 7),
('pi', 'f6fbc8689195c77155d0357dd8c8e301', 2, '12', './file/de920c743e34a62288f35defd2275af9,png', '2022-04-05 00:00:00', 'asdsa5665578', 'Castaneda', '#dcb7b7', NULL, NULL, 0, NULL, 8),
('p', 'f2b08c789522d39268cbb9b7a4e00a73', 1, '1111111', './file/d112c5d4950df73c7ac7d3ce4c1c84cf,png', '2022-04-12 00:00:00', 'put', 'a', '#000000', NULL, NULL, 0, NULL, 9),
('u', 'a9ab0361d683a8cbc623571116010767', 1, '21222', './file/1bf3c8a607fc434e7e3fb8f19469d818,jpg', '2222-05-13 00:00:00', 'adasd..,.,.', 'asdasd', '#000000', NULL, NULL, 0, NULL, 10),
('z', '36957d00a1a6d053a036de403ee3d2ba', 1, '22222', './file/8f1fc71c05d69bfc231a1b9af8f13a56,png', '2222-02-13 00:00:00', 'Diego', 'wqeqeq', '#000000', NULL, NULL, 0, NULL, 11),
('t', '158a6df78962e9caa5878a40c446e3c0', 3, '123123', './file/342c8d7f21d622ef3cbe0db6d3c88908,jpg', '2022-04-12 00:00:00', 'Perra', 'ppppp', '#ff0000', NULL, NULL, 0, NULL, 12),
('Diego', '7b75300b05e59a03660086801f533d81', 4, '12312', './file/25be51898a6b09bb5a19134d35e8a7b1,jpg', '5555-05-12 00:00:00', 'echo \'<script language=\"javascript\">alert(\"juas\");</script>\';', 'Castaneda', '#000000', NULL, NULL, 0, NULL, 13),
('g', '7db7545940653801c540879d0d31c73d', 3, '12312', './file/ccf4d5b8a5b6701310b7a9d8abd2010b,png', '2022-04-06 00:00:00', 'echo \'<script language=\"javascript\">alert(\"juas\");</script>\';', 'Castaneda', '#ff0000', NULL, NULL, 0, NULL, 14),
('a', '3799db36bc4f67b16b72122e8bfe80fc', 2, '111', './file/c810e28e12cf1ca0039f96993dc07468,jpg', '2022-04-06 00:00:00', 'echo \'<script language=\"javascript\">alert(\"juas\");</script>\';', 'aa', '#000000', NULL, NULL, 0, NULL, 15),
('z', 'd26db7bb014318b77d7af25eed05eebb', 1, '12312', './file/9c56f00c97a63be442efb44425b15d68,jpg', '2022-03-30 00:00:00', 'echo \'<script language=\"javascript\">alert(\"juas\");</script>\';', 'Castaneda', '#20ee38', NULL, NULL, 0, NULL, 16),
('k', '7de6332e6f12e051f1180384d1d0d05a', 3, '65656', './file/484649c97fd7c6db5cd43056ca2f346b,png', '2022-04-07 00:00:00', 'Diego', 'wqeqeq', '#a6ff00', NULL, NULL, 0, NULL, 17),
('diego', '72b944cc6987f56173075a1564e3e7dc', 1, '222', './file/41b48d19f07a17a6056a67265d2a0af6,jpg', '2022-04-07 00:00:00', 'Diego', 'Castaneda', '#404620', NULL, NULL, 0, NULL, 18),
('Juan', '93ff404e0a0a903fdd177a770760423b', 3, '1112', './file/d66f1527d79e27b9d86f01565c8b9634,jpg', '2022-04-10 00:00:00', 'Juan', 'wqeqeq', '#196df5', NULL, NULL, 0, NULL, 19),
('Juan', '1a03fa82ce2b0c9d122c94a01d7942af', 1, '21', './file/729e5464fe944da2b4a445a18fd17334,jpg', '2022-06-01 00:00:00', 'Juan', 'asdasd', '#ad2525', NULL, NULL, 0, NULL, 20),
('k', '871c1d598f10afa1053ac8be7d5f59cb', 4, '1002480566', './file/9d7e222646a011ece00a1130f53102f7,jpeg', '2022-04-06 00:00:00', 'Karen', 'Novas', '#e26ad2', NULL, NULL, 0, NULL, 21),
('betty', 'a2c054eef783b244de2d2553efcfc17d', NULL, NULL, './file/4b00598eff234ac5a417c26df66c9eed,jpg', NULL, 'Don', 'Armando', NULL, 'donarmando@gmail.com', 'no', 1, 1, 22),
('l', '71a9c8030e2e4d953e83cb6c63ab4062', NULL, NULL, './file/1b13945228a4dea67359b9a071d47a65,jpg', NULL, 'Juan', 'wqeqeq', NULL, 'otaku@goku.com', 'cra 1', 2, 4, 23),
('Maryluz', 'bae68fed50edfb4e48d49624b6b64126', NULL, NULL, 'tmp.jpeg', NULL, 'Mari', 'Luz', NULL, 'maria@gmail.com', 'kra 1', 2, 1, 64);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_estados_civiles`
--

CREATE TABLE `tm_estados_civiles` (
  `ID_ESTADO_CIVIL` int(11) NOT NULL,
  `TIPO_ESTADO` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tm_estados_civiles`
--

INSERT INTO `tm_estados_civiles` (`ID_ESTADO_CIVIL`, `TIPO_ESTADO`) VALUES
(1, 'Soltero'),
(2, 'Casado'),
(3, 'Union libre'),
(4, 'Viudo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_tipodocumento`
--

CREATE TABLE `tm_tipodocumento` (
  `ID_TIPO_DOCUMENTO` int(11) NOT NULL,
  `TIPO_DOCUMENTO` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tm_tipodocumento`
--

INSERT INTO `tm_tipodocumento` (`ID_TIPO_DOCUMENTO`, `TIPO_DOCUMENTO`) VALUES
(1, 'Cedula de ciudadania'),
(2, 'Tarjeta de identidad'),
(3, 'Cedula de extranjeria'),
(4, 'Pasaporte');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ta_mensajes`
--
ALTER TABLE `ta_mensajes`
  ADD PRIMARY KEY (`ID_MENSAJE`),
  ADD KEY `ID_USUARIO_E` (`ID_USUARIO_E`) USING BTREE,
  ADD KEY `ID_USUARIO_R` (`ID_USUARIO_R`);

--
-- Indices de la tabla `ta_tweets`
--
ALTER TABLE `ta_tweets`
  ADD PRIMARY KEY (`ID_TWEET`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `ta_usuarios`
--
ALTER TABLE `ta_usuarios`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD KEY `ID_TIPO_DOCUMENTO` (`ID_TIPO_DOCUMENTO`);

--
-- Indices de la tabla `tm_estados_civiles`
--
ALTER TABLE `tm_estados_civiles`
  ADD PRIMARY KEY (`ID_ESTADO_CIVIL`);

--
-- Indices de la tabla `tm_tipodocumento`
--
ALTER TABLE `tm_tipodocumento`
  ADD PRIMARY KEY (`ID_TIPO_DOCUMENTO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ta_mensajes`
--
ALTER TABLE `ta_mensajes`
  MODIFY `ID_MENSAJE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `ta_tweets`
--
ALTER TABLE `ta_tweets`
  MODIFY `ID_TWEET` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `ta_usuarios`
--
ALTER TABLE `ta_usuarios`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `tm_estados_civiles`
--
ALTER TABLE `tm_estados_civiles`
  MODIFY `ID_ESTADO_CIVIL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tm_tipodocumento`
--
ALTER TABLE `tm_tipodocumento`
  MODIFY `ID_TIPO_DOCUMENTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
