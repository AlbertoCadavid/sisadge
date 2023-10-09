<?php require_once('Connections/conexion1.php'); ?>
<?php
header('Pragma: public'); 
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past    
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1 
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1 
header('Pragma: no-cache'); 
header('Expires: 0'); 
header('Content-Transfer-Encoding: none'); 
header('Content-Type: application/vnd.ms-excel'); // This should work for IE & Opera 
header('Content-type: application/x-msexcel'); // This should work for the rest 
header('Content-Disposition: attachment; filename="Control de Piso.xls"'); 
?>
<?php
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
//FIN
 
?>
 
<?php
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

mysql_select_db($database_conexion1, $conexion1);
$query_lista = "SELECT id_op FROM Tbl_orden_produccion ORDER BY id_op DESC";
$lista = mysql_query($query_lista, $conexion1) or die(mysql_error());
$row_lista = mysql_fetch_assoc($lista);
$totalRows_lista = mysql_num_rows($lista);

mysql_select_db($database_conexion1, $conexion1);
$query_ano = "SELECT * FROM anual ORDER BY anual DESC";
$ano = mysql_query($query_ano, $conexion1) or die(mysql_error());
$row_ano = mysql_fetch_assoc($ano);
$totalRows_ano = mysql_num_rows($ano);

mysql_select_db($database_conexion1, $conexion1);
$query_mensual = "SELECT * FROM mensual ORDER BY id_mensual DESC";
$mensual = mysql_query($query_mensual, $conexion1) or die(mysql_error());
$row_mensual = mysql_fetch_assoc($mensual);
$totalRows_mensual = mysql_num_rows($mensual);

$maxRows_fichas_tecnicas = 60000;
$pageNum_fichas_tecnicas = 0;
if (isset($_GET['pageNum_fichas_tecnicas'])) {
  $pageNum_fichas_tecnicas = $_GET['pageNum_fichas_tecnicas'];
}
$startRow_fichas_tecnicas = $pageNum_fichas_tecnicas * $maxRows_fichas_tecnicas;

mysql_select_db($database_conexion1, $conexion1);

$fechaI = $_GET['fechaI'];
$fechaI = explode('T',$fechaI);
$fechaI = $fechaI[0].' '.$fechaI[1];
$fechaF = $_GET['fechaF'];
$fechaF = explode('T',$fechaF);
$fechaF = $fechaF[0].' '.$fechaF[1];

$id_op = $_GET['id_op'];
$id_ref = $_GET['id_ref'];
$estado = $_GET['estado'];
$anos = $_GET['fecha'];
$mensuals = $_GET['mensual'];
$dia='01';
$fecha=$anos.'-'.$mensuals.'-'.$dia;

if($estado=='1'){
 $campo_fecha_estado = 'f_coextruccion';
 $baserollos = 'tblextruderrollo';
}else if($estado=='2'){
 $campo_fecha_estado = 'f_impresion';
 $baserollos = 'tblimpresionrollo';
}else if($estado=='4'){
 $campo_fecha_estado = 'f_sellada';
 $baserollos = 'tblselladorollo';
}else{
 $campo_fecha_estado = 'f_coextruccion';
 $baserollos = 'tblextruderrollo';
}

//Filtra todos vacios

if($id_op== '0' && $id_ref == '0' && $fechaF != '' && $estado != '')
{
  $query_fichas_tecnicas = "SELECT DISTINCT trp.id_op_rp AS id_op, trp.fecha_ini_rp, top.int_cod_ref_op,top.str_tipo_bolsa_op,top.b_estado_op FROM Tbl_orden_produccion as top 
   JOIN Tbl_reg_produccion as trp ON top.id_op=trp.id_op_rp 
   WHERE trp.id_proceso_rp='$estado' AND trp.fecha_ini_rp BETWEEN '$fechaI' AND '$fechaF' AND trp.fecha_fin_rp BETWEEN '$fechaI' AND '$fechaF' GROUP BY trp.id_op_rp ORDER BY top.id_op DESC";
}
if($id_op!= '0' && $id_ref == '0' && $fechaF != '' && $estado != '')
{
  $query_fichas_tecnicas = "SELECT DISTINCT trp.id_op_rp AS id_op, trp.fecha_ini_rp, top.int_cod_ref_op,top.str_tipo_bolsa_op,top.b_estado_op FROM Tbl_orden_produccion as top 
   JOIN Tbl_reg_produccion as trp ON top.id_op=trp.id_op_rp 
   WHERE trp.id_proceso_rp='$estado' AND top.id_op='$id_op' AND trp.fecha_ini_rp BETWEEN '$fechaI' AND '$fechaF' AND trp.fecha_fin_rp BETWEEN '$fechaI' AND '$fechaF' GROUP BY trp.id_op_rp ORDER BY top.id_op DESC ";
}
if($id_op== '0' && $id_ref != '0' && $fechaF != '' && $estado != '')
{
  $query_fichas_tecnicas = "SELECT DISTINCT trp.id_op_rp AS id_op, trp.fecha_ini_rp, top.int_cod_ref_op,top.str_tipo_bolsa_op,top.b_estado_op FROM Tbl_orden_produccion as top 
   JOIN Tbl_reg_produccion as trp ON top.id_op=trp.id_op_rp 
   WHERE trp.id_proceso_rp='$estado' AND top.id_ref_op='$id_ref' AND trp.fecha_ini_rp BETWEEN '$fechaI' AND '$fechaF' AND trp.fecha_fin_rp BETWEEN '$fechaI' AND '$fechaF' GROUP BY trp.id_op_rp ORDER BY top.id_op DESC ";
}
if($id_op!= '0' && $id_ref != '0' && $fechaF != '' && $estado != '')
{
  $query_fichas_tecnicas = "SELECT DISTINCT trp.id_op_rp AS id_op, trp.fecha_ini_rp, top.int_cod_ref_op,top.str_tipo_bolsa_op,top.b_estado_op FROM Tbl_orden_produccion as top 
   JOIN Tbl_reg_produccion as trp ON top.id_op=trp.id_op_rp 
   WHERE trp.id_proceso_rp='$estado' AND top.id_op='$id_op' AND top.id_ref_op='$id_ref' AND trp.fecha_ini_rp BETWEEN '$fechaI' AND '$fechaF' AND trp.fecha_fin_rp BETWEEN '$fechaI' AND '$fechaF' GROUP BY trp.id_op_rp ORDER BY top.id_op DESC ";
}

//$query_limit_fichas_tecnicas = sprintf("%s LIMIT %d, %d", $query_fichas_tecnicas, $startRow_fichas_tecnicas, $maxRows_fichas_tecnicas);
$fichas_tecnicas = mysql_query($query_fichas_tecnicas, $conexion1) or die(mysql_error());
$row_consumo = mysql_fetch_assoc($fichas_tecnicas);

if (isset($_GET['totalRows_fichas_tecnicas'])) {
  $totalRows_fichas_tecnicas = $_GET['totalRows_fichas_tecnicas'];
} else {
  $all_fichas_tecnicas = mysql_query($query_fichas_tecnicas);
  $totalRows_fichas_tecnicas = mysql_num_rows($all_fichas_tecnicas);
}
$totalPages_fichas_tecnicas = ceil($totalRows_fichas_tecnicas/$maxRows_fichas_tecnicas)-1;

$queryString_fichas_tecnicas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fichas_tecnicas") == false && 
      stristr($param, "totalRows_fichas_tecnicas") == false) {
      array_push($newParams, $param);
  }
}
if (count($newParams) != 0) {
  $queryString_fichas_tecnicas = "&" . htmlentities(implode("&", $newParams));
}
}
$queryString_fichas_tecnicas = sprintf("&totalRows_fichas_tecnicas=%d%s", $totalRows_fichas_tecnicas, $queryString_fichas_tecnicas);

?> 
<table id="tabla1" border="2">
 <tr>
   <td id="subtitulo">LISTADO DE COSTOS</td>
 </tr>
 
</table>

