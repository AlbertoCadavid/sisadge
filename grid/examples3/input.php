<?php require_once('conexion1.php'); ?>
<?php 
$colname_rp= "-1";
if (isset($_GET['id_op'])) {
  $colname_rp = (get_magic_quotes_gpc()) ? $_GET['id_op'] : addslashes($_GET['id_op']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_consulta = "SELECT * FROM empleados WHERE nombre='$colname_rp'";
$consulta = mysql_query($query_consulta, $conexion1) or die(mysql_error());
$row_consulta = mysql_fetch_assoc($consulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<form name="nuevo_empleado" action="" onsubmit="enviarDatosEmpleado(); return false">
			<h2>Nuevo Usuario</h2>
				<table>
                <tr>
                	<td>Nombres</td><td><label><input name="nombre" type="text" value="<?php echo $row_consulta['nombre']; ?>"/></label></td>
               	</tr>
                <tr>
					<td>Apellido</td><td><label><input type="text" name="apellido" value="<?php echo $row_consulta['apellido']; ?>"></label></td>
				</tr>
                <tr>
                    <td>Web</td><td><label><input name="web" type="text"  value="<?php echo $row_consulta['web']; ?>" /></label></td>
				</tr>
                <tr>
                   	<td>&nbsp;</td><td><label><input type="submit" name="Submit" value="Grabar" /></label></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                   	<td></td>
                    </tr>
                </table>
		</form>
</body>
</html>