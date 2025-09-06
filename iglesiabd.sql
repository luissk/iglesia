-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2025 a las 17:51:21
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
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `co_fechareg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `co_fecha` date NOT NULL,
  `co_factura` varchar(10) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `us_creador` int(11) NOT NULL,
  `idiglesia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_detalle`
--

CREATE TABLE `compra_detalle` (
  `idcompra_detalle` int(11) NOT NULL,
  `cd_glosa` varchar(100) NOT NULL,
  `cd_precio` decimal(10,2) NOT NULL,
  `cd_cant` smallint(6) NOT NULL,
  `cd_subtotal` decimal(10,2) NOT NULL,
  `idcuenta` int(11) NOT NULL,
  `idcompra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
(14, 'Debe', '654', 'Gastos varios', 'Utiles de aseo, Medicina hno obando'),
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
(30, 'Haber', '140', 'Saldo Inicial', 'Saldo inicial de las iglesias'),
(31, 'Debe', '401', 'Igv', '-');

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
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `pr_ruc` varchar(11) NOT NULL,
  `pr_razon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `pr_ruc`, `pr_razon`) VALUES
(1, '20100190797', 'Gloria S.A.'),
(2, '10454872296', 'LUISCS S.A.C.'),
(6, '11111111111', 'sxczczxc'),
(7, '13123123131', '13123123'),
(8, '14785236987', 'PRUEBA SAC');

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
(1, '2025-07-01', 2682.49, 'Saldo inicial', 2, 30, 1, 1, '2025-09-05 03:52:20', '2025-09-05 03:52:20', 4),
(2, '2025-07-01', 16.50, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 03:53:09', '2025-09-05 03:53:09', 4),
(3, '2025-07-01', 17.60, '1 BOLSA DE PAPEL HIGIENICO', 2, 15, 1, 2, '2025-09-05 03:59:52', '2025-09-05 04:04:12', 4),
(4, '2025-07-01', 20.50, '1 PAPEL TOALLA NOVA', 2, 15, 1, 2, '2025-09-05 04:00:23', '2025-09-05 04:04:03', 4),
(5, '2025-07-01', 14.90, '1 GALON DE POET', 2, 15, 1, 2, '2025-09-05 04:03:28', '2025-09-05 04:03:28', 4),
(6, '2025-07-03', 300.00, 'PASAJES A PASTOR ALIPIO', 2, 10, 1, 2, '2025-09-05 04:06:00', '2025-09-05 04:06:00', 4),
(7, '2025-07-03', 4.00, 'COPIAS DE BALANCE', 2, 15, 1, 2, '2025-09-05 04:06:29', '2025-09-05 04:06:29', 4),
(8, '2025-07-04', 18.20, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:07:50', '2025-09-05 04:07:50', 4),
(9, '2025-07-04', 210.00, 'LEONEL CUEVA', 2, 22, 1, 1, '2025-09-05 04:08:40', '2025-09-05 04:08:40', 4),
(10, '2025-07-04', 177.00, 'JESUS CERNA', 2, 22, 1, 1, '2025-09-05 04:08:53', '2025-09-05 04:08:53', 4),
(11, '2025-07-05', 50.00, 'MERCEDES CORCUERA', 2, 22, 1, 1, '2025-09-05 04:09:13', '2025-09-05 04:09:13', 4),
(12, '2025-07-05', 50.00, 'CESAREA LIZARRAGA', 2, 23, 1, 1, '2025-09-05 04:09:39', '2025-09-05 04:13:13', 4),
(13, '2025-07-06', 89.10, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:10:01', '2025-09-05 04:10:01', 4),
(14, '2025-07-09', 67.80, 'MIGUEL VALVERDE', 2, 22, 1, 1, '2025-09-05 04:10:29', '2025-09-05 04:10:29', 4),
(15, '2025-07-10', 30.00, 'TEODOLINDA GARCIA', 2, 22, 1, 1, '2025-09-05 04:10:47', '2025-09-05 04:10:47', 4),
(16, '2025-07-11', 50.00, 'SANTOS TANDAIPAN', 2, 22, 1, 1, '2025-09-05 04:11:07', '2025-09-05 04:11:07', 4),
(17, '2025-07-11', 33.10, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:11:20', '2025-09-05 04:11:20', 4),
(18, '2025-07-15', 20.60, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:11:37', '2025-09-05 04:11:37', 4),
(19, '2025-07-18', 16.70, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:11:47', '2025-09-05 04:11:47', 4),
(20, '2025-07-18', 100.00, 'MARIA ARROYO', 2, 22, 1, 1, '2025-09-05 04:12:09', '2025-09-05 04:12:09', 4),
(21, '2025-07-19', 50.00, 'KEVIN LOYOLA', 2, 22, 1, 1, '2025-09-05 04:12:42', '2025-09-05 04:12:42', 4),
(22, '2025-07-21', 258.00, 'FAM BURGOS PAREDES', 2, 22, 1, 1, '2025-09-05 04:13:44', '2025-09-05 04:13:44', 4),
(23, '2025-07-21', 100.00, 'JOSE JUAREZ', 2, 22, 1, 1, '2025-09-05 04:14:26', '2025-09-05 04:14:26', 4),
(24, '2025-07-22', 15.90, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:14:43', '2025-09-05 04:14:43', 4),
(25, '2025-07-24', 9.00, 'OFRENDA DE AMOR CHENIER JUAREZ', 2, 26, 1, 1, '2025-09-05 04:16:30', '2025-09-05 04:16:30', 4),
(26, '2025-07-25', 17.70, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:16:44', '2025-09-05 04:16:44', 4),
(27, '2025-07-27', 150.00, 'OFRENDA DE AMOR IVON SALVADOR', 2, 26, 1, 1, '2025-09-05 04:17:09', '2025-09-05 04:17:09', 4),
(28, '2025-07-27', 20.00, 'NICOLASA VILLANUEVA', 2, 22, 1, 1, '2025-09-05 04:17:25', '2025-09-05 04:17:25', 4),
(29, '2025-07-30', 200.00, 'RAQUEL UCEDA', 2, 22, 1, 1, '2025-09-05 04:17:40', '2025-09-05 04:17:40', 4),
(30, '2025-07-31', 50.00, 'CESAREA LIZARRAGA', 2, 22, 1, 1, '2025-09-05 04:17:57', '2025-09-05 04:17:57', 4),
(31, '2025-07-31', 40.00, 'MARIA ROMAN', 2, 22, 1, 1, '2025-09-05 04:18:07', '2025-09-05 04:18:07', 4),
(32, '2025-07-31', 150.00, 'FAM SALVADOR BUENO', 2, 22, 1, 1, '2025-09-05 04:18:21', '2025-09-05 04:18:21', 4),
(33, '2025-07-31', 160.00, 'FAM REYES ROMAN', 2, 22, 1, 1, '2025-09-05 04:18:34', '2025-09-05 04:18:34', 4),
(34, '2025-07-31', 500.00, 'IVAN GOMEZ', 2, 22, 1, 1, '2025-09-05 04:19:05', '2025-09-05 04:19:05', 4),
(35, '2025-07-31', 46.00, 'OFRENDA MISIONERA DEL PUEBLO', 2, 25, 1, 1, '2025-09-05 04:19:37', '2025-09-05 04:19:37', 4),
(36, '2025-07-31', 205.00, 'OFRENDA DE AMOR JUAN SALVADOR', 2, 26, 1, 1, '2025-09-05 04:20:02', '2025-09-05 04:20:02', 4),
(37, '2025-07-31', 400.00, 'ALBERTO ORTIZ', 2, 22, 1, 1, '2025-09-05 04:20:17', '2025-09-05 04:20:17', 4),
(38, '2025-07-31', 180.00, 'JESUS CERNA', 2, 22, 1, 1, '2025-09-05 04:20:31', '2025-09-05 04:20:31', 4),
(39, '2025-07-31', 100.00, 'FAM SANGAY GUEVARA', 2, 22, 1, 1, '2025-09-05 04:20:42', '2025-09-05 04:20:42', 4);

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
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indices de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD PRIMARY KEY (`idcompra_detalle`),
  ADD KEY `idcompra` (`idcompra`);

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
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`);

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
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  MODIFY `idcompra_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `iglesia`
--
ALTER TABLE `iglesia`
  MODIFY `idiglesia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
-- Filtros para la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD CONSTRAINT `compra_detalle_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`);

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
