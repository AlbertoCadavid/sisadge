<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
include_once("./Controller/Ctrazabilidad.php");

if($_REQUEST){
    $id_op = $_REQUEST['id_op'];
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>SISADGE AC &amp; CIA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/trazabilidad.css">
    <link rel="stylesheet" type="text/css" href="css/formato.css"/>
    <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <script type="text/javascript" src="js/listado.js"></script>
    
    <!-- jQuery -->
    <script src='select3/assets/js/jquery-3.4.1.min.js' type='text/javascript'></script>
    <!-- select2 css -->
    <link href='select3/assets/plugin/select2/dist/css/select2.min.css' rel='stylesheet' type='text/css'>
    <!-- select2 script -->
    <script src='select3/assets/plugin/select2/dist/js/select2.min.js'></script>
    <!-- Styles -->
    <link rel="stylesheet" href="select3/assets/css/style.css">
    <!-- Fin Select3 Nuevo -->
    
</head>

<body onload="JavaScript: AutoRefresh (120000);">

    <div class="container row-fluid">
    <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
              <div class="panel panel-primary">
                <div class="panel-heading" align="left"></div><!--color azul-->
                <div class="row">
                  <div class="span12">&nbsp;&nbsp;&nbsp; <img src="images/cabecera.jpg"></div>
                </div>
                <div class="panel-heading" align="left"></div><!--color azul-->
                <div id="cabezamenu">
                  <ul id="menuhorizontal">
                    <li id="nombreusuario"><?php echo $_SESSION['Usuario']; ?></li>
                    <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                    <li><a href="menu.php">MENU PRINCIPAL</a></li>
                    <li><a href="produccion_ordenes_produccion_listado.php">LISTADO</a></li>
                  </ul>
                </div>
                <div class="panel-body">
                  <br>
                  <div>
                    <div class="row">
                      <div class="span12">
                      </div>
                    </div>
                    <br>
                    <div>
                        <h1>TRAZABILIDAD DE PRODUCTO</h1>
                    </div>
        <div class="search">
            <div>
                <strong id="titulo3">ORDEN DE PRODUCCION: <?php echo $id_op ?> </strong>
                <input id="op" type="hidden" value="<?php echo $id_op ?>">
            </div>
        </div>

        <div id="event-list" class="ul panelOP">
            <!-- Aquí se mostrarán los eventos -->
            <!-- <div class="div event-entrada">Orden de produccion creada el 2024-03-18</div>
            <div class="containerExtruder" id>
                <div class="div containerExtruder event-procesamiento">Iniciada en extrusion el 2024-03-17 23:00:00</div>
                <div >
                    <div >
                        <div class="titulo  event-procesamiento">Rollos Extruidos</div>
                    </div>
                    <div class="containerRollos">
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                        <div class="div containerRollo event-procesamiento"> Rollo 1</div>
                    </div>
                </div>
            </div> -->

        </div>

        <!-- <div class="wrapper">
            <button>
                Hover Here!
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div> -->
    </div>

    <script src="./js/trazabilidad.js"></script>
</body>

</html>