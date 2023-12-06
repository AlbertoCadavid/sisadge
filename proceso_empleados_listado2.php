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
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
//FIN
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
$currentPage = $_SERVER["PHP_SELF"];

$conexion = new ApptivaDB();

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
$row_usuario = $conexion->buscar('usuario','usuario',$colname_usuario); 

$maxRows_proceso_empleado = 60;
$pageNum_proceso_empleado = 0;
if (isset($_GET['pageNum_empleado'])) {
  $pageNum_proceso_empleado = $_GET['pageNum_empleado'];
}
$startRow_proceso_empleado = $pageNum_proceso_empleado * $maxRows_proceso_empleado;


//VARIABLES PARA LAS NOVEDADES MENSUALES
$anual = $_GET['anual'];
$mensual = $_GET['mensual'];
$mes = $_GET['mensual'];
$estado = $_GET['estado_empleado'];
$dia1 = '01';
$dia2 = '30';
if($anual!=0){

   $mensual = $_GET['mensual']=='0' ? '01' :$_GET['mensual'];
   $mensual2 = $_GET['mensual']=='0' ? '12' :$_GET['mensual']; 
   $mes = $_GET['mensual']=='0' ? '01' : $_GET['mensual'];
   
   $fechaInicio=$anual."-".$mensual."-".$dia1;
   $fechaFin=$anual."-".$mensual2."-".$dia2;

}else{
  $anual=0;
}

 
 
if($anual =='0' && $mensual=='0' && $estado=='0')
{
   $rows_empleado = $conexion->buscarListar("empleado a INNER JOIN TblProcesoEmpleado b on a.codigo_empleado=b.codigo_empleado","*","ORDER BY a.codigo_empleado DESC","",$maxRows_proceso_empleado,$pageNum_proceso_empleado," WHERE b.estado_empleado='0'" );
} 
if($anual =='0' && $mensual=='0' && $estado=='2')
{

 $rows_empleado = $conexion->buscarListar("empleado a INNER JOIN TblProcesoEmpleado b on a.codigo_empleado=b.codigo_empleado","*","ORDER BY a.codigo_empleado DESC","",$maxRows_proceso_empleado,$pageNum_proceso_empleado,"" ); 
}
if($anual =='0' && $mensual=='0' && $estado=='1')
{
  $rows_empleado = $conexion->buscarListar("empleado a INNER JOIN TblProcesoEmpleado b on a.codigo_empleado=b.codigo_empleado","*","ORDER BY a.codigo_empleado DESC","",$maxRows_proceso_empleado,$pageNum_proceso_empleado," WHERE b.estado_empleado='1' " ); 
}
if($anual !='0' && $mensual=='0' && $estado=='2')
{
  $rows_empleado = $conexion->buscarListar("empleado a INNER JOIN TblProcesoEmpleado b on a.codigo_empleado=b.codigo_empleado","*","ORDER BY a.codigo_empleado DESC","",$maxRows_proceso_empleado,$pageNum_proceso_empleado," WHERE b.fechainicial_empleado BETWEEN '$fechaInicio' and '$fechaFin' " ); 

}
if($anual !='0' && $mensual!='0' && $estado!='2')
{
  $rows_empleado = $conexion->buscarListar("empleado a INNER JOIN TblProcesoEmpleado b on a.codigo_empleado=b.codigo_empleado","*","ORDER BY a.codigo_empleado DESC","",$maxRows_proceso_empleado,$pageNum_proceso_empleado," WHERE b.estado_empleado='$estado' AND b.fechainicial_empleado BETWEEN '$fechaInicio' and '$fechaFin' " ); 

}
if($anual !='0' && $mensual!='0' && $estado=='2')
{
  $rows_empleado = $conexion->buscarListar("empleado a INNER JOIN TblProcesoEmpleado b on a.codigo_empleado=b.codigo_empleado","*","ORDER BY a.codigo_empleado DESC","",$maxRows_proceso_empleado,$pageNum_proceso_empleado," WHERE b.fechainicial_empleado BETWEEN '$fechaInicio' and '$fechaFin' " );
} 

 

/*$query_limit_proceso_empleado = sprintf("%s LIMIT %d, %d", $query_proceso_empleado, $startRow_proceso_empleado, $maxRows_proceso_empleado);
$proceso_empleado = mysql_query($query_limit_proceso_empleado, $conexion1) or die(mysql_error());
$rows_empleado = mysql_fetch_assoc($proceso_empleado);*/
 
