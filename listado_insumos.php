<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
require_once('Connections/conexion1.php');

$conexion = new ApptivaDB();
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_registros = 50;
$pageNum_registros = 0;

if (isset($_GET['pageNum_registros'])) {
    $pageNum_registros = $_GET['pageNum_registros'];
  }
$startRow_registros = $pageNum_registros * $maxRows_registros;

if (isset($_GET['totalRows_registros'])) {
    $totalRows_registros = $_GET['totalRows_registros'];
  } else {
    $totalRows_registros = $conexion->conteo('insumo');
  }

$colname_busqueda = "-1";
if (isset($_GET["valor"])) {
    $colname_busqueda = (get_magic_quotes_gpc()) ? $_GET["valor"] : addslashes($_GET["valor"]);
    if ($_GET['busqueda'] == "descripcion_insumo" && isset($_GET['valor'])) {
        $insumos = $conexion->buscarListar("insumo", 'id_insumo, codigo_insumo, descripcion_insumo, nombre_clase as clase', "ORDER BY descripcion_insumo ASC", "", $maxRows_registros, $pageNum_registros, "JOIN clase WHERE clase_insumo = id_clase AND $_GET[busqueda] LIKE'%$colname_busqueda%'");
        $totalRows_registros = sizeof($insumos);
    }
} else {
   $insumos = $conexion->buscarListar("insumo", 'id_insumo, codigo_insumo, descripcion_insumo, nombre_clase as clase', "ORDER BY descripcion_insumo ASC", "", $maxRows_registros, $pageNum_registros, 'JOIN clase WHERE clase_insumo = id_clase');
}
$totalPages_registros = ceil($totalRows_registros / $maxRows_registros) - 1;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>SISADGE AC &amp; CIA</title>
    <link rel="StyleSheet" href="css/formato.css" type="text/css">
    <script type="text/javascript" src="js/listado.js"></script>

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

    <!-- select2 -->
    <link href="select2/css/select2.min.css" rel="stylesheet" />
    <script src="select2/js/select2.min.js"></script>

    <!-- css Bootstrap-->
    <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php echo $conexion->header('listas'); ?>
    <table class="table table-bordered table-sm">
        <tr>
            <td id="titulo2">LISTADO DE INSUMOS </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <fieldset style="border: 1px solid #000; padding:10px">
            <legend style="border: 0.5px solid">BUSQUEDA</legend>
            <div class="row contenedor " style="justify-content:center">
                <div style="padding:10px" class="span3"> <strong>NOMBRE:</strong>
                    <div>
                        <input type="text" id="descripcion_insumo" name="descripcion_insumo" class='buscar' value="<?php if (!(strcmp("descripcion_insumo", $_GET['busqueda']))) {
                                                                                                            echo $_GET['valor'];
                                                                                                        } ?>">
                    </div>
                </div>

            </div>
        </fieldset>

        <tr>
            <td id='subtitulo2'>CODIGO</td>
            <td id='subtitulo2'>DESCRIPCION</td>
            <td id='subtitulo2'>CLASE INSUMO</td>
        </tr>
        <?php foreach ($insumos as $insumo) { ?>
            <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF" bordercolor="#ACCFE8">
                <td class="Estilo4"> <?php echo $insumo['codigo_insumo']; ?> </td>
                <td class="Estilo4"> <?php echo $insumo['descripcion_insumo']; ?> </td>
                <td class="Estilo4"> <?php echo $insumo['clase']; ?></td>
            </tr>
        <?php }  ?>

         <!-- tabla para paginacion opcional -->
         <table border="0" width="50%" align="center">
                        <tr>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                                      ?>
                              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, 0, $queryString_registros); ?>">Primero</a>
                            <?php } // Show if not first page 
                            ?>
                          </td>
                          <td width="31%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page 
                                                      ?>
                              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, max(0, $pageNum_registros - 1), $queryString_registros); ?>">Anterior</a>
                            <?php } // Show if not first page 
                            ?>
                          </td>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                                      ?>
                              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, min($totalPages_registros, $pageNum_registros + 1), $queryString_registros); ?>">Siguiente</a>
                            <?php } // Show if not last page 
                            ?>
                          </td>
                          <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page 
                                                      ?>
                              <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, $totalPages_registros, $queryString_registros); ?>">&Uacute;ltimo</a>
                            <?php } // Show if not last page 
                            ?>
                          </td>
                        </tr>
                      </table>
    </table>

   

    <?php echo $conexion->header('footer'); ?>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {

        $(".buscar").change(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            
            url = '<?php echo BASE_URL; ?>';
            if (value != "") {
                window.location.assign(url + 'listado_insumos.php?busqueda=' + name + '&valor=' + value)
            } else {
                window.location.assign(url + 'listado_insumos.php')
            }
        });
    });
</script>