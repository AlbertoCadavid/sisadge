<?php require_once('conexion1.php'); ?>
<?php

mysql_select_db($database_conexion1, $conexion1);
$query_sql = "SELECT * FROM empleados";
$sql = mysql_query($query_sql, $conexion1) or die(mysql_error());


//consulta todos los empleados

?>
<table style="color:#000099;width:400px;">
	<tr style="background:#9BB;">
		<td>Nombre</td>
		<td>Apellido</td>
		<td>Web</td>
	</tr>
<?php
  while($row = mysql_fetch_array($sql)){
  echo "<tr>";
  	echo "<td>".$row['nombre']."</td>";
  	echo "<td>".$row['apellido']."</td>";
    echo "<td>"?><a href="javascript:inputs('1','id_op','<?php $delrp=$row['nombre'];echo $delrp; ?>')"><?php echo $row['web']; ?></a></td><?php
  	echo "</tr>";
  }
?>
</table>