<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion1 = DB_HOST;
$database_conexion1 = DB_DATABASE;
$username_conexion1 = DB_USER;
$password_conexion1 = DB_PASS;
$conexion1 = mysql_pconnect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); 
/* $hostname_conexion1 = "localhost";
$database_conexion1 = "acycia_intranet_dev";
$username_conexion1 = "acycia_dev";
$password_conexion1 = "acycia_dev";
$conexion1 = mysql_pconnect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); */ 

?>