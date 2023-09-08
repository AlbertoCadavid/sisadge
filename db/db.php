<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');//se debe dejar para traer variables globales
 
class Conectar{
    public static function conexion(){
    	if($_SESSION['ambiente']=='acycia')
    	$conexion=new mysqli("localhost", "acycia_root", "ac2006", "acycia_intranet");
    else
        $conexion=new mysqli("localhost", "acycia_dev", "acycia_dev", "acycia_intranet_dev");

        $conexion->query("SET NAMES 'utf8'");
        return $conexion;
    }
}
 
?>
 