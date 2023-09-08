<?   
session_start();   
if(!isset($_SESSION['s_username']))header("location: ../res.php");  
echo "Bienvenido <b>".$_SESSION['s_username']."</b> <a href=\"../logout.php\">Cerrar Sesion</a>";  
?>
<?php require '../conectar.php'; ?>
<?php require '../info.php'; ?>
<?php

$error = array(); //Validar Campos

// INICIO  construccion de la consulta con los CLIENTES-->
	      $sql_celular = "SELECT `modelo` FROM `equipos`"; 
	      $result_celular = mysql_query($sql_celular)or die(mysql_error()); 
	      $options_celular = ''; 
	    while ($row_celular = mysql_fetch_array($result_celular))
		{	$options_celular = $options_celular.'<option value="'.$row_celular['modelo'].'">'.'</option>'; } 
// FIN  construccion de la consulta con los CLIENTES-->

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formulario")) {

$_POST['modelo']= trim($_POST['modelo']); //Trim, borrar espacios al inicio y final
$_POST['marca']= trim($_POST['marca']);
$_POST['proveedor']= trim($_POST['proveedor']);
$_POST['cantidad']= trim($_POST['cantidad']);
$_POST['garantia']= trim($_POST['garantia']);
$_POST['des']= trim($_POST['des']);
$_POST['base']= trim($_POST['base']);
$_POST['cliente']= trim($_POST['cliente']);
$_POST['publico']= trim($_POST['publico']);
$_POST['dir']= trim($_POST['dir']);
$_POST['tel']= trim($_POST['tel']);
$_POST['serial']= trim($_POST['serial']);//Trim, borrar espacios al inicio y final

$modelo = ucwords($modelo);//Primera Letra de cada palabra en Mayusculas
$marca = ucwords($marca);
$proveedor = ucwords($proveedor);
$garantia = ucwords($garantia);
$cliente = ucwords($cliente);
$dir = ucwords($dir);
$des = ucwords($des);//Primera Letra de cada palabra en Mayusculas

if(empty($_POST['modelo'])){ //Validar Campos
$error['modelo']= 'El Campo Modelo No Se Puede Dejar Vacio';
}
if(empty($_POST['marca'])){
$error['marca']= 'El Campo Marca No Se Puede Dejar Vacio';
}
if(empty($_POST['base'])){
$error['base']= 'El Campo Precio Base No Se Puede Dejar Vacio';
}
if(empty($_POST['cantidad'])){
$error['cantidad']= 'El Campo Cantidad No Se Puede Dejar Vacio';
}
/*if(empty($_POST['garantia'])){
$error['garantia']= 'El Campo Garantia No Se Puede Dejar Vacio';
}*///Validar Campos

if(!$error){ //Validar Campos

  $SQL = "INSERT INTO equipos (modelo, marca, proveedor, cantidad, des, fecha, garantia, serial, base, publico, cliente, dir, tel) VALUES ('$modelo', '$marca', '$proveedor', '$cantidad', '$des', '$fecha', '$garantia', '$serial', '$base', '$publico', '$cliente', '$dir', '$tel')";
                 
   $Result = mysql_query($SQL) or die ( "<center>El Equipo Ya Existe!!! <br><a href=\"javascript:history.back()\">Regresar</a></center>");//or die(mysql_error());
echo "<script language='JavaScript'> alert('La operacion ha resultado satisfactoria'); </script>";
}
} //Validar Campos
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compu-Soft</title>

<link href="../menu.css" rel="stylesheet" type="text/css" />
<link href="../form.css" rel="stylesheet" type="text/css" />
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

	<form method="POST" action="" name="formulario" id="formulario">
	<fieldset>
		<legend>Nuevo Articulo</legend>

		<label><b>Marca:</b>
		<input value="<? echo $_POST['marca'] ?>" name="marca" type="text" /></label>
		<label><b>Modelo:</b>
		<input value="<? echo $_POST['modelo'] ?>" name="modelo" type="text" /></label>
		<label><b>Serial:</b>
		<input value="<? echo $_POST['serial'] ?>" name="serial" type="text" /></label>
		<label><b>Cantidad:</b>
		<input value="<? echo $_POST['cantidad'] ?>" name="cantidad" type="text" /></label> 
		<label><b>Precio Base:</b>
       <input value="<? echo $_POST['base'] ?>" name="base" type="text" /></label>
	   <label><b>Precio Publico:</b>
       <input value="<? echo $_POST['publico'] ?>" name="publico" type="text" /></label>
       <label><b>Proveedor:</b>
       <input value="<? echo $_POST['proveedor'] ?>" name="proveedor" type="text" /></label>
       <label><b>Cliente:</b>
       <input value="<? echo $_POST['cliente'] ?>" name="cliente" type="text" /></label>	   
       	<label><b>Direccion:</b>
		<input value="<? echo $_POST['dir'] ?>" name="dir" type="text" /></label>
		<label><b>Telefono:</b>
		<input value="<? echo $_POST['tel'] ?>" name="tel" type="text" /></label>
		<label><b>Garantia:</b>
		<input value="<? echo $_POST['garantia'] ?>" name="garantia" type="text" /></label>
		<label><b>Fecha De Ingreso:</b>
        <input value="<? echo date("Y-m-d h:i:s A"); ?>" name="fecha" type="text" /></label><br />
		<label for="enviar"></label>
        <input type="submit" name="enviar" id="enviar" value="Grabar" class="uno"/>
        <input type="reset" name="borrar" id="borrar" value="Borrar Formulario" class="uno"/>
        <label for="borrar"></label>
        </fieldset>
    <input type="hidden" name="MM_insert" value="formulario" />
</form>

 
<?php if ($error) { //validar campos
?>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php
foreach ($error as $alerta) {
    echo "<script language='JavaScript'> alert('$alerta'); </script>";
	}
} //validar campos

?>

</body>
</html>

