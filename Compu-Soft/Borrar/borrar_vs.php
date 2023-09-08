<?   
session_start();   
if(!isset($_SESSION['s_username']))header("location: ../res.php");  
echo "Bienvenido <b>".$_SESSION['s_username']."</b> <a href=\"../logout.php\">Cerrar Sesion</a>";  
?>
<?php require '../info.php'; ?>
<?php  require '../conectar.php'; ?>

<?php
//inicio paginador
$registros = 20; 

$pagina = $_GET["pagina"];

if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else {
$inicio = ($pagina - 1) * $registros;
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistema Inventario</title>
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

<?php
//inicio borrado de registros
$nbrow = 0; //numero de registros
$cont = 0; //Para el checkbox

print "<form action ='borrar_vs.php' method='post'>";

//$result = mysql_query("SELECT * FROM clientes ORDER BY cli_nombre ASC");

//inicio consulta 
$resultados = mysql_query("SELECT * FROM mov_servicios WHERE 'visible' = 0");
$total_registros = mysql_num_rows($resultados) or die ( "<center>No Existen Registros!!! <br><a href=\"javascript:history.back()\">Regresar</a></center>"); //or die ( "Error en query: $sql, el error  es: " . mysql_error());
$resultados = mysql_query("SELECT * FROM mov_servicios WHERE 'visible' = 0 ORDER BY serv_fecha DESC LIMIT $inicio, $registros");
$total_paginas = ceil($total_registros / $registros); 
//fin consulta 
?>

<center>
<table style="border:1px #FF0000; color:#000000; width:990px; text-align:center;">
<tr style="background:#FFD700;">
<?php
echo "<td>Seleccionar</td><td>Item</td><td>Modelo</td><td>Tipo De Movimiento</td><td>Precio Publico</td><td>Pagos</td><td>Fecha De Movimiento</td> \n"; 
?>
</tr>

<?php
while($row=mysql_fetch_array($resultados))
{
$nbrow++;
$cont++;

$mov_id =$row["mov_id"];
$serv_tipo =$row["serv_tipo"];
$serv_modelo =$row["serv_modelo"];
$serv_pub = $row["serv_pub"];
$serv_pago =$row["serv_pago"];
$serv_fecha =$row["serv_fecha"];
print "<tr bgcolor='#FFFACD'> ";
print "<td><div align=\"center\"><font color=\"#000000\"><font face=\"Verdana\"><input type=\"checkbox\" name=\"delete[]\" value=\"".$mov_id."\"></font></font></div></td>";

print "<td> <div align=\"center\"><font color=\"#000000\"><font size=\"3\"><font face=\"Verdana\">$mov_id</font></font></div></td>";
print "<td> <div align=\"center\"><font color=\"#000000\"><font size=\"3\"><font face=\"Verdana\">$serv_modelo</font></font></div></td>";
print "<td> <div align=\"center\"><font color=\"#000000\"><font size=\"3\"><font face=\"Verdana\">$serv_tipo</font></font></div></td>";
print "<td> <div align=\"center\"><font color=\"#000000\"><font size=\"3\"><font face=\"Verdana\">$serv_pub</font></font></div></td>";
print "<td> <div align=\"center\"><font color=\"#000000\"><font size=\"3\"><font face=\"Verdana\">$serv_pago</font></font></div></td>";
print "<td> <div align=\"center\"><font color=\"#000000\"><font size=\"3\"><font face=\"Verdana\">$serv_fecha</font></font></div></td>";
print "</tr>";


}
print "</form> \n";
echo "</table> \n <p><p>";
print "<div align=\"center\"><input type='submit' name='borrar' value='Borrar'></div>";

if (count($_POST['delete']))
{
foreach ($_POST['delete'] as $v)
{
$sql="DELETE FROM mov_servicios WHERE mov_id = '$v'";
$res = mysql_query($sql);
}
}
//fin borrado de registros

//paginador
if(($pagina - 1) > 0) {
echo "<a href='borrar_vs.php?pagina=".($pagina-1)."'>< Anterior</a> ";
} 

for ($i=1; $i<=$total_paginas; $i++){
if ($pagina == $i) {
echo "<b>".$pagina."</b> ";
} else {
echo "<a href='borrar_vs.php?pagina=$i'>$i</a> ";
} }

if(($pagina + 1)<=$total_paginas) {
echo " <a href='borrar_vs.php?pagina=".($pagina+1)."'>Siguiente ></a>";
} 
//fin paginador
?> 
</center>
</table><br />
</body>
</html>
<?php mysql_free_result($resultados); ?>