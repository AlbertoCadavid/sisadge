 
 
<?php /*PROGRAMACION ESTRUCTURADA FUNCIONES PHP*/
require_once('Connections/conexion1.php'); 




//si se ha enviodo la variable
function issetVar($var) {
if (isset($var)) {
//envio
$envio_var = $var;
} else {
//no envio	
 $envio_var = "";
}
}
//MT A KILOS
  function dosDecimalesSinMiles($numero){
$nuevo_numero=number_format($numero, 2, '.', '');
return $nuevo_numero; 
}
function muestraDate_local($the_date){
	  $horaentero= explode(" ",$the_date);
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;
	return $campofecha;
	}
	function fechaHoraDatelocal_1(){ 
    $the_date = date("Y-m-01 01:00");
	  $horaentero= explode(" ",$the_date);
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;
	return $campofecha;
	}
	//fecha y hora actual
	function fechaHoraDatelocal_2(){ 
	  $the_date = date("Y-m-d H:i");
	  $horaentero= explode(" ",$the_date);
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;
	return $campofecha;
	}
	function fechaHoraDatelocal(){ 
	  $the_date = date("Y-m-d H:i");
	//LE RESTO 5 HORAS POR LA CONFIGURACION REGIONAL
   $hora =  date("Y-m-d H:i:s");
   $the_date = strtotime ( '-5 hour' , strtotime ( $hora ) ); 
   $the_date = date ( 'Y-m-d H:i' , $the_date);	  
	  
	$horaentero= explode(" ",$the_date);
	$fecha=$horaentero[0];
	$hora=$horaentero[1]; 
    $campofecha = $fecha."T".$hora;
	return $campofecha;
}
function minutoaDecimal($valor){
	return $valor/60;
	}
 function minutoaHoras($valor){
	
	return   number_format($valor/60, 2, '.', '');
}
/*function tiempoMes($valor,$valor1,$valor2,$valor4){
	$proceso=$valor;
	$Tiempomes_ext = $valor1;
	$Tiempomes_imp = $valor2;
	$Tiempomes_sell = $valor4;	
	//floor() - Redondear fracciones hacia abajo
    //round() - Redondea un float 
	//ceil()  - Redondea hacia arriba
$totHoxProc = $Tiempomes_ext+$Tiempomes_imp+$Tiempomes_sell;  
			  $porcent = ($proceso/$totHoxProc)*100;
 			  return ceil($porcent); 
 }*/
function kilosametros($valor1,$valor2,$valor3) {
   	$sub = ($valor1*1000)/$valor2;
	$mtroL = ($valor3*$sub)/100;//100 paso a centimetro porq el ancho esta en centimetros
	return round($mtroL);
}
function metrolineal($kilod,$kilom,$reproc,$metros,$kilos) {
   $metros_desp_ext = ($kilod+$kilom+$reproc)*$metros/$kilos;
	return round($metros_desp_ext);
}
//PARA BOLSILLO
function metroaKilos($valor1,$valor2,$valor3,$valor4){
			//OPERACION PARA BOLSILLO
            $lam1=$valor1; 			
			$lam2=$valor2;
			$calibre=($valor3/10); //paso a decimal 
			$metros=$valor4;			
			$mt=0.01;//centimetros de un metro 
            $cons=0.00467;//constante			
			$multip = ($mt * $calibre * $cons);
			$subKilos = (($lam1) + ($lam2) * ($multip));
			$toKilos = ($subKilos*$metros)/2;//se divide en 2 porque es lamina
			$Kilost = ($toKilos/1000);			
		    return round($Kilost);
}
//PARA CONVERTIR DE METROS A KILOS
function metroaKilos2($ancho,$calibre,$metro){
			//OPERACION
            $anchor=$ancho; 			
 			$calibr=($calibre);  
			$metros=$metro;			
			$mt=0.01;//centimetros de un metro 
            $cons=0.00467;//constante			
			$multip = ($mt * $calibr * $cons);
			$subKilos = ($anchor * $multip);
			$toKilos = ($subKilos * $metros);
			$Kilost = ($toKilos/1000);			
		    return  ($Kilost); 
}
function metroaKilos3($ancho,$calibre,$metro){
			//OPERACION
            $anchor=$ancho; 			
 			$calibr=($calibre);  
			$metros=$metro;			
			$mt=0.01;//centimetros de un metro 
            $cons=0.0467;//constante			
			$multip = ($mt * $calibr * $anchor);
			$subKilos = ($cons * $multip);
			$toKilos = ($subKilos * $metros);
			$Kilost = ($toKilos);			
		    return  $Kilost; 
}
//REGLA DE TRES
function regladetres($kilomenos,$metros,$kilosT){
	$incognita = ($kilomenos * $metros / $kilosT);
	   $incognitas=number_format($incognita, 2, '.', '');
	return ($incognitas); //round
	}
