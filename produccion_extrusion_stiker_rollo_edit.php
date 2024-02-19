<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php require_once('Connections/conexion1.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
  $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
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
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
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
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
    $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: " . $MM_restrictGoTo);
  exit;
}
?>
<?php
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php'); //SISTEMA RUW PARA LA BASE DE DATOS 
//FIN
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$conexion = new ApptivaDB();


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  $updateSQL = sprintf(
    "UPDATE TblExtruderRollo SET rollo_r=%s, id_op_r=%s, ref_r=%s, id_c_r=%s, tratInter_r=%s, tratExt_r=%s, pigmInt_r=%s, pigmExt_r=%s, calibre_r=%s, presentacion_r=%s, cod_empleado_r=%s, turno_r=%s, fechaI_r=%s, fechaF_r=%s, metro_r=%s, kilos_r=%s, reven_r=%s, medid_r=%s, corte_r=%s, desca_r=%s, calib_r=%s, trata_r=%s, arrug_r=%s, bandera_r=%s,montaje_r=%s, apagon_r=%s, observ_r=%s, reven2_r=%s,medid2_r=%s,corte2_r=%s,desca2_r=%s,calib2_r=%s,trata2_r=%s,arrug2_r=%s,apagon2_r=%s,montaje2_r=%s WHERE id_r=%s",
    GetSQLValueString($_POST['rollo_r'], "int"),
    GetSQLValueString($_POST['id_op_r'], "int"),
    GetSQLValueString($_POST['ref_r'], "text"),
    GetSQLValueString($_POST['id_c_r'], "int"),
    GetSQLValueString($_POST['tratInter_r'], "text"),
    GetSQLValueString($_POST['tratExt_r'], "text"),
    GetSQLValueString($_POST['pigmInt_r'], "text"),
    GetSQLValueString($_POST['pigmExt_r'], "text"),
    GetSQLValueString($_POST['calibre_r'], "double"),
    GetSQLValueString($_POST['presentacion_r'], "text"),
    GetSQLValueString($_POST['cod_empleado_r'], "int"),
    GetSQLValueString($_POST['turno_r'], "int"),
    GetSQLValueString($_POST['fechaI_r'], "date"),
    GetSQLValueString($_POST['fechaF_r'], "date"),
    GetSQLValueString($_POST['metro_r'], "int"),
    GetSQLValueString($_POST['kilos_r'], "double"),
    GetSQLValueString($_POST['reven_r'], "int"),
    GetSQLValueString($_POST['medid_r'], "int"),
    GetSQLValueString($_POST['corte_r'], "int"),
    GetSQLValueString($_POST['desca_r'], "int"),
    GetSQLValueString($_POST['calib_r'], "int"),
    GetSQLValueString($_POST['trata_r'], "int"),
    GetSQLValueString($_POST['arrug_r'], "int"),
    GetSQLValueString($_POST['bandera_r'], "int"),
    GetSQLValueString($_POST['montaje_r'], "int"),
    GetSQLValueString($_POST['apagon_r'], "int"),
    GetSQLValueString($_POST['observ_r'], "text"),
    GetSQLValueString($_POST['reven2_r'],  "text"),
    GetSQLValueString($_POST['medid2_r'],  "text"),
    GetSQLValueString($_POST['corte2_r'],  "text"),
    GetSQLValueString($_POST['desca2_r'],  "text"),
    GetSQLValueString($_POST['calib2_r'],  "text"),
    GetSQLValueString($_POST['trata2_r'],  "text"),
    GetSQLValueString($_POST['arrug2_r'],  "text"),
    GetSQLValueString($_POST['apagon2_r'],  "text"),
    GetSQLValueString($_POST['montaje2_r'],  "text"),
    GetSQLValueString($_POST['id_r'], "int")
  );

  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($updateSQL, $conexion1) or die(mysql_error());


  /* Registro de las Banderas */
  if (!empty($_POST['banderas'])) {

    for ($i = 0; $i < sizeof($_POST['banderas']); $i++) {
      $nombre = $_POST['banderas'][$i];
      if ($nombre != "") { //no almacena si viene alguna bandera sin nombre
        $metros = $_POST['metroBandera'][$i];
        $conexion->insertar("tbl_banderas", "`id_op`, `rollo_r`, `nombre`, `metros`, `proceso`", "$_POST[id_op_r], $_POST[rollo_r], '$nombre', $metros, 1 ");
      }
    }
  }

  $id_proceso = 1;
  /* inicio Tiempos muertos */
  if (!empty($_POST['id_rpt']) && !empty($_POST['valor_tiem_rt'])) {

    foreach ($_POST['id_rpt'] as $key => $v)
      $a[] = $v;
    foreach ($_POST['valor_tiem_rt'] as $key => $v)
      $b[] = $v;
    $c = $_POST['id_op_r'];

    for ($i = 0; $i < count($a); $i++) {
      if (!empty($a[$i]) && !empty($b[$i])) { //no salga error con campos vacios
        $insertSQLt = sprintf(
          "INSERT INTO Tbl_reg_tiempo (id_rpt_rt,id_rollo,valor_tiem_rt,op_rt,int_rollo_rt,id_proceso_rt,fecha_rt) VALUES (%s, %s, %s, %s,%s, %s, %s)",
          GetSQLValueString($a[$i], "int"),
          GetSQLValueString($_POST['id_r'], "int"),
          GetSQLValueString($b[$i], "int"),
          GetSQLValueString($c, "int"),
          GetSQLValueString($_POST['rollo_r'], "text"),
          GetSQLValueString($id_proceso, "int"),
          GetSQLValueString($_POST['fechaI_r'], "date")
        );

        mysql_select_db($database_conexion1, $conexion1);
        $Resultt = mysql_query($insertSQLt, $conexion1) or die(mysql_error());
      }
    }
  }
  /* Fin Tiempos muertos */

  /* inicio Tiempos preparacion */
  if (!empty($_POST['id_rtp']) && !empty($_POST['valor_prep_rtp'])) {
    foreach ($_POST['id_rtp'] as $key => $n)
      $h[] = $n;
    foreach ($_POST['valor_prep_rtp'] as $key => $n)
      $l[] = $n;
    $c = $_POST['id_op_r'];

    for ($x = 0; $x < count($h); $x++) {
      if (!empty($h[$x]) && !empty($l[$x])) { //no salga error con campos vacios
        $insertSQLp = sprintf(
          "INSERT INTO Tbl_reg_tiempo_preparacion (id_rpt_rtp,id_rollo,valor_prep_rtp,op_rtp,int_rollo_rtp,id_proceso_rtp,fecha_rtp) VALUES (%s, %s, %s, %s,%s, %s, %s)",
          GetSQLValueString($h[$x], "int"),
          GetSQLValueString($_POST['id_r'], "int"),
          GetSQLValueString($l[$x], "int"),
          GetSQLValueString($c, "int"),
          GetSQLValueString($_POST['rollo_r'], "text"),
          GetSQLValueString($id_proceso, "int"),
          GetSQLValueString($_POST['fechaI_r'], "date")
        );

        mysql_select_db($database_conexion1, $conexion1);
        $Resultp = mysql_query($insertSQLp, $conexion1) or die(mysql_error());
      }
    }
  }
  /* Fin Tiempos preparacion */

  /* inicio Desperdicios */
  if (!empty($_POST['id_rpd']) && !empty($_POST['valor_desp_rd'])) {
    foreach ($_POST['id_rpd'] as $key => $k)
      $f[] = $k;
    foreach ($_POST['valor_desp_rd'] as $key => $k)
      $g[] = $k;

    for ($s = 0; $s < count($f); $s++) {
      if (!empty($f[$s]) && !empty($g[$s])) { //no salga error con campos vacios
        $insertSQLd = sprintf(
          "INSERT INTO Tbl_reg_desperdicio (id_rpd_rd,id_rollo,valor_desp_rd,op_rd,int_rollo_rd,id_proceso_rd,fecha_rd,cod_ref_rd) VALUES (%s, %s, %s, %s, %s,%s, %s, %s)",
          GetSQLValueString($f[$s], "int"),
          GetSQLValueString($_POST['id_r'], "int"),
          GetSQLValueString($g[$s], "double"),
          GetSQLValueString($_POST['id_op_r'], "int"),
          GetSQLValueString($_POST['rollo_r'], "text"),
          GetSQLValueString($id_proceso, "int"),
          GetSQLValueString($_POST['fechaI_r'], "date"),
          GetSQLValueString($_POST['cod_ref_rd'], "text")
        );

        mysql_select_db($database_conexion1, $conexion1);
        $Resultd = mysql_query($insertSQLd, $conexion1) or die(mysql_error());
      }
    }
  }
  /* Fin Desperdicios */

  $id_op = $_POST['id_op_r'];
  $rollo_rd = $_POST['rollo_r'];
  $queryExisteLiquidacion = "SELECT id_rp FROM  TblExtruderRollo WHERE id_op_r='$id_op' AND rollo_r = $rollo_rd";
  $existeLiquidacion = mysql_query($queryExisteLiquidacion);
  $liquidacion = mysql_result($existeLiquidacion, 0, 'id_rp');

  if ($liquidacion != 0 || $liquidacion != null) {
    $sqlliq = "SELECT SUM(metro_r) AS metros, SUM(kilos_r) AS kilos, id_rp FROM  TblExtruderRollo WHERE id_op_r='$id_op' AND id_rp = $liquidacion";
    $resultliq = mysql_query($sqlliq);
    $kilos = mysql_result($resultliq, 0, 'kilos');
    $metros = mysql_result($resultliq, 0, 'metros');

    $sqlsuma = "UPDATE Tbl_reg_produccion SET int_total_kilos_rp=$kilos, int_metro_lineal_rp=$metros WHERE id_op_rp = $id_op AND id_proceso_rp='1' AND id_rp = $liquidacion ";
    mysql_select_db($database_conexion1, $conexion1);
    $Resultsuma = mysql_query($sqlsuma, $conexion1) or die(mysql_error());
  }



  $updateGoTo = "produccion_extrusion_stiker_rollo_vista.php?id_r=" . $_POST['id_r'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}



