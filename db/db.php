<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');//se debe dejar para traer variables globales
 
class Conectar{
    public static function conexion(){
    	if($_SESSION['ambiente']=='acycia')
    	$conexion=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
    else
        $conexion=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

        $conexion->query("SET NAMES 'utf8'");
        return $conexion;
    }
}
 
?>
 