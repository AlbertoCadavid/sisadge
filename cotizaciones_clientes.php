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
if (!isset($_SESSION)) {
  session_start();
}
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

$conexion = new ApptivaDB();

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
//EXPLODE PARA DIVIDIR LA VARIABLE REF QUE VIENE LA REF Y EL NIT DE VISUALIZCION CON BOTON REF. 
$datos=$_GET['con_ref'];
$datos_cliente = explode( '/',$datos);
$datos_cliente_ref=$datos_cliente[1];
$ref=$datos_cliente[0];
//FINN EXPLODE PARA DIVIDIR LA VARIABLE REF QUE VIENE LA REF Y EN NIT 
//CONSULTA USUARIO
$row_usuario = $conexion->buscar('usuario','usuario',$colname_usuario); 
//CONSULTA POR CLIENTE PARA EL BOTON MENU
 

$row_cliente = $conexion->llenaSelect('cliente',"",'ORDER BY nombre_c DESC');  

//CODIGO PARA VISUALIZACION DATOS DEL CLIENTE POR CLIENTE
mysql_select_db($database_conexion1, $conexion1);
$Strnit= $_GET['Str_nit'];//VARIABLE PARA CONSULTAR DATOS DEL CLIENTE
mysql_select_db($database_conexion1, $conexion1);
$query_cotizacion_cliente = ("SELECT * FROM cliente WHERE nit_c ='$Strnit' ");
$cotizacion_cliente = mysql_query($query_cotizacion_cliente, $conexion1) or die(mysql_error());
$row_cotizacion_cliente = mysql_fetch_assoc($cotizacion_cliente);
$totalRows_cotizacion_cliente = mysql_num_rows($cotizacion_cliente);
//CODIGO PARA VISUALIZAR COTIZACION DE BOLSAS SEGUN CLIENTE ESPECIFICO
$colname_ver_bolsa = "-1";  
if (isset($_GET['Str_nit'])) 
{
  $colname_ver_bolsa= (get_magic_quotes_gpc()) ? $_GET['Str_nit'] : addslashes($_GET['Str_nit']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_bolsa = sprintf("SELECT * FROM Tbl_cotizaciones,Tbl_cotiza_bolsa WHERE Tbl_cotizaciones.Str_nit ='%s' and Tbl_cotizaciones.N_cotizacion=Tbl_cotiza_bolsa.N_cotizacion and Tbl_cotizaciones.Str_nit=Tbl_cotiza_bolsa.Str_nit ORDER BY Tbl_cotiza_bolsa.fecha_creacion DESC LIMIT 5",$colname_ver_bolsa);
$ver_bolsa = mysql_query($query_ver_bolsa, $conexion1) or die(mysql_error());
$num2=mysql_num_rows($ver_bolsa);
//CODIGO PARA VISUALIZAR COTIZACION DE LAMINAS SEGUN CLIENTE ESPECIFICO
$colname_ver_lamina = "-1";
if (isset($_GET['Str_nit'])) 
{
  $colname_ver_lamina = (get_magic_quotes_gpc()) ? $_GET['Str_nit'] : addslashes($_GET['Str_nit']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_lamina = sprintf("SELECT * FROM Tbl_cotizaciones,Tbl_cotiza_laminas WHERE Tbl_cotizaciones.Str_nit ='%s' and Tbl_cotizaciones.N_cotizacion=Tbl_cotiza_laminas.N_cotizacion and Tbl_cotizaciones.Str_nit=Tbl_cotiza_laminas.Str_nit ORDER BY Tbl_cotiza_laminas.fecha_creacion DESC LIMIT 5",$colname_ver_lamina);
$ver_lamina = mysql_query($query_ver_lamina, $conexion1) or die(mysql_error());
$num3=mysql_num_rows($ver_lamina);
//CODIGO PARA VISUALIZAR COTIZACION DE MATERIA PRIMA SEGUN CLIENTE ESPECIFICO
$colname_ver_materia = "-1";
if (isset($_GET['Str_nit'])) 
{
  $colname_ver_materia= (get_magic_quotes_gpc()) ? $_GET['Str_nit'] : addslashes($_GET['Str_nit']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_materia = sprintf("SELECT * FROM Tbl_cotizaciones,Tbl_cotiza_materia_p WHERE Tbl_cotizaciones.Str_nit ='%s' and Tbl_cotizaciones.N_cotizacion=Tbl_cotiza_materia_p.N_cotizacion and Tbl_cotizaciones.Str_nit=Tbl_cotiza_materia_p.Str_nit ORDER BY Tbl_cotiza_materia_p.fecha_creacion DESC LIMIT 5",$colname_ver_materia);
$ver_materia = mysql_query($query_ver_materia, $conexion1) or die(mysql_error());
$num4=mysql_num_rows($ver_materia);
//CODIGO PARA VISUALIZAR COTIZACION DE PACKING LIST SEGUN CLIENTE ESPECIFICO
$colname_ver_pl= "-1";
if (isset($_GET['Str_nit'])) 
{
  $colname_ver_pl = (get_magic_quotes_gpc()) ? $_GET['Str_nit'] : addslashes($_GET['Str_nit']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_pl = sprintf("SELECT * FROM Tbl_cotizaciones,Tbl_cotiza_packing WHERE Tbl_cotizaciones.Str_nit ='%s' and Tbl_cotizaciones.N_cotizacion=Tbl_cotiza_packing.N_cotizacion and Tbl_cotizaciones.Str_nit=Tbl_cotiza_packing.Str_nit ORDER BY Tbl_cotiza_packing.fecha_creacion DESC LIMIT 5",$colname_ver_pl);
$ver_pl = mysql_query($query_ver_pl, $conexion1) or die(mysql_error());
$num5=mysql_num_rows($ver_pl);
//CODIGO PARA VISUALIZAR NUMERO DE COTIZACION MENU
mysql_select_db($database_conexion1, $conexion1);
$query_ver_ref ="SELECT * FROM Tbl_cotizaciones ORDER BY N_cotizacion DESC ";														
$refe = mysql_query($query_ver_ref, $conexion1) or die(mysql_error());
$row_ref = mysql_fetch_assoc($refe);
$totalRows_ref = mysql_num_rows($refe);
//CONSULTA POR CLIENTE
$nit=$_GET['Str_nit'];
mysql_select_db($database_conexion1, $conexion1);
$query_ref2 = "SELECT * FROM Tbl_cotiza_bolsa,Tbl_cotizaciones WHERE Tbl_cotiza_bolsa.Str_nit='$nit' AND Tbl_cotizaciones.N_cotizacion=Tbl_cotiza_bolsa.N_cotizacion AND Tbl_cotizaciones.Str_nit=Tbl_cotiza_bolsa.Str_nit";
$edit_ref_b = mysql_query($query_ref2, $conexion1) or die(mysql_error());
$row_ref_refb  = mysql_fetch_assoc($edit_ref_b );
$totalRows_ref_b  = mysql_num_rows($edit_ref_b );

//CODIGO PARA VISUALIZACION DATOS DEL CLIENTE  EN REFERENCIAS
mysql_select_db($database_conexion1, $conexion1);
$query_cotizacion_clienteref = ("SELECT * FROM cliente WHERE nit_c='$datos_cliente_ref'");
$cotizacion_clienteref = mysql_query($query_cotizacion_clienteref, $conexion1) or die(mysql_error());
$row_cotizacion_clienteref = mysql_fetch_assoc($cotizacion_clienteref);
$totalRows_cotizacion_clienteref = mysql_num_rows($cotizacion_clienteref);
//FIN DE CONSULTA POR REFERENCIAS
//CONSULTA PARA ENVIAR EL NIT CORRESPONDIENTE A LA REFERENCIA
$ref=$datos_cliente[0];
mysql_select_db($database_conexion1, $conexion1);
$query_ver_ref_nit = "SELECT * FROM Tbl_cliente_referencia WHERE N_cotizacion='$ref'";
$ref_nit  = mysql_query($query_ver_ref_nit , $conexion1) or die(mysql_error());
$row_ref_nit  = mysql_fetch_assoc($ref_nit );
$totalRows_ref_nit  = mysql_num_rows($ref_nit );
//CONSULTA POR COTIZACIONES PARA EL BOTON MENU COTIZACIONES
 
$row_cliente2 = $conexion->llenaSelect('Tbl_cotizaciones',"",'ORDER BY N_cotizacion DESC');  
//CODIGO PARA VISUALIZAR REFERENCIAS DE BOLSAS SEGUN COTIZACION ESPECIFICO
$colname_ver_bolsa2 = "-1";  
if (isset($ref)) 
{
  $colname_ver_bolsa2= (get_magic_quotes_gpc()) ? $ref : addslashes($ref);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_bolsa2 = sprintf("SELECT *
FROM Tbl_cotiza_bolsa WHERE Tbl_cotiza_bolsa.N_cotizacion='%s'",$colname_ver_bolsa2);
$ver_bolsa2 = mysql_query($query_ver_bolsa2, $conexion1) or die(mysql_error());
$row_ver_bolsa2  = mysql_fetch_assoc($ver_bolsa2);
$num22=mysql_num_rows($ver_bolsa2);
//CODIGO PARA VISUALIZAR REFERENCIAS DE LAMINAS SEGUN COTIZACION ESPECIFICO
$colname_ver_lamina2 = "-1";
if (isset($ref)) 
{
  $colname_ver_lamina2 = (get_magic_quotes_gpc()) ? $ref : addslashes($ref);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_lamina2 = sprintf("SELECT *
FROM Tbl_cotiza_laminas WHERE Tbl_cotiza_laminas.N_cotizacion='%s'",$colname_ver_lamina2);
$ver_lamina2 = mysql_query($query_ver_lamina2, $conexion1) or die(mysql_error());
$row_ver_lamina2  = mysql_fetch_assoc($ver_lamina2);
$num32=mysql_num_rows($ver_lamina2);
//CODIGO PARA VISUALIZAR REFERENCIAS DE PACKING SEGUN COTIZACION ESPECIFICO
$colname_ver_pl2= "-1";
if (isset($ref)) 
{
  $colname_ver_pl2 = (get_magic_quotes_gpc()) ? $ref : addslashes($ref);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_pl2 = sprintf("SELECT *
FROM Tbl_cotiza_packing WHERE Tbl_cotiza_packing.N_cotizacion='%s'",$colname_ver_pl2);
$ver_pl2 = mysql_query($query_ver_pl2, $conexion1) or die(mysql_error());
$row_ver_pl2  = mysql_fetch_assoc($ver_pl2);
$num52=mysql_num_rows($ver_pl2);
//CODIGO PARA VISUALIZAR FECHA Y REGISTRO DE MATERIA SEGUN COTIZACION ESPECIFICO
$colname_ver_m2= "-1";
if (isset($ref)) 
{
  $colname_ver_m2 = (get_magic_quotes_gpc()) ? $ref : addslashes($ref);
}
mysql_select_db($database_conexion1, $conexion1);
$query_ver_m2 = sprintf("SELECT *
FROM Tbl_cotiza_materia_p WHERE Tbl_cotiza_materia_p.N_cotizacion='%s'",$colname_ver_m2);
$ver_materia2= mysql_query($query_ver_m2, $conexion1) or die(mysql_error());
$row_ver_materia2  = mysql_fetch_assoc($ver_materia2);
$num72=mysql_num_rows($ver_materia2);
//FECHA Y REGISTRO
$colname_cotizacion_fc = "-1";
if (isset($ref)) {
  $colname_cotizacion_fc = (get_magic_quotes_gpc()) ? $ref : addslashes($ref);
}
mysql_select_db($database_conexion1, $conexion1);
$query_cotizacion_fc= sprintf("SELECT * FROM Tbl_cotiza_bolsa WHERE Tbl_cotiza_bolsa.N_cotizacion = '%s'", $colname_cotizacion_fc,$colname_cotizacion_fc);
$cotizacion_fc = mysql_query($query_cotizacion_fc, $conexion1) or die(mysql_error());
$row_cotizacion_fc = mysql_fetch_assoc($cotizacion_fc);
$totalRows_cotizacion_fc = mysql_num_rows($cotizacion_fc);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISADGE AC &amp; CIA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/vista.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/formato.js"></script>
<script type="text/javascript" src="js/vista.js"></script>
<script type="text/javascript" src="js/listado.js"></script>

<link href="css/formato.css" rel="stylesheet" type="text/css" />
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

<body>
<?php echo $conexion->header('listas'); ?>

                  <table class="table table-bordered table-sm">
                    <tr>
                      <td><table class="table table-bordered table-sm">
                        <tr>
                          <td><table class="table table-bordered table-sm">
                            <tr>
                              <td rowspan="2" id="fondo" width="30%"><img src="images/logoacyc.jpg"></td>
                              <td colspan="2"><div id="titulo1">COTIZACION <?php //echo  $row_ver_bolsa2['N_cotizacion'];echo $row_ver_lamina2['N_cotizacion'];echo $row_ver_pl2['N_cotizacion'];echo $row_ver_m2['N_cotizacion']?></div>
                                <div id="fondo">ALBERTO CADAVID R & CIA S.A.  Nit: 890915756-6</strong><br>
                                  Carrera 45 No. 14 - 15  Tel: 311-21-44 Fax: 2664123  Medellin-Colombia<br>
                                Emal: alvarocadavid@acycia.com</div></td>
                              </tr>
                              <tr>
                                <td id="fondo_2">CODIGO : R1 - F03</td>
                                <td id="fondo_2">VERSION : 2</td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td><table class="table table-bordered table-sm">
                              <tr>
                                <td id="fuente10" >

                                  <form action="cotizaciones_clientes.php" method="GET" name="form1">
                                    <p>NUMERO DE COTIZACION.
                                      <?php $ref=$datos_cliente[0];?>
                                    </p>
                                    <p>
                                      <select name="con_ref" id="con_ref" class="selectsMedio busqueda">
                                       <option value="0" <?php if (!(strcmp(0, $ref))) {echo "selected=\"selected\"";} ?>>SELECCIONAR</option>
                                       <?php  foreach($row_cliente2 as $row_cliente2 ) { ?>
                                        <option value="<?php echo $row_cliente2['N_cotizacion']?>/<?php echo $row_cliente2['Str_nit']; ?>"<?php if (!(strcmp($row_cliente2['N_cotizacion'], $ref))) {echo "selected=\"selected\"";} ?>><?php echo $row_cliente2['N_cotizacion']?></option>
                                      <?php } ?>
                                    </select> 
                                    <input type="submit" name="Submit" class="botonGeneral" value="BUSQUEDA" onclick="if(BUSQUEDA.ref.value=='0') { alert('DEBE SELECCIONAR UNA OPCION'); }"/>
                                  </p>
                                </form>  
                              </td>
                              <td id="fuente10" >
                                <form name="form1" method="GET" action="cotizaciones_clientes.php">
                                  <p>CLIENTE:              </p>
                                  <p>
                                    <select name="Str_nit" id="Str_nit"  class="selectsGrande busqueda">
                                     <option value="0" <?php if (!(strcmp(0, $_GET['Str_nit']))) {echo "selected=\"selected\"";} ?>>SELECCIONAR</option>
                                     <?php  foreach($row_cliente as $row_cliente ) { ?>
                                      <option value="<?php echo $row_cliente['nit_c']?>"<?php if (!(strcmp($row_cliente['nit_c'], $_GET['Str_nit']))) {echo "selected=\"selected\"";} ?>><?php $cad=htmlentities($row_cliente['nombre_c']); echo $cad;?></option>
                                    <?php } ?>
                                  </select>

                                  <input type="submit" name="Submit2" class="botonGeneral" value="                                     CONSULTA                                    " onClick="if(consulta.Str_nit.value=='0') { alert('DEBE SELECCIONAR UNA OPCION'); }"/>
                                </p>
                              </form>      
                            </td>
                          </tr>
                          <tr>
                            <td id="subppal4" width="50%">FECHA : <?php 
                            $fecha1=$row_cotizacion_fc['fecha_creacion'];
                            $dia1=substr($fecha1,8,2);
                            $mes1=substr($fecha1,5,2);
                            $ano1=substr($fecha1,0,4);
                            if($mes1=='01')
                            {
                              echo "Enero"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='02')
                            {
                              echo "Febrero"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='03')
                            {
                              echo "Marzo"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='04')
                            {
                              echo "Abril"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='05')
                            {
                              echo "Mayo"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='06')
                            {
                              echo "Junio"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='07')
                            {
                              echo "Julio"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='08')
                            {
                              echo "Agosto"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='09')
                            {
                              echo "Septiembre"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='10')
                            {
                              echo "Octubre"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='11')
                            {
                              echo "Noviembre"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            if($mes1=='12')
                            {
                              echo "Diciembre"."  ".$dia1."  "."de"."  ".$ano1;
                            }
                            ?>
                            <?php echo $row_ver_lamina2['fecha_creacion'];
                            echo $row_ver_pl2['fecha_creacion'];
                            echo $row_ver_m2['fecha_creacion'];
                            ?>
                          </td>
                          <td id="subppal4" width="50%">REGISTRO : <?php		
                          $vendedor=$row_cotizacion_fc['Str_usuario'];
                          if($vendedor!='')
                          {
                            $sqlvendedor="SELECT * FROM vendedor WHERE id_vendedor ='$vendedor'";
                            $resultvendedor= mysql_query($sqlvendedor);
                            $numvendedor= mysql_num_rows($resultvendedor);
                            if($numvendedor >='1') 
                            { 
                              $nombre_vendedor = mysql_result($resultvendedor,0,'nombre_vendedor'); 
                              echo $nombre_vendedor;
                            }
                          }
                          ?>
                          <?php 
  //mostrar registro usuario por cotizacion 
                          $lamina= $row_ver_lamina2['Str_usuario'];
                          $pl=$row_ver_pl2['Str_usuario'];
                          $mm=$row_ver_m2['Str_usuario'];
                          if($lamina!=''||$pl!=''||$mm!='')
                          {
                            $sqlvendedo="SELECT * FROM vendedor WHERE id_vendedor='$lamina' or id_vendedor = '$pl' or id_vendedor='$mm'";
                            $resultvendedo= mysql_query($sqlvendedo);
                            $numvendedo= mysql_num_rows($resultvendedo);
                            if($numvendedo >='1') 
                            { 
                              $nombre_vendedo = mysql_result($resultvendedo,0,'nombre_vendedor'); 
                              echo $nombre_vendedo;
                            }
                          }
                          ?></td>
                        </tr>
                        <tr>
                          <td id="fuente6">CLIENTE: <?php echo $row_cotizacion_cliente['nombre_c']; ?><?php echo $row_cotizacion_clienteref['nombre_c'];?></td>
                          <td id="fuente6">NIT: <?php echo $row_cotizacion_cliente['nit_c']; ?><?php echo $row_cotizacion_clienteref['nit_c']; ?></td>
                        </tr>
                        <tr>
                          <td id="fuente6">PAIS / CIUDAD: <?php echo $row_cotizacion_cliente['pais_c'];?><?php echo $row_cotizacion_clienteref['pais_c'];?> / <?php echo $row_cotizacion_cliente['ciudad_c'];?><?php echo $row_cotizacion_clienteref['ciudad_c'];?></td>
                          <td id="fuente6">TELEFONO: <?php echo $row_cotizacion_cliente['telefono_c'];?><?php echo $row_cotizacion_clienteref['telefono_c'];?></td>
                        </tr>
                        <tr>
                          <td id="fuente6">EMAIL: <?php echo $row_cotizacion_cliente['email_comercial_c'];?><?php echo $row_cotizacion_clienteref['email_comercial_c']; ?></td>
                          <td id="fuente6">FAX: <?php echo $row_cotizacion_cliente['fax_c']; ?><?php echo $row_cotizacion_clienteref['fax_c']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" id="fuente6">DIRECCION : <?php echo $row_cotizacion_cliente['direccion_c']; ?><?php echo $row_cotizacion_clienteref['direccion_c']; ?></td>
                        </tr>
                        <tr>
                          <td id="fuente6">CONTACTO COMERCIAL:<?php echo $row_cotizacion_cliente['contacto_c']; ?><?php echo $row_cotizacion_clienteref['contacto_c']; ?></td>
                          <td id="fuente6">CARGO: <?php echo $row_cotizacion_cliente['cargo_contacto_c']; ?><?php echo $row_cotizacion_clienteref['cargo_contacto_c']; ?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center">
                        <?php if($num2!='0')
                        { ?>
                          <table class="table table-bordered table-sm" >
                            <tr>
                              <td width="139" colspan="<?php echo $num2+1; ?>" nowrap  id="subppal2"><strong>COTIZACION BOLSAS </strong></td>
                            </tr>
                            <tr>
                              <td id="subppal4">COTIZACION N&deg; </td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td width="549" id="fuente2"><?php
                                $var=mysql_result($ver_bolsa,$i,N_cotizacion);
                                $var2=mysql_result($ver_bolsa,$i,Str_nit);
                                echo $linc="<a href='cotizacion_g_bolsa_vista.php?N_cotizacion=$var&amp;Str_nit=$var2&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
                              <?php } ?>        
                            </tr>
                            <tr>
                              <td id="subppal4">REFERENCIA N&deg; </td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_referencia_c); echo $var; ?></td>
                              <?php  } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">FECHA</td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,fecha_creacion); echo $var; ?></td>
                              <?php  } ?>
                            </tr>                
                            <tr>
                              <td id="subppal4">ANCHO(cm)  </td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_ancho); echo $var; ?></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">ALTO(cm) </td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_alto); echo $var; ?></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">FUELLE(cm)</td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_fuelle); echo $var; ?></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">CALIBRE (micras) </td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_calibre); echo $var; ?></td>
                              <?php } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">TROQUEL</td>
                              <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
                                <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_troquel); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
                              <?php } ?>
                            </tr>
        <!--<tr>
          <td id="subppal4">BOLSILLO PORTAGUIA(cm) </td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
          <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_bolsillo); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
          <?php } ?>
        </tr>-->
        <tr>
          <td id="subppal4"> BOLSILLO PORTAGUIA(cm) </td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_tamano_bolsillo); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">SOLAPA</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_solapa); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">PRECIO($)</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_moneda); echo $var; ?>/<?php $var=mysql_result($ver_bolsa,$i,N_precio); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">UNIDAD VENTA</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_unidad_vta); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">PLAZO DE PAGO</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_plazo); echo $var; ?></td>
          <?php } ?>
        </tr>          
        <tr>
          <td id="subppal4">INCOTERMS</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_incoterms); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">TIPO/COEXTRUSION </td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_tipo_coextrusion); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">CAPA EXTERNA COEXTRUSION</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_capa_ext_coext); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">CAPA INTERNA COEXTRUSION</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_capa_inter_coext); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">CANTIDAD IMPRESION</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_cant_impresion); if($var=='0'){ echo "N.A"; }else {echo $var;} ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">COLORES IMPRESION</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,N_colores_impresion); echo $var." COLORES";?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">CYRELES</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_cyreles);if($var=='0'){ echo "ACYCIA"; }else if($var=='1'){echo "SE LE FACTURA";}else if($var==''){echo "N.A";} ?></td><?php } ?>
          </tr> 
          <tr>
            <td id="subppal4">SELLADO SEGURIDAD</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_sellado_seguridad); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td id="subppal4">SELLADO PERMANENTE</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_sellado_permanente); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";}  ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td id="subppal4">SELLADO RESELLABLE</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_sellado_resellable); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";}  ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td id="subppal4">SELLADO HOTMELT</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_sellado_hotm); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
            <?php } ?>
          </tr> 
          <tr>
            <td id="subppal4">SELLADO LATERAL</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,Str_sellado_lateral); echo $var; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td id="subppal4">FONDO</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_fondo); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
            <?php } ?>
          </tr>  
          <tr>
            <td id="subppal4">CODIGO DE BARRAS</td>
            <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
             <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_codigo_b); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
           <?php } ?>
         </tr>
         <tr>
          <td id="subppal4">NUMERACION</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_numeracion); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
          <?php } ?>
        </tr> 
        <tr>
          <td id="subppal4">ESTADO</td>
          <?php  for ($i=0;$i<=$num2-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa,$i,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";} ?></td>
          <?php } ?>
        </tr>                                                           
      </table>
    <?php }?>
    <?php if($num5!='0')
    { ?>
      <table class="table table-bordered table-sm">
        <tr>
          <td width="144" colspan="<?php echo $num5+1; ?>" nowrap  id="subppal2"><strong>COTIZACION PACKING LIST</strong></td>
        </tr>
        <tr>
          <td  id="subppal4">COTIZACION N&deg; </td>
          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
            <td id="fuente2"><?php 
            $var=mysql_result($ver_pl,$l,N_cotizacion);
            $var2=mysql_result($ver_pl,$l,Str_nit);
            echo $linc="<a href='cotizacion_g_packing_vista.php?N_cotizacion=$var&amp;Str_nit=$var2&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
          <?php } ?>        
        </tr>
        <tr>
          <td id="subppal4">REFERENCIA N&deg; </td>
          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,N_referencia_c); echo $var; ?></td>
          <?php  } ?>
        </tr>
        <tr>
          <td id="subppal3">FECHA</td>
          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,fecha_creacion); echo $var; ?></td>
          <?php  } ?>
        </tr>          
        <tr>
          <td width="120" id="subppal4">ANCHO(cm)</td>
          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
            <td id="fuente2">
              <?php $var=mysql_result($ver_pl,$l,N_ancho); echo $var; ?>		  </td><?php } ?>
            </tr>
            <tr>
              <td id="subppal4">ALTO(cm)</td>
              <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                <td id="fuente2">
                  <?php $var=mysql_result($ver_pl,$l,N_alto); echo $var; ?>		  </td> <?php } ?>
                </tr>
                <tr>
                  <td id="subppal4">CANTIDAD SOLICITADA</td>
                  <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                    <td id="fuente2">
                      <?php $var=mysql_result($ver_pl,$l,N_cantidad); echo $var; ?>		  </td><?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">CALIBRE</td>
                      <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                        <td id="fuente2">
                          <?php $var=mysql_result($ver_pl,$l,N_calibre); echo $var; ?>		  </td><?php } ?>
                        </tr> 
                        <tr>
                          <td id="subppal4">INCOTERMS</td>
                          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                            <td id="fuente2">
                              <?php $var=mysql_result($ver_pl,$l,Str_incoterms);	echo $var; ?>		  </td><?php } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">PRECIO($)</td>
                              <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                <td id="fuente2">
                                  <?php $var=mysql_result($ver_pl,$l,Str_moneda); echo $var; ?>/<?php $var=mysql_result($ver_pl,$l,N_precio_vnta); echo $var; ?></td><?php } ?>
                                </tr>
                                <td id="subppal4">BOCA ENTRADA</td>
                                <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                  <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,Str_boca_entrada); echo $var; ?>		  </td><?php } ?>
                                </tr>
                                <tr>
                                  <td id="subppal4">COLORES IMPRESION</td>
                                  <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                    <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,N_colores_impresion); echo $var." COLORES";?>		  </td><?php } ?>
                                  </tr>
                                  <tr>
                                    <td id="subppal4">CYRELES</td>
                                    <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                      <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,B_cyreles);if($var=='0'){ echo "ACYCIA"; }else if($var=='1'){echo "SE LE FACTURA";}else if($var==''){echo "N.A";} ?></td><?php } ?>
                                    </tr>
                                    <tr>
                                      <td id="subppal4">UBIC. ENTRADA</td>
                                      <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                        <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,Str_ubica_entrada); echo $var; ?>		  </td><?php } ?>
                                      </tr>
                                      <tr>
                                        <td id="subppal4">LAMINA 1</td>
                                        <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                          <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,Str_lam1); echo $var; ?>		  </td><?php } ?>
                                        </tr>
                                        <tr>
                                          <td id="subppal4">LAMINA 2</td>
                                          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                            <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,Str_lam2); echo $var; ?>		  </td>
                                          <?php } ?>
                                        </tr>
                                        <tr>
                                          <td id="subppal4">PLAZO DE PAGO</td>
                                          <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                            <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,Str_plazo); echo $var; ?>		  </td><?php } ?>
                                          </tr>
                                          <tr>
                                            <td id="subppal4">ESTADO</td>
                                            <?php  for ($l=0;$l<=$num5-1;$l++) { ?>
                                              <td id="fuente2"><?php $var=mysql_result($ver_pl,$l,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";}?></td>
                                            <?php } ?>
                                          </tr>                 
                                        </table>       
                                      <?php }?>
                                      <?php if($num3!='0')
                                      { ?>
                                        <table class="table table-bordered table-sm">
                                          <tr>
                                            <td width="144" colspan="<?php echo $num3+1; ?>" nowrap id="subppal2"><strong>COTIZACION LAMINAS</strong></td>
                                          </tr>
                                          <tr>
                                            <td id="subppal4">COTIZACION N&deg; </td>
                                            <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                              <td id="fuente2"><?php 
                                              $var=mysql_result($ver_lamina,$j,N_cotizacion);
                                              $var2=mysql_result($ver_lamina,$j,Str_nit);
                                              echo $linc="<a href='cotizacion_g_lamina_vista.php?N_cotizacion=$var&amp;Str_nit=$var2&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
                                            <?php } ?>        
                                          </tr>
                                          <tr>
                                            <td id="subppal4">REFERENCIA N&deg; </td>
                                            <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                              <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,N_referencia_c); echo $var; ?></td>
                                            <?php  } ?>
                                          </tr>
                                          <tr>
                                            <td id="subppal4">FECHA</td>
                                            <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                              <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,fecha_creacion); echo $var; ?></td>
                                            <?php  } ?>
                                          </tr>          
                                          <tr>
                                            <td id="subppal4">ANCHO(cm) </td>
                                            <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                              <td width="544" id="fuente2"><?php $var=mysql_result($ver_lamina,$j,N_ancho); echo $var; ?>		  </td><?php } ?>
                                            </tr>
                                            <tr>
                                              <td id="subppal4">REPETICION</td>
                                              <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                <td id="fuente2">
                                                  <?php $var=mysql_result($ver_lamina,$j,N_repeticion); echo $var; ?>		  </td><?php } ?>
                                                </tr>
                                                <tr>
                                                  <td id="subppal4">CALIBRE (micras) </td>
                                                  <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                    <td id="fuente2">
                                                      <?php $var=mysql_result($ver_lamina,$j,N_calibre); echo $var; ?>		  </td> <?php } ?>
                                                    </tr>
                                                    <tr>
                                                      <td id="subppal4">CANTIDAD(mts)</td>
                                                      <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                        <td id="fuente2">
                                                          <?php $var=mysql_result($ver_lamina,$j,N_cantidad_metros_r); echo $var; ?>		  </td><?php } ?>
                                                        </tr>
                                                        <tr>
                                                          <td id="subppal4">INCOTERMS</td>
                                                          <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                            <td id="fuente2">
                                                              <?php $var=mysql_result($ver_lamina,$j,Str_incoterms); echo $var; ?>		  </td><?php } ?>
                                                            </tr> 
                                                            <tr>
                                                              <td id="subppal4">COLORES IMPRESION </td>
                                                              <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                <td id="fuente2">
                                                                  <?php $var=mysql_result($ver_lamina,$j,N_colores_impresion);echo $var." COLORES"; ?>	</td><?php } ?>
                                                                </tr>
                                                                <tr>
                                                                  <td id="subppal4">CYRELES</td>
                                                                  <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                    <td id="fuente2">
                                                                      <?php $var=mysql_result($ver_lamina,$j,B_cyreles);if($var=='0'){ echo "ACYCIA"; }else if($var=='1'){echo "SE LE FACTURA";}else if($var==''){echo "N.A";} ?></td><?php } ?>
                                                                    </tr>
                                                                    <tr>
                                                                      <td id="subppal4">CANTIDAD SOLICITADA</td>
                                                                      <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                        <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,N_cantidad); echo $var; ?>		  </td><?php } ?>
                                                                      </tr>
                                                                      <tr>
                                                                        <td id="subppal4">PESO MAX.</td>
                                                                        <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                          <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,N_peso_max); echo $var; ?>		  </td><?php } ?>
                                                                        </tr>
                                                                        <tr>
                                                                          <td id="subppal4">DIAMETRO MAX.</td>
                                                                          <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                            <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,N_diametro_max); echo $var; ?>		  </td><?php } ?>
                                                                          </tr>
                                                                          <tr>
                                                                            <td id="subppal4">PRECIO($)</td>
                                                                            <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                              <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,Str_moneda); echo $var; ?>/<?php $var=mysql_result($ver_lamina,$j,N_precio_k); echo $var; ?></td><?php } ?>
                                                                            </tr>
                                                                            <tr>
                                                                              <td id="subppal4">ESTADO</td>
                                                                              <?php  for ($j=0;$j<=$num3-1;$j++) { ?>
                                                                                <td id="fuente2"><?php $var=mysql_result($ver_lamina,$j,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";}?></td>
                                                                              <?php } ?>
                                                                            </tr>        
                                                                          </table>     
                                                                        <?php }?>
                                                                        <?php if($num4!='0')
                                                                        { ?>
                                                                          <table class="table table-bordered table-sm">
                                                                            <tr>
                                                                              <td width="160" colspan="<?php echo $num4+1; ?>" nowrap id="subppal2"><strong>COTIZACION MATERIA PRIMA</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td id="subppal4">COTIZACION N&deg; </td>
                                                                              <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
                                                                                <td id="fuente2"><?php
                                                                                $var=mysql_result($ver_materia,$k,N_cotizacion);
                                                                                $var2=mysql_result($ver_materia,$k,Str_nit);
                                                                                echo $linc="<a href='cotizacion_g_materiap_vista.php?N_cotizacion=$var&amp;Str_nit=$var2&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
                                                                              <?php } ?>        
                                                                            </tr>
                                                                            <tr>
                                                                              <td id="subppal4"> REFERENCIA</td>
                                                                              <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
                                                                                <td id="fuente2"><?php $var=mysql_result($ver_materia,$k,Str_referencia); echo $var; ?></td>
                                                                              <?php  } ?>
                                                                            </tr>
                                                                            <tr>
                                                                              <td id="subppal4">FECHA</td>
                                                                              <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
                                                                                <td id="fuente2"><?php $var=mysql_result($ver_materia,$k,fecha_creacion); echo $var; ?></td>
                                                                              <?php  } ?>
                                                                            </tr>          
                                                                            <tr>
                                                                              <td id="subppal4">CANTIDAD(und)</td>
                                                                              <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
                                                                                <td width="544"id="fuente2">
                                                                                  <?php $var=mysql_result($ver_materia,$k,N_cantidad); echo $var; ?>		  </td><?php } ?>
                                                                                </tr>
                                                                                <tr>
                                                                                  <td id="subppal4">INCOTERMS</td>
                                                                                  <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
                                                                                    <td id="fuente2">
                                                                                      <?php $var=mysql_result($ver_materia,$k,Str_incoterms); echo $var; ?>		  </td> <?php } ?>
                                                                                    </tr>
                                                                                    <tr>
                                                                                      <td id="subppal4">PRECIO($)</td>
                                                                                      <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
                                                                                        <td id="fuente2">
                                                                                          <?php $var=mysql_result($ver_materia,$k,Str_moneda); echo $var; ?>/<?php $var=mysql_result($ver_materia,$k,N_precio_vnta); echo $var; ?></td><?php } ?>
                                                                                        </tr>
        <!--<tr>
          <td id="subppal4">REFERENCIA N&deg;</td>
		  <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
          <td id="fuente2"><?php $var=mysql_result($ver_materia,$k,N_referencia_c); echo $var; ?></td><?php } ?>
        </tr>-->
        <tr>
          <td id="subppal4">UNIDAD DE VENTA</td>
          <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
            <td id="fuente2">
             <?php $var=mysql_result($ver_materia,$k,Str_unidad_vta); echo $var; ?></td>
           <?php } ?>
         </tr>
         <tr>
          <td id="subppal4">PLAZO DE PAGO</td>
          <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
            <td id="fuente2">
             <?php $var=mysql_result($ver_materia,$k,Str_plazo); echo $var; ?></td>
           <?php } ?>
         </tr>
         <tr>
          <td id="subppal4">ARCHIVO ADJUNTO MP</td>
          <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_materia,$k,Str_linc);if($var!=''){ ?><a href="javascript:verFoto('archivosc/archivos_pdf_mp/<?php echo $var ?>','610','490')"><?php echo $var ?></a><?php }else    echo "N/A";?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">ESTADO</td>
          <?php  for ($k=0;$k<=$num4-1;$k++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_materia,$k,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";}?></td>
          <?php } ?>
        </tr>                         
      </table>       
    <?php }?>
    <!--aqui empieza por referencia --> 
    <tr>
      <td align="center">
          <?php if($num22!='0')//&&$ver_bolsa['tipo_bolsa_ref']!="LAMINA"||$ver_bolsa['tipo_bolsa_ref']!="PACKING LIST")
          { ?>
            <table class="table table-bordered table-sm" >
              <tr>
                <td width="139" colspan="<?php echo $num22+1; ?>" nowrap  id="subppal2"><strong><!--<a href="cotizacion_g_bolsa_vista.php?N_cotizacion=<?php echo $ref;?>&Str_nit=<?php echo $row_cotizacion_clienteref['nit_c']; ?>&cod_ref=<?php echo $row_ref_refb['cod_ref']; ?>&tipo=<?php echo $row_usuario['tipo_usuario'] ?>">COTIZACION  BOLSA </a>-->COTIZACION  BOLSA
                  <!--<a href="cotizacion_general_bolsa_generica2.php?N_cotiz=<?php echo $row_ref_refb['n_cotiz_ref'];?>&cod_ref=<?php echo $row_ref_refb['cod_ref'];?>&tipo=<?php echo $row_usuario['tipo_usuario'] ?>">AGREGAR OTRO CLIENTE </a>--></strong>
                </td>
              </tr>
              <tr>
                <td id="subppal4">REFERENCIA N� </td>
                <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
                  <td width="549" id="fuente2"><?php
                  $var=mysql_result($ver_bolsa2,$i,N_referencia_c);
                  $var2=mysql_result($ver_bolsa2,$i,N_cotizacion);
                  $var3=mysql_result($ver_bolsa2,$i,Str_nit);
                  
                  echo $linc="<a href='cotizacion_general_bolsas_edit.php?N_cotizacion=$var2&amp;cod_ref=$var&amp;Str_nit=$var3&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
                <?php } ?>        
              </tr> 
