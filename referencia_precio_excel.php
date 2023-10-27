<?php require_once('Connections/conexion1.php'); ?>
<?php
header('Pragma: public'); 
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past    
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1 
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1 
header('Pragma: no-cache'); 
header('Expires: 0'); 
header('Content-Transfer-Encoding: none'); 
header('Content-Type: application/vnd.ms-excel'); // This should work for IE & Opera 
header('Content-type: application/x-msexcel'); // This should work for the rest 
header('Content-Disposition: attachment; filename="Precios-Referencia.xls"');
?>
<?php
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "usuario.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_conexion1, $conexion1);
/*if($_GET['orden']==''){
  $orden="N_cotizacion";
  }else{
$orden=$_GET['orden'];
  }*/

if($_GET['orden']==''){
  $orden="N_cotizacion";
  }else{
$orden=$_GET['orden'];
  }
$cod_ref = $_GET['cod_ref'];
$bolsa = $_GET['bolsa'];
$id_c = $_GET['id_c'];
$tipo_ref = $_GET['tipo_ref'];
$solapa = $_GET['solapa'];
$ancho = $_GET['ancho'];
$largo = $_GET['largo'];
$calibre = $_GET['calibre'];
$estado = $_GET['estado'];
//operacion rango de ancho y largo
$min='3'; $max='3';
$anchomin = $ancho-$min;
$anchomax = $max+$ancho;
$largomin = $largo-$min;
$largomax = $max+$largo;
//calibre
$minc='1'; $maxc='1';
$calibmin = $calibre-$minc;
$calibmax = $maxc+$calibre;

//Filtra todos vacios
if($cod_ref=='0'){
   $BD='';
}else{

$BD = $conexion->TipoTabla($cod_ref); //la funcion define que tipo de ref es: bolsa, lamina, packing
}
$BD = $BD=='' ? "Tbl_cotiza_bolsa" : $BD;
//todo vacio
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
 
$query_cotizacion = "SELECT * FROM $BD, tbl_referencia ref WHERE CONVERT($BD.n_referencia_c, SIGNED INTEGER) = CONVERT(ref.cod_ref, SIGNED INTEGER) and $BD.B_estado <> '2' ORDER BY CONVERT(ref.cod_ref, SIGNED INTEGER) DESC";
}
//Filtra estado lleno
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado!='')
{
$query_cotizacion = "SELECT * FROM $BD, tbl_referencia ref WHERE CONVERT($BD.n_referencia_c, SIGNED INTEGER) = CONVERT(ref.cod_ref, SIGNED INTEGER) and $BD.B_estado='$estado' ORDER BY CONVERT(ref.cod_ref, SIGNED INTEGER) DESC ";
}
//Filtra tipo ref,estado lleno
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref != '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado!='')
{
$query_cotizacion = "SELECT * FROM $BD, tbl_referencia ref WHERE CONVERT($BD.n_referencia_c, SIGNED INTEGER) = CONVERT(ref.cod_ref, SIGNED INTEGER) and $BD.B_estado='$estado' AND $BD.B_generica ='$tipo_ref' ORDER BY CONVERT(ref.cod_ref, SIGNED INTEGER) DESC ";
}
//Filtra cod ref lleno
if($cod_ref != '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_referencia_c='$cod_ref' ORDER BY $BD.$orden DESC";
}
//Filtra Bolsa
if($cod_ref == '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
 
 //$registros =$conexion->buscarListar("$BD","*","ORDER BY $BD.$orden DESC","",$maxRows_cotizacion,$pageNum_cotizacion,"where tipo_bolsa ='$bolsa' AND $BD.B_estado <> '2' " );
$query_cotizacion = "SELECT * FROM  $BD WHERE tipo_bolsa ='$bolsa' AND $BD.B_estado <> '2'  ORDER BY $BD.$orden DESC";
 
}
//Filtra cliente lleno
if($id_c != '' && $bolsa == '0' && $cod_ref == '0' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
 
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND Str_nit='$id_c' ORDER BY $BD.$orden DESC";
}

//Filtra cod y cliente llenos
if($cod_ref != '0' && $bolsa == '0' && $id_c != '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
 
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_referencia_c='$cod_ref' AND Str_nit='$id_c' ORDER BY $BD.$orden DESC";
}


