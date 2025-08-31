-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-09-2025 a las 00:27:06
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
  `cu_dh` enum('Debe','Haber') NOT NULL COMMENT '1:Debe, 2:Haber',
  `cu_codigo` char(3) NOT NULL,
  `cu_cuenta` varchar(100) DEFAULT NULL,
  `cu_observacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`idcuenta`, `cu_dh`, `cu_codigo`, `cu_cuenta`, `cu_observacion`) VALUES
(1, 'Debe', '101', 'Caja', 'Caja efectivo'),
(2, 'Debe', '141', 'Préstamo x Acción Social', 'Préstamo para Pollada, parrillada, ect.'),
(3, 'Debe', '142', 'Transf.entre cajas mismo templo', 'eliminar '),
(4, 'Debe', '421', 'Ctas x Pagar-fact. Compras, R/luz', 'Pago de Facturas '),
(5, 'Debe', '621', 'Remuneracion-Visitantes Pastores, varios', 'Remunerac  Visitantes, Pastores varios'),
(6, 'Debe', '622', 'Otras remuneraciones-labores varias', 'Remuneración limpieza, atención a enfermos'),
(7, 'Debe', '623', 'Remuneracion-Pastor-Copastor', 'Remuneración al Pastor y Copastor'),
(8, 'Debe', '624', 'Capacitación', 'Gastos por Capacitación'),
(9, 'Debe', '625', 'Atención a Visitantes', 'Refrigerio a Pastores y otros'),
(10, 'Debe', '631', 'Transporte y gastos de viaje', 'Gastos por movilidad, pasajes'),
(11, 'Debe', '636', 'Servicios básicos, agua luz', 'Gastos por energía electrica…agua.'),
(12, 'Debe', '641', 'Tributos gobierno central', 'Gasto por pago tributos: RENTA PYMES….'),
(13, 'Debe', '643', 'Tributos gobierno municipalidades', 'Gastos por Impuesto predial, otros'),
(14, 'Debe', '654', 'Gastos varios', 'Medicina hno obando'),
(15, 'Debe', '655', 'Otros gastos de gestión', 'Utiles varios: limpieza, copias, chapas, etc'),
(16, 'Debe', '656', 'Compra de flores para el Altar', 'Compra Flores para el altar'),
(17, 'Debe', '659', 'Donaciones', 'Donaciones'),
(18, 'Debe', '759', 'eliminar', 'eliminar '),
(19, 'Haber', '101', 'Caja efectivo', 'Caja efectivo'),
(20, 'Haber', '141', 'Préstamo x Acción Social', 'Préstamo para actividades, Pollada, parrillada, ect.'),
(21, 'Haber', '421', 'Ctas x Pagar-fact. Compras, R/luz', 'Pago de Factura por compras, activos fijos ,luz, agua'),
(22, 'Haber', '751', 'Diezmo actual', 'Diezmo actual'),
(23, 'Haber', '752', 'Diezmo anterior', 'Diezmo anterior'),
(24, 'Haber', '753', 'Ofrenda recogida', 'Ofrenda recogida'),
(25, 'Haber', '754', 'Ofrenda misionera', 'Ofrenda misionera'),
(26, 'Haber', '755', 'Ofrenda visitantes', 'Ofrenda visitantes'),
(27, 'Haber', '756', 'Ofrenda niños E. dominical', 'Ofrenda niños E. dominical'),
(28, 'Haber', '757', 'Por acción social', 'Ganancia x acción Social'),
(29, 'Haber', '759', 'Otros ingresos de Gestión', 'Aporte para gas, otros'),
(30, 'Haber', '140', 'Saldo Inicial', 'Saldo inicial de las iglesias');

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
(1, 'Asociación Evangélica Avivamiento Peruano Emmanuel a las Naciones', 'Ascope - La Libertad', 'Alberto Izquierdo'),
(4, 'Iglesia Monte de Sión - Sintuco', 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad', 'Alipio Avila Valencia'),
(5, 'Iglesia Bethel Casa Grande', 'Urb Miguel Grau 2da Etapa', 'Juan Perez'),
(7, 'Iglesia Lirio de los Valles', 'Careaga', 'Oscar Barreto');

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
  `idcuenta` int(11) NOT NULL,
  `idresponsable_caja` int(11) NOT NULL,
  `re_mov` tinyint(4) NOT NULL,
  `re_fechareg` timestamp NOT NULL DEFAULT current_timestamp(),
  `re_fechaact` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idiglesia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`idregistro`, `re_fecha`, `re_importe`, `re_desc`, `us_creador`, `idcuenta`, `idresponsable_caja`, `re_mov`, `re_fechareg`, `re_fechaact`, `idiglesia`) VALUES
(1, '2025-05-02', 16.00, 'Ofrenda recogida', 2, 24, 1, 1, '2025-08-29 14:19:42', '2025-08-31 17:01:31', 4),
(2, '2025-05-03', 300.00, 'Pasajes mes Pastor Alipio', 2, 10, 1, 2, '2025-08-29 14:22:40', '2025-08-31 17:01:31', 4),
(3, '2025-05-06', 30.00, 'Julia Juárez', 2, 22, 1, 1, '2025-08-29 14:23:43', '2025-08-31 17:01:31', 4),
(4, '2025-05-06', 363.00, 'Leonel Cueva', 2, 22, 1, 1, '2025-08-29 14:28:09', '2025-08-31 17:01:31', 4),
(5, '2025-03-01', 3000.00, 'saldo inicial de la iglesia monte de sion', 2, 30, 1, 1, '2025-08-29 16:41:26', '2025-08-31 17:01:31', 4),
(6, '2025-03-03', 150.00, 'ofrendas', 2, 25, 1, 1, '2025-08-29 18:13:02', '2025-08-31 17:01:31', 4),
(7, '2025-03-05', 120.50, 'ofrendas', 2, 25, 1, 1, '2025-08-29 18:13:40', '2025-08-31 17:01:31', 4),
(8, '2025-03-05', 200.00, 'capacitacion al sistema', 2, 8, 1, 2, '2025-08-29 18:14:09', '2025-08-31 17:01:31', 4),
(9, '2025-03-20', 80.00, 'atencion a visitantes de iglesias', 2, 9, 4, 2, '2025-08-29 18:15:18', '2025-08-31 17:01:31', 4),
(10, '2025-03-23', 2.20, 'ofrenda de niños', 2, 27, 6, 1, '2025-08-29 18:16:36', '2025-08-31 17:01:31', 4),
(11, '2025-04-01', 100.00, 'Raquel Uceda - diezmo de marzo', 2, 23, 1, 1, '2025-08-29 18:23:52', '2025-08-31 17:01:31', 4),
(12, '2025-04-04', 150.00, 'Alberto Oriz - diezmo', 2, 22, 1, 1, '2025-08-29 18:24:20', '2025-08-31 17:01:31', 4),
(13, '2025-04-16', 50.00, 'compra de flores', 2, 16, 1, 2, '2025-08-29 19:28:08', '2025-08-31 17:01:31', 4),
(14, '2025-04-29', 85.00, 'clases de canto', 2, 8, 4, 2, '2025-08-29 19:36:18', '2025-08-31 17:01:31', 4),
(15, '2025-04-29', 12.00, 'clases de canto', 2, 24, 1, 1, '2025-08-29 19:36:35', '2025-08-31 17:01:31', 4),
(16, '2025-05-29', 106.00, 'Otros ingresos', 2, 29, 7, 1, '2025-08-29 19:44:10', '2025-08-31 17:01:31', 4),
(17, '2025-05-10', 55.50, 'Compra de flores para todo el templo', 2, 16, 1, 2, '2025-08-30 13:51:27', '2025-08-31 17:01:31', 4),
(18, '2025-05-20', 55.50, 'Julia Juarez - diezmo', 2, 22, 1, 1, '2025-08-30 13:52:14', '2025-08-31 17:01:31', 4),
(19, '2025-05-30', 250.00, 'Pago a copastor', 2, 7, 1, 2, '2025-08-31 17:21:09', '2025-08-31 17:21:09', 4);

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
(1, 'Juana Juarez De La Cruz', 4, 1, 2),
(2, 'Paolo Guerrero', 5, 1, 3),
(3, 'Nolberto Solano', 5, 2, 3),
(4, 'Digna Flores', 4, 2, 2),
(5, 'Lidia Briceño', 4, 3, 2),
(6, 'Raquel Uceda', 4, 4, 2),
(7, 'Evelyn Mesa', 4, 5, 2),
(8, 'Juana Juarez De La Cruz', 4, 6, 2);

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
(2, 'jjuarez', 4, 2, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Juana Juarez De La Cruz', 1, '2025-08-22 21:24:02', '2025-08-26 16:38:12'),
(3, 'usuario2', 5, 2, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Juancito Perez', 1, '2025-08-24 04:35:50', '2025-08-24 04:36:20'),
(5, 'srbarreto', 7, 2, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Sr Barreto', 1, '2025-08-26 16:29:03', '2025-08-26 16:29:03'),
(6, 'auxiliar', 7, 3, '$2a$12$YmtIBS/VsxVywSQHV4A2.uFU8VcIdeY.pJDE0ZjKocqkKMwFw/Hka', 'Usuario Auxiliar', 5, '2025-08-26 16:35:20', '2025-08-26 16:35:20');

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
  ADD KEY `idresponsable_caja` (`idresponsable_caja`),
  ADD KEY `idx_iglesia_fecha` (`idiglesia`,`re_fecha`);

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
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `iglesia`
--
ALTER TABLE `iglesia`
  MODIFY `idiglesia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `responsable_caja`
--
ALTER TABLE `responsable_caja`
  MODIFY `idresponsable_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `idtipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
