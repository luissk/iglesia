-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2025 a las 06:47:44
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
-- Base de datos: `iglesiabd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `idcaja` int(11) NOT NULL,
  `ca_caja` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`idcaja`, `ca_caja`) VALUES
(1, 'Principal'),
(2, 'Música'),
(3, 'Concilio'),
(4, 'Evangelismo'),
(5, 'Juventud'),
(6, 'Escuela Bíblica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `idcuenta` int(11) NOT NULL,
  `cu_dh` tinyint(4) NOT NULL COMMENT '1:Debe, 2:Haber',
  `cu_codigo` varchar(45) NOT NULL,
  `cu_cuenta` varchar(45) DEFAULT NULL,
  `cu_observacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iglesia`
--

CREATE TABLE `iglesia` (
  `idiglesia` int(11) NOT NULL,
  `ig_iglesia` varchar(100) DEFAULT NULL,
  `ig_direccion` varchar(100) NOT NULL,
  `ig_pastor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `iglesia`
--

INSERT INTO `iglesia` (`idiglesia`, `ig_iglesia`, `ig_direccion`, `ig_pastor`) VALUES
(1, 'Asociación de Iglesias Cristianas', 'por definir ok', 'Encargado Alberto Ortiz'),
(4, 'Iglesia Monte de Sión - Sintuco', 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad', 'Alipio Avila Valencia'),
(5, 'Iglesia Bethel Casa Grande', 'Urb Miguel Grau 2da Etapa', 'Juan Perez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `idregistro` int(11) NOT NULL,
  `re_fecha` date NOT NULL,
  `re_importe` decimal(10,2) NOT NULL,
  `re_desc` varchar(200) NOT NULL,
  `us_creador` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `idcuenta` int(11) NOT NULL,
  `idresponsable_caja` int(11) NOT NULL,
  `re_fechareg` timestamp NOT NULL DEFAULT current_timestamp(),
  `re_fechaact` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable_caja`
--

CREATE TABLE `responsable_caja` (
  `idresponsable_caja` int(11) NOT NULL,
  `re_nombres` varchar(100) NOT NULL,
  `idiglesia` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `us_creador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `responsable_caja`
--

INSERT INTO `responsable_caja` (`idresponsable_caja`, `re_nombres`, `idiglesia`, `idcaja`, `us_creador`) VALUES
(1, 'Nolberto Solano', 4, 1, 2),
(2, 'Paolo Guerrero', 5, 1, 3),
(3, 'Nolberto Solano', 5, 2, 3),
(4, 'Jeferson Farfán', 4, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `idtipo_usuario` int(11) NOT NULL,
  `tu_tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`idtipo_usuario`, `tu_tipo`) VALUES
(1, 'super'),
(2, 'admin'),
(3, 'registro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `us_usuario` varchar(45) DEFAULT NULL,
  `idiglesia` int(11) NOT NULL,
  `idtipo_usuario` int(11) NOT NULL,
  `us_password` varchar(100) NOT NULL,
  `us_nombre` varchar(100) NOT NULL,
  `us_creador` int(11) DEFAULT NULL,
  `us_fechareg` timestamp NOT NULL DEFAULT current_timestamp(),
  `us_fechaact` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `us_usuario`, `idiglesia`, `idtipo_usuario`, `us_password`, `us_nombre`, `us_creador`, `us_fechareg`, `us_fechaact`) VALUES
(1, 'lcalderons', 1, 1, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Luis A. Calderón Sánchez', NULL, '2025-08-20 21:13:48', '2025-08-22 19:22:30'),
(2, 'usuario1', 4, 2, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Usuario1 Alcántara Riacho', 1, '2025-08-22 21:24:02', '2025-08-23 02:58:32'),
(3, 'usuario2', 5, 2, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Juancito Perez', 1, '2025-08-24 04:35:50', '2025-08-24 04:36:20'),
(4, 'usuarioSion', 4, 3, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Elias Aviles Cavero', 2, '2025-08-22 21:27:59', '2025-08-22 21:27:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`idcaja`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`idcuenta`);

--
-- Indices de la tabla `iglesia`
--
ALTER TABLE `iglesia`
  ADD PRIMARY KEY (`idiglesia`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`idregistro`),
  ADD KEY `fk_registro_usuario1_idx` (`us_creador`),
  ADD KEY `fk_registro_cuenta1_idx` (`idcuenta`),
  ADD KEY `idresponsable_caja` (`idresponsable_caja`);

--
-- Indices de la tabla `responsable_caja`
--
ALTER TABLE `responsable_caja`
  ADD PRIMARY KEY (`idresponsable_caja`),
  ADD KEY `idcaja` (`idcaja`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`idtipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`us_usuario`),
  ADD KEY `fk_usuario_iglesia_idx` (`idiglesia`),
  ADD KEY `fk_usuario_tipo_usuario1_idx` (`idtipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `idcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `iglesia`
--
ALTER TABLE `iglesia`
  MODIFY `idiglesia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `responsable_caja`
--
ALTER TABLE `responsable_caja`
  MODIFY `idresponsable_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `idtipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `fk_registro_cuenta1` FOREIGN KEY (`idcuenta`) REFERENCES `cuenta` (`idcuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registro_usuario1` FOREIGN KEY (`us_creador`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `registro_ibfk_1` FOREIGN KEY (`idresponsable_caja`) REFERENCES `responsable_caja` (`idresponsable_caja`);

--
-- Filtros para la tabla `responsable_caja`
--
ALTER TABLE `responsable_caja`
  ADD CONSTRAINT `responsable_caja_ibfk_1` FOREIGN KEY (`idcaja`) REFERENCES `caja` (`idcaja`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_iglesia` FOREIGN KEY (`idiglesia`) REFERENCES `iglesia` (`idiglesia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_tipo_usuario1` FOREIGN KEY (`idtipo_usuario`) REFERENCES `tipo_usuario` (`idtipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
