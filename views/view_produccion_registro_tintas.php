<?php
     require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
     require (ROOT_BBDD); 
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
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
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
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
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
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
 
<?php foreach($this->row_referencia_copia as $row_referencia_copia) { $row_referencia_copia; } ?>
<?php foreach($this->row_referencia as $row_referencia) { $row_referencia; } ?>
<?php foreach($this->row_caract as $row_caract) { $row_caract; } ?>
<?php foreach($this->row_caract_m as $row_caract_m) { $row_caract_m; } ?>
<!-- <?php foreach($this->row_mezcla as $row_mezcla) { $row_mezcla; } ?> -->
<?php foreach($this->row_materia_prima as $row_materia_prima) { $row_materia_prima; } ?>
<?php foreach($this->maquinas as $maquinas) { $maquinas; } ?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISADGE AC &amp; CIA</title>
<link rel="stylesheet" type="text/css" href="css/general.css"/>
<link rel="stylesheet" type="text/css" href="css/formato.css"/>
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
<link href="select2/css/select2.min.css" rel="stylesheet"/>
<script src="select2/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/general.css"/>

<!-- css Bootstrap hace mas grande el formato-->
<link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

 
<script type="text/javascript">

</script>
<!--CONFIRMACION AL DARLE CLICK EN SALIR BOTON-->

<script type="text/javascript">
    $(document).ready(function() { $(".busqueda").select2(); });
</script>

