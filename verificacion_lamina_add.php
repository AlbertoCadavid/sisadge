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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Tbl_verificacion_lamina (id_verif_l,id_ref_verif_l,version_ref_verif_l,fecha_verif_l,responsable_verif_l,ancho_verif_l,
observ_ancho_verif_l,largo_verif_l,
observ_largo_verif_l,calibre_verif_l,observ_calibre_verif_l,revi_ortog_verif_l,observ_revi_ortog_verif_l,rev_textos_verif_l,observ_rev_textos_verif_l,rev_extru_verif_l,observ_rev_extru_verif_l,color_ext_verif_l,observ_color_ext_verif_l,
color_int_verif_l,observ_int_verif_l,num_pista_verif_l,observ_num_pista_verif_l,num_repetic_verif_l,observ_num_repetic_verif_l,num_paginaw_verif_l,observ_num_paginaw_verif_l,rev_enbob_verif_l,observ_rev_enbob_verif_l,1color_verif_l,observ_1color_verif_l,2color_verif_l,observ_2color_verif_l,3color_verif_l,observ_3color_verif_l,4color_verif_l,observ_4color_verif_l,5color_verif_l,observ_5color_verif_l,6color_verif_l,observ_6color_verif_l,7color_verif_l,observ_7color_verif_l,8color_verif_l,observ_8color_verif_l,marca_foto_verif_l,observ_marca_foto_verif_l,ref_verif_l,observ_ref_verif_l,b_preimp_verif_l,observ_b_preimp_verif_l,observacion_verif_l,userfile_l,estado_arte_verif_l,fecha_aprob_arte_verif_l,fecha_edit_verif_l,
responsable_edit_verif_l) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_verif_l'], "int"),
                       GetSQLValueString($_POST['id_ref_verif_l'], "int"),
					   GetSQLValueString($_POST['version_ref_verif_l'], "text"),
                       GetSQLValueString($_POST['fecha_verif_l'], "date"),
					   GetSQLValueString($_POST['responsable_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['ancho_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_ancho_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['largo_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_largo_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['calibre_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_calibre_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['revi_ortog_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_revi_ortog_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['rev_textos_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_rev_textos_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['rev_extru_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_rev_extru_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['color_ext_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_color_ext_verif_l'], "text"),					   
					   GetSQLValueString(isset($_POST['color_int_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_int_verif_l'], "text"),
					   GetSQLValueString(isset($_POST['num_pista_verif_l']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString($_POST['observ_num_pista_verif_l'], "text"),
					   GetSQLValueString(isset($_POST['num_repetic_verif_l']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString($_POST['observ_num_repetic_verif_l'], "text"),
					   GetSQLValueString(isset($_POST['num_paginaw_verif_l']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString($_POST['observ_num_paginaw_verif_l'], "text"),
					   GetSQLValueString(isset($_POST['rev_enbob_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_rev_enbob_verif_l'], "text"),					   
                       GetSQLValueString(isset($_POST['1color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_1color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['2color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_2color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['3color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_3color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['4color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_4color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['5color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_5color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['6color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_6color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['7color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_7color_verif_l'], "text"),
                       GetSQLValueString(isset($_POST['8color_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_8color_verif_l'], "text"),
					   GetSQLValueString(isset($_POST['marca_foto_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_marca_foto_verif_l'], "text"),
					   GetSQLValueString(isset($_POST['ref_verif_l']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString($_POST['observ_ref_verif_l'], "text"), 					   					   
					   GetSQLValueString(isset($_POST['b_preimp_verif_l']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['observ_b_preimp_verif_l'], "text"),
                       GetSQLValueString($_POST['observacion_verif_l'], "text"),
                       GetSQLValueString($_POST['userfile_l'], "text"),
                       GetSQLValueString($_POST['estado_arte_verif_l'], "int"),
                       GetSQLValueString($_POST['fecha_aprob_arte_verif_l'], "date"),
                       GetSQLValueString($_POST['fecha_edit_verif_l'], "date"),
                       GetSQLValueString($_POST['responsable_edit_verif_l'], "text"));
					   
//ADICIONADA LA UPDATE POR SI SE LES OLVIDA ACTUALIZAR LA VERSION MANUALMENTE
   $version_ref_verif_l=$_POST['version_ref_verif_l'];
   $id_ref=$_GET['id_ref'];
   $sql1="UPDATE Tbl_referencia SET version_ref='$version_ref_verif_l' WHERE id_ref='$id_ref'";					   

  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
  $Result2 = mysql_query($sql1, $conexion1) or die(mysql_error());
  
   $Codigo=$_POST['cod_ref'].'-'.$_POST['version_ref'];
   $Codigo_nuevo=$_POST['cod_ref'].'-'.$version_ref_verif_l;
   $sqlinv="UPDATE TblInventarioListado SET Codigo='$Codigo_nuevo' WHERE Codigo = '$Codigo'";
   $resultinv=mysql_query($sqlinv, $conexion1) or die(mysql_error());  
     
  $insertGoTo = "adjuntar_lamina1.php?id_verif_l=" . $_POST['id_verif_l'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
  $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
  $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));  
}

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$colname_referencia_revision = "-1";
if (isset($_GET['id_ref'])) {
  $colname_referencia_revision = (get_magic_quotes_gpc()) ? $_GET['id_ref'] : addslashes($_GET['id_ref']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_referencia_revision = sprintf("SELECT * FROM Tbl_referencia, Tbl_revision_lamina WHERE Tbl_referencia.id_ref = %s AND Tbl_referencia.id_ref = Tbl_revision_lamina.id_ref_rev_l", $colname_referencia_revision);
$referencia_revision = mysql_query($query_referencia_revision, $conexion1) or die(mysql_error());
$row_referencia_revision = mysql_fetch_assoc($referencia_revision);
$totalRows_referencia_revision = mysql_num_rows($referencia_revision);

mysql_select_db($database_conexion1, $conexion1);
$query_ultimo = "SELECT * FROM Tbl_verificacion_lamina ORDER BY id_verif_l DESC";
$ultimo = mysql_query($query_ultimo, $conexion1) or die(mysql_error());
$row_ultimo = mysql_fetch_assoc($ultimo);
$totalRows_ultimo = mysql_num_rows($ultimo);

$colname_ref_egp = "-1";
if (isset($_GET['id_ref'])) {
  $colname_ref_egp = (get_magic_quotes_gpc()) ? $_GET['id_ref'] : addslashes($_GET['id_ref']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ref_egp = sprintf("SELECT * FROM Tbl_referencia, Tbl_egp WHERE Tbl_referencia.id_ref = %s AND Tbl_referencia.n_egp_ref=Tbl_egp.n_egp", $colname_ref_egp);
$ref_egp = mysql_query($query_ref_egp, $conexion1) or die(mysql_error());
$row_ref_egp = mysql_fetch_assoc($ref_egp);
$totalRows_ref_egp = mysql_num_rows($ref_egp);

$colname_validacion = "-1";
if (isset($_GET['id_ref'])) {
  $colname_validacion = (get_magic_quotes_gpc()) ? $_GET['id_ref'] : addslashes($_GET['id_ref']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_validacion = sprintf("SELECT * FROM Tbl_validacion_lamina WHERE id_ref_val_l = %s ", $colname_validacion);
$validacion = mysql_query($query_validacion, $conexion1) or die(mysql_error());
$row_validacion = mysql_fetch_assoc($validacion);
$totalRows_validacion = mysql_num_rows($validacion);

$colname_verificacion = "-1";
if (isset($_GET['id_ref'])) {
  $colname_verificacion = (get_magic_quotes_gpc()) ? $_GET['id_ref'] : addslashes($_GET['id_ref']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_verificacion = sprintf("SELECT * FROM Tbl_verificacion_lamina WHERE  id_ref_verif_l = '%s' ORDER BY version_ref_verif_l DESC", $colname_verificacion);
$verificacion = mysql_query($query_verificacion, $conexion1) or die(mysql_error());
$row_verificacion = mysql_fetch_assoc($verificacion);
$totalRows_verificacion = mysql_num_rows($verificacion);

$colname_ficha_tecnica = "-1";
if (isset($_GET['id_ref'])) {
  $colname_ficha_tecnica = (get_magic_quotes_gpc()) ? $_GET['id_ref'] : addslashes($_GET['id_ref']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ficha_tecnica = sprintf("SELECT * FROM TblFichaTecnica WHERE id_ref_ft = %s", $colname_ficha_tecnica);
$ficha_tecnica = mysql_query($query_ficha_tecnica, $conexion1) or die(mysql_error());
$row_ficha_tecnica = mysql_fetch_assoc($ficha_tecnica);
$totalRows_ficha_tecnica = mysql_num_rows($ficha_tecnica);

$colname_certificacion_ref = "-1";
if (isset($_GET['id_ref'])) {
  $colname_certificacion_ref = (get_magic_quotes_gpc()) ? $_GET['id_ref'] : addslashes($_GET['id_ref']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_certificacion_ref = sprintf("SELECT * FROM TblCertificacion WHERE TblCertificacion.idref='%s'",$colname_certificacion_ref);
$certificacion_ref = mysql_query($query_certificacion_ref, $conexion1) or die(mysql_error());
$row_certificacion_ref = mysql_fetch_assoc($certificacion_ref);
$totalRows_certificacion_ref = mysql_num_rows($certificacion_ref);      

?>
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/formato.js"></script>
</head>
<body>
<div align="center">
<table id="tabla"><tr align="center"><td align="center">
<div> 
<b class="spiffy"> 
<b class="spiffy1"><b></b></b>
<b class="spiffy2"><b></b></b>
<b class="spiffy3"></b>
<b class="spiffy4"></b>
<b class="spiffy5"></b></b>
<div class="spiffy_content">
<table id="tabla1">
<tr>
<td colspan="2" align="center"><img src="images/cabecera.jpg"></td></tr>
<tr>
<td id="nombreusuario"><?php echo $row_usuario['nombre_usuario']; ?></td>
<td id="cabezamenu"><ul id="menuhorizontal">
<li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
<li><a href="menu.php">MENU PRINCIPAL</a></li>
<li><a href="referencia_copia.php">LISTADO REFERENCIA</a></li>
</ul>
</td></tr>
<tr><td colspan="2" align="center">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
      <table id="tabla2">
        <tr id="tr1">
          <td id="codigo" width="25%">CODIGO: R2-F01</td>
          <td colspan="2" nowrap="nowrap" id="titulo2">PLAN DE DISE&Ntilde;O &amp; DESARROLLO</td>
          <td id="codigo" width="25%">VERSION: 4</td>
        </tr>
        <tr>
          <td rowspan="6" id="dato2"><img src="images/logoacyc.jpg"/></td>
          <td colspan="2" id="subtitulo">ADD - II. VERIFICACION 
            LAMINA
            <input name="id_verif_l" type="hidden" value="<?php $num=$row_ultimo['id_verif_l']+1; echo $num; ?>" />
            <?php echo $num; ?></td>
          <td id="dato2"><a href="referencias.php"><img src="images/a.gif" alt="REF'S ACTIVAS" title="REF'S ACTIVAS" border="0" style="cursor:hand;"/></a><a href="referencias_inactivas.php"><img src="images/i.gif" alt="REF'S INACTIVAS"  title="REF'S INACTIVAS" border="0" style="cursor:hand;"/></a><a href="revision_lamina_vista.php?id_rev_l=<?php echo $row_referencia_revision['id_rev_l']; ?>"><img src="images/r.gif" alt="REVISIONES" title="REVISIONES" border="0" style="cursor:hand;" /></a><a href="verificacion_referencia_lamina.php?id_ref=<?php echo $row_referencia_revision['id_ref']; ?>"><img src="images/v.gif" alt="VERIFICACION X REF" title="VERIFICACION X REF" border="0" style="cursor:hand;" /></a><a href="verificacion.php"><img src="images/identico.gif" alt="LISTADO DE VERIFICACIONES" title="LISTADO DE VERIFICACIONES" border="0" style="cursor:hand;" /></a><?php if($row_validacion['id_val_l']=='') { ?><a href="validacion_lamina_add.php?id_ref=<?php echo $_GET['id_ref']; ?>"><img src="images/v.gif" alt="ADD VALIDACION" title="ADD VALIDACION" border="0" style="cursor:hand;" /></a><?php } else{ ?><a href="validacion_lamina_vista.php?id_val_l=<?php echo $row_validacion['id_val_l']; ?>"><img src="images/v.gif" alt="VALIDACION" title="VALIDACION" border="0" style="cursor:hand;" /></a><?php } ?><?php if($row_ficha_tecnica['n_ft']=='') { ?><a href="ficha_tecnica_add.php?id_ref=<?php echo $_GET['id_ref']; ?>"><img src="images/f.gif" alt="ADD FICHA TECNICA"  title="ADD FICHA TECNICA" border="0" style="cursor:hand;" /></a><?php } else { ?><a href="ficha_tecnica_vista.php?n_ft=<?php echo $row_ficha_tecnica['n_ft']; ?>"><img src="images/f.gif" alt="FICHA TECNICA" title="FICHA TECNICA" border="0" style="cursor:hand;" /></a><?php } ?>
          <?php if($row_certificacion['idcc']=='') { ?>
          <a href="certificacion_add.php?id_ref=<?php echo $_GET['id_ref']; ?>" target="new"><img src="images/c.gif" alt="ADD CERTIFICACION" title="ADD CERTIFICACION" border="0" style="cursor:hand;"></a><?php } else { ?><a href="certificacion_listado.php?id_ref=<?php echo $_GET['id_ref']; ?>" target="new"><img src="images/c.gif" alt="CERTIFICACIONES" title="CERTIFICACIONES" border="0" style="cursor:hand;">
          </a><?php } ?></td>
        </tr>
        <tr id="tr1">
          <td id="fuente2">FECHA DE REGISTRO </td>
          <td colspan="2" id="fuente2">RESPONSABLE</td>
          </tr>
        <tr>
          <td id="dato2"><input name="fecha_verif_l" type="text" value="<?php echo date("Y-m-d"); ?>" size="10" /></td>
          <td colspan="2" id="dato2"><input name="responsable_verif_l" type="text" value="<?php echo $row_usuario['nombre_usuario']; ?>" size="30" readonly /></td>
          </tr>
        <tr id="tr1">
          <td id="fuente2">REFERENCIA</td>
          <td id="fuente2">MODIFICACION</td>
          <td id="fuente2">VERSION MODIF.</td>
        </tr>
        <tr>
          <td id="dato2"><input name="id_ref_verif_l" type="hidden" value="<?php echo $row_referencia_revision['id_ref']; ?>" />
          <input name="cod_ref" type="hidden" id="cod_ref" value="<?php echo $row_referencia_revision['cod_ref']; ?>">
            <input name="version_ref" type="hidden" id="version_ref" value="<?php if($row_verificacion['version_ref_verif_l']!=''){echo $row_verificacion['version_ref_verif_l'];}else{echo '00';} ?>" size="2" >
             <strong><?php echo $row_referencia_revision['cod_ref']; ?> - <?php echo $row_referencia_revision['version_ref']; ?></strong></td>
          <td id="dato2">- - </td>
          <td id="dato2"><strong>
            <input name="version_ref_verif_l" type="text" value="<?php echo $row_referencia_revision['version_ref']; ?>" size="2" />
          </strong></td>
        </tr>
        <tr>
          <td><?php if($row_referencia_revision['estado_ref'] == '1') { ?> <div id="acceso2"><?php echo "Activa"; ?></div> <?php } else { ?> <div id="numero2"> <?php echo "Inactiva"; ?> </div> <?php } ?></td>
          <td id="dato2"><!--EGP N&ordm; <?php //echo $row_referencia_revision['n_egp_ref']; ?>--></td>
          <td id="dato2">COTIZACION N&ordm; <?php echo $row_referencia_revision['n_cotiz_ref']; ?></td>
        </tr>
        <tr id="tr1">
          <td colspan="4" id="titulo4">LISTADO DE VERIFICACION DE PARAMETROS GENERALES (Cumple Si / No)</td>
          </tr>
        <tr>
          <td colspan="4" align="center"><table id="tabla1">
            <tr id="tr1">
              <td id="fuente2">DATO</td>
              <td id="fuente2">CUMPLE</td>
              <td id="fuente2">OBSERVACION</td>
            </tr>
            <tr>
              <td id="detalle1">Ancho: <?php echo $row_referencia_revision['ancho_ref']; ?></td>
              <td id="detalle1"><input type="checkbox" name="ancho_verif_l" value="1" />
                Ancho</td>
              <td id="detalle2"><input type="text" name="observ_ancho_verif_l" value="<?php echo $row_referencia_revision['observ_ancho_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">Largo: <?php echo $row_referencia_revision['largo_ref']; ?></td>
              <td id="detalle1"><input type="checkbox" name="largo_verif_l" value="1">
                Largo</td>
              <td id="detalle2"><input type="text" name="observ_largo_verif_l" value="<?php echo $row_referencia_revision['observ_largo_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">Calibre: <?php echo $row_referencia_revision['calibre_ref']; ?></td>
              <td id="detalle1"><input type="checkbox" name="calibre_verif_l" value="1">
                Calibre</td>
              <td id="detalle2"><input type="text" name="observ_calibre_verif_l" value="<?php echo $row_referencia_revision['observ_calibre_rev_l']; ?>" size="50" /></td>
            </tr>            
            <tr>
              <td id="detalle1">Revisi&oacute;n Ortografica</td>
              <td id="detalle1"><input type="checkbox" name="revi_ortog_verif_l" value="1">
                Revisi&oacute;n Ortografica</td>
              <td id="detalle2"><input type="text" name="observ_revi_ortog_verif_l" value="<?php echo $row_referencia_revision['observ_revi_ortog_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">Revisi&oacute;n Textos</td>
              <td id="detalle1"><input type="checkbox" name="rev_textos_verif_l" value="1">
Revisi&oacute;n Textos</td>
              <td id="detalle2"><input type="text" name="observ_rev_textos_verif_l" value="<?php echo $row_referencia_revision['observ_rev_textos_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">Tipo Extrusi&oacute;n: <?php echo $row_ref_egp['tipo_ext_egp']; ?></td>
              <td id="detalle1"><input name="rev_extru_verif_l" type="checkbox" id="rev_extru_verif_l" value="1">
                Tipo Extrusion </td>
              <td id="detalle2"><input type="text" name="observ_rev_extru_verif_l" value="<?php echo $row_referencia_revision['observ_rev_extru_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">Pigmento Exterior: <?php echo $row_ref_egp['pigm_ext_egp']; ?></td>
              <td id="detalle1"><input type="checkbox" name="color_ext_verif_l" value="1">Color Extrusi&oacute;n Exterior </td>
              <td id="detalle2"><input type="text" name="observ_color_ext_verif_l" value="<?php echo $row_referencia_revision['observ_color_ext_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">Pigmento Interior: <?php echo $row_ref_egp['pigm_int_epg']; ?></td>
              <td id="detalle1"><input type="checkbox" name="color_int_verif_l" value="1">Color Extrusi&oacute;n Interior</td>
              <td id="detalle2"><input type="text" name="observ_int_verif_l" value="<?php echo $row_referencia_revision['observ_int_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">No. Pistas: <?php echo $row_referencia_revision['int_numero_p_l']; ?></td>
              <td id="detalle1"><input type="checkbox" name="num_pista_verif_l" value="1">
                No. Pistas</td>
              <td id="detalle2"><input type="text" name="observ_num_pista_verif_l" value="<?php echo $row_referencia_revision['observ_num_pista_rev_l']; ?>" size="50" /></td>
            </tr>
            <tr>
              <td id="detalle1">No. Repeticiones: <?php echo $row_referencia_revision['int_repeticion_l']; ?></td>
              <td id="detalle1"><input type="checkbox" name="num_repetic_verif_l" value="1">
                No. Repeticiones</td>
              <td id="detalle2"><input type="text" name="observ_num_repetic_verif_l" value="<?php echo $row_referencia_revision['observ_num_repetic_rev_l']; ?>" size="50" /></td>
            </tr>
            
            <tr>
              <td id="detalle1">Embobinado:
                <?php switch($row_referencia_revision['N_embobinado_l']) {
	  case 0: echo "VACIO"; break;
	  case 1: ?>
                <img src="images/embobinado1.gif">
                <?php break;
	  case 2: ?>
                <img src="images/embobinado2.gif">
                <?php break;
	  case 3: ?>
                <img src="images/embobinado3.gif">
                <?php break;
	  case 4: ?>
                <img src="images/embobinado4.gif">
                <?php break;
	  case 5: ?>
                <img src="images/embobinado5.gif">
                <?php break;
	  case 6: ?>
                <img src="images/embobinado6.gif">
                <?php break;
	  case 7: ?>
                <img src="images/embobinado7.gif">
                <?php break;
	  case 8: ?>
                <img src="images/embobinado8.gif">
                <?php break;
	  case 9: ?>
                <img src="images/embobinado9.gif">
                <?php break;
	  case 10: ?>
                <img src="images/embobinado10.gif">
                <?php break;
	  case 11: ?>
                <img src="images/embobinado11.gif">
                <?php break;
	  case 12: ?>
                <img src="images/embobinado12.gif">
                <?php break;
	  case 13: ?>
                <img src="images/embobinado13.gif">
                <?php break;
	  case 14: ?>
                <img src="images/embobinado14.gif">
                <?php break;
	  case 15: ?>
                <img src="images/embobinado15.gif">
                <?php break;
	  case 16: ?>
                <img src="images/embobinado16.gif">
                <?php break;
	  } ?></td>
              <td id="detalle1"><input type="checkbox" name="rev_enbob_verif_l" value="1">
                Embobinado</td>
              <td id="detalle2"><input type="text" name="observ_rev_enbob_verif_l" value="" size="50" /></td>
            </tr>
            </table></td>
          </tr>
        <tr id="tr1">
          <td colspan="4" id="titulo4">VERIFICACION DE COLORES DE IMPRESION (Cumple Si / No)</td>
        </tr>
        <tr>
          <td colspan="4" align="center"><table id="tabla1">
            <tr id="tr1">
              <td id="fuente2">COLOR</td>
              <td id="fuente2">PANTONE</td>
              <td id="fuente2">CUMPLE</td>
              <td id="fuente2">OBSERVACION</td>
            </tr>
            <tr>
              <td id="detalle1"><strong>1 </strong>: <?php echo $row_ref_egp['color1_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone1_egp']; ?></td>
              <td id="detalle2"><input name="1color_verif_l" type="checkbox" id="1color_verif_l" value="1" /></td>
              <td id="detalle2"><input type="text" name="observ_1color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>2 </strong>: <?php echo $row_ref_egp['color2_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone2_egp']; ?></td>
              <td id="detalle2"><input name="2color_verif_l" type="checkbox" id="2color_verif_l" value="1" /></td>
              <td id="detalle2"><input type="text" name="observ_2color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>3 </strong>: <?php echo $row_ref_egp['color3_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone3_egp']; ?></td>
              <td id="detalle2"><input name="3color_verif_l" type="checkbox" id="3color_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_3color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>4 </strong>: <?php echo $row_ref_egp['color4_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone4_egp']; ?></td>
              <td id="detalle2"><input name="4color_verif_l" type="checkbox" id="4color_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_4color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>5 </strong>: <?php echo $row_ref_egp['color5_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone5_egp']; ?></td>
              <td id="detalle2"><input name="5color_verif_l" type="checkbox" id="5color_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_5color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>6 </strong>: <?php echo $row_ref_egp['color6_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone6_egp']; ?></td>
              <td id="detalle2"><input name="6color_verif_l" type="checkbox" id="6color_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_6color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>7 </strong>: <?php echo $row_ref_egp['color7_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone7_egp']; ?></td>
              <td id="detalle2"><input name="7color_verif_l" type="checkbox" id="7color_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_7color_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td id="detalle1"><strong>8 </strong>: <?php echo $row_ref_egp['color8_egp']; ?></td>
              <td id="detalle1">- <?php echo $row_ref_egp['pantone8_egp']; ?></td>
              <td id="detalle2"><input name="8color_verif_l" type="checkbox" id="8color_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_8color_verif_l" value="" size="60" /></td>
            </tr>
                                    
            <tr>
              <td colspan="2" id="detalle1">MARCA DE FOTOCELDA</td>
              <td id="detalle2"><input type="checkbox" name="marca_foto_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_marca_foto_verif_l" value="" size="60" /></td>
            </tr>
            <tr>
              <td colspan="2" id="detalle1">REFERENCIA</td>
              <td id="detalle2"><input type="checkbox" name="ref_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_ref_verif_l" value="" size="60" /></td>
            </tr>
<tr>
              <td colspan="2" id="detalle1">PAGINA WEB</td>
              <td id="detalle2"><input type="checkbox" name="num_paginaw_verif_l" value="1"></td>
              <td id="detalle2"><input type="text" name="observ_num_paginaw_verif_l" value="<?php echo $row_referencia_revision['observ_num_paginaw_rev_l']; ?>" size="60" /></td>
            </tr>            
          </table></td>
        </tr>
        <tr id="tr1">
          <td colspan="4" id="titulo4">VERIFICACION DE PREIMPRESO (Cumple Si / No)</td>
        </tr>
        <tr>
          <td colspan="4" align="center"><table id="tabla1">
            <tr id="tr1">
              <td id="fuente2">PREIMPRESO</td>
              <td id="fuente2">NUMERO</td>
              <td id="fuente2">CUMPLE</td>
              <td id="fuente2">OBSERVACION</td>
            </tr>
            <tr>
              <td id="detalle2"><?php if ($row_referencia_revision['b_preimp_l']=='0'){echo "NO ";}else {echo"SI ";}?></td>
              <td id="detalle2"><?php echo $row_referencia_revision['int_numero_l']; ?>&nbsp;</td>
              <td id="detalle2"><input type="checkbox" name="b_preimp_verif_l" value="1" /></td>
              <td id="detalle2"><input type="text" name="observ_b_preimp_verif_l" value="" size="60" /></td>
            </tr>
          </table></td>
        </tr>
        <tr id="tr1">
          <td colspan="4" id="titulo4">OBSERVACIONES GENERALES </td>
        </tr>
        <tr>
          <td colspan="4" id="dato2"><textarea name="observacion_verif_l" cols="80" rows="2"><?php if($row_referencia_revision['str_obs_general_l']!=''){echo "Revision dice: "; echo $row_referencia_revision['str_obs_general_l'];} ?><?php echo " ". $row_ref_egp['observacion5_egp']; ?></textarea>
            <input name="userfile_l" type="hidden" value="" />
            <input name="estado_arte_verif_l" type="hidden" id="estado_arte_verif_l" value="0" />
            <input name="fecha_aprob_arte_verif_l" type="hidden" value="0000-00-00" /> 
            <input name="fecha_edit_verif_l" type="hidden" value="" />
            <input name="responsable_edit_verif_l" type="hidden" value="" /></td>
        </tr>


        <tr>
          <td colspan="4" id="dato2">&nbsp;</td>
        </tr>
        <tr id="tr1">
          <td colspan="4" id="dato2"><input type="submit" value="ADD VERIFICACION"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
    </form></td></tr>
</table>
</div>
<b class="spiffy"> 
<b class="spiffy5"></b>
<b class="spiffy4"></b>
<b class="spiffy3"></b>
<b class="spiffy2"><b></b></b>
<b class="spiffy1"><b></b></b></b></div> 
 </td>
  </tr>  
</table>
</div>
</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($referencia_revision);

mysql_free_result($ultimo);

mysql_free_result($ref_egp);

//mysql_free_result($validacion);

//mysql_free_result($ficha_tecnica);
?>
