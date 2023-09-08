
<?php
  
  require_once('Connections/conexion1.php'); ?>
<?php
mysql_select_db($database_conexion1, $conexion1);
/*----------COTIZACION BOLSAS--------*/
/*--------------ACCIONES------------------*/
$rud=$_POST['valor'];     
//echo "varable switch".$rud ;                                                      
/*------------COTIZACIONES---------------*/
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
/*------------------------------------------------------------------*/
/*--------------------------GESTION COMERCIAL-----------------------*/
/*INSERT BOLSAS*/
 
   //$N_cotizacion=consultoIdcotiz($_POST['N_cotizacion']);//quitarlo para q puedan agregar varias ref a la cotiz
   $N_cotizacion=$_POST['N_cotizacion'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
// area de switch()
switch($rud) {
case '1':
$ref=$_POST['N_referencia']; 
$nitc=$_POST['Str_nit'];

 
$sqlestado="SELECT N_cotizacion,N_referencia_c,Str_nit,fecha_creacion,B_estado FROM Tbl_cotiza_bolsa WHERE N_referencia_c='$ref' and Str_nit='$nitc' ORDER BY fecha_creacion DESC LIMIT 1";
$resultestado= mysql_query($sqlestado);
$numestado= mysql_num_rows($resultestado);
if($numestado >='1')
{
$cotiz=mysql_result($resultestado,0,'N_cotizacion');	
$sqlobsoleta="UPDATE Tbl_cotiza_bolsa SET B_estado='3' WHERE N_cotizacion='$cotiz' and N_referencia_c='$ref' and Str_nit='$nitc'";
$resultobsoleta=mysql_query($sqlobsoleta);  //3 es obsoleta
}/*else{*/


 

  $insertSQL = sprintf("INSERT INTO Tbl_cotiza_bolsa(N_cotizacion, N_referencia_c, Str_nit, N_ancho, N_alto, B_fuelle, N_calibre, B_troquel, B_precorte, B_bolsillo, N_tamano_bolsillo, N_solapa, Str_moneda, N_precio,  Str_unidad_vta, Str_plazo, Str_incoterms, Str_tipo_coextrusion, Str_capa_ext_coext, Str_capa_inter_coext, N_cant_impresion, B_impresion, N_colores_impresion, B_cyreles, B_sellado_seguridad, B_sellado_permanente, B_sellado_resellable, B_sellado_hotm, Str_sellado_lateral, B_fondo, B_codigo_b, B_numeracion, fecha_creacion, Str_usuario, N_comision, B_estado,B_generica,tipo_bolsa,N_precio_old,impuesto,valor_impuesto) VALUES (%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
   GetSQLValueString($N_cotizacion, "int"),
   GetSQLValueString($_POST['N_referencia'], "int"), 
   GetSQLValueString($_POST['Str_nit'], "text"),					   
   GetSQLValueString($_POST['N_ancho'], "double"),
   GetSQLValueString($_POST['N_alto'], "double"),
   GetSQLValueString($_POST['B_fuelle'], "double"),
   GetSQLValueString($_POST['N_calibre'], "double"),
   GetSQLValueString($_POST['B_troquel'], "int"),
   GetSQLValueString($_POST['B_precorte'], "int"),
   GetSQLValueString($_POST['B_bolsillo'], "int"),
   GetSQLValueString($_POST['N_tamano_bolsillo'], "double"),
   GetSQLValueString($_POST['N_solapa'], "int"),
   GetSQLValueString($_POST['Str_moneda'], "text"),
   GetSQLValueString($_POST['N_precio'], "text"),                                             
   GetSQLValueString($_POST['Str_unidad_vta'], "text"),
   GetSQLValueString($_POST['Str_plazo'], "text"),
   GetSQLValueString($_POST['Str_incoterms'], "text"), 
   GetSQLValueString($_POST['Str_tipo_coextrusion'], "text"),
   GetSQLValueString($_POST['Str_capa_ext_coext'], "text"),
   GetSQLValueString($_POST['Str_capa_inter_coext'], "text"),
   GetSQLValueString($_POST['N_cant_impresion'], "text"),
   GetSQLValueString($_POST['B_impresion'], "int"),
   GetSQLValueString($_POST['N_colores_impresion'], "int"),
   GetSQLValueString($_POST['B_cyreles'], "int"),
   GetSQLValueString($_POST['B_sellado_seguridad'], "int"),
   GetSQLValueString($_POST['B_sellado_permanente'], "int"),
   GetSQLValueString($_POST['B_sellado_resellable'], "int"),
   GetSQLValueString($_POST['B_sellado_hotm'], "int"),
   GetSQLValueString($_POST['Str_sellado_lateral'], "text"),
   GetSQLValueString($_POST['B_fondo'], "int"),
   GetSQLValueString($_POST['B_codigo_b'], "int"),
   GetSQLValueString($_POST['B_numeracion'], "int"),
   GetSQLValueString($_POST['fecha_b'], "date"),
   GetSQLValueString($_POST['vendedor'], "text"),
   GetSQLValueString($_POST['N_comision'], "double"),
   GetSQLValueString($_POST['B_estado'], "text"),
   GetSQLValueString($_POST['B_generica'], "text"),
   GetSQLValueString($_POST['tipo_bolsa'], "text"),
   GetSQLValueString($_POST['N_precio_old'], "text"),
   GetSQLValueString(isset($_POST['impuesto']) ? "true" : "", "defined","1","0"),
   GetSQLValueString($_POST['valor_impuesto'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SEGUNDA TABLA QUE CONTIENE LOS TEXTOS*/
$insertSQL2 = sprintf("INSERT INTO Tbl_cotiza_bolsa_obs ( N_cotizacion,N_referencia_c,Str_nit, texto) VALUES (%s, %s, %s, %s)",
GetSQLValueString($N_cotizacion, "int"),
GetSQLValueString($_POST['N_referencia'], "int"),
GetSQLValueString($_POST['Str_nit'], "text"),
GetSQLValueString($_POST['nota_b'], "text"));
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
  //$nombre_vendedor = mysql_result($resultver,0,'N_cotizacion');  
      /*INSERT EN LA BD Tbl_cotizaciones*/ 
      $insertSQL3 = sprintf("INSERT INTO Tbl_cotizaciones(N_cotizacion,Str_nit,Str_tipo, fecha) VALUES (%s, %s, %s, %s)",
      GetSQLValueString($N_cotizacion, "int"),
      GetSQLValueString($_POST['Str_nit'], "text"),
      GetSQLValueString($_POST['Str_tipo'], "text"),
      GetSQLValueString($_POST['fecha_b'], "date"));
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
$insertSQL6 = sprintf("INSERT INTO Tbl_cliente_referencia(N_referencia,N_cotizacion,Str_nit) VALUES (%s, %s, %s)",
GetSQLValueString($_POST['N_referencia'], "text"),
GetSQLValueString($N_cotizacion, "text"),
GetSQLValueString($_POST['Str_nit'], "text"));
mysql_select_db($database_conexion1, $conexion1);
 
$Result5 = mysql_query($insertSQL6, $conexion1) or die(mysql_error());
   }else{
	   //SI EXISTE ACTUALIZO A LA ULTIMA COTIZ QUE SE LE CREO
	   $sqlcliente="UPDATE Tbl_cliente_referencia SET N_cotizacion='$cotiz' WHERE N_referencia='$ref' AND Str_nit='$nit'";
       $resultcliente=mysql_query($sqlcliente);
	   }
  }

/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/
  
  header("location:cotizacion_g_bolsa_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $N_cotizacion .  "&tipo=" . $_POST['tipo_usuario'] ); 
//}
break;
return '0';
case '2':   

$updateSQL = sprintf("UPDATE Tbl_cotiza_bolsa SET N_cotizacion=%s,N_referencia_c=%s, Str_nit=%s, N_ancho=%s, N_alto=%s, B_fuelle=%s, N_calibre=%s, B_troquel=%s, B_precorte=%s, B_bolsillo=%s, N_tamano_bolsillo=%s, N_solapa=%s, Str_moneda=%s, N_precio=%s,  Str_unidad_vta=%s, Str_plazo=%s, Str_incoterms=%s, Str_tipo_coextrusion=%s, Str_capa_ext_coext=%s, Str_capa_inter_coext=%s, N_cant_impresion=%s, B_impresion=%s, N_colores_impresion=%s, B_cyreles=%s, B_sellado_seguridad=%s, B_sellado_permanente=%s, B_sellado_resellable=%s, B_sellado_hotm=%s, Str_sellado_lateral=%s, B_fondo=%s, B_codigo_b=%s, B_numeracion=%s, fecha_creacion=%s, Str_usuario=%s, N_comision=%s, B_estado=%s, B_generica=%s, tipo_bolsa=%s,N_precio_old=%s,impuesto=%s, valor_impuesto=%s WHERE N_cotizacion='%s' and N_referencia_c='%s'",  
  GetSQLValueString($_POST['N_cotizacion'], "int"),
  GetSQLValueString($_POST['N_referencia'], "int"),
  GetSQLValueString($_POST['Str_nit'], "text"),					   
  GetSQLValueString($_POST['N_ancho'], "double"),
  GetSQLValueString($_POST['N_alto'], "double"),
  GetSQLValueString($_POST['B_fuelle'], "double"),
  GetSQLValueString($_POST['N_calibre'], "double"),
  GetSQLValueString($_POST['B_troquel'], "int"),
  GetSQLValueString($_POST['B_precorte'], "int"),
  GetSQLValueString($_POST['B_bolsillo'], "int"),
  GetSQLValueString($_POST['N_tamano_bolsillo'], "double"),
  GetSQLValueString($_POST['N_solapa'], "int"),
  GetSQLValueString($_POST['Str_moneda'], "text"),
  GetSQLValueString($_POST['N_precio'], "text"),                                        
  GetSQLValueString($_POST['Str_unidad_vta'], "text"),
  GetSQLValueString($_POST['Str_plazo'], "text"),
  GetSQLValueString($_POST['Str_incoterms'], "text"), 
  GetSQLValueString($_POST['Str_tipo_coextrusion'], "text"),
  GetSQLValueString($_POST['Str_capa_ext_coext'], "text"),
  GetSQLValueString($_POST['Str_capa_inter_coext'], "text"),
  GetSQLValueString($_POST['N_cant_impresion'], "text"),
  GetSQLValueString($_POST['B_impresion'], "int"),
  GetSQLValueString($_POST['N_colores_impresion'], "int"),
  GetSQLValueString($_POST['B_cyreles'], "int"),
  GetSQLValueString($_POST['B_sellado_seguridad'], "int"),
  GetSQLValueString($_POST['B_sellado_permanente'], "int"),
  GetSQLValueString($_POST['B_sellado_resellable'], "int"),
  GetSQLValueString($_POST['B_sellado_hotm'], "int"),
  GetSQLValueString($_POST['Str_sellado_lateral'], "text"),
  GetSQLValueString($_POST['B_fondo'], "int"),
  GetSQLValueString($_POST['B_codigo_b'], "int"),
  GetSQLValueString($_POST['B_numeracion'], "int"),
  GetSQLValueString($_POST['fecha_modificacion'], "date"),
  GetSQLValueString($_POST['vendedor'], "text"),
  GetSQLValueString($_POST['N_comision'], "double"),
  GetSQLValueString($_POST['B_estado'], "text"),
  GetSQLValueString($_POST['B_generica'], "text"),
  GetSQLValueString($_POST['tipo_bolsa'], "text"), 
  GetSQLValueString($_POST['N_precio_old'], "text"),
  GetSQLValueString(isset($_POST['impuesto']) ? "true" : "", "defined","1","0"),
  GetSQLValueString($_POST['valor_impuesto'], "text"),
  GetSQLValueString($_POST['N_cotizacion'], "int"),
  GetSQLValueString($_POST['N_referencia'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result4 = mysql_query($updateSQL, $conexion1) or die(mysql_error());
/*SEGUNDO UPDATE A LA SENDA TABLA QUE CONTIENE LOS TEXTOS*/
$updateSQL2 =  sprintf("UPDATE Tbl_cotiza_bolsa_obs SET N_cotizacion=%s,N_referencia_c=%s,Str_nit=%s, texto=%s WHERE N_cotizacion='%s' and N_referencia_c='%s'",
  GetSQLValueString($_POST['N_cotizacion'], "int"),
  GetSQLValueString($_POST['N_referencia'], "int"),
  GetSQLValueString($_POST['Str_nit'], "text"),
  GetSQLValueString($_POST['nota_b'], "text"),
  GetSQLValueString($_POST['N_cotizacion'], "int"),
  GetSQLValueString($_POST['N_referencia'], "int"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($updateSQL2, $conexion1) or die(mysql_error());
/*SI EN EL UPDATE VA VACIO QUE NO ME GUARDE Y ME ELIMINE EL TEXTO NULL
if($_POST['nota_b']==""){
$sqltex="DELETE FROM Tbl_cotiza_bolsa_obs WHERE N_cotizacion='$_POST[N_cotizacion]'";
$resulttex=mysql_query($sqltex);	
	} */
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/ 
  $updateGoTo = "cotizacion_g_bolsa_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $_POST['N_cotizacion'] .  "&tipo=" . $_POST['tipo_usuario'] ;
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo)); 
break;
return '0'; 
case '3':
$insertSQL = sprintf("INSERT INTO Tbl_cotiza_bolsa(N_cotizacion, N_referencia_c, Str_nit, N_ancho, N_alto, B_fuelle, N_calibre, B_troquel, B_precorte, B_bolsillo, N_tamano_bolsillo, N_solapa, Str_moneda, N_precio,  Str_unidad_vta, Str_plazo, Str_incoterms, Str_tipo_coextrusion, Str_capa_ext_coext, Str_capa_inter_coext, N_cant_impresion, B_impresion, N_colores_impresion, B_cyreles, B_sellado_seguridad, B_sellado_permanente, B_sellado_resellable, B_sellado_hotm, Str_sellado_lateral, B_fondo, B_codigo_b, B_numeracion, fecha_creacion, Str_usuario, N_comision, B_estado,B_generica,tipo_bolsa,N_precio_old,impuesto,valor_impuesto) VALUES (%s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
 GetSQLValueString($_POST['N_cotizacion'], "int"),
 GetSQLValueString($_POST['N_referencia'], "int"), 
 GetSQLValueString($_POST['Str_nit'], "text"),					   
 GetSQLValueString($_POST['N_ancho'], "double"), 
 GetSQLValueString($_POST['N_alto'], "double"),
 GetSQLValueString($_POST['B_fuelle'], "double"),
 GetSQLValueString($_POST['N_calibre'], "double"),
 GetSQLValueString($_POST['B_troquel'], "int"),
 GetSQLValueString($_POST['B_precorte'], "int"),
 GetSQLValueString($_POST['B_bolsillo'], "int"),
 GetSQLValueString($_POST['N_tamano_bolsillo'],"double"),
 GetSQLValueString($_POST['N_solapa'], "int"),
 GetSQLValueString($_POST['Str_moneda'], "text"),
 GetSQLValueString($_POST['N_precio'], "text"),                                             
 GetSQLValueString($_POST['Str_unidad_vta'], "text"),
 GetSQLValueString($_POST['Str_plazo'], "text"),
 GetSQLValueString($_POST['Str_incoterms'], "text"), 
 GetSQLValueString($_POST['Str_tipo_coextrusion'], "text"),
 GetSQLValueString($_POST['Str_capa_ext_coext'], "text"),
 GetSQLValueString($_POST['Str_capa_inter_coext'], "text"),
 GetSQLValueString($_POST['N_cant_impresion'], "text"),
 GetSQLValueString($_POST['B_impresion'], "int"),
 GetSQLValueString($_POST['N_colores_impresion'], "int"),
 GetSQLValueString($_POST['B_cyreles'], "int"),
 GetSQLValueString($_POST['B_sellado_seguridad'], "int"),
 GetSQLValueString($_POST['B_sellado_permanente'], "int"),
 GetSQLValueString($_POST['B_sellado_resellable'], "int"),
 GetSQLValueString($_POST['B_sellado_hotm'], "int"),
 GetSQLValueString($_POST['Str_sellado_lateral'], "text"),
 GetSQLValueString($_POST['B_fondo'], "int"),
 GetSQLValueString($_POST['B_codigo_b'], "int"),
 GetSQLValueString($_POST['B_numeracion'], "int"),
 GetSQLValueString($_POST['fecha_b'], "date"),
 GetSQLValueString($_POST['vendedor'], "text"),
 GetSQLValueString($_POST['N_comision'], "double"),
 GetSQLValueString($_POST['B_estado'], "text"),
 GetSQLValueString($_POST['B_generica'], "text"),
 GetSQLValueString($_POST['tipo_bolsa'], "text"),
   GetSQLValueString($_POST['N_precio_old'], "text"),
   GetSQLValueString(isset($_POST['impuesto']) ? "true" : "", "defined","1","0"),
   GetSQLValueString($_POST['valor_impuesto'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
/*SEGUNDO INSERT A LA SEGUNDA TABLA QUE CONTIENE LOS TEXTOS*/
$insertSQL2 = sprintf("INSERT INTO Tbl_cotiza_bolsa_obs ( N_cotizacion,N_referencia_c,Str_nit, texto) VALUES (%s, %s, %s, %s)",
  GetSQLValueString($_POST['N_cotizacion'], "int"),
  GetSQLValueString($_POST['N_referencia'], "int"),
  GetSQLValueString($_POST['Str_nit'], "text"),
  GetSQLValueString($_POST['nota_b'], "text"));
mysql_select_db($database_conexion1, $conexion1);
$Result2 = mysql_query($insertSQL2, $conexion1) or die(mysql_error()); 
/*ESTE CODIGO ES PARA ENVIAR POR GET LAS VARIABLES NIT Y N_COTIZACION Y PODER HACER EL SELECT EN cotizacion_bolsa_vista.php*/
  $insertGoTo = "cotizacion_g_bolsa_vista.php?Str_nit=" . $_POST['Str_nit'] . "&N_cotizacion=" . $_POST['N_cotizacion'] .  "&tipo=" . $_POST['tipo_usuario'] ;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo)); 
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