<p></p>
<table id="tabla1"  border="2">
  <tr>
    <?php if($estado=='1'): ?>
      <td colspan="7" id="dato1">EXTRUSION </td>
      <td colspan="7" id="dato1">COSTO (las columnas con palabra costo es porque tienen gastos de nomida etc) </td>
      <?php elseif($estado=='2'): ?>
      <td colspan="7" id="dato1">IMPRESION</td>
      <td colspan="7" id="dato1">COSTO (las columnas con palabra costo es porque tienen gastos de nomida etc) </td>
      <?php elseif($estado=='4'): ?>
      <td colspan="7" id="dato1">SELLADO</td> 
      <td colspan="7" id="dato1">COSTO (las columnas con palabra costo es porque tienen gastos de nomida etc) </td>
      <?php endif; ?>

      </tr>  
      <tr id="tr1">
       <td nowrap="nowrap"  id="titulo4">O.P</td>
       <td nowrap="nowrap" id="titulo4">-Ref-</td>
       <td nowrap="nowrap" id="titulo4">Tipo de bolsa</td>
       <td nowrap="nowrap" id="titulo4">Bolsas Selladas</td>
       <td nowrap="nowrap" id="titulo4">Fecha Creacion</td>
       <?php if($estado=='1'): ?>
        <td nowrap="nowrap" id="titulo4">Kilos Extruder</td>
        <td nowrap="nowrap" id="titulo4">$ Valor kilo MP </td>
        <td nowrap="nowrap" id="titulo4">Hora de Ext</td>
        <td nowrap="nowrap" id="titulo4">Desperdicio Extruder</td> 
        <td nowrap="nowrap" id="titulo4">Desperdicios de Montaje</td>
        <td nowrap="nowrap" id="titulo4">$ Costo kilo Extruder</td>
        <?php elseif($estado=='2'): ?>
          <td nowrap="nowrap" id="titulo4">IMPRESIÓN (Kilos)</td>
          <td nowrap="nowrap" id="titulo4">$ Valor Total Insumos Impr.</td>
          <td nowrap="nowrap" id="titulo4">Hora de Impr.</td>
          <td nowrap="nowrap" id="titulo4">Desperdicio Extruder</td>
          <td nowrap="nowrap" id="titulo4">Desperdicios de Montaje</td>
          <td nowrap="nowrap" id="titulo4">$ Costo kilo Impresion </td>
          <td nowrap="nowrap" id="titulo4">Colores</td>
          <?php elseif($estado=='4'): ?>
            <td nowrap="nowrap" id="titulo4">kilo Inicial Sellado </td>
            <td nowrap="nowrap" id="titulo4">$ Costo MP Sellado</td>
            <td nowrap="nowrap" id="titulo4">Hora de Sellado</td>
            <td nowrap="nowrap" id="titulo4">Desperdicio Sellado</td> 
            <td nowrap="nowrap" id="titulo4">$ Costo Materia Prima sellado</td>
            <td nowrap="nowrap" id="titulo4">$ Costo kilo Sellado</td> 
            <td nowrap="nowrap" id="titulo4">Reproceso</td>
            <td nowrap="nowrap" id="titulo4">$ Costo Bolsa</td>
            <td nowrap="nowrap" id="titulo4">$ Precio Venta Und. </td>
            <td nowrap="nowrap" id="titulo4">Rentabilidad</td>
          <?php endif; ?> 
          <!-- <td nowrap="nowrap" id="titulo4">$ Costo x Proceso</td>  -->
          <td nowrap="nowrap" id="titulo4">Estado en OP</td>
          <!-- excel explicito Piso -->
          <td nowrap="nowrap" id="titulo4">Ancho Lamina extrusión </td>
          <td nowrap="nowrap" id="titulo4">Porcentaje desperdicio </td>
          <td nowrap="nowrap" id="titulo4">Kilos Programados </td>
          <td nowrap="nowrap" id="titulo4">Metros programados </td>
          <td nowrap="nowrap" id="titulo4">Bolsas Programadas </td>
          <td nowrap="nowrap" id="titulo4">NUMERACION INICIAL </td>
          <td nowrap="nowrap" id="titulo4">NUMERACION FINAL </td>
           
          <?php $resultMotivos = mysql_query("SELECT trtd.nombre_rtp FROM `tbl_reg_tipo_desperdicio` as trtd LEFT JOIN `tbl_reg_desperdicio` AS trd ON trtd.id_rtp = trd.id_rpd_rd WHERE trtd.id_proceso_rtd ='$estado' GROUP BY trd.id_rpd_rd order by trtd.nombre_rtp asc");
          while ($rowMotivos = mysql_fetch_array($resultMotivos)) {?>
            <td nowrap="nowrap"><?php echo $rowMotivos['nombre_rtp'] ==''? 'No hay Nombre': $rowMotivos['nombre_rtp']; ?></td>
          <?php }  ?>
          <!-- <td nowrap="nowrap" id="titulo4">Desperdicio Extruder</td>
          <td nowrap="nowrap" id="titulo4">Desperdicio Montaje</td> -->
          <td nowrap="nowrap" id="titulo4">Kilos Reales </td>
          <td nowrap="nowrap" id="titulo4">Metros Lineales </td>
          <td nowrap="nowrap" id="titulo4"># ROLLOS </td>
          <td nowrap="nowrap" id="titulo4">Código del Operario </td>
          <td nowrap="nowrap" id="titulo4">Horas del Proceso </td>
          <td nowrap="nowrap" id="titulo4">Tiempo muerto </td>
          <td nowrap="nowrap" id="titulo4">Tiempo mecanico </td>
          <td nowrap="nowrap" id="titulo4">Tiempo Preparacion </td>
          <td nowrap="nowrap" id="titulo4">Sin Materia Prima </td>
          <td nowrap="nowrap" id="titulo4">Reviente </td>
          <td nowrap="nowrap" id="titulo4">Calentamiento de resistencias </td>
          <td nowrap="nowrap" id="titulo4">Montaje </td>
          <td nowrap="nowrap" id="titulo4">$ VALOR KILO/MP </td>
          <td nowrap="nowrap" id="titulo4">Maquina </td>
          <td nowrap="nowrap" id="titulo4">Periodo Ejecución </td>
        </tr>
        <?php do { ?>
          <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF">
            <td id="dato3"><?php echo $row_consumo['id_op']; ?>
          </td>
          <td id="dato3"><?php echo $row_consumo['int_cod_ref_op']; ?>
        </td>
        <td id="dato1" nowrap><?php echo $row_consumo['str_tipo_bolsa_op'];?>
      </td>
      <td id="dato3">
       <?php 
       $id_op=$row_consumo['id_op']; 
       $sqlex="SELECT SUM(bolsa_rp) AS bolsa_rp, SUM(int_metro_lineal_rp) AS int_metro_lineal_rp FROM Tbl_reg_produccion WHERE `id_op_rp`='$id_op' AND id_proceso_rp = '4'"; 
       $resultex=mysql_query($sqlex); 
       $numex=mysql_num_rows($resultex); 
       if($numex >= '1') 
       { 
        $metros_imp = mysql_result($resultex,0,'int_metro_lineal_rp'); 
        echo $bolsas_sell=mysql_result($resultex,0,'bolsa_rp'); //bolsas selladas
      }else{
        echo $bolsas_sell = "0";
        $metros_imp = '0';
      } 
      ?>
    </td>
    <td id="dato3"><?php $fechacreacion = explode(' ',$row_consumo['fecha_ini_rp']); echo $fechacreacion[0];  ?>  

      <?php 
      //kilos utilizados
       $id_op=$row_consumo['id_op'];
       $sqlexk="SELECT SUM(valor_prod_rp) AS kilosT FROM Tbl_reg_kilo_producido WHERE op_rp='$id_op' AND id_proceso_rkp='1'"; 
       $resultexk=mysql_query($sqlexk); 
       $numexk=mysql_num_rows($resultexk); 
       if($numexk >= '1') 
       { 
          $tkilos_ex=mysql_result($resultexk,0,'kilosT'); //kilos de extrusion 
       }
     
      $sqlCMP="SELECT valor_prod_rp, costo_mp FROM  Tbl_reg_kilo_producido WHERE id_proceso_rkp='1' AND op_rp = '$id_op'"; 
      $resultCMP=mysql_query($sqlCMP); 
      $numCMP=mysql_num_rows($resultCMP); 
      $row_CMP = mysql_fetch_assoc($resultCMP);
      $valorTE=0;
      do{
       $undMP = $row_CMP['valor_prod_rp'];
       $CMP = $row_CMP['costo_mp'];
       $valorMP=$undMP*$CMP;
           $valorTE+=$valorMP;//ACUMULA VALOR POR ITEM 
         } while ($row_CMP = mysql_fetch_assoc($resultCMP));
        $kiloValorMP = ($valorTE/$tkilos_ex);  //valor kilo MP 
       ?>

       <?php 
         $id_op=$row_consumo['id_op'];
            $sqlexh="SELECT total_horas_rp AS horasT, costo AS costo, str_maquina_rp as maquina_ext, fecha_ini_rp as fechaEjecucionExt FROM Tbl_reg_produccion WHERE id_op_rp='$id_op' AND id_proceso_rp = '$estado'"; 
            $resultexh=mysql_query($sqlexh); 
            $numexh=mysql_num_rows($resultexh); 
             if($numexh >= '1') 
                  { 
                    $tHoras_ex=mysql_result($resultexh,0,'horasT');//horas normal 00:00
                    $costo_ex=mysql_result($resultexh,0,'costo');
                    $maquina_ext = mysql_result($resultexh,0,'maquina_ext');
                    $fechaEjecucionExt = mysql_result($resultexh,0,'fechaEjecucionExt');   
                    $horas_ext = horadecimalUna($tHoras_ex);  //hora de extruder decimales 0.1
                 } 
         ?>
         <?php 
                  $id_op=$row_consumo['id_op'];
                  $sqlexd="SELECT SUM(valor_desp_rd) AS kgDespe FROM Tbl_reg_desperdicio WHERE op_rd='$id_op' AND id_proceso_rd='1'"; 
                  $resultexd=mysql_query($sqlexd); 
                  $numexd=mysql_num_rows($resultexd); 
                  if($numexd >= '1') 
                  {
                   $kilos_DESPERDICIO = mysql_result($resultexd,0,'kgDespe');//desperdicio extruder
                 } 
        ?> 
        <?php 
                 $sqlrtd="SELECT SUM(valor_desp_rd) AS kgMontajes FROM tbl_reg_desperdicio WHERE op_rd='$id_op' and id_rpd_rd='29' and id_proceso_rd='1'";
                 $resultrtd= mysql_query($sqlrtd);
                 $numrtd= mysql_num_rows($resultrtd);
                 if($numrtd >='1')
                 {
                   $kilos_exMontaje=mysql_result($resultrtd,0,'kgMontajes');
                 }else{
                   $kilos_exMontaje = 0;//Desperdicio Montaje
                 }
        ?> 

      </td>
      

  <!-- Inicio de Extrusion -->
  <?php if($estado=='1'): ?>
     <td id="dato3">  <?php echo numeros_format($tkilos_ex==''?'0':$tkilos_ex); ?></td>
     <td id="dato3">  <?php echo numeros_format($kiloValorMP); ?></td>
     <td id="dato3">  <?php echo $horas_ext; ?> </td>
     <td id="dato3">  <?php echo numeros_format($kilos_DESPERDICIO);?> <!-- desperdicio extruder --> </td>
     <td id="dato3">  <?php echo numeros_format($kilos_exMontaje);//de extruder  ?> </td>  
     <td id="dato3">
      <strong><?php //echo $costo_ex;
      if($tkilos_ex !='')
      {
        $sqlextru="SELECT COUNT(DISTINCT rollo_r) AS rollos, DATE_FORMAT(fechaI_r,'%Y-%m-%d') AS FECHA, SUM(metro_r) AS metros,SUM(kilos_r) AS kilos FROM $baserollos WHERE id_op_r='$id_op' ORDER BY fechaI_r ASC"; 
        $resultextru=mysql_query($sqlextru); 
        $numextru=mysql_num_rows($resultextru); 
        if($numextru >= '1') 
        { 
          $FECHA_NOVEDAD_EXT=mysql_result($resultextru,0,'FECHA');
        } 
      $sqlgeneral="SELECT * FROM `TblDistribucionHoras` ORDER BY `fecha` DESC LIMIT 1";//ORDER BY fecha DESC
      $resultgeneral= mysql_query($sqlgeneral);
      $numgeneral= mysql_num_rows($resultgeneral);
    //PARA TODOS LOS PROCESOS
      if($numgeneral >='1')
      { 
       $TiempomeExt =  mysql_result($resultgeneral, 0, 'extrusion');
      //EXTRUDER
       $costoUnHGga_ext = mysql_result($resultgeneral, 0, 'gga_ext');
       $costoUnHCif_ext = mysql_result($resultgeneral, 0, 'cif_ext');
       $costoUnHGgv_ext = mysql_result($resultgeneral, 0, 'ggv_ext');
       $costoUnHGgf_ext = mysql_result($resultgeneral, 0, 'ggf_ext');
       $cifyggaExt=($costoUnHGga_ext+$costoUnHCif_ext+$costoUnHGgv_ext+$costoUnHGgf_ext);
     }else{$TiempomeExt='0';} 

  //SUELDOS DE TODOS LOS EMPLEADOS FUERA DE PROCESO 
     $sqlbasicoExt="SELECT COUNT(a.codigo_empleado) AS operarios,(a.horas_empleado) AS HORADIA, SUM(b.sueldo_empleado) AS SUELDO, SUM(b.aux_empleado) AS AUXILIO, SUM(c.total) AS APORTES
     FROM empleado a 
     LEFT JOIN TblProcesoEmpleado b ON a.codigo_empleado=b.codigo_empleado  
     LEFT JOIN TblAportes c ON a.codigo_empleado=c.codigo_empl 
WHERE b.estado_empleado='1' AND a.tipo_empleado NOT IN(4,5,6,7,8,9,10)";//NOT IN(4,5,6,7,8,9,10) son los que estan fuera de los procesos SE AGREGO b.estado_empleado='1' AND
$resultbasicoExt=mysql_query($sqlbasicoExt);
$operario_ext_demas=mysql_result($resultbasicoExt,0,'operarios');
  $sueldo_basExt=mysql_result($resultbasicoExt,0,'SUELDO'); //sueldos del mes 
  $auxilio_basExt=mysql_result($resultbasicoExt,0,'AUXILIO'); //auxilios trans del mes    
  $aportes_basExt=mysql_result($resultbasicoExt,0,'APORTES'); //aportes del mes 
  //$horasmes_bas=mysql_result($resultbasico,0,'HORASMES');//LO EQUIVALENTE A LAS HORAS QUE SE TRABAJAN EN UN MES REAL 186,6666667 SE ENCUENTRA EN FACTOR
  $operarios_basExt=mysql_result($resultbasicoExt,0,'operarios');//CANTIDAD DE OPERARIOS 
  $horasdia_basExt=mysql_result($resultbasicoExt,0,'HORADIA');//esto es 8 

  //NOVEDAD DE TODOS LOS EMPLEADOS FUERA DE PROCESO 
  $sqlnovbasicoExt="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
  FROM empleado a 
  LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
WHERE a.tipo_empleado NOT IN(4,5,6,7,8,9,10) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_EXT', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_EXT', '%Y-%m-31')";//NOT IN(4,5,6,7,8,9,10) son los que estan fuera de los procesos
$resultnovbasicoExt=mysql_query($sqlnovbasicoExt);  
$pago_novbasicoExt=mysql_result($resultnovbasicoExt,0,'pago'); 
$extras_novbasicoExt=mysql_result($resultnovbasicoExt,0,'extras');  
$recargo_novbasicoExt=mysql_result($resultnovbasicoExt,0,'recargo');
$festivo_novbasicoExt=mysql_result($resultnovbasicoExt,0,'festivos');
  $horasmes_Ext='240';//240 mientras se define horas al mes
  //OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
  $valorhoraxoperExtDemas = sueldoMes($sueldo_basExt,$auxilio_basExt,$aportes_basExt,$horasmes_Ext,$horasdia_basExt,$recargo_novbasicoExt,$festivo_novbasicoExt); 
  $valorHoraExtDemas  = ($valorhoraxoperExtDemas/$operario_ext_demas)/3;//total H se divide por # de operarios de fuera de los procesos  

    //SUELDOS DE TODOS LOS EMPLEADOS DENTRO DE EXTRUSION 
  $sqlbasicoExt="SELECT COUNT(a.codigo_empleado) AS operarios,(a.horas_empleado) AS HORADIA, SUM(b.sueldo_empleado) AS SUELDO, SUM(b.aux_empleado) AS AUXILIO, SUM(c.total) AS APORTES
  FROM empleado a 
  LEFT JOIN TblProcesoEmpleado b ON a.codigo_empleado=b.codigo_empleado  
  LEFT JOIN TblAportes c ON a.codigo_empleado=c.codigo_empl 
WHERE b.estado_empleado='1' AND a.tipo_empleado IN(4)";//IN(4) son extrusion
$resultbasicoExt=mysql_query($sqlbasicoExt);
$operario_Ext=mysql_result($resultbasicoExt,0,'operarios');
  $sueldo_basExt=mysql_result($resultbasicoExt,0,'SUELDO'); //sueldos del mes 
  $auxilio_basExt=mysql_result($resultbasicoExt,0,'AUXILIO'); //auxilios trans del mes    
  $aportes_basExt=mysql_result($resultbasicoExt,0,'APORTES'); //aportes del mes 
  $horasdia_basExt=mysql_result($resultbasicoExt,0,'HORADIA');//esto es 8 
  $horasmes_Ext='240';//240 mientras se define horas al mes
   //FIN   
   //NOVEDAD DE ESE MES DE TODOS LOS EMPLEADOS DENTRO DE EXTRUSION 
  $sqlnovbasicoExt="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
  FROM empleado a 
  LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
WHERE a.tipo_empleado IN(4) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_EXT', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_EXT', '%Y-%m-31')";//IN(4)novedad extrusion 
$resultnovbasicoExt=mysql_query($sqlnovbasicoExt);  
$pago_novbasicoExt=mysql_result($resultnovbasicoExt,0,'pago'); 
$extras_novbasicoExt=mysql_result($resultnovbasicoExt,0,'extras');  
$recargo_novbasicoExt=mysql_result($resultnovbasicoExt,0,'recargo');
$festivo_novbasicoExt=mysql_result($resultnovbasicoExt,0,'festivos');
  //FIN
  //OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
  $valorhoraTodosExt = sueldoMes($sueldo_basExt,$auxilio_basExt,$aportes_basExt,$horasmes_Ext,$horasdia_basExt,$recargo_novbasicoExt,$festivo_novbasicoExt);
  $kiloXHoraExt=($tkilos_ex/$horas_ext);//kilo x hora para los cif y gga
  $valorHoraExt = ($valorhoraTodosExt/$operario_Ext);//total H se divide por # de operarios de extrusion    
  $costokiloInsumoExt=($kiloValorMP/$tkilos_ex);//$ costo de 1 kilos mp
  $manoObraExt=($horas_ext*($valorHoraExt+$valorHoraExtDemas))/$tkilos_ex;//$ costo de 1 kilo mano obra
  $valorkilocifyggaExt=($cifyggaExt/$kiloXHoraExt);//$kiloXHoraExt valor por hora de cif y gga  
  $costoExtrusion = ($costokiloInsumoExt+$manoObraExt+$valorkilocifyggaExt);
  $costoExtrusion = numeros_format($costoExtrusion); 
  echo $costoExtrusion = $costoExtrusion ==''? '0' : $costoExtrusion;//costo kilo extruder

}
?></strong> 
</td>
<!-- fin extruder -->


