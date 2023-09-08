<?php

/* Archivo para funciones */
/*$hostname_conexion1 = "localhost";
$database_conexion1 = "acycia_intranet";
$username_conexion1 = "acycia_root";
$password_conexion1 = "ac2006";*/
function conectaBaseDatos(){
	try{
		$servidor = "localhost";
		$puerto = "3306";
		$basedatos = "acycia_intranet";
		$usuario = "acycia_root";
		$contrasena = "ac2006";
	
		$conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$basedatos",
							$usuario,
							$contrasena,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		
		$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $conexion;
	}
	catch (PDOException $e){
		die ("No se puede conectar a la base de datos". $e->getMessage());
	}
}

function dameEstado(){
	$resultado = false;
	$consulta = "SELECT id_op FROM Tbl_orden_produccion ORDER BY id_op DESC";
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}

function dameMunicipio($estado = ''){
	$resultado = false;
	$consulta = "SELECT * FROM TblExtruderRollo";
	
	if($estado != ''){
		$consulta .= " WHERE id_op_r = :estado";
	}
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bindParam('estado',$estado);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}

function dameLocalidad($municipio = ''){
	$resultado = false;
	$consulta = "SELECT id_r,kilos_r FROM TblExtruderRollo";
	
	if($municipio != ''){
		$consulta .= " WHERE id_r = :municipio";
	}
	
	$conexion = conectaBaseDatos();
	$sentencia = $conexion->prepare($consulta);
	$sentencia->bindParam('municipio',$municipio);
	
	try {
		if(!$sentencia->execute()){
			print_r($sentencia->errorInfo());
		}
		$resultado = $sentencia->fetchAll();
		//$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$sentencia->closeCursor();
	}
	catch(PDOException $e){
		echo "Error al ejecutar la sentencia: \n";
			print_r($e->getMessage());
	}
	
	return $resultado;
}


?>