<?php require_once('../Connections/conexion1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE movi SET Clase=%s, Nro_Voucher=%s, Codigo=%s, Cantidad=%s WHERE Almacen=%s",
                       GetSQLValueString($_POST['Clase'], "text"),
                       GetSQLValueString($_POST['Nro_Voucher'], "int"),
                       GetSQLValueString($_POST['Codigo'], "text"),
                       GetSQLValueString($_POST['Cantidad'], "double"),
                       GetSQLValueString($_POST['Almacen'], "text"));

  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($updateSQL, $conexion1) or die(mysql_error());

  $updateGoTo = "salida.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conexion1, $conexion1);
$query_salida = "SELECT * FROM movi WHERE movi.Codigo";
$salida = mysql_query($query_salida, $conexion1) or die(mysql_error());
$row_salida = mysql_fetch_assoc($salida);
$totalRows_salida = mysql_num_rows($salida);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Almacen:</td>
      <td><?php echo $row_salida['Almacen']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Clase:</td>
      <td><input type="text" name="Clase" value="<?php echo htmlentities($row_salida['Clase'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nro_Voucher:</td>
      <td><input type="text" name="Nro_Voucher" value="<?php echo htmlentities($row_salida['Nro_Voucher'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codigo:</td>
      <td><input type="text" name="Codigo" value="<?php echo htmlentities($row_salida['Codigo'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cantidad:</td>
      <td><input type="text" name="Cantidad" value="<?php echo htmlentities($row_salida['Cantidad'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Almacen" value="<?php echo $row_salida['Almacen']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($salida);
?>
