-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2025 a las 02:13:39
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
  `co_factura` varchar(13) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `us_creador` int(11) NOT NULL,
  `idiglesia` int(11) NOT NULL,
  `co_subt` decimal(10,2) NOT NULL,
  `co_igv` decimal(10,2) NOT NULL,
  `co_total` decimal(10,2) NOT NULL,
  `cuentafact` int(11) NOT NULL,
  `cuentabase` int(11) NOT NULL,
  `cuentaigv` int(11) NOT NULL,
  `co_glosa` varchar(100) NOT NULL,
  `co_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:pagado,0:no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `co_fechareg`, `co_fecha`, `co_factura`, `idproveedor`, `us_creador`, `idiglesia`, `co_subt`, `co_igv`, `co_total`, `cuentafact`, `cuentabase`, `cuentaigv`, `co_glosa`, `co_status`) VALUES
(1, '2025-09-13 21:11:27', '2025-07-23', 'FG27-59901', 10, 2, 4, 119.32, 21.48, 140.80, 4, 15, 31, '', 0),
(2, '2025-09-13 21:11:27', '2025-07-23', 'F002-15225', 11, 2, 4, 95.76, 17.24, 113.00, 4, 15, 31, '', 0),
(3, '2025-09-13 21:11:27', '2025-07-23', 'F001-01109', 12, 2, 4, 91.10, 16.40, 107.50, 4, 15, 31, '', 0),
(4, '2025-09-13 21:11:27', '2025-07-23', 'F01-12449', 13, 2, 4, 103.56, 18.64, 122.20, 4, 15, 31, 'lllk', 0),
(5, '2025-09-13 21:11:27', '2025-07-03', 'FAO1-1246', 14, 2, 4, 2478.81, 446.19, 2925.00, 4, 15, 31, '', 0),
(6, '2025-09-13 21:11:27', '2025-07-05', 'F002-3157', 15, 2, 4, 127.12, 22.88, 150.00, 4, 15, 31, '', 0);

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
(5, 'Debe', '621', 'Remuneracion-Visitantes', 'Remunerac  Visitantes'),
(6, 'Debe', '622', 'Otras remuneraciones-labores varias', 'Remuneración limpieza, atención a enfermos'),
(7, 'Debe', '623', 'Remuneracion-Pastor-Copastor', 'Remuneración al Pastor y Copastor'),
(8, 'Debe', '624', 'Capacitación', 'Gastos por Capacitación'),
(9, 'Debe', '625', 'Atención a Visitantes', 'Refrigerio a Pastores y otros'),
(10, 'Debe', '631', 'Transporte y gastos de viaje', 'Gastos por movilidad, pasajes'),
(11, 'Debe', '636', 'Servicios básicos, agua luz', 'Gastos por energía electrica…agua.'),
(12, 'Debe', '641', 'Tributos gobierno central', 'Gasto por pago tributos: RENTA PYMES….'),
(13, 'Debe', '643', 'Tributos gobierno municipalidades', 'Gastos por Impuesto predial, otros'),
(14, 'Debe', '654', 'Gastos varios', 'Utiles de aseo, Medicina hno obando'),
(15, 'Debe', '655', 'Otros gastos de gestión', 'Utiles varios, copias, chapas, etc'),
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
(31, 'Debe', '401', 'Igv', '-'),
(32, 'Haber', '750', 'Aporte directivos  para la limpieza', 'Aporte directivos  para la limpieza');

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
(9, '20482360140', 'EDITORA GRAFICA BAZAR LIBRERIA BAZAN E.I.R.L.'),
(10, '20112273922', 'SODIMAC TIENDAS DEL MEJORAMIENTO DEL HOGAR S.A.'),
(11, '10408389980', 'LACHUMA RODRIGUEZ LEANDRO \"LACER COMERCIAL\"'),
(12, '20612254550', 'COMERCIO FERRETERO MUÑOZ S.R.L.'),
(13, '20440422072', 'CONSORCIO E INVERSIONES PLASTILOPEZ S.A.C.'),
(14, '20612951862', 'CASAMIA COMODIDAD PARA TU VIDA E.I.R.L'),
(15, '10179822950', 'BAZAN CHAVARRY JULIO ANDRES'),
(16, '20609912937', 'CORPORACION ARCO IRIS IMPORT E.I.R.L.');

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
  `idiglesia` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`idregistro`, `re_fecha`, `re_importe`, `re_desc`, `us_creador`, `idcuenta`, `idresponsable_caja`, `re_mov`, `re_fechareg`, `re_fechaact`, `idiglesia`, `idcaja`) VALUES
(1, '2025-07-01', 2682.49, 'Saldo inicial', 2, 30, 1, 1, '2025-09-05 03:52:20', '2025-09-09 19:14:13', 4, 1),
(2, '2025-07-01', 16.50, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 03:53:09', '2025-09-09 19:14:13', 4, 1),
(3, '2025-07-01', 17.60, '1 BOLSA DE PAPEL HIGIENICO', 2, 15, 1, 2, '2025-09-05 03:59:52', '2025-09-09 19:14:13', 4, 1),
(4, '2025-07-01', 20.50, '1 PAPEL TOALLA NOVA', 2, 15, 1, 2, '2025-09-05 04:00:23', '2025-09-09 19:14:13', 4, 1),
(5, '2025-07-01', 14.90, '1 GALON DE POET', 2, 15, 1, 2, '2025-09-05 04:03:28', '2025-09-09 19:14:13', 4, 1),
(6, '2025-07-03', 300.00, 'PASAJES A PASTOR ALIPIO', 2, 10, 1, 2, '2025-09-05 04:06:00', '2025-09-09 19:14:13', 4, 1),
(7, '2025-07-03', 4.00, 'COPIAS DE BALANCE', 2, 15, 1, 2, '2025-09-05 04:06:29', '2025-09-09 19:14:13', 4, 1),
(8, '2025-07-04', 18.20, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:07:50', '2025-09-09 19:14:13', 4, 1),
(9, '2025-07-04', 210.00, 'LEONEL CUEVA', 2, 22, 1, 1, '2025-09-05 04:08:40', '2025-09-09 19:14:13', 4, 1),
(10, '2025-07-04', 177.00, 'JESUS CERNA', 2, 22, 1, 1, '2025-09-05 04:08:53', '2025-09-09 19:14:13', 4, 1),
(11, '2025-07-05', 50.00, 'MERCEDES CORCUERA', 2, 22, 1, 1, '2025-09-05 04:09:13', '2025-09-09 19:14:13', 4, 1),
(12, '2025-07-05', 50.00, 'CESAREA LIZARRAGA', 2, 23, 1, 1, '2025-09-05 04:09:39', '2025-09-09 19:14:13', 4, 1),
(13, '2025-07-06', 89.10, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:10:01', '2025-09-09 19:14:13', 4, 1),
(14, '2025-07-09', 67.80, 'MIGUEL VALVERDE', 2, 22, 1, 1, '2025-09-05 04:10:29', '2025-09-09 19:14:13', 4, 1),
(15, '2025-07-10', 30.00, 'TEODOLINDA GARCIA', 2, 22, 1, 1, '2025-09-05 04:10:47', '2025-09-09 19:14:13', 4, 1),
(16, '2025-07-11', 50.00, 'SANTOS TANDAIPAN', 2, 22, 1, 1, '2025-09-05 04:11:07', '2025-09-09 19:14:13', 4, 1),
(17, '2025-07-11', 33.10, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:11:20', '2025-09-09 19:14:13', 4, 1),
(18, '2025-07-15', 20.60, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:11:37', '2025-09-09 19:14:13', 4, 1),
(19, '2025-07-18', 16.70, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:11:47', '2025-09-09 19:14:13', 4, 1),
(20, '2025-07-18', 100.00, 'MARIA ARROYO', 2, 22, 1, 1, '2025-09-05 04:12:09', '2025-09-09 19:14:13', 4, 1),
(21, '2025-07-19', 50.00, 'KEVIN LOYOLA', 2, 22, 1, 1, '2025-09-05 04:12:42', '2025-09-09 19:14:13', 4, 1),
(22, '2025-07-21', 258.00, 'FAM BURGOS PAREDES', 2, 22, 1, 1, '2025-09-05 04:13:44', '2025-09-09 19:14:13', 4, 1),
(23, '2025-07-21', 100.00, 'JOSE JUAREZ', 2, 22, 1, 1, '2025-09-05 04:14:26', '2025-09-09 19:14:13', 4, 1),
(24, '2025-07-22', 15.90, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:14:43', '2025-09-09 19:14:13', 4, 1),
(25, '2025-07-24', 9.00, 'OFRENDA DE AMOR CHENIER JUAREZ', 2, 26, 1, 1, '2025-09-05 04:16:30', '2025-09-09 19:14:13', 4, 1),
(26, '2025-07-25', 17.70, 'OFRENDA RECOGIDA', 2, 24, 1, 1, '2025-09-05 04:16:44', '2025-09-09 19:14:13', 4, 1),
(27, '2025-07-27', 150.00, 'OFRENDA DE AMOR IVON SALVADOR', 2, 26, 1, 1, '2025-09-05 04:17:09', '2025-09-09 19:14:13', 4, 1),
(28, '2025-07-27', 20.00, 'NICOLASA VILLANUEVA', 2, 22, 1, 1, '2025-09-05 04:17:25', '2025-09-09 19:14:13', 4, 1),
(29, '2025-07-30', 200.00, 'RAQUEL UCEDA', 2, 22, 1, 1, '2025-09-05 04:17:40', '2025-09-09 19:14:13', 4, 1),
(30, '2025-07-31', 50.00, 'CESAREA LIZARRAGA', 2, 22, 1, 1, '2025-09-05 04:17:57', '2025-09-09 19:14:13', 4, 1),
(31, '2025-07-31', 40.00, 'MARIA ROMAN', 2, 22, 1, 1, '2025-09-05 04:18:07', '2025-09-09 19:14:13', 4, 1),
(32, '2025-07-31', 150.00, 'FAM SALVADOR BUENO', 2, 22, 1, 1, '2025-09-05 04:18:21', '2025-09-09 19:14:13', 4, 1),
(33, '2025-07-31', 160.00, 'FAM REYES ROMAN', 2, 22, 1, 1, '2025-09-05 04:18:34', '2025-09-09 19:14:13', 4, 1),
(34, '2025-07-31', 500.00, 'IVAN GOMEZ', 2, 22, 1, 1, '2025-09-05 04:19:05', '2025-09-09 19:14:13', 4, 1),
(35, '2025-07-31', 46.00, 'OFRENDA MISIONERA DEL PUEBLO', 2, 25, 1, 1, '2025-09-05 04:19:37', '2025-09-09 19:14:13', 4, 1),
(36, '2025-07-31', 205.00, 'OFRENDA DE AMOR JUAN SALVADOR', 2, 26, 1, 1, '2025-09-05 04:20:02', '2025-09-09 19:14:13', 4, 1),
(37, '2025-07-31', 400.00, 'ALBERTO ORTIZ', 2, 22, 1, 1, '2025-09-05 04:20:17', '2025-09-09 19:14:13', 4, 1),
(38, '2025-07-31', 180.00, 'JESUS CERNA', 2, 22, 1, 1, '2025-09-05 04:20:31', '2025-09-09 19:14:13', 4, 1),
(39, '2025-07-31', 100.00, 'FAM SANGAY GUEVARA', 2, 22, 1, 1, '2025-09-05 04:20:42', '2025-09-09 19:14:13', 4, 1),
(40, '2025-07-06', 55.00, 'DESAYUNO POR OLLA COMUN', 2, 9, 1, 2, '2025-09-06 21:50:43', '2025-09-09 19:14:13', 4, 1),
(41, '2025-07-06', 2.00, '2 AGUA MINERAL', 2, 9, 1, 2, '2025-09-06 21:51:11', '2025-09-09 19:14:13', 4, 1),
(42, '2025-07-09', 10.00, 'PASAJES A PASTOR ALIPIO A CASA GRANDE', 2, 10, 1, 2, '2025-09-06 21:51:56', '2025-09-09 19:14:13', 4, 1),
(43, '2025-07-13', 20.00, 'PASAJES A PASTOR ALIPIO A ASCOPE', 2, 10, 1, 2, '2025-09-06 21:52:29', '2025-09-09 19:14:13', 4, 1),
(44, '2025-07-14', 162.70, 'PAGO DE LUZ MAS PASAJES', 2, 11, 1, 2, '2025-09-06 21:52:57', '2025-09-09 19:14:13', 4, 1),
(45, '2025-07-17', 4.00, 'IMPRESIÓN DE PLAN DE TRABAJO DE IGLESIA', 2, 15, 1, 2, '2025-09-06 21:53:42', '2025-09-09 19:14:13', 4, 1),
(46, '2025-07-20', 11.00, 'AGUA MINERAL 20 LT MAS MOTO', 2, 15, 1, 2, '2025-09-06 21:55:42', '2025-09-09 19:14:13', 4, 1),
(47, '2025-07-20', 94.60, 'CALDO MAS PAN POR AYUNO', 2, 9, 1, 2, '2025-09-06 21:56:47', '2025-09-09 19:14:13', 4, 1),
(48, '2025-07-21', 41.00, 'PAGO POR TRIBUTO A SUNAT MES DE JUNIO', 2, 12, 1, 2, '2025-09-06 21:57:39', '2025-09-09 19:14:13', 4, 1),
(49, '2025-07-23', 20.00, 'PASAJE A PASTOR A LA ESPERANZA POR ANIVERSARIO', 2, 10, 1, 2, '2025-09-06 21:59:23', '2025-09-09 19:14:13', 4, 1),
(50, '2025-07-23', 12.00, '1 BOLSA DE PINTURA PATO 5KG', 2, 15, 1, 2, '2025-09-06 21:59:55', '2025-09-09 19:14:13', 4, 1),
(51, '2025-07-23', 5.50, '2 LIJAS', 2, 15, 1, 2, '2025-09-06 22:00:47', '2025-09-09 19:14:13', 4, 1),
(52, '2025-07-23', 90.00, '1 BALDE PINTURA 20 LT LATEX', 2, 15, 1, 2, '2025-09-06 22:01:08', '2025-09-09 19:14:13', 4, 1),
(53, '2025-07-23', 11.90, '1 TOMACORRIENTE', 2, 15, 1, 2, '2025-09-06 22:02:15', '2025-09-09 19:14:13', 4, 1),
(54, '2025-07-23', 34.90, '1 GRIFO DE LAVACARA PARA BAÑO', 2, 15, 1, 2, '2025-09-06 22:02:47', '2025-09-09 19:14:13', 4, 1),
(55, '2025-07-23', 56.90, '1 JUEGO DE ACCESORIOS DE TANQUE DE AGUA', 2, 15, 1, 2, '2025-09-06 22:03:13', '2025-09-09 19:14:13', 4, 1),
(56, '2025-07-23', 36.90, '1 TAPA DE INODORO', 2, 15, 1, 2, '2025-09-06 22:03:30', '2025-09-09 19:14:13', 4, 1),
(57, '2025-07-23', 20.40, 'PAPEL TOALLA NOVA', 2, 14, 1, 2, '2025-09-06 22:04:02', '2025-09-09 19:14:13', 4, 1),
(58, '2025-07-23', 10.60, '1 GALON DE LEJIA CLOROX', 2, 15, 1, 2, '2025-09-06 22:04:37', '2025-09-09 19:14:13', 4, 1),
(59, '2025-07-23', 11.89, '1 LT DE CERA DE MADERA', 2, 15, 1, 2, '2025-09-06 22:04:52', '2025-09-09 19:14:13', 4, 1),
(60, '2025-07-23', 18.00, '1 BOLSA DE PAPEL RENDIPEL', 2, 15, 1, 2, '2025-09-06 22:05:14', '2025-09-09 19:14:13', 4, 1),
(61, '2025-07-23', 20.00, 'PASAJES POR COMPRA', 2, 10, 1, 2, '2025-09-06 22:05:40', '2025-09-09 19:14:13', 4, 1),
(62, '2025-07-23', 15.00, '3 KG DE DETERGENTE', 2, 15, 1, 2, '2025-09-06 22:06:00', '2025-09-09 19:14:13', 4, 1),
(63, '2025-07-23', 95.00, '500 PLATOS DE TECNOPORT N 22', 2, 15, 1, 2, '2025-09-06 22:06:39', '2025-09-09 19:14:13', 4, 1),
(64, '2025-07-23', 26.50, '500 TENEDOR N 10', 2, 15, 1, 2, '2025-09-06 22:06:51', '2025-09-09 19:14:13', 4, 1),
(65, '2025-07-23', 46.00, '1 MILLAR DE VASOS N 9', 2, 15, 1, 2, '2025-09-06 22:07:03', '2025-09-09 19:14:13', 4, 1),
(66, '2025-07-23', 19.00, '200 BANDEJAS', 2, 15, 1, 2, '2025-09-06 22:07:19', '2025-09-09 19:14:13', 4, 1),
(67, '2025-07-23', 25.50, '75 BANDEJAS CON TAPA', 2, 15, 1, 2, '2025-09-06 22:07:31', '2025-09-09 19:14:13', 4, 1),
(68, '2025-07-23', 4.20, '2 PQT DE BOLSAS', 2, 15, 1, 2, '2025-09-06 22:07:45', '2025-09-09 19:14:13', 4, 1),
(69, '2025-07-24', 50.00, 'COMPRA DE FLORES', 2, 16, 1, 2, '2025-09-06 22:08:17', '2025-09-09 19:14:13', 4, 1),
(70, '2025-07-28', 50.00, 'PASAJE A PASTOR Y DIACONOS FIESTA GRANDE', 2, 10, 1, 2, '2025-09-06 22:08:41', '2025-09-09 19:14:13', 4, 1),
(71, '2025-07-29', 40.00, 'PASAJE A PASTOR Y DIACONOS FIESTA GRANDE', 2, 10, 1, 2, '2025-09-06 22:08:58', '2025-09-09 19:14:13', 4, 1),
(72, '2025-07-31', 1025.00, 'SUELDO PASTORAL', 2, 7, 1, 2, '2025-09-06 22:09:35', '2025-09-09 19:14:13', 4, 1),
(73, '2025-07-31', 500.00, 'OFRENDA DE AMOR A COPASTOR', 2, 7, 1, 2, '2025-09-06 22:11:46', '2025-09-09 19:14:13', 4, 1),
(74, '2025-07-31', 250.00, 'OFRENDA DE AMOR A HNO POR LIMPIEZA', 2, 6, 1, 2, '2025-09-06 22:12:05', '2025-09-09 19:14:13', 4, 1),
(75, '2025-07-31', 180.00, 'OFRENDA DE AMOR POR ATENCION A HNO OBANDO', 2, 6, 1, 2, '2025-09-06 22:12:19', '2025-09-09 19:14:13', 4, 1),
(76, '2025-07-31', 120.00, 'OFRENDA MISIONERA', 2, 6, 1, 2, '2025-09-06 22:12:50', '2025-09-09 19:14:13', 4, 1),
(77, '2025-07-31', 50.00, 'OFRENDA DE AMOR A PASTOR ALBERTO', 2, 6, 1, 2, '2025-09-06 22:13:07', '2025-09-09 19:14:13', 4, 1),
(78, '2025-07-31', 16.00, 'PAGO DE AGUA', 2, 11, 1, 2, '2025-09-06 22:14:35', '2025-09-09 19:14:13', 4, 1),
(79, '2025-07-31', 10.00, 'CUOTA DE MEDICINA HNO OBANDO', 2, 6, 1, 2, '2025-09-06 22:14:56', '2025-09-09 19:14:13', 4, 1),
(80, '2025-07-31', 294.28, 'DIEZMO DE LOS DIEZMOS', 2, 6, 1, 2, '2025-09-06 22:16:05', '2025-09-09 19:14:13', 4, 1),
(81, '2025-07-03', 21.40, 'ofrenda recogida', 2, 24, 6, 1, '2025-09-10 01:06:52', '2025-09-10 01:06:52', 4, 4),
(82, '2025-07-10', 20.40, 'ofrenda recogida', 2, 24, 6, 1, '2025-09-10 01:07:17', '2025-09-10 01:07:17', 4, 4),
(83, '2025-07-17', 12.60, 'ofrenda recogida', 2, 24, 6, 1, '2025-09-10 01:07:37', '2025-09-10 01:07:37', 4, 4),
(84, '2025-07-23', 205.00, 'préstamo x acción social', 2, 20, 6, 1, '2025-09-10 01:11:00', '2025-09-10 01:11:00', 4, 4),
(85, '2025-07-24', 21.60, 'ofrenda recogida', 2, 24, 6, 1, '2025-09-10 01:12:16', '2025-09-10 01:12:16', 4, 4),
(86, '2025-07-30', 195.00, 'apoyo social', 2, 20, 6, 1, '2025-09-10 01:13:25', '2025-09-10 01:13:25', 4, 4),
(87, '2025-07-31', 22.00, 'ofrenda recogida', 2, 24, 6, 1, '2025-09-10 01:14:10', '2025-09-10 01:14:10', 4, 4),
(89, '2025-07-31', 60.00, 'Aporte directivos para la limpieza', 2, 32, 6, 1, '2025-09-10 02:14:57', '2025-09-10 02:14:57', 4, 4),
(90, '2025-07-31', 1050.00, 'Apoyo social', 2, 20, 6, 1, '2025-09-10 02:16:52', '2025-09-10 02:16:52', 4, 4),
(91, '2025-07-01', 471.40, 'Saldo inicial', 2, 30, 6, 1, '2025-09-10 02:19:45', '2025-09-10 02:19:45', 4, 4),
(92, '2025-07-10', 50.00, 'compra de flores', 2, 16, 6, 2, '2025-09-10 02:25:24', '2025-09-10 02:25:24', 4, 4),
(93, '2025-07-23', 10.00, 'Medicina para hno. Obando', 2, 14, 6, 2, '2025-09-10 02:51:10', '2025-09-10 02:51:10', 4, 4),
(94, '2025-07-31', 100.00, 'Gastos por limpieza del templo', 2, 6, 6, 2, '2025-09-10 02:52:59', '2025-09-10 02:52:59', 4, 4),
(95, '2025-07-13', 2.50, 'OFRENDA DE NIÑOS', 2, 24, 8, 1, '2025-09-10 03:48:37', '2025-09-10 03:48:37', 4, 6),
(96, '2025-07-13', 8.00, 'OFRENDA RECOGIDA', 2, 24, 8, 1, '2025-09-10 03:49:31', '2025-09-10 03:49:31', 4, 6),
(97, '2025-07-20', 25.20, 'OFRENDA RECOGIDA', 2, 24, 8, 1, '2025-09-10 03:50:27', '2025-09-10 03:50:27', 4, 6),
(98, '2025-07-27', 2.00, 'OFRENDA NIÑOS', 2, 24, 8, 1, '2025-09-10 03:51:05', '2025-09-10 03:51:05', 4, 6),
(99, '2025-07-27', 22.80, 'OFRENDA RECOGIDA', 2, 24, 8, 1, '2025-09-10 03:51:40', '2025-09-10 03:51:40', 4, 6),
(100, '2025-07-31', 28.00, 'OFRENDA RECOGIDA', 2, 32, 8, 1, '2025-09-10 03:53:27', '2025-09-10 03:53:27', 4, 6),
(101, '2025-07-31', 22.00, 'OFRENDA RECOGIDA', 2, 20, 8, 1, '2025-09-10 03:55:13', '2025-09-10 03:55:13', 4, 6),
(102, '2025-07-31', 10.00, 'MEDICINA PARA HNO OBANDO', 2, 15, 8, 2, '2025-09-10 03:59:40', '2025-09-10 03:59:40', 4, 6),
(103, '2025-07-01', 395.00, 'SALDO INICIAL', 2, 30, 8, 1, '2025-09-10 04:01:58', '2025-09-10 04:01:58', 4, 6),
(104, '2025-07-31', 80.00, 'GASTOS POR LIMPIEZA TEMPLO', 2, 6, 8, 2, '2025-09-10 04:08:42', '2025-09-10 04:08:42', 4, 6),
(105, '2025-07-05', 20.10, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-12 19:24:34', '2025-09-12 19:24:34', 4, 5),
(106, '2025-07-12', 14.00, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-12 19:25:12', '2025-09-12 19:25:12', 4, 5),
(107, '2025-07-19', 27.30, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-12 19:25:37', '2025-09-12 19:25:37', 4, 5),
(108, '2025-07-26', 15.50, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-12 19:25:52', '2025-09-12 21:48:24', 4, 5),
(109, '2025-07-27', 25.00, 'OFRENDA DE AMOR', 2, 26, 7, 1, '2025-09-12 19:27:22', '2025-09-12 19:27:22', 4, 5),
(110, '2025-07-10', 50.00, 'Compra de flores', 2, 16, 7, 2, '2025-09-12 21:29:46', '2025-09-12 21:41:33', 4, 5),
(111, '2025-07-10', 80.00, 'Compra de flores', 2, 6, 7, 2, '2025-09-12 21:30:49', '2025-09-12 21:40:20', 4, 5),
(112, '2025-07-11', 10.00, 'Medicina hno. obando', 2, 14, 7, 2, '2025-09-12 21:35:48', '2025-09-12 21:35:48', 4, 5),
(113, '2025-07-01', 250.10, 'saldo anterior', 2, 30, 7, 1, '2025-09-12 21:44:49', '2025-09-12 21:44:49', 4, 5),
(114, '2025-07-01', 3902.20, 'Saldo anterior', 2, 30, 4, 1, '2025-09-12 21:56:59', '2025-09-12 21:56:59', 4, 2),
(115, '2025-07-07', 20.40, 'Ofrenda recogida', 2, 24, 4, 1, '2025-09-12 21:58:20', '2025-09-12 21:58:20', 4, 2),
(116, '2025-07-14', 12.40, 'Ofrenda recogida', 2, 24, 4, 1, '2025-09-12 21:58:53', '2025-09-12 21:58:53', 4, 2),
(117, '2025-07-21', 32.40, 'Ofrenda recogida', 2, 24, 4, 1, '2025-09-12 21:59:11', '2025-09-12 21:59:11', 4, 2),
(118, '2025-07-27', 380.00, 'acción social', 2, 20, 4, 1, '2025-09-12 22:01:40', '2025-09-12 22:01:40', 4, 2),
(119, '2025-07-27', 300.00, 'Hno Gilmer Ramírez', 2, 24, 4, 1, '2025-09-12 22:02:51', '2025-09-12 22:02:51', 4, 2),
(120, '2025-07-30', 477.80, 'Por acción Social', 2, 2, 4, 2, '2025-09-12 22:04:00', '2025-09-12 22:04:00', 4, 2),
(121, '2025-08-02', 185.00, 'DEOLUCION POR ACCION SOCIAL', 2, 20, 4, 1, '2025-09-12 22:11:58', '2025-09-13 16:59:32', 4, 2),
(122, '2025-08-02', 20.00, 'DEVOLUCION POR ACCION SOCIAL', 2, 20, 4, 1, '2025-09-12 22:12:18', '2025-09-13 16:58:59', 4, 2),
(123, '2025-08-02', 26.70, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-13 00:55:53', '2025-09-13 00:55:53', 4, 5),
(124, '2025-08-09', 22.50, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-13 00:56:16', '2025-09-13 00:56:16', 4, 5),
(125, '2025-08-23', 19.40, 'OFRENDA RECOGIDA', 2, 24, 7, 1, '2025-09-13 00:56:38', '2025-09-13 00:56:38', 4, 5),
(126, '2025-08-30', 536.00, 'DEVOLUCION POR ACCION SOCIAL', 2, 20, 7, 1, '2025-09-13 00:57:21', '2025-09-13 16:15:25', 4, 5),
(130, '2025-08-02', 10.00, 'MEDICINA HNO OBANDO', 2, 14, 7, 2, '2025-09-13 16:20:11', '2025-09-13 16:20:11', 4, 5),
(131, '2025-08-04', 80.00, 'GASTOS POR LIMPIEZA TEMPLO', 2, 6, 7, 2, '2025-09-13 16:22:42', '2025-09-13 16:22:42', 4, 5),
(132, '2025-08-08', 224.50, 'COMPRA DE REGALO PARA IGLESIA', 2, 15, 7, 2, '2025-09-13 16:24:52', '2025-09-13 16:24:52', 4, 5),
(133, '2025-08-08', 20.00, 'MOVILIDAD Y GASTOS DE VIAJE', 2, 10, 7, 2, '2025-09-13 16:26:43', '2025-09-13 16:26:43', 4, 5),
(134, '2025-08-12', 50.00, 'COMPRA DE FLORES PARA EL ALTAR', 2, 16, 7, 2, '2025-09-13 16:27:24', '2025-09-13 16:27:24', 4, 5),
(135, '2025-08-13', 184.80, 'PRESTAMO PARA ACCION SOCIAL', 2, 2, 7, 2, '2025-09-13 16:29:19', '2025-09-13 16:29:19', 4, 5),
(136, '2025-08-13', 15.00, 'POR GAS', 2, 15, 7, 2, '2025-09-13 16:30:47', '2025-09-13 16:30:47', 4, 5),
(137, '2025-08-29', 10.00, 'COMPRA MEDICINA PARA HNO. OBANDO', 2, 14, 7, 2, '2025-09-13 16:31:59', '2025-09-13 16:31:59', 4, 5),
(138, '2025-08-04', 14.30, 'OFRENDA RECOGIDA', 2, 24, 4, 1, '2025-09-13 17:06:27', '2025-09-13 17:06:27', 4, 2),
(139, '2025-08-08', 1000.00, 'PRESTAMO DE UN HERMANO', 2, 20, 4, 1, '2025-09-13 17:11:12', '2025-09-13 17:11:12', 4, 2),
(141, '2025-08-08', 300.00, 'OFRENDA DE AMOR', 2, 26, 4, 1, '2025-09-13 17:17:09', '2025-09-13 17:17:09', 4, 2),
(142, '2025-08-08', 225.00, 'OFRENDA DE AMOR', 2, 26, 4, 1, '2025-09-13 17:19:03', '2025-09-13 17:19:03', 4, 2),
(143, '2025-08-11', 24.50, 'OFRENDA DEL PUEBLO', 2, 24, 4, 1, '2025-09-13 17:20:17', '2025-09-13 17:20:17', 4, 2),
(144, '2025-08-18', 112.80, 'OFRENDA DEL PUEBLO', 2, 24, 4, 1, '2025-09-13 17:21:12', '2025-09-13 17:21:12', 4, 2),
(145, '2025-08-25', 29.40, 'OFRENDA DEL PUEBLO', 2, 24, 4, 1, '2025-09-13 17:24:28', '2025-09-13 17:24:28', 4, 2),
(146, '2025-08-02', 68.70, 'POR ACCION SOCIAL', 2, 2, 4, 2, '2025-09-13 17:28:43', '2025-09-13 17:28:43', 4, 2),
(147, '2025-08-14', 50.00, 'COMPRA GIGANTOGRAFIAS-DPTO MUSICA', 2, 15, 4, 2, '2025-09-13 17:30:06', '2025-09-13 17:30:06', 4, 2),
(148, '2025-08-17', 30.00, 'COMPRA DE PILAS', 2, 15, 4, 2, '2025-09-13 17:31:24', '2025-09-13 17:31:24', 4, 2);

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
(1, 'aortizc', 1, 1, '$2a$12$YmtIBS/VsxVywSQHV4A2.u2ogIWWtGbIxE7CMtOw7tfgaS6SLYSie', 'Alberto Ortiz Cruz', NULL, '2025-08-20 21:13:48', '2025-09-08 16:21:18'),
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
  ADD KEY `idx_iglesia_fecha` (`idiglesia`,`re_fecha`),
  ADD KEY `idx_idcaja` (`idcaja`);

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
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `iglesia`
--
ALTER TABLE `iglesia`
  MODIFY `idiglesia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idregistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

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
