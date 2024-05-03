<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
include_once("./Controller/Cbanderas_listado.php");
?>
<?php

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
/* $currentPage = $_SERVER["PHP_SELF"] . "?c=" . $_GET['c'] . "&a=" . $_GET['a']; */
$currentPage2 = $_SERVER['REQUEST_URI'];

$maxRows_registros = 10;
$pageNum_registros = 0;


if (isset($_GET['pageNum_registros'])) {
  $pageNum_registros = $_GET['pageNum_registros'];
}
$startRow_registros = $pageNum_registros * $maxRows_registros;

$conexion = new ApptivaDB();
$llenarListado = new Cbanderas_listadoController;
$conteoBusqueda = new Cbanderas_listadoController;


$colname_usuario = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}

$row_usuario = $conexion->buscar('usuario', 'usuario', $colname_usuario);

$colname_cliente = "-1";
$colname_entrada = "-1";

$rowsLlenarListado = $llenarListado->mostrarListado($maxRows_registros, $pageNum_registros);

if (isset($_GET['busqueda'])) {
  $totalRows_registros = $conteoBusqueda->contarListado($_GET['busqueda'], $_GET["valor"]);
} else {
  $totalRows_registros = $conexion->conteo('tbl_banderas');
}

$totalPages_registros = ceil($totalRows_registros / $maxRows_registros) - 1;




