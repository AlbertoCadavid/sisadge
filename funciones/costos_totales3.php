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
//LLAMADO A FUNCIONES
include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
//FIN	
/*$fecha2= date("Y-m-d");
$fecha1=restaMes($fecha2);*/

$fecha2= '2014-01-31';
$fecha1= '2014-01-01';

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion1, $conexion1);
$query_usuario = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $colname_usuario);
$usuario = mysql_query($query_usuario, $conexion1) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
 
$sqlgga="SELECT TblDetalleGGAProd.ValorCaracGGA,TblCaracGGA.IDCaracGGA,TblCaracGGA.ValorBolsaGGA  
FROM TblCaracGGA,TblDetalleGGAProd WHERE TblDetalleGGAProd.IDCaracGGA=TblCaracGGA.IDCaracGGA AND    
DATE(TblDetalleGGAProd.FechaInicio) BETWEEN '$fecha1' AND '$fecha2' AND DATE(TblDetalleGGAProd.FechaFin) BETWEEN '$fecha1' AND '$fecha2'";
$resultgga=mysql_query($sqlgga);
$row_ggaycif=mysql_fetch_assoc($resultgga);
$totalRows_ggaycif=mysql_num_rows($resultgga);	    

mysql_select_db($database_conexion1, $conexion1); 
$query_consumo = "SELECT * FROM Tbl_reg_produccion WHERE b_borrado_rp='0' AND DATE(fecha_ini_rp) BETWEEN '$fecha1'
AND '$fecha2' AND DATE(fecha_fin_rp) BETWEEN '$fecha1' AND '$fecha2' ORDER BY fecha_ini_rp DESC";
$consumo = mysql_query($query_consumo, $conexion1) or die(mysql_error());
$row_consumo = mysql_fetch_assoc($consumo);
$totalRows_consumo = mysql_num_rows($consumo);

