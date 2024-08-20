<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
?>
<?php require_once('Connections/conexion1.php'); ?>
<?php

require_once("db/db.php");
require_once("Controller/CmezclasIm.php");

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


$conexion = new ApptivaDB();

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
<!-- listado select para stik -->
<?php $stik = ["E1520H DURO (Morado-3M)", "73326 DURO (Azul-Tesa)", "E1020H SEMIDURO (Blanco-3M)", "73324 SEMIDURO (Rosado-Tesa)", "E1320H BLANDO (Amarillo-3M)", "73322 BLANDO (Rojo-Tesa)"] ?>
<!--  -->
<?php foreach ($this->row_referencia_copia as $row_referencia_copia) {
  $row_referencia_copia;
} ?>
<?php foreach ($this->row_referencia as $row_referencia) {
  $row_referencia;
} ?>
<?php foreach ($this->row_caract as $row_caract) {
  $row_caract;
} ?>
<?php foreach ($this->row_caract_m as $row_caract_m) {
  $row_caract_m;
} ?>
<?php foreach ($this->row_mezcla as $row_mezcla) {
  $row_mezcla;
} ?>
<?php foreach ($this->row_materia_prima as $row_materia_prima) {
  $row_materia_prima;
} ?>
<?php foreach ($this->maquinas as $maquinas) {
  $maquinas;
} ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>SISADGE AC &amp; CIA</title>
  <link rel="stylesheet" type="text/css" href="css/general.css" />
  <link rel="stylesheet" type="text/css" href="css/formato.css" />
  <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
  <script type="text/javascript" src="js/formato.js"></script>
  <script type="text/javascript" src="js/validacion_numerico.js"></script>
  <script type="text/javascript" src="js/consulta.js"></script>
  <script type="text/javascript" src="AjaxControllers/js/consultas.js"></script>

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
  <link rel="stylesheet" type="text/css" href="css/general.css" />

  <!-- css Bootstrap hace mas grande el formato-->
  <link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
  .width_selects{
    width: 180px;
  }
</style>
</head>

