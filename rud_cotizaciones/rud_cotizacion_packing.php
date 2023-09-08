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

$sqlestado="SELECT N_cotizacion,N_referencia_c,Str_nit,fecha_creacion,B_estado FROM Tbl_cotiza_packing WHERE N_referencia_c='$ref' and Str_nit='$nitc' ORDER BY fecha_creacion DESC LIMIT 1";
$resultestado= mysql_query($sqlestado);
$numestado= mysql_num_rows($resultestado);
if($numestado >='1')
{
$cotiz=mysql_result($resultestado,0,'N_cotizacion');	
$sqlobsoleta="UPDATE Tbl_cotiza_packing SET B_estado='3' WHERE N_cotizacion='$cotiz' and N_referencia_c='$ref' and Str_nit='$nitc'";
$resultobsoleta=mysql_query($sqlobsoleta);  
} 

$insertSQL = sprintf("INSERT INTO Tbl_cotiza_packing (N_cotizacion, N_referencia_c, Str_nit, N_ancho, N_alto, N_cantidad, N_calibre, Str_incoterms, Str_moneda, N_precio_vnta, Str_boca_entrada, B_impresion, N_colores_impresion, B_cyreles, Str_ubica_entrada, Str_lam1, Str_lam2,Str_plazo, fecha_creacion, Str_usuario, N_comision, B_estado, B_generica,N_precio_old,impuesto,valor_impuesto) VALUES (%s, %s,%s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                     GetSQLValueString($N_cotizacion, "int"),
                     GetSQLValueString($_POST['N_referencia'], "int"), 
                     GetSQLValueString($_POST['Str_nit'], "text"),
                     GetSQLValueString($_POST['N_ancho_p'], "double"),
                     GetSQLValueString($_POST['N_alto_p'], "double"),
                     GetSQLValueString($_POST['N_cantidad_p'], "text"),
                     GetSQLValueString($_POST['N_calibre_p'], "double"),
                     GetSQLValueString($_POST['Str_incoterms_p'], "text"),					   
                     GetSQLValueString($_POST['Str_moneda_p'], "text"),
                     GetSQLValueString($_POST['N_precio_p'], "text"),
                     GetSQLValueString($_POST['Str_boca_entr'], "text"),
                     GetSQLValueString($_POST['B_impresion'], "int"),
                     GetSQLValueString($_POST['N_colores_impresion'], "int"),
                     GetSQLValueString($_POST['B_cyreles'], "int"),
                     GetSQLValueString($_POST['Str_entrada_p'], "text"),					   
                     GetSQLValueString($_POST['Str_lamina1_p'], "text"),
                     GetSQLValueString($_POST['Str_lamina2_p'], "text"),
                     GetSQLValueString($_POST['Str_plazo'], "text"),
                     GetSQLValueString($_POST['fecha_p'], "date"),
                     GetSQLValueString($_POST['vendedor'], "text"),
                     GetSQLValueString($_POST['N_comision'], "double"),
                     GetSQLValueString($_POST['B_estado'], "text"),
                     GetSQLValueString($_POST['B_generica'], "text"),
                     GetSQLValueString($_POST['N_precio_old'], "text"),
                     GetSQLValueString(isset($_POST['impuesto']) ? "true" : "", "defined","1","0"),
                     GetSQLValueString($_POST['valor_impuesto'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SENDA TABLA QUE CONTIENE LOS TEXTOS*/
$insertSQL2 = sprintf("INSERT INTO Tbl_cotiza_packing_obs ( N_cotizacion,N_referencia_c,Str_nit, texto) VALUES (%s, %s, %s, %s)",
GetSQLValueString($N_cotizacion, "int"),
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_p'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($insertSQL2, $conexion1) or die(mysql_error());
//CONSULTA PARA VER SI EXISTE LA COTIZACION EN MAESTRO
//

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
GetSQLValueString($_POST['fecha_p'], "date"));
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
GetSQLValueString($N_cotizacion, "text"),
GetSQLValueString($_POST['Str_nit'], "text"));
mysql_select_db($database_conexion1, $conexion1);

$Result5 = mysql_query($insertSQL5, $conexion1) or die(mysql_error()); 
   }else{
	   //SI EXISTE ACTUALIZO A LA ULTIMA COTIZ QUE SE LE CREO
	   $sqlcliente="UPDATE Tbl_cliente_referencia SET N_cotizacion='$cotiz' WHERE N_referencia='$ref' AND Str_nit='$nit'";
       $resultcliente=mysql_query($sqlcliente);
	   }
  }
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NI Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/
 header("location:cotizacion_g_packing_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $N_cotizacion .  "&tipo=" . $_POST['tipo_usuario'] ); 

 

break;
return '0';
case'2':
$updateSQL = sprintf("UPDATE Tbl_cotiza_packing SET N_cotizacion=%s, N_referencia_c=%s,Str_nit=%s, N_ancho=%s, N_alto=%s, N_cantidad=%s, N_calibre=%s, Str_incoterms=%s, Str_moneda=%s, N_precio_vnta=%s, Str_boca_entrada=%s, B_impresion=%s, N_colores_impresion=%s, B_cyreles=%s, Str_ubica_entrada=%s, Str_lam1=%s, Str_lam2=%s,Str_plazo=%s, fecha_creacion=%s, Str_usuario=%s, N_comision=%s, B_estado=%s, B_generica=%s,N_precio_old=%s,impuesto=%s, valor_impuesto=%s WHERE N_cotizacion=%s and N_referencia_c=%s",   
                       GetSQLValueString($_POST['N_cotizacion'], "int"),
					   GetSQLValueString($_POST['N_referencia'], "int"),
					   GetSQLValueString($_POST['Str_nit'], "text"),
                       GetSQLValueString($_POST['N_ancho_p'], "double"),
					   GetSQLValueString($_POST['N_alto_p'], "double"),
					   GetSQLValueString($_POST['N_cantidad_p'], "text"),
                       GetSQLValueString($_POST['N_calibre_p'], "double"),
					   GetSQLValueString($_POST['Str_incoterms_p'], "text"),					   
					   GetSQLValueString($_POST['Str_moneda_p'], "text"),
					   GetSQLValueString($_POST['N_precio_p'], "text"),
					   GetSQLValueString($_POST['Str_boca_entr'], "text"),
					   GetSQLValueString($_POST['B_impresion'], "int"),
					   GetSQLValueString($_POST['N_colores_impresion'], "int"),
                       GetSQLValueString($_POST['B_cyreles'], "int"),
                       GetSQLValueString($_POST['Str_entrada_p'], "text"),					   
					   GetSQLValueString($_POST['Str_lamina1_p'], "text"),
                       GetSQLValueString($_POST['Str_lamina2_p'], "text"),
					   GetSQLValueString($_POST['Str_plazo'], "text"),					   
					   GetSQLValueString($_POST['fecha_p'], "date"),
					   GetSQLValueString($_POST['vendedor'], "text"),
					   GetSQLValueString($_POST['N_comision'], "double"),
					   GetSQLValueString($_POST['B_estado'], "text"),
					   GetSQLValueString($_POST['B_generica'], "text"), 
             GetSQLValueString($_POST['N_precio_old'], "text"),
             GetSQLValueString(isset($_POST['impuesto']) ? "true" : "", "defined","1","0"),
             GetSQLValueString($_POST['valor_impuesto'], "text"),
					   GetSQLValueString($_POST['N_cotizacion'], "int"),
					   GetSQLValueString($_POST['N_referencia'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result4 = mysql_query($updateSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SENDA TABLA QUE CONTIENE LOS TEXTOS*/
$updateSQL2 = sprintf("UPDATE Tbl_cotiza_packing_obs SET N_cotizacion=%s,N_referencia_c=%s,Str_nit=%s, texto=%s WHERE N_cotizacion='%s' and N_referencia_c='%s'",
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_p'], "text"),
GetSQLValueString($_POST['N_cotizacion'], "int"),
GetSQLValueString($_POST['N_referencia'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($updateSQL2, $conexion1) or die(mysql_error()); 
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/ 
  $updateGoTo = "cotizacion_g_packing_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $_POST['N_cotizacion'] .  "&tipo=" . $_POST['tipo_usuario'] ;
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