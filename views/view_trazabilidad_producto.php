<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
include_once("./Controller/Ctrazabilidad.php");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trazabilidad de Producto</title>
    <link rel="stylesheet" href="trazabilidad.css">
    <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
    <link rel="stylesheet" type="text/css" href="css/general.css" />
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

<body>
   
    <div class="container">
        <h1>Trazabilidad de Producto</h1>
        <div class="search">
            <div>
                <strong>OP: </strong>
                <select id='op' name='op' class="selectsMini">
                    <option value='0'>- O.P -</option>
                </select>
            </div>
            <div class="">
                <input id="searchButton" type="button" name="Submit" value="BUSCAR" class="botonGMini">
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