<body>
  <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
    <div align="center">
      <table><!-- style="width: 100%" -->
        <tr>
          <td align="center">
            <div class="row-fluid">
              <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                <div class="panel panel-primary">
                  <div class="panel-heading" align="left"></div><!--color azul-->
                  <div class="row">
                    <div class="span12">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/cabecera.jpg"></div>
                    <div class="span12">
                      <h3> PROCESO DE MEZCLAS &nbsp;&nbsp;&nbsp; </h3>
                    </div>
                  </div>
                  <div class="panel-heading" align="left"></div><!--color azul-->
                  <div id="cabezamenu">
                    <ul id="menuhorizontal">
                      <li id="nombreusuario"><?php echo $_SESSION['Usuario']; ?></li>
                      <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                      <li><a href="menu.php">MENU PRINCIPAL</a></li>
                    </ul>
                  </div>
                  <div class="panel-body">
                    <div><!--  SI QUITO  class="container" SE ALINEA A LA IZQUIERDA TODO EL CONTENIDO DE ESTE Y SE REDUCE -->
                      <div class="row">
                        <div class="span12">
                        </div>
                      </div>
                      <!-- grid -->

                      <div class="container-fluid">
                        <form action="view_index.php?c=cmezclasIm&a=Guardar&id=<?php echo $_GET['cod_ref']; ?>" method="post" enctype="multipart/form-data" name="form1">
                          <table class="table table-bordered table-sm">
                            <tr id="tr1">
                              <td colspan="9" id="titulo2">CARACTERISTICAS DE IMPRESION</td>
                            </tr>
                            <tr>
                              <td colspan="2" rowspan="5" id="dato2"><img src="images/logoacyc.jpg" /></td>
                              <td colspan="7" id="dato3"><a href="menu.php"><img src="images/identico.gif" style="cursor:hand;" alt="MENU PRINCIPAL" title="MENU PRINCIPAL" border="0" /></a>
                                <a href="view_index.php?c=cmezclasIm&a=Mezcla&cod_ref=<?php echo $_GET['cod_ref']; ?>"><img src="images/hoja.gif" alt="VISTA" title="VISTA" border="0"></a>
                              </td>
                            </tr>
                            <tr id="tr1">
                              <td width="182" colspan="3" nowrap="nowrap" id="fuente1">Fecha Ingreso
                                <input name="fecha_registro" type="date" min="2000-01-02" value="<?php echo date("Y-m-d"); ?>" size="10" autofocus />
                              </td>
                              <td colspan="6" id="fuente1"> Ingresado por
                                <input name="usuario" type="text" value="<?php echo $_SESSION['Usuario']; ?>" size="27" readonly="readonly" />
                            </tr>
                            <tr>
                              <td colspan="9" nowrap="nowrap" id="fuente2">&nbsp;</td>
                            </tr>
                            <tr id="tr1">
                              <td colspan="3" nowrap="nowrap" id="fuente2">Referencia</td>
                              <td colspan="2" id="fuente2">Version</td>
                              <td nowrap="nowrap" colspan="4" id="dato1">
                                <?php if ($_SESSION['superacceso'] || (in_array($_SESSION['id_usuario'], $_SESSION['usuariosarray']))) : ?>
                                  <a class="botonGMini" onclick="vercopiaMezcla()">GENERAR COPIA</a>
                                <?php endif; ?>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" nowrap="nowrap" id="numero2">
                                <?php echo $row_referencia['cod_ref']; ?>
                              </td>
                              <td colspan="2" nowrap="nowrap" id="numero2">
                                <?php echo $row_referencia['version_ref']; ?>
                              </td>
                              <td colspan="3" id="fuente1">
                                <select name="ref" id="refcopia" class="refcopia   selectsMini" style="display: none;" onchange="copiaMezcla();">
                                  <option value="" <?php if (!(strcmp("", $_GET['cod_refcopia']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>Referencia</option>
                                  <?php foreach ($this->row_referencia_copia as $row_referencia_copia) {  ?>
                                    <option value="<?php echo $row_referencia_copia['int_cod_ref_pm']; ?>" <?php if (!(strcmp($row_referencia_copia['int_cod_ref_pm'], $_GET['cod_refcopia']))) {
                                                                                                          echo "selected=\"selected\"";
                                                                                                        } ?>><?php echo htmlentities($row_referencia_copia['int_cod_ref_pm']); ?> </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <tr>
                                <td colspan="9" id="fuente2">
                                  <?php if ($_GET['cod_refcopia'])
                                  echo 'Copiando Caracteristicas ' . $_GET['cod_refcopia'];
                                ?>
                              </td>
                            </tr>
                            </tr>
                            <!--  INICIA MEZCLAS DE IMPRESION -->
                            
                            <tr>
                              <td colspan="9" id="titulo4">
                                IMPRESORA:
                                <select name="maquina" id="impresora_ci" class="busqueda selectsMedio" required="required">
                                  <option value="">Seleccione</option>
                                  <?php foreach ($this->maquinas as $maquinas) { ?>
                                    <option value="<?php echo $maquinas['nombre_maquina']; ?>" <?php if (!(strcmp($row_caract['maquina'], $maquinas['nombre_maquina']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($maquinas['nombre_maquina']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <tr id="tr1">
                              <td colspan="9"> <strong style="color: red;"> NOTA: Los colores de las 8 unidades se deben ingresar en la referencia</strong></td>
                            </tr>
                            <tr>
          <td colspan="17" style="background-color: #ABADAF;"></td>
        </tr>
                            <tr id="tr1">
                              <td colspan="9" id="titulo4">UNIDADES DE IMPRESION</td>
                            </tr>
                            <tr>
                            <td id="fuente1"></td>
                              <td colspan="2" id="fuente2" class="fondoGris">UNIDAD 1</td>
                              <td colspan="2" id="fuente2">UNIDAD 2</td>
                              <td colspan="2" id="fuente2" class="fondoGris">UNIDAD 3</td>
                              <td colspan="2" id="fuente2">UNIDAD 4</td>
                              
                            </tr>
                            <tr>
                              <td id="fuente2">COLORES </td>
                              <td colspan="1" id="fuente1" class="fondoGris">
                                <select name="color1" id="color1" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color1']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color1']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td colspan="1" id="fuente1" class="fondoGris">
                                <input readonly name="val_color1" type="text" id="val_color1" placeholder="%" size="2" value="<?php echo $row_caract['val_color1']; ?>"/>
                              </td>
                              <td id="fuente1">
                                <select name="color2" id="color2" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color2']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color2']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input readonly name="val_color2" type="text" id="val_color2" placeholder="%" size="2" value="<?php echo $row_caract['val_color2'] ?>" />
                              </td>

                              <td id="fuente1" class="fondoGris">
                                <select name="color3" id="color3" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color3']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color3']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <input readonly name="val_color3" type="text" id="val_color3" placeholder="%" size="2" value="<?php echo $row_caract['val_color3'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="color4" id="color4" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color4']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color4']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input readonly name="val_color4" type="text" id="val_color4" placeholder="%" size="2" value="<?php echo $row_caract['val_color4'] ?>" />
                              </td>
                              
                            <tr>
                              <td id="fuente2">MEZCLA 1</td>
                              <td colspan="1" id="fuente1" class="fondoGris">
                                <select name="mezcla1" id="mezcla1" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla1']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla1']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td colspan="1" id="fuente1" class="fondoGris">
                                <input name="val_mezcla1" type="text" id="val_mezcla1" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla1'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="mezcla2" id="mezcla2" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla2']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla2']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input name="val_mezcla2" type="text" id="val_mezcla2" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla2'] ?>" />
                              </td>

                              <td id="fuente1" class="fondoGris">
                                <select name="mezcla3" id="mezcla3" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla3']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla3']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <input name="val_mezcla3" type="text" id="val_mezcla3" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla3'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="mezcla4" id="mezcla4" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla4']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla4']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input name="val_mezcla4" type="text" id="val_mezcla4" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla4'] ?>" />
                              </td>
                              
                              
                            </tr>

        </tr>
        <tr>
        <td id="fuente2">MEZCLA 2</td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <select name="mezcla9" id="mezcla9" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla9']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla9']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <input name="val_mezcla9" type="text" id="val_mezcla9" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla9'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla10" id="mezcla10" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla10']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla10']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla10" type="text" id="val_mezcla10" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla10'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="mezcla11" id="mezcla11" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla11']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla11']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla11" type="text" id="val_mezcla11" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla11'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla12" id="mezcla12" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla12']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla12']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla12" type="text" id="val_mezcla12" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla12'] ?>" />
          </td>
          <tr>
          <td id="fuente2">MEZCLA 3</td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <select name="mezcla17" id="mezcla17" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla17']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla17']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <input name="val_mezcla17" type="text" id="val_mezcla17" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla17'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla18" id="mezcla18" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla18']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla18']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla18" type="text" id="val_mezcla18" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla18'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="mezcla19" id="mezcla19" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla19']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla19']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla19" type="text" id="val_mezcla19" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla19'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla20" id="mezcla20" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla20']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla20']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla20" type="text" id="val_mezcla20" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla20'] ?>" />
          </td>
          

        <tr>
        <td id="fuente2">MEZCLA 4</td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <select name="mezcla25" id="mezcla25" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla25']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla25']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <input name="val_mezcla25" type="text" id="val_mezcla25" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla25'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla26" id="mezcla26" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla26']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla26']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla26" type="text" id="val_mezcla26" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla26'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="mezcla27" id="mezcla27" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla27']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla27']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla27" type="text" id="val_mezcla27" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla27'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla28" id="mezcla28" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla28']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla28']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla28" type="text" id="val_mezcla28" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla28'] ?>" />
          </td>
          
        </tr>
        <tr>
          <td id="fuente2">ALCOHOL</td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <select name="alcohol1" id="alcohol1" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol1']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol1']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <input name="val_alcohol1" type="text" id="val_alcohol1" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol1'] ?>" />
          </td>
          <td id="fuente1">
            <select name="alcohol2" id="alcohol2" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol2']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol2']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_alcohol2" type="text" id="val_alcohol2" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol2'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="alcohol3" id="alcohol3" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol3']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol3']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_alcohol3" type="text" id="val_alcohol3" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol3'] ?>" />
          </td>
          <td id="fuente1">
            <select name="alcohol4" id="alcohol4" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol4']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol4']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_alcohol4" type="text" id="val_alcohol4" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol4'] ?>" />
          </td>
        </tr>
        <tr>
          <td id="fuente2">ACETATO NPA</td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <select name="acetato1" id="acetato1" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato1']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato1']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="1" id="fuente1" class="fondoGris"><input name="val_acetato1" type="text" id="val_acetato1" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato1'] ?>" />
          </td>
          <td id="fuente1">
            <select name="acetato2" id="acetato2" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato2']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato2']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_acetato2" type="text" id="val_acetato2" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato2'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="acetato3" id="acetato3" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato3']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato3']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_acetato3" type="text" id="val_acetato3" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato3'] ?>" />
          </td>
          <td id="fuente1">
            <select name="acetato4" id="acetato4" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato4']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato4']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_acetato4" type="text" id="val_acetato4" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato4'] ?>" />
          </td>
        </tr>
        <tr>
          <td id="fuente2">METOXIPROPANOL</td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <select name="metoxi1" id="metoxi1" class="width_selects" >
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi1']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi1']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="1" id="fuente1" class="fondoGris">
            <input name="val_metoxi1" type="text" id="val_metoxi1" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi1'] ?>" />
          </td>
          <td id="fuente1">
            <select name="metoxi2" id="metoxi2" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi2']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi2']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_metoxi2" type="text" id="val_metoxi2" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi2'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="metoxi3" id="metoxi3" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi3']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi3']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_metoxi3" type="text" id="val_metoxi3" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi3'] ?>" />
          </td>
          <td id="fuente1">
            <select name="metoxi4" id="metoxi4" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi4']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi4']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_metoxi4" type="text" id="val_metoxi4" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi4'] ?>" />
          </td>
        </tr>
        <tr>
          <td id="fuente2">STIK</td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <select name="stik1" id="stik1" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik1'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="stik2" id="stik2" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik2'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <select name="stik3" id="stik3" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik3'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="stik4" id="stik4" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik4'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td id="fuente2">VISCOSIDAD</td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <input name="visco1" id="visco1" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco1'] ?>" placeholder="seg" /> Segundos
          </td>
          <td colspan="2" id="fuente1">
            <input name="visco2" id="visco2" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco2'] ?>" placeholder="seg" /> Segundos
          </td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <input name="visco3" id="visco3" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco3'] ?>" placeholder="seg" /> Segundos
          </td>
          <td colspan="2" id="fuente1">
            <input name="visco4" id="visco4" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco4'] ?>" placeholder="seg" /> Segundos
          </td>
        </tr>
        <tr>
          <td id="fuente2">ANILOX</td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <select name="anilox1" id="anilox1" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox1']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox1']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="anilox2" id="anilox2" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox2']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox2']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <select name="anilox3" id="anilox3" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox3']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox3']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="anilox4" id="anilox4" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox4']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox4']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          
        </tr>
        <tr>
          <td colspan="17" style="background-color: #ABADAF;"></td>
        </tr>
        <!-- <tr>
                        <td id="fuente1">BCM</td>
                          <td id="fuente1">
                              <select name="int_ref3_tol2_pm" id="int_ref3_tol2_pm" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['int_ref3_tol2_pm']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['int_ref3_tol2_pm']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="int_ref3_tol2_porc3_pm"  type="text"  id="int_ref3_tol2_porc3_pm" placeholder="%" size="3"value="<?php echo $row_caract['int_ref3_tol2_porc3_pm'] ?>"/>
                          </td>
                        <td id="fuente1">
                              <select name="campo_123" id="campo_123" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_123']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_123']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_124"  type="text"  id="campo_124" placeholder="%" size="3"value="<?php echo $row_caract['campo_124'] ?>"/>
                            </td>
                          <td id="fuente1">
                              <select name="campo_125" id="campo_125" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_125']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_125']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_126"  type="text"  id="campo_126" placeholder="%" size="3"value="<?php echo $row_caract['campo_126'] ?>"/>
                            </td>
                          <td id="fuente1">
                              <select name="campo_127" id="campo_127" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_127']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_127']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_128"  type="text"  id="campo_128" placeholder="%" size="3"value="<?php echo $row_caract['campo_128'] ?>"/>
                            </td>
                          <td id="fuente1">
                              <select name="campo_129" id="campo_129" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_129']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_129']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_130"  type="text"  id="campo_130" placeholder="%" size="3"value="<?php echo $row_caract['campo_130'] ?>"/>
                            </td>
                          <td id="fuente1">
                              <select name="campo_131" id="campo_131" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_131']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_131']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_132"  type="text"  id="campo_132" placeholder="%" size="3"value="<?php echo $row_caract['campo_132'] ?>"/>
                            </td>
                          <td id="fuente1">
                              <select name="campo_133" id="campo_133" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_133']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_133']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_134"  type="text"  id="campo_134" placeholder="%" size="3"value="<?php echo $row_caract['campo_134'] ?>"/>
                            </td>
                          <td id="fuente1">
                              <select name="campo_135" id="campo_135" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['campo_135']))) {
                                                echo "selected=\"selected\"";
                                              } ?>>BCM</option>
                              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['campo_135']))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                            <input name="campo_136"  type="text"  id="campo_136" placeholder="%" size="3"value="<?php echo $row_caract['campo_136'] ?>"/>
                            </td>
                      </tr> -->
                      <tr>
                      <td id="fuente1"></td>
                      <td colspan="2" id="fuente2" class="fondoGris">UNIDAD 5</td>
                              <td colspan="2" id="fuente2">UNIDAD 6</td>
                              <td colspan="2" id="fuente2" class="fondoGris">UNIDAD 7</td>
                              <td colspan="3" id="fuente2">UNIDAD 8</td>
                      </tr>
                      <tr>
                      <td id="fuente2">COLORES </td>
                      <td id="fuente1" class="fondoGris">
                                <select name="color5" id="color5" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color5']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color5']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <input readonly name="val_color5" type="text" id="val_color5" placeholder="%" size="2" value="<?php echo $row_caract['val_color5'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="color6" id="color6" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color6']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color6']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input readonly name="val_color6" type="text" id="val_color6" placeholder="%" size="2" value="<?php echo $row_caract['val_color6'] ?>" />
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <select name="color7" id="color7" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color7']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color7']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <input readonly name="val_color7" type="text" id="val_color7" placeholder="%" size="2" value="<?php echo $row_caract['val_color7'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="color8" id="color8" class="width_selects" onchange="updateInput(this)">
                                  <option value="" <?php if (!(strcmp("", $row_caract['color8']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>COLOR</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color8']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input readonly name="val_color8" type="text" id="val_color8" placeholder="%" size="2" value="<?php echo $row_caract['val_color8'] ?>" />
                              </td>
                            </tr>
                      </tr>
                      <tr>
                      <td id="fuente2">MEZCLA 1</td>
                      <td id="fuente1" class="fondoGris">
                                <select name="mezcla5" id="mezcla5" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla5']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla5']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <input name="val_mezcla5" type="text" id="val_mezcla5" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla5'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="mezcla6" id="mezcla6" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla6']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla6']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input name="val_mezcla6" type="text" id="val_mezcla6" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla6'] ?>" />
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <select name="mezcla7" id="mezcla7" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla7']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla7']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1" class="fondoGris">
                                <input name="val_mezcla7" type="text" id="val_mezcla7" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla7'] ?>" />
                              </td>
                              <td id="fuente1">
                                <select name="mezcla8" id="mezcla8" class="width_selects">
                                  <option value="" <?php if (!(strcmp("", $row_caract['mezcla8']))) {
                                                      echo "selected=\"selected\"";
                                                    } ?>>MEZCLAS</option>
                                  <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla8']))) {
                                                                                                      echo "selected=\"selected\"";
                                                                                                    } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                                    </option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td id="fuente1">
                                <input name="val_mezcla8" type="text" id="val_mezcla8" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla8'] ?>" />
                              </td>
                      </tr>
                      <tr>
                      <td id="fuente2">MEZCLA 2</td>
                      <td id="fuente1" class="fondoGris">
            <select name="mezcla13" id="mezcla13" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla13']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla13']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla13" type="text" id="val_mezcla13" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla13'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla14" id="mezcla14" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla14']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla14']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla14" type="text" id="val_mezcla14" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla14'] ?>" />
          </td>
          
                      <td id="fuente1" class="fondoGris">
            <select name="mezcla15" id="mezcla15" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla15']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla15']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla15" type="text" id="val_mezcla15" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla15'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla16" id="mezcla16" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla16']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla16']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla16" type="text" id="val_mezcla16" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla16'] ?>" />
          </td>
        </tr>

        </tr>
        <tr>
        <td id="fuente2">MEZCLA 3</td>
        <td id="fuente1" class="fondoGris">
            <select name="mezcla21" id="mezcla21" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla21']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla21']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla21" type="text" id="val_mezcla21" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla21'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla22" id="mezcla22" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla22']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla22']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla22" type="text" id="val_mezcla22" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla22'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="mezcla23" id="mezcla23" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla23']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla23']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla23" type="text" id="val_mezcla23" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla23'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla24" id="mezcla24" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla24']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla24']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla24" type="text" id="val_mezcla24" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla24'] ?>" />
          </td>
          </tr>