<!-- inicio impresion -->
<?php elseif($estado=='2'): ?>

 <td id="dato3"> 
   <?php 
   $id_op=$row_consumo['id_op'];
   $sqlimpk="SELECT SUM(int_kilos_prod_rp) AS kilosT FROM Tbl_reg_produccion WHERE id_op_rp='$id_op' AND id_proceso_rp='$estado'"; 
   $resultimpk=mysql_query($sqlimpk); 
   $numimpk=mysql_num_rows($resultimpk); 
   if($numimpk >= '1')
   { 
    $KILOSREALESIMP=mysql_result($resultimpk,0,'kilosT'); //IMPRESIÓN (Kilos) son registro de kilos no de tintas
    echo numeros_format($KILOSREALESIMP);
   }
  ?>
</td>

<td id="dato3"> 
   <?php
   $id_op=$row_consumo['id_op'];
   //$sqlCMP="SELECT (SUM(valor_prod_rp) * SUM(costo_mp) ) AS TCOSTO FROM  Tbl_reg_kilo_producido WHERE id_proceso_rkp='$estado' AND op_rp = '$id_op'"; 
   // $tiempoMuertoslExt=0;
  //$resultTintas = mysql_query("SELECT SUM(valor_prod_rp) * SUM(costo_mp) ) AS tcosto FROM Tbl_reg_kilo_producido WHERE id_proceso_rkp = '$estado' and op_rt='$id_op'");  
        $sqlCMP="SELECT valor_prod_rp, costo_mp FROM  Tbl_reg_kilo_producido WHERE Tbl_reg_kilo_producido.id_proceso_rkp='$estado' AND Tbl_reg_kilo_producido.op_rp = '$id_op'"; 
       $resultCMP=mysql_query($sqlCMP); 
       $numCMP=mysql_num_rows($resultCMP); 
       $row_CMP = mysql_fetch_assoc($resultCMP);
       $valorTI=0;
     do{
             $undMP = $row_CMP['valor_prod_rp'];
        $CMP = $row_CMP['costo_mp'];
        $valorMP=$undMP*$CMP;
        $valorTI+=$CMP;//ACUMULA VALOR POR ITEM 
       } while ($row_CMP = mysql_fetch_assoc($resultCMP));
         $kiloValorMP = $valorTI;    
   ?>
  <?php echo numeros_format($kiloValorMP);//Valor insumo Impr. valor kilo impresion ?>
 </td>

 <td id="dato3"> 
        <?php
        $sqlimph="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas_rp))) AS horasT, SUM(costo) AS Tcosto FROM Tbl_reg_produccion WHERE id_op_rp='$id_op' AND id_proceso_rp = '$estado'"; 
        $resultimph=mysql_query($sqlimph); 
        $numimph=mysql_num_rows($resultimph); 
        if($numimph >= '1') 
        { 
         $tHoras_imp=mysql_result($resultimph,0,'horasT');
         $costo_imp=mysql_result($resultimph,0,'Tcosto'); 
         $horas_imp = horadecimalUna($tHoras_imp);
         echo $tHoras_imp ;//Hora de Impr.
       }
       ?>
    </td>

 <td id="dato3"> 
  <?php     
