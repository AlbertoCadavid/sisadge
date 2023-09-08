<?php require_once('Connections/conexion1.php'); ?>
<?php
	include("class/pDraw.class.php");
	include("class/pImage.class.php");
	include("class/pPie.class.php");
	include("class/pData.class.php");
    include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
    //FECHAS DEL AÑO ACTUAL
    $fecha1=first_year_month();
	$fecha2=last_year_month();
	mysql_select_db($database_conexion1, $conexion1);
	//select avg(clave) from personal group by clave
	$consulta="SELECT id_rt,SUM(valor_prep_rtp) AS valor,fecha_rtp FROM tbl_reg_tiempo_preparacion WHERE DATE(fecha_rtp) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rtp) ASC";
	$r=mysql_query($consulta, $conexion1) or die(mysql_error());

	echo("<table  border='1' align='center'>");
 	echo"<tr><td colspan='100%'><strong>GRAFICA DE TIEMPOS DE PREPARACION /HORAS</strong></td></tr>";
 
    echo("<tr>");
	$tabla=new pData();
	while ($registro = mysql_fetch_row($r)) {
	$dato1=minutoaHoras($registro[1]);
	$fech=$registro[2];//mes 
 	echo("<td><strong>".soloMes($fech)."</strong></td>"); //imprime mes
	$tabla->addPoints(array($dato1),"serie");
	echo("<td>$dato1</td>"); //imprime valores
	$tabla->AddPoints(array(soloMes($fech)),"etiquetas");//define la columna mes 
    } 
    echo("</tr>");
    echo("</table>");
 
	  //$tabla->addPoints(array("Kilos","Tipo"),"etiquetas");
	 //$tabla->AddPoints(array("Ene","Feb","Mar","Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"),"etiquetas"); //define la columna mes 
	 $tabla->setSerieDescription("serie","Sexo");
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


