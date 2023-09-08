<?php
require_once("funciones.php");

if(isset($_POST['estado'])){
	
	$municipios = dameMunicipio($_POST['estado']);
	
	$html = "<option value=''>- Seleccione un Municipio -</option>";
	foreach($municipios as $indice => $registro){
		$html .= "<option value='".$registro['id_r']."'>".$registro['rollo_r']."</option>";
	}
	
	$respuesta = array("html"=>$html);
	echo json_encode($respuesta);
}

if(isset($_POST['municipio'])){
	
	$localidades= dameLocalidad($_POST['municipio']);
 	
	$html = "";
	//$html = "<input type='text' value=''>";
 	//$html = "<input type='text' list='misdatos' value=''>";
	foreach($localidades as $indice => $registro){
 	$html .= "<option value='".$registro['id_r']."'>".$registro['kilos_r']."</option>";
	//$html = "<input type='text' value='".$registro['kilos_r']."'>";
    //$html .= "<datalist id='misdatos'><option  label='".$registro['kilos_r']."' value='".$registro['kilos_r']."'></datalist>";	
 		
	}
	
	$respuesta = array("html"=>$html);
	echo json_encode($respuesta);
 }

?>