/*  $sqldespExt="SELECT SUM(valor_desp_rd) AS kgDespe FROM Tbl_reg_desperdicio WHERE op_rd='$id_op' AND id_proceso_rd='1'"; 
  $resultdespExt=mysql_query($sqldespExt); 
  $numdespExt=mysql_num_rows($resultdespExt); 
  if($numdespExt >= '1') 
   {  echo $kilos_despExt=mysql_result($resultdespExt,0,'kgDespe');}*/

         echo numeros_format($kilos_DESPERDICIO);//desperdicio Extruder ya q ese es el q piden
  ?>
 </td>

 <td id="dato3"><?php  echo numeros_format($kilos_exMontaje);//de extruder  ?> </td>



<td id="dato3"><strong>
 <?php 
    $id_op=$row_consumo['id_op'];

        $sqlimp="SELECT DATE_FORMAT(fechaI_r,'%Y-%m-%d') AS FECHA FROM TblImpresionRollo WHERE id_op_r='$id_op' ORDER BY fechaI_r ASC"; 
        $resultimp=mysql_query($sqlimp); 
        $numimp=mysql_num_rows($resultimp); 
        if($numimp >= '1') 
         { 
         $FECHA_NOVEDAD_IMP=mysql_result($resultimp,0,'FECHA');
         }
         
          $sqlgeneral="SELECT * FROM `TblDistribucionHoras`  ORDER BY `fecha` DESC LIMIT 1";
        $resultgeneral= mysql_query($sqlgeneral);
        $numgeneral= mysql_num_rows($resultgeneral);
        if($numgeneral >='1')
        { 
        $TiempomeImp =  mysql_result($resultgeneral, 0, 'impresion');
        //IMPRESION
        $costoUnHGga_imp = mysql_result($resultgeneral, 0, 'gga_imp');
        $costoUnHCif_imp = mysql_result($resultgeneral, 0, 'cif_imp');
        $costoUnHGgv_imp = mysql_result($resultgeneral, 0, 'ggv_imp');
        $costoUnHGgf_imp = mysql_result($resultgeneral, 0, 'ggf_imp');
        $cifyggaImp=($costoUnHGga_imp+$costoUnHCif_imp+$costoUnHGgv_imp+$costoUnHGgf_imp);
        }else{$TiempomeImp='0';} 

      //SUELDOS DE TODOS LOS EMPLEADOS FUERA DE PROCESO 
      $sqlbasico="SELECT COUNT(a.codigo_empleado) AS operarios,(a.horas_empleado) AS HORADIA, SUM(b.sueldo_empleado) AS SUELDO, SUM(b.aux_empleado) AS AUXILIO, SUM(c.total) AS APORTES
    FROM empleado a 
    LEFT JOIN TblProcesoEmpleado b ON a.codigo_empleado=b.codigo_empleado  
    LEFT JOIN TblAportes c ON a.codigo_empleado=c.codigo_empl 
    WHERE b.estado_empleado='1' AND a.tipo_empleado NOT IN(4,5,6,7,8,9,10)";//NOT IN(4,5,6,7,8,9,10) son los que estan fuera de los procesos SE AGREGO b.estado_empleado='1' AND
      $resultbasico=mysql_query($sqlbasico);
        $operario_imp_demas=mysql_result($resultbasico,0,'operarios');
      $sueldo_bas=mysql_result($resultbasico,0,'SUELDO'); //sueldos del mes 
      $auxilio_bas=mysql_result($resultbasico,0,'AUXILIO'); //auxilios trans del mes    
      $aportes_bas=mysql_result($resultbasico,0,'APORTES'); //aportes del mes 
      //$horasmes_bas=mysql_result($resultbasico,0,'HORASMES');//LO EQUIVALENTE A LAS HORAS QUE SE TRABAJAN EN UN MES REAL 186,6666667 SE ENCUENTRA EN FACTOR
      $operarios_bas=mysql_result($resultbasico,0,'operarios');//CANTIDAD DE OPERARIOS 
      $horasdia_bas=mysql_result($resultbasico,0,'HORADIA');//esto es 8 
         
      //NOVEDAD DE TODOS LOS EMPLEADOS FUERA DE PROCESO 
      $sqlnovbasico="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
    FROM empleado a 
    LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
    WHERE a.tipo_empleado NOT IN(4,5,6,7,8,9,10) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_IMP', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_IMP', '%Y-%m-31')";//NOT IN(4,5,6,7,8,9,10) son los que estan fuera de los procesos
      $resultnovbasico=mysql_query($sqlnovbasico);  
      $pago_novbasico=mysql_result($resultnovbasico,0,'pago'); 
      $extras_novbasico=mysql_result($resultnovbasico,0,'extras');  
      $recargo_novbasico=mysql_result($resultnovbasico,0,'recargo');
      $festivo_novbasico=mysql_result($resultnovbasico,0,'festivos');
      $horasmes_imp='240';//240 mientras se define horas al mes
      //OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
        $valorhoraxoperImpDemas = sueldoMes($sueldo_bas,$auxilio_bas,$aportes_bas,$horasmes_imp,$horasdia_bas,$recargo_novbasico,$festivo_novbasico); 
      $valorHoraImpDemas = ($valorhoraxoperImpDemas/$operario_imp_demas)/3;//total Horas se divide por # de operarios de fuera de los procesos dividido en 3 q son los procesos
      
        //SUELDOS DE TODOS LOS EMPLEADOS DENTRO DE IMPRESION 
      $sqlbasico="SELECT COUNT(a.codigo_empleado) AS operarios,(a.horas_empleado) AS HORADIA, SUM(b.sueldo_empleado) AS SUELDO, SUM(b.aux_empleado) AS AUXILIO, SUM(c.total) AS APORTES
    FROM empleado a 
    LEFT JOIN TblProcesoEmpleado b ON a.codigo_empleado=b.codigo_empleado  
    LEFT JOIN TblAportes c ON a.codigo_empleado=c.codigo_empl 
    WHERE b.estado_empleado='1' AND a.tipo_empleado IN(5,10)";//IN(5,10) son impresion
      $resultbasico=mysql_query($sqlbasico);
      $operario_imp=mysql_result($resultbasico,0,'operarios');
      $sueldo_bas=mysql_result($resultbasico,0,'SUELDO'); //sueldos del mes 
      $auxilio_bas=mysql_result($resultbasico,0,'AUXILIO'); //auxilios trans del mes    
      $aportes_bas=mysql_result($resultbasico,0,'APORTES'); //aportes del mes 
      $horasdia_bas=mysql_result($resultbasico,0,'HORADIA');//esto es 8 
      $horasmes_imp='240';//240 mientras se define horas al mes
       //FIN   
       //NOVEDAD DE ESE MES DE TODOS LOS EMPLEADOS DENTRO DE IMPRESION 
        $sqlnovbasico="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
    FROM empleado a 
    LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
    WHERE a.tipo_empleado IN(5,10) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_IMP', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_IMP', '%Y-%m-31')";//IN(5,10)novedad impresion 
      $resultnovbasico=mysql_query($sqlnovbasico);  
      $pago_novbasico=mysql_result($resultnovbasico,0,'pago'); 
      $extras_novbasico=mysql_result($resultnovbasico,0,'extras');  
      $recargo_novbasico=mysql_result($resultnovbasico,0,'recargo');
      $festivo_novbasico=mysql_result($resultnovbasico,0,'festivos');
      //FIN
      //OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
      $valorhoraTodosImp = sueldoMes($sueldo_bas,$auxilio_bas,$aportes_bas,$horasmes_imp,$horasdia_bas,$recargo_novbasico,$festivo_novbasico);
      $kiloXHora=($KILOSREALESIMP/$horas_imp);//kilo x hora para los cif y gga
      $valorHoraImp = ($valorhoraTodosImp/$operario_imp);//total Horas se divide por # de operarios de Impresion    
        $costokiloInsumo=($kiloValorMP/$KILOSREALESIMP);//$ costo de 1 kilos mp
      $manoObra=($horas_imp*($valorHoraImp+$valorHoraImpDemas))/$KILOSREALESIMP;//$ costo de 1 kilo mano obra en 1 hora
        $valorkilocifygga=($cifyggaImp/$kiloXHora);// $kiloXHora valor por hora de cif y gga  
       $costoImpresion = numeros_format($costokiloInsumo+$manoObra+$valorkilocifygga);
       echo ($costoImpresion);//Costo kilo Impresion
   //}
    ?></strong>
  </td>
  <td id="dato3"> 
  <?php
 
  $sqlreferencias="SELECT impresion_ref as colores FROM tbl_referencia  WHERE cod_ref= '".$row_consumo['int_cod_ref_op']."' "; 
  $resultreferencias=mysql_query($sqlreferencias); 
  echo $coloresref = mysql_result($resultreferencias,0,'colores'); 
  ?> 
   
  </td>

  <!-- fin impresion -->



 <!-- inicio sellado -->
 <?php elseif($estado=='4'): ?>