function regladetres2($metrodes,$metros,$kilosT){
	$incognita = ($metrodes * $kilosT / $metros);
	   $incognitas=number_format($incognita, 2, '.', '');
	return ($incognitas); //round 
	}
//PORCENTAJE
function porcentajeKilos($kilosmes,$kilos_ex){
	$porcemes =($kilos_ex*100)/$kilosmes;
	 $formato=number_format($porcemes, 2, ",", ".");
    return  $formato;
} 
function porcentaje($valores,$porciento){
	$resultado = round($valores*$porciento )/100;
  
    return  $resultado;
}
 function porcentaje2($total, $parte) {
    return round($parte / $total * 100 ); 
}
//SUMAR M.O.D COSTOS DE O.P PARA SACAR SUELDO MES
function sueldoMes($sueldo,$aux_trans,$aportestotal,$horasmes,$horasdia,$recargos,$festivos){
	$sueldomes =($sueldo+$aux_trans+$aportestotal+$recargos+$festivos);// sueldo totales con todo de todos 
	$valorHora= ($sueldomes / $horasmes);//valor hora; quitar round si voy a usar los decimales con exactitud
	//$turno12=round($valorHora*$horasdia);//$ valor de un dia del operario diurno
	//$turno3=round($valorHora*$horasdia)*1.35;//$ valor de un dia del operario por 1.35 es el valor adicionar por el recargo nocturno
	 return ($valorHora);
	//fin	
	}
function horadecimal($valor,$valo2){ 
if($valor!=''){
	  $horaentero= explode(":",$valor);
	  $hora=$horaentero[0]*60;
	  $minut=$horaentero[1]+$hora;
	  
	  $horaentero2= explode(":",$valor2);
	  $hora2=$horaentero2[0]*60;	  
	  $minut2=$horaentero2[1]+$hora2;
	  
	  $suma= $minut + $minut2;
	  $totalsec=$suma/60; 
	  $formato=number_format($totalsec, 2, ",", ".");   
	  return $formato;}else{
	  return "0";} 
}
function horadecimalUna($valor){  
if($valor!=''){
	  $horaentero= explode(":",$valor);
	  $hora=$horaentero[0]*60; 
	  $minut=$horaentero[1];
	  $suma= $hora + $minut; 
	  $totalsec=$suma/60;//debo dejarlo contodos los decimales para poder operar  
	  $totals = number_format($totalsec, 2, '.', '');
	  return ($totals);}else{
	  return "0";}   
}
function conversorSegundosHoras($tiempo_en_segundos) {
	$horas = floor($tiempo_en_segundos / 3600);
	$minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
	$segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
    return $horas . '.' . $minutos;//en decimal
	//return $horas . ':' . $minutos . ":" . $segundos;//daria la hora completa
}
/*function conversoraHoras($horaopti) {
		 //convierto a seundos y sumo
         list($h, $m, $s) = explode(':', $horaopti); 
         $secun += ($h * 3600) + ($m * 60) + $s; 
  		 //paso de nuevo a formato horas
		 $horas = floor($secun / 3600);
	     $minutos = floor(($secun - ($horas * 3600)) / 60);
	     $segundos = $secun - ($horas * 3600) - ($minutos * 60);
 
	     return $totaltiempo = $horas . ':' . $minutos . ":" . $segundos;
}*/
function sumar($valor,$valor2,$valor3,$valor4){ 
$suma = ($valor+$valor2+$valor3+$valor4); 
return 	$suma; 
}
//PRIMERAS LETRAS A MAYUSCULAS
function primeraMayuscula($valor){ 
$str = strtolower($valor);
$foo = ucwords($str); 
return 	$foo; 
}
//INICIO DE FUNCIONES
function limpiarCaracteresEspeciales($valor){
 $string = htmlentities($valor);
 $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
 return $string;
}
//LIMPIAR CADENA DE ESPACIOS DENTRO
function limpiaEspacios($valor){
    $str = str_replace(" ", "", $valor);
	$valor = strtoupper($str);
    return $valor;
}
//redondear decimales a entero
function redondear_decimal($valor) {  
   $float_redondeado=round($valor * 100) / 100; 
   return $float_redondeado; 
}
function redondear_decimal_operar($valor) {  
   //float_redondeado=round($valor * 100) / 100; 
   $float_redondeado=number_format($valor, 2); 
   return $float_redondeado; 
} 
//sacar porcentaje y dejar dos decimales
function sacar_porcentaje($valor,$valor2) {
   $valor3=($valor*$valor2/100);//porcentaje neto
   $valor4=$valor3+$desperdicio;//porcentaje mas el desperdicio o tolerancia
   $float_redondeado=round($valor4 * 100) / 100;
   $valor5=$float_redondeado / 3; //divide por tres tornillos
   $formato=number_format($valor5, 2, ",", "."); 
   return $formato; 
}
//redondear decimales a entero dejar entero
function bolsasAprox($valor1,$valor2) { 
  $anchoporc=$valor2/100;
  $anchoporc_redon=round($valor1/$anchoporc); 
  $retorno = round($anchoporc_redon); 
   return $retorno; 
}
function bolsasAprox2($ancho,$bolsas) { 
  $metros=($ancho*$bolsas);
  $total_metros=round($metros/100); 
   return $total_metros; 
}
//redondear decimales a entero dejar entero
function redondear_entero_puntos($valor) { 
  $int_redondeado=round($valor);
  $formato=number_format($int_redondeado, 0,",", ".");  
  //$formato=number_format($int_redondeado, 2, ',', '.'); 
   return $formato; 
}
//redondear decimales a entero dejar entero
function redondear_entero($valor) { 
  $int_redondeado=round($valor);
  // $float_redondeado=number_format($valor, 0);  
   return $int_redondeado; 
}
//redondear ajuste
function restar_ajuste($valor,$cm) { 
$cons='1000';//valor bolsa promedio 
$prom=$valor;
$cm=$cm; 
$max=($prom*$cm)/$cons; 
  $resta_redondeado=round($max);
  // $float_redondeado=number_format($valor, 0);  
   return $resta_redondeado; 
}
//formato numero puntos
function numeros_format($valor) { 
 $formato=number_format($valor, 2, ",", ".");
 return $formato;
}


