<?php require_once('Connections/conexion1.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "usuario.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_conexion1, $conexion1);
$query_cliente = "SELECT * FROM cliente ORDER BY nombre_c ASC";
$cliente = mysql_query($query_cliente, $conexion1) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

//AQUI EMPIEZA EL CODIGO PARA EVALUAR LOS TRES FILTROS ENVIADOS POR GET
mysql_select_db($database_conexion1, $conexion1);
$estado_c = $_GET['estado_c'];
$tipo_c = $_GET['tipo_c'];
$revisado_c = $_GET['revisado_c'];
	   echo "estado: $estado_c ";
      echo "tipo: $tipo_c ";
      echo "revisado: $revisado_c ";
/*$n_cotiz = $_GET['estado_c'];
$id_c = $_GET['tipo_c'];
$fecha = $_GET['revisado_c'];*/
//Filtra todos vacios
/*if($estado_c == '0' && $tipo_c == '0' && $revisado_c == '0')
{
$query_cotizacion = "SELECT * FROM cliente ORDER BY id_c ASC";
}
//Filtra estado lleno
if($estado_c != '0' && $tipo_c == '0' && $revisado_c == '0')
{
$query_cotizacion = "SELECT * FROM cliente WHERE estado_c='$estado_c' ORDER BY estado_c DESC";
}
//Filtra tipo_c lleno
if($tipo_c != '0' && $estado_c == '0' && $revisado_c == '0')
{
$query_cotizacion = "SELECT * FROM cliente WHERE id_c='$id_c' ORDER BY tipo_c DESC";
}
//Filtra fecha lleno
if($revisado != '0' && $tipo_c == '0' && $estado_c == '0'  )
{
$query_cotizacion = "SELECT * FROM cliente WHERE revisado_c = '$revisado_c' ORDER BY revisado_c DESC";
}*/
/*//Filtra fecha y cliente lleno
if($fecha != '0' && $id_c != '0' && $n_cotiz == '0'  )
{
$fecha1 = "$fecha-01-01";
$fecha2 = $fecha + 1;
$fecha2 = "$fecha2-01-01";
$query_cotizacion = "SELECT * FROM cotizacion WHERE id_c_cotiz='$id_c' and fecha_cotiz >= '$fecha1' and fecha_cotiz < '$fecha2' ORDER BY n_cotiz DESC";
}
//Filtra cotizacion y fecha lleno
if($n_cotiz != '0' && $fecha != '0' && $id_c == '0')
{
$fecha1 = "$fecha-01-01";
$fecha2 = $fecha + 1;
$fecha2 = "$fecha2-01-01";
$query_cotizacion = "SELECT * FROM cotizacion WHERE n_cotiz='$n_cotiz' and fecha_cotiz >= '$fecha1' and fecha_cotiz < '$fecha2' ORDER BY n_cotiz DESC";
}
//Filtra cotizacion y cliente lleno
if($n_cotiz != '0' && $id_c != '0' && $fecha == '0')
{
$query_cotizacion = "SELECT * FROM cotizacion WHERE n_cotiz='$n_cotiz' and id_c_cotiz='$id_c' ORDER BY n_cotiz DESC";
}
//Filtra Todos llenos
if($n_cotiz != '0' && $id_c != '0' && $fecha != '0')
{
$fecha1 = "$fecha-01-01";
$fecha2 = $fecha + 1;
$fecha2 = "$fecha2-01-01";
$query_cotizacion = "SELECT * FROM cotizacion WHERE n_cotiz='$n_cotiz' and id_c_cotiz='$id_c' and fecha_cotiz >= '$fecha1' and fecha_cotiz < '$fecha2' ORDER BY n_cotiz DESC";
}*/

//AQUITERMINA LA EVALUACION DE LOS TRES FILTROS
//CONSULTA AGREGADA PARA EL FILTRO POR ESTADO
mysql_select_db($database_conexion1, $conexion1);
$query_numero = "SELECT * FROM cliente ORDER BY estado_c ASC";
$numero = mysql_query($query_numero, $conexion1) or die(mysql_error());
$row_numero = mysql_fetch_assoc($numero);
$totalRows_numero = mysql_num_rows($numero);
//CONSULTA AGREGADA PARA EL FILTRO POR TIPO CLIENTE
mysql_select_db($database_conexion1, $conexion1);
$query_t_cliente = "SELECT * FROM cliente ORDER BY tipo_c ASC";
$t_cliente = mysql_query($query_t_cliente, $conexion1) or die(mysql_error());
$row_t_cliente = mysql_fetch_assoc($t_cliente);
$totalRows_t_cliente = mysql_num_rows($t_cliente);
//CONSULTA AGREGADA PARA EL FILTRO POR ASESOR
mysql_select_db($database_conexion1, $conexion1);
$query_ano = "SELECT * FROM cliente ORDER BY revisado_c ASC";
$ano = mysql_query($query_ano, $conexion1) or die(mysql_error());
$row_ano = mysql_fetch_assoc($ano);
$totalRows_ano = mysql_num_rows($ano);
//AQUI TERMINA PRUEBA
?>
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<link rel="StyleSheet" href="css/general.css" type="text/css">
<script type="text/javascript" src="js/listado.js"></script>
</head>
<table></tr>
      <td id="subtitulo3">
<form action="listado_clientes3.php" method="GET" name="consulta">
<table id="tabla1">
<tr>
  <td colspan="3" id="fuente2"><select name="estado_c" id="estado_c">
    <option value="0">Estado</option>
    <?php
do {  
?><option value="<?php echo $row_numero ['id_c']?>"><?php echo $row_numero['estado_c']?></option>
    <?php
} while ($row_numero = mysql_fetch_assoc($numero));
  $rows = mysql_num_rows($numero);
  if($rows > 0) {
      mysql_data_seek($numero, 0);
	  $row_numero = mysql_fetch_assoc($numero);
  }
?>
    </select><select name="tipo_c" id="tipo_c">
      <option value="0">Tipo Cliente</option>
      <?php
do {  
?>
      <option value="<?php echo $row_t_cliente['id_c']?>"><?php echo $row_t_cliente['tipo_c']?></option>
      <?php
} while ($row_t_cliente = mysql_fetch_assoc($t_cliente));
  $rows = mysql_num_rows($t_cliente);
  if($rows > 0) {
      mysql_data_seek($t_cliente, 0);
	  $row_t_cliente = mysql_fetch_assoc($t_cliente);
  }
?>
    </select><select name="revisado_c" id="revisado_c">
      <option value="0">Asesor</option>
      <?php
do {  
?>
      <option value="<?php echo $row_ano['id_c']?>"><?php echo $row_ano['revisado_c']?></option>
      <?php
} while ($row_ano = mysql_fetch_assoc($ano));
  $rows = mysql_num_rows($ano);
  if($rows > 0) {
      mysql_data_seek($ano, 0);
	  $row_ano = mysql_fetch_assoc($ano);
  }
?>
    </select><input type="submit" name="Submit" value="FILTRO" onClick="if(consulta.estado_c.value=='0' && consulta.tipo_c.value=='0' && consulta.revisado_c.value=='0') { alert('DEBE SELECCIONAR UNA OPCION'); }"/></td>
  </tr>
</table>
<?php
 if(isset($estado_c)||  isset($tipo_c)|| isset($revisado_c))?>
<body><div align="center">
<table id="tabla_listado"><?php do { ?>     
      <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#ECF5FF');" bgcolor="#ECF5FF" bordercolor="#ACCFE8">
	  <td class="Estilo3"> <a href="perfil_cliente_vista.php?id_c= <?php echo $row_numero['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_top" style="text-decoration:none; color:#000000"> <?php if($row_numero['estado_c']== $estado_c){ echo $row_numero['estado_c']?> / <?php echo $row_numero['nombre_c'];} else {echo $row_numero['nombre_c'];}?></a> </td>
      <td class="Estilo3"> <a href="perfil_cliente_vista.php?id_c= <?php echo $row_cliente['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_cliente['contacto_c']; ?> </a> </td>
      <td class="Estilo3"> <a href="perfil_cliente_vista.php?id_c= <?php echo $row_cliente['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_cliente['direccion_c']; ?></a></td>
      <td class="Estilo4"> <a href="perfil_cliente_vista.php?id_c= <?php echo $row_cliente['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_cliente['pais_c']; ?> / <?php echo $row_cliente['ciudad_c']; ?> </a> </td>
      <td class="Estilo4"><a href="perfil_cliente_vista.php?id_c= <?php echo $row_cliente['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $row_cliente['telefono_c']; ?></a></td>
      <td class="Estilo4"><a href="perfil_cliente_vista.php?id_c= <?php echo $row_cliente['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $row_cliente['fax_c']; ?></a></td>
      <td class="Estilo6">
	  <?php if($row_numero['bolsa_plastica_c']=='1') { echo "B"; } ?>
	  <?php if($row_numero['lamina_c']=='1') { echo "  L"; } ?>
	  <?php if($row_numero['cinta_c']=='1') { echo "  C"; } ?>
	  <?php if($row_numero['packing_list_c']=='1') { echo " P"; } ?>
      </td>
      </tr>
    <?php } while ($row_numero = mysql_fetch_assoc($numero)); ?>
</table></div>
</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($cliente);
?>
