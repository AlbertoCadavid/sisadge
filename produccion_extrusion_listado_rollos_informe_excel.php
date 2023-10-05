<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php require_once('Connections/conexion1.php'); ?>

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
header('Content-Disposition: attachment; filename="Listado de rollos.xls"'); 
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

$maxRows_proceso_rollos = 99;
$pageNum_proceso_rollos = 0;
if (isset($_GET['pageNum_proceso_rollos'])) {
  $pageNum_proceso_rollos = $_GET['pageNum_proceso_rollos'];
}
$startRow_proceso_rollos = $pageNum_proceso_rollos * $maxRows_proceso_rollos;



$colname_rollo_cola = "-1";
if (isset($_GET['id_op_r'])) {
  $colname_rollo_cola = (get_magic_quotes_gpc()) ? $_GET['id_op_r'] : addslashes($_GET['id_op_r']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_rollo_estrusion = sprintf("SELECT * FROM TblExtruderRollo WHERE TblExtruderRollo.id_op_r=%s", $colname_rollo_cola, $startRow_proceso_rollos, $maxRows_proceso_rollos);
$rollo_estrusion = mysql_query($query_rollo_estrusion, $conexion1) or die(mysql_error());
$row_rollo_estrusion = mysql_fetch_assoc($rollo_estrusion);
$totalRows_rollo_estrusion = mysql_num_rows($rollo_estrusion);

if (isset($_GET['totalRows_proceso_rollos'])) {
  $totalRows_proceso_rollos = $_GET['totalRows_proceso_rollos'];
} else {
  $all_proceso_rollos = mysql_query($query_rollo_estrusion);
  $totalRows_proceso_rollos = mysql_num_rows($all_proceso_rollos);
}
$totalPages_proceso_rollos = ceil($totalRows_proceso_rollos / $maxRows_proceso_rollos) - 1;

if (isset($_GET['info'])) {
  // Obtiene el objeto serializado de la URL y lo decodifica
  $objetoCodificado = $_GET['info'];
  $objetoDeserializado = urldecode($objetoCodificado);

  // Convierte el objeto JSON en un array asociativo de PHP
  $objetoArray = json_decode($objetoDeserializado, true);

}

?><html>

<head>
  <title>SISADGE AC &amp; CIA</title>

</head>

<body>


  <table id="tabla1">
    <tr>
    <tr>
      <td colspan="2" align="center">
        <table class="table table-bordered table-sm">
          
          <tr>
            <td id="subtitulo"><strong> LISTADO DE ROLLOS </strong></td>
          </tr>

          <tr>
            <td id="subtitulo1">ORDEN DE PRODUCCION:</td>
            <td id="fuente2"><?php echo $_GET['id_op_r'] ?></td>
          </tr>
          <tr>
            <td id="subtitulo1">CANTIDAD DE ROLLOS:</td>
            <td id="fuente2" class="rollos"><?php echo $_GET['rollos'] ?> </td>
          </tr>
          <tr>
            <td id="subtitulo1">METROS TOTALES:</td>
            <td id="fuente2" class="metros"><?php echo $_GET['metros'] ?></td>
          </tr>
          <tr>
            <td id="subtitulo1">KILOS TOTALES:</td>
            <td id="fuente2" class="kilos"><?php echo $_GET['kilos'] ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>

        </table>

        <table id="tabla1">
          <tr id="tr1">
            <td nowrap="nowrap" id="titulo4"  style="text-align: right;">ROLLO N&deg;</td>
            <td nowrap="nowrap" id="titulo4">KILOS</td>
            <td nowrap="nowrap" id="titulo4">METRO</td>
            <td nowrap="nowrap" id="titulo4">OPERARIO</td>
          </tr>
          <?php foreach ($objetoArray as $value) { ?>
            <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
            <td id="dato2"><?php echo $value['rollo']; ?></td>
            <td id="dato2"><?php echo $value['kilos']; ?></td>
            <td id="dato2"><?php echo $value['metros']; ?></td>
            <td id="dato2"><?php echo $value['operario']; ?></td>
            </tr>  
          <?php } ?>
          
          <tr bgcolor="#FFFFFF">

            <td id="dato3"> <strong> TOTAL: </strong></td>
            <td id="dato2"><strong><?php echo $_GET['kilos'] ?></strong></td>
            <td id="dato2"><strong><?php echo $_GET['metros'] ?></strong></td>
            <td id="dato1">&nbsp;</td>
            <td id="dato1">&nbsp;</td>
            <td id="dato1">&nbsp;</td>
            <td id="dato1">&nbsp;</td>
          </tr>

          <table id="tabla3">
            <tr>
              <td width="23%" align="center" id="dato2"><?php if ($pageNum_proceso_rollos > 0) { // Show if not first page 
                                                        ?>
                  <a href="<?php printf("%s?pageNum_proceso_rollos=%d%s", $currentPage, 0, $queryString_proceso_rollos); ?>">Primero</a>
                <?php } // Show if not first page 
                ?>
              </td>
              <td width="31%" align="center" id="dato2"><?php if ($pageNum_proceso_rollos > 0) { // Show if not first page 
                                                        ?>
                  <a href="<?php printf("%s?pageNum_proceso_rollos=%d%s", $currentPage, max(0, $pageNum_proceso_rollos - 1), $queryString_proceso_rollos); ?>">Anterior</a>
                <?php } // Show if not first page 
                ?>
              </td>
              <td width="23%" align="center" id="dato2"><?php if ($pageNum_proceso_rollos < $totalPages_proceso_rollos) { // Show if not last page 
                                                        ?>
                  <a href="<?php printf("%s?pageNum_proceso_rollos=%d%s", $currentPage, min($totalPages_proceso_rollos, $pageNum_proceso_rollos + 1), $queryString_proceso_rollos); ?>">Siguiente</a>
                <?php } // Show if not last page 
                ?>
              </td>
              <td width="23%" align="center" id="dato2"><?php if ($pageNum_proceso_rollos < $totalPages_proceso_rollos) { // Show if not last page 
                                                        ?>
                  <a href="<?php printf("%s?pageNum_proceso_rollos=%d%s", $currentPage, $totalPages_proceso_rollos, $queryString_proceso_rollos); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page 
                ?>
              </td>
            </tr>
          </table>
      </td>
    </tr>
  </table>
  
</body>

</html>
<?php
mysql_free_result($usuario);

mysql_free_result($rollo_estrusion);

?>

<script type="text/javascript">
  let rollos = document.querySelector(".rollos");
  let metros = document.querySelector(".metros");
  let kilos = document.querySelector(".kilos");


</script>