//resta de fechas Actualizado
function RestarFechasNew($fechaini, $fechafin) {
$date1 = new DateTime($fechaini);
$date2 = new DateTime($fechafin);
$diff = $date1->diff($date2);
$diasaVencer = $diff->days ;
return($diasaVencer);
}


//resta de fechas 
function RestarFechas($fechaini, $fechafin) {
$date1 = $fechaini; 

$date2 = $fechafin; 

$diff = abs(strtotime($date2) - strtotime($date1)); 

$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$dayah= $days*24;//paso el dia a horas para sumarlo al total de horas transcurridos 

$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 


$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

$th=$dayah+$hours;
return($th.":". $minuts);

}


//HORAS A SEGUNDOS
function hoursToSecods ($valor) { // $hour must be a string type: "HH:mm:ss"
$parse = array();
if (!preg_match ('#^(?<hours>[\d]{2}):(?<mins>[\d]{2}):(?<secs>[\d]{2})$#',$valor,$parse)) {
// Throw error, exception, etc
throw new RuntimeException ("Hour Format not valid");
}
//return (int) $parse['hours'] * 3600 + (int) $parse['mins'] * 60 + (int) $parse['secs'];//TODO A SEGUNDOS
return (int) $parse['hours'] * 60 + (int) $parse['mins'] + (int) $parse['secs'];//TODO A MINUTOS
//esta me transforma todo a segundos y despues hago el tratamiento de la division y luego lo vuelvo a transformar a hora con gmdate	
}
//fechas restar un ano
function restaAnos($nuevafecha){
$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}
//fechas restar un mes
function restaMesParametro($valor){
$fecha = $valor;
$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
	  
 return $nuevafecha;	
}
//fechas restar un mes
function restaMes($nuevafecha){
$fecha = date('Y-m-d'); $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ); $nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}
//fechas restar un mes pasando parametro
function restaMesParam($fechas,$nuevafecha){ 
$fecha = $fechas;
//$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
$nuevafecha= strtotime ( '-1 month' , strtotime ( $fecha )) ;// resta 1 mes
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//date($fecha, strtotime('-1 month')) ;
return $nuevafecha;	
}
function restaMesParam2($fechas,$nuevafecha){ 
$fecha = $fechas;
//$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
$nuevafecha= strtotime ( '-1 month' , strtotime ( $fecha )) ;// resta 1 mes
$nuevafecha = date ( 'Y-m' , $nuevafecha );	
//date($fecha, strtotime('-1 month')) ;
return $nuevafecha;	
}
//resta 3 meses
function restaMesParam3($fechas,$nuevafecha){ 
$fecha = $fechas;
//$nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
$nuevafecha= strtotime ( '-3 month' , strtotime ( $fecha )) ;// resta 1 mes
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//date($fecha, strtotime('-1 month')) ;
return $nuevafecha;	
}
//fechas restar dia
function restaDia($fecha,$dias=''){
 $dias=$dias=='' ? 1 : $dias;
$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-'.$dias.'day' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}
function RestaDias($nuevafecha,$dias=''){
	 $dias=$dias=='' ? 1 : $dias;
   $nuevafecha = strtotime ( '-'.$dias.'day' , strtotime ( $nuevafecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}
//fechas sumar mes
function sumarMes($nuevafecha){
$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}
//fechas sumar mes y xdias
function sumarMesyDias($nuevafecha ,$dias ){
$fecha = $nuevafecha == '' ? date('Y-m-d') : $nuevafecha;
$dias2 = $dias=='' ? 0 : $dias;
$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
$nuevafecha2 = date ( 'Y-m-d', $nuevafecha );	

$nuevafecha3 = strtotime ( '+ '.$dias2.' day' , strtotime ( $nuevafecha2 ) ) ;
$nuevafecha4 = date ( 'Y-m-d', $nuevafecha3 );	

return $nuevafecha4;	
}
//fecha
function fecha($fechaNueva){
$fechaNueva = date("Y-m-d");
return $fechaNueva;
}
//fechas restar una hora
function sumaDia($nuevafecha){
$fecha = date('Y-m-d');$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}


//fechas restar una hora
function SumaDias($nuevafecha,$dias=''){
	$dias2 = $dias=='' ? 0 : $dias;
 $nuevafecha = strtotime ( '+'.$dias2.'day' , strtotime ( $nuevafecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );	
//$fecha = date('Y-m-d');$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
return $nuevafecha;	
}

//sumar una hora
function restaHora($nuevahora){
$hora =  date("H:i:s");$nuevahora = strtotime ( '+1 hour' , strtotime ( $hora ) ) ; $nuevahora = date ( 'H:i:s' , $nuevahora );
return $nuevahora;	
}
function restoHoranew($cuanto){
$hora =  date("H:i:s");$nuevahora = strtotime ( '-'.$cuanto.'hour' , strtotime ( $hora ) ) ; $nuevahora = date ( 'H:i:s' , $nuevahora );
return $nuevahora;	
}
function restoHoranew2($cuanto){
$hora =  date("H:i");$nuevahora = strtotime ( '-'.$cuanto.'hour' , strtotime ( $hora ) ) ; $nuevahora = date ( 'H:i' , $nuevahora );
return $nuevahora;	
}
//hora normal
function Hora($nuevahora){
//$nuevahora = date ('g:i a');//HORA AM/PM
$nuevahora = date('H:i:s');//HORA MILITAR
return $nuevahora;	
}
function quitarFecha($nuevahora){
$nueva = explode(" ",$nuevahora);
$nuevahora=$nueva[1];
return $nuevahora;	
}
function quitarHora($nuevahora){
$nueva = explode(" ",$nuevahora); 
$nuevahora=$nueva[0];
return $nuevahora;	
}
function quitarDia($nuevafecha){
$fecha_todos = explode("-",$nuevafecha);
	  $fecha_ano = $fecha_todos[0];
	  $fecha_mes = $fecha_todos[1];
	  $fecha_general = $fecha_ano.'-'.$fecha_mes;
return $fecha_general;	
}

function restaHoras($nuevahora){ 
$hora =  date("Y-m-d H:i:s");$nuevahora = strtotime ( '-8 hour' , strtotime ( $hora ) ) ; $nuevahora = date ( 'Y-m-d H:i' , $nuevahora );
 
	  $horaentero= explode(" ",$nuevahora); 
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;
	return $campofecha;
}
function sumarHoras($nuevahora){ 
/*$ultimafecha = $ultimafecha; //inicializo la fecha con la hora
$nuevafecha = strtotime ( '+16 hour' , strtotime ( $ultimafecha ) ) ;
$nuevafecha = date ( 'Y-m-j H:i:s' , $nuevafecha );*/
$hora =  date("Y-m-d H:i:s");$nuevahora = strtotime ( '+8 hour' , strtotime ( $hora ) ) ; $nuevahora = date ( 'Y-m-d H:i' , $nuevahora );
return $nuevahora;
}
function sumarMinutoHoras($nuevahora,$tmuertos,$tprep){ 
 $totalmuertos=$tmuertos+$tprep;
$newhora =  date("$nuevahora",strtotime("-$totalmuertos minute"));
return $newhora;
}
function sumarHorasparam($ultimaF,$horaAdd){
$ahorafecha = date("Y-m-d H:i"); 
	//LE RESTO 5 HORAS POR LA CONFIGURACION REGIONAL
$hora =  date("Y-m-d H:i:s");$ahorafecha = strtotime ( '-5 hour' , strtotime ( $hora ) ) ; $ahorafecha = date ( 'Y-m-d H:i' , $ahorafecha);

$datetime1 = new DateTime($ahorafecha);
$datetime2 = new DateTime($ultimaF);
$diffech = $datetime1->diff($datetime2);
if($diffech->y >0 || $diffech->m >0 || $diffech->d >0 || $diffech->h > $horaAdd){
   	  $horaentero= explode(" ",$ahorafecha);//FECHA CON - 5 HORAS REGIONAL
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;	
  	return $campofecha;	
  	//return '';
	}else{ 
	  $horaentero= explode(" ",$ultimaF);
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;	
	return $campofecha; 
		}
//printf('%d anos, %d meses, %d dias, %d horas, %d minutos, %d segundos', $diffech->y, $diffech->m, $diffech->d, $diffech->h, $diffech->i, $diffech->s);
}
 function muestradatelocal($fecha){ 
	  $horaentero= explode(" ",$fecha);
	  $fecha=$horaentero[0];
	  $hora=$horaentero[1];
      $campofecha = $fecha."T".$hora;	
	return $campofecha; 
}
function soloFecha($soloFech){
$sFechas = strftime("%Y-%m-%d", strtotime($soloFech));
return $sFechas;
}
function fechaHora2($fechaHora){
$fecha = date("Y-m-d H:i");
}
function fechaHora($fechaHora){
$fecha = date("Y-m-d H:i");
	//LE RESTO 5 HORAS POR LA CONFIGURACION REGIONAL
/* $hora =  date("Y-m-d H:i:s");
$fecha = strtotime ( '-5 hour' , strtotime ( $hora ) ) ; 
$fecha = date ( 'Y-m-d H:i' , $fecha); */
return $fecha; 
}

function formaiso($form){
$var=htmlentities($form);
return $var;
}
function conversorMinutosHoras($valor1,$valor2) {
	$tiempo_en_segundos=($valor1+$valor2)*60;
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
    $minutoahoras=$horas . ':' . $minutos . ":" . $segundos;
    return $minutoahoras;
}
function conversorDatetimeLocal($time){
$time = strtotime($dateInUTC.' UTC');
$dateInLocal = date("Y-m-d H:i", $time);
	//LE RESTO 5 HORAS POR LA CONFIGURACION REGIONAL
$hora =  date("Y-m-d H:i:s");$dateInLocal = strtotime ( '-5 hour' , strtotime ( $hora ) ) ; $dateInLocal = date ( 'Y-m-d H:i' , $dateInLocal);

return $dateInLocal;
}
/*---------------------------------------PRODUCCION------------------------------------------------*/
function conversorAKilos($ancho,$largo,$solapa,$fuelle,$calibre){	

$const="0.00467";//0.00467
$pesoxmetro=($ancho*($larg+$fuelle+$solapa)*$calibre*$const)/2;

$resul=number_format($pesoxmetro, 2, ".", ".");
return $resul;
} 

function pasarMillar($ancholam,$calibre,$metros){	
$const='0.0467';//0.00467  
$calib=$calibre;
$anchocent=$ancholam/100;//proporcion de metros
$mt=$metros/100;//proporcion de metros
$pesoxmetro=($anchocent*$calib*$mt*$const);
$res = ($pesoxmetro)/2;//se divide en 2 porque es tubular
//$resul= round($res); 
$resul=number_format($res, 2);
return $resul;
} 
function millarBolsillo($ancho,$largo,$calibre){	
$const='0.00467';  
$calib=$calibre;
$peso=($ancho*$largo*$calib*$const);
$res = ($peso)/2;//se divide en 2 porque es tubular
$resul=number_format($res, 2);
return $resul;
}
/*---------------------------------------PROCESOS COSTOS-------------------------------------------*/
//PRECIO POR REFERENCIA
function PrecioRef($valor,$BD){
$id_ref=$valor;
mysql_select_db($database_conexion1, $conexion1);
$sqlce1="SELECT tipo_bolsa_ref FROM Tbl_referencia WHERE Tbl_referencia.cod_ref = '$id_ref'";
$resultce1= mysql_query($sqlce1);
$numce1= mysql_num_rows($resultce1);
if($numce1 >='1') {
$tipo_bolsa_ref=mysql_result($resultce1,0,'tipo_bolsa_ref'); 
//ADHESIVO
if($tipo_bolsa_ref="CINTA DE SEGURIDAD"){$seg="1";}

if($tipo_bolsa_ref="CINTA PERMANENTE"){$per="1";}

if($tipo_bolsa_ref="CINTA RESELLABLE"){$res="1";}

if($row[27]=='1'){$hot="HOT MELT";}
$adhesivo=$seg.$per.$res.$hot;
}
//DEVUELVE LA BASE DE DATOS CORRESPONDIENTE AL TIPO

if($tipo_bolsa_ref!='LAMINA'||$tipo_bolsa_ref!='PACKING LIST'){
$BD="Tbl_cotiza_bolsa";}
if ($tipo_bolsa_ref=='LAMINA'){
$BD="Tbl_cotiza_laminas";}
if($tipo_bolsa_ref=='PACKING LIST'){
$BD="Tbl_cotiza_packing";} 
return $BD;
mysql_free_result($resultce1);

}
/*******CONVIERTE EL ADHESIVO A KILOS***********/
function adhesivos($tipo,$metros){ 
   	//$cinta='2.3';//en 1 metro lineal de cinta en gramos
	$hotmelt=1.2;//en 1 metro lineal hay 1.2 gramo de hotmelt y no guardo el liner ya que son los mismoos metros lineales	
	$kilo=1000;   
	$mts=$metros;//termino de metros, son los metros lineales ancho por bolsas
	if($tipo=="HOT MELT"){  
     $kilosadhesivo=(($mts * $hotmelt)/$kilo);//consumo de la pega solamente esto es en terminos de kilo
	 return number_format($kilosadhesivo, 2);
	 }else if($tipo=='N.A'){
      return '';
		 }else { 
	 //$kilosadhesivo=$cinta * $mts/$kilo; 
	 $metroscinta = $mts; 
	 return round($metroscinta);//sin dos decimales 
	 }
		 //pendiente evaluar si tiene los dos hot y cinta
	 
	}
function generaRef()
{
	include 'Connections/conexion1.php';

	mysql_select_db($database_conexion1, $conexion1);
	$sqlconsulta=("SELECT id,descripcion FROM TblTipoproducto");
	$consulta = mysql_query($sqlconsulta, $conexion1) or die(mysql_error());
	// Voy imprimiendo el primer select compuesto por los paises
	echo "<select name='tipo_inv' id='tipo_inv' onChange='cargaContenido(this.id)' style='width:300px'>";
	echo "<option value='0'>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}
	echo "</select>";
}

function RangoMedidaAnchoLargo($medida){
	$medida;
	
}
function enteroHoras($total_seconds){
$horas = floor ( $total_seconds / 3600 );
$minutes = ( ( $total_seconds / 60 ) % 60 );
$seconds = ( $total_seconds % 60 );
 
$time['horas'] = str_pad( $horas, 2, "0", STR_PAD_LEFT );
$time['minutes'] = str_pad( $minutes, 2, "0", STR_PAD_LEFT );
$time['seconds'] = str_pad( $seconds, 2, "0", STR_PAD_LEFT );
 
$tim = implode( ':', $time );
 
return $tim;

}
function sumarMinutosaHora($valor,$valor2){
	$second=$valor2*60;
	 return date('H:i:s', strtotime($valor) + $second); 
/*$horaInicial=$valor;
$minutoAnadir=$valor2;
 
$segundos_horaInicial=strtotime($horaInicial);
 
$segundos_minutoAnadir=$minutoAnadir*60;
 
$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
 return $nuevaHora;*/
}
  /** Actual month first day **/
  function first_year_month() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, 1, 1, $year));
  }
  function last_year_month() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, 12, 1, $year));
  }
  function first_month_day() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  function last_month_day() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
       return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  }
  //PARA INVENTARIO
  function first_month_day_inv() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d H:i', mktime(0,0,0, $month, 1, $year));
  }
  function last_month_day_inv() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
      return date('Y-m-d H:i', mktime(0,0,0, $month, $day, $year));
  }  
  //FIN  
  
  
  function last_month_day2($fecha) { 
      $horaentero = explode('-',$fecha);
      $year = $fecha=$horaentero[0];
	  $month = $fecha=$horaentero[1]; 
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
     return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  }  
 function restrincionUsuarios($usuario){
	 if($usuario=='1'){ 
	 return 0;
 }else if($usuario=='14'){
	 return 0;
	 }else{return 1;}
	 }
 function conversionTasa($moneda,$unidad,$precio){
	 if($usuario=='1'){ 
 
	 }	 
 }