$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

//ORDENES DE PRODUCCION
$colname_orden_produccion = "-1";
if (isset($_GET['id_r'])) {
  $colname_orden_produccion = (get_magic_quotes_gpc()) ? $_GET['id_r'] : addslashes($_GET['id_r']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_lista_op = sprintf("SELECT Tbl_orden_produccion.metroLineal_op FROM TblExtruderRollo,Tbl_orden_produccion WHERE TblExtruderRollo.id_r=%s and TblExtruderRollo.id_op_r=Tbl_orden_produccion.id_op ORDER BY Tbl_orden_produccion.id_op DESC", $colname_orden_produccion);
$lista_op = mysql_query($query_lista_op, $conexion1) or die(mysql_error());
$row_lista_op = mysql_fetch_assoc($lista_op);
$totalRows_lista_op = mysql_num_rows($lista_op);
//CODIGO EMPLEADO
/*mysql_select_db($database_conexion1, $conexion1);
$query_codigo_empleado = "SELECT codigo_empleado,nombre_empleado FROM empleado WHERE tipo_empleado='4' ORDER BY nombre_empleado ASC";
$codigo_empleado = mysql_query($query_codigo_empleado, $conexion1) or die(mysql_error());
$row_codigo_empleado = mysql_fetch_assoc($codigo_empleado);
$totalRows_codigo_empleado = mysql_num_rows($codigo_empleado);*/
$row_codigo_empleado = $conexion->llenaSelect('empleado a INNER JOIN TblProcesoEmpleado b ', 'ON a.codigo_empleado=b.codigo_empleado WHERE a.tipo_empleado IN(4) AND b.estado_empleado=1 ', 'ORDER BY a.nombre_empleado ASC');


$colname_rollo_estrusion_edit = "-1";
if (isset($_GET['id_r'])) {
  $colname_rollo_estrusion_edit = (get_magic_quotes_gpc()) ? $_GET['id_r'] : addslashes($_GET['id_r']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_rollo_estrusion_edit = sprintf("SELECT * FROM TblExtruderRollo WHERE TblExtruderRollo.id_r=%s", $colname_rollo_estrusion_edit);
$rollo_estrusion_edit = mysql_query($query_rollo_estrusion_edit, $conexion1) or die(mysql_error());
$row_rollo_estrusion_edit = mysql_fetch_assoc($rollo_estrusion_edit);
$totalRows_rollo_estrusion_edit = mysql_num_rows($rollo_estrusion_edit);

$idop = $row_rollo_estrusion_edit['id_op_r'];
$elrollo = $row_rollo_estrusion_edit['rollo_r'];
$fechaR = $row_rollo_estrusion_edit['fechaI_r'];

$row_orden = $conexion->llenarCampos("tbl_orden_produccion ", "WHERE id_op='" . $idop . "' AND b_borrado_op='0' ", "ORDER BY id_op DESC", " * ");


mysql_select_db($database_conexion1, $conexion1);
$query_tiempo_muertos = "SELECT * FROM Tbl_reg_tipo_desperdicio WHERE Tbl_reg_tipo_desperdicio.id_proceso_rtd='1' AND Tbl_reg_tipo_desperdicio.codigo_rtp='1' AND estado_rtp='0' ORDER BY Tbl_reg_tipo_desperdicio.nombre_rtp ASC";
$tiempo_muertos = mysql_query($query_tiempo_muertos, $conexion1) or die(mysql_error());
$row_tiempo_muertos = mysql_fetch_assoc($tiempo_muertos);
$totalRows_tiempo_muertos = mysql_num_rows($tiempo_muertos);

mysql_select_db($database_conexion1, $conexion1);
$query_tiempo_preparacion = "SELECT * FROM Tbl_reg_tipo_desperdicio WHERE Tbl_reg_tipo_desperdicio.id_proceso_rtd='1' AND Tbl_reg_tipo_desperdicio.codigo_rtp='2' AND estado_rtp='0' ORDER BY Tbl_reg_tipo_desperdicio.nombre_rtp ASC";
$tiempo_preparacion = mysql_query($query_tiempo_preparacion, $conexion1) or die(mysql_error());
$row_tiempo_preparacion = mysql_fetch_assoc($tiempo_preparacion);
$totalRows_tiempo_preparacion = mysql_num_rows($tiempo_preparacion);

mysql_select_db($database_conexion1, $conexion1);
$query_desperdicios = "SELECT * FROM Tbl_reg_tipo_desperdicio WHERE Tbl_reg_tipo_desperdicio.id_proceso_rtd='1' AND Tbl_reg_tipo_desperdicio.codigo_rtp='3' AND estado_rtp='0' ORDER BY Tbl_reg_tipo_desperdicio.nombre_rtp ASC";
$desperdicios = mysql_query($query_desperdicios, $conexion1) or die(mysql_error());
$row_desperdicios = mysql_fetch_assoc($desperdicios);
$totalRows_desperdicios = mysql_num_rows($desperdicios);


mysql_select_db($database_conexion1, $conexion1);
$query_tiempoMuerto = sprintf("SELECT * FROM Tbl_reg_tiempo WHERE op_rt=%s AND id_proceso_rt='1' AND int_rollo_rt=$elrollo AND fecha_rt='$fechaR' ORDER BY id_rpt_rt ASC", $idop);
$tiempoMuerto = mysql_query($query_tiempoMuerto, $conexion1) or die(mysql_error());
$row_tiempoMuerto = mysql_fetch_assoc($tiempoMuerto);
$totalRows_tiempoMuerto = mysql_num_rows($tiempoMuerto);
//CARGA LOS TIEMPOS PREPARACION 
mysql_select_db($database_conexion1, $conexion1);
$query_tiempoPreparacion = sprintf("SELECT * FROM Tbl_reg_tiempo_preparacion WHERE op_rtp=%s AND id_proceso_rtp='1' AND int_rollo_rtp=$elrollo AND fecha_rtp='$fechaR' ORDER BY id_rpt_rtp ASC", $idop);
$tiempoPreparacion  = mysql_query($query_tiempoPreparacion, $conexion1) or die(mysql_error());
$row_tiempoPreparacion  = mysql_fetch_assoc($tiempoPreparacion);
$totalRows_tiempoPreparacion  = mysql_num_rows($tiempoPreparacion);
//CARGA LOS TIEMPOS  DESPERDICIOS
mysql_select_db($database_conexion1, $conexion1);
$query_desperdicio = sprintf("SELECT * FROM Tbl_reg_desperdicio WHERE op_rd=%s AND id_proceso_rd='1' AND int_rollo_rd=$elrollo AND fecha_rd='$fechaR' ORDER BY id_rpd_rd ASC", $idop);
$desperdicio = mysql_query($query_desperdicio, $conexion1) or die(mysql_error());
$row_desperdicio = mysql_fetch_assoc($desperdicio);
$totalRows_desperdicio = mysql_num_rows($desperdicio);

/* obtener banderas */
$banderas = $conexion->llenaListas("tbl_banderas", "WHERE id_op = $row_rollo_estrusion_edit[id_op_r] AND rollo_r = $row_rollo_estrusion_edit[rollo_r] AND proceso = 1", "ORDER BY nombre ASC", "*");
$num_banderas = sizeof($banderas);

/*if($row_tiempoMuerto['fecha_rt'] !='' || $row_tiempoPreparacion['fecha_rtp']!='' || $row_desperdicio['fecha_rd']!=''){
  $fechaibloque = $row_tiempoMuerto['fecha_rt'] =='' ? $row_tiempoPreparacion['fecha_rtp'] : $row_desperdicio['fecha_rd'];
}*/
?>
<html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">

  <link href="css/formato.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/formato.js"></script>
  <script type="text/javascript" src="js/consulta.js"></script>
  <script type="text/javascript" src="js/validacion_numerico.js"></script>
  <link rel="stylesheet" type="text/css" href="css/general.css" />

  <!-- desde aqui para listados nuevos -->
  <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
  <link rel="stylesheet" type="text/css" href="css/general.css" />

  <!-- sweetalert -->
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

  <script type="text/javascript">
    function alerta_ext() {
      DatosGestiones3('13', 'id_r', document.form1.id_r.value, '&fechaI', document.form1.fechaI_r.value);

      //alert('si cambia esta fecha, elimine primero los registros de tiempos, preparacion y desperdicios')
    }
  </script>
</head>

<body>
  <?php echo $conexion->header('vistas'); ?>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="return(validacion_registro_rollo())">
    <table align="center" class="table table-bordered table-sm">
      <tr>
        <td rowspan="3" id="fondo"><img src="images/logoacyc.jpg" width="97" height="71" /></td>
        <td colspan="4" id="titulo2">IDENTIFICACION MATERIALES EXTRUIDOS
          <?php $id_op = $row_rollo_estrusion_edit['id_op_r'];
          $sqlr = "SELECT id_proceso_rp, SUM(int_total_rollos_rp) AS maxrollo FROM Tbl_reg_produccion WHERE id_op_rp=$id_op AND id_proceso_rp='1' ORDER BY int_total_rollos_rp DESC LIMIT 1";
          $resultr = mysql_query($sqlr);
          $numr = mysql_num_rows($resultr);
          if ($numr >= '1') {
            $max_rollo = mysql_result($resultr, 0, 'maxrollo');
          } else {
            $max_rollo = '0';
          } ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" id="numero2">ROLLO N&deg; <?php echo $row_rollo_estrusion_edit['rollo_r'];
                                                  if ($max_rollo != '') {
                                                    echo " de " . $max_rollo;
                                                  } ?>
          <input type="hidden" name="rollo_r" id="rollo_r" style="width:40px" value="<?php echo $row_rollo_estrusion_edit['rollo_r']; ?>">
          <input type="hidden" name="id_r" id="id_r" value="<?php echo $row_rollo_estrusion_edit['id_r']; ?>">
        </td>
      </tr>
      <tr>
        <td id="talla3">&nbsp;Rollos ingresados hasta el momento:</td>
        <td colspan="2" id="numero"><?php
                                    $id_op = $row_rollo_estrusion_edit['id_op_r'];
                                    $result = mysql_query("SELECT rollo_r FROM TblExtruderRollo WHERE id_op_r='$id_op' ORDER BY rollo_r ASC");
                                    if ($row = mysql_fetch_array($result)) {
                                      do {
                                        echo $row["rollo_r"] . ", " . "\n";
                                      } while ($row = mysql_fetch_array($result));
                                    } else {
                                      echo "&iexcl; Aun no hay Rollos!";
                                    }
                                    ?></td>
      </tr>
      <tr>
        <td id="titulo2">&nbsp;</td>
        <td colspan="4" id="fuente3"><a href="produccion_extrusion_stiker_rollo_add.php?id_op_r=<?php echo $row_rollo_estrusion_edit['id_op_r']; ?>"><img src="images/mas.gif" alt="ADD ROLLO" title="ADD ROLLO" border="0" style="cursor:hand;" /></a><a href="produccion_extrusion_stiker_rollo_vista.php?id_r=<?php echo $row_rollo_estrusion_edit['id_r']; ?>"><img src="images/hoja.gif" alt="VISTA" title="VISTA" border="0" /></a><a href="produccion_extrusion_listado_rollos.php?id_op_r=<?php echo $row_rollo_estrusion_edit['id_op_r']; ?>"><img src="images/opciones.gif" alt="LISTADO ROLLOS" title="LISTADO ROLLO" border="0" style="cursor:hand;" /></a>
          <?php if ($row_usuario['tipo_usuario'] == 1) { ?><a href="produccion_extrusion_stiker_rollo_colas_vista.php?id_op_r=<?php echo $row_rollo_estrusion_edit['id_op_r']; ?>"><img src="images/t.gif" alt="IMPRESION TODOS LOS ROLLOS" title="IMPRESION TODOS LOS ROLLOS" border="0" /></a>
            <a href="javascript:eliminar1('id_re',<?php echo $row_rollo_estrusion_edit['id_r']; ?>,'produccion_extrusion_stiker_rollo_edit.php')"><img src="images/por.gif" alt="ELIMINAR" title="Eliminara todos los tiempos y desperdicios si tienen fecha de este rollo" border="0" style="cursor:hand;" /></a>
          <?php } ?><a href="javascript:location.reload()"><img src="images/ciclo1.gif" alt="RESTAURAR" title="RESTAURAR" border="0" style="cursor:hand;" /></a>
        </td>
      </tr>
      <tr>
        <td colspan="4" id="titulo1">INFORMACION GENERAL DE LA O.P.</td>
      </tr>
      <tr>
        <td id="fuente1">ORDEN P</td>
        <td id="fuente1"><input name="id_op_r" type="text" id="id_op_r" value="<?php echo $row_rollo_estrusion_edit['id_op_r']; ?>" size="11" readonly /></td>
        <td id="fuente1">REF.</td>
        <td id="fuente1"><input type="number" name="ref_r" id="ref_r" min="0" max="20" style=" width:100px" value="<?php echo $row_rollo_estrusion_edit['ref_r']; ?>" readonly>
        </td>
      </tr>
      <tr>
        <td id="fuente1">CLIENTE</td>
        <td colspan="3" id="fuente1">
          <?php $id_c = $row_rollo_estrusion_edit['id_c_r'];
          $sqln = "SELECT id_c,nombre_c FROM cliente WHERE id_c='$id_c'";
          $resultn = mysql_query($sqln);
          $numn = mysql_num_rows($resultn);
          if ($numn >= '1') {
            $id_co = mysql_result($resultn, 0, 'id_c');
            $nombre_c = mysql_result($resultn, 0, 'nombre_c');
            $cadenaN = htmlentities($nombre_c);
            echo $cadenaN;
          } ?><input type="hidden" name="id_c_r" id="id_c_r" value="<?php echo $id_co; ?>" size="11"></td>
      </tr>
      <tr>
        <td id="fuente1">TRATADO INTERNO</td>
        <td id="fuente1"><select name="tratInter_r" id="tratInter_r" style="width:100px">
            <option value="N.A" <?php if (!(strcmp('N.A', $row_rollo_estrusion_edit['tratInter_r']))) {
                                  echo "selected=\"selected\"";
                                } ?>>N.A</option>
            <option value="UNA CARA" <?php if (!(strcmp('UNA CARA', $row_rollo_estrusion_edit['tratInter_r']))) {
                                        echo "selected=\"selected\"";
                                      } ?>>UNA CARA</option>
            <option value="DOBLE CARA" <?php if (!(strcmp('DOBLE CARA', $row_rollo_estrusion_edit['tratInter_r']))) {
                                          echo "selected=\"selected\"";
                                        } ?>>DOBLE CARA</option>
          </select></td>
        <td id="fuente1">TRATADO EXTERNO</td>
        <td id="fuente1"><select name="tratExt_r" id="tratExt_r" style="width:100px">
            <option value="N.A" <?php if (!(strcmp('N.A', $row_rollo_estrusion_edit['tratExt_r']))) {
                                  echo "selected=\"selected\"";
                                } ?>>N.A</option>
            <option value="UNA CARA" <?php if (!(strcmp('UNA CARA', $row_rollo_estrusion_edit['tratExt_r']))) {
                                        echo "selected=\"selected\"";
                                      } ?>>UNA CARA</option>
            <option value="DOBLE CARA" <?php if (!(strcmp('DOBLE CARA', $row_rollo_estrusion_edit['tratExt_r']))) {
                                          echo "selected=\"selected\"";
                                        } ?>>DOBLE CARA</option>
          </select></td>
      </tr>
      <tr>
        <td id="fuente1">PIGMENTO INTERIOR</td>
        <td id="fuente1"><input name="pigmInt_r" type="text" onKeyUp="conMayusculas(this)" value="<?php echo $row_rollo_estrusion_edit['pigmInt_r']; ?>" size="11" readonly /></td>
        <td id="fuente1">PIGMENTO EXTERIOR</td>
        <td id="fuente1"><input name="pigmExt_r" type="text" onKeyUp="conMayusculas(this)" value="<?php echo $row_rollo_estrusion_edit['pigmExt_r']; ?>" size="11" readonly /></td>
      </tr>
      <tr>
        <td id="fuente1">CALIBRE MILS.</td>
        <td id="fuente1"><input name="calibre_r" type="text" id="calibre_r" value="<?php echo $row_rollo_estrusion_edit['calibre_r']; ?>" size="11" readonly /></td>
        <td id="fuente1">PRESENTACION</td>
        <td id="fuente1"><input name="presentacion_r" type="text" value="<?php echo $row_rollo_estrusion_edit['presentacion_r']; ?>" size="11" readonly /></td>
      </tr>
      <tr>
        <td colspan="4">
        </td>
      </tr>
      <tr>
        <td colspan="4" id="titulo1">INFORMACION DEL ROLLO</td>
      </tr>
      <tr>
        <td id="fuente1">OPERARIO</td>
        <td id="fuente1">

          <select name="cod_empleado_r" id="montaje" onBlur="validacion_registro_rollo();" style="width:120px">
            <option value="" <?php if (!(strcmp("", $row_rollo_estrusion_edit['cod_empleado_r']))) {
                                echo "selected=\"selected\"";
                              } ?>>Montaje</option>
            <option value="0">Seleccione</option>
            <?php foreach ($row_codigo_empleado as $row_codigo_empleado) { ?>
              <option value="<?php echo $row_codigo_empleado['codigo_empleado'] ?>" <?php if (!(strcmp($row_codigo_empleado['codigo_empleado'], $row_rollo_estrusion_edit['cod_empleado_r']))) {
                                                                                      echo "selected=\"selected\"";
                                                                                    } ?>><?php echo $row_codigo_empleado['codigo_empleado'] . " - " . $row_codigo_empleado['nombre_empleado'] . " " . $row_codigo_empleado['apellido_empleado'] ?></option>
            <?php } ?>
          </select>

        </td>
        <td id="fuente1">&nbsp;</td>
        <td id="fuente1">&nbsp;</td>
      </tr>
      <tr>
        <td id="fuente1">TURNO</td>
        <td id="fuente1"><input type="number" name="turno_r" id="turno_r" min="1" max="6" style=" width:40px" value="<?php echo $row_rollo_estrusion_edit['turno_r']; ?>" required></td>
        <td colspan="2" id="fuente1">
          <p>FECHA IMPRIME
            ESTIQUER ROLLO</p>
          <p>
            <input name="fechaV_r" type="datetime-local" min="2000-01-02" size="15" value="<?php echo muestradatelocal($row_rollo_estrusion_edit['fechaV_r']); ?>" readonly required />
          </p>
        </td>
      </tr>
      <tr>
        <td id="fuente1">FECHA INICIO ROLLO</td>
        <td id="fuente1"><input name="fechaI_r" id="fecha_ini_rp" type="datetime-local" size="15" value="<?php echo muestradatelocal($row_rollo_estrusion_edit['fechaI_r']); ?>" onChange="alerta_ext();" required="required" /></td>
        <td colspan="2" id="fuente1">
          <p>FECHA FIN ROLLO
          </p>
          <p>
            <input name="fechaF_r" id="fecha_fin_rp" type="datetime-local" size="15" value="<?php echo muestradatelocal($row_rollo_estrusion_edit['fechaF_r']); ?>" onBlur="validacion_registro_rollo();" required />
          </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" id="fuente4">
          <div id="resultado_generador"></div>
        </td>
        <td colspan="2" id="fuente4">&nbsp;</td>
      </tr>
      <tr>
        <td id="fuente1">METRO LINEAL</td>
        <td id="fuente1">
          <input name="metro_r" type="number" id="metro_r" min="1" style=" width:100px" value="<?php echo $row_rollo_estrusion_edit['metro_r']; ?>" required />

          <?php echo $row_lista_op['metroLineal_op']; ?>
        </td>
        <td id="fuente1">PESO</td>
        <td id="fuente1"><input name="kilos_r" type="number" id="kilos_r" min="1.00" step="0.01" style=" width:100px" value="<?php echo $row_rollo_estrusion_edit['kilos_r']; ?>" required /></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>

      <!-- Desperdicio -->
      <tr id="tr1">
        <td style="text-align:center" colspan="1" id="dato1">Tiempos Muertos</td>
        <td style="text-align:center" id="dato1">Tiempos Preparacion</td>
        <td style="text-align:center" id="dato1">Desperdicios</td>
        <td style="text-align:center" id="titulo1" rowspan="2">DEFECTOS</td>

      </tr>
      <tr id="tr1">
        <td colspan="1" id="dato1"><input type="button" class="botonFinalizar" name="button" id="button" value="Crear otra fila" onclick="tiemposM()" style="width:193px" /></td>
        <td id="dato1" style="text-align:center"><input type="button" name="button2" class="botonFinalizar" id="button2" value="Crear otra fila" onclick="tiemposP()" style="width:193px" /></td>
        <td id="dato1"><input type="button" name="button3" class="botonFinalizar" id="button3" value="Crear otra fila" onclick="tiemposD()" style="width:193px" /></td>
        <td><input type="hidden" name="cod_ref_rd" id="cod_ref_rd" value="<?php echo $row_orden['int_cod_ref_op'] ?>" /></td>
      </tr>

      <tr>
        <td colspan="1" id="dato1">
          <div id="moreUploads"></div>
        </td>
        <td id="dato1">
          <div id="moreUploads2"></div>
        </td>
        <td id="dato1">
          <div id="moreUploads3"></div>
        </td>
      </tr>

      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>

      <tr>
        <td colspan="4">
          <table width="100%" border="1">
            <?php if ($row_tiempoMuerto['id_rpt_rt'] != '') { ?>
              <tr>
                <td nowrap id="detalle2"><strong>Tiempos Muertos- Tipo</strong></td>
                <td nowrap id="detalle2"><strong>Tiempos Muertos- Minutos</strong></td>
                <td nowrap id="detalle2"><strong>ELIMINA</strong></td>

              </tr>
              <?php for ($x = 0; $x <= $totalRows_tiempoMuerto - 1; $x++) { ?>
                <tr>
                  <td id="fuente1">
                    <?php $id1 = mysql_result($tiempoMuerto, $x, id_rpt_rt);
                    $id_tm = $id1;
                    $sqltm = "SELECT nombre_rtp FROM Tbl_reg_tipo_desperdicio WHERE id_rtp='$id_tm'";
                    $resulttm = mysql_query($sqltm);
                    $numtm = mysql_num_rows($resulttm);
                    if ($numtm >= '1') {
                      $nombreM = mysql_result($resulttm, 0, 'nombre_rtp');
                      echo $nombreM;
                    }
                    ?>

                  </td>
                  <td id="fuente1"><?php $var = mysql_result($tiempoMuerto, $x, valor_tiem_rt);
                                    echo $var;
                                    $TM = $TM + $var; ?></td>
                  <td id="fuente1"><a href="javascript:eliminarTiemposDesp('idtiemprollo','id_rt',<?php $delrt = mysql_result($tiempoMuerto, $x, id_rt);
                                                                                                  echo $delrt; ?>,'id_r',<?php echo $_GET['id_r']; ?>,'Tbl_reg_tiempo','produccion_extrusion_stiker_rollo_edit.php')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a>
                  </td>
                </tr>
              <?php } ?>
              <tr>
                <td id="fuente3">TOTAL</td>
                <td id="fuente1"><strong><?php echo $TM; ?></strong></td>
                <td id="fuente3">&nbsp;</td>
              </tr>
            <?php } ?>
            <?php if ($row_tiempoPreparacion['id_rpt_rtp'] != '') { ?>

              <tr>
                <td nowrap id="detalle2"><strong>Tiempos Preparacion - Tipo</strong></td>
                <td nowrap id="detalle2"><strong>Tiempos Preparacion - Minutos</strong></td>
                <td nowrap id="detalle2"><strong>ELIMINA</strong></td>

              </tr>
              <?php for ($o = 0; $o <= $totalRows_tiempoPreparacion - 1; $o++) { ?>
                <tr>
                  <td id="fuente1">
                    <?php $id2 = mysql_result($tiempoPreparacion, $o, id_rpt_rtp);
                    $id_rtp = $id2;
                    $sqlrtp = "SELECT nombre_rtp FROM Tbl_reg_tipo_desperdicio WHERE id_rtp='$id_rtp'";
                    $resultrtp = mysql_query($sqlrtp);
                    $numrtp = mysql_num_rows($resultrtp);
                    if ($numrtp >= '1') {
                      $nombreP = mysql_result($resultrtp, 0, 'nombre_rtp');
                      echo $nombreP;
                    } ?>

                  </td>
                  <td id="fuente1"> <?php $var2 = mysql_result($tiempoPreparacion, $o, valor_prep_rtp);
                                    echo $var2;
                                    $TP += $var2; ?></td>
                  <td id="fuente1"><a href="javascript:eliminarTiemposDesp('idtiemprollo','id_rt',<?php $delrp = mysql_result($tiempoPreparacion, $o, id_rt);
                                                                                                  echo $delrp; ?>,'id_r',<?php echo $_GET['id_r']; ?>,'Tbl_reg_tiempo_preparacion','produccion_extrusion_stiker_rollo_edit.php')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a></td>
                </tr>
              <?php } ?>
              <tr>
                <td id="fuente3">TOTAL</td>
                <td id="fuente1"><strong><?php echo $TP; ?></strong></td>
                <td id="fuente3">&nbsp;</td>
              </tr>
            <?php } ?>
            <?php if ($row_desperdicio['id_rpd_rd'] != '') { ?>
              <tr>
                <td nowrap id="detalle2"><strong>Desperdicios - Tipo</strong></td>
                <td nowrap id="detalle2"><strong>Desperdicios - Kilos</strong></td>
                <td nowrap id="detalle2"><strong>ELIMINA</strong></td>
              </tr>
              <?php for ($m = 0; $m <= $totalRows_desperdicio - 1; $m++) { ?>
                <tr>
                  <td id="fuente1"><?php
                                    $id3 = mysql_result($desperdicio, $m, id_rpd_rd);
                                    $id_rpd = $id3;
                                    $sqlrtd = "SELECT nombre_rtp FROM Tbl_reg_tipo_desperdicio WHERE id_rtp='$id_rpd'";
                                    $resultrtd = mysql_query($sqlrtd);
                                    $numrtd = mysql_num_rows($resultrtd);
                                    if ($numrtd >= '1') {
                                      $nombreD = mysql_result($resultrtd, 0, 'nombre_rtp');
                                      echo $nombreD;
                                    } ?></td>
                  <td id="fuente1"><?php $var3 = mysql_result($desperdicio, $m, valor_desp_rd);
                                    echo $var3;
                                    $TD = $TD + $var3; ?></td>
                  <td id="fuente1"><a href="javascript:eliminarTiemposDesp('idtiemprollo','id_rd',<?php $delrd = mysql_result($desperdicio, $m, id_rd);
                                                                                                  echo $delrd; ?>,'id_r',<?php echo $_GET['id_r']; ?>,'Tbl_reg_desperdicio','produccion_extrusion_stiker_rollo_edit.php')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a></td>
                </tr>
              <?php } ?>
              <tr>
                <td id="fuente3">TOTAL</td>
                <td id="fuente1"><strong><?php echo $TD; ?></strong></td>
                <td id="fuente3">&nbsp;</td>
              </tr>
            <?php } ?>
          </table>
        </td>
      </tr>

      <tr><td >&nbsp;</td></tr>
      <tr>
        <td colspan="2" id="titulo1">BANDERAS
          <!-- grid -->
          <?php if ($num_banderas > 0) { ?>
            <hr>
            <table id="example" class="display" style="width:100%" border="1">
              <thead>
                <tr id="titulo1">
                  <td style="text-align: center;">NOMBRE</td>
                  <td>METROS</td>
                  <td>ELIMINAR</td>
                </tr>
              </thead>
              <tbody id="DataResult">
                <?php foreach ($banderas as $value) { ?>
                  <tr>
                    <td nowrap id="detalle2"> <?php echo  ucfirst($value['nombre']) ?></td>
                    <td nowrap id="detalle2"> <?php echo $value['metros'] ?></td>
                    <td style="text-align: center;"><a href="javascript:eliminarBandera('id_bandera',<?php echo $value['id_bandera'] ?>, 'proceso', <?php echo $value['proceso'] ?>,'Tbl_banderas', <?php echo $_GET['id_r'] ?>, 'produccion_extrusion_stiker_rollo_edit.php?id_r=')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR BANDERA" border="0"></td>
                  </tr>

                <?php } ?>
              </tbody>
            </table>
          </td>
        </tr>
      <?php } ?>

      <tr id="tablaf">
        <td></td>
      </tr>

      <tr>
        <td></td>
        <td style="text-align: right">
          <span>Nueva Bandera</span>
          <button style="width:40px" type="button" class="botonGMini" onClick="AddItemd();"> + </button>
        </td>
      </tr>
      <tr>
        <td id="fuente1" colspan="1">TOTAL BANDERAS:
          <input type="number" readonly value="" name="bandera_r" id="totales" style="width:35px; border:0">
        </td>
      </tr>

      <tr>
        <td colspan="4" id="titulo1">OBSERVACIONES</td>
      </tr>
      <tr>
        <td colspan="4" id="fuente2"><textarea name="observ_r" cols="75" rows="2" id="observ_r" onKeyUp="conMayusculas(this)"><?php echo $row_rollo_estrusion_edit['observ_r']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="4" id="fuente5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" id="fuente2">
          <input type="submit" class="botonGeneral" name="button" id="button" value="EDITAR"><!--onClick="envio_form(this);"-->
        </td>
      </tr>
      <tr>
        <td colspan="4" id="dato2"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1">
  </form>
  <?php echo $conexion->header('footer'); ?>
</body>

</html>
<script type="text/javascript">
  function desperdicios() {
    idop = $("#id_op_r").val();
    fechaIni = $("#fecha_ini_rp").val();
    rollito = $("#rollo_r").val();
    if (fechaIni) {
      verFoto('produccion_registro_extrusion_detalle_add.php?id_op=' + idop + '&fecha=' + fechaIni + '&rollo=' + rollito)

    } else {
      swal("Debe agregar una fecha inicial")
    }
  }

  var upload_number = 1;

  function tiemposM() {
    var i = 0;
    var d = document.createElement("div");
    var file0 = document.createElement("select");
    file0.setAttribute("name", "id_rpt[]");
    file0.options[i] = new Option('Seleccione T.Muertos', '');
    i++;
    <?php do { ?>
      file0.options[i] = new Option('<?php echo $row_tiempo_muertos['nombre_rtp'] ?>', '<?php echo $row_tiempo_muertos['id_rtp'] ?>');
      i++;
    <?php
    } while ($row_tiempo_muertos = mysql_fetch_assoc($tiempo_muertos));
    $rows = mysql_num_rows($tiempo_muertos);
    if ($rows > 0) {
      mysql_data_seek($tiempo_muertos, 0);
      $row_tiempo_muertos = mysql_fetch_assoc($tiempo_muertos);
    } ?>
    file0.setAttribute("style", "width:120px");
    d.appendChild(file0);
    var file = document.createElement("input");
    file.setAttribute("type", "number");
    file.setAttribute("name", "valor_tiem_rt[]");
    file.setAttribute("min", "0");
    file.setAttribute("placeholder", "Tiempo minutos");
    file.setAttribute("style", "width:65px");
    d.appendChild(file);

    document.getElementById("moreUploads").appendChild(d);
    upload_number++;
  }
</script>

<script language="javascript" type="text/javascript">
  var upload_number = 1;

  function tiemposP() {
    var i = 0;
    var e = document.createElement("div");
    var file0 = document.createElement("select");
    file0.setAttribute("name", "id_rtp[]");
    file0.options[i] = new Option('Seleccione T.Preparacion', '');
    i++;
    <?php do { ?>
      file0.options[i] = new Option('<?php echo $row_tiempo_preparacion['nombre_rtp'] ?>', '<?php echo $row_tiempo_preparacion['id_rtp'] ?>');
      i++;
    <?php
    } while ($row_tiempo_preparacion = mysql_fetch_assoc($tiempo_preparacion));
    $rows = mysql_num_rows($tiempo_preparacion);
    if ($rows > 0) {
      mysql_data_seek($tiempo_preparacion, 0);
      $row_tiempo_preparacion = mysql_fetch_assoc($tiempo_preparacion);
    } ?>
    file0.setAttribute("style", "width:120px");
    e.appendChild(file0);
    var file = document.createElement("input");
    file.setAttribute("type", "number");
    file.setAttribute("name", "valor_prep_rtp[]");
    file.setAttribute("min", "0");
    file.setAttribute("placeholder", "Tiempo minutos");
    file.setAttribute("style", "width:65px");
    e.appendChild(file);

    document.getElementById("moreUploads2").appendChild(e);
    upload_number++;
  }
</script>

<script language="javascript" type="text/javascript">
  var upload_number = 1;

  function tiemposD() {
    var i = 0;
    var f = document.createElement("div");
    var file0 = document.createElement("select");
    file0.setAttribute("name", "id_rpd[]");
    file0.options[i] = new Option('Seleccione Desperdicio', '');
    i++;
    <?php do { ?>
      file0.options[i] = new Option('<?php echo $row_desperdicios['nombre_rtp'] ?>', '<?php echo $row_desperdicios['id_rtp'] ?>');
      i++;
    <?php
    } while ($row_desperdicios = mysql_fetch_assoc($desperdicios));
    $rows = mysql_num_rows($desperdicios);
    if ($rows > 0) {
      mysql_data_seek($desperdicios, 0);
      $row_desperdicios = mysql_fetch_assoc($desperdicios);
    } ?>
    file0.setAttribute("style", "width:120px");
    f.appendChild(file0);
    var file = document.createElement("input");
    file.setAttribute("type", "number");
    file.setAttribute("name", "valor_desp_rd[]");
    file.setAttribute("min", "0");
    file.setAttribute("step", "0.01");
    file.setAttribute("placeholder", "Kilos");
    file.setAttribute("style", "width:65px");
    f.appendChild(file);

    document.getElementById("moreUploads3").appendChild(f);
    upload_number++;
  }


  //------------------FUNCION PARA AGREGAR ITEMS DINAMICOS----//
  var num = 0;
  var contador = 1

  function AddItemd() {
    var contador = num++;
    var tbody = null;
    var tablaf = document.getElementById("tablaf");
    var nodes = tablaf.childNodes;
    var count = 0;
    var acumula = 0;

    for (var x = 0; x < nodes.length; x++) {
      if (nodes[x].nodeName == 'TD') {
        tbody = nodes[x];
        break;
      }
      count = acumula + x;
    }

    if (tbody != null) {
      contador = contador + 1;
      var tr = document.createElement('tr');
      tr.innerHTML = `<td colspan="2">
          <select oninput=actualizarTotal() name="banderas[]" id="banderas[]" class="banderas">
            <option value="">SELECCIONE</option>
            <option value="apagon">APAGON</option>
            <option value="arrugas">ARRUGAS</option>
            <option value="cortes_huecos">CORTES/HUECOS</option>
            <option value="descalibre">DESCALIBRE</option>
            <option value="medida">MEDIDA</option>
            <option value="montaje">MONTAJE</option>
            <option value="pigmentacion">PIGMENTACION</option>
            <option value="reventon">REVENTON</option>
            <option value="tratamiento">TRATAMIENTO</option>
          </select>

          <input name="metroBandera[]" type="number" id="metroBandera[]" style="width:60px" min="0" value="0">Metros
        </td>`;
      tbody.appendChild(tr);
      contador = contador + 1;
    }

  }

  //funcion para sumar total de las cantidades
  actualizarTotal();

  function actualizarTotal() {
    var cantidades = document.getElementsByClassName("banderas");
    var total = <?php echo $num_banderas ?>;

    for (var i = 0; i < cantidades.length; i++) {
      if (cantidades[i].value != '') {
        var valorCampo = 1; // Convertir a número o usar 0 si no es válido
        total += valorCampo;
      }

    }

    // Actualizar el contenido del campo "total"
    document.getElementById('totales').value = total;
  }
</script>

<?php
mysql_free_result($usuario);

mysql_free_result($codigo_empleado);

mysql_free_result($lista_op);


?>