</head>
<body>

    <div class="spiffy_content"> <!-- este define el fondo gris de lado a lado si se coloca dentro de tabla inicial solamente coloca borde gris -->
      <div align="center">
        <table style="width: 100%">
          <tr>
           <td align="center">
             <div class="row-fluid">
               <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
                 <div class="panel panel-primary">
                  <div class="panel-heading" align="left" ></div><!--color azul-->
                   <div class="row" >
                     <div class="span12">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/cabecera.jpg"></div>
                     <div class="span12"><h3> PROCESO DE MEZCLAS  &nbsp;&nbsp;&nbsp; </h3></div>
                   </div>
                   <div class="panel-heading" align="left" ></div><!--color azul-->
                      <div id="cabezamenu">
                       <ul id="menuhorizontal">
                        <li id="nombreusuario" ><?php echo $_SESSION['Usuario']; ?></li>
                        <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                        <li><a href="menu.php">MENU PRINCIPAL</a></li>
                      </ul>
                  </div> 
                 <div class="panel-body"> 
                   <div ><!--  SI QUITO  class="container" SE ALINEA A LA IZQUIERDA TODO EL CONTENIDO DE ESTE Y SE REDUCE -->
                    <div class="row">
                      <div class="span12"> 
                 </div>
               </div> 
            <!-- grid --> 

            <div class="container-fluid">  
              <form action="view_index.php?c=cmezclasIm&a=GuardarTintas&id=<?php echo $_GET['cod_ref'];?>" method="post" enctype="multipart/form-data" name="form1" >
                <table class="table table-striped">
                <tr id="tr1">
                  <td colspan="26" id="titulo2">CARACTERISTICAS DE IMPRESION </td>
                </tr>
                <tr>
                  <td colspan="3" rowspan="5" id="dato2"><img src="images/logoacyc.jpg"/></td>
                  <td colspan="26" id="dato3">
                    <a href="manteni.php"><img src="images/opciones.gif" style="cursor:hand;" alt="DISE&Ntilde;O Y DESARROLLO" title="LISTADO MEZCLAS Y CARACTERISTICAS" border="0" /></a>
                    <a href="menu.php"><img src="images/identico.gif" style="cursor:hand;" alt="MENU PRINCIPAL" title="MENU PRINCIPAL" border="0"/></a>
                    <a href="view_index.php?c=cmezclasIm&a=Tintas&cod_ref=<?php echo $_GET['cod_ref'];?>"><img src="images/hoja.gif" alt="VISTA" title="VISTA" border="0"></a>
                  </td>
                </tr>
                <tr id="tr1">
                  <td width="182" colspan="10" nowrap="nowrap" id="fuente1">Fecha Ingreso
                   <b style="color:red;" >
                    <input name="fecha_rkp" type="datetime" min="2000-01-02" value="<?php echo $_GET['fecha']; ?>" size="19" readonly="readonly"> </b>
                  <td colspan="12" id="fuente1"> Ingresado por
                   <b style="color:red;" ><?php echo $row_caract['usuario']; ?></b>
                    <?php //$numero=$row_ultimo['id_cv']+1;  $numero; ?>
                    <!--<input type="hidden" name="id_cv" id="id_cv" value="<?php echo $numero; ?>"/>--></td>
                </tr>
                <tr>
                  <td colspan="8" nowrap="nowrap" id="fuente2">&nbsp;</td>
                  <td colspan="7" nowrap="nowrap" id="fuente2">&nbsp;</td>
                  <td colspan="4" id="fuente2">&nbsp;</td>
                </tr>
                <tr id="tr1">
                  <td colspan="8" nowrap="nowrap" id="fuente2">Referencia</td>
                  <td colspan="7" id="fuente2">Version</td>
                  <td colspan="7" id="dato1">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8" nowrap="nowrap" id="numero2"> 
                      <?php echo $row_referencia['cod_ref']; ?>
                    </td>
                  <td colspan="7" nowrap="nowrap" id="numero2"> 
                      <?php echo $row_referencia['version_ref']; ?>
                    </td>
                  <td colspan="7" id="fuente1">
                     
                </td> 
                </tr>  
                   <!--  INICIA MEZCLAS DE EXTRUDER -->
                      <tr id="tr1">
                        <td colspan="26" id="titulo4">IMPRESION</td>
                        </tr>
                        <tr>
                         <td  colspan="26" id="titulo4"> 
                          IMPRESORA: 
                          <?php echo $row_caract['maquina']; ?> 
                        </td>
                       </tr>
                      <tr>
                        <td rowspan="1"> </td>
                        <td colspan="3" id="fuente1" class="fondoGris">UNIDAD 1</td>
                        <td colspan="3" id="fuente1">UNIDAD 2</td>
                        <td colspan="3" id="fuente1" class="fondoGris">UNIDAD 3</td>
                        <td colspan="3" id="fuente1">UNIDAD 4</td>
                        <td colspan="3" id="fuente1" class="fondoGris">UNIDAD 5</td>
                        <td colspan="3" id="fuente1">UNIDAD 6</td>
                        <td colspan="3" id="fuente1" class="fondoGris">UNIDAD 7</td>
                        <td colspan="3" id="fuente1">UNIDAD 8</td> 
                        </tr> 
                         
                      <tr>
                        <td id="fuente1">COLORES</td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                          <select name="id_i[]" id="id_i[]" style="width:80px">
                          <option value=""<?php if (!(strcmp("",  $row_caract['color1']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                          <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                              <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'],  $row_caract['color1']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                            </option>
                          <?php } ?> 
                        </select>
                      </td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                          <b style="color:red;"> <?php echo  $row_caract['val_color1']; ?></b>
                        </td>
                        <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("",  $row_caract['color2']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'],  $row_caract['color2']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo  $row_caract['val_color2'] ?></b>
                          </td>
                          <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                            <td id="fuente1" class="fondoGris">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['color3']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color3']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1" class="fondoGris">
                             <b style="color:red;" > <?php echo $row_caract['val_color3'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                            <td id="fuente1">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['color4']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color4']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1">
                             <b style="color:red;" > <?php echo $row_caract['val_color4'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0" step="0.01" value=""/></td> 
                            <td id="fuente1" class="fondoGris">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['color5']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color5']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1" class="fondoGris">
                             <b style="color:red;" > <?php echo $row_caract['val_color5'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                            <td id="fuente1">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['color6']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color6']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1">
                             <b style="color:red;" > <?php echo $row_caract['val_color6'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                            <td id="fuente1" class="fondoGris">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['color7']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color7']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1" class="fondoGris">
                             <b style="color:red;" > <?php echo $row_caract['val_color7'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                            <td id="fuente1">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['color8']))) {echo "selected=\"selected\"";} ?>>COLOR</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['color8']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1">
                             <b style="color:red;" > <?php echo $row_caract['val_color8'] ?></b>
                            </td> 
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                      </tr>
                      <tr>
                        <td id="fuente1">MEZCLAS</td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                            <select name="id_i[]" id="id_i[]" style="width:80px">
                            <option value=""<?php if (!(strcmp("",  $row_caract['mezcla1']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                            <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla1']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                              </option>
                            <?php } ?> 
                          </select>
                      </td>
                        <td colspan="1"id="fuente1" class="fondoGris">
                         <b style="color:red;" > <?php echo $row_caract['val_mezcla1'] ?></b>
                        </td> 
                        <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("",$row_caract['mezcla2']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'],$row_caract['mezcla2']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla2'] ?></b>
                          </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['mezcla3']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla3']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1" class="fondoGris">
                             <b style="color:red;" > <?php echo $row_caract['val_mezcla3'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['mezcla4']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla4']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1">
                             <b style="color:red;" > <?php echo $row_caract['val_mezcla4'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['mezcla5']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla5']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1" class="fondoGris">
                             <b style="color:red;" > <?php echo $row_caract['val_mezcla5'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                             <td id="fuente1">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['mezcla6']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla6']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1">
                             <b style="color:red;" > <?php echo $row_caract['val_mezcla6'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                             <td id="fuente1" class="fondoGris">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['mezcla7']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla7']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1" class="fondoGris">
                             <b style="color:red;" > <?php echo $row_caract['val_mezcla7'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                             <td id="fuente1">
                                <select name="id_i[]" id="id_i[]" style="width:80px">
                                <option value=""<?php if (!(strcmp("", $row_caract['mezcla8']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla8']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                  </option>
                                <?php } ?> 
                              </select>
                          </td>
                            <td id="fuente1">
                             <b style="color:red;" > <?php echo $row_caract['val_mezcla8'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                        </tr>
                        
                      </tr>
                      <tr>
                        <td id="fuente1"></td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                            <select name="id_i[]" id="id_i[]" style="width:80px">
                            <option value=""<?php if (!(strcmp("", $row_caract['mezcla9']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                            <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla9']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                              </option>
                            <?php } ?> 
                          </select>
                      </td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                         <b style="color:red;" > <?php echo $row_caract['val_mezcla9'] ?></b>
                        </td>
                        <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla10']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla10']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla10'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla11']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla11']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla11'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla12']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla12']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla12'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla13']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla13']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla13'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla14']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla14']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla14'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla15']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla15']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla15'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla16']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla16']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla16'] ?></b>
                            </td> 
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                        </tr> 
                      </tr>
                      <tr>
                        <td id="fuente1"></td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                            <select name="id_i[]" id="id_i[]" style="width:80px">
                            <option value=""<?php if (!(strcmp("", $row_caract['mezcla17']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                            <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla17']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                              </option>
                            <?php } ?> 
                          </select>
                      </td>
                        <td colspan="1" id="fuente1" class="fondoGris">
                         <b style="color:red;" > <?php echo $row_caract['val_mezcla17'] ?></b>
                        </td>
                        <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                      <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla18']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla18']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla18'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla19']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla19']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla19'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla20']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla20']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla20'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla21']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla21']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla21'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla22']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla22']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla22'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla23']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla23']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla23'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris"><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla24']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla24']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla24'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                      <tr>
                        <td id="fuente1"></td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla25']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['mezcla25']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select> 
                        </td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla25'] ?></b>
                          </td>
                          <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                        <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla26']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla26']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla26'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla27']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla27']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla27'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla28']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla28']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla28'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla29']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla29']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla29'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla30']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla30']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla30'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla31']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla31']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla31'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['mezcla32']))) {echo "selected=\"selected\"";} ?>>MEZCLAS</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['mezcla32']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_mezcla32'] ?></b>
                         </td>
                         <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td>   
                      </tr>
                      <tr>
                        <td id="fuente1">ALCOHOL</td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol1']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol1']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol1'] ?></b>
                          </td>
                          <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                        <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol2']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol2']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol2'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol3']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol3']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol3'] ?></b>
                            </td>
                            <td id="fuente1"  class="fondoGris"><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol4']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol4']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol4'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol5']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol5']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol5'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol6']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol6']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol6'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol7']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol7']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol7'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['alcohol8']))) {echo "selected=\"selected\"";} ?>>ALCOHOL</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['alcohol8']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_alcohol8'] ?></b>
                            </td> 
                          <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td>    
                      </tr>
                      <tr>
                        <td id="fuente1">ACETATO NPA</td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato1']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato1']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                            <b style="color:red;" ><?php echo $row_caract['val_acetato1'] ?></b>
                          </td>
                          <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                        <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato2']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato2']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato2'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td>  
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato3']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato3']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato3'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td>  
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato4']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato4']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato4'] ?></b>
                            </td> 
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato5']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato5']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato5'] ?></b>
                            </td> 
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato6']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato6']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato6'] ?></b>
                            </td> 
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato7']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato7']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato7'] ?></b>
                            </td> 
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['acetato8']))) {echo "selected=\"selected\"";} ?>>ACETATO</option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['acetato8']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_acetato8'] ?></b>
                            </td> 
                           <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td>   
                      </tr>  
                      <tr>
                        <td id="fuente1">METOXIPROPANOL</td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi1']))) {echo "selected=\"selected\"";} ?>></option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi1']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td colspan="1" id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi1'] ?></b>
                          </td>
                          <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                        <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi2']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi2']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi2'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi3']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi3']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi3'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi4']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi4']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi4'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi5']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi5']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi5'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi6']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi6']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi6'] ?></b>
                            </td>
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1" class="fondoGris">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi7']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi7']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1" class="fondoGris">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi7'] ?></b>
                            </td>
                            <td id="fuente1" class="fondoGris" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                          <td id="fuente1">
                              <select name="id_i[]" id="id_i[]" style="width:80px">
                              <option value=""<?php if (!(strcmp("", $row_caract['metoxi8']))) {echo "selected=\"selected\"";} ?>> </option>
                              <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                                  <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_caract['metoxi8']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                                </option>
                              <?php } ?> 
                            </select>
                        </td>
                          <td id="fuente1">
                           <b style="color:red;" > <?php echo $row_caract['val_metoxi8'] ?></b>
                            </td> 
                            <td id="fuente1" ><input class="nameee" name="cant[]" type="number" style="width:50px" placeholder="kilos" min="0"step="0.01" value=""/></td> 
                      </tr>

                      
                <!-- INICIA CARACTERISTICAS -->
                 <tr>
                  <td  colspan="10" id="titulo4"> 
                    
                 </td>
                </tr>
                      
                <tr id="tr1">
                  <td colspan="28" id="fuente2">
                    <div class="panel-footer" > 
                        
                      <input type="hidden" name="op_rp" id="op_rp" value="<?php echo $_GET['id_op']; ?>"/>
                      <input type="hidden" name="int_rollo_rkp" id="int_rollo_rkp" value="<?php echo $_GET['rollo']; ?>"/>
                      <input type="hidden" name="id_proceso_rkp" id="id_proceso_rkp" value="2" /> 
                      <input type="hidden" name="cod_ref" id="cod_ref" value="<?php echo $_GET['cod_ref']; ?>"/> 

                      <input class="botonGeneral" type="submit" name="GuardarTintas" id="GuardarTintas" value="GuardarTintas"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a class="botonFinalizar" style="text-decoration:none; "href="javascript:Salir('view_index.php?c=cmezclasIm&a=Salir')" >SALIR</a>  
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
    refcopia = $( ".refcopia" ).val(); 
    if(refcopia !='')
      vercopiaMezcla();

     extrusoraNumero();

    $( "#extrusora_mp" ).on( "change", function() {
         extrusoraNumero();
    }); 

  });