?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="css/general.css" />
  <link rel="stylesheet" type="text/css" href="css/formato.css" />
  <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
  <script type="text/javascript" src="js/usuario.js"></script>
  <script type="text/javascript" src="js/formato.js"></script>
  <!-- sweetalert -->
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- css Bootstrap-->
  <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
  <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
    <div align="center">
      <table id="tabla">
        <tr>
          <td align="center">
            <div class="row-fluid">
              <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h2>LISTADO DE BANDERAS</h2>
                  </div>
                  <div id="cabezamenu">
                    <ul id="menuhorizontal">
                      <li id="nombreusuario"><?php echo $row_usuario['nombre_usuario']; ?></li>
                      <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                      <li><a href="menu.php">MENU PRINCIPAL</a></li>
                    </ul>
                  </div>
                  <div class="panel-body">
                    <br>
                    <div class="container">
                      <div class="row">
                        <div class="span12">
                          <table id="tabla2">
                            <tr>
                              <td rowspan="4" id="fondo2"><img src="images/logoacyc.jpg"></td>
                            </tr>
                            <tr>
                              <td id="subtitulo">
                                LISTADO DE BANDERAS DE TODOS LOS PROCESOS
                              </td>
                            </tr>
                            <tr>
                              <td id="numero2">
                                <h5 id="numero2"> </h5>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <br>
                      <br>
                      <!-- COLUMNAS -->
                      <form id="consulta" name="consulta" action="envio.php" method="get">
                        <fieldset style="border: 1px solid #000; padding:10px">
                          <legend style="border: 0.5px solid">BUSQUEDA</legend>
                          <div class="row contenedor " style="justify-content:space-between">
                            <div style="padding:10px" class="span3"> <strong>OP:</strong>
                              <div>
                                <input type="text" id="id_op" name="id_op" class=' buscar' value="<?php if (!(strcmp("id_op", $_GET['busqueda']))) {
                                                                                                    echo $_GET['valor'];
                                                                                                  } ?>">
                              </div>
                            </div>

                            <div style="padding:10px" class="span3"> <strong>PROCESO:</strong>

                              <div>
                                <select name="busquedaEstado" id="busquedaEstado">
                                  <option value="">Seleccione</option>
                                  <option value="1" <?php if (!(strcmp("1", $_GET['proceso']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>EXTRUSION</option>
                                  <option value="2" <?php if (!(strcmp("2", $_GET['proceso']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>IMPRESION</option>

                                </select>
                              </div>

                            </div>

                            <div style="padding:10px" class="span3"> <strong>OPERARIO:</strong>
                              <div>
                                <input type="text" id="nombre_empleado" name="nombre_empleado" class=' buscar' value="<?php if (!(strcmp("nombre_empleado", $_GET['busqueda']))) {
                                                                                                                        echo $_GET['valor'];
                                                                                                                      } ?>">
                              </div>
                            </div>

                          </div>
                        </fieldset>
                      </form>
                      <br>
                      <br>
                      <!-- grid -->


                      <div class="container-fluid">
                        <h3 id="dato2"><strong>BANDERAS - INGRESADAS</strong></h3>
                        <hr>
                        <div class="row align-items-end">
                          <div class="col-sm-1" style="padding:0"><strong>OP</strong></div>
                          <div class="col-sm-1" style="padding:0"><strong>PROCESO</strong></div>
                          <div class="col-sm-1" style="padding:0"><strong>ROLLO</strong></div>
                          <div class="col-sm-2" style="padding:0"><strong>DESCRIPCION</strong></div>
                          <div class="col-sm-1" style="padding:0"><strong>A CUANTOS METROS</strong></div>
                          <div class="col-sm-1" style="padding:0"><strong>TOTAL MTS ROLLO FINAL</strong></div>
                          <div class="col-sm-2" style="padding:0"><strong>VISTO SELLADO</strong></div>
                          <div class="col-sm-2" style="padding:0"><strong>FECHA VISTO SELLADO</strong></div>
                          <div class="col-sm-1" style="padding:0"><strong>VISTO</strong></div>
                        </div>

                        <?php foreach ($rowsLlenarListado as $row_registros) {  ?>

                          <div class="row celdaborde1">
                            <div class="col-sm-1" id="fondo_2" style="padding:0">
                              <p> <?php echo $row_registros['id_op']; ?></p>
                            </div>
                            <div class="col-sm-1" id="fondo_2" style="padding:0">
                              <p><?php echo $row_registros['nombre_proceso']; ?></p>
                            </div>
                            <div class="col-sm-1" id="fondo_2" style="padding:0">
                              <p><?php echo $row_registros['rollo_r']; ?></p>
                            </div>
                            <div class="col-sm-2" id="fondo_2" style="padding:0">
                              <p><?php echo $row_registros['nombre']; ?></p>
                            </div>
                            <div class="col-sm-1" id="fondo_2" style="padding:0">
                              <p><?php echo $row_registros['metros']; ?> </p>
                            </div>
                            <div class="col-sm-1" id="fondo_2" style="padding:0">
                              <p><?php echo $row_registros['metros_rollo']; ?></p>
                            </div>
                            <div class="col-sm-2" id="fondo_2" style="padding:0">
                              <p> <?php echo $row_registros['nombre_empleado']." ".$row_registros['apellido_empleado']; ?></p>
                            </div>
                            <div class="col-sm-2" id="fondo_2" style="padding:0">
                              <p> <?php echo $row_registros['fecha_verificacion']; ?></p>
                            </div>
                            <div class="col-sm-1" id="fondo_2" style="padding:0">
                              <p> <?php echo ($row_registros['visto'] == 1) ? "SI" : ""; ?></p>
                            </div>
                          </div>

                        <?php  } ?>
                      </div>

                      <!-- tabla para paginacion opcional -->
                      <table border="0" width="50%" align="center">
                        <tr>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage2, 0, $queryString_registros); ?>">Primero</a>
                            <?php } // Show if not first page 
                            ?>
                          </td>
                          <td width="31%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage2, max(0, $pageNum_registros - 1), $queryString_registros); ?>">Anterior</a>
                            <?php } // Show if not first page 
                            ?>
                          </td>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage2, min($totalPages_registros, $pageNum_registros + 1), $queryString_registros); ?>">Siguiente</a>
                            <?php } // Show if not last page 
                            ?>
                          </td>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage2, $totalPages_registros, $queryString_registros); ?>">&Uacute;ltimo</a>
                            <?php } // Show if not last page 
                            ?>
                          </td>
                        </tr>
                      </table>
                      <fieldset style="border: 1px solid #000; padding:10px; margin:10px 0 ">
                        <div>
                          <div class="row " style="padding:0 10px; justify-content:space-between">
                            <strong>CODIGO: A3-F06</strong>
                            <strong>VERSION 02</strong>
                          </div>
                        </div>
                      </fieldset>

                    </div> <!-- contenedor -->

                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>

</body>

</html>

<script type="text/javascript">
  $(document).ready(function() {

    $(".buscar").change(function() {
      var name = $(this).attr('name');
      var value = $(this).val();
      url = '<?php echo BASE_URL; ?>';
      if (value != "") {
        window.location.assign(url + 'view_index.php?c=Cbanderas_listado&a=inicioListado&busqueda=' + name + '&valor=' + value)
      } else {
        window.location.assign(url + 'view_index.php?c=Cbanderas_listado&a=inicioListado')
      }
    });
  });

  window.setTimeout(function() {
    window.location.reload();
    window.location.assign('<?php echo $_SERVER['REQUEST_URI'] ?>');
  }, 60000);


  $('#busquedaEstado').on('change', function() {
    idbusqueda = $('#busquedaEstado').val();
    url = '<?php echo $_SERVER['REQUEST_URI'] ?>';
  
    if (document.getElementById('busquedaEstado').value == "") {
      window.location = "view_index.php?c=Cbanderas_listado&a=inicioListado";
    } else {
      window.location.assign(url + "&proceso="+idbusqueda+"&busqueda=proceso"+"&valor=" + idbusqueda);
    };
  })
</script>