//Filtra Bolsa y ref
if($cod_ref != '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE tipo_bolsa='$bolsa' AND N_referencia_c='$cod_ref' AND $BD.B_estado <> '2' ORDER BY $BD.$orden DESC";
 
}
//Filtra Bolsa y cliente
if($cod_ref == '0' && $bolsa != '0' && $id_c != '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
 
$query_cotizacion = "SELECT * FROM $BD WHERE tipo_bolsa='$bolsa' AND $BD.Str_nit='$id_c' AND $BD.B_estado <> '2' ORDER BY $BD.$orden DESC";
}
//Filtra Bolsa, ancho
if($cod_ref == '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho != '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE $BD.B_estado <> '2' AND tipo_bolsa='$bolsa' AND $BD.N_ancho BETWEEN $anchomin AND $anchomax ORDER BY $BD.$orden DESC";
}
//Filtra Bolsa, alto
if($cod_ref == '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo != '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE $BD.B_estado <> '2' AND tipo_bolsa='$bolsa' AND $BD.N_alto BETWEEN $largomin AND $largomax ORDER BY $BD.$orden DESC";
}
//Filtra Bolsa, calibre
if($cod_ref == '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE $BD.B_estado <> '2' AND tipo_bolsa='$bolsa' AND $BD.N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  Bolsa, ancho, largo, calibre
if($cod_ref == '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE $BD.B_estado <> '2' AND tipo_bolsa='$bolsa' AND $BD.N_ancho BETWEEN $anchomin AND $anchomax AND $BD.N_alto BETWEEN $largomin AND $largomax AND $BD.N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  Bolsa, solapa, ancho, largo, calibre
if($cod_ref == '0' && $bolsa != '0' && $id_c == '' && $tipo_ref == '' && $solapa != '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE $BD.B_estado <> '2' AND tipo_bolsa='$bolsa' AND $BD.N_solapa ='$solapa' AND $BD.N_ancho BETWEEN $anchomin AND $anchomax AND $BD.N_alto BETWEEN $largomin AND $largomax AND $BD.N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}



//Filtra tipo_ref
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref != '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND B_generica ='$tipo_ref' ORDER BY $BD.$orden DESC";
}
//Filtra solapa
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa != '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_solapa ='$solapa' ORDER BY $BD.$orden DESC";
}
//Filtra ancho
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho != '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_ancho BETWEEN $anchomin AND $anchomax ORDER BY $BD.$orden DESC";
}
//Filtra largo
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo != '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_alto BETWEEN $largomin AND $largomax ORDER BY $BD.$orden DESC";
}
//Filtra calibre
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo == '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_calibre BETWEEN '$calibmin' AND '$calibmax' ORDER BY $BD.$orden DESC";
}
//Filtra cliente, tipo ref, tipo bolsa,solapa, ancho, largo, calibre
if($cod_ref == '0' && $id_c != '' && $tipo_ref != '' && $solapa != '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
 
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND Str_nit='$id_c' AND B_generica ='$tipo_ref'  AND N_solapa ='$solapa' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax  AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  tipo ref, tipo bolsa, ancho, largo, calibre
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref != '' && $solapa != '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND B_generica ='$tipo_ref'  AND N_solapa ='$solapa' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  tipo ref, ancho, largo, calibre
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref != '' && $solapa == '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND B_generica ='$tipo_ref' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  tipo ref, ancho, largo
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref != '' && $solapa == '' && $ancho != '0' && $largo != '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND B_generica ='$tipo_ref' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax ORDER BY $BD.$orden DESC";
}
//Filtra  tipo bolsa, ancho, largo, calibre
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa != '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_solapa ='$solapa' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  tipo bolsa, ancho, largo
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa != '' && $ancho != '0' && $largo != '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_solapa ='$solapa' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax ORDER BY $BD.$orden DESC";
}
//Filtra  ancho, largo, calibre
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho != '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  ancho, largo
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho != '0' && $largo != '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax ORDER BY $BD.$orden DESC";
}
//Filtra largo, calibre
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref == '' && $solapa == '' && $ancho == '0' && $largo != '0' && $calibre != '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND N_alto BETWEEN $largomin AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
//Filtra  tipo ref,solapa 
if($cod_ref == '0' && $bolsa == '0' && $id_c == '' && $tipo_ref != '' && $solapa != '' && $ancho == '0' && $largo == '0' && $calibre == '0' && $estado=='')
{
$query_cotizacion = "SELECT * FROM $BD WHERE B_estado <> '2' AND B_generica ='$tipo_ref' AND N_solapa ='$solapa' AND N_ancho BETWEEN $anchomin AND $anchomax AND N_alto BETWEEN $largomin AND $largomax  AND N_calibre BETWEEN $calibmin AND $calibmax ORDER BY $BD.$orden DESC";
}
$cotizacion = mysql_query($query_cotizacion, $conexion1) or die(mysql_error());
$row_cotizacion = mysql_fetch_assoc($cotizacion);
$totalRows_cotizacion = mysql_num_rows($cotizacion); 
 ?>
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
          <table class="table table-bordered table-sm" border='1' >
            
              <tr id="tr1">
                <td nowrap="nowrap" id="titulo4">N&deg; REF</td>
                <td nowrap="nowrap" id="titulo4">TIPO REF</td>
                <td nowrap="nowrap" id="titulo4">COTIZ</td>
                <td nowrap="nowrap" id="titulo4">Cliente</td>
                <td nowrap="nowrap" id="titulo4">TIPO</td>
                <td nowrap="nowrap" id="titulo4">BOLSA</td>
                <td nowrap="nowrap" id="titulo4">Ancho</td>
                <td nowrap="nowrap" id="titulo4">Largo</td>
                <td nowrap="nowrap" id="titulo4">Solapa</td>
                <td nowrap="nowrap" id="titulo4">Bolsillo</td>
                <td nowrap="nowrap" id="titulo4">Calibre</td>
                <td nowrap="nowrap" id="titulo4">Precio sin impuesto $</td>
                <td nowrap="nowrap" id="titulo4">Precio Con impuesto $</td>
                <td nowrap="nowrap" id="titulo4">Fecha Creacion</td>
                <td nowrap="nowrap" id="titulo4">ESTADO COTIZ</td>


              </tr>
        <?php do { ?>
            <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#ffffffff');" bgcolor#ffffffffFF">
              <td id="dato2"><?php echo $row_cotizacion['N_referencia_c']; ?></td>
              <td id="dato2">
                   <?php  if($row_cotizacion['B_generica']=='0'){echo "Existente";}else{echo "Generica";};?> 
               </td>     
               <td id="dato2"><?php echo $row_cotizacion['N_cotizacion']; ?></td>
               <td id="talla1">
               <?php 
               $nit_c=$row_cotizacion['Str_nit'];
               $sqln="SELECT nombre_c FROM cliente WHERE nit_c='$nit_c'"; 
               $resultn=mysql_query($sqln); 
               $numn=mysql_num_rows($resultn); 
               if($numn >= '1') 
                { $nit_cliente_c=mysql_result($resultn,0,'nombre_c'); echo $nit_cliente_c; }
              ?>
              </td>      
              <td id="dato2"><?php echo $row_cotizacion['material_ref']=='' ? $row_cotizacion['Str_tipo_coextrusion']: $row_cotizacion['material_ref']; ?></td>
              <td id="dato2"><?php echo $row_cotizacion['tipo_bolsa_ref']==''?$row_cotizacion['tipo_bolsa']:$row_cotizacion['tipo_bolsa_ref'];?></td>
              <td id="dato2"><?php echo $row_cotizacion['N_ancho']; ?></td> 
              <td id="dato2"><?php echo $row_cotizacion['N_alto']; ?></td>
              <td id="dato2"><?php echo $row_cotizacion['N_solapa']; ?></td>
              <td id="dato2"><?php if($row_cotizacion['N_tamano_bolsillo']!=''){ echo $row_cotizacion['N_tamano_bolsillo'];}else{echo "0.00";} ?></td>
              <td id="dato2"><?php echo $row_cotizacion['N_calibre']; ?></td>
              <td id="dato2"><?php echo $row_cotizacion['N_precio'],$row_cotizacion['N_precio_vnta']; ?></td>
              <td id="dato2"><?php echo $row_cotizacion['N_precio_old']; ?></td>
              <td id="dato1"><?php echo $row_cotizacion['fecha_creacion']; ?></td>
              <td id="dato1"><?php 
              if (!(strcmp("0", $row_cotizacion['B_estado']))) {echo "Pendiente";}
              if (!(strcmp("1", $row_cotizacion['B_estado']))) {echo "Aceptada";}
              if (!(strcmp("2", $row_cotizacion['B_estado']))) {echo "Rechazada";}
              if (!(strcmp("3", $row_cotizacion['B_estado']))) {echo "Obsoleta";} ?></td>
              </tr>
              <?php } while ($row_cotizacion = mysql_fetch_assoc($cotizacion)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($cotizacion);

?>