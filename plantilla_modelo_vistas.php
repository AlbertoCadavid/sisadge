<?php
   require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
   require (ROOT_BBDD); 
?> 
<?php require_once('Connections/conexion1.php'); ?>
<?php
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
 
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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

<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    break;    
    case "long":
    case "int":
    $theValue = ($theValue != "") ? intval($theValue) : "NULL";
    break;
    case "double":
    $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
    break;
    case "date":
    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    break;
    case "defined":
    $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
    break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//////////////////////////////////////////////////////////////////////////////
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


  $insertSQL = sprintf("INSERT INTO usuario_carpetas (id, descripcion) VALUES (%s, %s)",
   GetSQLValueString($_POST['id'], "int"), 
   GetSQLValueString($_POST['descripcion'], "text"));

  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());



  $insertGoTo = "insumos_interno_entrada_salida.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$conexion = new ApptivaDB();

$maxRows_registros = 5;
$pageNum_registros = 0;
if (isset($_GET['pageNum_registros'])) {
  $pageNum_registros = $_GET['pageNum_registros'];
}
$startRow_registros = $pageNum_registros * $maxRows_registros;


$colname_usuario = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
 
$row_usuario = $conexion->buscar('usuario','usuario',$colname_usuario); 

mysql_select_db($database_conexion1, $conexion1);
$query_proveedores = "SELECT * FROM proveedor ORDER BY proveedor_p ASC";
$proveedores = mysql_query($query_proveedores, $conexion1) or die(mysql_error());
$row_proveedores = mysql_fetch_assoc($proveedores);
$totalRows_proveedores = mysql_num_rows($proveedores);

mysql_select_db($database_conexion1, $conexion1);
$query_insumos = "SELECT * FROM insumo ORDER BY descripcion_insumo ASC";
$insumos = mysql_query($query_insumos, $conexion1) or die(mysql_error());
$row_insumos = mysql_fetch_assoc($insumos);
$totalRows_insumos = mysql_num_rows($insumos);

mysql_select_db($database_conexion1, $conexion1);
$query_ver_nuevo = "SELECT * FROM usuario_carpetas ORDER BY id DESC";
$ver_nuevo = mysql_query($query_ver_nuevo, $conexion1) or die(mysql_error());
$row_ver_nuevo = mysql_fetch_assoc($ver_nuevo);
$totalRows_ver_nuevo = mysql_num_rows($ver_nuevo);

mysql_select_db($database_conexion1, $conexion1);
$query_registros = "SELECT * FROM usuario_carpetas ORDER BY id DESC";
$query_limit_registros = sprintf("%s LIMIT %d, %d", $query_registros, $startRow_registros, $maxRows_registros);
//$carpeta = mysql_query($query_registros, $conexion1) or die(mysql_error());
$registros = mysql_query($query_limit_registros, $conexion1)  or die(mysql_error());
$row_registros = mysql_fetch_assoc($registros);
$totalRows_registros = mysql_num_rows($registros);

