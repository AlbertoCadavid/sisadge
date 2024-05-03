<?php require_once('Connections/conexion1.php'); ?>
<?php
//initialize the session
session_start();

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
	
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
$colname_usuario_comercial = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario_comercial = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario_comercial = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario_comercial);
$usuario_comercial = mysql_query($query_usuario_comercial, $conexion1) or die(mysql_error());
$row_usuario_comercial = mysql_fetch_assoc($usuario_comercial);
$totalRows_usuario_comercial = mysql_num_rows($usuario_comercial);

$colname_ver_sub_menu = "-1";
if (isset($_GET['id_menu'])) {
  $colname_ver_sub_menu = (get_magic_quotes_gpc()) ? $_GET['id_menu'] : addslashes($_GET['id_menu']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_sub_menu = sprintf("SELECT * FROM submenu WHERE id_menu_submenu = '1'", $colname_ver_sub_menu);
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
<link rel="StyleSheet" href="css/imageMenu.css" type="text/css">
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
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
                        $result=mysql_query($sql); $num=mysql_num_rows($result);
                        if ($num >= '1') { $submenu=mysql_result($result,0,'submenu'); }
                        if ($id_submenu==$submenu) {	$url=$row_ver_sub_menu['url'];
                        echo "<a href=$url>".$row_ver_sub_menu['nombre_submenu']."</a>"; }
                        else { echo $row_ver_sub_menu['nombre_submenu']; } ?></li>
                      <?php } while ($row_ver_sub_menu = mysql_fetch_assoc($ver_sub_menu)); ?>
                      <li><a href=referencia_precio.php>Referencias por Precio</a></li>
                      <li><a href=referencia_copia.php>Listado Referencias</a></li>
                   </ul>
                 </div>
              </div>          
            <div class="col-md-4">
              <strong>MENU PRINCIPAL</strong><br><br>
              El sistema administrador de gestiones (SISADGE) de ALBERTO CADAVID R & C&Iacute;A S.A. es un desarrollo gen&eacute;rico que especifica el Sistema de Gesti&oacute;n de Calidad en nuestra organizaci&oacute;n. 
              <br>El proposito fundamental de este desarrollo es seguir paso a paso la metodologia del sistema de Gesti&oacute;n de Calidad para la linea comercial, de dise&ntilde;o, producci&oacute;n y comercializaci&oacute;n de bolsas de seguridad para el empaque y transporte de valores.<br><br>
            </div>
            <div class="col-md-4">
              <!-- <strong>POLITICA DE CALIDAD</strong><br><br>Se busca la completa satisfaccion de los clientes a trav&eacute;s del mejoramiento continuo y con un grupo humano comprometido, verificando que durante todo el proceso se este cumpliendo con sus requisitos, necesidades y expectativas garantizando un producto y servicio de excelente calidad en el menor tiempo y a un precio justo, generando en ellos lealtad y confianza. -->
              <strong>PROPOSITO ORGANIZACIONAL</strong><br><br>En Alberto Cadavid R.& CIA estamos comprometidos con la generacion y suministro de soluciones seguras y confiables de empaques para el transporte de documentos, valores u otros productos que mantenga la satisfaccion, confianza y fidelizacion con el cliente y partes interesadas. 
            <br> Gestionamos eficientemente nuestros procesos con una infraestructura adecuada y el desarrollo de las competencias de nuestros colaboradores, garantizando la calidad de nuestros productos, el cumplimiento a los requisitos aplicables y el mejoramiento continuo de nuestros Sistema de Gestion.
            <button id="accordion" class="accordion">Continuar Leyendo....</button>
            <div class="panel">
            <br> Reafirmamos el compromiso con la proteccion y promocion de la salud de los trabajadores, en beneficio de su integridad física, mediante la gestion de los controles de los riesgos existentes, el cuidado, la intervencion de las condiciones de trabajo que puedan causar accidentes y enfermedades laborales. Logrando mecanismos efectivos que proporcionen un control del ausentismo, la preparacion ante emergencias y una cultura preventiva. 
            <br> Fomentamos el cumplimiento de normas y procedimientos de seguridad en beneficio de la realizacion de un trabajo seguro y productivo, en los empleados, contratistas y personal temporal, quienes serán responsables de notificar oportunamente todas aquellas condiciones que puedan generar consecuencias y contingencias en la empresa. 
            <br> A partir del cumplimiento de nuestro proposito, nuestra empresa mantendrá el reconocimiento y posicionamiento a nivel nacional e internacional, con un liderazgo y un crecimiento que garantice el desarrollo sostenible de nuestra empresa. 
            </div>

  </div>
  <script type="text/javascript">
    var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
  </script> 
</body>
</html>
<script>
let ac = document.getElementById('accordion')

  ac.addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
</script>
<?php
mysql_free_result($usuario_comercial);

mysql_free_result($ver_sub_menu);
?>