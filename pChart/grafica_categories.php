<?php require_once('Connections/conexion1.php'); ?>
<?php
	include("class/pDraw.class.php");
	include("class/pImage.class.php");
	include("class/pPie.class.php");
	include("class/pData.class.php");
    include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 

    //FECHAS DEL AÑO ACTUAL
	$ano=$_GET['ano'];
    $fecha1=first_year_month2($ano);
	$fecha2=last_year_month2($ano);
 	//Recepción variables
    $proceso = $_GET['proceso'];
    $tipoDesp = $_GET['tipoDesp'];
	$codigo = $_GET['codigo'];
	//CONTROL TODOS 
	if($proceso!="Todos" && $tipoDesp!="Todos"){
		//tipos
		$id_rpt_rt= "id_rpt_rt='$tipoDesp' AND ";
		$id_rpt_rtp="id_rpt_rtp='$tipoDesp' AND ";
		$id_rpd_rd="id_rpd_rd='$tipoDesp' AND ";
		$id_consumo="id_rpp_rp='$tipoDesp' AND ";			
 		//procesos
		$id_proceso_rt="id_proceso_rt='$proceso' AND ";
		$id_proceso_rtp="id_proceso_rtp='$proceso' AND ";
		$id_proceso_rd="id_proceso_rd='$proceso' AND ";
		$id_proceso_rkp="id_proceso_rkp='$proceso' AND ";
 	    } 
		if($proceso!="Todos" && $tipoDesp=="Todos"){
		//tipos
		$id_rpt_rt="";
		$id_rpt_rtp="";
		$id_rpd_rd="";
		$id_consumo="";
		//procesos
		$id_proceso_rt="id_proceso_rt='$proceso' AND ";
		$id_proceso_rtp="id_proceso_rtp='$proceso' AND ";
		$id_proceso_rd="id_proceso_rd='$proceso' AND ";
		$id_proceso_rkp="id_proceso_rkp='$proceso' AND ";
		} 
		if($proceso=="Todos" && $tipoDesp==""){
		//tipos
		$id_rpt_rt="";
		$id_rpt_rtp="";
		$id_rpd_rd="";
		$id_consumo="";
		//procesos		
		$id_proceso_rt="";
		$id_proceso_rtp="";
		$id_proceso_rd="";
		$id_proceso_rkp="";
	}
    //imprimir variables
	mysql_select_db($database_conexion1, $conexion1);
	if($codigo=='1'){
	$consulta="SELECT id_rt,SUM(valor_tiem_rt) AS valor,fecha_rt FROM tbl_reg_tiempo WHERE $id_rpt_rt $id_proceso_rt DATE(fecha_rt) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rt) ASC";
	$tipov="TIEMPOS MUERTOS / HORAS";
	$medida="minutoaHoras"; 
	}
	if($codigo=='2'){
	$consulta="SELECT id_rt,SUM(valor_prep_rtp) AS valor,fecha_rtp FROM tbl_reg_tiempo_preparacion WHERE $id_rpt_rtp $id_proceso_rtp DATE(fecha_rtp) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rtp) ASC";
	$tipov="TIEMPOS DE PREPARACION / HORAS";
	$medida="minutoaHoras";
	}	
	if($codigo=='3'){
	$consulta="SELECT id_rd,SUM(valor_desp_rd) AS valor,fecha_rd FROM tbl_reg_desperdicio WHERE $id_rpd_rd $id_proceso_rd DATE(fecha_rd) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rd) ASC";
	$tipov="DESPERDICIOS / KILOS";
	$medida="vacia";
 	}
  	$r=mysql_query($consulta, $conexion1) or die(mysql_error());
	
 
	echo("<table  border='1' align='center'>");
	echo"<tr><td colspan='100%'><strong>GRAFICA DE $tipov</strong></td></tr>";
    echo("<tr>");
	echo("<td><strong>Desperdicio</strong></td>");
	$tabla=new pData();
	while ($registro = mysql_fetch_row($r)) {
	$dato1= $medida($registro[1]); //minutoaHoras
	$tabla->addPoints(array($dato1),"serie"); 
	$fech=$registro[2];//mes 
 	echo("<td><strong>".soloMes($fech)."</strong></td>"); //imprime mes
 	echo("<td>".redondear_decimal_operar($dato1)."</td>"); //imprime valores
	$tabla->AddPoints(array(soloMes($fech)),"etiquetas");//define la columna mes 
     
	$totaldatos+=$dato1;
	
	  
	   } 
    echo("</tr>");
	
	if($codigo=='3')//3 si es desperdicio
	{
		
	if($proceso=='1')//1 si proceso es extruder
	{
		
	 //IMPRIME TOTALES CONSUMO X MES
	$consulta2="SELECT SUM(valor_prod_rp) AS valor,fecha_rkp FROM tbl_reg_kilo_producido WHERE $id_consumo $id_proceso_rkp DATE(fecha_rkp) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rkp) ASC";
   	$r2=mysql_query($consulta2, $conexion1) or die(mysql_error());	
	
	$kproceso="Extruidos";
	}
	
	if($proceso=='2')//3 si proceso IMPRESION
	{
		
	 //IMPRIME TOTALES CONSUMO X MES IMPRESION
	$consulta2="SELECT SUM(kilos_r) AS valor,fechaF_r FROM tblimpresionrollo WHERE DATE(fechaF_r) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fechaF_r) ASC";
   	$r2=mysql_query($consulta2, $conexion1) or die(mysql_error());	
	$kproceso="Impresos";
	}	
	if($proceso=='4')//4 si proceso ES SELLADO
	{
		
	 //IMPRIME TOTALES CONSUMO X MES de sellado colocar tabla
	$consulta2="SELECT SUM(kilos_r) AS valor,fechaF_r FROM tblselladorollo WHERE DATE(fechaF_r) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fechaF_r) ASC";
   	$r2=mysql_query($consulta2, $conexion1) or die(mysql_error());	
	
	$kproceso="Sellados";
	}	
    echo("<tr>");
	echo("<td><strong>Kilos $kproceso</strong></td>");
	$tabla2=new pData();
	while ($registro2 = mysql_fetch_row($r2)) {
	$dato2= $registro2[0];//kilos
	$tabla2->addPoints(array($dato2),"serie"); 
	$fech2=$registro2[1];//mes 
  	echo("<td><strong>".soloMes($fech2)."</strong></td>"); //imprime mes
 	echo("<td>".redondear_decimal_operar($dato2)."</td>"); //imprime valores
	$tabla2->AddPoints(array(soloMes($fech2)),"etiquetas");//define la columna mes
	   } 
    echo("</tr>");
	/*echo"<tr><td colspan='100%'><strong>CUMPLIMIENTO</strong></td></tr>";
	echo("<td><strong>".soloMes($fech2)."</strong></td>"); //imprime mes
	$cumple = porcentaje3($dato2,$dato1);
	echo(" <td>$cumple</td></tr>"); */
	}
	
	echo("</table>");
	
 	echo("<br>");
    echo "<td><strong>Total Desp:</strong> ".redondear_decimal_operar($totaldatos)."</td>";
	//IMRPIME PASTEL//
	  //$tabla->addPoints(array("Kilos","Tipo"),"etiquetas");
	 //$tabla->AddPoints(array("Ene","Feb","Mar","Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"),"etiquetas");//define la columna mes  
	 $tabla->setSerieDescription("serie","Fecha");
	 $tabla->setAbscissa("etiquetas");
	 $imagen=new pImage(600,400,$tabla, TRUE);
	 $pastel=new pPie($imagen,$tabla);
	 $pastel->draw3DPie(250,240,array("Radius"=>180,"DrawLabels"=>TRUE,"LabelStacked"=>TRUE,"Border"=>TRUE,"WriteValues"=>TRUE));//propiedades circulo
	 $imagen->Render("images/graficapastel.png");
	 echo("<br>");
	 echo("<br>");
	 echo("<br>");
	 echo("<br>");
  	 echo ("<img src=\"images/graficapastel.png\">");

mysql_close();
?>


