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

<?php
// declarando las variables provenientes desde abono.php
$modelo = $_POST['modelo'];
$fecha = $_POST['fecha'];
$abono = $_POST['abono'];
$serial = $_POST['serial'];
//$horas_diferencia=0;
//$tiempo=time() + ($horas_diferencia * 60 *60);
//$fecha = date('Y-m-d H:i:s',$tiempo);   

// $ini es un contador, iniciado en cero, inserta los datos ingresados en abono.php hasta que sea igual al numero de cantidades.
$ini = 0 ;

    $modelo = $modelo[$ini];
	$cliente = $cliente[$ini];
	$fecha = $fecha[$ini];
	$abono = $abono[$ini];
	$serial = $serial[$ini];
	
//$des = ucwords($des[$ini]);//Primera Letra de cada palabra en Mayusculas
//$articulo = ucwords($articulo);//Primera Letra de cada palabra en Mayusculas
	
$sql_insert = "INSERT INTO abonos (abono_fecha, abono_modelo, abono_valor, abono_serial, abono_cliente) VALUES ('$fecha', '$modelo', '$abono', '$serial', '$cliente')";
//$sql_ganancia = "UPDATE mov_servicios, equipos SET ganancia = '$publico' - base WHERE serv_fecha = '$fecha' AND modelo = '$modelo'";
//$sql_qty = "UPDATE equipos SET cantidad = cantidad - '$qty' WHERE modelo = '$modelo'";
//$sql_base = "UPDATE equipos, mov_servicios SET base = base - '$publico' + '$publico' WHERE serv_modelo = '$modelo'";
//$sql_pago = "UPDATE mov_servicios SET ganancia = ganancia - '$pago' WHERE serv_fecha = '$fecha'";
$sql_abono = "UPDATE equipos SET publico = publico - '$abono' WHERE modelo = '$modelo' AND serial = '$serial'";
//$sql_mora = "UPDATE servicios SET g_total = g_total + '$publico' - '$pago'";
	                                
	mysql_query($sql_insert) or die(mysql_error(). " Query: " . $sql_insert);
	//mysql_query($sql_ganancia)or die(mysql_error(). " Query: " . $sql_ganancia);
	//mysql_query($sql_qty)or die(mysql_error(). " Query: " . $sql_qty);
	//mysql_query($sql_base)or die(mysql_error(). " Query: " . $sql_base);
	//mysql_query($sql_pago)or die(mysql_error(). " Query: " . $sql_pago);
	mysql_query($sql_abono)or die(mysql_error(). " Query: " . $sql_abono);
	//mysql_query($sql_mora)or die(mysql_error(). " Query: " . $sql_mora);
	$ini++ ;
	
	echo '<div align="center">Lo operacion ha resultado satisfactoria</div>';

?>

</body>
</html>



