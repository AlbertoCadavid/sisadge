<?php require_once('Connections/conexion1.php'); ?><?php
if (!isset($_SESSION)) {
  session_start();
}
 
 
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
//VARIABLES GET
  $colname_faltantes_op = $_GET['id_op'];
  $colname_faltantes_p = $_GET['int_paquete_tn'];
  $colname_faltantes_k =  $_GET['int_caja_tn'];
 
mysql_select_db($database_conexion1, $conexion1);
$query_vista_faltantes = sprintf("SELECT * FROM Tbl_tiquete_numeracion, Tbl_faltantes WHERE Tbl_tiquete_numeracion.int_op_tn=%s AND Tbl_tiquete_numeracion.int_paquete_tn=%s AND Tbl_tiquete_numeracion.int_caja_tn=%s  AND Tbl_tiquete_numeracion.int_op_tn=Tbl_faltantes.id_op_f AND Tbl_tiquete_numeracion.int_paquete_tn=Tbl_faltantes.int_paquete_f AND Tbl_tiquete_numeracion.int_caja_tn=Tbl_faltantes.int_caja_f ORDER BY Tbl_faltantes.int_inicial_f ASC", $colname_faltantes_op,$colname_faltantes_p,$colname_faltantes_k);
$vista_faltantes = mysql_query($query_vista_faltantes, $conexion1) or die(mysql_error());
$row_vista_faltantes = mysql_fetch_assoc($vista_faltantes);
$totalRows_vista_faltantes = mysql_num_rows($vista_faltantes);

