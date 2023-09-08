<?php
session_start();
define('DIR_SITIO' 		, dirname(__FILE__) . '/');
include 'opet/config/config.ini';
include (DIR_OPET . DIR_CONTR . 'FrenteControl.php');
$erroresAMostrar	= isset($_SESSION['mostrarErrores']) ? $_SESSION['mostrarErrores'] : 0;
error_reporting($erroresAMostrar);
date_default_timezone_set(TIME_ZONE);
$objFC              = new FrenteControl();
$objFC->main();