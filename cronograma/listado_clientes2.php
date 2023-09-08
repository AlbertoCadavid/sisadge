<?php require_once('Connections/conexion1.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "usuario.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

  /*Cuando un visitante se registra en este sitio, la variable de sesión MM_Username igual a su nombre de usuario.
   / / Por lo tanto, sabemos que un usuario no se registra en el caso de que la variable de sesión está en blanco.*/
  if (!empty($UserName)) { 
   //Además de estar conectado, se puede restringir el acceso sólo a ciertos usuarios basados ??en una identificación establecida al iniciar la sesión.
     // Analizar las cadenas en las matrices.
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    //O bien, puede restringir el acceso sólo a determinados usuarios en base a su nombre de usuario. 
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

//CONSULTA AGREGADA PARA EL FILTRO POR RAZON SOCIAL
mysql_select_db($database_conexion1, $conexion1);
$query_cliente = "SELECT * FROM cliente ORDER BY nombre_c ASC";
$cliente = mysql_query($query_cliente, $conexion1) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);
//CONSULTA AGREGADA PARA EL FILTRO POR ESTADO
mysql_select_db($database_conexion1, $conexion1);
$query_numero = "select distinct estado_c from cliente where estado_c is not null";
$numero = mysql_query($query_numero, $conexion1) or die(mysql_error());
$row_numero = mysql_fetch_assoc($numero);
$totalRows_numero = mysql_num_rows($numero);
//CONSULTA AGREGADA PARA EL FILTRO POR TIPO CLIENTE
mysql_select_db($database_conexion1, $conexion1);
$query_t_cliente = "select distinct tipo_c from cliente where tipo_c is not null";
$t_cliente = mysql_query($query_t_cliente, $conexion1) or die(mysql_error());
$row_t_cliente = mysql_fetch_assoc($t_cliente);
$totalRows_t_cliente = mysql_num_rows($t_cliente);
//CONSULTA AGREGADA PARA EL FILTRO POR ASESOR
mysql_select_db($database_conexion1, $conexion1);
$query_ano = "select distinct revisado_c from cliente where revisado_c is not null";
$ano = mysql_query($query_ano, $conexion1) or die(mysql_error());
$row_ano = mysql_fetch_assoc($ano);
$totalRows_ano = mysql_num_rows($ano);

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISADGE AC &amp; CIA</title>
<link rel="StyleSheet" href="css/general.css" type="text/css">
</head>
<body oncontextmenu="return false">
  <table id="tabla_formato"><tr><td>  
<table id="tabla_formato">
    <tr>
      <td width="30%" id="codigo_formato">CODIGO: R1 - F02</td>
      <td width="45%" id="titulo_formato">LISTADO MAESTRO DE CLIENTES </td>
      <td width="25%" id="codigo_formato">VERSION: 1 </td>
    </tr>
    <tr>
      <td height="28"width="45%" id="subtitulo3" >
    <FORM > 
    <SELECT NAME="lista" id="id_c">
    <option value="0">Seleccione una Razon Social</option>
     <?php do { ?>
    <OPTION VALUE="perfil_cliente_vista.php?id_c= <?php echo $row_cliente['id_c']; ?>&tipo_usuario=<?php echo $row_usuario['tipo_usuario']; ?>" target="_blank" style=" text-decoration:none; color:#000000"><?php echo $row_cliente['nombre_c']; ?><?php } while ($row_cliente = mysql_fetch_assoc($cliente)); ?> 
    </option>
    </SELECT> 
    <INPUT TYPE=button VALUE="OK" 
    onClick=
"window.top.location.href=this.form.lista.options[this.form.lista.selectedIndex].value "/> 
    <input name="campo" type="hidden" value=" " size="5" readonly><?php echo $totalRows_cliente;echo ' '?>Clientes
    </FORM>          
      </td> 
      
      
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
</form>
      </td>        
    </tr>    
</table>
<table id="tabla_borde_top">
  <tr>
    <td height="16" class="Estilo1">RAZON SOCIAL</td>
    <td class="Estilo1">CONTACTO</td>
    <td class="Estilo1">DIRECCION</td>
    <td class="Estilo2">PAIS/CIUDAD</td>
    <td class="Estilo2">TELEFONO</td>
    <td class="Estilo2">FAX</td>
    <td class="Estilo5">REF</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($numero);

mysql_free_result($cliente);

mysql_free_result($t_cliente);

mysql_free_result($ano);
?>
