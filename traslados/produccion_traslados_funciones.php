<?php
/*$hostname_conexion1 = "localhost";
$database_conexion1 = "acycia_intranet";
$username_conexion1 = "acycia_root";
$password_conexion1 = "ac2006";
$conexion1 = mysql_pconnect($hostname_conexion1, $username_conexion1, $password_conexion1) or trigger_error(mysql_error(),E_USER_ERROR); 
*/

function conectaBaseDatos(){
	try{
		$hostname_conexion1 = "localhost";
		//$puerto = "3306";
		$database_conexion1 = "acycia_intranet";
		$username_conexion1 = "acycia_root";
		$password_conexion1 = "ac2006";
	
		$conexion1 = new PDO("mysql:host=$hostname_conexion1;dbname=$database_conexion1",
							$username_conexion1,
							$password_conexion1,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		
		$conexion1->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $conexion1;
	}
	catch (PDOException $e){
		die ("No se puede conectar a la base de datos". $e->getMessage());
	}
}

function dameEstado(){
	$resultado = false;
	$consulta = "SELECT id_op FROM Tbl_orden_produccion ORDER BY id_op DESC";
	
	$conexion1 = conectaBaseDatos();
	$sentencia = $conexion1->prepare($consulta);
	
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
	
	$conexion1 = conectaBaseDatos();
	$sentencia = $conexion1->prepare($consulta);
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
	
	$conexion1 = conectaBaseDatos();
	$sentencia = $conexion1->prepare($consulta);
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