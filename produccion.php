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
session_start();
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
$colname_usuario_comercial = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario_comercial = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario_comercial = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario_comercial);
$usuario_comercial = mysql_query($query_usuario_comercial, $conexion1) or die(mysql_error());
$row_usuario_comercial = mysql_fetch_assoc($usuario_comercial);
$totalRows_usuario_comercial = mysql_num_rows($usuario_comercial);

mysql_select_db($database_conexion1, $conexion1);
$query_ver_sub_menu = "SELECT * FROM submenu WHERE id_menu_submenu = '4'";
$ver_sub_menu = mysql_query($query_ver_sub_menu, $conexion1) or die(mysql_error());
$row_ver_sub_menu = mysql_fetch_assoc($ver_sub_menu);
$totalRows_ver_sub_menu = mysql_num_rows($ver_sub_menu);
?>
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="StyleSheet" href="css/imageMenu.css" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid" id="divconten"> 
        <div class="row">
         <div class="col-md-8" ><img src="images/cabecera.jpg" style="width: 100%;margin:10px 0px 10px;">
          </div>
          <div class="col-md-4"> 
            <div class="menu2"><ul>
              <li><?php echo $row_usuario_comercial['nombre_usuario']; ?></li>
              <li><a href="<?php echo $logoutAction ?>">SALIR</a></li>
              </ul>
            </div> 
          </div>
        </div>
         <div class="row">
           <div class="col-md-4">
              <!--INICIA MENU-->
	               <div class="navbar"><ul><?php do { ?>
                      <li><?php
                        $tipo=$row_usuario_comercial['tipo_usuario'];
                        $id_submenu=$row_ver_sub_menu['id_submenu'];
                        $sql="select * from permisos where submenu='$id_submenu' and usuario='$tipo'";
                        $result=mysql_query($sql);
                        $num=mysql_num_rows($result);
                        if ($num >= '1'){ $submenu=mysql_result($result,0,'submenu'); }
                        if ($id_submenu==$submenu) { $url=$row_ver_sub_menu['url'];
                        echo "<a href=$url>".$row_ver_sub_menu['nombre_submenu']."</a>"; }
                        else{ echo $row_ver_sub_menu['nombre_submenu']; }
                        ?></li><?php } while ($row_ver_sub_menu = mysql_fetch_assoc($ver_sub_menu)); ?>
                    </ul> 
              </div>
           </div>          
            <div class="col-md-4">
                  <strong>Nombre: </strong>GESTION DE LA PRODUCCION DE BOLSAS DE SEGURIDAD.<br><br>
		<strong>Objetivo: </strong> Garantizar la adecuada producci&oacute;n del producto cumpliendo con los requisitos del cliente y del proceso. <br><br>
		  <strong>Alcance: </strong>Cubre la planeaci&oacute;n de la elaboraci&oacute;n del producto, la programaci&oacute;n de la producci&oacute;n, la fabricaci&oacute;n, el seguimiento, monitoreo, revisi&oacute;n, liberaci&oacute;n final, empaque, preservaci&oacute;n, despacho y trazabilidad. <br><br>
            </div>
            <div class="col-md-4">
			   <strong>Responsable: </strong>Supervisor de producci&oacute;n - Coordinador de Calidad - Coordinador de Sellado. <br><br>
		       <strong>Participantes: </strong>Gerente de Unidad de Bolsas, Operarios, Auxiliares, Supervisor y Coordinador de Calidad.<br><br>
            </div>            
          </div>

  </div> 
</body>
</html>
<?php
mysql_free_result($usuario_comercial);

mysql_free_result($ver_sub_menu);
?>
