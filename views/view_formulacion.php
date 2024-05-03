<?php
     require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
     require (ROOT_BBDD); 
?>
<?php require_once('Connections/conexion1.php'); ?>
<?php

require_once("db/db.php"); 
require_once("Controller/Cformulacion.php");

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

$conexion2 = new oFormulacion(); 
  
$row_mezcla=$this->row_mezcla;
 
 

$insumoactual = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref1_tol1_pm'], " ");
$insumoactual2 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref2_tol1_pm'], " ");
$insumoactual3 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref3_tol1_pm'], " ");
$insumoactual4 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref1_tol2_pm'], " ");
$insumoactual5 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref2_tol2_pm'], " ");
$insumoactual6 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref3_tol2_pm'], " ");
$insumoactual7 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref1_tol3_pm'], " ");
$insumoactual8 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref2_tol3_pm'], " ");
$insumoactual9 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref3_tol3_pm'], " ");
$insumoactual10 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref1_tol4_pm'], " ");
$insumoactual11 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref2_tol4_pm'], " ");
$insumoactual12 = $conexion2->ObtenerColumn("insumo","id_insumo","descripcion_insumo", $row_mezcla['int_ref3_tol4_pm'], " ");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISADGE AC &amp; CIA</title>
<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/formato.js"></script>
<script type="text/javascript" src="AjaxControllers/js/elimina.js"></script>
<script type="text/javascript" src="AjaxControllers/js/updates.js"></script>

<!-- desde aqui para listados nuevos -->
<link rel="stylesheet" type="text/css" href="css/desplegable.css" />
<link rel="stylesheet" type="text/css" href="css/general.css"/>

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

<!-- css Bootstrap-->
<link rel="stylesheet" href="bootstrap-4/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 