if (isset($_GET['totalRows_proceso_empleado'])) {
  $totalRows_proceso_empleado = $_GET['totalRows_proceso_empleado'];
} else {
  $totalRows_proceso_empleado = $conexion->conteo('empleado'); 
} 
$totalPages_proceso_empleado = ceil($totalRows_proceso_empleado/$maxRows_proceso_empleado)-1;
 
$queryString_proceso_empleado = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_proceso_empleado") == false && 
        stristr($param, "totalRows_proceso_empleado") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_proceso_empleado = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_proceso_empleado = sprintf("&totalRows_proceso_empleado=%d%s", $totalRows_proceso_empleado, $queryString_proceso_empleado);




mysql_select_db($database_conexion1, $conexion1);
$query_mensual = "SELECT * FROM mensual ORDER BY id_mensual DESC";
$mensual = mysql_query($query_mensual, $conexion1) or die(mysql_error());
$row_mensual = mysql_fetch_assoc($mensual);
$totalRows_mensual = mysql_num_rows($mensual);

mysql_select_db($database_conexion1, $conexion1);
$query_ano = "SELECT * FROM anual ORDER BY anual DESC";
$ano = mysql_query($query_ano, $conexion1) or die(mysql_error());
$row_ano = mysql_fetch_assoc($ano);
$totalRows_ano = mysql_num_rows($ano);

 
//FACTOR POR FECHA
mysql_select_db($database_conexion1, $conexion1);
if($anual !='0')
{
  $anual=$anual;
}else{
  $anual= date('Y');
}
  $query_factor = "SELECT * FROM TblFactorP WHERE YEAR(fecha_fp) = '$anual' ORDER BY fecha_fp DESC";
   $factor = mysql_query($query_factor, $conexion1) or die(mysql_error());
   $row_factor = mysql_fetch_assoc($factor);
   $totalRows_factor = mysql_num_rows($factor);


?>
<html>
<head>
  <title>SISADGE AC &amp; CIA</title>
  <link href="css/formato.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/listado.js"></script>
  <script type="text/javascript" src="js/formato.js"></script>

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

