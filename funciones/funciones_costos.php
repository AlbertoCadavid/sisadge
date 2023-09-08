<?php /*PROGRAMACION ESTRUCTURADA FUNCIONES PHP*/
require_once('Connections/conexion1.php'); 


function fechaGeneral($id_op,$bd){

	  $sqlrollo=" $bd WHERE id_op_r='$id_op'"; 
	  $resultrollo=mysql_query($sqlrollo); 
	  $numrollo=mysql_num_rows($resultrollo); 
	  if($numrollo >= '1') 
	  { $rollo=mysql_result($resultrollo,0,'rollos');
	    $metros_ext=mysql_result($resultrollo,0,'metros');
	    $bolsas_sell=mysql_result($resultrollo,0,'bolsas');
		$reproceso_sell=mysql_result($resultrollo,0,'reproceso');
		$FECHA_NOVEDAD=mysql_result($resultrollo,0,'FECHA');
		$FECHA_NOVEDAD;//trae la fecha y el ultimo dia del mes
		$fecha_todos = explode("-",$FECHA_NOVEDAD);
			  $fecha_ano = $fecha_todos[0];
			  $fecha_mes = $fecha_todos[1];
			  $fecha_general = $fecha_ano.'-'.$fecha_mes;
	  return $fecha_general;
 	
 	  }
 }
function distribucion($hora_mes,$proceso){
	    mysql_select_db($database_conexion1, $conexion1);
		$sqldis = "SELECT extrusion FROM TblDistribucionHoras WHERE fecha = '$hora_mes'";   
		$resultdis = mysql_query($sqldis);
        $numdis = mysql_num_rows($resultdis);
 
        $extr = mysql_result($resultdis,0,'extrusion');
 
		return $extr;
/*	while ($row = mysql_fetch_row($result)){ 
	       if($proceso=="extrusion"){
		   echo "ext";} 
		   else if($proceso=="impresion"){
		   echo "$row[2] \n"; }
		   else if($proceso=="sellado"){
		   echo "$row[3] \n"; }
} */
/* 	  $sqlgeneral="SELECT * FROM `TblDistribucionHoras` WHERE fecha = '$hora_mes'";
	  $resultgeneral= mysql_query($sqlgeneral);
	  $numgeneral= mysql_num_rows($resultgeneral);
 	  //PARA TODOS LOS PROCESOS
	  if($numgeneral >='1')
	  { 
	  $TiempomeExt =  mysql_result($resultgeneral, 0, 'extrusion');
	  $TiempomeImp =  mysql_result($resultgeneral, 0, 'impresion');
	  $TiempomeRef =  mysql_result($resultgeneral, 0, 'refilado');
	  $TiempomeSell =  mysql_result($resultgeneral, 0, 'sellado');
	 
      //EXTRUDER
	  $costoUnHGga_ext = mysql_result($resultgeneral, 0, 'gga_ext');
	  $costoUnHGga_imp = mysql_result($resultgeneral, 0, 'gga_imp');
	  $costoUnHGga_ref = mysql_result($resultgeneral, 0, 'gga_ref');
	  $costoUnHGga_sell = mysql_result($resultgeneral, 0, 'gga_sell');	  
	  //IMPRESION
	  $costoUnHCif_ext = mysql_result($resultgeneral, 0, 'cif_ext');
	  $costoUnHCif_imp = mysql_result($resultgeneral, 0, 'cif_imp');
	  $costoUnHCif_ref = mysql_result($resultgeneral, 0, 'cif_ref');
	  $costoUnHCif_sell = mysql_result($resultgeneral, 0, 'cif_sell');
	  //REFILADO
	  $costoUnHGgv_ext = mysql_result($resultgeneral, 0, 'ggv_ext');
	  $costoUnHGgv_imp = mysql_result($resultgeneral, 0, 'ggv_imp');
	  $costoUnHGgv_ref = mysql_result($resultgeneral, 0, 'ggv_ref');
	  $costoUnHGgv_sell = mysql_result($resultgeneral, 0, 'ggv_sell');
	  //SELLADO
	  $costoUnHGgf_ext = mysql_result($resultgeneral, 0, 'ggf_ext');
	  $costoUnHGgf_imp = mysql_result($resultgeneral, 0, 'ggf_imp');
	  $costoUnHGgf_ref = mysql_result($resultgeneral, 0, 'ggf_ref');
	  $costoUnHGgf_sell = mysql_result($resultgeneral, 0, 'ggf_sell');
 	 
	  return $resultgeneral;
	  }	*/


}

?>