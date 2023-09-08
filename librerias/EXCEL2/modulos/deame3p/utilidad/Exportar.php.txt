<?php
/**
 * Es una clase que asiste a la hoja Exportar.
 * Tiene funciones para facilitar el codigo.
 * @author		objetivoPHP
 * @link 		objetivophp@gmail.com
 * @copyright	2009 - ObjetivoPHP
 * @license		Free
 * @version 		1.0 (07/04/2008)
 * @since 			18/05/2008	=> Se comenzo el agregado de Formateo de Campos.
 * @version 		1.2	(05/09/2009) Pasaje de Conexion Mysqli para consultas a base de datos.
 */
class Exportar
{	
    /**
     * Alamacena solo los campos a exportar y elimina el resto.
     * @var 	array
     */
    private		$datosPOST		= array();
	
    /**
     * Contiene las columnas excel que deberan exportarse.
     * @var 	array
     */
    private		$columExport	= array();	
    
    /**
     * Contiene el nombre de la clave Primaria en caso de existir.
     * @var 	String
     */
    private		$clavePrimaria;
    
    /**
     * Contiene el nombre de la clave unica en caso de existir.
     * @var 	String
     */
    private 	$claveUnica;
    
    /**
     * Es el tipo de codificacion utilizada puede ser o nada o UTF8.
     * @var 	String
     */
    private 	$codificacion;
    
    /**
     * Contiene una conexion Mysqli para ser utilizada en las consultas.
     * @object	mysqli
     */
    private 	$mysqliConexion;
    
	/**
	 * No Hace nada
	 */
	public function __construct() {}
	
	/**
	 * Se configura una conexion mysqli.
	 * @param 	Object		$mysqli	Conexion mysqli.
	 * @return	void
	 */
	public function setConexionMysqli($mysqli)
	{	$this->mysqliConexion	= $mysqli;		}
	
	/**
	 * Carga solo los datos para los campos que va a exportar.
	 * Los ingresa en la variable $datosPOST para su posterior consulta.
	 * @param 	array	$_datos		es el valor $_POST del formulario procesar.
	 * @return  void	
	 */
	public function setCamposExportar($_datos,$codificar='')
	{   // Codificacion
		if($codificar=='UTF8')
		{	$this->codificacion	= 'UTF8';	}
		
		foreach ($_datos as $nombre => $valor) 
	    {    if(is_array($_datos[$nombre]))
             {   if($valor[0]!="###NO###")
                 {	$this->datosPOST[$nombre]	= $valor;
                 	//echo $valor[0]." == ".$valor[2]."<br />";
                 	$this->columExport[$valor[0]] = $valor[2];
                 	switch ($valor[8])
                 	{	case "PRI":	$this->clavePrimaria	= $nombre;
                 			break;
                 		case "UNI": $this->claveUnica		= $nombre; 
                 			break;
                 	} // Fin Switch
             	 } // Fin IF ###NO###	
            } // Fin IF array
	    } // Fin ForEach
	} 
	
	/**
	 * Se encarga de mostrar por pantalla las propiedades de los campos,
	 * que fueron seleccionados para ser ingresados desde excel.
	 */
    public function getPropiedadesCampos()
    {   foreach ($this->datosPOST as $nombre => $valor)
        {    foreach ($this->datosPOST[$nombre] as $clave => $valor)
            {    echo $clave." => ".$valor."<br>";  }
            echo "<hr>";        
        }
    }
	
  	/**
  	 * Nos informa si una columna debe ser exportada o no.
  	 * @param	Integer	$columna Numero de la columna.
  	 * @return 	String	Nombre de la columna en caso de ser afirmativo.
  	 * 					false en caso de no exportarse. 
  	 */
    public function exportoColum($columna)
    {	$valor	= $this->columExport[$columna];
    	return $valor;
	}

	/**
	 * Devuelve la primer parte de una sentencia INSERT.
	 * @param 	String	$tabla	Nombre de la tabla a realizar el insert.
	 * @return  String	Contiene el inicio de la sentencia INSERT.
	 */
    public function getInsertar($tabla)
    {	$exporto	= "";
    	foreach ($this->columExport as $campos)
    	{	$exporto= $exporto." ".$campos.",";	}
    	$exporto	= substr($exporto,0,strlen($exporto)-1);
    	$exporto	= "INSERT INTO ".$tabla." (".$exporto.") VALUES (";
    	return $exporto;   	
    }
    
  	/**
  	 * Retorna una clave que identifica de manera unica a un registro.
  	 * @return	String	contiene la clave en caso de tener la tabla clave.
  	 * 					Si tiene primaria se debuelve la primaria si no 
  	 * 					debuelve clave Unica.
  	 */
	public function getClave()
	{	if($this->clavePrimaria)
		return $this->clavePrimaria;
		
		if($this->claveUnica)
		return $this->claveUnica;
		
		return false;
	}
	