</head>
<body>
    <div align="center">
      <table style="width: 80%"><!-- id="tabla1" -->
        <tr>
         <td align="center">
           <div class="row-fluid">
             <div class="span8 offset2"> <!--span8 offset2   esto da el tamaño pequeño -->
               <div class="panel panel-primary">
                <div class="panel-heading" align="left" ></div><!--color azul-->
                <div class="row" >
                    <div class="span12">&nbsp;&nbsp;&nbsp; <img src="images/cabecera.jpg"></div> 
                </div>
                <div class="panel-heading" align="left" ></div><!--color azul-->
                 <div id="cabezamenu">
                  <ul id="menuhorizontal">
                    <li id="nombreusuario" ><?php echo $_SESSION['Usuario']; ?></li>
                    <li><a href="<?php echo $logoutAction ?>">CERRAR SESION</a></li>
                    <li><a href="menu.php">MENU PRINCIPAL</a></li>
                    <li><a href="costos_generales.php">COSTOS GENERALES</a></li>
                  </ul>
               </div> 
               <div class="panel-body">
                 <br> 
                 <div class="container">
                  <div class="row">
                    <div class="span12"> 
               </div>
             </div>

                  <form action="proceso_empleados_listado2.php" method="get" name="consulta">
                  <table id="tabla3">
                    <tr>
                      <td colspan="8" id="subtitulo">LISTADO DE EMPLEADOS DE PLANTA</td>
                    </tr>
                    <tr>
                      <td colspan="8" id="fuente2">Fecha Inicial
                        <select name="anual" id="anual">
                          <option value="0"<?php if (!(strcmp("", $_GET['anual']))) {echo "selected=\"selected\"";} ?>>ANUAL</option>
                          <?php
                          do {  
                            ?>
                            <option value="<?php echo $row_ano['anual']?>"<?php if (!(strcmp($row_ano['anual'], $_GET['anual']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ano['anual']?></option>
                            <?php
                          } while ($row_ano = mysql_fetch_assoc($ano));
                          $rows = mysql_num_rows($ano);
                          if($rows > 0) {
                            mysql_data_seek($ano, 0);
                            $row_ano = mysql_fetch_assoc($ano);
                          }
                          ?>
                        </select>
                        <select name="mensual" id="mensual">
                          <option value="0"<?php if (!(strcmp("", $_GET['mensual']))) {echo "selected=\"selected\"";} ?>>MENSUAL</option>
                          <?php
                          do {  
                            ?>
                            <option value="<?php echo $row_mensual['id_mensual']?>"<?php if (!(strcmp($row_mensual['id_mensual'], $_GET['mensual']))) {echo "selected=\"selected\"";} ?>><?php echo $row_mensual['mensual']?></option>
                            <?php
                          } while ($row_mensual = mysql_fetch_assoc($mensual));
                          $rows = mysql_num_rows($mensual);
                          if($rows > 0) {
                            mysql_data_seek($mensual, 0);
                            $row_mensual = mysql_fetch_assoc($mensual);
                          }
                          ?>
                        </select>
                        <select name="estado_empleado" id="estado_empleado">
                         <option value="2" <?php if (!(strcmp(2, $_GET['estado_empleado']))) {echo "selected=\"selected\"";} ?>>Todos</option>
                         <option value="0" <?php if (!(strcmp(0, $_GET['estado_empleado']))) {echo "selected=\"selected\"";} ?>>Inactivo</option>
                         <option value="1" <?php if (!(strcmp(1, $_GET['estado_empleado']))) {echo "selected=\"selected\"";} ?>>Activo</option>
                       </select>
                       <input class="botonUpdate" type="submit" name="Submit" value="FILTRO"/>
                       <input type="button" value="Excel Completo" onClick="window.location = 'proceso_empleados_listado_excel.php?id_todo=1'" />
                       <input type="button" value="Excel Fecha"  onClick="window.location = 'proceso_empleados_listado_excel.php?id_todo=2&anual=<?php echo $anual; ?>&mensual=<?php echo $mes; ?>&estado=<?php echo $estado; ?>'"/> 
                     </td>
                   </tr>
                 </table>
               </form>
               <table id="tabla3">
                <tr>
                  <td colspan="11" id="fuente1"><!--<input name="" type="submit" value="Delete"/>--><strong>Nota:</strong> consulte por año y mes para poder visualizar los cambios de aporter y recargos correspondientes a la fecha, recuerde tener actualizados los factores</td>
                  <td colspan="4" id="fuente3"><a href="empleado_add.php"><img src="images/mas.gif" alt="ADD EMPLEADO" title="ADD EMPLEADO" border="0" style="cursor:hand;"></a><a href="factor_prestacional_add.php"><img src="images/f.gif" alt="FACTORES" title="FACTORES" border="0" style="cursor:hand;"></a><a href="empleado_tipo.php"><img src="images/p.gif" title="CARGO" alt="CARGO" border="0" style="cursor:hand;"></a><a href="turnos.php"><img src="images/t.gif" style="cursor:hand;" alt="TURNOS" title="TURNOS" border="0"/></a><a href="javascript:location.reload()"><img src="images/ciclo1.gif" alt="CARGAR LISTADO" title="CARGAR LISTADO" border="0" style="cursor:hand;"/></a></td>
                </tr>
                <tr id="tr1">
                  <td id="titulo4">CODIGO</td>
                  <td id="titulo4">NOMBRE APELLIDO</td>
                  <td id="titulo4">CARGO</td>
                  <?php if(in_array($_SESSION['id_usuario'], $_SESSION['usuariosarrayrRHH'])):?>
                  <td id="titulo4">SUELDO</td>
                  <td id="titulo4">RECARGOS</td>
                  <td id="titulo4">APORTES</td>
                  <td id="titulo4">COSTO MES</td>
                  <td id="titulo4">VALOR HORA</td>
                  <?php endif;?>
                  <td id="titulo4">DIAS NOVEDAD</td>
                  <td id="titulo4"> DIAS LABORADOS</td>
                  <td id="titulo4">FECHA INICIAL</td>
                  <td id="titulo4">FECHA RETIRO</td>
                  <td id="titulo4">EMPRESA</td>
                  <td id="titulo4">NOVEDADES</td>
                  <td id="titulo4">ESTADO</td>
                </tr>
                <?php foreach($rows_empleado as $rows_empleado) {  ?>
                  <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
                    <td id="dato1"><a href="empleado_edit.php?id_empleado=<?php echo $rows_empleado['id_empleado']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $rows_empleado['codigo_empleado'];?></a></td>
                    <td nowrap id="dato1"><a href="empleado_edit.php?id_empleado=<?php echo $rows_empleado['id_empleado']; ?>" target="_top" style="text-decoration:none; color:#000000">
                      <?php $codigo_empleado=$rows_empleado['codigo_empleado']; 	
                      $sqlemp="SELECT nombre_empleado, apellido_empleado FROM empleado WHERE codigo_empleado='$codigo_empleado'";
                      $resultemp=mysql_query($sqlemp); $numemp=mysql_num_rows($resultemp);
                      if ($numemp>='1') { 
                       $nombre_empleado=mysql_result($resultemp,0,'nombre_empleado');$apellido_empleado=mysql_result($resultemp,0,'apellido_empleado');  
                       echo $nombre_empleado." ".$apellido_empleado; }?>
                     </a></td>
                     <td nowrap id="dato1"><a href="empleado_edit.php?id_empleado=<?php echo $rows_empleado['id_empleado']; ?>" target="_top" style="text-decoration:none; color:#000000">
                      <?php 
                      $cargo_empleado=$rows_empleado['codigo_empleado'];
                      $sqlempt="SELECT empleado.empresa_empleado,empleado.tipo_empleado,empleado_tipo.nombre_tipo_empleado FROM empleado,empleado_tipo WHERE empleado.codigo_empleado=$cargo_empleado AND empleado_tipo.id_empleado_tipo=empleado.tipo_empleado";
                      $resultempt=mysql_query($sqlempt); 
                      $numempt=mysql_num_rows($resultempt);
                      if ($numempt>='1') { 
                       $empresa_empleado=mysql_result($resultempt,0,'empleado.empresa_empleado');
                       $cargo_empleado=mysql_result($resultempt,0,'empleado_tipo.nombre_tipo_empleado'); echo $cargo_empleado;  
                     }
                     ?>
                   </a></td>
                   <?php if(in_array($_SESSION['id_usuario'], $_SESSION['usuariosarrayrRHH'])):?>
                   <td id="dato3">
                    <a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo numeros_format($rows_empleado['sueldo_empleado']);$totalsueldo+=$rows_empleado['sueldo_empleado'];?></a>
                  </td>
                   <td id="dato3"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000">
                    <?php $novedades=$rows_empleado['codigo_empleado']; 	
                    $sqlrecargos="SELECT SUM(pago_acycia) AS valoracycia, SUM(pago_eps) AS valoreps, SUM(dias_incapacidad) as dias,SUM(dias_faltantes) as diasf, SUM(horas_extras) as horas,SUM(recargos) as recargos,SUM(festivos) as festivos
                    FROM TblNovedades
                    WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND codigo_empleado=$novedades";
                    $resultrecargos=mysql_query($sqlrecargos); 
                    $numrecargos=mysql_num_rows($resultrecargos);
                    if ($numrecargos >='1') {
                      $valoracycia=mysql_result($resultrecargos,0,'valoracycia'); 
                      $valoreps=mysql_result($resultrecargos,0,'valoreps');
                      $dias_incapacidad=mysql_result($resultrecargos,0,'dias');
                      $dias_falto=mysql_result($resultrecargos,0,'diasf'); 
                      $horas=mysql_result($resultrecargos,0,'horas');
                      $recargos=mysql_result($resultrecargos,0,'recargos'); 
                      $festivos=mysql_result($resultrecargos,0,'festivos');
                      $pagoIncapacidad=$valoracycia;
                      $total_recargos = $horas+$recargos+$festivos; 
                      echo $total_recargos;
                      $totalrecargo+=$total_recargos;
                    }?>
                  </a></td>
                  <td id="dato3"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000">
                    <?php 	
                    $codigo_aporte=$rows_empleado['codigo_empleado'];
                    $sqlaport="SELECT total FROM TblAportes WHERE codigo_empl=$codigo_aporte";
                    $resultaport=mysql_query($sqlaport); 
                    $numaport=mysql_num_rows($resultaport);
                    if ($numaport>='1') { 
                     $aport=mysql_result($resultaport,0,'total');  
                     echo $aport; $totalaporte+=$aport; }
                     ?></a></td>
                     <td id="dato3"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php 
	//sueldo mes
	//variables de control
                     $sueld=$rows_empleado['sueldo_empleado'];	
                     $aux_trans=$rows_empleado['aux_empleado'];
                     $diasmes = $rows_empleado['dias_empleado']-($dias_falto+$dias_incapacidad);	
                     $subsueldo = ($sueld+$aux_trans)/$rows_empleado['dias_empleado'];	
                     $costomes=$subsueldo * $diasmes;  
                     $costoMesNeto = sumar($total_recargos,$aport,$costomes,0);
                     echo numeros_format($costoMesNeto);	$totalmes+=$costoMesNeto;
                     ?></a>
                     </td>
                     <td id="dato3"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000">
                      <?php 
	                          $costo_hora = $costoMesNeto/$row_factor['hora_lab_fp']; //para saber costo por hora
	                         echo redondear_entero_puntos($costo_hora) ?></a>                   
                    </td>
              <?php endif;?>

<td id="dato2"><?php if($dias_falto!=''){echo ($dias_falto+$dias_incapacidad);} else {echo 0;}?></td>
<td id="dato2"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000">
  <?php  echo $diasmes;?>
</a><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"></a><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"></a></td>
<td nowrap id="dato2"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $rows_empleado['fechainicial_empleado']; ?></a></td>
<td nowrap id="dato2"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $rows_empleado['fechafinal_empleado']; ?></a></td>
<td id="dato2"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000"><?php echo $empresa_empleado; ?></a></td>
<td id="dato2"><?php 
$novedades=$rows_empleado['codigo_empleado']; 
$fechaI=$_GET['anual'].'-'.$_GET['mensual'].'-'.'01';
$fechaF=last_month_day();	
$sqlnov="SELECT codigo_empleado FROM TblNovedades WHERE codigo_empleado=$novedades AND fecha BETWEEN '$fechaI' AND '$fechaF'";
$resultnov=mysql_query($sqlnov); $numnov=mysql_num_rows($resultnov);
if ($numnov >='1') { ?>
  <a href="javascript:popUp('novedades.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>&cod=<?php echo $rows_empleado['codigo_empleado']; ?>&fecha=<?php echo $fechaF; ?>','800','500')"><span class="rojo_normal"><em>VerNovedad</em></span></a>
  <?php
} else{?>
  <a href="javascript:popUp('novedades.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>&cod=<?php echo $rows_empleado['codigo_empleado']; ?>','800','500')"><em>AddNovedad</em></a>
  <?php } ?></td>
  <td id="dato2"><a href="proceso_empleado_edit.php?id_pem=<?php echo $rows_empleado['id_pem']; ?>" target="_top" style="text-decoration:none; color:#000000">
    <?php if($rows_empleado['estado_empleado']==0){echo "Inactivo";}else{echo "Activo";}?>
  </a></td>
</tr>
<?php } ?>
<tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
  <td id="dato4">&nbsp;</td>
  <td nowrap id="dato4">&nbsp;</td>
  <td nowrap id="dato4">&nbsp;</td>
  <td id="dato3"><?php echo number_format($totalsueldo, 2, ",", ".");?></td>
  <td id="dato3"><?php echo number_format($totalrecargo, 2, ",", ".");?></td>
  <td id="dato3"><?php echo number_format($totalaporte, 2, ",", ".");?></td>
  <td id="dato3"><?php echo number_format($totalmes, 2, ",", ".");?></td>
  <td id="dato3">&nbsp;</td>
  <td id="dato6">&nbsp;</td>
  <td id="dato6">&nbsp;</td>
  <td nowrap id="dato6">&nbsp;</td>
  <td nowrap id="dato6">&nbsp;</td>
  <td id="dato6">&nbsp;</td>
  <td id="dato6">&nbsp;</td>
  <td id="dato6">&nbsp;</td>
</tr>

</table>
<table id="tabla3">
  <tr>
    <td width="23%" align="center" id="dato2"><?php if ($pageNum_proceso_empleado > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_proceso_empleado=%d%s", $currentPage, 0, $queryString_proceso_empleado); ?>">Primero</a>
      <?php } // Show if not first page ?></td>
      <td width="31%" align="center" id="dato2"><?php if ($pageNum_proceso_empleado > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_proceso_empleado=%d%s", $currentPage, max(0, $pageNum_proceso_empleado - 1), $queryString_proceso_empleado); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
        <td width="23%" align="center" id="dato2"><?php if ($pageNum_proceso_empleado < $totalPages_proceso_empleado) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_proceso_empleado=%d%s", $currentPage, min($totalPages_proceso_empleado, $pageNum_proceso_empleado + 1), $queryString_proceso_empleado); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
          <td width="23%" align="center" id="dato2"><?php if ($pageNum_proceso_empleado < $totalPages_proceso_empleado) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_proceso_empleado=%d%s", $currentPage, $totalPages_proceso_empleado, $queryString_proceso_empleado); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page ?></td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
  <b class="spiffy"> <b class="spiffy5"></b> <b class="spiffy4"></b> <b class="spiffy3"></b> <b class="spiffy2"><b></b></b> <b class="spiffy1"><b></b></b></b></div></td>
</tr>
</table>
     </td>
   </tr> 
 </div> <!-- contenedor -->

  </div>
 </div>
 </div>
 </div>
 </td>
 </tr>
 </table> 
 </div>
</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($proceso_empleado);

mysql_free_result($mensual);

mysql_free_result($ano);
?>