<td id="dato3"> 
<?php 
$id_op=$row_consumo['id_op'];
$sqlsellk="SELECT SUM(int_kilos_prod_rp) AS kilosT FROM Tbl_reg_produccion WHERE id_op_rp='$id_op' AND id_proceso_rp='$estado'"; 
$resultsellk=mysql_query($sqlsellk); 
$numsellk=mysql_num_rows($resultsellk); 
if($numsellk >= '1') 
{ 
  $KILOSREALESSELL=mysql_result($resultsellk,0,'kilosT'); 
  echo numeros_format($KILOSREALESSELL);//kilo Inicial Sellado  
}
?>
</td>
 <td id="dato3">
    <?php 
 
     $sqlCMP="SELECT valor_prod_rp, costo_mp FROM Tbl_reg_kilo_producido WHERE Tbl_reg_kilo_producido.id_proceso_rkp='$estado' AND Tbl_reg_kilo_producido.op_rp = '$id_op'"; 
             $resultCMP=mysql_query($sqlCMP); 
             $numCMP=mysql_num_rows($resultCMP); 
             $row_CMP = mysql_fetch_assoc($resultCMP);
             $valorTS=0;
           do{
              $undMP = $row_CMP['valor_prod_rp'];
              $CMP = $row_CMP['costo_mp'];
              $valorMP=$undMP*$CMP;
              $valorTS+=$CMP;//ACUMULA VALOR POR ITEM 
            } while ($row_CMP = mysql_fetch_assoc($resultCMP)); 
          
           echo numeros_format($valorTS); //Costo MP Sellado
 
    ?>
  </td>

  <td id="dato3">
    <?php  
    $id_op=$row_consumo['id_op'];
    $sqlsellh="SELECT COUNT(int_total_rollos_rp) AS Trollos, SEC_TO_TIME(SUM(TIME_TO_SEC(total_horas_rp))) AS horasT, SUM(costo) AS Tcosto FROM Tbl_reg_produccion WHERE id_op_rp='$id_op' AND id_proceso_rp = '$estado'"; 
    $resultsellh=mysql_query($sqlsellh); 
    $numsellh=mysql_num_rows($resultsellh); 
    if($numsellh >= '1') 
    { 
     $tHoras_sell=mysql_result($resultsellh,0,'horasT');
     $costo_sell=mysql_result($resultsellh,0,'Tcosto'); 
     $Trollos=mysql_result($resultsellh,0,'Trollos'); 
     $horas_sell = horadecimalUna($tHoras_sell);
     echo $tHoras_sell;//Hora de Sellado  
   }
   ?>
  </td>


  <td id="dato3"> 
        <?php     
             $sqldespsell="SELECT SUM(valor_desp_rd) AS kgDespe FROM Tbl_reg_desperdicio WHERE op_rd='$id_op' AND id_proceso_rd='$estado'"; 
             $resultdespsell=mysql_query($sqldespsell); 
             $numdespsell=mysql_num_rows($resultdespsell); 
             if($numdespsell >= '1') 
             {  
               $kilos_despsell=mysql_result($resultdespsell,0,'kgDespe');
               echo numeros_format($kilos_despsell);//  Desperdicio Sellado
             } 
        ?>
  </td>

  <td id="dato3"> 
       <?php 
       //MATERIA PRIMA
      mysql_select_db($database_conexion1, $conexion1);
      $queryref = "SELECT * FROM Tbl_orden_produccion,Tbl_referencia  WHERE Tbl_orden_produccion.id_op='$id_op' AND Tbl_orden_produccion.id_ref_op=Tbl_referencia.id_ref";
      $resultref=mysql_query($queryref); 
      $numcostoMP=mysql_num_rows($resultref); 
      $row_referencia = mysql_fetch_assoc($resultref);
       
      $tipo_cinta = $row_referencia['tipoCinta_ref'];//TIPO DE CINTA O LINER
      $id_ter=$row_referencia['id_termica_op'];

      //SI LLEVA CINTA TERMICA
      $sqlterm="SELECT valor_unitario_insumo FROM insumo WHERE id_insumo='$id_ter'"; 
      $resultterm=mysql_query($sqlterm); 
      $numterm=mysql_num_rows($resultterm);  
      if($numterm >= '1')  
      { 
        $valor_term=mysql_result($resultterm,0,'valor_unitario_insumo');
            $RealmetrosTermica = ($row_referencia['cinta_termica_op']*$bolsas_sell);//por el ancho real de la cinta termica
         $costoTermica=($RealmetrosTermica * $valor_term);
       }else{
          $costoTermica='0';
       }

      $tipo = $row_referencia['adhesivo_ref'];//HOTMELT O CINTA
      if($tipo=='HOT MELT')//EVALUO QUE SEA HOT PORQ SE COSTEA EN KILO
          {
            //LINER
            $sqlliner="SELECT `id_insumo`,`valor_unitario_insumo` FROM `insumo` WHERE `id_insumo` = '$tipo_cinta'";
            $resultliner=mysql_query($sqlliner);
            $valorLiner = mysql_result($resultliner,0,'valor_unitario_insumo');
            $costoliner = $metros_imp * $valorLiner;//valor liner por metro lineal
           //PEGANTE
             $sqlpega="SELECT `id_insumo`,`valor_unitario_insumo` FROM `insumo` WHERE `id_insumo` = '1695'";//1695 codigo del pegante aplicado es general
              $resultpega=mysql_query($sqlpega);
                  $valorpega = mysql_result($resultpega,0,'valor_unitario_insumo');//VALOR DEL KILO DE PEGA
                $metrosakilospega=adhesivos($tipo,$metros_imp);//1.2 LOS GRAMOS EN 1 METRO LINEAL Y 1000 GRAMOS EN 1 KILO 
              $costopega = ($metrosakilospega * $valorpega);
            $costoHotmelOcinta = ($costoliner+$costopega);// El precio total de hotmelt
          }else{
            //CINTA SEGURIDAD
              $sqlcostoMP="SELECT valor_unitario_insumo AS VALORMETRO FROM insumo WHERE insumo.id_insumo = '$tipo_cinta'"; 
              $resultcostoMP=mysql_query($sqlcostoMP); 
              $numcostoMP=mysql_num_rows($resultcostoMP); 
              $row_valoresMP = mysql_fetch_assoc($resultcostoMP);
              if($numcostoMP >= '1')  
                     { 
                       $valorMPcinta = $row_valoresMP['VALORMETRO'];
                   $costoHotmelOcinta = $metros_imp * $valorMPcinta;//esto pasa a dinero
                 }         
          }
      //SUMA CINTA SEGURIDAD Y TERMICA, BOLSILLO, HOTMEL
      $pesoMbols = millarBolsillo($row_referencia['ancho_ref'],$row_referencia['largo_ref'],$row_referencia['calibreBols_ref']) ;
      $tipoLm = $row_referencia['tipoLamina_ref'];
      $sqlrbols="SELECT valor_unitario_insumo FROM insumo WHERE id_insumo = '$tipoLm'";
      $resultrbols= mysql_query($sqlrbols);
      $numrbols = mysql_num_rows($resultrbols);
      if($numrbols >='1')
      { 
         $valor_bols = mysql_result($resultrbols, 0, 'valor_unitario_insumo'); 
         $costo_bols = ($valor_bols*$pesoMbols);
      }else{
        $costo_bols="0";
      } 
         $COSTOMPSELLADO=($costoTermica+$costoHotmelOcinta+$costo_bols);
         echo numeros_format($COSTOMPSELLADO);// Costo Materia Prima sellado si es cinta con todo
  ?>
 
