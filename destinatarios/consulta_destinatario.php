<?php require_once('Connections/conexion1.php'); ?>
<?php
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/formato.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
mysql_select_db($database_conexion1, $conexion1);
// DATOS
$nit_c=$_GET["nit_c"];
$nit=$_GET["nit"];
$cod_ref_cn=$_GET["cod_ref_cn"];
$id_c=$_GET['id_c'];
//CLIENTE
if ($nit!='')
{
$resultado = mysql_query("SELECT * FROM Tbl_Destinatarios WHERE nit= '".$_GET["nit"]."'");
if (mysql_num_rows($resultado) > 0)
{ ?> <div id="numero1"><strong> <?php echo "EL NIT EXISTE, FAVOR HACER REVISION"; ?> </strong></div> <?php }
else 
{ ?> <div id="acceso1"><strong> <?php echo "NIT VALIDADO, PUEDE CONTINUAR REGISTRANDO"; ?> </strong></div> <?php }
}
// DATOS CLIENTE
if ($nit!='') 
{ 
$resultcli = mysql_query("SELECT * FROM Tbl_destinatarios WHERE nit = '$nit'");
$row_destinatarios = mysql_fetch_assoc($resultcli);
$totalRows_destinatarios  = mysql_num_rows($resultcli);
if ($totalRows_destinatarios  > 0)
{ ?>
<table id="tabla1">
  <tr>
    <td id="detalle1">NIT : <?php echo $row_destinatarios ['nit']; ?></td>
    <td id="detalle1">Telefono : <?php echo $row_destinatarios ['telefono']; ?></td>

  </tr>
  <tr>
    <td colspan="3" id="detalle1">Direcci&oacute;n : <?php echo $row_destinatarios ['direccion']; ?></td>
  </tr>
  <tr>
    <td id="detalle1">Ciudad : <?php echo $row_destinatarios ['ciudad']; ?></td>
    <td id="detalle1">responsable : <?php echo $row_destinatarios ['nombre_responsable']; ?></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan="3" id="detalle1">Para agregar el detalle de la cotizacion de click en siguiente </td>
  </tr>
</table>
<?php
}
else 
{ 
echo "NINGUN REGISTRO SELECCIONADO"; 
}
}
//REFERENCIA CLIENTE
if ($nit!='') 
{ 
$resultcli = mysql_query("SELECT * FROM Tbl_destinatarios WHERE nit = '$nit'");
$row_destinatarios = mysql_fetch_assoc($resultcli);
$totalRows_destinatarios = mysql_num_rows($resultcli);
if ($totalRows_destinatarios > 0)
{ ?>
<table id="tabla1">
  <tr>
    <td id="detalle1">NIT : <?php echo $row_destinatarios ['nit']; ?></td>
    <td id="detalle1">Telefono : <?php echo $row_destinatarios ['telefono']; ?></td>

  </tr>
  <tr>
    <td colspan="3" id="detalle1">Direcci&oacute;n : <?php echo $row_destinatarios ['direccion']; ?></td>
  </tr>
  <tr>
    <td id="detalle1">Ciudad : <?php echo $row_destinatarios ['ciudad']; ?></td>
    <td id="detalle1">responsable : <?php echo $row_destinatarios ['nombre_responsable']; ?></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan="3" id="detalle1">Para agregar el detalle de la cotizacion de click en siguiente </td>
  </tr>
</table>
<?php
}
else 
{ 
echo "NINGUN CLIENTE SELECCIONADO"; 
}
}
exit();
?>
</body>
</html>
<?php
mysql_free_result($usuario);
?>