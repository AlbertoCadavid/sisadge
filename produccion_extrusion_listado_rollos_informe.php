<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php require_once('Connections/conexion1.php'); ?>
<?php
$count = 0;

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
if (isset($_GET['desde'])) {
  $query_rollo_estrusion = sprintf("SELECT * FROM TblExtruderRollo WHERE TblExtruderRollo.id_op_r=$colname_rollo_cola and rollo_r >= $_GET[desde] and rollo_r <= $_GET[hasta]");
} else {
  $query_rollo_estrusion = sprintf("SELECT * FROM TblExtruderRollo WHERE TblExtruderRollo.id_op_r=%s", $colname_rollo_cola, $startRow_proceso_rollos, $maxRows_proceso_rollos);
}
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

?><html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <link href="css/formato.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/formato.js"></script>
  <script type="text/javascript" src="js/listado.js"></script>
  <script type="text/javascript" src="AjaxControllers/js/envioListado.js"></script>

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
  <?php echo $conexion->header('listas'); ?>

  <table id="tabla1">
    <tr>
    <tr>
      <td colspan="2" align="center">

    <tr>
      <td id="titulo" style="text-align:center ; width:100%">LISTADO DE ROLLOS</td>
    </tr>
    <table class="table table-bordered table-sm">

      <tr>
        <td id="fuente2" style="text-align:left">ORDEN DE PRODUCCION:</td>
        <td id="fuente2" style="text-align:left"><?php echo $_GET['id_op_r'] ?></td>
      </tr>
      <tr>
        <td id="fuente2" style="text-align:left">CANTIDAD DE ROLLOS:</td>
        <td id="fuente2" class="rollos" style="text-align:left"> </td> <input type="hidden" value="" name="rollos" id="rollos">
      </tr>
      <tr>
        <td id="fuente2" style="text-align:left">METROS TOTALES:</td>
        <td id="fuente2" class="metros" style="text-align:left"></td><input type="hidden" value="" name="metros" id="metros">
      </tr>
      <tr>
        <td id="fuente2" style="text-align:left">KILOS TOTALES:</td>
        <td id="fuente2" class="kilos" style="text-align:left"></td><input type="hidden" value="" name="kilos" id="kilos">
      </tr>
      <div>
        <tr>
          <td id="fuente2" style="display:flex"><a href="produccion_extrusion_listado_rollos.php?id_op_r=<?php echo $_GET['id_op_r']; ?>"><img src="images/atras.gif" alt="ATRAS" title="ATRAS" border="0" style="cursor:hand;" /></a></td>
          <td>
            <label for="undEstiba">Rollos x Estiba</label>
            <input style="width:35px; margin-right:30px" type="number" name="undEstiba" id="undEstiba">
          </td>
          <td id="fuente2">
            <a type="submit" onClick="envioexcel();" style="margin-right:30px">
              <img src="./Fichero_excel/xls-export-green.png" alt="EXPORTAR ROLLOS" title="EXPORTAR ROLLOS A EXCEL" border="0" style="cursor:hand" />
            </a>
          </td>
          <td id="fuente2">
            <a type="submit" onClick="envioexcelMalos();">
              <img src="./Fichero_excel/xls-export-red.png" alt="EXPORTAR ROLLOS DEFECTUOSOS A EXCEL" title="EXPORTAR ROLLOS DEFECTUOSOS A EXCEL" border="0" style="cursor:hand" />
            </a>
          </td>

        </tr>
      </div>

      <div>
        <fieldset style="width:70%">
          <legend>Filtro de Rollos</legend>
          <label for="desde">Desde</label>
          <input style="width:40px" type="number" min="0" name="rolloDesde" id="rolloDesde" value="<?php if ((strcmp("rolloDesde", $_GET['desde']))) {
                                                                                                      echo $_GET['desde'];
                                                                                                    } ?>">

          <label for="hasta">Hasta</label>
          <input style="width:40px" type="number" min="0" name="rolloHasta" id="rolloHasta" value="<?php if ((strcmp("rolloDesde", $_GET['hasta']))) {
                                                                                                      echo $_GET['hasta'];
                                                                                                    } ?>">

          <button class="buscar" type="button">Buscar</button>
          <img style="width:20px; margin-bottom:-5px" class="reset" src="./images/14.png" alt="Borrar Busqueda"><br><br>
        </fieldset>
      </div>

    </table>

    <table id="tabla1">

      <tr id="tr1">
        <td nowrap="nowrap" id="titulo4">ROLLO N&deg;</td>
        <td nowrap="nowrap" id="titulo4">KILOS</td>
        <td nowrap="nowrap" id="titulo4">METRO</td>
        <td nowrap="nowrap" id="titulo4">OPERARIO</td>
        <td nowrap="nowrap" id="titulo4">ELIMINAR ROLLO</td>
      </tr>
      <?php do { ?>
        <?php if ($row_rollo_estrusion['bandera_r'] > 0) { ?>
          <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
            <input type="hidden" class="id<?php echo $count ?>" name="id[]" value="<?php echo $row_rollo_estrusion['id_r'] ?>">
            <td style="background: rgb(188, 179, 177)" id="dato2" class="item<?php echo $count ?>"><?php echo $row_rollo_estrusion['rollo_r']; ?></td>
            <td style="background: rgb(188, 179, 177)" id="dato2" class="kilos<?php echo $count ?> item<?php echo $count ?>"><?php echo $row_rollo_estrusion['kilos_r'];
                                                                                                                              $TKILOS += $row_rollo_estrusion['kilos_r']; ?></td>
            <td style="background: rgb(188, 179, 177)" id="dato2" class="metros<?php echo $count ?> item<?php echo $count ?>"><?php echo $row_rollo_estrusion['metro_r'];
                                                                                                                              $TMETROS += $row_rollo_estrusion['metro_r']; ?></td>
            <td style="background: rgb(188, 179, 177)" id="dato2" class="operario<?php echo $count ?> item<?php echo $count ?>"><?php echo $row_rollo_estrusion['cod_empleado_r']; ?></td>
            <td style="background: rgb(188, 179, 177)" id="dato2" class="item<?php echo $count ?>"><input type="checkbox" name="sel<?php echo $count ?>" id="sel<?php echo $count ?>"></td>
          </tr>
        <?php } else { ?>
          <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
            <input type="hidden" class="id<?php echo $count ?>" name="id[]" value="<?php echo $row_rollo_estrusion['id_r'] ?>">
            <td id="dato2" class="item<?php echo $count ?>"><?php echo $row_rollo_estrusion['rollo_r']; ?></td>
            <td id="dato2" class="kilos<?php echo $count ?> item<?php echo $count ?>"><?php echo $row_rollo_estrusion['kilos_r'];
                                                                                      $TKILOS += $row_rollo_estrusion['kilos_r']; ?></td>
            <td id="dato2" class="metros<?php echo $count ?> item<?php echo $count ?>"><?php echo $row_rollo_estrusion['metro_r'];
                                                                                        $TMETROS += $row_rollo_estrusion['metro_r']; ?></td>
            <td id="dato2" class="operario<?php echo $count ?> item<?php echo $count ?>"><?php echo $row_rollo_estrusion['cod_empleado_r']; ?></td>
            <td id="dato2" class="item<?php echo $count ?>"><input type="checkbox" name="sel<?php echo $count ?>" id="sel<?php echo $count ?>"></td>
          </tr>
        <?php } ?>
        <?php $count = $count + 1 ?>
      <?php } while ($row_rollo_estrusion = mysql_fetch_assoc($rollo_estrusion)); ?>
      <tr bgcolor="#FFFFFF">

        <td id="dato3">TOTAL:</td>
        <td id="dato2"><strong class="kilos"></strong></td>
        <td id="dato2"><strong class="metros"></strong></td>
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
      <?php echo $conexion->header('footer'); ?>
    </table>