<!--<tr>
          <td id="subppal4">VERSION</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
          <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,version_ref); echo $var; ?>		  </td><?php } ?>
        </tr>-->
<!--<tr>
  <td id="subppal4">TIPO DE BOLSA</td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
  <td id="fuente2"><?php $var1=mysql_result($ver_bolsa2,$i,B_sellado_seguridad); 
  $var2=mysql_result($ver_bolsa2,$i,B_sellado_permanente); 
  $var3=mysql_result($ver_bolsa2,$i,B_sellado_resellable); 
  $var4=mysql_result($ver_bolsa2,$i,B_sellado_hotm); 
  if($var1==1){echo "CINTA DE SEGURIDAD";}else if($var2==1){echo "CINTA PERMANENTE";}else if($var3==1){echo "CINTA RESELLABLE";}else if($var4==1){echo "HOT MELT";}else{echo "N.A";}?></td>
  <?php } ?>
</tr>-->
<tr>
  <td id="subppal4">MATERIAL</td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,Str_tipo_coextrusion); echo $var; ?></td>
  <?php } ?>
</tr>               
<tr>
  <td id="subppal4">ANCHO(cm)  </td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_ancho); echo $var; ?></td>
  <?php } ?>
</tr>
<tr>
  <td id="subppal4">ALTO(cm) </td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_alto); echo $var; ?></td>
  <?php } ?>