$colname_op = "-1";
if (isset($_GET['id_op'])) {
  $colname_op = (get_magic_quotes_gpc()) ? $_GET['id_op'] : addslashes($_GET['id_op']);
}
$colname_p = "-1";
if (isset($_GET['int_paquete_tn'])) {
  $colname_p = (get_magic_quotes_gpc()) ? $_GET['int_paquete_tn'] : addslashes($_GET['int_paquete_tn']);
}
$colname_faltantes_k = "-1";
if (isset($_GET['int_caja_tn'])) {
  $colname_faltantes_k = (get_magic_quotes_gpc()) ? $_GET['int_caja_tn'] : addslashes($_GET['int_caja_tn']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_vista_paquete = sprintf("SELECT * FROM Tbl_tiquete_numeracion WHERE int_op_tn=%s AND int_paquete_tn=%s AND int_caja_tn=%s", $colname_op,$colname_p,$colname_faltantes_k);
$vista_paquete = mysql_query($query_vista_paquete, $conexion1) or die(mysql_error());
$row_vista_paquete = mysql_fetch_assoc($vista_paquete);
$totalRows_vista_paquete = mysql_num_rows($vista_paquete);
 
mysql_select_db($database_conexion1, $conexion1);
$query_existe_falt = sprintf("select id_f as id_idf from Tbl_faltantes WHERE Tbl_faltantes.id_op_f= '%s' and Tbl_faltantes.int_paquete_f = '%s' and Tbl_faltantes.int_caja_f= '%s'", $colname_op,$colname_p,$colname_faltantes_k);
$existe_falt = mysql_query($query_existe_falt, $conexion1) or die(mysql_error());
$row_existe_falt = mysql_fetch_assoc($existe_falt);
$totalRows_existe_falt = mysql_num_rows($existe_falt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>SISADGE AC & CIA</title>
<link href="css/vista.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="js/impresion.js" async="async"></script>-->
</head>
<body onload="self.print();"><!--self.close(); onLoad="imprimir();"   id="seleccion" onClick="cerrar('seleccion');return false"-->
<div align="center" id="seleccion" onClick="cerrar('seleccion');return false">
<table>
  <tr>
    <td colspan="4" ></td>
  </tr>
      <tr>
        <td colspan="4" nowrap="nowrap" align="center" id="stikers_titu">CONTROL DE NUMERACION </td>
    </tr>
  <tr>
    <td nowrap="nowrap" id="stikers_fuent1">PAQUETE</td>
    <td nowrap="nowrap" id="stikers_fuentN2"><?php echo $paq_gen=$row_vista_paquete['int_paquete_tn']; ?></td>
    <td nowrap id="stikers_fuent1">CAJA</td>
    <td nowrap id="stikers_fuentN2"><?php echo $caja_gen=$_GET['int_caja_tn']; ?></td>
    </tr>    
  <tr>
    <td colspan="2" nowrap="nowrap" id="stikers_fuent1">FECHA</td>
    <td colspan="2" nowrap id="stikers_fuent1"><?php echo $row_vista_paquete['fecha_ingreso_tn']; ?> HORA: <?php echo date("H:i:s");?></td>
    </tr>
  <tr>
    <td colspan="2" nowrap="nowrap"id="stikers_fuent1">ORDEN P.</td>
    <td colspan="2" id="stikers_fuent1"><?php echo $op_gen=$_GET['id_op']; ?></td>
    </tr> 
      <tr>
    <td colspan="2" nowrap="nowrap" id="stikers_fuent1">UNIDADES  X PAQ.</td>
    <td colspan="2" id="stikers_fuent1"><?php echo $row_vista_paquete['int_undxpaq_tn']; ?></td>
    </tr>
    <tr>
     <td colspan="2" nowrap="nowrap"id="stikers_fuent1">UNIDADES X CAJA</td>
      <td colspan="2"id="stikers_fuent1"><?php echo $row_vista_paquete['int_undxcaja_tn'];?></td>
      </tr>
      <tr>
    <td colspan="2" nowrap="nowrap" id="stikers_fuent1"><b>DESDE</b></td>
    <td colspan="2" id="stikers_fuentN2"><b><?php echo $row_vista_paquete['int_desde_tn']; ?></b></td>
    </tr>
      <tr>
    <td colspan="2" nowrap="nowrap" id="stikers_fuent1"><b>HASTA</b></td>
    <td colspan="2" id="stikers_fuentN2"><b><?php echo $row_vista_paquete['int_hasta_tn']; ?></b></td>
    </tr>
      <tr>
    <td colspan="2" nowrap="nowrap" id="stikers_fuent1">CODIGO DE EMPLEADO</td>
    <td colspan="2" id="stikers_fuent1"><?php echo $row_vista_paquete['int_cod_empleado_tn']; ?></td>
    </tr>
    <tr>
    <td colspan="2" nowrap="nowrap" id="stikers_fuent1">CODIGO DE REVISOR</td>
    <td colspan="2" id="stikers_fuent1"><?php echo $row_vista_paquete['int_cod_rev_tn']; ?></td>
    </tr> 
    
    
    <?php if($row_vista_faltantes['int_inicial_f']!=''){ ?>
      <tr>
        <td colspan="4" nowrap="nowrap" id="stikers_subt2"><b>FALTANTES</b></td>
      </tr>    
     <?php  do { ?> 
     <tr>
    <td width="52" colspan="4" id="stikers_fuentN2"><?php echo 'Del: <b>'. $row_vista_faltantes['int_inicial_f']; ?> - <?php echo '</b>Al: <b>'. $row_vista_faltantes['int_final_f']. "</b> "; ?></td>
    </tr>
    <?php } while ($row_vista_faltantes = mysql_fetch_assoc($vista_faltantes)); ?>
    <?php }?>    
    
    
         
<!--    <?php if($row_existe_falt['id_idf']!=''){
		 ?>
      <tr>
        <td colspan="4" nowrap="nowrap" align="center" id="stikers_titu">FALTANTES</td>
      </tr>      
   <?php 
   //faltante por paquete
 $consulta_mysql="select Tbl_faltantes.int_inicial_f AS inicial, Tbl_faltantes.int_final_f AS final
                     from Tbl_faltantes  WHERE Tbl_faltantes.id_op_f='$op_gen' and Tbl_faltantes.int_paquete_f = '$paq_gen' and Tbl_faltantes.int_caja_f= '$caja_gen'";
 $resultado_consulta_mysql=mysql_query($consulta_mysql);
  //Navegamos cada fila que devuelve la consulta mysql y la imprimimos en pantalla
 while($fila=mysql_fetch_array($resultado_consulta_mysql)){
  $inicio=$fila['inicial']; $final=$fila['final'];
  
  ?> 
     <tr>
    <td colspan="4" id="stikers_fuentN2"><?php echo $inicio; ?> - <?php echo $final; ?></td>
    </tr>
     <?php 
 }
	 }?>-->
</table>
 </div><script type="text/javascript" async="async">
function cerrar() {
  //setTimeout(function() {
   // window.close();
   // }, 100); 
     // window.onload = cerrar();
	window.close();
 }
 </script>
<!--<div id="oculto">
<table width="100%" height="100%" border="0" align="center">
  <tr>
    <td><input name="cerrar" type="button" autofocus value="cerrar"onClick="cerrar('seleccion');return false" ></td>
  </tr>
</table>
</div>-->
 </body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($vista_faltantes);
mysql_free_result($vista_paquete);
mysql_free_result($existe_falt);

?>
