<?php require_once('./Connections/conexion1.php'); ?>
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
  $updateSQL = sprintf("UPDATE stock SET Almacen=%s, StockActual=%s WHERE Codigo=%s",
                       GetSQLValueString($_POST['Almacen'], "text"),
                       GetSQLValueString($_POST['StockActual'], "double"),
                       GetSQLValueString($_POST['Codigo'], "text"));

  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($updateSQL, $conexion1) or die(mysql_error());

  $updateGoTo = "update.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conexion1, $conexion1);
$query_actualiza_stock = "SELECT * FROM stock WHERE stock.Codigo ORDER BY stock.Codigo";
$actualiza_stock = mysql_query($query_actualiza_stock, $conexion1) or die(mysql_error());
$row_actualiza_stock = mysql_fetch_assoc($actualiza_stock);
$totalRows_actualiza_stock = mysql_num_rows($actualiza_stock);
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
      <td><input type="text" name="Almacen" value="<?php echo htmlentities($row_actualiza_stock['Almacen'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Codigo:</td>
      <td><?php echo $row_actualiza_stock['Codigo']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">StockActual:</td>
      <td><input type="text" name="StockActual" value="<?php echo htmlentities($row_actualiza_stock['StockActual'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Codigo" value="<?php echo $row_actualiza_stock['Codigo']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($actualiza_stock);
?>