//TRM DOLAR
function trm_dolar2(){
$f=@fopen("http://www.colombia.com/includes/2007/enlaces/actualidad_indicadores.js","r");
if($f){
$line = fread($f, 1024);
$dollar = (preg_match('/[0-9-.,]+/i',$line,$match))? $match[0] : 0;
//$dollar = str_replace(',','.',str_replace('.','',$dollar));
$dollar = str_replace(',','',$dollar);
return $dollar;
}
return 0;  
return $puntuacion; 
}
function trm_dolar() {
  $url = "http://dolar.wilkinsonpc.com.co/dolar-cop-usd-1.html";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  $page = trim(curl_exec($ch));
  //echo $page;
  $pos1 = strpos($page, "$");
  $pos2 = strpos($page, " -");
  $trm = substr($page, $pos1, $pos2 - $pos1);
  $line = str_replace(',','',$trm);
  $dollar = (preg_match('/[0-9-.,]+/i',$line,$match))? $match[0] : 0;
  return $dollar;
}

function unidadMedida($medida,$precioCotiz,$undPaquetes,$trmCotiz){ 
	if ($medida=="UNIDAD"){ 
		return $precioCotiz;
 		}
		else if($medida=="MILLAR"){
		$millar='1000';	
		$precioBolsa=($precioCotiz/$millar)*$trmCotiz;  
		return round($precioBolsa);
		//return number_format($precioBol, 2, ",", ".");   
		} 
		else if($medida=="PAQUETE"){
		return ($precioCotiz/$undPaquetes);
 	    }
		else if($medida=="KILOS"){
		return $precioCotiz;
 	    }
	}

