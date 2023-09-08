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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
// area de switch()
switch($rud) {
case '1':
$ref=$_POST['Str_linc'];
$refer=explode("*",$ref);
$refer['0'];//divide las variables de value Str_linc en dos para insertar en campos distintos
$refer['1'];
$insertSQL = sprintf("INSERT INTO Tbl_cotiza_materia_p (N_cotizacion,N_referencia_c, Str_nit, N_cantidad, Str_incoterms, Str_moneda, N_precio_vnta, Str_referencia,Str_unidad_vta,Str_plazo, fecha_creacion, Str_usuario, Str_linc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",           
                       GetSQLValueString($_POST['N_cotizacion'], "int"),
					   GetSQLValueString($_POST['N_referencia'], "int"), 
                       GetSQLValueString($_POST['Str_nit'], "text"),
                       GetSQLValueString($_POST['N_cantidad_m'], "int"),                      
					   GetSQLValueString($_POST['Str_incoterms_m'], "text"),
					   GetSQLValueString($_POST['Str_moneda_m'], "text"),                                                                    
                       GetSQLValueString($_POST['N_precio_vnta_m'], "int"),
					   GetSQLValueString($refer['0'], "text"),
					   GetSQLValueString($_POST['Str_unidad_vta'], "text"),
					   GetSQLValueString($_POST['Str_plazo'], "text"),
					   GetSQLValueString($_POST['fecha_m'], "date"),
					   GetSQLValueString($_POST['Str_usuario'], "text"),
					   GetSQLValueString($refer['1'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SEGUNDA TABLA QUE CONTIENE LOS TEXTOS*/
$insertSQL2 = sprintf("INSERT INTO Tbl_cotiza_materia_p_obs ( N_cotizacion,Str_nit, texto) VALUES (%s, %s, %s)",
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_m'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($insertSQL2, $conexion1) or die(mysql_error());
/*INSERT EN LA BD Tbl_cliente_referencia*/ 
$insertSQL3 = sprintf("INSERT INTO Tbl_cliente_referencia(N_referencia,N_cotizacion,Str_nit) VALUES (%s, %s, %s)",
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result3 = mysql_query($insertSQL3, $conexion1) or die(mysql_error()); 
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NI Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/
  $insertGoTo = "cotizacion_g_materiap_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $_POST['N_cotizacion'] .  "&tipo=" . $_POST['tipo_usuario'] ;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo)); 
break;
return '0';
case'2':
$updateSQL = sprintf("UPDATE Tbl_cotiza_materia_p SET N_cotizacion=%s, Str_nit=%s, N_cantidad=%s, Str_incoterms=%s, Str_moneda=%s, N_precio_vnta=%s, Str_referencia=%s,Str_unidad_vta=%s, Str_plazo=%s, fecha_creacion=%s, Str_usuario=%s, Str_linc=%s WHERE N_cotizacion=%s",   
                       GetSQLValueString($_POST['N_cotizacion'], "int"), 
                       GetSQLValueString($_POST['Str_nit'], "text"),
                       GetSQLValueString($_POST['N_cantidad_m'], "int"),                      
					   GetSQLValueString($_POST['Str_incoterms_m'], "text"),
					   GetSQLValueString($_POST['Str_moneda_m'], "text"),                                                                    
                       GetSQLValueString($_POST['N_precio_vnta_m'], "int"),
					   GetSQLValueString($_POST['Str_referencia_m'], "text"),
					   GetSQLValueString($_POST['Str_unidad_vta'], "text"),
					   GetSQLValueString($_POST['Str_plazo'], "text"),					   
					   GetSQLValueString($_POST['fecha_m'], "date"),
					   GetSQLValueString($_POST['Str_usuario'], "text"),
					   GetSQLValueString($_POST['Str_linc'], "text"),
					   GetSQLValueString($_POST['N_cotizacion'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result4 = mysql_query($updateSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SENDA TABLA QUE CONTIENE LOS TEXTOS*/
$updateSQL2 = sprintf("UPDATE Tbl_cotiza_materia_p_obs SET N_cotizacion=%s,Str_nit=%s, texto=%s WHERE N_cotizacion=%s",
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_m'], "text"),
GetSQLValueString($_POST['N_cotizacion'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($updateSQL2, $conexion1) or die(mysql_error()); 
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/ 
  $updateGoTo = "cotizacion_g_materiap_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $_POST['N_cotizacion'] .  "&tipo=" . $_POST['tipo_usuario'] ;
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo)); 
break;
return '0';
};
}
?>