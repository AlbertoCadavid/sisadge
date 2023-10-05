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
	
    $codigo = $_GET['codigo'];
	$proceso = $_GET['proceso'];
	$maqui = $_GET['maqui'];
	$general=1;
mysql_select_db($database_conexion1, $conexion1);
 
 if($codigo=='1'){
	
	 $xmaquina='';
	 $xproceso = ''; 
	 if($maqui=='0' && $proceso=='0'){ 
	 	$consulta="SELECT id_rt,SUM(valor_tiem_rt) AS valor,fecha_rt FROM tbl_reg_tiempo WHERE DATE(fecha_rt) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rt) ASC";
	 	  
	 }else
	 if($maqui!='0' && $proceso=='0'){
	 	$xmaquina = " AND tabla2.str_maquina_rp= $maqui ";
	 	$consulta="SELECT tabla1.id_rt,SUM(tabla1.valor_tiem_rt) AS valor,tabla1.fecha_rt FROM tbl_reg_tiempo tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rt = tabla2.id_op_rp AND DATE(tabla1.fecha_rt) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina  GROUP BY MONTH(tabla1.fecha_rt) ASC";  
	 }else
	 if($maqui=='0' && $proceso!='0'){ 
	 	$xproceso = " AND tabla1.id_proceso_rt=$proceso AND tabla2.id_proceso_rp=$proceso "; 	
	 	$consulta="SELECT tabla1.id_rt,SUM(tabla1.valor_tiem_rt) AS valor,tabla1.fecha_rt FROM tbl_reg_tiempo tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rt = tabla2.id_op_rp AND DATE(tabla1.fecha_rt) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rt) ASC"; 
	 }else
	 if($maqui!='0' && $proceso!='0'){
	 	$xmaquina = " AND tabla2.str_maquina_rp= $maqui";
	 	$xproceso = " AND tabla2.id_proceso_rp=$proceso AND tabla1.id_proceso_rt=$proceso "; 
	 	$consulta="SELECT tabla1.id_rt,SUM(tabla1.valor_tiem_rt) AS valor,tabla1.fecha_rt FROM tbl_reg_tiempo tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rt = tabla2.id_op_rp AND DATE(tabla1.fecha_rt) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rt) ASC";  
	 } 
$tipov="TABLA DE TIEMPOS MUERTOS / MINUTOS";
}

if($codigo=='2'){
        $xmaquina='';
        $xproceso = ''; 
        if($maqui=='0' && $proceso=='0'){ 
           $consulta="SELECT id_rt,SUM(valor_prep_rtp) AS valor,fecha_rtp FROM tbl_reg_tiempo_preparacion WHERE DATE(fecha_rtp) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rtp) ASC";
        	 
        }else
        if($maqui!='0' && $proceso=='0'){
        	$xmaquina = " AND tabla2.str_maquina_rp= $maqui ";
        	$consulta="SELECT tabla1.id_rt,SUM(tabla1.valor_prep_rtp) AS valor,tabla1.fecha_rtp FROM tbl_reg_tiempo_preparacion tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rtp = tabla2.id_op_rp AND DATE(tabla1.fecha_rtp) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina  GROUP BY MONTH(tabla1.fecha_rtp) ASC"; 
        }else
        if($maqui=='0' && $proceso!='0'){ 
        	$xproceso = " AND tabla1.id_proceso_rtp=$proceso AND tabla2.id_proceso_rp=$proceso "; 	
        	$consulta="SELECT tabla1.id_rt,SUM(tabla1.valor_prep_rtp) AS valor,tabla1.fecha_rtp FROM tbl_reg_tiempo_preparacion tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rtp = tabla2.id_op_rp AND DATE(tabla1.fecha_rtp) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rtp) ASC"; 
        }else
        if($maqui!='0' && $proceso!='0'){
        	$xmaquina = " AND tabla2.str_maquina_rp= $maqui";
        	$xproceso = " AND tabla2.id_proceso_rp=$proceso AND tabla1.id_proceso_rtp=$proceso "; 
        	$consulta="SELECT tabla1.id_rt,SUM(tabla1.valor_prep_rtp) AS valor,tabla1.fecha_rtp FROM tbl_reg_tiempo_preparacion tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rtp = tabla2.id_op_rp AND DATE(tabla1.fecha_rtp) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rtp) ASC";  
        }
$tipov="TABLA DE TIEMPOS DE PREPARACION / MINUTOS";
}
if($codigo=='3'){
           $xmaquina='';
           $xproceso = ''; 
           if($maqui=='0' && $proceso=='0'){ 
           	$consulta="SELECT id_rd,SUM(valor_desp_rd) AS valor,fecha_rd FROM Tbl_reg_desperdicio WHERE DATE(fecha_rd) BETWEEN '$fecha1' AND '$fecha2' GROUP BY MONTH(fecha_rd) ASC";
           	$general=0;
           }else
           if($maqui!='0' && $proceso=='0'){
           	$xmaquina = " AND tabla2.str_maquina_rp= $maqui ";
           	$consulta="SELECT tabla1.id_rd,SUM(tabla1.valor_desp_rd) AS valor,tabla1.fecha_rd FROM Tbl_reg_desperdicio tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rd = tabla2.id_op_rp AND DATE(tabla1.fecha_rd) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina  GROUP BY MONTH(tabla1.fecha_rd) ASC"; 
           	$general=0;
           }else
           if($maqui=='0' && $proceso!='0'){ 
           	$xproceso = " AND tabla1.id_proceso_rd=$proceso AND tabla2.id_proceso_rp=$proceso "; 	
           	$consulta="SELECT tabla1.id_rd,SUM(tabla1.valor_desp_rd) AS valor,tabla1.fecha_rd FROM Tbl_reg_desperdicio tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rd = tabla2.id_op_rp AND DATE(tabla1.fecha_rd) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rd) ASC"; 
           	$general=0;
           }else
           if($maqui!='0' && $proceso!='0'){
           	$xmaquina = " AND tabla2.str_maquina_rp= $maqui";
           	$xproceso = " AND tabla2.id_proceso_rp=$proceso AND tabla1.id_proceso_rd=$proceso "; 
           	$consulta="SELECT tabla1.id_rd,SUM(tabla1.valor_desp_rd) AS valor,tabla1.fecha_rd FROM Tbl_reg_desperdicio tabla1 INNER JOIN tbl_reg_produccion tabla2 ON tabla1.op_rd = tabla2.id_op_rp AND DATE(tabla1.fecha_rd) BETWEEN '$fecha1' AND '$fecha2'  $xmaquina $xproceso GROUP BY MONTH(tabla1.fecha_rd) ASC";  
           	$general=0;
           }
$tipov="TABLA DE DESPERDICIOS / KILOS";
}
$r=mysql_query($consulta, $conexion1);
 