</head>
<body>
<?php echo $conexion->header('listas'); ?>
 
  <table border="0" class="table table-bordered table-sm">
    
  <tr>
    <td id="dato2">
      <form method="post" name="form1" action="view_index.php?c=cformulacion&a=Guardar">
        <table>
          <tr>
            <td id="fuente2">CODIGO</td>
            <td id="fuente2">FORMULACION </td>
            <?php if(in_array($_SESSION['id_usuario'], $_SESSION['usuariosarray'] )): ?>
              <td id="fuente2">DELETE</td>
            <?php endif; ?>
          </tr>
          <?php foreach($this->modelos as $modelos) { ?>
            <tr >
              <td id="detalle1"><a href="view_index.php?c=cformulacion&a=llenarEditar&id_for=<?php echo $modelos['id_for']; ?>&proceso=1&material=1" target="_top" style="text-decoration:none; color:#000000"><?php echo $modelos['nombre']; ?></a></td>
              <td id="detalle1"><a href="view_index.php?c=cformulacion&a=llenarEditar&id_for=<?php echo $modelos['id_for']; ?>&proceso=1&material=1" target="_top" style="text-decoration:none; color:#000000" ><?php echo $modelos['formulacion']; ?></a></td>
              
              <?php if(in_array($_SESSION['id_usuario'], $_SESSION['usuariosarray'] )): ?>
               <td id="detalle2"> 
                <!-- <a class="botonDel" id="btnDelItems" onclick='eliminar("<?php echo $modelos['id_for']; ?>","id_for","0","view_index.php?c=cformulacion&a=Eliminar","0" )' type="button">DELETE</a> -->
               <a href='javascript:eliminar("<?php echo $modelos['id_for']; ?>","id_for","0","view_index.php?c=cformulacion&a=Eliminar","0" )'><img src="images/por.gif" alt="ELIMINAR" border="0" style="cursor:hand;" /></a> 
              </td>
              <?php endif; ?>
            </tr>
            <?php } ?>
          <tr>
            <td id="dato2">
              <input name="nombre" type="text" id="nombre" class="mayuscula" value="" maxlength="7" size="5" onchange="agregarMezcla();" />
            </td>
            <td colspan="2" id="dato2">
              <input name="formulacion" type="text" id="formulacion" value="" size="30" />
            <input type="hidden" name="proceso" value="1">
            <input type="hidden" name="material" value="1">
           </td>
            </tr>
          <tr>
            <td colspan="3" id="dato2"><!-- <input type="submit" onclick="validaSelectMezclas()" value="ADICIONAR FORMULACION"> --></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
      <!-- </form> -->
    </td>
    




   <td>
    <!--  INICIA MEZCLAS DE EXTRUDER -->
    <!-- <form action="view_index.php?c=cmezclas&a=Guardar&id=<?php echo $_GET['cod_ref'];?>&vistaLiquida=<?php echo $_GET['vistaLiquida'];?>" method="post" enctype="multipart/form-data" name="form3"> -->
      <table class="table table-bordered table-sm">   
            <tr id="tr1">
              <td colspan="7" id="titulo4">FORMULA EXTRUSION</td>
              </tr>
              <tr>
               <td colspan="4" id="numero1"><em> Nota: Si no aparece el insumo es porque no esta como clase Insumo Extruder</em></td>
               <td colspan="3" id="titulo1"> 
                Extrusoras : 
                <select name="extrusora_mp" id="extrusora_mp" class="busqueda selectsMedio" required="required" onchange="Extrusora();">
                    <option value="">Seleccione</option>
                       <?php  foreach($this->maquinas as $maquinas ) { ?>
                    <option value="<?php echo $maquinas['nombre_maquina']; ?>"<?php if (!(strcmp($row_mezcla['extrusora_mp'] , $maquinas['nombre_maquina']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($maquinas['nombre_maquina']); ?> 
                  </option>
                <?php } ?>
                </select>  
              </td>
             </tr>
            <tr id="tr1">
              <td rowspan="2" id="fuente1">EXT-1          
              </td>
              <td colspan="2" id="fuente1">TORNILLO A</td>
              <td colspan="2" id="fuente1">TORNILLO B</td>
              <td colspan="2" id="fuente1">TORNILLO C</td>
              </tr> 
            <tr id="tr1">
              <td id="fuente1">Referencia</td>
              <td id="fuente1">%</td>
              <td id="fuente1">Referencia</td>
              <td id="fuente1">%</td>
              <td id="fuente1">Referencia</td>
              <td id="fuente1">%</td>
            </tr>
            
            <tr id="tr1">
              <td id="fuente1">Tolva A</td>
              <td  id="fuente1">
                <select name="int_ref1_tol1_pm" id="int_ref1_tol1_pm" style="width:80px">
                <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref1_tol1_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                    <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref1_tol1_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                  </option>
                <?php } ?> 
              </select> <span style="width: 10px" title='<?php echo $insumoactual['descripcion_insumo']; ?>' ><?php echo substr($insumoactual['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1"><input name="int_ref1_tol1_porc1_pm"  type="text" required="required" id="int_ref1_tol1_porc1_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref1_tol1_porc1_pm']; ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref2_tol1_pm" id="int_ref2_tol1_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref2_tol1_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref2_tol1_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual2['descripcion_insumo']; ?>' ><?php echo substr($insumoactual2['descripcion_insumo'], 0, 10);?>... </span> 
            </td>
              <td id="fuente1">
                <input name="int_ref2_tol1_porc2_pm"  type="text" required="required" id="int_ref2_tol1_porc2_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref2_tol1_porc2_pm'] ?>"/>
              </td>
              <td id="fuente1"> 
                  <select name="int_ref3_tol1_pm" id="int_ref3_tol1_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref3_tol1_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref3_tol1_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual3['descripcion_insumo']; ?>' ><?php echo substr($insumoactual3['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref3_tol1_porc3_pm"  type="text" required="required" id="int_ref3_tol1_porc3_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref3_tol1_porc3_pm'] ?>"/>
              </td>
            </tr>
            <tr>
              <td id="fuente1">Tolva B</td>
              <td id="fuente1">
                  <select name="int_ref1_tol2_pm" id="int_ref1_tol2_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref1_tol2_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref1_tol2_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual4['descripcion_insumo']; ?>' ><?php echo substr($insumoactual4['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref1_tol2_porc1_pm"  type="text" required="required" id="int_ref1_tol2_porc1_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref1_tol2_porc1_pm'] ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref2_tol2_pm" id="int_ref2_tol2_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref2_tol2_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref2_tol2_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual5['descripcion_insumo']; ?>' ><?php echo substr($insumoactual5['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref2_tol2_porc2_pm"  type="text" required="required" id="int_ref2_tol2_porc2_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref2_tol2_porc2_pm'] ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref3_tol2_pm" id="int_ref3_tol2_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref3_tol2_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref3_tol2_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual6['descripcion_insumo']; ?>' ><?php echo substr($insumoactual6['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref3_tol2_porc3_pm"  type="text" required="required" id="int_ref3_tol2_porc3_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref3_tol2_porc3_pm'] ?>"/>
              </td>
            </tr>
            <tr id="tr1">
              <td id="fuente1">Tolva C</td>
              <td id="fuente1">
                  <select name="int_ref1_tol3_pm" id="int_ref1_tol3_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref1_tol3_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref1_tol3_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual7['descripcion_insumo']; ?>' ><?php echo substr($insumoactual7['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref1_tol3_porc1_pm"  type="text" required="required" id="int_ref1_tol3_porc1_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref1_tol3_porc1_pm'] ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref2_tol3_pm" id="int_ref2_tol3_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref2_tol3_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref2_tol3_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual8['descripcion_insumo']; ?>' ><?php echo substr($insumoactual8['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1"><input name="int_ref2_tol3_porc2_pm"  type="text" required="required" id="int_ref2_tol3_porc2_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref2_tol3_porc2_pm'] ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref3_tol3_pm" id="int_ref3_tol3_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref3_tol3_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref3_tol3_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual9['descripcion_insumo']; ?>' ><?php echo substr($insumoactual9['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref3_tol3_porc3_pm"  type="text" required="required" id="int_ref3_tol3_porc3_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref3_tol3_porc3_pm'] ?>"/>
              </td>
            </tr>
            <tr>
              <td id="fuente1">Tolva D</td>
              <td id="fuente1">
                  <select name="int_ref1_tol4_pm" id="int_ref1_tol4_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref1_tol4_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref1_tol4_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual10['descripcion_insumo']; ?>' ><?php echo substr($insumoactual10['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref1_tol4_porc1_pm"  type="text" required="required" id="int_ref1_tol4_porc1_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref1_tol4_porc1_pm'] ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref2_tol4_pm" id="int_ref2_tol4_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref2_tol4_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref2_tol4_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual11['descripcion_insumo']; ?>' ><?php echo substr($insumoactual11['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td id="fuente1">
                <input name="int_ref2_tol4_porc2_pm"  type="text" required="required" id="int_ref2_tol4_porc2_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref2_tol4_porc2_pm'] ?>"/>
              </td>
              <td id="fuente1">
                  <select name="int_ref3_tol4_pm" id="int_ref3_tol4_pm" style="width:80px">
                  <option value=""<?php if (!(strcmp("", $row_mezcla['int_ref3_tol4_pm']))) {echo "selected=\"selected\"";} ?>>Referencia MP</option>
                  <?php  foreach($this->row_materia_prima as $row_materia_prima ) { ?>
                      <option value="<?php echo $row_materia_prima['id_insumo']; ?>"<?php if (!(strcmp($row_materia_prima['id_insumo'], $row_mezcla['int_ref3_tol4_pm']))) {echo "selected=\"selected\"";} ?>><?php echo htmlentities($row_materia_prima['descripcion_insumo']); ?> 
                    </option>
                  <?php } ?> 
                </select> <span style="width: 10px" title='<?php echo $insumoactual12['descripcion_insumo']; ?>' ><?php echo substr($insumoactual12['descripcion_insumo'], 0, 10);?>... </span>
            </td>
              <td  id="fuente1">
                <input name="int_ref3_tol4_porc3_pm"  type="text" required="required" id="int_ref3_tol4_porc3_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref3_tol4_porc3_pm'] ?>"/></td>
            </tr>
            <tr id="tr1">
              <td id="fuente1">RPM - %</td>
              <td  id="fuente1"><input name="int_ref1_rpm_pm"  type="text" placeholder="Rpm Torn-A" required="required" size="10"value="<?php echo $row_mezcla['int_ref1_rpm_pm'] ?>"/></td>
              <td id="fuente1"><input name="int_ref1_tol5_porc1_pm"  type="text" required="required" id="int_ref1_tol5_porc1_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref1_tol5_porc1_pm'] ?>"/></td>
              <td id="fuente1"><input name="int_ref2_rpm_pm"  type="text" placeholder="Rpm Torn-B" required="required" size="10"value="<?php echo $row_mezcla['int_ref2_rpm_pm'] ?>"/></td>
              <td id="fuente1"><input name="int_ref2_tol5_porc2_pm"  type="text" required="required" id="int_ref2_tol5_porc2_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref2_tol5_porc2_pm'] ?>"/></td>
              <td id="fuente1"><input name="int_ref3_rpm_pm"  type="text" placeholder="Rpm Torn-C" required="required" size="10"value="<?php echo $row_mezcla['int_ref3_rpm_pm'] ?>"/></td>
              <td id="fuente1"><input name="int_ref3_tol5_porc3_pm"  type="text" required="required" id="int_ref3_tol5_porc3_pm" placeholder="%" size="3"value="<?php echo $row_mezcla['int_ref3_tol5_porc3_pm'] ?>"/></td>
            </tr>
            <tr>
              <td colspan="10" id="fuente1">
                <textarea name="observ_pm" id="observ_pm" style="width:100%;" cols="100" rows="2" placeholder="OBSERVACIONES"><?php echo $row_mezcla['observ_pm']; ?></textarea>
              </td>
            </tr>
            <tr>
              <td>

              <input type="hidden" name="int_cod_ref_pm" id="int_cod_ref_pm" value="<?php echo $this->modelos_editar['nombre']; ?>">
              <input type="hidden" name="id_ref_pm" id="id_ref_pm" value=""/> 
               
              <input type="hidden" name="fecha_registro_pm" id="fecha_registro_pm" value="<?php echo date('Y-m-d') ?>"/>  
              <input type="hidden" name="str_registro_pm" id="str_registro_pm" value="<?php echo $_SESSION['Usuario'] ?>" />
              <input type="hidden" name="id_proceso" id="id_proceso" value="1"/>
              <input type="hidden" name="b_borrado_pm" id="b_borrado_pm" value="0"/>
 
              <input class="botonGeneral"type="submit" onclick="validaSelectMezclas()" name="GUARDAR" id="btnEnviar" value="GUARDAR Y EDITAR" /> 
            </td></tr> 
          </table>
        </form>
       </td>
      <!-- FIN MEZCLAS -->

      <td id="dato2"> 
        <?php if($this->modelos_editar['id_for']!='') { ?>
        <form method="post" name="form2" action="view_index.php?c=cformulacion&a=Editar">
          <table align="center">
            <tr>
              <td id="fuente2">CODIGO EDIT</td>
              <td id="fuente2">EDITAR FORMULACION EDIT</td>
            </tr>
            <tr>
              <td id="fuente2"><input name="nombre" type="text" id="nombre" class="mayuscula" maxlength="7" value="<?php echo $this->modelos_editar['nombre']; ?>" size="5" onchange="agregarMezcla();"/></td>
              <td id="fuente2"><input name="formulacion" type="text" id="formulacion" value="<?php echo $this->modelos_editar['formulacion']; ?>" size="30"></td>
            </tr>
            <tr>
              <td colspan="2" id="dato2">
                <!-- <a href='javascript:UpdateGenerals("<?php echo $this->modelos_editar['id_for']; ?>","id_for","view_index.php?c=cformulacion&a=llenarEditar","MM_update" )'><img src="images/por.gif" alt="ELIMINAR" border="0" style="cursor:hand;"/></a>  -->

                 <input name="submit" type="submit" value="ACTUALIZAR FORMULACION" /> <!-- onclick='javascript:UpdateGenerals("<?php echo $this->modelos_editar['id_for']; ?>","id_for","view_index.php?c=cformulacion&a=llenarEditar","")' -->
               </td> 
              </tr>
          </table>
          <input type="hidden" name="id_for" value="<?php echo $this->modelos_editar['id_for']; ?>">
          <input type="hidden" name="proceso" value="1">
          <input type="hidden" name="material" value="1">
          <input type="hidden" name="MM_update" value="form2">
        </form>
        <?php } ?>
      </td>

</table>
  </td>
</tr>
</table>
 
<?php echo $conexion->header('footer'); ?>
</body>
</html>
<script>

   
 

  $( "#btnEnviar" ).on( "click", function() {
       
      if($("#nombre").val()=='' && $("#formulacion").val()=='' && $("#int_cod_ref_pm").val()==''){
        event.preventDefault();
        swal('Codigo y formulacion deben estar llenos!')

      }
     
  } ); 

  
  $( ".mayuscula" ).on( "keyup", function() {
    $(this).val($(this).val().toUpperCase()); 
  } );
 
  function agregarMezcla(){
       $("#int_cod_ref_pm").val($("#nombre").val()) 
       $("#id_ref_pm").val($("#nombre").val()) 
  }
 
 





 function validaSelectMezclas(){

  
   //si son vacios coloco 0.00
   if($("#int_ref1_tol1_porc1_pm").val()=='' ){ $("#int_ref1_tol1_porc1_pm").val('0.00') } 
   if($("#int_ref1_tol2_porc1_pm").val()=='' ){ $("#int_ref1_tol2_porc1_pm").val('0.00') } 
   if($("#int_ref1_tol3_porc1_pm").val()=='' ){ $("#int_ref1_tol3_porc1_pm").val('0.00') } 
   if($("#int_ref1_tol4_porc1_pm").val()=='' ){ $("#int_ref1_tol4_porc1_pm").val('0.00') } 

   if($("#int_ref2_tol1_porc2_pm").val()=='' ){ $("#int_ref2_tol1_porc2_pm").val('0.00') } 
   if($("#int_ref2_tol2_porc2_pm").val()=='' ){ $("#int_ref2_tol2_porc2_pm").val('0.00') } 
   if($("#int_ref2_tol3_porc2_pm").val()=='' ){ $("#int_ref2_tol3_porc2_pm").val('0.00') } 
   if($("#int_ref2_tol4_porc2_pm").val()=='' ){ $("#int_ref2_tol4_porc2_pm").val('0.00') } 

   if($("#int_ref3_tol1_porc3_pm").val()=='' ){ $("#int_ref3_tol1_porc3_pm").val('0.00') } 
   if($("#int_ref3_tol2_porc3_pm").val()=='' ){ $("#int_ref3_tol2_porc3_pm").val('0.00') } 
   if($("#int_ref3_tol3_porc3_pm").val()=='' ){ $("#int_ref3_tol3_porc3_pm").val('0.00') } 
   if($("#int_ref3_tol4_porc3_pm").val()=='' ){ $("#int_ref3_tol4_porc3_pm").val('0.00') } 

      //valida select
       if( ($("#int_ref1_tol1_porc1_pm").val() > '0.00')  &&  $("#int_ref1_tol1_pm").val()==''){
            swal("Debe ingresar el insumo Tolva A TORNILLO A")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol1_porc2_pm").val() > '0.00')  &&  $("#int_ref2_tol1_pm").val()==''){
            swal("Debe ingresar el insumo Tolva A TORNILLO B")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol1_porc3_pm").val() > '0.00')  &&  $("#int_ref3_tol1_pm").val()==''){
            swal("Debe ingresar el insumo Tolva A TORNILLO C")
            event.preventDefault();
       }
       if( ($("#int_ref1_tol2_porc1_pm").val() > '0.00')  &&  $("#int_ref1_tol2_pm").val()==''){
            swal("Debe ingresar el insumo Tolva B TORNILLO A")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol2_porc2_pm").val() > '0.00')  &&  $("#int_ref2_tol2_pm").val()==''){
            swal("Debe ingresar el insumo Tolva B TORNILLO B")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol2_porc3_pm").val() > '0.00')  &&  $("#int_ref3_tol2_pm").val()==''){
            swal("Debe ingresar el insumo Tolva B TORNILLO C")
            event.preventDefault();
       }
       if( ($("#int_ref1_tol3_porc1_pm").val() > '0.00')  &&  $("#int_ref1_tol3_pm").val()==''){
            swal("Debe ingresar el insumo Tolva C TORNILLO A")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol3_porc2_pm").val() > '0.00')  &&  $("#int_ref2_tol3_pm").val()==''){
            swal("Debe ingresar el insumo Tolva C TORNILLO B")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol3_porc3_pm").val() > '0.00')  &&  $("#int_ref3_tol3_pm").val()==''){
            swal("Debe ingresar el insumo Tolva C TORNILLO C")
            event.preventDefault();
       }
       if( ( $("#int_ref1_tol4_porc1_pm").val() > '0.00')  &&  $("#int_ref1_tol4_pm").val()==''){
            swal("Debe ingresar el insumo Tolva D TORNILLO A")
            event.preventDefault();
       }
       if( ( $("#int_ref2_tol4_porc2_pm").val() > '0.00')  &&  $("#int_ref2_tol4_pm").val()==''){
            swal("Debe ingresar el insumo Tolva D TORNILLO B")
            event.preventDefault();
       }
       if( ( $("#int_ref2_tol4_porc2_pm").val() > '0.00')  &&  $("#int_ref3_tol4_pm").val()==''){
            swal("Debe ingresar el insumo Tolva D TORNILLO C")
            event.preventDefault();
       } 

     //valida campo %
       if( ($("#int_ref1_tol1_porc1_pm").val() == '0.00' || $("#int_ref1_tol1_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol1_pm").val()!='')){
            swal("Debe ingresar el valor Tolva A TORNILLO A %")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol1_porc2_pm").val() == '0.00' || $("#int_ref2_tol1_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol1_pm").val()!='')){
            swal("Debe ingresar el valor Tolva A TORNILLO B %")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol1_porc3_pm").val() == '0.00' || $("#int_ref3_tol1_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol1_pm").val()!='')){
            swal("Debe ingresar el valor Tolva A TORNILLO C %")
            event.preventDefault();
       }
       if( ($("#int_ref1_tol2_porc1_pm").val() == '0.00' || $("#int_ref1_tol2_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol2_pm").val()!='')){
            swal("Debe ingresar el valor Tolva B TORNILLO A %")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol2_porc2_pm").val() == '0.00' || $("#int_ref2_tol2_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol2_pm").val()!='')){
            swal("Debe ingresar el valor Tolva B TORNILLO B %")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol2_porc3_pm").val() == '0.00' || $("#int_ref3_tol2_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol2_pm").val()!='')){
            swal("Debe ingresar el valor Tolva B TORNILLO C %")
            event.preventDefault();
       }
       if( ($("#int_ref1_tol3_porc1_pm").val() == '0.00' || $("#int_ref1_tol3_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol3_pm").val()!='')){
            swal("Debe ingresar el valor Tolva C TORNILLO A %")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol3_porc2_pm").val() == '0.00' || $("#int_ref2_tol3_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol3_pm").val()!='')){
            swal("Debe ingresar el valor Tolva C TORNILLO B %")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol3_porc3_pm").val() == '0.00' || $("#int_ref3_tol3_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol3_pm").val()!='')){
            swal("Debe ingresar el valor Tolva C TORNILLO C %")
            event.preventDefault();
       }
       if( ($("#int_ref1_tol4_porc1_pm").val() == '0.00' || $("#int_ref1_tol4_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol4_pm").val()!='')){
            swal("Debe ingresar el valor Tolva D TORNILLO A %")
            event.preventDefault();
       }
       if( ($("#int_ref2_tol4_porc2_pm").val() == '0.00' || $("#int_ref2_tol4_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol4_pm").val()!='')){
            swal("Debe ingresar el valor Tolva D TORNILLO B %")
            event.preventDefault();
       }
       if( ($("#int_ref3_tol4_porc3_pm").val() == '0.00' || $("#int_ref3_tol4_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol4_pm").val()!='')){
            swal("Debe ingresar el valor Tolva D TORNILLO C %")
            event.preventDefault();
       }

      

 
       
       //valido que no sea inferior o superio a 100 %
     if($("#int_ref1_tol1_porc1_pm").val() >'0.00' || $("#int_ref1_tol2_porc1_pm").val() >'0.00' || $("#int_ref1_tol3_porc1_pm").val()>'0.00' ||$("#int_ref1_tol4_porc1_pm").val()>'0.00'){
           if(  (parseFloat($("#int_ref1_tol1_porc1_pm").val() ) + parseFloat($("#int_ref1_tol2_porc1_pm").val() ) + parseFloat($("#int_ref1_tol3_porc1_pm").val() ) + parseFloat($("#int_ref1_tol4_porc1_pm").val()) ) !=100 ){
                swal("Los % del Tornillo A no pueden superar o ser inferior a el 100% !")
                event.preventDefault();
           }
     }
     if($("#int_ref2_tol1_porc2_pm").val() >'0.00' || $("#int_ref2_tol2_porc2_pm").val() >'0.00' || $("#int_ref2_tol3_porc2_pm").val()>'0.00' ||$("#int_ref2_tol4_porc2_pm").val()>'0.00'){
           if(  (parseFloat($("#int_ref2_tol1_porc2_pm").val() ) + parseFloat($("#int_ref2_tol2_porc2_pm").val() ) + parseFloat($("#int_ref2_tol3_porc2_pm").val() ) + parseFloat($("#int_ref2_tol4_porc2_pm").val()) ) !=100 ){
                swal("Los % del Tornillo B no pueden superar o ser inferior a el 100% !")
                event.preventDefault();
           }
     }
     if($("#int_ref3_tol1_porc3_pm").val() >'0.00' || $("#int_ref3_tol2_porc3_pm").val() >'0.00' || $("#int_ref3_tol3_porc3_pm").val()>'0.00' ||$("#int_ref3_tol4_porc3_pm").val()>'0.00'){
           if(  (parseFloat($("#int_ref3_tol1_porc3_pm").val() ) + parseFloat($("#int_ref3_tol2_porc3_pm").val() ) + parseFloat($("#int_ref3_tol3_porc3_pm").val() ) + parseFloat($("#int_ref3_tol4_porc3_pm").val()) ) !=100 ){
                swal("Los % del Tornillo C no pueden superar o ser inferior a el 100% !")
                event.preventDefault();
           }
     }

       //valida los dos en cero y vacios
         if( ($("#int_ref1_tol1_porc1_pm").val() == '0.00' || $("#int_ref1_tol1_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol1_pm").val()=='')){
              
              event.currentTarget.submit();
         }
         if( ($("#int_ref2_tol1_porc2_pm").val() == '0.00' || $("#int_ref2_tol1_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol1_pm").val()=='')){
              
              event.currentTarget.submit();
         }
         if( ($("#int_ref3_tol1_porc3_pm").val() == '0.00' || $("#int_ref3_tol1_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol1_pm").val()=='')){
             
              event.currentTarget.submit();
         }
         if( ($("#int_ref1_tol2_porc1_pm").val() == '0.00' || $("#int_ref1_tol2_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol2_pm").val()=='')){
               
              event.currentTarget.submit();
         }
         if( ($("#int_ref2_tol2_porc2_pm").val() == '0.00' || $("#int_ref2_tol2_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol2_pm").val()=='')){
               
              event.currentTarget.submit();
         }
         if( ($("#int_ref3_tol2_porc3_pm").val() == '0.00' || $("#int_ref3_tol2_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol2_pm").val()=='')){
              
              event.currentTarget.submit();
         }
         if( ($("#int_ref1_tol3_porc1_pm").val() == '0.00' || $("#int_ref1_tol3_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol3_pm").val()=='')){
         
              event.currentTarget.submit();
         }
         if( ($("#int_ref2_tol3_porc2_pm").val() == '0.00' || $("#int_ref2_tol3_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol3_pm").val()=='')){
             
              event.currentTarget.submit();
         }
         if( ($("#int_ref3_tol3_porc3_pm").val() == '0.00' || $("#int_ref3_tol3_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol3_pm").val()=='')){
              
              event.currentTarget.submit();
         }
         if( ($("#int_ref1_tol4_porc1_pm").val() == '0.00' || $("#int_ref1_tol4_porc1_pm").val() == '0')  &&  ($("#int_ref1_tol4_pm").val()=='')){
              
              event.currentTarget.submit();
         }
         if( ($("#int_ref2_tol4_porc2_pm").val() == '0.00' || $("#int_ref2_tol4_porc2_pm").val() == '0')  &&  ($("#int_ref2_tol4_pm").val()=='')){
             
              event.currentTarget.submit();
         }
         if( ($("#int_ref3_tol4_porc3_pm").val() == '0.00' || $("#int_ref3_tol4_porc3_pm").val() == '0')  &&  ($("#int_ref3_tol4_pm").val()=='')){
            
              event.currentTarget.submit();
         } 

       event.currentTarget.submit();
 }
       

 function extrusoraNumero(){

   if($("#extrusora_mp" ).val() == "1 Maquina Extrusora") { 
      $('.zonaextruder1').show();
      $('.zonaextruder2').hide();
      $('.zonaimpr2').hide(); 

   }else if($("#extrusora_mp" ).val() == "2 Maquina Extrusora"){  
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
 }
   
</script>
