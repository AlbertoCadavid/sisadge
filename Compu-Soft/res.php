<?php

session_start();
  
  require 'conectar.php';
  
  if ($_POST['username']) {
//Comprobacion del envio del nombre de usuario y password
$username=$_POST['username'];
$password=$_POST['password'];
if ($password==NULL) {
echo "Password Invalido";
}else{
$query = mysql_query("SELECT username,password FROM users WHERE username = '$username'") or die(mysql_error());
$data = mysql_fetch_array($query);
if($data['password'] != $password) {
echo "Datos Incorrectos. Por Favor Intenta De Nuevo.";
}else{
$query = mysql_query("SELECT username,password FROM users WHERE username = '$username'") or die(mysql_error());
$row = mysql_fetch_array($query);
$_SESSION["s_username"] = $row['username'];
echo "Bienvenido <b>".$_SESSION['s_username']."</b> <a href=\"logout.php\">Cerrar Sesion</a>";
}
}
}  
?>
<?php require 'info.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIGFA</title>

<link href="menu.css" rel="stylesheet" type="text/css" />
<link href="form2.css" rel="stylesheet" type="text/css" />
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
   <li><a href="../Compu-Soft/index.php">Inicio</a> 
    </li>
    <li><a href="#">Articulos</a> 
      <ul>
        <li><a href="../Compu-Soft/Registros/r_articulos.php">Nuevo Articulo</a></li>
		<li><a href="../Compu-Soft/Registros/nuevo_ingreso.php">Ingreso De Articulos</a></li>
		<li><a href="../Compu-Soft/Registros/nueva_salida.php">Salida De Articulos</a></li>
		<li><a href="../Compu-Soft/Movimientos/movimiento_compu.php">Ver Movimientos</a></li>
		<li><a href="../Compu-Soft/Borrar/borrar_movimiento.php">Borrar Movimientos</a></li>
		<li><a href="../Compu-Soft/Buscar/buscar_art.php">Buscar Articulos</a></li>
		<li><a href="../Compu-Soft/Borrar/borrar_art.php">Borrar Articulos</a></li>
        </ul>
    </li>
	<li><a href="#">Ventas Y Servicios</a> 
      <ul>
        <li><a href="../Compu-Soft/Registros/mov.php">Ventas Y Servicios</a></li>
		<li><a href="../Compu-Soft/Registros/abono.php">Abonos</a></li>
		<li><a href="../Compu-Soft/Movimientos/movimiento_abono.php">Ver Abonos</a></li>
		<li><a href="../Compu-Soft/Borrar/borrar_vs.php">Borrar Movimientos</a></li>
		<li><a href="../Compu-Soft/Registros/act_valor.php">Actualizar Precio Base</a></li>
       </ul>
    </li>
	<li><a href="#">Kardex</a> 
      <ul>
	    <li><a href="../Compu-Soft/Kardex/kardex.php">Kardex Diario</a></li>
        <li><a href="../Compu-Soft/Kardex/kardex_semanal.php">Kardex Semanal</a></li>
		<li><a href="../Compu-Soft/Kardex/kardex_quince.php">Kardex Quincenal</a></li>
		<li><a href="../Compu-Soft/Kardex/kardex_mensual.php">Kardex Mensual</a></li>
		<li><a href="../Compu-Soft/Kardex/kardex_tipo.php">Kardex Movimiento</a></li>
	 </ul>
    </li>
	<li><a href="../Compu-Soft/creditos.php">Acerca De</a>
    </li>
    </ul>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<center>
<?php
echo "No Estas Autorizado, Por Favor Ingresa Tus Datos Para Acceder Al Sistema.";
echo '<br />';
echo '<br />';
    // provee el formulario para hacer  log in
    echo "<form method=post action=\"res.php\">";
    echo "<table>";
    echo "<tr><td><b>Usuario:</b></td>";
    echo "<td><input type=text name=username></td></tr>";
    echo "<tr><td><b>Password:</b></td>";
    echo "<td><input type=password name=password></td></tr>";
    echo "<tr><td colspan=2 align=center><br>";
    echo "<input type=submit value=\"Ingresar\"></td></tr>";
    echo "</table></form>";
  
?>
</center>
</body>
</html>