function vercopiaMezcla(){ 
        
        $('.refcopia').show();  
 
   }

  function copiaMezcla(){
    refcopia = $( "#refcopia" ).val();
    cod_ref = $( "#cod_ref" ).val();  
    if(refcopia)
    window.location="view_index.php?c=cmezclasIm&a=Carat&cod_ref="+cod_ref+"&cod_refcopia="+refcopia;

  }
  
  function Impresora(){
  $( "#extrusora" ).val($( "#extrusora_mp" ).val());
  }



  /*function extrusoraNumero(){
    if($( "#extrusora_mp" ).val() == "Maquina Extrusora 1") { 
       $('.zonaextruder1').show();
       $('.zonaextruder2').hide();
       $('.zonaimpr2').hide(); 

    }else if($( "#extrusora_mp" ).val() == "Maquina Extrusora 2"){  
       $('.zonaextruder1').hide();
       $('.zonaextruder2').show();
       $('.bloquef').text('Bloque Fijo');
       $('.cabezal1').text('Cabezal');
       $('.labios').text('Labios');
       $('.zona1').text('Zona 1');
       $('.zona2').text('Zona 2');
       $('.zona3').text('Zona 3');
       $('.zona4').text('Zona 4'); 
       $('.zonaimpr2').show();


    }
  }*/

</script>

<?php
mysql_free_result($usuario);
mysql_free_result($referencia);
mysql_free_result($referencia_copia); 
mysql_free_result($mezcla);
mysql_free_result($caract); 
mysql_free_result($ultimo);
?>