mysql_select_db($database_conexion1, $conexion1);
$query_manodeobra = "SELECT * FROM TblProcesoEmpleado WHERE DATE(fechainicial_empleado) BETWEEN '$fecha1'
AND '$fecha2' AND DATE(fechafinal_empleado) BETWEEN '$fecha1' AND '$fecha2' ORDER BY proceso_empleado ASC";	
$manodeobra = mysql_query($query_manodeobra, $conexion1) or die(mysql_error());
$row_manodeobra = mysql_fetch_assoc($manodeobra);
$totalRows_manodeobra = mysql_num_rows($manodeobra);
?><html>
<head>
<title>SISADGE AC &amp; CIA</title>
<link rel="StyleSheet" href="css/formato.css" type="text/css">
<script type="text/javascript" src="js/formato.js"></script>
<script type="text/javascript" src="js/listado.js"></script>
</head>
<body><div align="center">
<table id="tabla3">
  <?php do { ?>
    <tr onMouseOver="uno(this,'CBCBE4');" onMouseOut="dos(this,'#FFFFFF');" bgcolor="#FFFFFF" bordercolor="#ACCFE8">   
      <td class="centrado6"><?php echo $row_consumo['int_cod_ref_rp'];?></td>
      <td class="centrado6"><?php echo $row_consumo['id_op_rp'];?></td>
      <td nowrap class="centrado6"><?php echo /*soloFecha(*/$row_consumo['fecha_ini_rp']/*)*/;?></td>
      <td class="Estilo6"> 
        <?php 
		$op=$row_consumo['id_op_rp']; 	
		$sqlchm="SELECT str_nit_op,nombre_c FROM Tbl_orden_produccion,cliente WHERE id_op=$op AND str_nit_op=nit_c";
		$resultchm=mysql_query($sqlchm); $numchm=mysql_num_rows($resultchm);
		if ($numchm>='1') { 
		$cliente=mysql_result($resultchm,0,'nombre_c'); 	
		echo $cliente; }
		?></td>
      <td class="Estilo6">
	    <?php 
		$rp=$row_consumo['id_ref_rp']; 	
		$sqlref="SELECT tipo_bolsa_ref FROM Tbl_referencia WHERE id_ref=$rp";
		$resultref=mysql_query($sqlref); $numref=mysql_num_rows($resultref);
		if ($numref>='1') { 
		$tipoBolsa=mysql_result($resultref,0,'tipo_bolsa_ref'); 	
		echo $tipoBolsa; }
		?></td>
      <td class="centrado6">
        <?php 
		$rp=$row_consumo['id_ref_rp'];
		$sqln="SELECT ancho_ref,largo_ref,solapa_ref FROM Tbl_referencia WHERE id_ref=$rp"; 
		$resultn=mysql_query($sqln); 
		$numn=mysql_num_rows($resultn); 
		if($numn >= '1') 
		{ $ancho=mysql_result($resultn,0,'ancho_ref');
		$largo=mysql_result($resultn,0,'solapa_ref');
		$solapa=mysql_result($resultn,0,'largo_ref'); 
		$area_b = $ancho*$largo;
		$area_s = $ancho*$solapa;
		$area_t=$area_b+$area_s; echo $area_t;
		} else { echo " ";	
	    }?></td>
      <td class="centrado6"><?php echo $row_consumo['bolsa_rp'];//produccion?></td>
      <td class="centrado6"><?php 
		$rp=$row_consumo['id_ref_rp']; 	
		$sqlref="SELECT tipo_bolsa_ref,material_ref,adhesivo_ref FROM Tbl_referencia WHERE id_ref=$rp";
		$resultref=mysql_query($sqlref); $numref=mysql_num_rows($resultref);
		if ($numref>='1') { 
		$tipoBolsa=mysql_result($resultref,0,'tipo_bolsa_ref');
		$materialBolsa=mysql_result($resultref,0,'material_ref');
		$adhesivo=mysql_result($resultref,0,'adhesivo_ref');
		$seguridad="SEGURIDAD";$currier="CURRIER";$bolsaP="BOLSA PLASTICA";$bolsaM="BOLSA MONEDA";
		$natur="NATURAL";$pigm="PIGMENTADO";
		$adheC="CINTA DE SEGURIDAD";$adheH="HOT MELT";
		if($tipoBolsa==$seguridad && ($materialBolsa==$pigm || $materialBolsa==$natur) && $adhesivo==$adheC){
			$nivel="1"; echo $nivel;
			} else 
			if($tipoBolsa==$currier && ($materialBolsa==$pigm || $materialBolsa==$natur) && $adhesivo==$adheH){
				$nivel="2"; echo $nivel;
				} else 
			   if($tipoBolsa==$bolsaP && ($materialBolsa==$pigm || $materialBolsa==$natur) && $adhesivo=="N.A."){
				   $nivel="2"; echo $nivel;
				   } else 
			      if($tipoBolsa==$bolsaM && ($materialBolsa==$natur) && $adhesivo==$adheH){
				      $nivel="2"; echo $nivel;
				      }
						  }else{
						 echo "N.A."; 
		}
		?>	  
      </td>
      <td class="centrado6">
	  <?php 
	    $Nivel =$nivel;
		$area_to=$area_t;
		echo $row_ggaycif['ValorBolsaGGA'];
		echo "GGA Y CIF";
/*		for ($x=1; $x<=count($Nivel);$x++){
		if($x==1&&$area_to<=500){
		 echo $row_ggaycif['ValorCaracGGA'];	
			}else if($x==2&&$area_to<=1000){
				 echo $row_ggaycif['ValorCaracGGA'];
				}else if($x==3&&$area_to<=4000){
				    echo $row_ggaycif['ValorCaracGGA'];
				   }
			    //echo $Nivel;
			}*/
		
/*		if($Nivel==1&&$area_to<=500){
		 echo $row_ggaycif['ValorCaracGGA'];	
			}else if($Nivel==1&&$area_to<=1000){
				 echo $row_ggaycif['ValorCaracGGA'];
				}else if($Nivel==1&&$area_to<=4000){
				    echo $row_ggaycif['ValorCaracGGA'];
				   }if($Nivel==2&&$area_to<=500){
					 echo $row_ggaycif['ValorCaracGGA'];	
						}else if($Nivel==2&&$area_to<=1000){
							 echo $row_ggaycif['ValorCaracGGA'];
							}else if($Nivel==2&&$area_to<=4000){
								echo $row_ggaycif['ValorCaracGGA'];
							   }if($Nivel==3&&$area_to<=500){
								 echo $row_ggaycif['ValorCaracGGA'];	
									}else if($Nivel==3&&$area_to<=1000){
										 echo $row_ggaycif['ValorCaracGGA'];
										}else if($Nivel==3&&$area_to<=4000){
											echo $row_ggaycif['ValorCaracGGA'];
										   }*/
				 

	  ?></td>
      <td class="centrado6"><?php 
	  $id_ref=$row_consumo['id_ref_rp'];
	  $sqlmezcla="SELECT * FROM Tbl_produccion_mezclas WHERE id_ref_pm='$id_ref' AND b_borrado_pm='0'"; 
	  $resultmezcla=mysql_query($sqlmezcla); 
	  $nummezcla=mysql_num_rows($resultmezcla); 
	  if($nummezcla >= '1') 
	  { $mezc1=mysql_result($resultmezcla,0,'int_ref1_tol1_pm');
        $mezc2=mysql_result($resultmezcla,0,'int_ref2_tol1_pm'); 
		$mezc3=mysql_result($resultmezcla,0,'int_ref3_tol1_pm');
		$mezc4=mysql_result($resultmezcla,0,'int_ref1_tol2_pm');
		$mezc5=mysql_result($resultmezcla,0,'int_ref2_tol2_pm'); 
		$mezc6=mysql_result($resultmezcla,0,'int_ref3_tol2_pm'); 
		$mezc7=mysql_result($resultmezcla,0,'int_ref1_tol3_pm');
		$mezc8=mysql_result($resultmezcla,0,'int_ref2_tol3_pm'); 
		$mezc9=mysql_result($resultmezcla,0,'int_ref3_tol3_pm'); 
		$arraymezcla=array($mezc1,$mezc2,$mezc3,$mezc4,$mezc5,$mezc6,$mezc7,$mezc8,$mezc9);
		
		if(count($arraymezcla)) {
		  foreach ($arraymezcla as $v) {
			$sqlref="SELECT descripcion_insumo,valor_unitario_insumo FROM insumo WHERE `descripcion_insumo` = '$v'";
			$resultref= mysql_query($sqlref);
			$numref= mysql_num_rows($resultref);
			for ($y=0;$y < $numref;$y++){
       		 $valor_ins=mysql_result($resultref,$y,'valor_unitario_insumo');
				//echo $valor_ins."\n	";
				$Total+=$valor_ins;
				}
			}
			$valor=$Total/$row_consumo['bolsa_rp'];
			echo numeros_format($valor);
			}
			
	  }
	  ?></td>
      <td class="centrado6">
    <?php $proceso=$row_manodeobra['proceso_empleado']; 	
	$sqlpro="SELECT id_pa,valor_pa FROM TblProcesoAjuste WHERE fechaInicial_pa='$fecha1' AND fechaFinal_pa='$fecha2' id_proceso_pa=1";
	$resultpro=mysql_query($sqlpro); $numpro=mysql_num_rows($resultpro);
	if ($numpro>='1') { 	
	$valor_pa=mysql_result($resultpro,0,'valor_pa'); 
	 }?> 
    <?php $empleados=$row_manodeobra['proceso_empleado']; 	
	$sqlemp="SELECT COUNT(proceso_empleado) AS empleados FROM TblProcesoEmpleado WHERE proceso_empleado=$empleados";
	$resultemp=mysql_query($sqlemp); $numemp=mysql_num_rows($resultemp);
	if ($numemp>='1') { 
	$cant_empleado=mysql_result($resultemp,0,'empleados'); 
	}?>
    <?php $maquinas=$row_manodeobra['proceso_empleado']; 
	$sqlmaq="SELECT COUNT(proceso_maquina) AS maq FROM maquina WHERE proceso_maquina=$maquinas";
	$resultmaq=mysql_query($sqlmaq); 
	$nummaq=mysql_num_rows($resultmaq);
	if ($nummaq>='1') { 
	$Tmaquinas=mysql_result($resultmaq,0,'maq');
	//echo $Tmaquinas;
	}?>
    <?php 
	$p_empleado=$row_manodeobra['proceso_empleado']; 	
	$sqlchm="SELECT COUNT(proceso_empleado) AS registros, SUM(costo_empleado) AS costo FROM TblProcesoEmpleado WHERE proceso_empleado=$p_empleado";
	$resultchm=mysql_query($sqlchm); $numchm=mysql_num_rows($resultchm);
	if ($numchm>='1') { 
	$registros=mysql_result($resultchm,0,'registros'); 	
	$dias_empleado=$row_costos['dias_empleado']; 
	$cost=mysql_result($resultchm,0,'costo'); 
	$c_HoraM=$cost/($dias_empleado*8);
	$costoHoraM = $c_HoraM/$registros;//para la operacion * operario x turno y maquina
	}?>
    <?php $operarioxMaqu=$cant_empleado/$Tmaquinas;//operario por maquina?>
    <?php $operarioxTurnoM=($operarioxMaqu/$valor_pa);//para la operacion $costoHoraM * operario x turno y maquina ?>
    <?php $costoxPxLxT=($costoHoraM*$operarioxTurnoM); //echo numeros_format($costoxPxLxT);//costo hora proceso x linea $costoHoraM * $operarioxTurnoM?>
    <?php 
    $op_rp=$row_consumo['id_op_rp'];
	$fecha=$row_consumo['fecha_ini_rp'];
	$sqlex="SELECT TIMEDIFF(fecha_fin_rp,fecha_ini_rp) AS horasT FROM Tbl_reg_produccion WHERE b_borrado_rp='0' AND id_op_rp='$op_rp' AND fecha_ini_rp='$fecha'"; 
	$resultex=mysql_query($sqlex); 
	$numex=mysql_num_rows($resultex); 
	if($numex >= '1') 
	{ $tHoras_ex=mysql_result($resultex,0,'horasT'); //echo $BolsaxHora=$tHoras_ex; }if ($BolsaxHora==NULL) {echo "00:00:00";
	}	
	?>
    <?php 
    $op_rp=$row_consumo['id_op_rp'];
	$fecha=$row_consumo['fecha_ini_rp'];
	$sqlexm="SELECT SUM(valor_tiem_rt) AS horasM FROM Tbl_reg_tiempo WHERE op_rt='$op_rp' AND fecha_rt='$fecha'"; 
	$resultexm=mysql_query($sqlexm); 
	$numexm=mysql_num_rows($resultexm); 
	if($numexm >= '1') 
	{ $horasM=mysql_result($resultexm,0,'horasM');  }
	  
	$sqlexp="SELECT SUM(valor_prep_rtp) AS horasP FROM Tbl_reg_tiempo_preparacion WHERE op_rtp='$op_rp' AND fecha_rtp='$fecha'"; 
	$resultexp=mysql_query($sqlexp); 
	$numexp=mysql_num_rows($resultexp); 
	if($numexp >= '1') 
	{ $horasP=mysql_result($resultexp,0,'horasP'); }  
	?>    
    <?php //costo M.O.D Neto
	$TiempoDesperdicio=$horasM+$horasP;
	$Total_bolsaSellado=$row_consumo['bolsa_rp'];	
	//Tiempo en minutos
    $TiempoMinutos= hoursToSecods($tHoras_ex);//total tiempo y pasado a minutos 
	echo $sumaTiempos=$TiempoMinutos+$TiempoDesperdicio;
	$BolsaxHora=$Total_bolsaSellado/$sumaTiempos;
	$MOD=$costoxPxLxT/$BolsaxHora;
	//echo $MOD;
	?>
    </td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"></td>
      <td class="centrado6"><?php echo $row_consumo['int_kilos_desp_rp'];?>
      <?php
/*	  if($proceso=='2'){ //ESTYE CONTROL ES PARA MOSTRAR EL DESPERDICIO DE MATERIA PRIMA O TINTAS
	  $kilos_exd=$row_consumo['kdesp'];
	  echo numeros_format($kilos_exd);
	  }else{	   
	  $fecha=$row_consumo['fecha_rkp'];	  
	  $sqlexd="SELECT SUM(valor_desp_rd) AS kgDespe FROM Tbl_reg_desperdicio WHERE fecha_rd='$fecha'"; 
	  $resultexd=mysql_query($sqlexd); 
	  $numexd=mysql_num_rows($resultexd); 
	  if($numexd >= '1') 
	  { $kilos_exd=mysql_result($resultexd,0,'kgDespe'); echo numeros_format($kilos_exd); }else {echo "0,00";}
	  }*/
	  ?></td>
    </tr>
    <?php } while ($row_consumo = mysql_fetch_assoc($consumo)); ?>
</table></div>
</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($consumo);
?>
