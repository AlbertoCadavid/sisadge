<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config.php');
require (ROOT_BBDD); 
?> 
<?php 
 require_once('Connections/conexion1.php');
 
  ?>
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
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
//FIN
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$conexion = new ApptivaDB();//consultas
 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	      //COSTO SELLADO
		  $id_op=$_POST['id_op_rp'];
	      $metros_imp=$_POST['metro_r2']; 
		  $bolsas_sell=$_POST['bolsa_rp']; 
 		  $KILOSREALESSELL=$_POST['int_total_kilos_rp'];
 		  $FECHA_NOVEDAD_SELL = quitarHora($_POST['fecha_ini_rp']);//quita hora 	 
          $horas_sell = $_POST['total_horas_rp'];

 	  	  //MATERIA PRIMA

	   	  mysql_select_db($database_conexion1, $conexion1);
		  $queryref = "SELECT * FROM Tbl_orden_produccion,Tbl_referencia  WHERE Tbl_orden_produccion.id_op='$id_op' AND Tbl_orden_produccion.id_ref_op=Tbl_referencia.id_ref";
		  $resultref=mysql_query($queryref); 
		  $numcostoMP=mysql_num_rows($resultref); 
		  $row_referencia = mysql_fetch_assoc($resultref);
   		  
   		  if($row_referencia['id_op'] == ''){

     		  $refop = $_POST['cod_ref'];  
     		  $row_referencia = $conexion->llenarCampos('tbl_referencia as ref', "  WHERE ref.cod_ref ='".$refop."' ", " ","ref.id_ref,ref.tipoCinta_ref,ref.adhesivo_ref,ref.ancho_ref,ref.largo_ref,ref.calibreBols_ref,ref.tipoLamina_ref,ref.ancho_ref,ref.tipoCinta_ref,ref.cod_ref,ref.version_ref,ref.tipoCinta_ref" );

   		  }


		  //$id_ter=$row_referencia['id_termica_op'];

		  $tipo_cinta = $row_referencia['tipoCinta_ref'];//TIPO DE CINTA O LINER

		  //SI LLEVA CINTA TERMICA
 	      $sqlterm="SELECT valor_unitario_insumo FROM insumo WHERE id_insumo='$tipo_cinta'"; 
		  $resultterm=mysql_query($sqlterm); 
		  $numterm=mysql_num_rows($resultterm);  
 		  if($numterm >= '1')  
		  { 
		   $cintatermica =$row_referencia['cinta_termica_op'] =='' ? 1 : $row_referencia['cinta_termica_op'];
		  $valor_term=mysql_result($resultterm,0,'valor_unitario_insumo');
		  $RealmetrosTermica = ($cintatermica*$bolsas_sell);//por el ancho real de la cinta termica
		  $costoTermica=($RealmetrosTermica * $valor_term);
		  }else{$costoTermica='0';}

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
 	      }else{$costo_bols="0";}	
		  $COSTOMPSELLADO=($costoTermica+$costoHotmelOcinta+$costo_bols);
    
		  $sqlgeneral="SELECT * FROM `TblDistribucionHoras` ORDER BY `fecha` DESC LIMIT 1";
		  $resultgeneral= mysql_query($sqlgeneral);
		  $numgeneral= mysql_num_rows($resultgeneral);
		  if($numgeneral >='1')
		  { 
		  $TiempomeSell =  mysql_result($resultgeneral, 0, 'sellado');
		  //IMPRESION
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
WHERE b.estado_empleado='1' AND a.tipo_empleado IN(7,9)";//IN(5,10) son impresion
	$resultbasicoSell=mysql_query($sqlbasicoSell);
	$operario_sell=mysql_result($resultbasicoSell,0,'operarios');
	$sueldo_basSell=mysql_result($resultbasicoSell,0,'SUELDO'); //sueldos del mes 
	$auxilio_basSell=mysql_result($resultbasicoSell,0,'AUXILIO'); //auxilios trans del mes 	  
	$aportes_basSell=mysql_result($resultbasicoSell,0,'APORTES'); //aportes del mes 
	$horasdia_basSell=mysql_result($resultbasicoSell,0,'HORADIA');//esto es 8 
	$horasmes_sell='240';//240 mientras se define horas al mes
	 //FIN	 
	 //NOVEDAD DE ESE MES DE TODOS LOS EMPLEADOS DENTRO DE IMPRESION 
  	$sqlnovbasicoSell="SELECT SUM(b.pago_acycia) as pago,SUM(b.horas_extras) as extras,SUM(b.recargos) as recargo,SUM(b.festivos) AS festivos 
FROM empleado a 
LEFT JOIN TblNovedades b ON a.codigo_empleado=b.codigo_empleado 
WHERE a.tipo_empleado IN(7,9) AND b.fecha BETWEEN DATE_FORMAT('$FECHA_NOVEDAD_SELL', '%Y-%m-01') AND DATE_FORMAT('$FECHA_NOVEDAD_SELL', '%Y-%m-31')";//IN(5,10)novedad impresion 
	$resultnovbasicoSell=mysql_query($sqlnovbasicoSell);	
	$pago_novbasicoSell=mysql_result($resultnovbasicoSell,0,'pago'); 
	$extras_novbasicoSell=mysql_result($resultnovbasicoSell,0,'extras');  
	$recargo_novbasicoSell=mysql_result($resultnovbasicoSell,0,'recargo');
	$festivo_novbasicoSell=mysql_result($resultnovbasicoSell,0,'festivos');
	//FIN
	//OPERO TODOS LOS SUELDOS ETC, PARA SACAR EL COSTO HORA DE LOS FUERA DE PROCESOS
 	$valorhoraTodosSell = sueldoMes($sueldo_basSell,$auxilio_basSell,$aportes_basSell,$horasmes_sell,$horasdia_basSell,$recargo_novbasicoSell,$festivo_novbasicoSell);
	$kiloXHoraSell=($KILOSREALESSELL/$horas_sell);//kilo x hora para los cif y gga
	$valorHoraSell = ($valorhoraTodosSell/$operario_sell);//total Horas se divide por # de operarios de Impresion	  
  	$costokiloInsumoSell=($COSTOMPSELLADO/$KILOSREALESSELL);//$ costo de 1 kilos mp
	$manoObraSell=($horas_sell*($valorHoraSell+$valorHoraSellDemas))/$KILOSREALESSELL;//$ costo de 1 kilo mano obra en 1 hora
  	$valorkilocifyggaSell=($cifyggaSell/$kiloXHoraSell);// $kiloXHora valor por hora de cif y gga  
	 
 	 $COSTOHORAKILOSELL =($costokiloInsumoSell+$manoObraSell+$valorkilocifyggaSell);
     //FIN DE EVALUACION DEL COSTO 
	 
    $insertSQL = sprintf("INSERT INTO Tbl_reg_produccion ( id_proceso_rp, id_op_rp,id_ref_rp, int_cod_ref_rp, version_ref_rp, placa_rp, bolsa_rp, lam1_rp, lam2_rp, turno_rp, rollo_rp, n_ini_rp, n_fin_rp, int_kilos_prod_rp, int_kilos_desp_rp, int_total_kilos_rp, porcentaje_op_rp, int_metro_lineal_rp, int_total_rollos_rp, total_horas_rp, rodamiento_rp, horas_muertas_rp, horas_prep_rp, str_maquina_rp, str_responsable_rp, fecha_ini_rp, fecha_fin_rp, int_kilosxhora_rp,int_metroxmin_rp,int_cod_empleado_rp,int_cod_liquida_rp,kiloFaltante_rp,costo) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_proceso_rp'], "int"),
                       GetSQLValueString($_POST['id_op_rp'], "int"),
					   GetSQLValueString($_POST['id_ref_rp'], "int"),
                       GetSQLValueString($_POST['int_cod_ref_rp'], "text"),
                       GetSQLValueString($_POST['version_ref_rp'], "int"),
					   GetSQLValueString($_POST['placa_rp'], "text"),
					   GetSQLValueString($_POST['bolsa_rp'], "int"),
					   GetSQLValueString($_POST['lam1_rp'], "double"),
					   GetSQLValueString($_POST['lam2_rp'], "double"),
					   GetSQLValueString($_POST['turno_rp'], "int"), 
					   GetSQLValueString($_POST['rollo_rp'], "int"),
					   GetSQLValueString($_POST['n_ini_rp'], "text"),
					   GetSQLValueString($_POST['n_fin_rp'], "text"),					   
                       GetSQLValueString($_POST['int_kilos_prod_rp'] , "double"),
                       GetSQLValueString($_POST['int_kilos_desp_rp'], "text"),
					   GetSQLValueString($_POST['int_total_kilos_rp'], "double"),
					   GetSQLValueString($_POST['porcentaje'], "int"),
					   GetSQLValueString($_POST['metro_r2'], "int"),
					   GetSQLValueString($_POST['int_total_rollos_rp'], "int"),					   
                       GetSQLValueString($_POST['total_horas_rp'], "text"),
					   GetSQLValueString($_POST['rodamiento_rp'], "text"),
					   GetSQLValueString($_POST['horas_muertas_rp'], "text"), 
					   GetSQLValueString($_POST['horas_prep_rp'], "text"),              
                       GetSQLValueString($_POST['str_maquina_rp'], "text"),
                       GetSQLValueString($_POST['str_responsable_rp'], "text"),
					   GetSQLValueString($_POST['fecha_ini_rp'], "date"),
                       GetSQLValueString($_POST['fecha_fin_rp'], "date"),
					   GetSQLValueString($_POST['int_kilosxhora_rp'], "double"),
					   GetSQLValueString($_POST['int_metroxmin_rp'], "double"),
					   GetSQLValueString($_POST['int_cod_empleado_rp'], "int"),
					   GetSQLValueString($_POST['int_cod_liquida_rp'], "int"),
					   GetSQLValueString($_POST['kiloSistema'], "double"),
					   GetSQLValueString($COSTOHORAKILOSELL, "double"));

  mysql_select_db($database_conexion1, $conexion1);
  $Result1 = mysql_query($insertSQL, $conexion1) or die(mysql_error());
 
 //INSERTA ROLLO 
//$metroIni_r=$_POST['metro_r']-$_POST['metro_r2'];
$insertSQL2 = sprintf("INSERT INTO TblSelladoRollo ( id_op_r, ref_r, bolsas_r, metro_r, metroIni_r, kilos_r, reproceso_r, rollo_r, maquina_r, numIni_r, numFin_r, cod_empleado_r, cod_auxiliar_r, turno_r, fechaI_r, fechaF_r, kilopendiente_r, rolloParcial_r,costo_r) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_op_rp'], "int"),
                       GetSQLValueString($_POST['int_cod_ref_rp'], "text"),
                       GetSQLValueString($_POST['bolsa_rp'], "int"),
					   GetSQLValueString($_POST['metro_r2'], "int"),
					   GetSQLValueString($_POST['metroIni_r'], "int"),
					   GetSQLValueString($_POST['int_total_kilos_rp'], "double"),
					   GetSQLValueString($_POST['reproceso'], "double"),
					   GetSQLValueString($_POST['rollo_rp'], "int"),
                       GetSQLValueString($_POST['str_maquina_rp'], "int"),
                       GetSQLValueString($_POST['n_ini_rp'], "text"),
                       GetSQLValueString($_POST['n_fin_rp'], "text"),
                       GetSQLValueString($_POST['int_cod_empleado_rp'], "int"),
                       GetSQLValueString($_POST['int_cod_liquida_rp'], "int"),
                       GetSQLValueString($_POST['turno_rp'], "int"),
                       GetSQLValueString($_POST['fecha_ini_rp'], "text"),
                       GetSQLValueString($_POST['fecha_fin_rp'], "text"),
					   GetSQLValueString($_POST['kiloSistema'], "double"),
					   GetSQLValueString($_POST['rolloParcial_r'], "text"),
					   GetSQLValueString($COSTOHORAKILOSELL, "double"));

  mysql_select_db($database_conexion1, $conexion1);
  $Result2 = mysql_query($insertSQL2, $conexion1) or die(mysql_error()); 





//INSERTAR ARRAYS DE TIEMPOS Y DESPERDICIOS
  if (!empty ($_POST['id_rpt'])&&!empty ($_POST['valor_tiem_rt'])){
    foreach($_POST['id_rpt'] as $key=>$v)
    $a[]= $v;
    foreach($_POST['valor_tiem_rt'] as $key=>$v)
    $b[]= $v;
    $c= $_POST['id_op_rp'];	
	
	for($i=0; $i<count($a); $i++) {
		  if(!empty($a[$i])&&!empty($b[$i])){ //no salga error con campos vacios
 $insertSQLt = sprintf("INSERT INTO Tbl_reg_tiempo (id_rpt_rt,valor_tiem_rt,op_rt,int_rollo_rt,id_proceso_rt,fecha_rt) VALUES (%s, %s, %s, %s, %s, %s)",                      
                       GetSQLValueString($a[$i], "int"),
                       GetSQLValueString($b[$i], "int"),
					   GetSQLValueString($c, "int"),
					   GetSQLValueString($_POST['rollo_rp'], "int"),
					   GetSQLValueString($_POST['id_proceso_rp'], "int"),
					   GetSQLValueString($_POST['fecha_ini_rp'], "date"));
  mysql_select_db($database_conexion1, $conexion1);
  $Resultt = mysql_query($insertSQLt, $conexion1) or die(mysql_error());
		  }
	}
}
if (!empty ($_POST['id_rtp'])&&!empty ($_POST['valor_prep_rtp'])){
    foreach($_POST['id_rtp'] as $key=>$n)
    $h[]= $n;
    foreach($_POST['valor_prep_rtp'] as $key=>$n)
    $l[]= $n;
    $c= $_POST['id_op_rp'];	
	
	for($x=0; $x<count($h); $x++) {
		  if(!empty($h[$x])&&!empty($l[$x])){ //no salga error con campos vacios
 $insertSQLp = sprintf("INSERT INTO Tbl_reg_tiempo_preparacion (id_rpt_rtp,valor_prep_rtp,op_rtp,int_rollo_rtp,id_proceso_rtp,fecha_rtp) VALUES (%s, %s, %s, %s, %s, %s)",                      
                       GetSQLValueString($h[$x], "int"),
                       GetSQLValueString($l[$x], "int"),
					   GetSQLValueString($c, "int"),
					   GetSQLValueString($_POST['rollo_rp'], "int"),
					   GetSQLValueString($_POST['id_proceso_rp'], "int"),
					   GetSQLValueString($_POST['fecha_ini_rp'], "date"));
  mysql_select_db($database_conexion1, $conexion1);
  $Resultp = mysql_query($insertSQLp, $conexion1) or die(mysql_error());
		  }
	}
}
if (!empty ($_POST['id_rpd'])&&!empty ($_POST['valor_desp_rd'])){
    foreach($_POST['id_rpd'] as $key=>$k)
    $f[]= $k;
    foreach($_POST['valor_desp_rd'] as $key=>$k)
    $g[]= $k;
 	
	for($s=0; $s<count($f); $s++) {
		  if(!empty($f[$s])&&!empty($g[$s])){ //no salga error con campos vacios
        

        $id_proceso_rp = $conexion->seleccionProceso($f[$s],$_POST['rollo_rp'],$_POST['id_op_rp'],$g[$s],$_POST['metro_r2']);

		  	//$id_proceso_rp = seleccionProceso($f[$s],$_POST['rollo_rp'],$_POST['id_op_rp'],$g[$s]);
        $id_proceso_rp = $id_proceso_rp=='' ? $_POST['id_proceso_rp'] : $id_proceso_rp;
        //$id_proceso_rp = $_POST['id_proceso_rp'];
 $insertSQLd = sprintf("INSERT INTO Tbl_reg_desperdicio (id_rpd_rd,valor_desp_rd,op_rd,int_rollo_rd,id_proceso_rd,fecha_rd,cod_ref_rd) VALUES (%s,%s, %s, %s, %s, %s, %s)",                      
                       GetSQLValueString($f[$s], "int"),
                       GetSQLValueString($g[$s], "double"),
					   GetSQLValueString($_POST['id_op_rp'], "int"),
					   GetSQLValueString($_POST['rollo_rp'], "int"),
					   GetSQLValueString($id_proceso_rp, "int"),
					   GetSQLValueString($_POST['fecha_ini_rp'], "date"),
					   GetSQLValueString($_POST['int_cod_ref_rp'], "text"));
  mysql_select_db($database_conexion1, $conexion1);
  $Resultd = mysql_query($insertSQLd, $conexion1) or die(mysql_error());
		  }
	}
} 
//UPDATE LA TABLA DE INVENTARIOS DESCONTANDO LO QUE SE GASTO EN INSUMOS
    foreach($_POST['tipoCinta_ref'] as $key=>$h)
    $cinta[]= $h;
	for($t=0; $t<count($cinta); $t++) {
		  if(!empty($cinta[$t])){ 
  $updateINV = sprintf("UPDATE TblInventarioListado SET Salida=Salida + %s WHERE Codigo = %s",
					   GetSQLValueString($_POST['metro_r2'], "text"), 
                       GetSQLValueString($cinta[$t], "int"));
  mysql_select_db($database_conexion1, $conexion1);
  $ResultINV = mysql_query($updateINV, $conexion1) or die(mysql_error());
  
//REGISTRO DEL VALOR DE EL INSUMO
 	  $sqlcostoMP="SELECT valor_unitario_insumo AS valorkilo FROM insumo WHERE id_insumo = $cinta[$t]"; 
	  $resultcostoMP=mysql_query($sqlcostoMP); 
	  $numcostoMP=mysql_num_rows($resultcostoMP); 
	  $row_valoresMP = mysql_fetch_assoc($resultcostoMP);
	  $contValor=0;
      $valorMP = $row_valoresMP['valorkilo']; 
	  				 
 $insertSQLkp = sprintf("INSERT INTO Tbl_reg_kilo_producido (id_rpp_rp,valor_prod_rp,op_rp,int_rollo_rkp,id_proceso_rkp,fecha_rkp,costo_mp) VALUES (%s, %s, %s, %s, %s, %s, %s)",                      
                       GetSQLValueString($cinta[$t], "int"),
                       GetSQLValueString($_POST['metro_r2'], "text"),  
					   GetSQLValueString($_POST['id_op_rp'], "int"),
					   GetSQLValueString($_POST['rollo_rp'], "int"),
					   GetSQLValueString($_POST['id_proceso_rp'], "int"),
					   GetSQLValueString($_POST['fecha_ini_rp'], "date"),
					   GetSQLValueString($valorMP, "double"));
  mysql_select_db($database_conexion1, $conexion1);
  $Resultkp = mysql_query($insertSQLkp, $conexion1) or die(mysql_error());
//FIN  
   
		  }
	}
//SUMA AL INVENTARIO LAS REFERENCIA DE BOLSA
   $updateINV2 = sprintf("UPDATE TblInventarioListado SET Entrada=Entrada + %s WHERE Codigo = %s",
					   GetSQLValueString($_POST['bolsa_rp'], "int"),
                       GetSQLValueString($_POST['ref_inven'], "text"));

  mysql_select_db($database_conexion1, $conexion1);
  $ResultINV2 = mysql_query($updateINV2, $conexion1) or die(mysql_error());	
	
//SI LOS ROLLOS EREGISTRADOS EN SELLADO SON IGUALES A LOS DE EXTRUSION SE CAMBIA EL ESTADO EN OP A FINALIZADA	
$updateSQL3 = sprintf("UPDATE Tbl_orden_produccion SET  b_estado_op=%s,f_sellada=DATE(%s) WHERE id_op=%s", 
                       GetSQLValueString($_POST['estado'], "text"),
					   GetSQLValueString($_POST['fecha_fin_rp'], "date"),
					   GetSQLValueString($_POST['id_op_rp'], "int"));
  mysql_select_db($database_conexion1, $conexion1);
  $Result3 = mysql_query($updateSQL3, $conexion1) or die(mysql_error());	
 
//RETORNO
$insertGoTo = "produccion_registro_sellado_total_vista.php?id_op=" . $_POST['id_op_rp'] ."";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  } 
  header(sprintf("Location: %s", $insertGoTo));
}
//INSERT
 