</tr>
<tr>
  <td id="subppal4">SOLAPA</td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_solapa); echo $var; ?></td>
  <?php } ?>
</tr>
<tr>
  <td id="subppal4">FUELLE(cm)</td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_fuelle); if($var=='0'){ echo "NO"; }else {echo $var;} ?></td>
  <?php } ?>
</tr>
<tr>
  <td id="subppal4">CALIBRE (micras) </td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_calibre); echo $var; ?></td>
  <?php } ?>
</tr>
<tr>
  <td id="subppal4">COLORES IMPRESION</td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_colores_impresion);if($var=='0'){echo 'SEGUN ARTE';} else {echo $var." COLORES";}?></td>
  <?php } ?>
</tr>
<tr>
  <td id="subppal4">BOLSILLO PORTAGUIA(cm) </td>
  <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
    <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_bolsillo); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
  <?php } ?>
</tr>

        <!--<tr>
          <td id="subppal4">PESO MILLAR</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
          <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,peso_millar_ref); echo $var; ?></td>
          <?php } ?>
        </tr>--> 
        <tr>
          <td id="subppal4">LATERAL</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,Str_sellado_lateral); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">FONDO</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_fondo); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
          <?php } ?>
        </tr> 
        <tr>
          <td id="subppal4">TROQUEL</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_troquel); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
          <?php } ?>
        </tr>                       
        <tr>
          <td id="subppal4">CODIGO DE BARRAS</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_codigo_b); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">NUMERACION</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_numeracion); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">TIPO DE ADHESIVO</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var1=mysql_result($ver_bolsa2,$i,B_sellado_seguridad); 
            $var2=mysql_result($ver_bolsa2,$i,B_sellado_permanente); 
            $var3=mysql_result($ver_bolsa2,$i,B_sellado_resellable); 
            $var4=mysql_result($ver_bolsa2,$i,B_sellado_hotm); 
            if($var1==1){echo "CINTA DE SEGURIDAD";}else if($var2==1){echo "CINTA PERMANENTE";}else if($var3==1){echo "CINTA RESELLABLE";}else if($var4==1){echo "HOT MELT";}else{echo "N.A";}?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">CANTIDA MINIMA </td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_cant_impresion); if($var=='0'){ echo "N.A"; }else {echo $var;}  ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">INCOTERMS</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,Str_incoterms); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">MONEDA DE NEGOCIACION </td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,Str_moneda); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">PRECIO DE VENTA </td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,N_precio); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">UNIDAD DE VENTA </td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,Str_unidad_vta); echo $var; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <td id="subppal4">COSTO CYREL</td>
          <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
            <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_cyreles); if($var=='0'){ echo "ACYCIA"; }else if($var=='1'){echo "SE LE FACTURA";}else if($var==''){echo "N.A";} ?></td><?php } ?>
          </tr>                         
          <tr>
            <td id="subppal4">GENERICA</td>
            <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_generica); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td id="subppal4">ESTADO</td>
            <?php  for ($i=0;$i<=$num22-1;$i++) { ?>
              <td id="fuente2"><?php $var=mysql_result($ver_bolsa2,$i,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";} ?></td>
            <?php } ?>
          </tr>                                                                  
        </table>
      <?php }?>
      <?php if($num52!='0')
      { ?>
        <table class="table table-bordered table-sm">
          <tr>
            <td width="144" colspan="<?php echo $num52+1; ?>" nowrap  id="subppal2"><strong><!--<a href="cotizacion_g_packing_vista.php?N_cotizacion=<?php echo $ref;?>&Str_nit=<?php echo $row_cotizacion_clienteref['nit_c']; ?>&tipo=<?php echo $row_usuario['tipo_usuario'] ?>">COTIZACION  PACKING LIST</a>-->COTIZACION  PACKING LIST</strong> </td>
          </tr>
          <tr>
            <td  id="subppal4">REFERENCIA N&deg; </td>
            <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
              <td id="fuente2"><?php 
              $var=mysql_result($ver_pl2,$l,N_referencia_c);
              $var2=mysql_result($ver_pl2,$l,N_cotizacion);
              $var3=mysql_result($ver_pl2,$l,Str_nit);
              echo $linc="<a href='cotizacion_general_packingList_edit.php?N_cotizacion=$var2&amp;cod_ref=$var&amp;Str_nit=$var3&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
            <?php } ?>        
          </tr> 
        <!--<tr>
          <td id="subppal4">VERSION</td>
          <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
          <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,version_ref); echo $var; ?>		  </td><?php } ?>
        </tr>-->                 
        <tr>
          <td width="144" id="subppal4">ANCHO(cm)</td>
          <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
            <td id="fuente2">
              <?php $var=mysql_result($ver_pl2,$l,N_ancho); echo $var; ?>		  </td><?php } ?>
            </tr>
            <tr>
              <td id="subppal4">ALTO(cm)</td>
              <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                <td id="fuente2">
                  <?php $var=mysql_result($ver_pl2,$l,N_alto); echo $var; ?>		  </td> <?php } ?>
                </tr>
                <tr>
                  <td id="subppal4">CALIBRE</td>
                  <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                    <td id="fuente2">
                      <?php $var=mysql_result($ver_pl2,$l,N_calibre); echo $var; ?>		  </td><?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">COLORES IMPRESION</td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,N_colores_impresion);if($var=='0'){echo 'SEGUN ARTE';} else {echo $var." COLORES";}?></td>
                      <?php } ?>
                    </tr>
                    <td id="subppal4">BOCA ENTRADA</td>
                    <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                      <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,Str_boca_entrada); echo $var; ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td id="subppal4">UBIC. ENTRADA</td>
                    <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                      <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,Str_ubica_entrada); echo $var; ?></td>
                    <?php } ?>
                  </tr>        
                  <tr>
                    <td id="subppal4">LAMINA 1</td>
                    <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                      <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,Str_lam1); echo $var; ?>		  </td><?php } ?>
                    </tr>
                    
                    <tr>
                      <td id="subppal4">LAMINA 2</td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,Str_lam2); echo $var; ?>		  </td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">INCOTERMS</td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,Str_incoterms); echo $var; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">CANTIDA SOLICITADA </td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,N_cantidad); echo $var; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">MONEDA DE NEGOCIACION </td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,Str_moneda); echo $var; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">PRECIO DE VENTA </td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,N_precio_vnta); echo $var; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">CANTIDAD SOLICITADA</td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,N_cantidad); echo $var; ?></td>
                      <?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">COSTO CYREL</td>
                      <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,B_cyreles); if($var=='0'){ echo "ACYCIA"; }else if($var=='1'){echo "SE LE FACTURA";}else if($var==''){echo "N.A";} ?></td><?php } ?>
                      </tr>
                      <tr>
                        <td id="subppal4">GENERICA</td>
                        <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                          <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,B_generica); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
                        <?php } ?>
                      </tr> 
                      <tr>
                        <td id="subppal4">ESTADO</td>
                        <?php  for ($l=0;$l<=$num52-1;$l++) { ?>
                          <td id="fuente2"><?php $var=mysql_result($ver_pl2,$l,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";} ?></td>
                        <?php } ?>
                      </tr>                      
                    </table>       
                  <?php }?>
                  <?php if($num32!='0')
                  { ?>
                    <table class="table table-bordered table-sm">
                      <tr>
                        <td width="144" colspan="<?php echo $num32+1; ?>" nowrap id="subppal2"><strong><!--<a href="cotizacion_g_lamina_vista.php?N_cotizacion=<?php echo $ref;?>&Str_nit=<?php echo $row_cotizacion_clienteref['nit_c']; ?>&tipo=<?php echo $row_usuario['tipo_usuario'] ?>">COTIZACION LAMINAS</a>-->COTIZACION LAMINAS</strong></td>
                      </tr>
                      <tr>
                        <td id="subppal4">REFERENCIA N&deg; </td>
                        <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                          <td id="fuente2"><?php 
                          $var=mysql_result($ver_lamina2,$j,N_referencia_c);
                          $var2=mysql_result($ver_lamina2,$j,N_cotizacion);
                          $var3=mysql_result($ver_lamina2,$j,Str_nit);
                          echo $linc="<a href='cotizacion_general_laminas_edit.php?N_cotizacion=$var2&amp;cod_ref=$var&amp;Str_nit=$var3&amp;tipo=$row_usuario[tipo_usuario]'><strong>".$var."</strong></a>";?></td>
                        <?php } ?>        
                      </tr> 
        <!--<tr>
          <td id="subppal4">VERSION</td>
          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
          <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,version_ref); echo $var; ?>		  </td><?php } ?>
        </tr>-->                  
        <tr>
          <td id="subppal4">ANCHO(cm) </td>
          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
            <td width="544" id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_ancho); echo $var; ?>		  </td><?php } ?>
          </tr>
          <tr>
            <td id="subppal4">REPETICION</td>
            <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
              <td id="fuente2">
                <?php $var=mysql_result($ver_lamina2,$j,N_repeticion); echo $var; ?>		  </td><?php } ?>
              </tr>
              <tr>
                <td id="subppal4">CALIBRE (micras) </td>
                <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                  <td id="fuente2">
                    <?php $var=mysql_result($ver_lamina2,$j,N_calibre); echo $var; ?>		  </td> <?php } ?>
                  </tr>
                  <tr>
                    <td id="subppal4">PESO MAX.</td>
                    <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                      <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_peso_max); echo $var; ?>		  </td><?php } ?>
                    </tr>
                    <tr>
                      <td id="subppal4">DIAMETRO MAX.</td>
                      <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                        <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_diametro_max); echo $var; ?>		  </td><?php } ?>
                      </tr>
                      <tr>
                        <td id="subppal4">COLORES IMPRESION</td>
                        <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                          <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_colores_impresion);if($var=='0'){echo 'SEGUN ARTE';} else {echo $var." COLORES";}?></td>
                        <?php } ?>
                      </tr> 
                      <tr>
                        <td id="subppal4">EMBOBINADO</td>
                        <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                          <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_embobinado); echo $var; ?>		  </td><?php } ?>
                        </tr>
                        <tr>
                          <td id="subppal4">INCOTERMS</td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,Str_incoterms); echo $var; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td id="subppal4">CANTIDAD (mts)</td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_cantidad_metros_r); echo $var; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td id="subppal4">CANTIDAD SOLICITADA</td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_cantidad); echo $var; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td id="subppal4">MONEDA DE NEGOCIACION </td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,Str_moneda); echo $var; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td id="subppal4">PRECIO POR KILO </td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,N_precio_k); echo $var; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td id="subppal4">COSTO CYREL</td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,B_cyreles); if($var=='0'){ echo "ACYCIA"; }else if($var=='1'){echo "SE LE FACTURA";}else if($var==''){echo "N.A";} ?></td><?php } ?>
                          </tr>               
                          <tr>
                           <td id="subppal4">GENERICA</td>
                           <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                             <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,B_generica); if($var=='1'){ echo "SI"; }else if($var=='0'){echo "NO";} ?></td>
                           <?php } ?>
                         </tr> 
                         <tr>
                          <td id="subppal4">ESTADO</td>
                          <?php  for ($j=0;$j<=$num32-1;$j++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_lamina2,$j,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";} ?></td>
                          <?php } ?>
                        </tr>      
                      </table>     
                    <?php }?>
                    <?php if($num72!='0')
                    { ?>
                      <table class="table table-bordered table-sm">
                        <tr>
                          <td width="160" colspan="<?php echo $num72+1; ?>" nowrap id="subppal2"><strong><!--<a href="cotizacion_g_materiap_vista.php?N_cotizacion=<?php echo $ref;?>&Str_nit=<?php echo $row_cotizacion_clienteref['nit_c']; ?>&tipo=<?php echo $row_usuario['tipo_usuario'] ?>">COTIZACION MATERIA PRIMA</a>-->
                          COTIZACION MATERIA PRIMA</strong></td>
                        </tr>
                        <tr>                    
                          <td id="subppal4">COTIZACION N&deg; </td>
                          <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                            <td id="fuente2"><?php
                            $var=mysql_result($ver_materia2,$m,N_referencia_c);
                            $var2=mysql_result($ver_materia2,$m,N_cotizacion);
                            $var3=mysql_result($ver_materia2,$m,Str_nit);
                            echo $linc="<a href='cotizacion_general_materia_prima_edit.php?N_cotizacion=$var2&amp;cod_ref=$var&amp;Str_nit=$var3&amp;tipo$row_usuario[tipo_usuario]'><strong>".$var2."</strong></a>";?></td>
                          <?php } ?>        
                        </tr>
                        <tr>
                          <td id="subppal4">REFERENCIA</td>
                          <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                            <td id="fuente2"><?php $var=mysql_result($ver_materia2,$m,Str_referencia); echo $var; ?></td>
                          <?php  } ?>
                        </tr>          
                        <tr>
                          <td id="subppal4">CANTIDAD(und)</td>
                          <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                            <td width="544"id="fuente2">
                              <?php $var=mysql_result($ver_materia2,$m,N_cantidad); echo $var; ?>		  </td><?php } ?>
                            </tr>
                            <tr>
                              <td id="subppal4">INCOTERMS</td>
                              <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                                <td id="fuente2">
                                  <?php $var=mysql_result($ver_materia2,$m,Str_incoterms); echo $var; ?>		  </td> <?php } ?>
                                </tr>
                                <tr>
                                  <td id="subppal4">PRECIO($)</td>
                                  <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                                    <td id="fuente2">
                                      <?php $var=mysql_result($ver_materia2,$m,Str_moneda); echo $var; ?>/<?php $var=mysql_result($ver_materia2,$m,N_precio_vnta); echo $var; ?></td><?php } ?>
                                    </tr>
                                    <tr>
                                      <td id="subppal4">FECHA</td>
                                      <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                                        <td id="fuente2"><?php $var=mysql_result($ver_materia2,$m,fecha_creacion); echo $var; ?></td><?php } ?>
                                      </tr>
                                      <tr>
                                        <td id="subppal4">UNIDAD DE VENTA</td>
                                        <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                                          <td id="fuente2">
                                           <?php $var=mysql_result($ver_materia2,$m,Str_unidad_vta); echo $var; ?>          </td>
                                         <?php } ?>
                                       </tr>
                                       <tr>
                                        <td id="subppal4">ESTADO</td>
                                        <?php  for ($m=0;$m<=$num72-1;$m++) { ?>
                                          <td id="fuente2">
                                            <?php $var=mysql_result($ver_materia2,$m,B_estado); if($var=='1'){ echo "ACEPTADA"; }else if($var=='0'){echo "PENDIENTE";}else if($var=='2'){echo "RECHAZADA";} ?></td>
                                          <?php } ?>
                                        </tr>                                 
                                      </table>       
                                      <?php }?></td>
                                    </tr>  
                                    <tr>  
                                      
                                      <!--aqui termina impresion por referencia-->
                                      <td id="justificar"><strong>IMPORTANTE</strong>:  Las cantidades entregadas pueden variar en +/- 10%. Los calibres en +/- 10% y en las dimensiones de la bolsa la variaci&oacute;n aceptada es de 10 mm.<br>
                                        <br>
                                        Las condiciones comerciales para la elaboraci&oacute;n de este pedido son:<br>
                                        1. Orden de compra debidamente aprobada incluyendo en ella este numero de cotizaci&oacute;n como se&ntilde;al de aprobaci&oacute;n de nuestros t&eacute;rminos y condiciones.<br>
                                        2. Arte aprobado y firmado.<br>
                                        3. El costo de los artes y cyreles se factura solo por una sola vez. Modificaciones al arte no son posibles hasta terminar con toda la producci&oacute;n acordada. En caso contrario cualquier modificaci&oacute;n acarrear&iacute;an nuevo cobro de elaboraci&oacute;n de artes y Cyreles.<br>
                                        4. El precio de venta hay que adicionarle el IVA correspondiente si aplica.<br>
                                        <br>
                                      Quedamos pendientes de sus comentarios al respecto y recuerde que el tiempo de entrega se empieza a contar desde la recepci&oacute;n de la orden de compra y/o del arte aprobado debidamente por parte del cliente.</td>
                                    </tr>
                                    <tr>
                                      <td id="justificar"><strong><?php echo $row_ver_texto['texto']; ?></strong></td>
                                    </tr>
                                    <tr>
                                      <td id="justificar"><strong>P.D.</strong>� Esta oferta es valida por 30 d&iacute;as siempre y cuando no cambien los costos de las materias primas de tal manera que afecten sensiblemente los costos.</td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            <table class="table table-bordered table-sm" align="center">
                              <tr>
                                <td id="noprint" align="center"><?php if($_GET['tipo']=='1') { ?><?php } ?>
                                
                                <?php if($_GET['tipo']=='1') { ?><a href="cotizacion_bolsa_add.php"><img src="images/mas.gif" alt="ADD COTIZACION"title="ADD COTIZACION" border="0" style="cursor:hand;"/></a><?php } ?><a href="cotizacion_copia.php"><img src="images/opciones.gif" style="cursor:hand;" alt="LISTADO COTIZACIONES"title="LISTADO COTIZACIONES" border="0" /></a><a href="menu.php"><img src="images/identico.gif" style="cursor:hand;" alt="MENU PRINCIPAL"title="MENU PRINCIPAL" border="0"/></a><a href="cotizacion_general_menu.php"><img src="images/salir.gif" style="cursor:hand;" alt="SALIR"title="SALIR" onclick="window.close() "/></a></td>
                              </tr>
                            </table>
                         <?php echo $conexion->header('footer'); ?>
</body>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($cliente);
mysql_free_result($cotizacion_cliente);
mysql_free_result($ver_bolsa);
mysql_free_result($ver_lamina);
mysql_free_result($ver_materia2);
mysql_free_result($ver_materia);
mysql_free_result($ver_pl);
mysql_free_result($edit_ref_b);
mysql_free_result($cotizacion_clienteref);
mysql_free_result($refe);
?>