	/**
	 * Se encarga retornar el valor de la propiedad o propiedades de un campo MySQL.
	 * @param 	String	Campo del cual queremos la propiedad.
	 * @param 	String	Propiedad que queremos del Campo o null para que regrese
	 * 					todas las propiedades.
	 * @return 	String	Valor de la propiedad.
	 * @return 	Array	Valores de Propiedad.
	 */
	public function getPropiedadCampo($campo,$propiedad=false)
	{	//echo "<br>Campo :".$campo."<br>";
		if($propiedad)
		{	$propiedades	= $this->datosPOST[$campo][$propiedad];	}
		else 
		{	$propiedades	= $this->datosPOST[$campo];				}
		
		return $propiedades;
	}
	
	public function getDatosPost()
	{	return $this->datosPOST;	}
	
	/**
	 * Borra o Mantiene el archivo en el servidor.
	 * @param 	Integer	$modo 		0: Mantengo el archivo - 1: Borro el archivo.-
	 * @param 	String	$archivo	Nombre del archivo a procesar. 
	 */
	public function borrarArchivo($modo,$archivo)
	{	if($modo)
		{	$error	= unlink("planillas/".$archivo);	
			if($error)
			{	echo "<br /><b>Archivo borrado exitosamente.</b><br />";	}
			else
			{	echo "<br /><b>No se pudo borrar el Archivo del Servidor.</b><br />";	}	
		}
	}
	
	#########################################################
	# Formateo de Campos									#
	#########################################################
   /*
	0	=> Con que columna Excel se vincula	
	1	=> Con que tabla y campo se relaciona
	2	=> Nombre del Campo MySQL
	3	=> Tipo de campo
	4	=> Sin Signo
	5	=> Zero Fill
	6	=> Largo del Campo
	7	=> Nulo
	8	=> Clave
	9	=> Valor por Defecto
	10	=> extra
	11	=> Clave Foranea
	*/
	/**
	 * Se encarga de ver las propiedades de los campos y mandar los datos
	 * al metodo correcto para su formateo.
	 *
	 * @access 	public
	 * @param	String		$campo	Nombre del Campo
	 * @param 	mixed		$valor	Valor del Campo
	 * @return	mixed		Valor del Campo Formateado
	 */
  	public function formatearCampo($campo,$valor)
  	{	$funcion = $this->datosPOST[$campo][3];
  		// Veo si es un campo Autoincrement y si quiere que el llenado
  		// sea automatico o de Excel.
  		if($this->datosPOST[$campo][10]=="auto_increment")
  		{	if($this->datosPOST[$campo][1]==1)
  			{	$valor = "";	}
   		}
  		
  		// Si se relaciona con otro campo veo que es lo que trae
  		// para poner el valor correcto.
		if($this->datosPOST[$campo][1] && $this->datosPOST[$campo][10]!="auto_increment")
		{	$relacion	= explode(".",$this->datosPOST[$campo][1]);
			$consulta	= "SELECT $campo FROM $relacion[1] WHERE $relacion[0]='".$valor."'";
					
			$resultado	= $this->mysqliConexion->query($consulta);
			$linea		= $resultado->fetch_array();
			$valor		= $linea[$campo];
		}
		
		
		if(method_exists($this,$funcion))
  		{	$valor		=	$this->$funcion($campo,$valor);	}
  		else
  		{	echo "El Metodo: <b>".$funcion."</b> No existe. Se envio a un metodo
  				por defecto<br />";
  			$valor		= $this->defecto($valor);
  		}
  		return $valor;
  	}
	
  	/**
  	 * Funcion que se larga si el tipo de campo no tiene metodo para
  	 * su formateo. Solo se realizan operaciones basicas para que no de
  	 * error la insercion en MySQL.
  	 *
  	 * @access 	private
	 * @param	String		$campo	Nombre del Campo
	 * @param 	mixed		$valor	Valor del Campo
	 * @return	mixed		Valor del Campo Formateado
	 */
  	private function defecto($valor)
	{	$valor		= $this->utf8_latin($valor,$this->codificacion);
		return 		addslashes($valor);
	}

