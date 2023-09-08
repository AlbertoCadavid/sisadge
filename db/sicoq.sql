-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2022 a las 16:31:47
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

 

CREATE TABLE `tbl_sicoq` (
  `id` int(15) NOT NULL,
  `autorizacion` int(15) DEFAULT NULL,
  `anyo` varchar(10) DEFAULT NULL,
  `kilospermitidosmes` decimal(3,1) DEFAULT NULL,
  `kilosdisponiblescompra` decimal(3,1) DEFAULT NULL,
  `totalingresados` decimal(3,1) DEFAULT NULL,
  `totalsalida` decimal(3,1) DEFAULT NULL,
  `totalinventario` decimal(3,1) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_vence` date DEFAULT NULL,
  `userfile` VARCHAR(100) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
ALTER TABLE `tbl_sicoq`
  ADD PRIMARY KEY (`id`);
 
ALTER TABLE `tbl_sicoq`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

  CREATE TABLE `tbl_sicoq_items` (
  `id_i` int(15) NOT NULL,
  `nombre` varchar(300) DEFAULT NULL,
  `ingresokilos` decimal(3,1) DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `proveedor` varchar(300) DEFAULT NULL,
  `costound` decimal(12,1) DEFAULT NULL, 
  `factura` varchar(20) DEFAULT NULL,
  `area` varchar(12) DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `salidakilos` decimal(3,1) DEFAULT NULL,
  `numeradora` varchar(20) DEFAULT NULL,
  `autorizacion` int(15) DEFAULT NULL,
  `responsable` varchar(30) DEFAULT NULL,
  `revisado` varchar(30) DEFAULT NULL,
  `aprobado` varchar(30) DEFAULT NULL,
  `modificado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
ALTER TABLE `tbl_sicoq_items`
  ADD PRIMARY KEY (`id_i`);
 
ALTER TABLE `tbl_sicoq_items`
  MODIFY `id_i` int(15) NOT NULL AUTO_INCREMENT;
 