<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);

include_once("./Controller/Csolicitud_compras.php")

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

$currentPage = $_SERVER["PHP_SELF"];

$conexion = new ApptivaDB();

$colname_usuario = "1";
if (isset($_SESSION['MM_Username'])) {
    $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}

$row_usuario = $conexion->buscar('usuario', 'usuario', $colname_usuario);

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

<body onKeyDown="javascript:Verificar()">
    <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
        <div align="center">
            <table id="tabla1">
                <tr>
                    <td align="center">
                        <div class="row-fluid">
                            <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h2>IMPRESION DE STIKER</h2>
                                    </div>
                                    <div id="cabezamenu">
                                        <ul id="menuhorizontal">
                                            <li id="nombreusuario"><?php echo $_SESSION['Usuario']; ?></li>
                                            <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                                            <li><a href="menu.php">MENU PRINCIPAL</a></li>
                                            <a style="background:#fff; border:none" href="view_index.php?c=Cstiker_tintas&a=viewStikerImprimir"><img  src="images/ciclo1.gif" alt="RESTAURAR" title="RESTAURAR" border="0" style="cursor:hand;" /></a>
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
                                                            <td align="center">

                                                                ALBERTO CADAVID R & CIA S.A. - Nit: 890915756-6 <br>
                                                                Carrera 45 N°. 14 - 15 Tel: 604 311-21-44 - Medellin-Colombia
                                                                <p></p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>


                                            <form action="view_index.php?c=Cstiker_tintas&a=viewStikerImprimir" method="post" id="form1" name="form1" >
                                                <table id="tabla1">

                                                    <tr>
                                                        <td class="size padding">
                                                            <label for="sustancia"><strong>NOMBRE DE LA SUSTANCIA QUIMICA:</strong></label>
                                                        </td>
                                                        <td>
                                                            <select name="sustancia" id="sustancia">
                                                                <option value="">SELECCIONAR</option>
                                                                <option value="TINTA">TINTA</option>
                                                                <option value="ALCOHOL">ALCOHOL</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="proveedor"><strong>IDENTIFICACION DEL PROVEEDOR:</strong></label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="proveedor" id="proveedor">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>OBSERVACIONES:</strong>
                                                            <textarea class="form-control" id="observaciones" name="observaciones" cols="50" rows="3"></textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="color"><strong>COLOR:</strong></label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="color" id="color">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="panton"><strong>PANTONE:</strong></label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="panton" id="panton">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="pesofinal"><strong>PESOFINAL:</strong></label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="pesofinal" id="pesofinal">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="retorno"><strong>RETORNO:</strong></label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="retorno" id="retorno">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="original"><strong>ORIGINAL:</strong></label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="original" id="original">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">&nbsp;</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <button id="imprimir" class="botonGeneral">IMPRIMIR</button>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </form>

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

<style>

    .padding {
        padding-top: 10px;
    }

    .size {
        width: 40%;
    }

   
</style>
<script type="text/javascript">
    $("#imprimir").on("click", function() {

        if ($("#sustancia").val() == '') {
            swal("Error", "Debe agregar un valor al campo Sustancia Quimica! :)", "error");
            return false;
        } else  if ($("#proveedor").val() == ''){
            swal("Error", "Debe agregar un valor al campo Identificador de proveedor! :)", "error");
            return false;
        }
    });



    $('#proveedor').on("change", function(){
        let txt = $('#proveedor').val();
        $('#proveedor').val(txt.toUpperCase())
    })
    $('#observaciones').on("change", function(){
        let txt = $('#observaciones').val();
        $('#observaciones').val(txt.toUpperCase())
    })
    $('#color').on("change", function(){
        let txt = $('#color').val();
        $('#color').val(txt.toUpperCase())
    })
    $('#panton').on("change", function(){
        let txt = $('#panton').val();
        $('#panton').val(txt.toUpperCase())
    })
    $('#original').on("change", function(){
        let txt = $('#original').val();
        $('#original').val(txt.toUpperCase())
    })
    $('#retorno').on("change", function(){
        let txt = $('#retorno').val();
        $('#retorno').val(txt.toUpperCase())
    })

    $('input').on('keypress', function(event){
        if (event.keyCode === 13) {
                // Prevenir el envío del formulario
                event.preventDefault();
                return false;
            }
    })
</script>