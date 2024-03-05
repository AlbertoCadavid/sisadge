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

$row_orden = $conexion->llenarCampos("tbl_orden_produccion ", "WHERE id_op='" . $_GET['id_op_r'] . "' AND b_borrado_op='0' ", "ORDER BY id_op DESC", " * ");


//ORDENES DE PRODUCCION
mysql_select_db($database_conexion1, $conexion1);
$query_lista_op = "SELECT id_op,metroLineal_op FROM Tbl_orden_produccion ORDER BY Tbl_orden_produccion.id_op DESC";
$lista_op = mysql_query($query_lista_op, $conexion1) or die(mysql_error());
$row_lista_op = mysql_fetch_assoc($lista_op);
$totalRows_lista_op = mysql_num_rows($lista_op);


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  $insertSQL = sprintf(
    "INSERT INTO TblExtruderRollo ( id_r, rollo_r, id_op_r, ref_r, id_c_r, tratInter_r, tratExt_r, pigmInt_r, pigmExt_r, calibre_r, presentacion_r, cod_empleado_r, turno_r, fechaI_r, fechaF_r, metro_r, kilos_r, reven_r, medid_r, corte_r, desca_r, calib_r, trata_r, arrug_r, bandera_r, montaje_r, apagon_r, observ_r, reven2_r,medid2_r,corte2_r,desca2_r,calib2_r,trata2_r,arrug2_r,apagon2_r,montaje2_r) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

    GetSQLValueString($_POST['id_r'], "int"),
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
    GetSQLValueString($_POST['montaje2_r'],  "text")
  );


  $idRollo = $conexion->insertarQuery($insertSQL); //devuelve el id del nuevo rollo que se guardo para ingresarlo a los desperdicios

  /* Registro de las Banderas */
  if (!empty($_POST['banderas'])) {

    for ($i = 0; $i < sizeof($_POST['banderas']); $i++) {
      $nombre = $_POST['banderas'][$i];
      if ($nombre != "") { //no almacena si viene alguna bandera sin nombre
        $metros = $_POST['metroBandera'][$i];
        $conexion->insertar("tbl_banderas", "`id_op`, `rollo_r`, `nombre`, `metros`, `metros_rollo`, `proceso`", "$_POST[id_op_r], $_POST[rollo_r], '$nombre', $metros, $_POST[metro_r], 1 ");
      }
    }
  }

  /* inicio Tiempos muertos */
  if (!empty($_POST['id_rpt']) && !empty($_POST['valor_tiem_rt'])) {

    foreach ($_POST['id_rpt'] as $key => $v)
      $a[] = $v;
    foreach ($_POST['valor_tiem_rt'] as $key => $v)
      $b[] = $v;
    $c = $_GET['id_op_r'];

    for ($i = 0; $i < count($a); $i++) {
      if (!empty($a[$i]) && !empty($b[$i])) { //no salga error con campos vacios
        $insertSQLt = sprintf(
          "INSERT INTO Tbl_reg_tiempo (id_rpt_rt,id_rollo,valor_tiem_rt,op_rt,int_rollo_rt,id_proceso_rt,fecha_rt) VALUES (%s, %s, %s, %s,%s, %s, %s)",
          GetSQLValueString($a[$i], "int"),
          GetSQLValueString($idRollo, "int"),
          GetSQLValueString($b[$i], "int"),
          GetSQLValueString($c, "int"),
          GetSQLValueString($_POST['rollo_r'], "text"),
          GetSQLValueString($_POST['id_proceso'], "int"),
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
    $c = $_GET['id_op_r'];

    for ($x = 0; $x < count($h); $x++) {
      if (!empty($h[$x]) && !empty($l[$x])) { //no salga error con campos vacios
        $insertSQLp = sprintf(
          "INSERT INTO Tbl_reg_tiempo_preparacion (id_rpt_rtp,id_rollo,valor_prep_rtp,op_rtp,int_rollo_rtp,id_proceso_rtp,fecha_rtp) VALUES (%s, %s, %s, %s,%s, %s, %s)",
          GetSQLValueString($h[$x], "int"),
          GetSQLValueString($idRollo, "int"),
          GetSQLValueString($l[$x], "int"),
          GetSQLValueString($c, "int"),
          GetSQLValueString($_POST['rollo_r'], "text"),
          GetSQLValueString($_POST['id_proceso'], "int"),
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
          GetSQLValueString($idRollo, "int"),
          GetSQLValueString($g[$s], "double"),
          GetSQLValueString($_GET['id_op_r'], "int"),
          GetSQLValueString($_POST['rollo_r'], "text"),
          GetSQLValueString($_POST['id_proceso'], "int"),
          GetSQLValueString($_POST['fechaI_r'], "date"),
          GetSQLValueString($row_orden['int_cod_ref_op'], "text")
        );
        mysql_select_db($database_conexion1, $conexion1);
        $Resultd = mysql_query($insertSQLd, $conexion1) or die(mysql_error());
      }
    }
  }
  /* Fin Desperdicios */

  $insertGoTo = "produccion_extrusion_stiker_rollo_vista.php?id_r=" . $_POST['id_r'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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


//CODIGO EMPLEADO
$row_codigo_empleado = $conexion->llenaSelect('empleado a INNER JOIN TblProcesoEmpleado b ', 'ON a.codigo_empleado=b.codigo_empleado WHERE a.tipo_empleado IN(4) AND b.estado_empleado=1 ', 'ORDER BY a.nombre_empleado ASC');
/*mysql_select_db($database_conexion1, $conexion1);
$query_codigo_empleado = "SELECT codigo_empleado,nombre_empleado FROM empleado WHERE tipo_empleado='4' ORDER BY nombre_empleado ASC";
$codigo_empleado = mysql_query($query_codigo_empleado, $conexion1) or die(mysql_error());
$row_codigo_empleado = mysql_fetch_assoc($codigo_empleado);
$totalRows_codigo_empleado = mysql_num_rows($codigo_empleado);*/

mysql_select_db($database_conexion1, $conexion1);
$query_ultimo = "SELECT * FROM TblExtruderRollo  ORDER BY TblExtruderRollo.id_r DESC";
$ultimo = mysql_query($query_ultimo, $conexion1) or die(mysql_error());
$row_ultimo = mysql_fetch_assoc($ultimo);
$totalRows_ultimo = mysql_num_rows($ultimo);

//ULTIMO ROLLO
$rollito = 0;
$colname_rollo = "-1";
if (isset($_GET['id_op_r'])) {
  $colname_rollo = (get_magic_quotes_gpc()) ? $_GET['id_op_r'] : addslashes($_GET['id_op_r']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_rollo = sprintf("SELECT cod_empleado_r,turno_r,fechaI_r, fechaF_r,id_op_r,rollo_r FROM TblExtruderRollo WHERE id_op_r=%s ORDER BY rollo_r DESC", $colname_rollo); //orden en rollo
$rollo = mysql_query($query_rollo, $conexion1) or die(mysql_error());
$row_rollo = mysql_fetch_assoc($rollo);
$totalRows_rollo = mysql_num_rows($rollo);
//INFORMACION OP
$colname_op_carga = "-1";
if (isset($_GET['id_op_r'])) {
  $colname_op_carga = (get_magic_quotes_gpc()) ? $_GET['id_op_r'] : addslashes($_GET['id_op_r']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_op_carga = sprintf("SELECT id_op, int_cod_ref_op, version_ref_op, int_cliente_op,str_presentacion_op,int_calibre_op,metroLineal_op,str_interno_op,str_externo_op,str_tratamiento_op FROM Tbl_orden_produccion WHERE id_op=%s AND b_borrado_op='0'", $colname_op_carga);
$op_carga = mysql_query($query_op_carga, $conexion1) or die(mysql_error());
$row_op_carga = mysql_fetch_assoc($op_carga);
$totalRows_op_carga = mysql_num_rows($op_carga);




//CARGA LOS TIEMPOS MUERTOS 
$colname_tiempoMuerto = "-1";
if (isset($_GET['id_op_r'])) {
  $colname_tiempoMuerto = (get_magic_quotes_gpc()) ? $_GET['id_op_r'] : addslashes($_GET['id_op_r']);
}

$rollito = $row_rollo['rollo_r'] + 1; //guardar el rollo en desperdicios y consultarlos en esta vista
if ($rollito > '0') {

  $mustraTiemposT =  "AND int_rollo_rt='$rollito' ";
  $mustraTiemposP =  "AND int_rollo_rtp='$rollito' ";
  $mustraTiemposD =  "AND int_rollo_rd='$rollito' ";
}
mysql_select_db($database_conexion1, $conexion1);
$query_tiempoMuerto = sprintf("SELECT * FROM Tbl_reg_tiempo WHERE op_rt=%s AND id_proceso_rt='1' $mustraTiemposT ORDER BY id_rpt_rt ASC", $colname_tiempoMuerto);
$tiempoMuerto = mysql_query($query_tiempoMuerto, $conexion1) or die(mysql_error());
$row_tiempoMuerto = mysql_fetch_assoc($tiempoMuerto);
$totalRows_tiempoMuerto = mysql_num_rows($tiempoMuerto);
//CARGA LOS TIEMPOS PREPARACION 
mysql_select_db($database_conexion1, $conexion1);
$query_tiempoPreparacion = sprintf("SELECT * FROM Tbl_reg_tiempo_preparacion WHERE op_rtp=%s AND id_proceso_rtp='1' $mustraTiemposP ORDER BY id_rpt_rtp ASC", $colname_tiempoMuerto);
$tiempoPreparacion  = mysql_query($query_tiempoPreparacion, $conexion1) or die(mysql_error());
$row_tiempoPreparacion  = mysql_fetch_assoc($tiempoPreparacion);
$totalRows_tiempoPreparacion  = mysql_num_rows($tiempoPreparacion);
//CARGA LOS TIEMPOS  DESPERDICIOS
mysql_select_db($database_conexion1, $conexion1);
$query_desperdicio = sprintf("SELECT * FROM Tbl_reg_desperdicio WHERE op_rd=%s AND id_proceso_rd='1' $mustraTiemposD ORDER BY id_rpd_rd ASC", $colname_tiempoMuerto);
$desperdicio = mysql_query($query_desperdicio, $conexion1) or die(mysql_error());
$row_desperdicio = mysql_fetch_assoc($desperdicio);
$totalRows_desperdicio = mysql_num_rows($desperdicio);

if ($row_tiempoMuerto['fecha_rt'] != '' || $row_tiempoPreparacion['fecha_rtp'] != '' || $row_desperdicio['fecha_rd'] != '') {
  if ($row_tiempoMuerto['fecha_rt'] != '') {
    $fechaibloque = $row_tiempoMuerto['fecha_rt'];
  } elseif ($row_tiempoPreparacion['fecha_rtp'] != '') {
    $fechaibloque = $row_tiempoPreparacion['fecha_rtp'];
  } elseif ($row_desperdicio['fecha_rd'] != '') {
    $fechaibloque = $row_desperdicio['fecha_rd'];
  }
}

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
  <script type="text/javascript" src="js/general.js"></script>

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

</head>

<body>
  <?php echo $conexion->header('vistas'); ?>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="return(validacion_registro_rollo())">
    <table align="center" class="table table-bordered table-sm">
      <tr>
        <td rowspan="4" id="fondo"><img src="images/logoacyc.jpg" width="97" height="71" /></td>
        <td colspan="3" id="titulo2">IDENTIFICACION MATERIALES EXTRUIDOS
          <?php $id_op = $row_op_carga['id_op'];
          $sqlre = "SELECT SUM(metro_r) as metro_r, SUM(kilos_r) as kilos_r FROM TblExtruderRollo WHERE id_op_r='$id_op'";
          $resultre = mysql_query($sqlre);
          $numre = mysql_num_rows($resultre);
          if ($numre >= '1') {
            $kilosR = mysql_result($resultre, 0, 'kilos_r');
            $metrosE = mysql_result($resultre, 0, 'metro_r');
          }
          $sqlrE = "SELECT MAX(rollo_r) AS max_rolloE FROM TblExtruderRollo WHERE id_op_r='$id_op'";
          $resultrE = mysql_query($sqlrE);
          $numrE = mysql_num_rows($resultrE);
          if ($numrE >= '1') {
            $max_rollo = mysql_result($resultrE, 0, 'max_rolloE');
          } ?>
        </td>
      </tr>
      <tr>
        <td colspan="3" id="numero2">ROLLO N&deg; <?php $num = $row_rollo['rollo_r'] + 1;
                                                  echo $num;
                                                  if ($max_rollo != '') {
                                                    echo " de " . $max_rollo;
                                                  } ?>
          <input type="hidden" name="rollo_r" id="rollo_r" style="width:40px" value="<?php echo $num ?>">
          <input type="hidden" name="id_r" id="id_r" value="<?php echo $row_ultimo['id_r'] + 1; ?>">
        </td>
      </tr>
      <tr>
        <td id="talla3">&nbsp;Rollos ingresados hasta el momento:</td>
        <td colspan="2" id="numero"><?php
                                    $id_op = $_GET['id_op_r'];
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
        <td colspan="4" id="fuente3"><?php if ($row_rollo['id_op_r'] != '') { ?><a href="produccion_extrusion_listado_rollos.php?id_op_r=<?php echo $row_rollo['id_op_r']; ?>"><img src="images/opciones.gif" alt="LISTADO ROLLOS" title="LISTADO ROLLO" border="0" style="cursor:hand;" /></a><?php } ?><a href="javascript:location.reload()"><img src="images/ciclo1.gif" alt="RESTAURAR" title="RESTAURAR" border="0" style="cursor:hand;" /></a></td>
      </tr>
      <tr>
        <td colspan="4" id="titulo1">INFORMACION GENERAL DE LA O.P.</td>
      </tr>
      <tr>
        <td id="fuente1">ORDEN P</td>
        <td id="fuente1">
          <input type="text" name="id_op_r" id="id_op_r" min="0" max="20" style=" width:100px" value="<?php echo $row_op_carga['id_op']; ?>" readonly="readonly">
          <!-- <select name="id_op_r" id="id_op_r" style="width:100px" onchange="if(form1.id_op_r.value) { consulta_rollo_E(); }else { alert('Debe Seleccionar una O.P')}" autofocus>
              <option value=""<?php if (!(strcmp("", $row_op_carga['id_op']))) {
                                echo "selected=\"selected\"";
                              } ?>>Seleccione</option>
              <?php
              do {
              ?>
             			 <option value="<?php echo $row_lista_op['id_op'] ?>"<?php if (!(strcmp($row_lista_op['id_op'], $row_op_carga['id_op']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo $row_lista_op['id_op'] ?></option>
             						  <?php
                          } while ($row_lista_op = mysql_fetch_assoc($lista_op));
                          $rows = mysql_num_rows($lista_op);
                          if ($rows > 0) {
                            mysql_data_seek($lista_op, 0);
                            $row_lista_op = mysql_fetch_assoc($lista_op);
                          }
                            ?>
            </select> -->

        </td>
        <td id="fuente1">REF.</td>
        <td id="fuente1"><input type="number" name="ref_r" id="ref_r" min="0" max="20" style=" width:100px" value="<?php echo $row_op_carga['int_cod_ref_op']; ?>" readonly></td>
      </tr>
      <tr>
        <td id="fuente1">CLIENTE</td>
        <td colspan="3" id="fuente1"><?php $id_c = $row_op_carga['int_cliente_op'];
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
            <option value="N.A" <?php if (!(strcmp('N.A', $row_op_carga['str_tratamiento_op']))) {
                                  echo "selected=\"selected\"";
                                } ?>>N.A</option>
            <option value="UNA CARA" <?php if (!(strcmp('UNA CARA', $row_op_carga['str_tratamiento_op']))) {
                                        echo "selected=\"selected\"";
                                      } ?>>UNA CARA</option>
            <option value="DOBLE CARA" <?php if (!(strcmp('DOBLE CARA', $row_op_carga['str_tratamiento_op']))) {
                                          echo "selected=\"selected\"";
                                        } ?>>DOBLE CARA</option>
          </select></td>
        <td id="fuente1">TRATADO EXTERNO</td>
        <td id="fuente1"><select name="tratExt_r" id="tratExt_r" style="width:100px">
            <option value="N.A" <?php if (!(strcmp('N.A', $row_op_carga['str_tratamiento_op']))) {
                                  echo "selected=\"selected\"";
                                } ?>>N.A</option>
            <option value="UNA CARA" <?php if (!(strcmp('UNA CARA', $row_op_carga['str_tratamiento_op']))) {
                                        echo "selected=\"selected\"";
                                      } ?>>UNA CARA</option>
            <option value="DOBLE CARA" <?php if (!(strcmp('DOBLE CARA', $row_op_carga['str_tratamiento_op']))) {
                                          echo "selected=\"selected\"";
                                        } ?>>DOBLE CARA</option>
          </select></td>
      </tr>
      <tr>
        <td id="fuente1">PIGMENTO INTERIOR</td>
        <td id="fuente1"><input name="pigmInt_r" type="text" onKeyUp="conMayusculas(this)" value="<?php echo $row_op_carga['str_interno_op']; ?>" size="11" readonly /></td>
        <td id="fuente1">PIGMENTO EXTERIOR</td>
        <td id="fuente1"><input name="pigmExt_r" type="text" onKeyUp="conMayusculas(this)" value="<?php echo $row_op_carga['str_externo_op']; ?>" size="11" readonly /></td>
      </tr>
      <tr>
        <td id="fuente1">CALIBRE MILS.</td>
        <td id="fuente1"><input name="calibre_r" type="text" id="calibre_r" value="<?php echo $row_op_carga['int_calibre_op']; ?>" size="11" readonly /></td>
        <td id="fuente1">PRESENTACION</td>
        <td id="fuente1"><input name="presentacion_r" type="text" value="<?php echo $row_op_carga['str_presentacion_op']; ?>" size="11" readonly /></td>
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

          <select name="cod_empleado_r" id="montaje">
            <option value="" <?php if (!(strcmp("", $row_rollo['cod_empleado_r']))) {
                                echo "selected=\"selected\"";
                              } ?>>Seleccione</option>
            <?php foreach ($row_codigo_empleado as $row_codigo_empleado) { ?>
              <option value="<?php echo $row_codigo_empleado['codigo_empleado'] ?>" <?php if (!(strcmp($row_codigo_empleado['codigo_empleado'], $row_rollo['cod_empleado_r']))) {
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
        <td id="fuente1"><input type="number" name="turno_r" id="turno_r" min="1" max="7" style="width:40px" required value="<?php echo $row_rollo['turno_r']; ?>"></td>
        <td id="fuente1">&nbsp;</td>
        <td id="fuente1">&nbsp;</td>
      </tr>
      <tr>
        <td id="fuente1">FECHA INICIO ROLLO</td>
        <td id="fuente1">
          <?php

          $horaIni = restoHoranew2(2);

          $ultimaF = $row_rollo['fechaF_r'] == '' ? date("Y-m-d " . $horaIni) : $row_rollo['fechaF_r'];
          $horaAdd = '16'; //16 es si la fecha del ultimo rollo supera en 16 horas entonces coloca la actual


          $fechahoraofinal = sumarHorasparam($ultimaF, $horaAdd);

          ?>
          <input name="fechaI_r" id="fecha_ini_rp" min="2000-01-02" type="datetime-local" size="15" value="<?php echo $fechaibloque == '' ? $fechahoraofinal : $fechaibloque; ?>" required="required" <?php if ($fechaibloque != '') { ?> readonly="readonly" <?php } ?> />
        </td>
        <td colspan="2" id="fuente1">
          <p>FECHA FIN ROLLO
          </p>
          <p>
            <input name="fechaF_r" id="fecha_fin_rp" type="datetime-local" min="2000-01-02" size="15" value="" onblur="validacion_registro_rollo();" required="required" />
          </p>
        </td>
      </tr>
      <tr>
        <td id="fuente1">METRO LINEAL</td>
        <td id="fuente1"><input name="metro_r" type="number" id="metro_r" min="1" style="width:100px" value="" required="required" /> <?php //echo redondear_decimal($metrosE/$max_rollo); 
                                                                                                                                      ?>
          de <?php if ($row_op_carga['metroLineal_op'] == '') {
                echo $row_lista_op['metroLineal_op'];
              } else {
                echo $row_op_carga['metroLineal_op'];
              }  ?></td>
        <td id="fuente1">PESO</td>
        <td id="fuente1"><input name="kilos_r" type="number" id="kilos_r" min="1.00" step="0.01" style="width:100px" value="" required="required" /><?php //echo redondear_decimal($kilosR/$max_rollo); 
                                                                                                                                                    ?></td>
      </tr>
      <tr>
        <td colspan="3" id="titulo1">DEFECTOS</td>
      </tr>

      <!-- Desperdicio -->
      <tr id="tr1">
        <td style="text-align:center" colspan="1" id="dato1">Tiempos Muertos</td>
        <td style="text-align:center" id="dato1">Tiempos Preparacion</td>
        <td style="text-align:center" id="dato1">Desperdicios</td>
      </tr>
      <tr id="tr1">
        <td colspan="1" id="dato1"><input type="button" class="botonFinalizar" name="button" id="button" value="Crear otra fila" onclick="tiemposM()" style="width:193px" /></td>
        <td id="dato1" style="text-align:center"><input type="button" name="button2" class="botonFinalizar" id="button2" value="Crear otra fila" onclick="tiemposP()" style="width:193px" /></td>
        <td id="dato1"><input type="button" name="button3" class="botonFinalizar" id="button3" value="Crear otra fila" onclick="tiemposD()" style="width:193px" /></td>
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
      <!-- fin desperdicio  -->

      <!--inicio cuadro de tiempos muertos a -->
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
                                                                                                  echo $delrt; ?>,'id_op_r',<?php echo $_GET['id_op_r']; ?>,'Tbl_reg_tiempo','produccion_extrusion_stiker_rollo_add.php')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a>
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
                                                                                                  echo $delrp; ?>,'id_op_r',<?php echo $_GET['id_op_r']; ?>,'Tbl_reg_tiempo_preparacion','produccion_extrusion_stiker_rollo_add.php')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a></td>
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
                                                                                                  echo $delrd; ?>,'id_op_r',<?php echo $_GET['id_op_r']; ?>,'Tbl_reg_desperdicio','produccion_extrusion_stiker_rollo_add.php')"><img src="images/por.gif" style="cursor:hand;" alt="ELIMINAR " title="ELIMINAR" border="0"></a></td>
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
      <tr>
        <td colspan="4" id="titulo1">BANDERAS</td>
      </tr>

      <tr>
      <tr id="tablaf">

        <td colspan="2">
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

          <input name="metroBandera[]" type="number" id="metroBandera[]" style="width:60px" min="0" value="0" onblur="validacionBanderasExt()">Metros
        </td>
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
        <td colspan="4" id="fuente2"><textarea name="observ_r" cols="75" rows="2" id="observ_r" onKeyUp="conMayusculas(this)"></textarea></td>
      </tr>
      <tr>
        <td colspan="4" id="fuente5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" id="fuente2"><input type="submit" class="botonGeneral" name="button" id="buttonExt" value="GUARDAR"><!--onClick="envio_form(this);"--></td>
      </tr>
      <tr>
        <td colspan="4" id="dato2"></td>
      </tr>
    </table>
    <input name="id_proceso" type="hidden" id="id_proceso" value="1" />
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <?php echo $conexion->header('footer'); ?>
</body>

</html>
<script type="text/javascript">
  function desperdicios() {
    idop = "<?php echo $_GET['id_op_r'] ?>";
    fechaIni = $("#fecha_ini_rp").val();
    rollito = $("#rollo_r").val();
    operario = $("#montaje").val();
    turno = $("#turno_r").val();
    fechaFin = $("#fecha_fin_rp").val();
    metros = $("#metro_r").val();
    peso = $("#kilos_r").val();

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

          <input name="metroBandera[]" type="number" id="metroBandera[]" style="width:60px" min="0" value="0" onblur="validacionBanderasExt()">Metros
        </td>`;
      tbody.appendChild(tr);
      contador = contador + 1;
    }

  }

  //funcion para sumar total de las cantidades

  function actualizarTotal() {
    var cantidades = document.getElementsByClassName("banderas");
    var total = 0;

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

mysql_free_result($ultimo);

mysql_free_result($lista_op);

mysql_free_result($op_carga);

?>

<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  echo "<script type=\"text/javascript\">window.opener.location.reload();</script>";
  echo "<script type=\"text/javascript\">window.close();</script>";
}
?>