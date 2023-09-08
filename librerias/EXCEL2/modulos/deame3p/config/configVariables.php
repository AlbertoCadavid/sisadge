<?php
$config = Config::singleton();
#############################################################################
# Configuro datos del Modulo												#
#############################################################################
$config->set('ACCESO_LIBRE', true);
#############################################################################
# Configuro Base de Datos													#
#############################################################################

$servidor       = (isset($_SESSION['OP_SERVIDOR']))?    $_SESSION['OP_SERVIDOR']    : 'localhost';
$usuario        = (isset($_SESSION['OP_USUARIO']))?     $_SESSION['OP_USUARIO']     : 'root';
$clave          = (isset($_SESSION['OP_CLAVE']))?       $_SESSION['OP_CLAVE']       : '';
$conexion       = (isset($_SESSION['OP_CONECT']))?      $_SESSION['OP_CONECT']      : false;
$puerto         = (isset($_SESSION['OP_PUERTO']))?      $_SESSION['OP_PUERTO']      : 3306;

$config->set('dbhost', $servidor);
$config->set('dbuser', $usuario);
$config->set('dbpass', $clave);
$config->set('dbconn', $conexion);
$config->set('dbname', '');
$config->set('dbport', $puerto);