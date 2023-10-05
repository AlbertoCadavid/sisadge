<?php require_once('Connections/conexion1.php'); ?>
<?php
	include("class/pDraw.class.php");
	include("class/pImage.class.php");
	include("class/pPie.class.php");
	include("class/pData.class.php");
    include('funciones/funciones_php.php');//SISTEMA RUW PARA LA BASE DE DATOS 
    //FECHAS DEL AÑO ACTUAL
    $fecha1=first_year_month();
	$fecha2=date("Y-m-d");
	mysql_select_db($database_conexion1, $conexion1);
 
	//$consulta="SELECT id_rd,SUM(valor_desp_rd) AS valor,fecha_rd FROM Tbl_reg_desperdicio WHERE DATE(fecha_rd) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rd) ASC";
 
	$maqui = $_GET['maqui'];
	$proceso = $_GET['proceso'];
	
	 $xmaquina='';
	 $xproceso = '';
	 $general=1;
	 if($maqui=='0' && $proceso=='0'){ 
	 	$consulta="SELECT id_rd,SUM(valor_desp_rd) AS valor,fecha_rd FROM Tbl_reg_desperdicio WHERE DATE(fecha_rd) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rd) ASC";
	 	$general=0;
	 }else
	 if($maqui!='0' && $proceso=='0'){
	 	$xmaquina = " AND tabla2.str_maquina_rp= $maqui ";
	 	$consulta="SELECT tabla1.id_rd,SUM(tabla1.valor_desp_rd) AS valor,tabla1.fecha_rd FROM Tbl_reg_desperdicio tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rd = tabla2.id_op_rp AND DATE(tabla1.fecha_rd) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina  GROUP BY MONTH(tabla1.fecha_rd) ASC"; 
	 }else
	 if($maqui=='0' && $proceso!='0'){ 
	 	$xproceso = " AND tabla1.id_proceso_rd=$proceso AND tabla2.id_proceso_rp=$proceso "; 	
	 	$consulta="SELECT tabla1.id_rd,SUM(tabla1.valor_desp_rd) AS valor,tabla1.fecha_rd FROM Tbl_reg_desperdicio tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rd = tabla2.id_op_rp AND DATE(tabla1.fecha_rd) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rd) ASC"; 
	 }else
	 if($maqui!='0' && $proceso!='0'){
	 	$xmaquina = " AND tabla2.str_maquina_rp= $maqui";
	 	$xproceso = " AND tabla2.id_proceso_rp=$proceso AND tabla1.id_proceso_rd=$proceso "; 
	 	$consulta="SELECT tabla1.id_rd,SUM(tabla1.valor_desp_rd) AS valor,tabla1.fecha_rd FROM Tbl_reg_desperdicio tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rd = tabla2.id_op_rp AND DATE(tabla1.fecha_rd) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rd) ASC";  
	 } 

	$r=mysql_query($consulta, $conexion1) or die(mysql_error());
    
    if($general == 0){
    	  	echo("<table  border='1' align='center'>");
    		echo("<tr><td colspan='12'><strong>GRAFICA DE TIEMPOS Y DESPERDICIOS / AÑO ACTUAL</strong></td></tr>");
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
    			$dato1=($registro[1]);// minutoaHoras
    	 		echo ("<td> $dato1 </td>");
    	 	}
    		echo("</tr>");
    		echo("</table>");

             
              $r2=mysql_query($consulta, $conexion1) or die(mysql_error()); 
    		    echo("<table  border='1' align='center'>"); 
              echo("<tr>");
          	$tabla2=new pData();
          	while ($registro = mysql_fetch_row($r2)) {
          	$dato1=minutoaHoras($registro[1]); 
          	$tabla2->addPoints(array($dato1),"serie"); 
          	$fech=$registro[2];//mes 
            
          	$tabla2->AddPoints(array(soloMes($fech)),"etiquetas");//define la columna mes 
                 } 
              echo("</tr>");
              echo("</table>");
           
          	  //$tabla->addPoints(array("Kilos","Tipo"),"etiquetas");
          	 //$tabla->AddPoints(array("Ene","Feb","Mar","Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"),"etiquetas"); //define la columna mes 
          	 $tabla2->setSerieDescription("serie","Fecha");
          	 $tabla2->setAbscissa("etiquetas");
          	 $imagen=new pImage(600,400,$tabla2, TRUE);
          	 $pastel=new pPie($imagen,$tabla2);
          	 $pastel->draw3DPie(250,240,array("Radius"=>180,"DrawLabels"=>TRUE,"LabelStacked"=>TRUE,"Border"=>TRUE,"WriteValues"=>TRUE));//propiedades circulo
          	 $imagen->Render("images/graficapastel.png");
          	 echo("<br>");
          	 echo("<br>");
          	 echo("<br>");
          	 echo("<br>");
           	 echo ("<img src=\"images/graficapastel.png\">");

    	}else{ 
    mysql_select_db($database_conexion1, $conexion1);
    $r=mysql_query($consulta, $conexion1);
 	echo("<table border='1' align='center'>"); 
 	echo"<tr><td colspan='100%'><strong>GRAFICA DE DESPERDICIO / KILOS / AÑO ACTUAL</strong></td></tr>";
 
    echo("<tr>");
	$tabla=new pData();
	while ($registro = mysql_fetch_row($r)) {
	$dato1=$registro[1];
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
    }

mysql_close();
?>


