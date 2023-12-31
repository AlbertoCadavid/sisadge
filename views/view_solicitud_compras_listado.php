<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
include_once("./Controller/Csolicitud_compras.php");
?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

?>
<?php
$currentPage = $_SERVER["PHP_SELF"] . "?c=" . $_GET['c'] . "&a=" . $_GET['a'];

$maxRows_registros = 10;
$pageNum_registros = 0;


if (isset($_GET['pageNum_registros'])) {
  $pageNum_registros = $_GET['pageNum_registros'];
}
$startRow_registros = $pageNum_registros * $maxRows_registros;

$conexion = new ApptivaDB();
$llenarListado = new Csolicitud_comprasController;


$colname_usuario = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}

$row_usuario = $conexion->buscar('usuario', 'usuario', $colname_usuario);

$colname_cliente = "-1";
$colname_entrada = "-1";

$rowsLlenarListado = $llenarListado->mostrarListado("");


if (isset($_GET['totalRows_registros'])) {
  $totalRows_registros = $_GET['totalRows_registros'];
} else {
  $totalRows_registros = $conexion->conteo('tbl_remision_interna');
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
      <table id="tabla1">
        <tr>
          <td align="center">
            <div class="row-fluid">
              <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h2>LISTADO SOLICITUDES DE COMPRA</h2>
                  </div>
                  <div id="cabezamenu">
                    <ul id="menuhorizontal">
                      <li id="nombreusuario"><?php echo $row_usuario['nombre_usuario']; ?></li>
                      <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                      <li><a href="menu.php">MENU PRINCIPAL</a></li>
                      <li><a href="view_index.php?c=Csolicitud_compras&a=inicioListado">LISTADO ENTRADAS</a></li>
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
                                LISTADO SOLICITUDES DE COMPRA
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
                            <div style="padding:10px" class="span3"> <strong>FECHA: </strong>
                              <div>
                                <input type="date" id="fecha" name="fecha" class=' buscar' value="<?php if (!(strcmp("fecha", $_GET['busqueda']))) {
                                                                                                    echo $_GET['valor'];
                                                                                                  } ?>">
                              </div>
                            </div>

                            <div style="padding:10px" class="span3"> <strong>NOMBRE:</strong>
                              <div>
                                <input type="text" id="nombre" name="nombre" class=' buscar' value="<?php if (!(strcmp("nombre", $_GET['busqueda']))) {
                                                                                                      echo $_GET['valor'];
                                                                                                    } ?>">
                              </div>
                            </div>

                            <div style="padding:10px" class="span3"> <strong>AREA:</strong>
                              <div>
                                <input  type="text" id="area" name="area" class=' buscar' value="<?php if (!(strcmp("area", $_GET['busqueda']))) {
                                                                                                  echo $_GET['valor'];
                                                                                                } ?>">
                              </div>
                            </div>

                            <div style="padding:10px" class="span3"> <strong>ESTADO:</strong>

                              <div>
                                <select name="busquedaEstado" id="busquedaEstado" >
                                  <option value="">Seleccione</option>
                                  <option value="PENDIENTE" <?php if (!(strcmp("PENDIENTE", $_GET['estado']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>PENDIENTE</option>
                                  <option value="TERMINADO" <?php if (!(strcmp("TERMINADO", $_GET['estado']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>TERMINADO</option>
                                  <option value="EN PROCESO" <?php if (!(strcmp("EN PROCESO", $_GET['estado']))) {
                                                              echo "selected=\"selected\"";
                                                            } ?>>EN PROCESO</option>
                                </select>
                              </div>
                                                                                          
                            </div>

                          </div>
                        </fieldset>
                      </form>
                      <br>
                      <br>
                      <!-- grid -->


                      <div class="container-fluid">
                        <h3 id="dato2"><strong>SOLICITUDES - INGRESADAS</strong></h3>
                        <?php if ($_GET['alerta'] == 1) : ?> <span id="alertG" style="color: blue;">
                            <h4> Actualizo Correctamente </h4>
                          </span> <?php endif; ?>
                        <?php if ($_GET['alerta'] == 2) : ?> <span id="alertG" style="color: blue;">Se Guardo Correctamente </span> <?php endif; ?>
                        <div style="text-align: right;">NUEVO <a href="view_index.php?c=Csolicitud_compras&a=Inicio"><img src="images/masazul.PNG" alt="AGREGAR SOLICITUD DE COMPRA" title="AGREGAR SOLICITUD DE COMPRA" border="0" style="cursor:hand;" /></a></div>
                        <hr>
                        <div class="row align-items-start">
                          <div class="col-sm-1"><strong>ITEMS</strong></div>
                          <div class="col-sm-2"><strong>Nº SOLICITUD</strong></div>
                          <div class="col-sm-2"><strong>NOMBRE</strong></div>
                          <div class="col-sm-2"><strong>AREA</strong></div>
                          <div class="col-sm-2"><strong>ESTADO</strong></div>
                          <div class="col-sm-2"><strong>FECHA</strong></div>
                          <div class="col-sm-1"><strong>VER</strong></div>
                        </div>

                        <?php foreach ($rowsLlenarListado as $row_registros) {  ?>
                          
                            <div class="row celdaborde1">
                              <div class="col-sm-1" id="fondo_2" style="padding:0">
                                <p><a <?php if ($_SESSION['acceso']) : ?> href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" <?php endif ?> target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_registros['cantidad_elementos']; ?></a></p>
                              </div>
                              <div class="col-sm-2" id="fondo_2" style="padding:0">
                                <p><a <?php if ($_SESSION['acceso']) : ?> href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" <?php endif ?> target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_registros['codigo']; ?></a></p>
                              </div>
                              <div class="col-sm-2" id="fondo_2" style="padding:0">
                                <p><a <?php if ($_SESSION['acceso']) : ?> href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" <?php endif ?> target="_top" style="text-decoration:none; color:#000000"><?php echo $row_registros['nombre']; ?></a></p>
                              </div>
                              <div class="col-sm-2" id="fondo_2" style="padding:0">
                                <p><a <?php if ($_SESSION['acceso']) : ?> href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" <?php endif ?> target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_registros['area']; ?></a></p>
                              </div>
                              <div class="col-sm-2" id="fondo_2" style="padding:0">
                                <p><a <?php if ($_SESSION['acceso']) : ?> href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" <?php endif ?> target="_top" style="text-decoration:none; color:<?php if ($row_registros['estado2'] == "PENDIENTE") {
                                                                                                                                                                                                                                                                  echo "red";
                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                  echo "green";
                                                                                                                                                                                                                                                                } ?>"><?php echo $row_registros['estado2']; ?> </a></p>
                              </div>
                              <div class="col-sm-2" id="fondo_2" style="padding:0">
                                <p> <a <?php if ($_SESSION['acceso']) : ?> href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" <?php endif ?> target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_registros['fecha']; ?></a></p>
                              </div>
                              <?php if ($_SESSION['acceso']) { ?>
                                <div class="col-sm-1" id="fondo_2" style="padding:0">
                                  <p><a href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>" target="_top" style="text-decoration:none; color:#000000"><img src="images/pincel.PNG" alt="EDITAR" title="EDITAR" border="0" style="cursor:hand;" width="20" height="18" /> </a></p>
                                </div>
                              <?php } else { ?>
                                <div class="col-sm-1" id="fondo_2" style="padding:0">
                                  <p><a href="view_index.php?c=Csolicitud_compras&a=inicioEdit&id_consecutivo=<?php echo $row_registros['id_solicitud']; ?>&editar=NO" target="_top" style="text-decoration:none; color:#000000"><img src="images/adelante.gif" alt="VER" title="VER" border="0" style="cursor:hand;" width="20" height="18" /> </a></p>
                                </div>
                              <?php } ?>
                            </div>
                          

                          
                        <?php  } ?>
                      </div>

                      <!-- tabla para paginacion opcional -->
                      <table border="0" width="50%" align="center">
                        <tr>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage, 0, $queryString_registros); ?>">Primero</a>
                            <?php } // Show if not first page 
                            ?>
                          </td>
                          <td width="31%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage, max(0, $pageNum_registros - 1), $queryString_registros); ?>">Anterior</a>
                            <?php } // Show if not first page 
                            ?>
                          </td>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage, min($totalPages_registros, $pageNum_registros + 1), $queryString_registros); ?>">Siguiente</a>
                            <?php } // Show if not last page 
                            ?>
                          </td>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                                      ?>
                              <a href="<?php printf("%s&pageNum_registros=%d%s", $currentPage, $totalPages_registros, $queryString_registros); ?>">&Uacute;ltimo</a>
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
        window.location.assign(url + 'view_index.php?c=Csolicitud_compras&a=inicioListado&busqueda=' + name + '&valor=' + value)
      } else {
        window.location.assign(url + 'view_index.php?c=Csolicitud_compras&a=inicioListado')
      }
    });
  });

  window.setTimeout(function() {
    window.location.reload();
    window.location.assign('<?php echo BASE_URL; ?>' + 'view_index.php?c=Csolicitud_compras&a=inicioListado');
  }, 60000);

  setTimeout(function() {
    $("#alertG").fadeOut();
  }, 3000);

  $('#busquedaEstado').on('change', function() {
    idbusqueda = $('#busquedaEstado').val();
    url = '<?php echo $_SERVER['REQUEST_URI'] ?>';
    
    if (document.getElementById('busquedaEstado').value == "") {
      window.location = "view_index.php?c=Csolicitud_compras&a=inicioListado";
    } else {
      window.location.assign(url + "&estado=" + idbusqueda);
    };
  })

</script>