</td>

<td id="dato3"><strong>
  <?php 
      $sqlsell="SELECT DATE_FORMAT(fechaI_r,'%Y-%m-%d') AS FECHA FROM TblSelladoRollo WHERE id_op_r='$id_op' ORDER BY fechaI_r ASC"; 
      $resultsell=mysql_query($sqlsell); 
      $numsell=mysql_num_rows($resultsell); 
      if($numsell >= '1') 
       { 
       $FECHA_NOVEDAD_SELL=mysql_result($resultsell,0,'FECHA');
       }
   
      $sqlgeneral="SELECT * FROM `TblDistribucionHoras` ORDER BY `fecha` DESC LIMIT 1";
    $resultgeneral= mysql_query($sqlgeneral);
    $numgeneral= mysql_num_rows($resultgeneral);
    if($numgeneral >='1')
    { 
    $TiempomeSell =  mysql_result($resultgeneral, 0, 'sellado');
    //SELLADO
    $costoUnHGga_sell = mysql_result($resultgeneral, 0, 'gga_sell');
    $costoUnHCif_sell = mysql_result($resultgeneral, 0, 'cif_sell');
    $costoUnHGgv_sell = mysql_result($resultgeneral, 0, 'ggv_sell');
    $costoUnHGgf_sell = mysql_result($resultgeneral, 0, 'ggf_sell');
    $cifyggaSell=($costoUnHGga_sell+$costoUnHCif_sell+$costoUnHGgv_sell+$costoUnHGgf_sell);
    }else{$TiempomeSell='0';} 

  //SUELDOS DE TODOS LOS EMPLEADOS FUERA DE PROCESO 
  $sqlbasicoSell="SELECT COUNT(a.codigo_empleado) AS operarios,(a.horas_empleado) AS HORADIA, SUM(b.sueldo_empleado) AS SUELDO, SUM(b.aux_empleado) AS AUXILIO, SUM(c.total) AS APORTES
FROM empleado a 
LEFT JOIN TblProcesoEmpleado b ON a.codigo_empleado=b.codigo_empleado  
LEFT JOIN TblAportes c ON a.codigo_empleado=c.codigo_empl 
WHERE b.estado_empleado='1' AND a.tipo_empleado NOT IN(4,5,6,7,8,9,10)";//NOT IN(4,5,6,7,8,9,10) son los que estan fuera de los procesos SE AGREGO b.estado_empleado='1' AND
  $resultbasicoSell=mysql_query($sqlbasicoSell);
    $operario_sell_demas=mysql_result($resultbasicoSell,0,'operarios');
  $sueldo_basSell=mysql_result($resultbasicoSell,0,'SUELDO'); //sueldos del mes 
  $auxilio_basSell=mysql_result($resultbasicoSell,0,'AUXILIO'); //auxilios trans del mes    
  $aportes_basSell=mysql_result($resultbasicoSell,0,'APORTES'); //aportes del mes 
  //$horasmes_bas=mysql_result($resultbasico,0,'HORASMES');//LO EQUIVALENTE A LAS HORAS QUE SE TRABAJAN EN UN MES REAL 186,6666667 SE ENCUENTRA EN FACTOR
  $operarios_basSell=mysql_result($resultbasicoSell,0,'operarios');//CANTIDAD DE OPERARIOS 
  $horasdia_basSell=mysql_result($resultbasicoSell,0,'HORADIA');//esto es 8 
     
  //NOVEDAD DE TODOS LOS EMPLEADOS FUERA DE PROCESO 
  $sqlnovbasicoSell="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