$d=mysql_num_rows($r);

$r=mysql_query($consulta, $conexion1);
    
  if($general == 0){
  	    mysql_select_db($database_conexion1, $conexion1);
        $r=mysql_query($consulta, $conexion1);
        
            header('Content-type: application/vnd.ms-excel');
        	header("Content-Disposition: attachment; filename=archivo.xls");
        	header("Pragma: no-cache");
        	header("Expires: 0");

  	  	echo("<table  border='1' align='center'>");
  		echo("<tr><td colspan='14'><strong>GRAFICA DE TIEMPOS Y DESPERDICIOS / AÑO ACTUAL</strong></td></tr>");
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

           
            $r2=mysql_query($consulta, $conexion1); 
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
         	 //echo ("<img src=\"images/graficapastel.png\">");

  	}else{
    mysql_select_db($database_conexion1, $conexion1);
    $r=mysql_query($consulta, $conexion1);

        header('Content-type: application/vnd.ms-excel');
    	header("Content-Disposition: attachment; filename=archivo.xls");
    	header("Pragma: no-cache");
    	header("Expires: 0");

	echo("<table  border='1' align='center'>");

	echo"<tr><td colspan='14'><strong>GRAFICA DETALLE DE TIEMPOS Y DESPERDICIOS / AÑO ACTUAL</strong></td></tr>";
 
    echo("<tr>");
	$tabla=new pData();
	while ($registro = mysql_fetch_row($r)) {
	$dato1=minutoaHoras($registro[1]); 
	$tabla->addPoints(array($dato1),"serie"); 
	$fech=$registro[2];//mes 
 	echo("<td><strong>".soloMes($fech)."</strong></td>"); //imprime mens
 	echo("<td>$dato1</td>"); //imprime valores
	$tabla->AddPoints(array(soloMes($fech)),"etiquetas");//define la columna mes 
       } 
    echo("</tr>");
    echo("</table>");

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
 	//echo ("<img src=\"images/graficapastel.png\">");
  	}

//if($d>0){
	/*header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=archivo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");*/
	
/*		
        //muestra igual al pastel
        echo("<table  border='1' align='center'>");

		echo("<tr><td colspan='14'> $tipov </td></tr>");
	 
	    echo("<tr>");
		$tabla=new pData();
		while ($registro = mysql_fetch_row($r)) {
		$dato1=minutoaHoras($registro[1]); 
		$tabla->addPoints(array($dato1),"serie"); 
		$fech=$registro[2];//mes 
	 	echo("<td><strong>".soloMes($fech)."</strong></td>"); 
	 	echo("<td>$dato1</td>"); 
		$tabla->AddPoints(array(soloMes($fech)),"etiquetas");  
	       } 
	    echo("</tr>");
	    echo("</table>");*/

 /* 	echo("<table border=1>");
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
		$dato1=($registro[1]); 
 		echo ("<td> $dato1 </td>");
 	}
	echo("</tr>");
	echo("</table>"); */
/* }
else{
echo("No hay registros en la tabla");
}*/
 
?>