	#########################################################
	# Metodos para campos: FECHA-HORA						#
	#########################################################
	/**
	 * Formatea una cadena a tipo Date.
	 */
	public function date($campo,$valor)
	{	$tipo	= is_numeric($valor);
		switch ($tipo)
		{	case 0: // El campo no es numerico
					// formato dd/mm/aaaa con mes de 1o2 caracter.y año de 2a4
					$aFecha		= array();
					//echo $valor. ' - Texto <br />'; 
					// Antigua (^[0123][0-9]?).([0-1]?[0-9]).([0-9]{4})$
					if(ereg("^([0-1]?[0-9]).([0123][0-9]?).([0-9]{4})$",$valor,$aFecha))
					{	if(checkdate($aFecha[1],$aFecha[2],$aFecha[3]))
						{	//$campo	= date ("Y-m-d",(mktime(0, 0, 0, $aFecha[2], $aFecha[1], $aFecha[3])+(60*60*24)));
							$campo	= date ("Y-m-d",(mktime(0, 0, 0, $aFecha[1], $aFecha[2], $aFecha[3])));
						}
						else
						{	$fecha	= date ("Y-m-d",mktime());
							echo "Fecha:".$aFecha[0]." es incorrecta sera cambiada por: $fecha<br />";
							$campo	= $fecha;
						}
					}
					else
					{	// (^[0-9]{4})([-\/]{1})([0-1]?[0-9])([-\/]{1})([0123][0-9]?)$
						if(ereg("(^[0-9]{4}).([0-1]?[0-9]).([0123][0-9]?)$",$valor,$aFecha))
						{	if(checkdate($aFecha[2],$aFecha[3],$aFecha[1]))
							{	$campo	= date ("Y-m-d",(mktime(0, 0, 0, $aFecha[2], $aFecha[3], $aFecha[1])));		}		
							else
							{	echo "Fecha: ".$valor." No se pudo reconocer el formato.<br />";
								$campo		= "1000-01-01";
							}
						}
					}
					break;
			
			case 1: // El campo es numerico
					//echo $valor. ' - Numero <br />';
					if(ereg("^[1-3]?[0-9]{7}$", $valor))
					{	$anio 	= substr($valor,strlen($valor)-4);	
						$mes	= substr($valor,strlen($valor)-6,2);	
						$dia	= (strlen($valor)==7)? substr($valor,0,1) : substr($valor,0,2);
						//echo '<br />';
						//$campo	= date ("Y-m-d",(mktime(0, 0, 0, $mes, $dia, $anio)));
						if(checkdate($mes,$dia,$anio))
						{	$campo	= date ("Y-m-d",(mktime(0, 0, 0, $mes, $dia, $anio)));		}		
						else
						{	echo "Fecha: ".$valor." No se pudo reconocer el formato.<br />";
							$campo		= "1000-01-01";
						}
					}
					else
					{	// 5/08/2007 = 39299 Dia Testigo.
						$campo		= $valor - 39299;
						$campo	= date ("Y-m-d",(mktime(0, 0, 0, 8, 5, 2007)+($campo*60*60*24)));
					}
					break;
		}
	return $campo;	
	}
	
	/**
	 * Formatea una cadena a tipo DateTime de MySQL.-
	 */
	public function datetime($campo,$valor)
	{	//echo "Valor:".$valor."<br />";
		if(!is_numeric($valor))
		{	$explode	= explode(" ",$valor);
			$fecha		= $explode[0];	
			$hora		= $explode[1];
			$fecha		= explode("/",$fecha);
			$hora		= explode(":",$hora);
			//echo "MK:".mktime($hora[0],$hora[1],$hora[2],$fecha[1],$fecha[0],$fecha[2]);
			$campo		= gmdate("Y-m-d H:i:s", mktime($hora[0],$hora[1],$hora[2],$fecha[1],$fecha[0],$fecha[2]));
			
		}
		else
		{	$explode	= explode(".",$valor);
			$fecha		= $explode[0];	
			$hora		= "0.".$explode[1];
			$fecha		= $this->date($campo,$fecha);
			$hora		= $this->time($campo,$hora);
			$campo 		= $fecha." ".$hora;
		}
		//echo "DATETIME:".$campo."<br />";
		return $campo;
		
	}
	
	public function timestamp($campo,$valor)
	{	return $this->datetime($campo,$valor);	}
	
	
	public function time($campo,$tiempo)
	{	$testigo	= ($tiempo*24);
		$hora		= intval($testigo);
		$testigo	= (($testigo-$hora)*60);
		$minutos	= intval($testigo);
		$testigo	= ($testigo-$minutos)*60;
		$segundos	= intval($testigo);
		$campo 		= sprintf("%+02s:%+02s:%+02s",$hora,$minutos,$segundos);
		//echo "TIME:".$campo."<br />";
		return $campo;
	}
	
	public function year($campo,$anio)
	{	$propiedades	= $this->datosPOST[$campo];
		$largo			= $propiedades[6];
		$campo			= 0;
		$anio			= (int)$anio;
		switch ($largo)
		{	case 2:	if($anio>=0 && $anio<100)
					{	$campo	= $anio;	}	
					break;
			case 4: if($anio>1900 && $anio<2156)
					{	$campo	= $anio;	}
					break;
		}
		return $campo;
 	}
 	