<tr>
<td id="fuente2">MEZCLA 4</td>
<td id="fuente1" class="fondoGris">
            <select name="mezcla29" id="mezcla29" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla29']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla29']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla29" type="text" id="val_mezcla29" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla29'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla30" id="mezcla30" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla30']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla30']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla30" type="text" id="val_mezcla30" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla30'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="mezcla31" id="mezcla31" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla31']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla31']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_mezcla31" type="text" id="val_mezcla31" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla31'] ?>" />
          </td>
          <td id="fuente1">
            <select name="mezcla32" id="mezcla32" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['mezcla32']))) {
                                  echo "selected=\"selected\"";
                                } ?>>MEZCLAS</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla32']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_mezcla32" type="text" id="val_mezcla32" placeholder="%" size="2" value="<?php echo $row_caract['val_mezcla32'] ?>" />
          </td>
</tr>
<tr>
<td id="fuente2">ALCOHOL</td>
<td id="fuente1" class="fondoGris">
            <select name="alcohol5" id="alcohol5" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol5']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol5']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
<td id="fuente1" class="fondoGris">
            <input name="val_alcohol5" type="text" id="val_alcohol5" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol5'] ?>" />
          </td>
          <td id="fuente1">
            <select name="alcohol6" id="alcohol6" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol6']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol6']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_alcohol6" type="text" id="val_alcohol6" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol6'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="alcohol7" id="alcohol7" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol7']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol7']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_alcohol7" type="text" id="val_alcohol7" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol7'] ?>" />
          </td>
          <td id="fuente1">
            <select name="alcohol8" id="alcohol8" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['alcohol8']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ALCOHOL</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol8']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_alcohol8" type="text" id="val_alcohol8" placeholder="%" size="2" value="<?php echo $row_caract['val_alcohol8'] ?>" />
          </td>