$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
//ROLLOS SELLADO
$colname_rollo = "-1";
if (isset($_GET['id_op'])) {
  $colname_rollo = (get_magic_quotes_gpc()) ? $_GET['id_op'] : addslashes($_GET['id_op']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_rollo = sprintf("SELECT id_op_r,rollo_r,fechaI_r,maquina_r,cod_empleado_r, cod_auxiliar_r,fechaF_r FROM TblSelladoRollo WHERE id_op_r='%s' ORDER BY fechaF_r DESC LIMIT 1",$colname_rollo);//order por fecha porq los pueden ingresar en orden aleatorio
$rollo = mysql_query($query_rollo, $conexion1) or die(mysql_error());
$row_rollo = mysql_fetch_assoc($rollo);
$totalRows_rollo = mysql_num_rows($rollo);

/*$id_op = $row_rollo['id_op_r'];
$rolloNum = $row_rollo['rollo_r'];
$fechaNum = $row_rollo['fechaI_r'];
//ORDEN DE PRODUCCION*/
$colname_op= "-1";
if (isset($_GET['id_op'])) {
  $colname_op = (get_magic_quotes_gpc()) ? $_GET['id_op'] : addslashes($_GET['id_op']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_orden_produccion = sprintf("SELECT * FROM Tbl_orden_produccion WHERE id_op=%s AND b_borrado_op='0' ORDER BY id_op DESC",$colname_op);
$orden_produccion = mysql_query($query_orden_produccion, $conexion1) or die(mysql_error());
$row_orden_produccion = mysql_fetch_assoc($orden_produccion);
$totalRows_orden_produccion = mysql_num_rows($orden_produccion);
 
//MAQUINAS
mysql_select_db($database_conexion1, $conexion1);
$query_maquinas = "SELECT * FROM maquina WHERE proceso_maquina='4' ORDER BY id_maquina DESC";
$maquinas= mysql_query($query_maquinas, $conexion1) or die(mysql_error());
$row_maquinas = mysql_fetch_assoc($maquinas);
$totalRows_maquinas = mysql_num_rows($maquinas);
//CODIGO EMPLEADO
/*mysql_select_db($database_conexion1, $conexion1);
$query_codigo_empleado = "SELECT * FROM empleado WHERE tipo_empleado IN(7,9) ORDER BY nombre_empleado ASC";
$codigo_empleado = mysql_query($query_codigo_empleado, $conexion1) or die(mysql_error());
$row_codigo_empleado = mysql_fetch_assoc($codigo_empleado);
$totalRows_codigo_empleado = mysql_num_rows($codigo_empleado);*/
 //ID DEL ROLLO
mysql_select_db($database_conexion1, $conexion1);
$query_ultimo = "SELECT id_r FROM TblSelladoRollo ORDER BY id_r DESC";
$ultimo = mysql_query($query_ultimo, $conexion1) or die(mysql_error());
$row_ultimo = mysql_fetch_assoc($ultimo);
$totalRows_ultimo = mysql_num_rows($ultimo);
//INFORMACION DE ROLLOS DISPONIBLES DE IMPRESION PARA SELLADO
$colname_Rollo_I = "-1";
if (isset($_GET['id_op'])) {
  $colname_Rollo_I = (get_magic_quotes_gpc()) ? $_GET['id_op'] : addslashes($_GET['id_op']);
}
mysql_select_db($database_conexion1, $conexion1);
 $query_Rollo_I = sprintf("SELECT TblImpresionRollo.id_r, TblImpresionRollo.rollo_r FROM TblImpresionRollo WHERE TblImpresionRollo.id_op_r='%s' AND TblImpresionRollo.rollo_r NOT IN (SELECT TblSelladoRollo.rollo_r FROM TblSelladoRollo WHERE TblSelladoRollo.id_op_r=TblImpresionRollo.id_op_r AND TblSelladoRollo.rollo_r=TblImpresionRollo.rollo_r)",$colname_Rollo_I);
$Rollo_I = mysql_query($query_Rollo_I, $conexion1) or die(mysql_error());
$row_Rollo_I = mysql_fetch_assoc($Rollo_I);
$totalRows_Rollo_I = mysql_num_rows($Rollo_I);
//SI NO TIENE IMPRESION LA O.P SE DIRIGE A EXTRUSION
if($totalRows_Rollo_I=='0'){
 
mysql_select_db($database_conexion1, $conexion1);
 $query_Rollo_I = sprintf("SELECT TblExtruderRollo.id_r, TblExtruderRollo.rollo_r  FROM TblExtruderRollo WHERE TblExtruderRollo.id_op_r='%s' AND TblExtruderRollo.rollo_r NOT IN (SELECT TblSelladoRollo.rollo_r FROM TblSelladoRollo WHERE TblSelladoRollo.id_op_r=TblExtruderRollo.id_op_r AND TblSelladoRollo.rollo_r=TblExtruderRollo.rollo_r)",$colname_Rollo_I);
$Rollo_I = mysql_query($query_Rollo_I, $conexion1) or die(mysql_error());
$row_Rollo_I = mysql_fetch_assoc($Rollo_I);
$totalRows_Rollo_I = mysql_num_rows($Rollo_I);
}
//CARGA LOS CAMPOS DINAMICOS
mysql_select_db($database_conexion1, $conexion1);
$query_tiempo_muertos = "SELECT * FROM Tbl_reg_tipo_desperdicio WHERE Tbl_reg_tipo_desperdicio.id_proceso_rtd='4' AND Tbl_reg_tipo_desperdicio.codigo_rtp='1' AND estado_rtp='0' ORDER BY Tbl_reg_tipo_desperdicio.nombre_rtp ASC";
$tiempo_muertos = mysql_query($query_tiempo_muertos, $conexion1) or die(mysql_error());
$row_tiempo_muertos = mysql_fetch_assoc($tiempo_muertos);
$totalRows_tiempo_muertos = mysql_num_rows($tiempo_muertos);

mysql_select_db($database_conexion1, $conexion1);
$query_tiempo_preparacion = "SELECT * FROM Tbl_reg_tipo_desperdicio WHERE Tbl_reg_tipo_desperdicio.id_proceso_rtd='4' AND Tbl_reg_tipo_desperdicio.codigo_rtp='2' AND estado_rtp='0' ORDER BY Tbl_reg_tipo_desperdicio.nombre_rtp ASC";
$tiempo_preparacion = mysql_query($query_tiempo_preparacion, $conexion1) or die(mysql_error());
$row_tiempo_preparacion = mysql_fetch_assoc($tiempo_preparacion);
$totalRows_tiempo_preparacion = mysql_num_rows($tiempo_preparacion);

mysql_select_db($database_conexion1, $conexion1);
$query_desperdicios = "SELECT * FROM Tbl_reg_tipo_desperdicio WHERE Tbl_reg_tipo_desperdicio.id_proceso_rtd='4' AND Tbl_reg_tipo_desperdicio.codigo_rtp='3' AND estado_rtp='0' ORDER BY Tbl_reg_tipo_desperdicio.nombre_rtp ASC";
$desperdicios = mysql_query($query_desperdicios, $conexion1) or die(mysql_error());
$row_desperdicios = mysql_fetch_assoc($desperdicios);
$totalRows_desperdicios = mysql_num_rows($desperdicios);

//EL ID_REF ES ENVIADO DESDE VISTA DE REFERENCIA

$refop = $_GET['id_op'] == '' ? 0 : $_GET['id_op'];

$row_referencia = $conexion->llenarCampos('tbl_orden_produccion as op ', "JOIN tbl_referencia as ref ON op.int_cod_ref_op = ref.cod_ref WHERE op.id_op='".$refop."' ", '',"ref.id_ref, ref.calibre_ref,ref.ancho_ref,ref.tipoCinta_ref,ref.cod_ref,ref.version_ref,op.id_termica_op" );
 

 $row_codigo_empleado = $conexion->llenaSelect('empleado a INNER JOIN TblProcesoEmpleado b ','ON a.codigo_empleado=b.codigo_empleado WHERE a.tipo_empleado IN(7,9) AND b.estado_empleado=1 ','ORDER BY a.nombre_empleado ASC');
   
 $row_revisor = $conexion->llenaSelect('empleado a INNER JOIN TblProcesoEmpleado b ','ON a.codigo_empleado=b.codigo_empleado WHERE a.tipo_empleado IN(7,9) AND b.estado_empleado=1 ','ORDER BY a.nombre_empleado ASC');
 
/*$colname_referencia = "-1";
if (isset($_GET['id_op'])) {
  $colname_referencia = (get_magic_quotes_gpc()) ? $_GET['id_op'] : addslashes($_GET['id_op']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_referencia = sprintf("SELECT * FROM Tbl_orden_produccion,Tbl_referencia WHERE Tbl_orden_produccion.id_op='%s' AND Tbl_orden_produccion.id_ref_op=Tbl_referencia.id_ref", $colname_referencia);
$referencia = mysql_query($query_referencia, $conexion1) or die(mysql_error());
$row_referencia = mysql_fetch_assoc($referencia);
$totalRows_referencia = mysql_num_rows($referencia);*/



 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISADGE AC &amp; CIA</title>
 

<script src="librerias/sweetalert/dist/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="librerias/sweetalert/dist/sweetalert.css">
<link rel="stylesheet" type="text/css" href="css/general.css"/>

<link href="css/formato.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/formato.js"></script>
<script type="text/javascript" src="js/validacion_numerico.js"></script>
<script type="text/javascript" src="js/consulta.js"></script>
<script type="text/javascript" src="js/ajax_sellado.js"> </script>
<script type="text/javascript" src="AjaxControllers/js/numeracionInicial.js"></script> 
 

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

<script>
//Metodo II: Deshabilitar el bot�n Enviar
function checkSubmit() {
    document.getElementById("btsubmit").value = "Enviando...";
    document.getElementById("btsubmit").disabled = true;
    return true;
}
</script>
<script language="javascript" type="text/javascript">
var upload_number=1;
	function tiemposM() {
	var i=0;
 	var d = document.createElement("div");
	var file0 = document.createElement("select");
 	file0.setAttribute("name", "id_rpt[]");
	file0.setAttribute("onChange", "restakilosT()" );
	file0.options[i] = new Option('T.Muertos','');
	i++;
	<?php do { ?>
    file0.options[i] = new Option('<?php echo $row_tiempo_muertos['nombre_rtp']?>','<?php echo $row_tiempo_muertos['id_rtp']?>');
	i++;
    <?php
        } while ($row_tiempo_muertos = mysql_fetch_assoc($tiempo_muertos));
         $rows = mysql_num_rows($tiempo_muertos);
             if($rows > 0) {
                 mysql_data_seek($tiempo_muertos, 0);
               $row_tiempo_muertos = mysql_fetch_assoc($tiempo_muertos);
        }?> 		
	file0.setAttribute("style", "width:150px" );
	d.appendChild(file0);
 	var file = document.createElement("input");
 	file.setAttribute("type", "number");
 	file.setAttribute("name", "valor_tiem_rt[]");
	file.setAttribute("min", "0" );
	file.setAttribute("placeholder", "Tiempo minutos" );
	file.setAttribute("style", "width:60px" );
	file.setAttribute("onChange", "restakilosT()" ); 
	d.appendChild(file); 
	
	
 	document.getElementById("moreUploads").appendChild(d);
 	upload_number++;
}
</script>
<script language="javascript" type="text/javascript">
var upload_number=1;
	function tiemposP() {
	var i=0;
 	var e = document.createElement("div");
	var file0 = document.createElement("select");
 	file0.setAttribute("name", "id_rtp[]");
	file0.setAttribute("onChange", "restakilosT()" );
	file0.options[i] = new Option('T.Preparacion','');
	i++;
	<?php do { ?>
    file0.options[i] = new Option('<?php echo $row_tiempo_preparacion['nombre_rtp']?>','<?php echo $row_tiempo_preparacion['id_rtp']?>');
	i++;
    <?php
        } while ($row_tiempo_preparacion = mysql_fetch_assoc($tiempo_preparacion));
         $rows = mysql_num_rows($tiempo_preparacion);
             if($rows > 0) {
                 mysql_data_seek($tiempo_preparacion, 0);
               $row_tiempo_preparacion = mysql_fetch_assoc($tiempo_preparacion);
        }?> 
	file0.setAttribute("style", "width:150px" );
	e.appendChild(file0);
 	var file = document.createElement("input");
 	file.setAttribute("type", "number");
 	file.setAttribute("name", "valor_prep_rtp[]");
	file.setAttribute("min", "0" );
	file.setAttribute("placeholder", "Tiempo minutos" );
	file.setAttribute("style", "width:60px" );
	file.setAttribute("onChange", "restakilosT()" ); 
	e.appendChild(file); 
	
 	document.getElementById("moreUploads2").appendChild(e);
 	upload_number++;
}
</script>
<script language="javascript" type="text/javascript">
var upload_number=1;
	function tiemposD() {
	var i=0;
 	var f = document.createElement("div");
	var file0 = document.createElement("select");
 	file0.setAttribute("name", "id_rpd[]");
	/*file0.setAttribute("onChange", "restakilosD();kiloComparativoSell()"); */
	file0.options[i] = new Option('Desperdicio','');
	i++;
	<?php do { ?>
    file0.options[i] = new Option('<?php echo $row_desperdicios['nombre_rtp']?>','<?php echo $row_desperdicios['id_rtp']?>');
	i++;
    <?php
        } while ($row_desperdicios = mysql_fetch_assoc($desperdicios));
         $rows = mysql_num_rows($desperdicios);
             if($rows > 0) {
                 mysql_data_seek($desperdicios, 0);
               $row_desperdicios = mysql_fetch_assoc($desperdicios);
        }?>
	file0.setAttribute("style", "width:150px" );
	f.appendChild(file0);
 	var file = document.createElement("input");
 	file.setAttribute("type", "number");
 	file.setAttribute("name", "valor_desp_rd[]" );
	file.setAttribute("min", "0" );
	file.setAttribute("step", "0.01" );
	file.setAttribute("placeholder", "Kilos" );
	file.setAttribute("style", "width:60px" );
	file.setAttribute("onChange", "restakilosD();kiloComparativoSell()"); 
	f.appendChild(file); 
	
 	document.getElementById("moreUploads3").appendChild(f);
 	upload_number++;
}

</script>
 <script>
function parcial() {	
  var idrollo=document.getElementById("idrollo").value;
  if(idrollo !=''){
  swal({
  title: 'Rollo Parcial o Total!',
  text: "Que desea Hacer Con el Rollo:", 
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Liquidar Total !',
  cancelButtonText: 'Dejar Parcial !',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  closeOnConfirm: false,
  closeOnCancel: false
  //allowOutsideClick:true//cierra dando clic fuera
},
function(isConfirm) {
	
 	var txt;
  if (isConfirm === true) {
    swal(
      'Liquidar Rollo!',
      'ok para Liquidar Total.',
      'success'
    );
	txt = 0;
    } else if (isConfirm === false) {
    swal(
      'Dejar Parcial',
      'ok para Dejar parcial :)',
      'error'
    );
	txt = 1;
    } else {
		
	 //outside click, isConfirm is undefinded
  }
    document.getElementById("rolloParcial_r").value = txt;
     submitform();
	
})
  }else{
	  swal(
      '[ERROR] Debe escoger un Rollo'
    );
	  
	  }

 }

  function submitform(){
 	var bolsa_rp=(document.form1.bolsa_rp.value);
 	var total_horas_rp=(document.form1.total_horas_rp.value);
 	var tiempoOptimo_rp=(document.form1.tiempoOptimo_rp.value);
 	var int_kilosxhora_rp=(document.form1.int_kilosxhora_rp.value);
 	var indice7 = document.getElementById("n_ini_rp").value;
	var indice8 = document.getElementById("n_fin_rp").value;

    if( bolsa_rp == '') { 
        swal('Debe llenar el Campo: Bolsas x Rollo! ');
        return false;
      }else if( total_horas_rp == '' ) { 
        swal('Debe llenar el Campo: Total Horas Trabajadas ! ');
        return false;
      }else if( tiempoOptimo_rp == '') { 
        swal('Debe llenar el Campo: Tiempo Optimo! ');
        return false;
      }else if(int_kilosxhora_rp =='') { 
        swal('Debe llenar el Campo: Kilos*Hora! ');
        return false; 
      }else if((indice7  != 0 && indice8 == '') || (indice7  == '' && indice8 == '')) {  
		
		swal('[ERROR] Ingrese las numeraciones');
		 return false;  
	  }else{
        document.form1.submit(); 
         return true;
      }
  
}

</script>
   </head>
<body ><!--onload="kilosxHora2();"-->
<?php echo $conexion->header('vistas'); ?>
  <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" onSubmit="return(parcial() || restakilosD())">
 
<table class="table table-bordered table-sm">
  <tr id="tr1">
    <td colspan="4" id="titulo2">REGISTRO DEL ROLLO EN SELLADO</td>
  </tr>
  <tr>
    <td rowspan="6" id="dato2"><img src="images/logoacyc.jpg"/></td>
    <td colspan="3" id="dato2">
      <select name="idrollo" id="idrollo" onclic="window.location.reload();" onchange="getClientData(this.name,this.value); " style="width:50px" onfocus="" required >
        <option value="" >Rollo</option>
        <?php
			do {  
		?>
        <option value="<?php echo $row_Rollo_I['id_r']?>"><?php echo $row_Rollo_I['rollo_r'];?></option>
        <?php
			} while ($row_Rollo_I = mysql_fetch_assoc($Rollo_I));
			  $rows = mysql_num_rows($Rollo_I);
			  if($rows > 0) {
				  mysql_data_seek($Rollo_I, 0);
				  $row_Rollo_I = mysql_fetch_assoc($Rollo_I);
			  }
			?>
        </option>
        </select>      <a href="javascript:location.reload()"><img src="images/ciclo1.gif" alt="RESTAURAR"title="RESTAURAR" border="0" style="cursor:hand;"/></a></td>
    </tr>
  <tr id="tr1">
    <td colspan="2" nowrap="nowrap" id="dato2">ORDEN DE PRODUCCION</td>
    <td id="dato3"> Ingresado por
      <input name="str_responsable_rp" type="text" id="str_responsable_rp" value="<?php echo $row_usuario['nombre_usuario']; ?>" size="15" readonly="readonly"/></td>
  </tr>
  <tr id="tr3">
    <td colspan="2" nowrap="nowrap" id="numero2"><?php echo $row_orden_produccion['id_op'];?></td>
    <td nowrap="nowrap" id="fuente2"><?php $ultipo_reg = $row_ultimo['id_r']+1?>
      <input type="hidden" name="id_r" id="id_r" value="<?php echo $ultipo_reg; ?>" /></td> 
  </tr>
  <tr id="tr1">
    <td colspan="2" nowrap="nowrap" id="dato2">REFERENCIA</td>
    <td id="dato2">VERSION</td>
  </tr>
  <tr>
    <td colspan="2" nowrap="nowrap" id="numero2"><?php echo $row_referencia['cod_ref'];?></td>
    <td nowrap="nowrap" id="numero2"><?php echo $row_orden_produccion['version_ref_op'];?></td>
  </tr>
  <tr>
    <td colspan="3" id="dato2">
      Ref Ancho: <input type="text" readonly="readonly" name="ancho" id="ancho" style="width:50px" value="<?php echo $row_referencia['ancho_ref']=='' ? 0 : $row_referencia['ancho_ref'];?>"/>
      Calibre: <input type="text" readonly="readonly" name="calibre" id="calibre"  style="width:50px" value="<?php echo $row_referencia['calibre_ref'];?>" />
     </td> 
     <td id="dato2">&nbsp;</td>
  </tr>
  <tr id="tr1"> 
    <td colspan="4" id="titulo4">DETALLE CONSUMO</td>
  </tr>
  <tr>
    <td colspan="4" id="fuente2">&nbsp; 
      </td>
  </tr>
 <tr>
   <td id="fuente1"><p>Peso Inicial </p>
     <p>
  <input type="hidden" name="placa_rp" id="placa_rp" style="width:80px" required="required" readonly="readonly"/>
     <input type="hidden" name="kiloInicial" id="kiloInicial" style="width:60px" value=""/>
     <input type="text" name="int_kilos_prod_rp" id="int_kilos_prod_rp" min="0" step="any" required="required" style="width:60px" value="" readonly="readonly" onchange="restakilosT();"/>
     </p></td> 
   <td id="fuente1"><p>Consumo Kg</p>
     <p>
       <input type="number" name="int_total_kilos_rp" id="int_total_kilos_rp" min="0.10" step="any" style="width:60px" required="required" value="" readonly="readonly" />Consumo
     </p></td> 
   <td id="fuente1">Bolsas x Rollo
     <input type="number" name="bolsa_rp" min="1" id="bolsa_rp" readonly="readonly" style="width:80px" required="required" onchange="kiloComparativoSell();kiloDisponible();restakilosT();"/></td>
   <td id="fuente1"><p>Reproceso</p>
     <p>
       <input type="number" min="0.00" step="any" style="width:80px" name="reproceso" id="reproceso"  required="required" onchange="kiloComparativoSell();" value="0"/>
     </p></td>
 </tr>
 <tr>
   <td id="fuente1"><!--Lamina 1 kg <?php $laminas = $row_producido['lamina']/2;?>-->
     <p>Metro Inicial </p>
     <p>
  <input name="metroInicial"  readonly="readonly" type="hidden" id="metroInicial" min="1" style="width:60px" value="" /> <!-- readonly -->
  <input name="metro_r" type="number" id="metro_r" min="1" style="width:60px" value="" required="required" readonly="readonly"/>
     </p></td>
    <td id="fuente1"><!--<input type="number" name="lam1_rp" id="lam1_rp" min="0" step="0.01" style="width:80px" required="required" value=""/>--><!--Lamina 2 klg--><!--<input type="number" name="lam2_rp" id="lam2_rp" min="0" step="0.01" style="width:80px" required="required" onblur="return validacion_sellado();" value=""/>-->
      <p>Metro Final </p>
      <p>
        <input name="metro_r2" id="metro_r2" type="number" required="required" style="width:60px" min="0" step="any" value=""  readonly="readonly"/>Consumo
      </p></td>
    <td id="fuente1">&nbsp;</td>
   <td id="fuente1"><input type="number" name="turno_rp" id="turno_rp" min="1" max="7" step="1" required="required" style="width:80px" value="1"/>
     Turno </td>
 </tr>
  <tr>
      <td id="fuente2">&nbsp;</td>
      <td colspan="2" id="fuente1">&nbsp;</td>
      <td id="fuente2">&nbsp;</td>
      </tr>
  <tr id="tr1">
    <td id="fuente1">Maquina<strong>
      <input name="standby" id="standby" type="hidden" value="0" size="5"/>
      <input name="valor_tiem_rt" id="valor_tiem_rt" type="hidden" size="5" value="0"/>
      <input name="valor_prep_rt" id="valor_prep_rt" type="hidden" size="5" value="0"/>
    </strong></td>
    <td id="fuente1"><?php
	  $rangoHora = '8'; //si pasa un turno resetea los nombres
	  $fechaActual = fechaHoraDatelocal();
	  $fechaFinal = $row_rollo['fechaF_r'];
	  $datetime1 = new DateTime($fechaActual);
      $datetime2 = new DateTime($fechaFinal);
      $diffech = $datetime1->diff($datetime2);
if($diffech->y >0 || $diffech->m >0 || $diffech->d >0 || $diffech->h > $rangoHora){
	$maquinacero='';
	$empleadocero='';
	$auxiliarcero='';
  }else{
  	$maquinacero=$row_rollo['maquina_r'];
 	$empleadocero=$row_rollo['cod_empleado_r'];
 	$auxiliarcero=$row_rollo['cod_auxiliar_r'];	
	}
  	  ?>
      <select name="str_maquina_rp" id="maquina" style="width:155px"  required><!--maquina();-->
      <option value=""<?php if (!(strcmp("", $maquinacero))) {echo "selected=\"selected\"";} ?>>Maquina</option>
      <?php
do {  
?>
      <option value="<?php echo $row_maquinas['id_maquina']?>"<?php if (!(strcmp($row_maquinas['id_maquina'], $maquinacero))) {echo "selected=\"selected\"";} ?>><?php echo $row_maquinas['nombre_maquina']?></option>
      <?php
} while ($row_maquinas = mysql_fetch_assoc($maquinas));
  $rows = mysql_num_rows($maquinas);
  if($rows > 0) {
      mysql_data_seek($maquinas, 0);
	  $row_maquinas = mysql_fetch_assoc($maquinas);
  }
?>
  </select></td>

  <td id="fuente1"> 
  	     <select name="int_cod_empleado_rp"  style="width:120px" id="operario" required>
  	       <option value=""<?php if (!(strcmp("", $empleadocero))) {echo "selected=\"selected\"";} ?>>Operario</option>
  	       <?php  foreach($row_codigo_empleado as $row_codigo_empleado ) { ?>
  	         <option value="<?php echo $row_codigo_empleado['codigo_empleado']?>"<?php if (!(strcmp($row_codigo_empleado['codigo_empleado'], $empleadocero))) {echo "selected=\"selected\"";} ?>><?php echo $row_codigo_empleado['codigo_empleado']." - ".$row_codigo_empleado['nombre_empleado']." ".$row_codigo_empleado['apellido_empleado']?></option>
  	       <?php } ?>
  	     </select>
  	</td>
  	   <td id="fuente1">

  	     <select name="int_cod_liquida_rp" style="width:120px" id="auxiliar" >
  	         <option value=""<?php if (!(strcmp("", $auxiliarcero))) {echo "selected=\"selected\"";} ?>>Revisor</option>
  	       <?php  foreach($row_revisor as $row_revisor ) { ?>
  	         <option value="<?php echo $row_revisor['codigo_empleado']?>"<?php if (!(strcmp($row_revisor['codigo_empleado'], $auxiliarcero))) {echo "selected=\"selected\"";} ?>><?php echo $row_revisor['codigo_empleado']." - ".$row_revisor['nombre_empleado']." ".$row_revisor['apellido_empleado']?></option>
  	       <?php } ?>
  	     </select>
      </td>

<!--     <td id="fuente1">
    	<select name="int_cod_empleado_rp"  style="width:120px" id="operario"  required>
      <option value=""<?php if (!(strcmp("", $empleadocero))) {echo "selected=\"selected\"";} ?>>Operario</option>
      <?php
do {  
?>
      <option value="<?php echo $row_codigo_empleado['codigo_empleado']?>"<?php if (!(strcmp($row_codigo_empleado['codigo_empleado'], $empleadocero))) {echo "selected=\"selected\"";} ?>><?php echo $row_codigo_empleado['codigo_empleado']." - ".$row_codigo_empleado['nombre_empleado']." ".$row_codigo_empleado['apellido_empleado']?></option>
      <?php
} while ($row_codigo_empleado = mysql_fetch_assoc($codigo_empleado));
  $rows = mysql_num_rows($codigo_empleado);
  if($rows > 0) {
      mysql_data_seek($codigo_empleado, 0);
	  $row_codigo_empleado = mysql_fetch_assoc($codigo_empleado);
  }
?>
    </select></td>
    <td colspan="2" id="fuente1"> 
        <select name="int_cod_liquida_rp" style="width:120px" id="auxiliar" >
        <option value=""<?php if (!(strcmp("", $auxiliarcero))) {echo "selected=\"selected\"";} ?>>Revisor</option>
        <?php
do {  
?>
        <option value="<?php echo $row_codigo_empleado['codigo_empleado']?>"<?php if (!(strcmp($row_codigo_empleado['codigo_empleado'], $auxiliarcero))) {echo "selected=\"selected\"";} ?>><?php echo $row_codigo_empleado['codigo_empleado']." - ".$row_codigo_empleado['nombre_empleado']." ".$row_codigo_empleado['apellido_empleado']?></option>
        <?php
} while ($row_codigo_empleado = mysql_fetch_assoc($codigo_empleado));
  $rows = mysql_num_rows($codigo_empleado);
  if($rows > 0) {
      mysql_data_seek($codigo_empleado, 0);
	  $row_codigo_empleado = mysql_fetch_assoc($codigo_empleado);
  }
?>
      </select>
  </td> -->
    </tr>
  <tr>
    <td colspan="2" id="dato1"></td>
    <td colspan="3" id="dato1"></td>
    <td colspan="3" id="dato1"></td>
    <td colspan="2" id="dato1"></td>
  </tr>
  <tr>
    <td id="fuente1">Fecha Inicial</td>
    <td colspan="2" id="fuente1"> <?php 
	        //VALIDA QUE SI PASO 8 HORAS ME RESETE LA FECHA INICIAL
			    //$ultimaF = $row_rollo['fechaF_r'];
			    $ultimaF = $row_rollo['fechaF_r']=='' ? date("Y-m-d H:i") : $row_rollo['fechaF_r'];
				  $horaAdd='4032';//16 es si la fecha del ultimo rollo supera en 16 horas entonces coloca la actual
  				$fechahoraofinal = sumarHorasparam($ultimaF,$horaAdd);
   			  ?><input name="fecha_ini_rp" id="fecha_ini_rp" type="datetime-local" min="2000-01-02" value="<?php  echo $fechahoraofinal; ?>"<?php /*if($fechahoraofinal !=''){ echo "readonly"; }else{echo $fechahoraofinal;} */echo $fechahoraofinal; ?>  size="15" onChange="restakilosT()" required="required" />
   	</td>
    <td colspan="2" id="fuente1"><input type="number" name="rollo_rp" id="rollo_rp" min="0"step="any" required="required" readonly="readonly" placeholder="Rollos" style="width:46px" value=""/>
   de
  <?php 
	  $id_op_r=$row_orden_produccion['id_op'];
	  $sqlExt="SELECT COUNT(rollo_r) AS rollo_ex FROM TblExtruderRollo WHERE id_op_r='$id_op_r'";
	  $resultExt= mysql_query($sqlExt);
	  $numExt= mysql_num_rows($resultExt);
	  if($numExt >='1')
	  { 
	  $rollo_ex = mysql_result($resultExt, 0, 'rollo_ex'); 
	  }else{echo $rollo_ex='0';}
	  
  	  $id_op_r=$row_orden_produccion['id_op'];
	  $sqlPro="SELECT COUNT(DISTINCT rollo_r) AS rollo_sell FROM TblSelladoRollo WHERE id_op_r='$id_op_r'";
	  $resultPro= mysql_query($sqlPro);
	  $numPro= mysql_num_rows($resultPro);
	  if($numPro >='1')
	  { 
	  $rollo_pro = mysql_result($resultPro, 0, 'rollo_sell');//este dice de cuantos en total 
	  }else
	  { $rollo_pro='0';}
	  //PARA CAMBIO DE ESTADO	  
	  if(($rollo_pro + 1) >= $rollo_ex)// + 1 porque debe ser mayor
	  {
 	   $rollos_iguales='5';//FINALIZADA
	  }else 
	  {$rollos_iguales='4';//CONTINUA EN SELLADO
	  }
	  ?>
<input type="hidden" name="estado" id="estado" value="<?php echo $rollos_iguales;?>" />
<input name="int_total_rollos_rp" type="number" id="int_total_rollos_rp" placeholder="Rollos" style="width:46px" min="0"step="any" value="<?php echo $rollo_ex;?>" readonly="readonly"/>
Total Rollos </td>
  </tr>
  <tr id="tr1">
    <td id="fuente1">Fecha Final</td>
    <td colspan="2" id="fuente1"><input name="fecha_fin_rp" id="fecha_fin_rp" type="datetime-local" min="2000-01-02" size="15" onChange="restakilosT()" required="required"/></td>
    <td colspan="2" id="fuente1"><p>Metro Restante</p>
      <p>
        <input name="metroIni_r" type="number" id="metroIni_r" step="any" style="width:60px" value="" required="required" readonly="readonly" />
      </p></td>
  </tr>
 <tr>
    <td id="fuente1">Total Horas Trabajadas</td>
    <td colspan="3" id="fuente1">
      <input name="total_horas_rp" id="total_horas_rp" type="text" required="required" readonly="readonly" placeholder="total horas" value="" size="15"/>
      
      Tiempo Optimo
      <input name="rodamiento_rp" id="tiempoOptimo_rp" type="text" size="5"  onclick="restakilosT();" required="required" placeholder="rodamientos"  value="" readonly="readonly"/></td> 
  </tr> 
  <tr id="tr1">
    <td id="fuente1">Numeracion Inicial</td>
    <td colspan="2" id="fuente1">
    	<input type="hidden" name="numInicioControl" id="numInicioControl" value=""/>
    	<input type="text" name="n_ini_rp" id="n_ini_rp" size="15" required="required" onBlur="conMayusculas(this);" value="" />
      <input id="porcentaje" name="porcentaje" type="hidden" value="<?php echo $row_orden_produccion['int_desperdicio_op']; ?>" min="0" max="100" step="1" style="width:40px" required="required" readonly="readonly"/>
  </td>
    <td colspan="2" id="fuente1"><p>Numeracion Final </p>
      <p>
  <input type="text" name="n_fin_rp" id="n_fin_rp" style="width:116px" required="required" onblur="conMayusculas(this);"/>
      </p></td>
  </tr>
  <tr>
    <td id="fuente1">Desperdicio Operario</td>
    <td colspan="2" id="fuente1"> 
      <input type="text" name="int_kilos_desp_rp" id="int_kilos_desp_rp" min="0" step="any" required="required" size="7" placeholder="Desp.oper" value="0" readonly="readonly" />
      <input type="number" name="kiloSistema" id="kiloSistema" style="width:55px" required="required" placeholder="Sistema" min="0.00" step="any" value="0" readonly="readonly" onclick="kiloComparativoSell();kiloDisponible();restakilosT();"/></td>
    <td colspan="2" id="fuente1"><input name="int_kilosxhora_rp" type="number" required="required" id="int_kilosxhora_rp" min="0.10" step="any" value="" style="width:116px" onclick="restakilosT();" readonly="readonly"/>
      Kilos*Hora</td>
  </tr>
  <tr>
    <td  id="fuente1">&nbsp; </td>
    <td id="fuente1"><input type="hidden" name="rolloParcial_r" id="rolloParcial_r"  value="" />      <!--<p id="demo"></p>-->
      </td>
    <td id="fuente1">&nbsp;</td>
    <td id="dato4">&nbsp;</td>
  </tr>
    <tr>
    <td  id="dato4">&nbsp;</td>
    <td id="dato4">&nbsp;</td>
    <td id="dato4"> </td>
    <td id="dato3"><input type="button" name="ENVIAR" id="ENVIAR" class="botonGeneral" value="GUARDAR" onclick="parcial();validaTodoSell()"/></td>
  </tr>
  <tr>
  <td colspan="7">
  <table style="width:100%; " > 
   <tr id="tr1"> 
            <td colspan="2"id="dato1">Desperdicios</td>
            <td id="dato1">Tiempos Muertos</td>
            <td id="dato1">Tiempos Preparacion</td>
            
          </tr>
          <tr>
           
            <td colspan="2" id="dato1"><input type="button" class="botonFinalizar" name="button3" id="button3" value="Crear otra fila" onClick="desperdicio();" style="width:125px"/></td>
            <td id="dato1"><input type="button" class="botonFinalizar" name="button" id="button" value="Crear otra fila" onClick="tiempoM();" style="width:125px"/></td>
            <td  id="dato1"><input type="button" class="botonFinalizar" name="button2" id="button2" value="Crear otra fila" onClick="tiempoP();" style="width:125px"/></td> 
          <tr>
 
            <td colspan="2" id="dato1"><div id="moreUploads3"></div></td>
            <td id="dato1"><div id="moreUploads"></div></td>
            <td id="dato1" ><div id="moreUploads2"></div></td>
          </tr>
    </table>
    </td> 
</tr>
   <tr>
      <td colspan="2" id="fuente4"><!--INSUMOS Y REFERENCIA-->
      	<input type="hidden" name="cod_ref" id="cod_ref"  value="<?php echo $row_referencia['cod_ref'];?>"/>
        <input type="hidden" name="tipoCinta_ref[]" id="tipoCinta_ref[]"  value="<?php echo $row_referencia['id_termica_op'];?>"/>
      <input type="hidden" name="tipoCinta_ref[]" id="tipoCinta_ref[]"  value="<?php echo $row_referencia['tipoCinta_ref'];?>"/>
        <input type="hidden" name="ref_inven" id="ref_inven" value="<?php echo $row_referencia['cod_ref']."-".$row_referencia['version_ref'];?>"/></td>
      </tr>
  <tr id="tr1">
    <td colspan="4" id="dato2"><!--<?php  for ($r=0;$r<=$totalRows_Rollo-1;$r++) { ?>
      <input name="kilos_sellado[]" type="hidden" id="kilos_sellado[]" value="<?php $tK=mysql_result($Rollos,$r,int_total_kilos_rp); echo $tK; ?>" />
      <?php } ?> --><strong>
      <input type="hidden" name="horas_muertas_rp" id="horasmuertas"  size="12"  value="0" />
      <input type="hidden" name="horas_prep_rp" id="horasprep"  size="12" value="0" />
      <input name="id_proceso_rp" type="hidden" id="id_proceso_rp" value="4" />
      <input name="id_op_rp" type="hidden" id="id_op_rp" value="<?php echo $row_orden_produccion['id_op']; ?>" />
      <input name="id_ref_rp" type="hidden" id="id_ref_rp" value="<?php echo $row_referencia['id_ref']; ?>" />
      <input name="int_cod_ref_rp" type="hidden" id="int_cod_ref_rp" value="<?php echo $row_orden_produccion['int_cod_ref_op']; ?>" />
      <input name="version_ref_rp" type="hidden" id="version_ref_rp" value="<?php echo $row_orden_produccion['version_ref_op']; ?>" />
      <input type="hidden" name="MM_insert" value="form1" />
      <input name="int_metroxmin_rp" id="metroxmin" type="hidden" size="5" value=""/>
      </strong></td>
  </tr>
</table>
  </form>
  <?php echo $conexion->header('footer'); ?>
</body>
</html>
<script type="text/javascript">
	 numeracioInicial();
function enviodeFormulario(){ 
     var resul =validaTodoSell();

      enviodeForms(resul);
    
}

</script>
<?php
mysql_free_result($usuario); 
mysql_free_result($orden_produccion);
mysql_free_result($maquinas);
mysql_free_result($codigo_empleado);
?>