FROM empleado a 
LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
WHERE a.tipo_empleado NOT IN(4,5,6,7,8,9,10) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_SELL', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_SELL', '%Y-%m-31')";//NOT IN(4,5,6,7,8,9,10) son los que estan fuera de los procesos
  $resultnovbasicoSell=mysql_query($sqlnovbasicoSell);  
  $pago_novbasicoSell=mysql_result($resultnovbasicoSell,0,'pago'); 
  $extras_novbasicoSell=mysql_result($resultnovbasicoSell,0,'extras');  
  $recargo_novbasicoSell=mysql_result($resultnovbasicoSell,0,'recargo');
  $festivo_novbasicoSell=mysql_result($resultnovbasicoSell,0,'festivos');
  $horasmes_sell='240';//240 mientras se define horas al mes
  //OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
    $valorhoraxoperSellDemas = sueldoMes($sueldo_basSell,$auxilio_basSell,$aportes_basSell,$horasmes_sell,$horasdia_basSell,$recargo_novbasicoSell,$festivo_novbasicoSell); 
  $valorHoraSellDemas = ($valorhoraxoperSellDemas/$operario_sell_demas)/3;//total Horas se divide por # de operarios de fuera de los procesos dividido en 3 q son los procesos
  
    //SUELDOS DE TODOS LOS EMPLEADOS DENTRO DE SELLADO 
  $sqlbasicoSell="SELECT COUNT(a.codigo_empleado) AS operarios,(a.horas_empleado) AS HORADIA, SUM(b.sueldo_empleado) AS SUELDO, SUM(b.aux_empleado) AS AUXILIO, SUM(c.total) AS APORTES
FROM empleado a 
LEFT JOIN TblProcesoEmpleado b ON a.codigo_empleado=b.codigo_empleado  
LEFT JOIN TblAportes c ON a.codigo_empleado=c.codigo_empl 
WHERE b.estado_empleado='1' AND a.tipo_empleado IN(7,9)";//IN(7,9) son Sellado
  $resultbasicoSell=mysql_query($sqlbasicoSell);
  $operario_sell=mysql_result($resultbasicoSell,0,'operarios');
  $sueldo_basSell=mysql_result($resultbasicoSell,0,'SUELDO'); //sueldos del mes 
  $auxilio_basSell=mysql_result($resultbasicoSell,0,'AUXILIO'); //auxilios trans del mes    
  $aportes_basSell=mysql_result($resultbasicoSell,0,'APORTES'); //aportes del mes 
  $horasdia_basSell=mysql_result($resultbasicoSell,0,'HORADIA');//esto es 8 
  $horasmes_sell='240';//240 mientras se define horas al mes
   //FIN   
   //NOVEDAD DE ESE MES DE TODOS LOS EMPLEADOS DENTRO DE SELLADO 
    $sqlnovbasicoSell="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
FROM empleado a 
LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
WHERE a.tipo_empleado IN(7,9) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_SELL', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_SELL', '%Y-%m-31')";//IN(5,10)novedad sellado 
  $resultnovbasicoSell=mysql_query($sqlnovbasicoSell);  
  $pago_novbasicoSell=mysql_result($resultnovbasicoSell,0,'pago'); 
  $extras_novbasicoSell=mysql_result($resultnovbasicoSell,0,'extras');  
  $recargo_novbasicoSell=mysql_result($resultnovbasicoSell,0,'recargo');
  $festivo_novbasicoSell=mysql_result($resultnovbasicoSell,0,'festivos');
  //FIN
  //OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
  $valorhoraTodosSell = sueldoMes($sueldo_basSell,$auxilio_basSell,$aportes_basSell,$horasmes_sell,$horasdia_basSell,$recargo_novbasicoSell,$festivo_novbasicoSell);
  $kiloXHoraSell=($KILOSREALESSELL/$horas_sell);//kilo x hora para los cif y gga
  $valorHoraSell = ($valorhoraTodosSell/$operario_sell);//total Horas se divide por # de operarios de Sellado   
    $costokiloInsumoSell=($COSTOMPSELLADO/$KILOSREALESSELL);//$ costo de 1 kilos mp
    $manoObraSell=($horas_sell*($valorHoraSell+$valorHoraSellDemas))/$KILOSREALESSELL;//$ costo de 1 kilo mano obra en 1 hora
    $valorkilocifyggaSell=($cifyggaSell/$kiloXHoraSell);//valor por hora de cif y gga  
   
   $costoSellado =($costokiloInsumoSell+$manoObraSell+$valorkilocifyggaSell);
    echo numeros_format($costoSellado = $costoSellado ==''? '0' : $costoSellado);// Costo kilo Sellado
   //}//solamente imprime si tiene kilos en sellado
    ?>
      
    </strong>
  </td>
 

  <td id="dato3"> 
    <?php
    $sqlrepro="SELECT SUM(reproceso_r) AS reproceso FROM $baserollos WHERE id_op_r='$id_op' ORDER BY fechaI_r ASC"; 
    $resultrepro=mysql_query($sqlrepro); 
    $numrepro=mysql_num_rows($resultrepro); 
    if($numrepro >= '1') 
    {  
      $reproceso_sell=mysql_result($resultrepro,0,'reproceso') ;
      echo numeros_format($reproceso_sell);//reproceso
    }?>
  </td>

  <td id="dato3">
   <?php
   $costokiloBolsa=($costoExtrusion+$costoImpresion+$costoSellado);//$ kilo en sellado
   $costototalBolsa = (($KILOSREALESSELL-$kilos_despsell)*$costokiloBolsa);//$total o.p 
   $costoBolsa=($costototalBolsa/$bolsas_sell);//$costo bolsa
   echo numeros_format($costoBolsa);// costo bolsa
  ?>
</td>
<td id="dato3">
<?php  
$sqlcotiz="SELECT Tbl_items_ordenc.trm AS trm,Tbl_items_ordenc.str_unidad_io AS medida,Tbl_items_ordenc.int_precio_io AS precio,Tbl_items_ordenc.str_moneda_io AS moneda FROM Tbl_orden_produccion,Tbl_items_ordenc WHERE Tbl_orden_produccion.id_op = '$id_op'  AND Tbl_orden_produccion.int_cod_ref_op = Tbl_items_ordenc.int_cod_ref_io ORDER BY Tbl_items_ordenc.fecha_entrega_io DESC LIMIT 1";        
$resultcotiz=mysql_query($sqlcotiz); 
$numcotiz=mysql_num_rows($resultcotiz); 
$moneda=mysql_result($resultcotiz,0,'moneda');
$medida=mysql_result($resultcotiz,0,'medida');
$precioCotiz=mysql_result($resultcotiz,0,'precio');
$trmCotiz=mysql_result($resultcotiz,0,'trm');
$undPaquetes=$row_consumo['int_undxpaq_op'];//unidad x paquetes
echo /*$moneda.' '.*/numeros_format($precioCotiz);
$precioCotiz_sell = unidadMedida($medida,$precioCotiz,$undPaquetes,$trmCotiz);//Precio Venta Und.
?>
</td>
<td id="dato3" nowrap>
<?php 
 //Rentabilidad
  $utilidadSell=($precioCotiz_sell-$costoBolsa); 
  $Rentabilidad = porcentaje2($precioCotiz_sell,$utilidadSell,0);
  if($Rentabilidad < 0) {?>
     <h4 style="color:#F00"> <?php echo $Rentabilidad.' %';?> </h4>
 <?php }else{ echo $Rentabilidad.' %'; } //Rentabilidad ?>
</td>
<!-- fin sellado -->
<?php endif; ?>

<!-- <td id="dato3"><strong><?php //echo  ($costoExtrusion+$costoImpresion+$costoSellado);//costo x proceso?></strong> -->
</td>

<td id="dato4">
  <?php 
  $id_op=$row_consumo['id_op'];
  $sqlordenp="SELECT * FROM Tbl_orden_produccion WHERE id_op = '$id_op'";
  $resultordenp= mysql_query($sqlordenp);
  $numordenp= mysql_num_rows($resultordenp);
  if($numordenp >='1')
  { 
   $estados =  mysql_result($resultordenp, 0, 'b_estado_op');//Estado en OP
 }
 switch ($estados){
   case 0: echo "INGRESADA";
   break;
   case 1: echo "EXTRUSION";
   break;
   case 2: echo "IMPRESION";
   break;
   case 3: echo "REFILADO";
   break;
   case 4: echo "SELLADO";
   break;
   case 5: echo "FINALIZADA";
   break;             
 }
 ?>
</td>

