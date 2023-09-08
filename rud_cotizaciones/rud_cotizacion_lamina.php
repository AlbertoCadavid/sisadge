<?php require_once('Connections/conexion1.php'); ?>
<?php
mysql_select_db($database_conexion1, $conexion1);                                                            
/*----------------------------------------*/
/*--------------ACCIONES------------------*/
/*----------------------------------------*/
/*------------COTIZACIONES---------------*/
/*------------VARIABLE DE CONDICION SWITCH RUD---------------*/
$rud=$_POST['valor'];  
/*FUNCION PARA LIMPIAR VARIABLES PARA ESCAPAR DE ALGUNOS DATOS PARA PASARLO A MYSQL*/
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


//$N_cotizacion=consultoIdcotiz($_POST['N_cotizacion']);
 $N_cotizacion=$_POST['N_cotizacion'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
// area de switch()
switch($rud) {
case '1':
$ref=$_POST['N_referencia']; 
$nitc=$_POST['Str_nit'];
$sqlestado="SELECT N_cotizacion,N_referencia_c,Str_nit,fecha_creacion,B_estado FROM Tbl_cotiza_laminas WHERE N_referencia_c='$ref' and Str_nit='$nitc' ORDER BY fecha_creacion DESC LIMIT 1";
$resultestado= mysql_query($sqlestado);
$numestado= mysql_num_rows($resultestado);
if($numestado >='1')
{
$cotiz=mysql_result($resultestado,0,'N_cotizacion');	
$sqlobsoleta="UPDATE Tbl_cotiza_laminas SET B_estado='3' WHERE N_cotizacion='$cotiz' and N_referencia_c='$ref' and Str_nit='$nitc'";
$resultobsoleta=mysql_query($sqlobsoleta);  
} 
$insertSQL = sprintf("INSERT INTO Tbl_cotiza_laminas (N_cotizacion, N_referencia_c, Str_nit, N_ancho, N_repeticion, N_calibre,Str_tipo_coextrusion,Str_capa_ext_coext,Str_capa_inter_coext,N_embobinado, Str_plazo,N_cantidad_metros_r, Str_incoterms, B_impresion, N_colores_impresion, B_cyreles, N_cantidad, N_peso_max, N_diametro_max, Str_moneda, N_precio_k, Str_unidad_vta, fecha_creacion, Str_usuario, N_comision, B_estado,B_generica) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s)",
                     GetSQLValueString($N_cotizacion, "int"),
                     GetSQLValueString($_POST['N_referencia'], "int"),                     
                     GetSQLValueString($_POST['Str_nit'], "text"),
                     GetSQLValueString($_POST['N_ancho_l'], "double"),
                     GetSQLValueString($_POST['N_repeticion_l'], "double"),
                     GetSQLValueString($_POST['N_calibre_l'], "double"),
                     GetSQLValueString($_POST['Str_tipo_coextrusion'], "text"),
                     GetSQLValueString($_POST['Str_capa_ext_coext'], "text"),
                     GetSQLValueString($_POST['Str_capa_inter_coext'], "text"),
                     GetSQLValueString($_POST['N_embobinado'], "text"),
                     GetSQLValueString($_POST['Str_plazo'], "text"),
                     GetSQLValueString($_POST['N_cantidad_metros_r_l'], "int"),
                     GetSQLValueString($_POST['Str_incoterms_l'], "text"),
                     GetSQLValueString($_POST['B_impresion'], "int"),
                     GetSQLValueString($_POST['N_colores_impresion'], "int"),
                     GetSQLValueString($_POST['B_cyreles'], "int"),
                     GetSQLValueString($_POST['N_cantidad_l'], "text"),                                           
                     GetSQLValueString($_POST['N_peso_max'], "int"),
                     GetSQLValueString($_POST['N_diametro_max_l'], "int"), 
                     GetSQLValueString($_POST['Str_moneda_l'], "text"),
                     GetSQLValueString($_POST['N_precio_k'], "text"),
                     GetSQLValueString($_POST['Str_unidad_vta'], "text"),
                     GetSQLValueString($_POST['fecha_l'], "date"),
                     GetSQLValueString($_POST['vendedor'], "text"),
                     GetSQLValueString($_POST['N_comision'], "double"),
                     GetSQLValueString($_POST['B_estado'], "text"),
                     GetSQLValueString($_POST['B_generica'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SEGUNDA TABLA QUE CONTIENE LOS TEXTOS*/
$insertSQL2 = sprintf("INSERT INTO Tbl_cotiza_lamina_obs ( N_cotizacion,N_referencia_c,Str_nit, texto) VALUES (%s, %s, %s, %s)",
GetSQLValueString($N_cotizacion, "int"),
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_l'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($insertSQL2, $conexion1) or die(mysql_error());
//CONSULTA PARA VER SI EXISTE LA COTIZACION EN MAESTRO
   $n_cot=$N_cotizacion;
   $nit=$_POST['Str_nit'];  
  if($n_cot!=''&& $nit!='')
  {	  
  $sqlver="SELECT * FROM Tbl_cotizaciones WHERE N_cotizacion ='$n_cot' and Str_nit='$nit'";
  $resultver= mysql_query($sqlver);
  $numver= mysql_num_rows($resultver);
  if($numver =='0')
  {
/*INSERT EN LA BD Tbl_cliente_referencia*/ 
$insertSQL3 = sprintf("INSERT INTO Tbl_cotizaciones(N_cotizacion,Str_nit,Str_tipo, fecha) VALUES (%s, %s, %s, %s)",
GetSQLValueString($N_cotizacion, "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['Str_tipo'], "text"),
GetSQLValueString($_POST['fecha_l'], "date"));
mysql_select_db($database_conexion1, $conexion1);
$Result3 = mysql_query($insertSQL3, $conexion1) or die(mysql_error()); 
  }
  }
    //VALIDO QUE YA ESTE ASOCIADO EL CLIENTE A ESTA REFERENCIA
   $cotiz=$N_cotizacion;
   $ref=$_POST['N_referencia'];
   $nit=$_POST['Str_nit'];  
  if($n_cot!=''&& $nit!='')
  {	  
  $sqlexit="SELECT * FROM `tbl_cliente_referencia` WHERE N_referencia='$ref' AND Str_nit='$nit'";
  $resultexit= mysql_query($sqlexit);
  $numexit= mysql_num_rows($resultexit);
  if($numexit =='0')
  {
//INSERT EN LA BD Tbl_cliente_referencia
$insertSQL5 = sprintf("INSERT INTO Tbl_cliente_referencia(N_referencia,N_cotizacion,Str_nit) VALUES (%s, %s, %s)",
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($N_cotizacion, "int"),
GetSQLValueString($_POST['Str_nit'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result5 = mysql_query($insertSQL5, $conexion1) or die(mysql_error());
   }else{
	   //SI EXISTE ACTUALIZO A LA ULTIMA COTIZ QUE SE LE CREO
	   $sqlcliente="UPDATE Tbl_cliente_referencia SET N_cotizacion='$cotiz' WHERE N_referencia='$ref' AND Str_nit='$nit'";
       $resultcliente=mysql_query($sqlcliente);
	   }
  }
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/
 

  header("location:cotizacion_g_lamina_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $N_cotizacion .  "&tipo=" . $_POST['tipo_usuario'] ); 

break;
return '0';
case'2':
$updateSQL = sprintf("UPDATE Tbl_cotiza_laminas SET N_cotizacion=%s,N_referencia_c=%s, Str_nit=%s, N_ancho=%s, N_repeticion=%s, N_calibre=%s,Str_tipo_coextrusion=%s,Str_capa_ext_coext=%s,Str_capa_inter_coext=%s,N_embobinado=%s,Str_plazo=%s, N_cantidad_metros_r=%s, Str_incoterms=%s, B_impresion=%s, N_colores_impresion=%s, B_cyreles=%s, N_cantidad=%s, N_peso_max=%s, N_diametro_max=%s, Str_moneda=%s, N_precio_k=%s, fecha_creacion=%s, Str_usuario=%s, N_comision=%s, B_estado=%s, B_generica=%s WHERE N_cotizacion='%s' and N_referencia_c='%s'",  
 					   GetSQLValueString($_POST['N_cotizacion'], "int"), 
					   GetSQLValueString($_POST['N_referencia'], "int"),                    
					   GetSQLValueString($_POST['Str_nit'], "text"),
                       GetSQLValueString($_POST['N_ancho_l'], "double"),
                       GetSQLValueString($_POST['N_repeticion_l'], "double"),
                       GetSQLValueString($_POST['N_calibre_l'], "double"),
					   GetSQLValueString($_POST['Str_tipo_coextrusion'], "text"),
					   GetSQLValueString($_POST['Str_capa_ext_coext'], "text"),
					   GetSQLValueString($_POST['Str_capa_inter_coext'], "text"),
					   GetSQLValueString($_POST['N_embobinado'], "text"),
					   GetSQLValueString($_POST['Str_plazo'], "text"),					   					   
                       GetSQLValueString($_POST['N_cantidad_metros_r_l'], "int"),
                       GetSQLValueString($_POST['Str_incoterms_l'], "text"),
                       GetSQLValueString($_POST['B_impresion'], "int"),
					   GetSQLValueString($_POST['N_colores_impresion'], "int"),
					   GetSQLValueString($_POST['B_cyreles'], "int"),
                       GetSQLValueString($_POST['N_cantidad_l'], "text"),                                             
                       GetSQLValueString($_POST['N_peso_max'], "int"),
					   GetSQLValueString($_POST['N_diametro_max_l'], "int"), 
                       GetSQLValueString($_POST['Str_moneda_l'], "text"),
                       GetSQLValueString($_POST['N_precio_k'], "text"),
					   GetSQLValueString($_POST['fecha_l'], "date"),
					   GetSQLValueString($_POST['vendedor'], "text"),
					   GetSQLValueString($_POST['N_comision'], "double"),
					   GetSQLValueString($_POST['B_estado'], "text"),
					   GetSQLValueString($_POST['B_generica'], "text"),
					   GetSQLValueString($_POST['N_cotizacion'], "int"),
					   GetSQLValueString($_POST['N_referencia'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result4 = mysql_query($updateSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SEGUNDA TABLA QUE CONTIENE LOS TEXTOS*/
$updateSQL2 = sprintf("UPDATE Tbl_cotiza_lamina_obs SET N_cotizacion=%s,N_referencia_c=%s,Str_nit=%s, texto=%s WHERE N_cotizacion='%s' and N_referencia_c='%s'",
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_l'], "text"),
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['N_referencia'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($updateSQL2, $conexion1) or die(mysql_error());
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/ 
  $updateGoTo = "cotizacion_g_lamina_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $_POST['N_cotizacion'] .  "&tipo=" . $_POST['tipo_usuario'] ;
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo)); 
break;
return '0';
};
}

function consultoIdcotiz($n_cot){
   
 
 
$conexion = new ApptivaDB();

  $existe = $conexion->llenarCampos("tbl_cotizaciones","WHERE N_cotizacion ='".$n_cot."' " , "","N_cotizacion"); 

  $desId = $conexion->buscarId("tbl_cotizaciones","N_cotizacion");//consulto el ultimo id cotiz
 if($existe == '')
 { 
       $cotiz=$n_cot;
 }else{
       $cotiz=$desId['id']+1 ;//si existe  suma 1
 }
 
 
   
 return $cotiz; 

}

?>