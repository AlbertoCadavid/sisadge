<?php require_once('Connections/conexion1.php'); ?>
<?php
    include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
        //FECHAS DEL AÑO ACTUAL
	$ano=$_GET['ano'];
    $fecha1=first_year_month2($ano);
	$fecha2=last_year_month2($ano);
	//Recepción variables
    $proceso = $_GET['proceso'];
    $tipoDesp = $_GET['tipoDesp'];
	$codigo = $_GET['codigo'];
	
mysql_select_db($database_conexion1, $conexion1);
if($codigo=='1'){
$consulta="SELECT id_rt,SUM(valor_tiem_rt) AS valor,fecha_rt FROM tbl_reg_tiempo WHERE id_rpt_rt='$tipoDesp' AND id_proceso_rt='$proceso' AND DATE(fecha_rt) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rt) ASC";
$tipov="TABLA DE TIEMPOS MUERTOS / HORAS";
$medida="minutoaHoras";
}
if($codigo=='2'){
$consulta="SELECT id_rt,SUM(valor_prep_rtp) AS valor,fecha_rtp FROM tbl_reg_tiempo_preparacion WHERE id_rpt_rtp='$tipoDesp' AND id_proceso_rtp='$proceso' AND DATE(fecha_rtp) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rtp) ASC";
$tipov="TABLA DE TIEMPOS DE PREPARACION / HORAS";
$medida="minutoaHoras";
}
if($codigo=='3'){
$consulta="SELECT id_rd,SUM(valor_desp_rd) AS valor,fecha_rd FROM tbl_reg_desperdicio WHERE id_rpd_rd='$tipoDesp' AND id_proceso_rd='$proceso' AND DATE(fecha_rd) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rd) ASC";
$tipov="TABLA DE DESPERDICIOS / KILOS";
$medida="vacia";
}
$r=mysql_query($consulta, $conexion1);

$d=mysql_num_rows($r);
if($d>0){
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=archivo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo("<table border=1>");
	echo("<tr><td colspan='12'> $tipov </td></tr>");
	echo("<tr>");
  	$array=(array("Enero","Febre","Marzo","Abril", "Mayo", "Junio", "Julio", "Agost", "Septi", "Octub", "Noviem", "Dicie"));
	$cont = 0;
	foreach($array as $value){
	print "<td>".$value."</td>";
	$cont++;
	}
    echo("</tr>");
    echo ("<tr>");
	while($registro=mysql_fetch_row($r)){
		$dato1=$medida($registro[1]);// minutoaHoras
 		echo ("<td> $dato1 </td>");
 	}
	echo("</tr>");
	echo("</table>");
}
else{
echo("No hay registros en la tabla");
}
mysql_close();
?>