</tr>
<tr>
<td id="fuente2">ACETATO NPA</td>
<td id="fuente1" class="fondoGris">
            <select name="acetato5" id="acetato5" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato5']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato5']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_acetato5" type="text" id="val_acetato5" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato5'] ?>" />
          </td>
          <td id="fuente1">
            <select name="acetato6" id="acetato6" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato6']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato6']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_acetato6" type="text" id="val_acetato6" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato6'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="acetato7" id="acetato7" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato7']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato7']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_acetato7" type="text" id="val_acetato7" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato7'] ?>" />
          </td>
          <td id="fuente1">
            <select name="acetato8" id="acetato8" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['acetato8']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ACETATO</option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato8']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_acetato8" type="text" id="val_acetato8" placeholder="%" size="2" value="<?php echo $row_caract['val_acetato8'] ?>" />
          </td>
</tr>
<tr>
<td id="fuente2">METOXIPROPANOL</td>
<td id="fuente1" class="fondoGris">
            <select name="metoxi5" id="metoxi5" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi5']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi5']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_metoxi5" type="text" id="val_metoxi5" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi5'] ?>" />
          </td>
          <td id="fuente1">
            <select name="metoxi6" id="metoxi6" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi6']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi6']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_metoxi6" type="text" id="val_metoxi6" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi6'] ?>" />
          </td>
          <td id="fuente1" class="fondoGris">
            <select name="metoxi7" id="metoxi7" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi7']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi7']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1" class="fondoGris">
            <input name="val_metoxi7" type="text" id="val_metoxi7" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi7'] ?>" />
          </td>
          <td id="fuente1">
            <select name="metoxi8" id="metoxi8" class="width_selects">
              <option value="" <?php if (!(strcmp("", $row_caract['metoxi8']))) {
                                  echo "selected=\"selected\"";
                                } ?>></option>
              <?php foreach ($this->row_materia_prima as $row_materia_prima) { ?>
                <option value="<?php echo $row_materia_prima['id_insumo']; ?>" <?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi8']))) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td id="fuente1">
            <input name="val_metoxi8" type="text" id="val_metoxi8" placeholder="%" size="2" value="<?php echo $row_caract['val_metoxi8'] ?>" />
          </td>
        </tr>
        <tr>
</tr>
<tr>
<td id="fuente2">STIK</td>
<td colspan="2" id="fuente1" class="fondoGris">
            <select name="stik5" id="stik5" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik5'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="stik6" id="stik6" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik6'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <select name="stik7" id="stik7" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik7'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="stik8" id="stik8" class="width_selects bordegris">
              <option value="">STIK</option>
              <?php foreach ($stik as $row_stik) { ?>
                <option value="<?php echo $row_stik; ?>" <?php if (!(strcmp($row_caract['stik8'], $row_stik))) {
                                                            echo "selected=\"selected\"";
                                                          } ?>><?php echo $row_stik; ?></option>
              <?php } ?>
            </select>
          </td>
</tr>
<tr>
<td id="fuente2">VISCOSIDAD</td>
<td colspan="2" id="fuente1" class="fondoGris">
            <input name="visco5" id="visco5" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco5'] ?>" placeholder="seg" /> Segundos
          </td>
          <td colspan="2" id="fuente1">
            <input name="visco6" id="visco6" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco6'] ?>" placeholder="seg" /> Segundos
          </td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <input name="visco7" id="visco7" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco7'] ?>" placeholder="seg" /> Segundos
          </td>
          <td colspan="2" id="fuente1">
            <input name="visco8" id="visco8" style="width:50px" min="0" step="0.1" type="number" size="3" value="<?php echo $row_caract['visco8'] ?>" placeholder="seg" /> Segundos
          </td>
</tr>
<tr>
<td id="fuente2">ANILOX</td>
<td colspan="2" id="fuente1" class="fondoGris">
            <select name="anilox5" id="anilox5" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox5']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox5']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="anilox6" id="anilox6" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox6']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox6']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1" class="fondoGris">
            <select name="anilox7" id="anilox7" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox7']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox7']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="anilox8" id="anilox8" class="width_selects bordegris">
              <option value="" <?php if (!(strcmp("", $row_caract['anilox8']))) {
                                  echo "selected=\"selected\"";
                                } ?>>ANILOX</option>
              <?php foreach ($this->anilox as $row_anilox) { ?>
                <option value="<?php echo $row_anilox['id_insumo']; ?>" <?php if (!(strcmp($row_anilox['id_insumo'], $row_caract['anilox8']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo htmlentities($row_anilox['descripcion_insumo']); ?>
                </option>
              <?php } ?>
            </select>
          </td>
</tr>
<tr>
          <td colspan="17" style="background-color: #ABADAF;"></td>
        </tr>
        <tr>
          <td colspan="9" id="fuente1">
            <textarea name="observ_ci" id="observ_ci" cols="80" rows="3" placeholder="OBSERVACIONES"><?php echo $row_caract['observ_ci'] ?></textarea>
          </td>
        </tr>

        <!-- INICIA CARACTERISTICAS -->
        <tr>
          <!-- <td  colspan="10" id="titulo4"> 
                   <input name="impresora"  type="text" id="impresora" placeholder="Impresora" size="20" value="<?php echo $row_caract['extrusora_mp']; ?>" readonly="readonly"/>  
                 </td> -->
        </tr>
        <tr id="tr1">
          <td colspan="19" id="titulo2">CARACTERISTICAS DE IMPRESION </td>
        </tr>
        <tr>
          <td colspan="1" id="fuente1">Cant de Unidades</td>
          <td colspan="2" id="fuente1">Temp Secado Tunel</td>
          <td colspan="2" id="fuente1">Temp Secado Tinteros</td>
          <td colspan="2" id="fuente1">Numero de Pistas</td>
          <td colspan="2" id="fuente1">Repeticion Perimetro</td>
          
        </tr>
        <tr>
          <td colspan="1" id="fuente1">
            <input name="cant_unidades" id="cant_unidades" style="width:40px" min="0" max="8" step="1" type="number" size="3" value="<?php echo $row_caract['cant_unidades'] ?>"/>
          </td>
          <td colspan="2" id="fuente1">
            <input name="temp_tunel" id="temp_tunel" style="width:40px" min="0" step="1" type="number" size="3" value="<?php echo $row_caract['temp_tunel'] ?>" placeholder="°C" /> °C
          </td>
          <td colspan="2" id="fuente1">
            <input name="temp_tintas" id="temp_tintas" style="width:40px" min="0" step="1" type="number" size="3" value="<?php echo $row_caract['temp_tintas'] ?>" placeholder="°C" /> °C
          </td>
          <td colspan="2" id="fuente1">
            <input name="rep_ancho" id="rep_ancho" style="width:40px" min="0" step="1" type="number" size="3" value="<?php echo $row_caract['rep_ancho'] ?>" />
          </td>
          <td colspan="2" id="fuente1">
            <input name="rep_perimetro" id="rep_perimetro" style="width:40px" min="0" step="1" type="number" size="3" value="<?php echo $row_caract['rep_perimetro'] ?>" />
          </td>
         
        </tr>
        <tr>
        <td colspan="3" id="fuente1">Arte Aprobado (SI/NO)</td>
          <td colspan="2" id="fuente1">Guia Fotocelda (SI/NO)</td>
          <td colspan="2" id="fuente1">Velocidad Maquina</td>
          <td colspan="1" id="fuente1">Z</td>
        </tr>
        <tr>
        <td colspan="3" id="fuente1">
            <select name="arte" id="arte" style="width:50px">
              <option value="0" <?php if (!strcmp("0", $row_caract['arte'])) {
                                  echo "selected=\"selected\"";
                                } ?>>SI</option>
              <option value="1" <?php if (!strcmp("1", $row_caract['arte'])) {
                                  echo "selected=\"selected\"";
                                } ?>>NO</option>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <select name="guia_fotoc" id="guia_fotoc" style="width:50px">
              <option value="0" <?php if (!strcmp("0", $row_caract['guia_fotoc'])) {
                                  echo "selected=\"selected\"";
                                } ?>>SI</option>
              <option value="1" <?php if (!strcmp("1", $row_caract['guia_fotoc'])) {
                                  echo "selected=\"selected\"";
                                } ?>>NO</option>
            </select>
          </td>
          <td colspan="2" id="fuente1">
            <input name="velocidad" id="velocidad" style="width:50px" min="0" step="1" type="number" size="3" value="<?php echo $row_caract['velocidad'] ?>" />
          </td>
          <td colspan="1" id="fuente1">
            <input name="z" id="z" style="width:50px" min="0" step="1" type="number" size="3" value="<?php echo $row_caract['z'] ?>" />
          </td>
        </tr>
        <tr>
          <td colspan="3" id="fuente1">Tension Desbobinador</td>
          <td colspan="2" id="fuente1">Tension Refrescador</td>
          <td colspan="2" id="fuente1">Tension Rebobinador</td>
        </tr>
        <tr>
          <td colspan="3" id="fuente1">
            <input name="tension_desbo" id="tension_desbo" style="width:40px" min="0" step="1" type="number" size="2" value="<?php echo $row_caract['tension_desbo'] ?>" placeholder="Tension" /> N
          </td>
          <td colspan="2" id="fuente1">
            <input name="tension_refres" id="tension_refres" style="width:40px" min="0" step="1" type="number" size="2" value="<?php echo $row_caract['tension_refres'] ?>" placeholder="Tension" /> N
          </td>
          <td colspan="2" id="fuente1">
            <input name="tension_rebo" id="tension_rebo" style="width:40px" min="0" step="1" type="number" size="2" value="<?php echo $row_caract['tension_rebo'] ?>" placeholder="Tension" /> N
          </td>
        </tr>
        <tr id="tr1">
          <td colspan="19" id="fuente2">
            <div class="panel-footer">
              <input type="hidden" name="fecha_registro" id="fecha_registro" value="<?php echo date('Y-m-d') ?>" />
              <input type="hidden" name="id_ref_ci" id="id_ref_ci" value="<?php echo $row_referencia['id_ref']; ?>" />
              <input type="hidden" name="cod_ref_ci" id="cod_ref_ci" value="<?php echo $row_referencia['cod_ref']; ?>" />
              <input type="hidden" name="version_ref_ci" id="version_ref_ci" value="<?php echo $row_referencia['version_ref']; ?>" />
              <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['Usuario'] ?>" />
              <input type="hidden" name="modifico" id="modifico" value="<?php echo $_SESSION['Usuario'] ?>" />
              <input type="hidden" name="fecha_modif" id="fecha_modif" value="<?php echo date('Y-m-d H:i:s') ?>" />
              <input class="botonGeneral" type="submit" name="GUARDAR" id="GUARDAR" value="GUARDAR" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a class="botonFinalizar" style="text-decoration:none; " href="javascript:saliryCerrar()">SALIR</a>
            </div>
          </td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
      </form>
      <!-- FIN CARACTERISTICAS -->
    </div>
  </div>
  </div>
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
    busquedaColor('#color1', 'COLOR', <?php echo $row_caract['color1'] ?>);
    busquedaColor('#color2', 'COLOR', <?php echo $row_caract['color2'] ?>);
    busquedaColor('#color3', 'COLOR', <?php echo $row_caract['color3'] ?>);
    busquedaColor('#color4', 'COLOR', <?php echo $row_caract['color4'] ?>);
    busquedaColor('#color5', 'COLOR', <?php echo $row_caract['color5'] ?>);
    busquedaColor('#color6', 'COLOR', <?php echo $row_caract['color6'] ?>);
    busquedaColor('#color7', 'COLOR', <?php echo $row_caract['color7'] ?>);
    busquedaColor('#color8', 'COLOR', <?php echo $row_caract['color8'] ?>);
    busquedaColor('#mezcla1', 'MEZCLAS', <?php echo $row_caract['mezcla1'] ?>);
    busquedaColor('#mezcla2', 'MEZCLAS', <?php echo $row_caract['mezcla2'] ?>);
    busquedaColor('#mezcla3', 'MEZCLAS', <?php echo $row_caract['mezcla3'] ?>);
    busquedaColor('#mezcla4', 'MEZCLAS', <?php echo $row_caract['mezcla4'] ?>);
    busquedaColor('#mezcla5', 'MEZCLAS', <?php echo $row_caract['mezcla5'] ?>);
    busquedaColor('#mezcla6', 'MEZCLAS', <?php echo $row_caract['mezcla6'] ?>);
    busquedaColor('#mezcla7', 'MEZCLAS', <?php echo $row_caract['mezcla7'] ?>);
    busquedaColor('#mezcla8', 'MEZCLAS', <?php echo $row_caract['mezcla8'] ?>);
    busquedaColor('#mezcla9', 'MEZCLAS', <?php echo  $row_caract['mezcla9'] ?>);
    busquedaColor('#mezcla10', 'MEZCLAS', <?php echo $row_caract['mezcla10'] ?>);
    busquedaColor('#mezcla11', 'MEZCLAS', <?php echo $row_caract['mezcla11'] ?>);
    busquedaColor('#mezcla12', 'MEZCLAS', <?php echo $row_caract['mezcla12'] ?>);
    busquedaColor('#mezcla13', 'MEZCLAS', <?php echo $row_caract['mezcla13'] ?>);
    busquedaColor('#mezcla14', 'MEZCLAS', <?php echo $row_caract['mezcla14'] ?>);
    busquedaColor('#mezcla15', 'MEZCLAS', <?php echo $row_caract['mezcla15'] ?>);
    busquedaColor('#mezcla16', 'MEZCLAS', <?php echo $row_caract['mezcla16'] ?>);
    busquedaColor('#mezcla17', 'MEZCLAS', <?php echo $row_caract['mezcla17'] ?>);
    busquedaColor('#mezcla18', 'MEZCLAS', <?php echo $row_caract['mezcla18'] ?>);
    busquedaColor('#mezcla19', 'MEZCLAS', <?php echo $row_caract['mezcla19'] ?>);
    busquedaColor('#mezcla20', 'MEZCLAS', <?php echo $row_caract['mezcla20'] ?>);
    busquedaColor('#mezcla21', 'MEZCLAS', <?php echo $row_caract['mezcla21'] ?>);
    busquedaColor('#mezcla22', 'MEZCLAS', <?php echo $row_caract['mezcla22'] ?>);
    busquedaColor('#mezcla23', 'MEZCLAS', <?php echo $row_caract['mezcla23'] ?>);
    busquedaColor('#mezcla24', 'MEZCLAS', <?php echo $row_caract['mezcla24'] ?>);
    busquedaColor('#mezcla25', 'MEZCLAS', <?php echo $row_caract['mezcla25'] ?>);
    busquedaColor('#mezcla26', 'MEZCLAS', <?php echo $row_caract['mezcla26'] ?>);
    busquedaColor('#mezcla27', 'MEZCLAS', <?php echo $row_caract['mezcla27'] ?>);
    busquedaColor('#mezcla28', 'MEZCLAS', <?php echo $row_caract['mezcla28'] ?>);
    busquedaColor('#mezcla29', 'MEZCLAS', <?php echo $row_caract['mezcla29'] ?>);
    busquedaColor('#mezcla30', 'MEZCLAS', <?php echo $row_caract['mezcla30'] ?>);
    busquedaColor('#mezcla31', 'MEZCLAS', <?php echo $row_caract['mezcla31'] ?>);
    busquedaColor('#mezcla32', 'MEZCLAS', <?php echo $row_caract['mezcla32'] ?>);
    busquedaColor('#alcohol1', 'ALCOHOL', <?php echo $row_caract['alcohol1'] ?>);
    busquedaColor('#alcohol2', 'ALCOHOL', <?php echo $row_caract['alcohol2'] ?>);
    busquedaColor('#alcohol3', 'ALCOHOL', <?php echo $row_caract['alcohol3'] ?>);
    busquedaColor('#alcohol4', 'ALCOHOL', <?php echo $row_caract['alcohol4'] ?>);
    busquedaColor('#alcohol5', 'ALCOHOL', <?php echo $row_caract['alcohol5'] ?>);
    busquedaColor('#alcohol6', 'ALCOHOL', <?php echo $row_caract['alcohol6'] ?>);
    busquedaColor('#alcohol7', 'ALCOHOL', <?php echo $row_caract['alcohol7'] ?>);
    busquedaColor('#alcohol8', 'ALCOHOL', <?php echo $row_caract['alcohol8'] ?>);
    busquedaColor('#acetato1', 'ACETATO', <?php echo $row_caract['acetato1'] ?>);
    busquedaColor('#acetato2', 'ACETATO', <?php echo $row_caract['acetato2'] ?>);
    busquedaColor('#acetato3', 'ACETATO', <?php echo $row_caract['acetato3'] ?>);
    busquedaColor('#acetato4', 'ACETATO', <?php echo $row_caract['acetato4'] ?>);
    busquedaColor('#acetato5', 'ACETATO', <?php echo $row_caract['acetato5'] ?>);
    busquedaColor('#acetato6', 'ACETATO', <?php echo $row_caract['acetato6'] ?>);
    busquedaColor('#acetato7', 'ACETATO', <?php echo $row_caract['acetato7'] ?>);
    busquedaColor('#acetato8', 'ACETATO', <?php echo $row_caract['acetato8'] ?>);
    busquedaColor('#metoxi1', 'METOXIPROPANOL', <?php echo $row_caract['metoxi1'] ?>);
    busquedaColor('#metoxi2', 'METOXIPROPANOL', <?php echo $row_caract['metoxi2'] ?>);
    busquedaColor('#metoxi3', 'METOXIPROPANOL', <?php echo $row_caract['metoxi3'] ?>);
    busquedaColor('#metoxi4', 'METOXIPROPANOL', <?php echo $row_caract['metoxi4'] ?>);
    busquedaColor('#metoxi5', 'METOXIPROPANOL', <?php echo $row_caract['metoxi5'] ?>);
    busquedaColor('#metoxi6', 'METOXIPROPANOL', <?php echo $row_caract['metoxi6'] ?>);
    busquedaColor('#metoxi7', 'METOXIPROPANOL', <?php echo $row_caract['metoxi7'] ?>);
    busquedaColor('#metoxi8', 'METOXIPROPANOL', <?php echo $row_caract['metoxi8'] ?>);

    $(".busqueda").select2();

    refcopia = $(".refcopia").val();
    if (refcopia != '')
      vercopiaMezcla();

    /* $( ".select_colores" ).change(function() { 
      let name_color = document.querySelector("#color1").value;
      console.log(name_color)
      if(name_color != ""){
        document.querySelector("#val_color1").value = 100
      } else document.querySelector("#val_color1").value = ""
    }) */
  });

  function updateInput(selectElement) {
    const selectId = selectElement.id; // Obtener el ID del select
    const inputId = selectId.replace('color', 'val_color'); // Derivar el ID del input correspondiente
    const inputElement = document.getElementById(inputId); // Obtener el elemento input correspondiente
    // Verificar si el select tiene algún valor seleccionado
    if (selectElement.value) {
      inputElement.value = 100;
    } else {
      inputElement.value = '';
    }
  } 

  function vercopiaMezcla() {
    $('.refcopia').show();
  }

  function copiaMezcla() {
    refcopia = $("#refcopia").val();
    cod_ref = $("#cod_ref_ci").val();
    if (refcopia)
      window.location = "view_index.php?c=cmezclasIm&a=Carat&cod_ref=" + cod_ref + "&cod_refcopia=" + refcopia;
  }

  function Impresora() {
    $("#impresora").val($("#impresora_ci").val());
  }


  function busquedaColor(elemento, nom, select) {

    select = (select == "" || select == undefined) ? nom : select
    $(elemento).select2({
      placeholder: select,
      allowClear: true,
      ajax: {
        url: "select3/proceso.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            palabraClave: params.term, // search term
            var1: "id_insumo", //campo normal para usar
            var2: "insumo", //tabla
            var3: "clase_insumo='8' AND estado_insumo='0'", //where
            var4: "ORDER BY descripcion_insumo ASC",
            var5: "id_insumo", //clave
            var6: "descripcion_insumo" //columna a buscar
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });
  }

  /* comprobar si se ingreso la cantidad de unidades y si se lleno con los colores */
  $("#GUARDAR").on("click", function() {
    let cont = 0;
    if ($("#cant_unidades").val() == '') {
      $("#cant_unidades").focus();
      swal("Error", "Debe agregar la cantidad de unidades! :)", "error");
      return false;
    }
    let unidades = $("#cant_unidades").val();
    for (let i = 1; i <= 8; i++) {
      if ($(`#val_color${i}`).val() != "") {
        cont++
      }
    }
    if (cont < unidades) {
      for (let i = 1; i <= 8; i++) {
        if ($(`#mezcla${i}`).val() != "") {
          cont++
        }
      }
    }
    if (cont < unidades) {
      $("#color1").focus();
      swal("Error", "Falta por agregar mas colores/mezclas o falta agregarle el Valor! :)", "error");
      return false;
    }

    if($("#temp_tunel").val() == ''){
      swal("Error", "Falta por agregar Temperatura Secado Tunel! :)", "error");
      return false;
    }
    if($("#temp_tintas").val() == ''){
      swal("Error", "Falta por agregar Temperatura Tintas! :)", "error");
      return false;
    }
    if($("#rep_ancho").val() == ''){
      swal("Error", "Falta por agregar el Numero de Pistas! :)", "error");
      return false;
    }
    if($("#rep_perimetro").val() == ''){
      swal("Error", "Falta por agregar la Repeticion del Perimetro! :)", "error");
      return false;
    }
    if($("#velocidad").val() == ''){
      swal("Error", "Falta por agregar la Velocidad! :)", "error");
      return false;
    }
    if($("#z").val() == ''){
      swal("Error", "Falta por agregar la Z! :)", "error");
      return false;
    }
    if($("#tension_desbo").val() == ''){
      swal("Error", "Falta por agregar la Tension del Desbobinador! :)", "error");
      return false;
    }
    if($("#tension_refres").val() == ''){
      swal("Error", "Falta por agregar la Tension del refrescador! :)", "error");
      return false;
    }
    if($("#tension_rebo").val() == ''){
      swal("Error", "Falta por agregar la Tension del Rebobinador! :)", "error");
      return false;
    }
    
  })

  /* agregar el 100% a los colores cuando se cargan los datos de la DB y no se tenia agregado el valor*/
  for (let i = 1; i <= 8; i++) {
      if ($(`#color${i}`).val() != "" && $(`#val_color${i}`).val() == "") {
        $(`#val_color${i}`).val(100)
      } else if($(`#color${i}`).val() == "" && $(`#val_color${i}`).val() != ""){
        $(`#val_color${i}`).val('')
      }
    }
</script>

<?php
mysqli_free_result($usuario);
mysqli_free_result($referencia);
mysqli_free_result($referencia_copia);
mysqli_free_result($mezcla);
mysqli_free_result($caract);
mysqli_free_result($ultimo);
?>