function restarMes($fecha='' ,$meses){
	$dates = date('Y-m-d'); 
	$dates = $fecha=='' ? $dates : $fecha;
	$nuevafecha = date("Y-m-d",strtotime($fecha."- $meses month"));
	return $nuevafecha;
}


function ceros($numero){
	$numeroConCeros = str_pad($numero,11,"10000", STR_PAD_LEFT);//10000
	return $numeroConCeros+1;
}

/*function conversionCantidadMedida($cantidad,$medida){
    if($medida=='ROLLO'){
       $cantidad = $cantidad * 10000;
    }else{
       $cantidad = $cantidad; 
    }
    return $cantidad;
}*/



function eliminar_tildes($cadena){

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    $cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    ); 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena; 
}


function horaActual(){
	// Establecer la zona horaria para America/Bogota
	date_default_timezone_set('America/Bogota');

	// Obtener la hora actual
	$hora_actual = date('H:i:s');

	// Mostrar la hora actual en Bogotá, Colombia
	return $hora_actual;
}

function fechahoraActual(){
	// Establecer la zona horaria para America/Bogota
	date_default_timezone_set('America/Bogota');

	// Obtener la hora actual
	$hora_actual = date('Y-m-d H:i:s');

	// Mostrar la hora actual en Bogotá, Colombia
	return $hora_actual;
}

?>