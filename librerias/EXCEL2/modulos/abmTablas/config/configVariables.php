<?php
$config = Config::singleton();
#############################################################################
# Configuro datos del Modulo												#
#############################################################################
$config->set('ACCESO_LIBRE', true);
define('ABM_DEBUG'      , false);
#############################################################################
# Configuro Base de Datos													#
#############################################################################
$config->set('dbhost', (isset($_SESSION['OP_SERVIDOR']))? $_SESSION['OP_SERVIDOR'] : null);
$config->set('dbuser', (isset($_SESSION['OP_USUARIO']))? $_SESSION['OP_USUARIO'] : null);
$config->set('dbpass', (isset($_SESSION['OP_CLAVE']))? $_SESSION['OP_CLAVE'] : null);
$config->set('dbconn', (isset($_SESSION['OP_CONECT']))? $_SESSION['OP_CONECT'] : null);
$config->set('dbname', '');
$config->set('dbport', 3306);
$config->set('cantidadDeEnlacesPorPagina'	, 10);
$config->set('cantidadDeRegistrosPorPagina'	, 20);