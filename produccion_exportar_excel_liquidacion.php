<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php

require_once('Connections/conexion1.php');

require_once('funciones/funciones_php.php');

?>
<?php
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Transfer-Encoding: none');
header('Content-Type: application/vnd.ms-excel');
header('Content-type: application/x-msexcel');
header('Content-Disposition: attachment; filename="Produccion.xls"');
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
?>
<?php

$conexion = new ApptivaDB();

$currentPage = $_SERVER["PHP_SELF"];
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$tipoListado = $_GET['tipoListado']; //variable de control del case
$var1 = $_GET['op'];
$var2 = $_GET['id_ref'];
$anyo = $_GET['anyo'];
$var3 = $_GET['mes'];
$maquina = $_GET['maquina'];
$date = date("Y");
switch ($tipoListado) {

  case "4":

    mysql_select_db($database_conexion1, $conexion1);
    // AÑO Y MES LLENOS
    if ($_GET['op'] == '0' && $_GET['anyo'] != '0' && $_GET['mes'] != '0') {

      $query_orden_produccion = "SELECT tsr.id_r, tsr.id_op_r, tsr.rollo_r, tsr.ref_r, tsr.metro_r, tsr.cod_empleado_r,tsr.cod_auxiliar_r, tsr.turno_r,tsr.fechaI_r,tsr.fechaF_r, DATE_FORMAT(tsr.fechaI_r, '%k:%i:%s') AS TIEMPOINI, DATE_FORMAT(tsr.fechaF_r,'%k:%i:%s') AS TIEMPOFIN, DATE_FORMAT(tsr.fechaI_r, '%Y-%m-%d') AS DATEINI, DATE_FORMAT(tsr.fechaF_r, '%Y-%m-%d') AS DATEFIN, TIMEDIFF(MAX(tsr.fechaF_r), MIN(tsr.fechaI_r)) AS TIEMPODIFE, SUM(tsr.kilos_r) AS KILOS, SUM(tsr.reproceso_r) AS reproceso, SUM(tsr.bolsas_r) AS BOLSAS, maquina.nombre_maquina as maquina_r,tsr.rolloParcial_r 
          FROM TblSelladoRollo  tsr
          INNER JOIN maquina ON tsr.maquina_r = maquina.id_maquina
          WHERE YEAR(tsr.fechaI_r) = " . $_GET['anyo'] . " AND MONTH(tsr.fechaI_r) = " . $_GET['mes'] . " 
          GROUP BY tsr.id_op_r,tsr.fechaI_r,tsr.cod_empleado_r,tsr.cod_auxiliar_r ASC "; //GROUP BY `fechaI_r`,`cod_empleado_r`,`cod_auxiliar_r` ASC
      $orden_produccion = mysql_query($query_orden_produccion, $conexion1) or die(mysql_error());
      $row_orden_produccion = mysql_fetch_assoc($orden_produccion);
      $totalPages_orden_produccion = mysql_num_rows($orden_produccion);
    } else
      // AÑO LLENOS
      if ($_GET['op'] == '0' && $_GET['anyo'] != '0' && $_GET['mes'] == '0') {

        $query_orden_produccion = "SELECT tsr.id_r, tsr.id_op_r, tsr.rollo_r, tsr.ref_r, tsr.metro_r, tsr.cod_empleado_r,tsr.cod_auxiliar_r, tsr.turno_r,tsr.fechaI_r,tsr.fechaF_r, DATE_FORMAT(tsr.fechaI_r, '%k:%i:%s') AS TIEMPOINI, DATE_FORMAT(tsr.fechaF_r,'%k:%i:%s') AS TIEMPOFIN, DATE_FORMAT(tsr.fechaI_r, '%Y-%m-%d') AS DATEINI, DATE_FORMAT(tsr.fechaF_r, '%Y-%m-%d') AS DATEFIN, TIMEDIFF(MAX(tsr.fechaF_r), MIN(tsr.fechaI_r)) AS TIEMPODIFE, SUM(tsr.kilos_r) AS KILOS, SUM(tsr.reproceso_r) AS reproceso, SUM(tsr.bolsas_r) AS BOLSAS, maquina.nombre_maquina as maquina_r,tsr.rolloParcial_r 
          FROM TblSelladoRollo  tsr
          INNER JOIN maquina ON tsr.maquina_r = maquina.id_maquina
          WHERE YEAR(tsr.fechaI_r) = " . $_GET['anyo'] . " 
          GROUP BY tsr.id_op_r,tsr.fechaI_r,tsr.cod_empleado_r,tsr.cod_auxiliar_r ASC";
        $orden_produccion = mysql_query($query_orden_produccion, $conexion1) or die(mysql_error());
        $row_orden_produccion = mysql_fetch_assoc($orden_produccion);
        $totalPages_orden_produccion = mysql_num_rows($orden_produccion);
      } else
     if ($_GET['op'] != '0' && $_GET['anyo'] != '0' && $_GET['mes'] == '0') {

        $query_orden_produccion = "SELECT tsr.id_r, tsr.id_op_r, tsr.rollo_r, tsr.ref_r, tsr.metro_r, tsr.cod_empleado_r,tsr.cod_auxiliar_r, tsr.turno_r,tsr.fechaI_r,tsr.fechaF_r, DATE_FORMAT(tsr.fechaI_r, '%k:%i:%s') AS TIEMPOINI, DATE_FORMAT(tsr.fechaF_r,'%k:%i:%s') AS TIEMPOFIN, DATE_FORMAT(tsr.fechaI_r, '%Y-%m-%d') AS DATEINI, DATE_FORMAT(tsr.fechaF_r, '%Y-%m-%d') AS DATEFIN, TIMEDIFF(MAX(tsr.fechaF_r), MIN(tsr.fechaI_r)) AS TIEMPODIFE, SUM(tsr.kilos_r) AS KILOS, SUM(tsr.reproceso_r) AS reproceso, SUM(tsr.bolsas_r) AS BOLSAS, maquina.nombre_maquina as maquina_r,tsr.rolloParcial_r 
          FROM TblSelladoRollo  tsr
          INNER JOIN maquina ON tsr.maquina_r = maquina.id_maquina
          WHERE tsr.id_op_r = " . $_GET['op'] . " AND YEAR(tsr.fechaI_r) = " . $_GET['anyo'] . " 
          GROUP BY tsr.id_op_r,tsr.fechaI_r,tsr.cod_empleado_r,tsr.cod_auxiliar_r ASC";
        $orden_produccion = mysql_query($query_orden_produccion, $conexion1) or die(mysql_error());
        $row_orden_produccion = mysql_fetch_assoc($orden_produccion);
        $totalPages_orden_produccion = mysql_num_rows($orden_produccion);
      } else
     if ($_GET['op'] != '0' && $_GET['anyo'] != '0' && $_GET['mes'] != '0') {
        $query_orden_produccion = "SELECT tsr.id_r, tsr.id_op_r, tsr.rollo_r, tsr.ref_r, tsr.metro_r, tsr.cod_empleado_r,tsr.cod_auxiliar_r, tsr.turno_r,tsr.fechaI_r,tsr.fechaF_r, DATE_FORMAT(tsr.fechaI_r, '%k:%i:%s') AS TIEMPOINI, DATE_FORMAT(tsr.fechaF_r,'%k:%i:%s') AS TIEMPOFIN, DATE_FORMAT(tsr.fechaI_r, '%Y-%m-%d') AS DATEINI, DATE_FORMAT(tsr.fechaF_r, '%Y-%m-%d') AS DATEFIN, TIMEDIFF(MAX(tsr.fechaF_r), MIN(tsr.fechaI_r)) AS TIEMPODIFE, SUM(tsr.kilos_r) AS KILOS, SUM(tsr.reproceso_r) AS reproceso, SUM(tsr.bolsas_r) AS BOLSAS, maquina.nombre_maquina as maquina_r,tsr.rolloParcial_r 
          FROM TblSelladoRollo  tsr
          INNER JOIN maquina ON tsr.maquina_r = maquina.id_maquina
          WHERE tsr.id_op_r = " . $_GET['op'] . " AND YEAR(tsr.fechaI_r) = " . $_GET['anyo'] . " AND MONTH(tsr.fechaI_r) = " . $_GET['mes'] . " 
          GROUP BY tsr.id_op_r,tsr.fechaI_r,tsr.cod_empleado_r,tsr.cod_auxiliar_r ASC";
        $orden_produccion = mysql_query($query_orden_produccion, $conexion1) or die(mysql_error());
        $row_orden_produccion = mysql_fetch_assoc($orden_produccion);
        $totalPages_orden_produccion = mysql_num_rows($orden_produccion);
      } else
        // AÑO LLENOS
        if ($_GET['anyo'] == '0' && $_GET['mes'] != '0') {

          echo "Debe seleccionar un Año ya que esto sobrecarga la base de datos !";
          die;
        } else {

          echo "Debe seleccionar un Año o mes o ambos para no sobrecargar la base de datos !";
          die;
        }
    /*$query_orden_produccion = "SELECT * FROM Tbl_reg_produccion WHERE id_proceso_rp ='4' ORDER BY Tbl_reg_produccion.id_op_rp DESC";
      $orden_produccion = mysql_query($query_orden_produccion, $conexion1) or die(mysql_error());
      $row_orden_produccion = mysql_fetch_assoc($orden_produccion);
      $totalPages_orden_produccion = mysql_num_rows($orden_produccion);*/
    break;
}