if (isset($_GET['totalRows_registros'])) {
  $totalRows_registros = $_GET['totalRows_registros'];
} else {
  $all_registros = mysql_query($query_registros) or die(mysql_error());
  $totalRows_registros = mysql_num_rows($all_registros);
}
$totalPages_registros = ceil($totalRows_registros/$maxRows_registros)-1;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>SISADGE AC &amp; CIA</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="css/general.css"/>
  <link rel="stylesheet" type="text/css" href="css/formato.css"/>
  <link rel="stylesheet" type="text/css" href="css/desplegable.css" />
  <script type="text/javascript" src="js/usuario.js"></script>
  <script type="text/javascript" src="js/formato.js"></script>
  <!-- sweetalert -->
  <script src="librerias/sweetalert/dist/sweetalert.min.js"></script> 
  <link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script> 

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
                 <div class="panel-heading"><h2>INSUMOS INTERNO ENTRADA-SALIDA</h2></div>
                 <div id="cabezamenu">
                  <ul id="menuhorizontal">
                   <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                   <li><a href="menu.php">MENU PRINCIPAL</a></li> 
                   <li><a href="/acycia/insumos.php/">VER INSUMOS</a></li>
                   <li><a href="/acycia/insumos_interno_listado.php">LISTADO ENTRADAS</a></li>
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
                         REMISION SALIDA - ENTRADA 
                       </td>
                     </tr>
                     <tr>
                      <td id="numero2">
                       <h5 id="numero2" >N° <input name="id" readonly="readonly" type="text" value="<?php $num=$row_ver_nuevo['id']+1; echo $num; ?>" style="width:80px"> </h5>
                     </td>

                   </tr>
                 </table> 
               </div>
             </div>
             <br>


             <form action="<?php echo $logoutAction ?>" method="post" name="form1" onSubmit="MM_validateForm('fecha','','R','telefono','','R','direccion','','R' );return document.MM_returnValue">
               <table id="tabla1">
                 <tr>
                  <td > 
                    <div class="row">
                      <div class="span12">
                        <strong >CLIENTE:</strong>
                        <select name="proveedores" id="proveedores" class="selects">
                         <option value="">Seleccione Cliente</option>
                         <?php do {  ?>
                           <option value="<?php echo $row_proveedores['proveedor_p']?>"><?php echo $row_proveedores['proveedor_p']?></option>
                         <?php } while ($row_proveedores = mysql_fetch_assoc($proveedores));
                         $rows = mysql_num_rows($proveedores);
                         if($rows > 0) {
                          mysql_data_seek($proveedores, 0);
                          $row_proveedores = mysql_fetch_assoc($proveedores);
                        }
                        ?>
                      </select>
                    </div> 
                  </div>
                  <br>
                  <div class="row">
                    <div class="span6">
                      <strong >FECHA:</strong>
                      <input type="date" required="required"  name="fecha" value="<?php echo $row_proveedores['fecha_p']; ?>" class='campostext' >
                    </div>
                    <div class="span6">
                      <strong >TELEFONO:</strong>
                      <input type="text" required="required" placeholder="Telefono" name="telefono" value="<?php echo $row_proveedores['telefono_p']; ?>"  class='campostext' onBlur="conMayusculas(this)">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="span12">
                      <strong >DIRECCION COMERCIAL:</strong>
                      <input type="text" required="required" placeholder="Direccion" name="direccion" value="<?php echo $row_proveedores['direccion_p']; ?>" class='campostextGrandes'   onBlur="conMayusculas(this)" >
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="span12">
                      <strong >OBSERVACIONES:</strong>
                      <textarea class="observaciones" name="observacion_oc" cols="50" rows="3"><?php echo $row_proveedores['observacion_p']; ?></textarea>
                    </div>  
                  </div>

                  <br>
                     
                </td>
              </tr>
        
              <tr>
                  <td colspan="5" id="dato1">
                    <hr>
                    <select name="id_insumo_det" class="selectsMin" onChange="DatosGestiones('3','id_insumo',form1.id_insumo_det.value);">
                    <option value="">SELECCIONE</option>
                    <?php
                    do {  
                      ?>
                      <option value="<?php echo $row_insumos['id_insumo']?>"><?php echo $row_insumos['descripcion_insumo']?></option>
                      <?php
                    } while ($row_insumos = mysql_fetch_assoc($insumos));
                    $rows = mysql_num_rows($insumos);
                    if($rows > 0) {
                      mysql_data_seek($insumos, 0);
                      $row_insumos = mysql_fetch_assoc($insumos);
                    }
                    ?>
                  </select>
                  <hr>
                </td>
                <td id="dato3">
                  <button type="button" class="botonMini" autofocus="">ADD INSUMO</button> 
                </td>
              </tr>
            </table>
            <div class="panel-footer">
              <button type="submit" class="botonGeneral" autofocus="">GUARDAR REMISION</button> 
            </div>
            <input type="hidden" name="MM_insert" value="form1">
          </form>



          <br>
          <!-- grid -->
          <h3 id="dato2">Registros Ingresados</h3>
          <hr>
          <div class="container">
            <div class="row align-items-start">
              <div class="col gridEncabezado" >
               <strong> Descripcion</strong>
              </div> 
               <?php do { ?>
              <div class="col-12 grid" ><b> - </b>
                <a href="insumos_interno_entrada_salida_editar.php?id=<?php echo $row_registros['id']; ?>" target="_top" style="text-decoration:none; color:#000000"> <?php echo $row_registros['descripcion']; ?></a>
              </div> 
                 <?php } while ($row_registros = mysql_fetch_assoc($registros)); ?>
            </div>
          </div>
 
             <!-- tabla para paginacion opcional -->
             <table border="0" width="50%" align="center">
               <tr>
                 <td width="23%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page ?>
                   <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, 0, $queryString_registros); ?>">Primero</a>
                 <?php } // Show if not first page ?>
               </td>
               <td width="31%" id="dato2"><?php if ($pageNum_registros > 0) { // Show if not first page ?>
                 <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, max(0, $pageNum_registros - 1), $queryString_registros); ?>">Anterior</a>
               <?php } // Show if not first page ?>
             </td>
             <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, min($totalPages_registros, $pageNum_registros + 1), $queryString_registros); ?>">Siguiente</a>
             <?php } // Show if not last page ?>
           </td>
           <td width="23%" id="dato2"><?php if ($pageNum_registros < $totalPages_registros) { // Show if not last page ?>
             <a href="<?php printf("%s?pageNum_registros=%d%s", $currentPage, $totalPages_registros, $queryString_registros); ?>">&Uacute;ltimo</a>
           <?php } // Show if not last page ?>
         </td>
       </tr>
     </table>


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

<!-- js Bootstrap-->
<script src="bootstrap-4/js/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="bootstrap-4/js/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="bootstrap-4/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>



<?php
mysql_free_result($usuario);

?>