	#########################################################
	# Metodos para campos: NUMERICOS ENTEROS				#
	#########################################################
 	/**
 	 * Formatea un campo a Entero de acuerdo a los parametros.
 	 *
 	 * @param Boolean	$sinSigno	contiene 1 si no tiene signo, 0 en caso contrario.
 	 * @param Integer	$minSS	Valor minimo que puede tomar un campo sin signo.
 	 * @param Integer	$minCS	Valor minimo que puede tomar un campo con signo.
 	 * @param Integer 	$maxSS	Valor maximo que puede tomar un campo sin signo.
 	 * @param Integer	$maxCS	Valor minimo que puede tomar un campo con signo.
 	 * @param Integer	$campo	Nombre del Campo al que se esta exportando.
 	 * @param Integer	$valor	Valor a formatear.
 	 * @param Integer	$defecto	Valor por defecto cuando el valor a importar esta fuera de rango.
 	 * @return Integer
 	 */
 	private function formatoNumerico($sinSigno,$minSS,$minCS,$maxSS,$maxCS,$campo,$valor,$defecto=0)
 	{	$valor			= intval($valor);
 		switch ($sinSigno)
 		{	case 1: // Es un campo sin signo va de 0 a 255
 					if($valor>$maxSS || $minSS<0)
 					{	echo	"Valor fuera de rango permitio para el Campo:<b>
 								$campo .-";
 								$valor	= $defecto;
 					}
 					break;
 			case 0:// Campo con signo va de -128 a 127	
 		 			if($valor>$maxCS || $valor<$minCS)
 					{	echo	"Valor fuera de rango permitio para el Campo:<b>
 								$campo .-";
 								$valor	= $defecto;
					}
 					break;
 		}
 		return $valor;
 	}

	public function tinyint($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-128,255,127,$campo,$valor);	}
	
	public function smallint($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-32768,65535,32767,$campo,$valor);	}
	
	public function mediumint($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-8388608,16777215,8388607,$campo,$valor);	}

	public function int($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-2147483648,4294967295,2147483647,$campo,$valor);	}
	
	public function bigint($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-9223372036854775808,18446744073709551615,9223372036854775807,$campo,$valor);	}
	
	public function bool($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-128,255,127,$campo,$valor);	}
	
	public function boolean($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,-128,255,127,$campo,$valor);	}
	
	public function bit($campo,$valor)
	{	return $this->formatoNumerico($this->datosPOST[$campo][4],0,0,1,1,$campo,$valor,1);	}

	#########################################################
	# Metodos para campos: NUMERICOS DECIMALES				#
	#########################################################

	public function float($campo,$valor)
	{	$propiedades	= $this->datosPOST[$campo];
		$caract			= explode(",",$propiedades[6]);

		if($caract[1]=="") {$caract[1]	= $caract[0];}
		if($caract[1]>23)
		{	$campo	= doubleval($valor);	}
		else
		{	$campo	= floatval($valor);		}
		
		return $campo;			
	}
	
	public function double($campo,$valor)
	{	$campo	= $campo;
		return	doubleval($valor); 
	}
	
	public function decimal($campo,$valor)
	{	$campo	= $campo;
		return	doubleval($valor); 
	}
	
	public function dec($campo,$valor)
	{	$campo	= $campo;
		return	doubleval($valor); 
	}
	
	public function numeric($campo,$valor)
	{	$campo	= $campo;
		return	doubleval($valor); 
	}
	
	#########################################################
	# Metodos para campos: CADENA DE CARACTERES				#
	#########################################################
	
	public function varchar($campo,$valor)
	{	$propiedades= $this->datosPOST[$campo];
	
		if(!$valor)
		{	$formateo	= $propiedades[9];
			return $formateo;
		}
		$formateo	= substr($valor,0,$propiedades[6]);
		$formateo	= $this->utf8_latin($formateo,$this->codificacion);
		$formateo	= addslashes($formateo);
		$formateo	= trim($formateo);
		return $formateo;
	}
	
	public function text($campo,$valor)
	{	$valor		= addslashes($valor);
		$valor		= $this->utf8_latin($valor,$this->codificacion);
		return 		$valor;
	}
	
	public function set($campo,$valor)
	{	$propiedades	= $this->datosPOST[$campo];
		$conjuntoSet	= $propiedades[6];
		if(strpos($conjuntoSet,$valor)!==false)
		{	$campo	= $valor;	}
		else
		{	echo "Valor no permitido para el campo: ".$campo."<br />";
			$campo	= "";
		}
		return $campo;
	}
	
	public function enum($campo,$valor)
	{	return $this->set($campo,$valor);	}
	
	public function utf8_latin($valor,$codificacion)
	{	if($codificacion=='UTF8')
		{	$valor	= utf8_encode($valor);	}
		else
		{	$valor	= utf8_decode($valor);	}
		return $valor;
	}
}