</body>

</html>
<?php
mysql_free_result($usuario);

mysql_free_result($rollo_estrusion);

?>

<script type="text/javascript">
  let rollos = document.querySelector(".rollos");
  let metros = document.querySelectorAll(".metros");
  let kilos = document.querySelectorAll(".kilos");
  let checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#todo');
  let cantidad = checkboxes.length;
  let buscar = document.querySelector(".buscar");
  let reset = document.querySelector(".reset");

  for (let i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function() {
      let kiloitem = document.querySelector(".kilos" + i).innerText
      let metroitem = document.querySelector(".metros" + i).innerText
      let fila = document.querySelectorAll(".item" + i)


      if (this.checked) {
        // Se selecciona este checkbox
        kilos.forEach(element => {
          element.value = element.value - kiloitem
          element.innerHTML = element.value;
        });

        metros.forEach(element => {
          element.value = element.value - metroitem
          element.innerHTML = element.value;
        });

        cantidad = cantidad - 1
        rollos.innerHTML = cantidad;

        fila.forEach(element => {
          element.setAttribute("disabled", "true");
          element.style.background = "#BCB3B1";
        });



      } else {
        // Se deselecciona este checkbox
        kilos.forEach(element => {
          element.value = (parseFloat(element.value) + parseFloat(kiloitem))
          element.innerHTML = element.value;
        });

        metros.forEach(element => {
          element.value = (parseFloat(element.value) + parseFloat(metroitem))
          element.innerHTML = element.value;
        });
        cantidad = cantidad + 1
        rollos.innerHTML = cantidad;

        fila.forEach(element => {
          element.setAttribute("disabled", "false");
          element.style.background = "white";
        });
      }
    })

  }


  window.addEventListener('load', function() {

    rollos.innerHTML = cantidad;
    rollos.value = cantidad;

    metros.forEach(element => {
      element.innerHTML = <?php echo $TMETROS; ?>;
      element.value = <?php echo $TMETROS ?>;
    });


    kilos.forEach(element => {
      element.innerHTML = <?php echo $TKILOS; ?>;
      element.value = <?php echo $TKILOS ?>;
    });


  })

  function objRollos(condicion) {

    let infoRollos = [];
    let pos = 0;

    for (let i = 0; i < checkboxes.length; i++) {
      let info = document.querySelectorAll(".item" + i)

      if (condicion === "buenos") {
        if (info[0].getAttribute("disabled") != "true") {

          infoRollos[pos] = {
            rollo: info[0].innerText,
            kilos: info[1].innerText,
            metros: info[2].innerText,
            operario: info[3].innerText
          }
          pos++
        }
      } else if (condicion === "malos") {
        if (info[0].getAttribute("disabled") == "true") {

          infoRollos[pos] = {
            rollo: info[0].innerText,
            kilos: info[1].innerText,
            metros: info[2].innerText,
            operario: info[3].innerText
          }
          pos++
        }
      }

    }

    return infoRollos;
  }


  function envioexcel() {
    let undxestiba = cantidad;
    if (document.querySelector('#undEstiba').value != '') {
      undxestiba = document.querySelector('#undEstiba').value;
    }

    var objetoSerializado = JSON.stringify(objRollos('buenos'));
    localStorage.setItem('dataObjetoJSON', objetoSerializado);

    var form = "id_op_r=<?php echo $_GET['id_op_r']; ?>" + '&rollos=' + cantidad + '&metros=' + metros[0].value + '&kilos=' + kilos[0].value + '&undxestiba=' + undxestiba;
    var vista = 'produccion_extrusion_listado_rollos_informe_excel.php';
    enviovarListados(form, vista);
  }

  buscar.addEventListener("click", function() {
    let desde = document.querySelector("#rolloDesde").value;
    let hasta = document.querySelector("#rolloHasta").value;
    let id = '<?php echo $_GET['id_op_r'] ?>'

    url = '<?php echo $_SERVER['PHP_SELF'] ?>';
    if (desde != "" || hasta != "") {
      window.location.assign(url + "?id_op_r=" + id + "&desde=" + desde + "&hasta=" + hasta)
    } else {
      window.location.assign(url + "?id_op_r=" + id)
    }
  })

  function envioexcelMalos() {
    let undxestiba = cantidad;
    if (document.querySelector('#undEstiba').value != '') {
      undxestiba = document.querySelector('#undEstiba').value;
    }

    if (objRollos('malos').length > 0) {
      var objetoSerializado = JSON.stringify(objRollos('malos'));
      localStorage.setItem('dataObjetoJSON', objetoSerializado);

      var form = "id_op_r=<?php echo $_GET['id_op_r']; ?>" + '&rollos=' + cantidad + '&metros=' + metros[0].value + '&kilos=' + kilos[0].value + '&undxestiba=' + undxestiba;
      var vista = 'produccion_extrusion_listado_rollos_informe_excel.php';
      enviovarListados(form, vista);
    } else {
      swal({
        icon: "warning",
        title: "Oops...",
        text: "No has seleccionado ningun rollo malo"
      });
    }
  }

  reset.addEventListener("click", function() {
    let id = '<?php echo $_GET['id_op_r'] ?>'
    url = '<?php echo $_SERVER['PHP_SELF'] ?>';
    window.location.assign(url + "?id_op_r=" + id)
  })
</script>