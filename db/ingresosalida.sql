-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2022 a las 11:07:37
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `acycia_intranet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ingresosalida`
--

CREATE TABLE `tbl_ingresosalida` (
  `id` int(15) NOT NULL,
  `autorizacion` bigint(30) DEFAULT NULL,
  `anyo` varchar(10) DEFAULT NULL,
  `kilospermitidosmes` decimal(7,1) DEFAULT NULL,
  `kilosdisponiblescompra` decimal(7,1) DEFAULT NULL,
  `totalingresados` decimal(7,3) DEFAULT NULL,
  `totalsalida` decimal(7,3) DEFAULT NULL,
  `totalinventario` decimal(7,3) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_vence` date DEFAULT NULL,
  `userfile` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_ingresosalida`
--
ALTER TABLE `tbl_ingresosalida`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_ingresosalida`
--
ALTER TABLE `tbl_ingresosalida`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;








-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2022 a las 11:07:54
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `acycia_intranet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ingresosalida_items`
--

CREATE TABLE `tbl_ingresosalida_items` (
  `id_i` int(15) NOT NULL,
  `nombre` varchar(300) DEFAULT NULL,
  `ingresokilos` decimal(7,3) DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `proveedor` varchar(300) DEFAULT NULL,
  `costound` decimal(12,1) DEFAULT NULL,
  `factura` varchar(20) DEFAULT NULL,
  `area` varchar(12) DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `salidakilos` decimal(7,3) DEFAULT NULL,
  `numeradora` varchar(20) DEFAULT NULL,
  `autorizacion` bigint(30) DEFAULT NULL,
  `ccit_autorizacion` varchar(15) DEFAULT NULL,
  `op` varchar(30) DEFAULT NULL,
  `controladas` varchar(2) DEFAULT NULL,
  `responsable` varchar(30) DEFAULT NULL,
  `revisado` varchar(30) DEFAULT NULL,
  `aprobado` varchar(30) DEFAULT NULL,
  `modificado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_ingresosalida_items`
--
ALTER TABLE `tbl_ingresosalida_items`
  ADD PRIMARY KEY (`id_i`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_ingresosalida_items`
--
ALTER TABLE `tbl_ingresosalida_items`
  MODIFY `id_i` int(15) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

