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
<center>
<form action="buscar_art.php" method="get">
    <b>Busqueda De Articulos Por Marca</b><br><br>
    <input name="busqueda" type=text>
    <br>
    <input type=submit value="Buscar">
  </form>
  
  
 <?php
 //iniciamos buscador 
trim($busqueda); //Evitar espacios en blanco en la busqueda

if (!$busqueda)
  {
   //  echo "No se ha ingresado ningun valor a buscar";
     exit;
  }

  $busqueda = addslashes($busqueda); //Marca una cadena con barras
  
  //comenzamos la consulta 
  $consulta = "SELECT * FROM equipos WHERE marca like '%".$busqueda."%' ORDER BY marca ASC";
  $resultado = mysql_query($consulta) or die(mysql_error());

?>

<table style="border:1px #FF0000; color:#000000; width:990px; text-align:center;">
<tr style="background:#FFD700;">
    <td>Marca</td>
	<td>Modelo</td>
	<td>Serial</td>
	<td>Proveedor</td>
	<td>Cliente</td>
	<td>Direccion</td>
	<td>Telefono</td>
	<td>Garantia</td>
	<td>Cantidad</td>
	<td>Precio</td>
	<td>Fecha Ingreso</td>
	</tr> 

<?php  
  //mostramos los resultados
     while($row = mysql_fetch_array($resultado)){
     echo "<tr bgcolor='#FFFACD'>";
	 //echo " 		<td><a style=\"text-decoration:underline;cursor:pointer;\" onclick=\"pedirDatos('".$row['cli_id']."')\">".$row['cli_id']."</a></td>";
     echo " 		<td>".stripslashes($row["marca"])."</td>";
	 echo " 		<td>".stripslashes($row["modelo"])."</td>";
	 echo " 		<td>".stripslashes($row["serial"])."</td>";
	 echo " 		<td>".stripslashes($row["proveedor"])."</td>";
	 echo " 		<td>".stripslashes($row["cliente"])."</td>";
	 echo " 		<td>".stripslashes($row["dir"])."</td>";
	 echo " 		<td>".stripslashes($row["tel"])."</td>";
	 echo " 		<td>".stripslashes($row["garantia"])."</td>";
	 echo " 		<td>".stripslashes($row["cantidad"])."</td>";
	 echo " 		<td>".stripslashes($row["publico"])."</td>";
	 echo " 		<td>".stripslashes($row["fecha"])."</td>";
     echo "</tr>";
	 //echo "<br />";
	 
  }
?>

</table><br />
<div id="formulario" style="display:none;"></div>
<div id="resultado"></div>
</center>
</body>
</html> 
<?php mysql_free_result($resultado); ?>
