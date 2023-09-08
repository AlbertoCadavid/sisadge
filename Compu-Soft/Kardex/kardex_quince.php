<?   
session_start();   
if(!isset($_SESSION['s_username']))header("location: ../res.php");  
echo "Bienvenido <b>".$_SESSION['s_username']."</b> <a href=\"../logout.php\">Cerrar Sesion</a>";  
?>
<?php require '../conectar.php'; ?>
<?php require '../info.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compu-Soft</title>

<link href="../menu.css" rel="stylesheet" type="text/css" />
<link href="../form2.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="principal">

  <div id="cabecera"> 
    <div id="titulo"> 
      <center>
      <h1>Compu-Soft</h1>
      </center>
    </div>
  </div>
  
<div id="menu">
<ul>
   <li><a href="/Compu-Soft/index.php">Inicio</a> 
    </li>
    <li><a href="#">Articulos</a> 
      <ul>
        <li><a href="/Compu-Soft/Registros/r_articulos.php">Nuevo Articulo</a></li>
		<li><a href="/Compu-Soft/Registros/nuevo_ingreso.php">Ingreso De Articulos</a></li>
		<li><a href="/Compu-Soft/Registros/nueva_salida.php">Salida De Articulos</a></li>
		<li><a href="/Compu-Soft/Movimientos/movimiento_compu.php">Ver Movimientos</a></li>
		<li><a href="/Compu-Soft/Borrar/borrar_movimiento.php">Borrar Movimientos</a></li>
		<li><a href="/Compu-Soft/Buscar/buscar_art.php">Buscar Articulos</a></li>
		<li><a href="/Compu-Soft/Borrar/borrar_art.php">Borrar Articulos</a></li>
        </ul>
    </li>
	<li><a href="#">Ventas Y Servicios</a> 
      <ul>
        <li><a href="/Compu-Soft/Registros/mov.php">Ventas Y Servicios</a></li>
		<li><a href="/Compu-Soft/Registros/abono.php">Abonos</a></li>
		<li><a href="/Compu-Soft/Movimientos/movimiento_abono.php">Ver Abonos</a></li>
		<li><a href="/Compu-Soft/Borrar/borrar_vs.php">Borrar Movimientos</a></li>
		<li><a href="/Compu-Soft/Registros/act_valor.php">Actualizar Precio Base</a></li>
       </ul>
    </li>
	<li><a href="#">Kardex</a> 
      <ul>
	    <li><a href="/Compu-Soft/Kardex/kardex.php">Kardex Diario</a></li>
        <li><a href="/Compu-Soft/Kardex/kardex_semanal.php">Kardex Semanal</a></li>
		<li><a href="/Compu-Soft/Kardex/kardex_quince.php">Kardex Quincenal</a></li>
		<li><a href="/Compu-Soft/Kardex/kardex_mensual.php">Kardex Mensual</a></li>
		<li><a href="/Compu-Soft/Kardex/kardex_tipo.php">Kardex Movimiento</a></li>
	 </ul>
    </li>
	<li><a href="#">Copia De Seguridad</a> 
      <ul>
        <li><a href="/Compu-Soft/Backup/backup.php">Realizar Copia</a></li>
        </ul>
    </li>
	<li><a href="/Compu-Soft/creditos.php">Acerca De</a>
    </li>
    </ul>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>

<?php
//comenzamos la consulta de los movimientos de articulos
$query_movimiento = ("SELECT * FROM mov_servicios, equipos WHERE modelo = serv_modelo AND serv_fecha > DATE_SUB(CURDATE(), INTERVAL 15 DAY) ORDER BY serv_fecha DESC");//mov_fecha > DATE_SUB( CURDATE( ) , INTERVAL DAYOFMONTH( CURDATE( ) )DAY ) ORDER BY mov_fecha DESC");
$movimiento = mysql_query($query_movimiento) or die ( "Error en query: $sql, el error  es: " . mysql_error() );//(mysql_error());
$row_movimiento = mysql_fetch_assoc($movimiento);
//terminamos la consulta de los movimientos de articulos
?>

<center>
<table style="border:1px #FF0000; color:#000000; width:980px; text-align:center;">
<tr style="background:#FFD700;">
    <td><b>Modelo</b></td>
	<td><b>Serial</b></td>
	<td><b>Cantidad Actual</b></td>
	<td><b>Tipo De Movimiento</b></td>
	<td><b>Fecha Movimiento</b></td>
	<td><b>Precio Base</b></td>
	<td><b>Precio Publico</b></td>
	<td><b>Pagos</b></td>
	<td><b>Ganancia</b></td>
</tr>
  <?php do { ?>
    <tr bgcolor='#FFFACD'>
  	  <td><?php echo $row_movimiento['serv_modelo']; ?></td>
	  <td><?php echo $row_movimiento['serv_serial']; ?></td>
	  <td><?php echo $row_movimiento['cantidad']; ?></td>
	  <td><?php echo $row_movimiento['serv_tipo']; ?></td>
	  <td><?php echo $row_movimiento['serv_fecha']; ?></td>
	  <td><?php echo $row_movimiento['base']; ?></td>
	  <td><?php echo $row_movimiento['serv_pub']; ?></td>
	  <td><?php echo $row_movimiento['serv_pago']; ?></td>
	  <td><?php echo $row_movimiento['ganancia']; ?></td>
    </tr>
    <?php 
	$total += $row_movimiento['ganancia'];
	$total1 += $row_movimiento['serv_pub'];
	$total2 += $row_movimiento['serv_pago'];
	$total3 += $row_movimiento['base'];
	      //mostramos los resultados de la busqueda
	      } while ($row_movimiento= mysql_fetch_assoc($movimiento)); ?>
	<tr>
	    <td><b></b></td>
		<td><b></b></td>
		<td><b></b></td>
		<td><b></b></td>
		<td style="background:#FFD700;"><b><?php echo "Totales:"; ?></b></td>
		<td style="background:#FFD700;"><b><?php echo "$total3"; ?></b></td>
		<td style="background:#FFD700;"><b><?php echo "$total1"; ?></b></td>
		<td style="background:#FFD700;"><b><?php echo "$total2"; ?></b></td>
		<td style="background:#FFD700;"><b><?php echo "$total"; ?></b></td>
	</tr>

</table>
</center>
<?php mysql_free_result($movimiento); ?>