?>
<html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>

<body>
  <?php
  switch ($tipoListado) {
    case "4":
  ?>

      <!--SELLADO -->
      <table id="Exportar_a_Excel" border="1">

        <tr id="tr1">
          <td nowrap="nowrap" id="titulo4">N&deg; O.P </td>
          <td nowrap="nowrap" id="titulo4">CLIENTE</td>
          <td nowrap="nowrap" id="titulo4">REF. </td>
          <td nowrap="nowrap" id="titulo4" style="border: solid 2px red ;"><b>ROLLO</b></td>
          <td nowrap="nowrap" id="titulo4">KILOS</td>
          <td nowrap="nowrap" id="titulo4">KILOS DESP.</td>
          <td nowrap="nowrap" id="titulo4">TIEMPOS TOTAL</td>
          <td nowrap="nowrap" id="titulo4">TIEMPOS MUERTOS</td>
          <td nowrap="nowrap" id="titulo4">TIEMPOS PREPARACION</td>
          <td nowrap="nowrap" id="titulo4"><b>TIEMPOS OPERATIVO</b></td>
          <td nowrap="nowrap" id="titulo4">BOLSAS X TURNO</td>
          <td nowrap="nowrap" id="titulo4">METROS LINEAL</td>
          <td nowrap="nowrap" id="titulo4">TURNO</td>
          <td nowrap="nowrap" id="titulo4">MAQUINA</td>
          <td nowrap="nowrap" id="titulo4">PLACA</td>
          <td nowrap="nowrap" id="titulo4">BOLSAS/UND</td>
          <td nowrap="nowrap" id="titulo4">LAMINA 1</td>
          <td nowrap="nowrap" id="titulo4">LAMINA 2</td>
          <td nowrap="nowrap" id="titulo4">NUMERACION INICIAL</td>
          <td nowrap="nowrap" id="titulo4">NUMERACION FINAL</td>
          <td nowrap="nowrap" id="titulo4">FECHA INICIO</td>
          <td nowrap="nowrap" id="titulo4">HORA INICIO</td>
          <td nowrap="nowrap" id="titulo4">FECHA FINAL</td>
          <td nowrap="nowrap" id="titulo4">HORA FIN</td>
          <td nowrap="nowrap" id="titulo4">OPERARIO</td>
          <td nowrap="nowrap" id="titulo4">REVISOR</td>
          <td nowrap="nowrap" id="titulo4">ESTADO</td>
        </tr>
        <?php do { ?>
          <tr>
            <td nowrap="nowrap" id="dato2"><?php echo $row_orden_produccion['id_op_r']; ?></td>
            <td nowrap="nowrap" id="dato2">
              <?php
              $op_c = $row_orden_produccion['id_op_r'];
              $num_rollo = $row_orden_produccion['rollo_r'];

              if ($num_rollo != '') {
                $query_liquidacion = "SELECT trp.id_rp,trp.placa_rp,trp.lam1_rp,trp.lam2_rp,trp.n_ini_rp,trp.n_fin_rp,DATE_FORMAT(trp.fecha_ini_rp, '%k:%i:%s') AS fechaI_r ,trp.fecha_fin_rp, trp.b_borrado_rp
          FROM tbl_reg_produccion trp WHERE trp.id_op_rp=$op_c AND trp.rollo_rp=$num_rollo AND trp.id_proceso_rp='4' ORDER BY trp.id_op_rp DESC";
                $liquidacion = mysql_query($query_liquidacion, $conexion1) or die(mysql_error());
                $row_liquidacion = mysql_fetch_assoc($liquidacion);
              }


              $sqln = "SELECT cliente.nombre_c FROM Tbl_orden_produccion, cliente WHERE Tbl_orden_produccion.id_op='$op_c' AND Tbl_orden_produccion.int_cliente_op=cliente.id_c";
              $resultn = mysql_query($sqln);
              $numn = mysql_num_rows($resultn);
              if ($numn >= '1') {
                $nombre_cliente_c = mysql_result($resultn, 0, 'nombre_c');
                $ca = ($nombre_cliente_c);
                echo $ca;
              } else {
                echo "";
              } ?>
              </a></td>
            <td id="dato2"><?php echo $row_orden_produccion['ref_r']; ?></td>
            <td id="dato2"><?php echo $num_rollo; ?></td>
            <td id="dato2"><?php echo round($row_orden_produccion['KILOS'], 2); ?></td>
            <td id="dato2"><?php

                            $fechaI = $row_orden_produccion['fechaI_r'];

                            if ($num_rollo != '') {
                              $query_desperdicio = "SELECT *, (SUM(trd.valor_desp_rd) ) AS T_desp FROM tbl_reg_desperdicio trd WHERE trd.op_rd=$op_c AND trd.int_rollo_rd=$num_rollo AND trd.id_proceso_rd='4' AND trd.fecha_rd='$fechaI' GROUP BY trd.int_rollo_rd ASC";
                              $desperdicio = mysql_query($query_desperdicio, $conexion1) or die(mysql_error());
                              $row_desperdicio = mysql_fetch_assoc($desperdicio);
                              echo $row_desperdicio['T_desp'];
                            }
                            //echo $row_orden_produccion['int_kilos_desp_rp']; 
                            ?></td>
            <td id="dato2"><?php
                            $tiempototal = $row_orden_produccion['TIEMPODIFE'];
                            $totaltiempo = horadecimalUna($tiempototal);
                            echo $totaltiempo; ?></td>
            <td id="dato2"><?php
                            if ($num_rollo != '') {
                              $query_tiempoMuerto = "SELECT SUM(trt.valor_tiem_rt) AS muertos FROM Tbl_reg_tiempo trt WHERE trt.op_rt=$op_c AND trt.id_rpt_rt <> '141' AND trt.int_rollo_rt=$num_rollo AND trt.id_proceso_rt='4' AND trt.fecha_rt='$fechaI'";
                              $tiempoMuerto = mysql_query($query_tiempoMuerto, $conexion1) or die(mysql_error());
                              $row_tiempoMuerto = mysql_fetch_assoc($tiempoMuerto);
                              echo  $TPREMU = round($row_tiempoMuerto['muertos'] / 60, 2);
                            }
                            ?></td>
            <td id="dato2"><?php
                            if ($num_rollo != '') {
                              $query_tiempoPreparacion = "SELECT SUM(trp.valor_prep_rtp) AS preparacion FROM Tbl_reg_tiempo_preparacion trp WHERE trp.op_rtp=$op_c AND trp.int_rollo_rtp=$num_rollo AND trp.id_proceso_rtp='4' AND trp.fecha_rtp='$fechaI'";
                              $tiempoPreparacion  = mysql_query($query_tiempoPreparacion, $conexion1) or die(mysql_error());
                              $row_tiempoPreparacion  = mysql_fetch_assoc($tiempoPreparacion);
                              echo round($row_tiempoPreparacion['preparacion'] / 60, 2);
                            }
                            ?></td>
            <td id="dato2"><?php echo $tiempOperativo = ($totaltiempo - $TPREMU); ?></td>
            <td id="dato1"><?php echo round((($row_orden_produccion['BOLSAS'] / $tiempOperativo) * 8.0), 2); ?></td>
            <td id="dato2"><?php echo $row_orden_produccion['metro_r']; ?></td>
            <td id="dato2"><?php echo $row_orden_produccion['turno_r']; ?></td>
            <td id="dato2"><?php echo $row_orden_produccion['maquina_r']; ?></td>
            <td id="dato2" nowrap="nowrap">
              <?php
              echo $row_liquidacion['placa_rp'];
              ?></td>
            <td id="dato2"><?php echo $row_orden_produccion['BOLSAS']; ?></td>
            <td id="dato2"><?php echo $row_liquidacion['lam1_rp']; ?></td>
            <td id="dato2"><?php echo $row_liquidacion['lam2_rp']; ?></td>
            <td id="dato2"><?php echo $row_liquidacion['n_ini_rp']; ?></td>
            <td id="dato2"><?php echo $row_liquidacion['n_fin_rp']; ?></td>
            <td nowrap="nowrap" id="dato2"><?php echo $row_orden_produccion['DATEINI']; ?></td>
            <td nowrap="nowrap" id="dato2"><?php echo $row_orden_produccion['TIEMPOINI']; ?></td>
            <td nowrap="nowrap" id="dato2"><?php echo $row_orden_produccion['DATEFIN']; ?></td>
            <td nowrap="nowrap" id="dato2"><?php echo $row_orden_produccion['TIEMPOFIN']; ?></td>
            <td nowrap="nowrap" id="dato2">
              <?php
              echo $id_emp = $row_orden_produccion['cod_empleado_r'];
              /*$sqlemp="SELECT * FROM empleado WHERE codigo_empleado='$id_emp' ";
	  $resultemp= mysql_query($sqlemp);
	  $numemp= mysql_num_rows($resultemp);
	  if($numemp >='1')
	  { 
	  $nombre = mysql_result($resultemp, 0, 'nombre_empleado');echo $nombre; 
	  }*/ ?>
            </td>
            <td nowrap="nowrap" id="dato2">
              <?php
              echo $id_emp = $row_orden_produccion['cod_auxiliar_r'];
              /*$sqlemp="SELECT * FROM empleado WHERE codigo_empleado='$id_emp' ";
	  $resultemp= mysql_query($sqlemp);
	  $numemp= mysql_num_rows($resultemp);
	  if($numemp >='1')
	  { 
	  $nombre = mysql_result($resultemp, 0, 'nombre_empleado');echo $nombre; 
	  }*/ ?>
            </td>
            <td nowrap="nowrap" id="dato2">
              <?php

              echo $row_liquidacion['b_borrado_rp'] == '0' ? "Activa" : "Inactiva";

              ?>
            </td>
          </tr>
        <?php } while ($row_orden_produccion = mysql_fetch_assoc($orden_produccion)); ?>
      </table>

  <?php
      break;
  }
  ?>
</body>

</html>
<?php
mysql_free_result($usuario);

mysql_free_result($orden_produccion);

?>