<td id="dato3"><?php echo numeros_format(mysql_result($resultordenp, 0, 'int_ancho_rollo_op'));?> </td>
<td id="dato3"><?php echo numeros_format(mysql_result($resultordenp, 0, 'int_desperdicio_op'));?> </td>
<td id="dato3"><?php echo numeros_format(mysql_result($resultordenp, 0, 'int_kilos_op'));?> </td>
<td id="dato3"><?php echo numeros_format(mysql_result($resultordenp, 0, 'metroLineal_op'));?> </td>
<td id="dato3"><?php echo round(mysql_result($resultordenp, 0, 'int_cantidad_op'));?> </td>
<td id="dato3"><?php echo (mysql_result($resultordenp, 0, 'numInicio_op'));?> </td>
<td id="dato3"><?php echo (mysql_result($resultordenp, 0, 'numInicio_op')+mysql_result($resultordenp, 0, 'int_cantidad_op'))-1;?> 
</td>

 <!-- Inicia los tipos de desperdicio y sus valores -->
<?php $resultIds = mysql_query("SELECT trtd.id_rtp AS ID FROM `tbl_reg_tipo_desperdicio` as trtd LEFT JOIN `tbl_reg_desperdicio` AS trd ON trtd.id_rtp = trd.id_rpd_rd WHERE trtd.id_proceso_rtd ='$estado' GROUP BY trd.id_rpd_rd order by trtd.nombre_rtp asc");
while ($rowIds = mysql_fetch_array($resultIds)) { 
  $id_desperdicio = $rowIds['ID'];
  ?>

  <td nowrap="nowrap">
    <?php $resultMotivosNombre = mysql_query("SELECT SUM(trd.valor_desp_rd) AS VALORES FROM `tbl_reg_desperdicio` AS trd WHERE trd.id_rpd_rd = '$id_desperdicio' AND trd.op_rd = '$id_op' and trd.id_proceso_rd ='$estado' GROUP BY trd.id_rpd_rd "); 
    $row_resultMotivosNombre = mysql_fetch_assoc($resultMotivosNombre);
    echo numeros_format($row_resultMotivosNombre['VALORES'] ==''? '0':$row_resultMotivosNombre['VALORES']);//valores de tipo desperdicios
    ?> 
  </td>
  <?php }  ?>

<!-- <td id="dato3"><?php //echo numeros_format($kilos_DESPERDICIO);//desperdicio extruder para todos ?></td>
<td id="dato3"><?php //echo numeros_format($kilos_exMontaje);//Montaje de extruder para todos ?> </td> -->
<td id="dato3">
  <?php 
  $sqlline="SELECT COUNT(rollo_r) AS rollo_r, SUM(metro_r) AS metro_r, SUM(kilos_r) AS kilos_r, cod_empleado_r FROM `$baserollos` WHERE `id_op_r`='$id_op' ";
  $resultline=mysql_query($sqlline); 
  $numline=mysql_num_rows($resultline); 
  if($numline >= '1') 
  { 
   $total_rolloext = mysql_result($resultline,0,'rollo_r'); 
   $metros_linealext = mysql_result($resultline,0,'metro_r'); 
   $cod_empleado_ext = mysql_result($resultline,0,'cod_empleado_r');  
   $kilos_realesext = mysql_result($resultline,0,'kilos_r');//Kilos Reales
   echo numeros_format($kilos_realesext);
 } 

 $resultOpmes = mysql_query("SELECT (TIMESTAMPDIFF(MINUTE,fechaI_r,fechaF_r )/60)  AS TIEMPODIFE FROM `$baserollos`  WHERE `id_op_r`= '$id_op' GROUP BY `fechaI_r` ASC");  
 while ($row=mysql_fetch_array($resultOpmes)){ 
   $tiempototalExt += $row['TIEMPODIFE']; //Horas
 } 

 $tiempoMuertoslExt=0;
 $resultDesp = mysql_query("SELECT SUM(`valor_tiem_rt`)/60 AS muertos FROM Tbl_reg_tiempo WHERE id_proceso_rt = '$estado' and op_rt='$id_op' and id_rpt_rt not in('1','2')");  
 while ($row2=mysql_fetch_array($resultDesp)){ 
   $tiempoMuertoslExt += $row2['muertos']; 
 } 

 $tiempoMecanicoExt=0;
 $resultMecanico = mysql_query("SELECT SUM(`valor_tiem_rt`)/60 AS mecanico FROM Tbl_reg_tiempo WHERE id_proceso_rt = '$estado' and op_rt='$id_op' and id_rpt_rt in('1','2'"); 
 while ($row3=mysql_fetch_array($resultMecanico)){ 
   $tiempoMecanicoExt += $row3['mecanico']; 
 } 

 $tiempoSinMateriaExt=0;
 $resultSinMateria = mysql_query("SELECT SUM(`valor_tiem_rt`)/60 AS sinmateria FROM Tbl_reg_tiempo WHERE id_proceso_rt = '$estado' and op_rt='$id_op' and id_rpt_rt='8'");  
 while ($row4=mysql_fetch_array($resultSinMateria)){ 
   $tiempoSinMateriaExt += $row4['sinmateria']; 
 } 

 $tiempoRevienteExt=0;
 $resultReviente = mysql_query("SELECT SUM(`valor_tiem_rt`)/60 AS Reviente FROM Tbl_reg_tiempo WHERE id_proceso_rt = '$estado' and op_rt='$id_op' and id_rpt_rt='11'");
 while ($row5=mysql_fetch_array($resultReviente)){ 
   $tiempoRevienteExt += $row5['Reviente']; 
 }  

 $tiempoResistenciaExt=0;
 $resultResistencia = mysql_query("SELECT SUM(`valor_tiem_rt`)/60 AS Resistencia FROM Tbl_reg_tiempo WHERE id_proceso_rt = '$estado' and op_rt='$id_op' and id_rpt_rt='7'");  
 while ($row6=mysql_fetch_array($resultResistencia)){ 
   $tiempoResistenciaExt += $row6['Resistencia']; 
 }

 $tiempoPreparacionExt=0;
 $resultPreparacion = mysql_query("SELECT SUM(`valor_prep_rtp`)/60 AS Preparacion FROM Tbl_reg_tiempo_preparacion WHERE id_proceso_rtp = '$estado' and op_rtp='$id_op' ");  
 while ($row7=mysql_fetch_array($resultPreparacion)){ 
   $tiempoPrepaExt += $row7['Preparacion']; 
 } 

/* $resultMontaje = mysql_query("SELECT SUM(`valor_tiem_rt`) AS Montaje FROM Tbl_reg_tiempo WHERE id_proceso_rt = '$estado' and op_rt='$id_op' and id_rpt_rt='7'");  
 while ($row=mysql_fetch_array($resultMontaje)){ 
   $tiempoMontajeExt += $row['Montaje']; 
 } */

 
 ?> 
 <td id="dato3"><?php echo $metros_linealext;?> </td>
 <td id="dato3"><?php echo ($total_rolloext);?> </td>
</td>
<td id="dato3"><?php echo $cod_empleado_ext;?> </td>
<td id="dato3"><?php echo numeros_format($tiempototalExt);?> </td>
<td id="dato3"><?php echo numeros_format($tiempoMuertoslExt==''?'0':$tiempoMuertoslExt);?> </td>
<td id="dato3"><?php echo numeros_format($tiempoMecanicoExt==''?'0':$tiempoMecanicoExt);?> </td>
<td id="dato3"><?php echo numeros_format($tiempoPrepaExt==''?'0':$tiempoPrepaExt) ;?> </td>
<td id="dato3"><?php echo numeros_format($tiempoSinMateriaExt==''?'0':$tiempoSinMateriaExt);?> </td>
<td id="dato3"><?php echo numeros_format($tiempoRevienteExt==''?'0':$tiempoRevienteExt);?> </td>
<td id="dato3"><?php echo numeros_format($tiempoResistenciaExt==''?'0':$tiempoResistenciaExt);?> </td>
<td id="dato3"><?php echo numeros_format($kilos_exMontaje==''?'0':$kilos_exMontaje); ?> </td>
<td id="dato3"><?php echo numeros_format($kiloValorMP==''?'0':$kiloValorMP);//VALOR KILO?> </td>
<td id="dato3" nowrap >
  <?php 
  echo $maquina_ext;
  ?> 
</td>
<td id="dato3"><?php $fechaEjecucionExt =  explode(' ',$fechaEjecucionExt); echo $fechaEjecucionExt[0] ==' '? 'SIN FECHA': $fechaEjecucionExt[0];  ;?> </td>
 
<!-- sellado -->
</tr>
<?php } while ($row_consumo = mysql_fetch_assoc($fichas_tecnicas)); ?>
</table>

<?php
mysql_free_result($usuario);

mysql_free_result($lista);

mysql_free_result($fichas_tecnicas);

mysql_free_result($referencias);
?>
